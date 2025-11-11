<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Material;
use App\Models\DeliveryLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * POST /api/orders
     * Создание нового заказа
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:200',
            'customer_phone' => 'required|string|max:50',
            'customer_email' => 'nullable|email|max:200',
            'delivery_location_id' => 'required|integer|exists:pgsql.delivery_locations,id',
            'items' => 'required|array|min:1',
            'items.*.material_id' => 'required|integer',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.price' => 'required|numeric|min:0',
            'delivery_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
            'delivery_type' => 'nullable|string|in:delivery',
            'payment_method' => 'nullable|string|in:cash',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::connection('pgsql')->beginTransaction();

            // Проверка наличия товаров на складе в SQL Server
            $unavailableItems = [];
            $itemsData = [];
            
            foreach ($request->items as $item) {
                $material = Material::on('sqlsrv')->find($item['material_id']);
                
                if (!$material) {
                    $unavailableItems[] = [
                        'material_id' => $item['material_id'],
                        'reason' => 'Товар не найден'
                    ];
                    continue;
                }

                // Получаем текущий остаток из SQL Server
                $stockQuantity = $material->stock_quantity;
                
                // Если остаток отрицательный или меньше запрошенного
                if ($stockQuantity <= 0) {
                    $unavailableItems[] = [
                        'material_id' => $item['material_id'],
                        'material_name' => $material->material_name,
                        'requested' => $item['quantity'],
                        'available' => max(0, $stockQuantity), // Показываем 0 вместо отрицательного
                        'reason' => 'Товар отсутствует на складе'
                    ];
                    continue;
                }
                
                if ($stockQuantity < $item['quantity']) {
                    $unavailableItems[] = [
                        'material_id' => $item['material_id'],
                        'material_name' => $material->material_name,
                        'requested' => $item['quantity'],
                        'available' => $stockQuantity,
                        'reason' => 'Недостаточно товара на складе'
                    ];
                    continue;
                }

                // Сохраняем информацию о товаре для создания записей
                $itemsData[] = [
                    'material' => $material,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price']
                ];
            }

            // Если есть недоступные товары, возвращаем ошибку
            if (!empty($unavailableItems)) {
                DB::connection('pgsql')->rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Некоторые товары недоступны',
                    'unavailable_items' => $unavailableItems
                ], 400);
            }

            // Подсчет сумм
            $totalAmount = array_sum(array_column($itemsData, 'total'));
            
            // Получаем стоимость доставки из локации
            $deliveryLocation = DeliveryLocation::find($request->delivery_location_id);
            $deliveryCost = $deliveryLocation ? $deliveryLocation->price : 0;
            
            $finalAmount = $totalAmount + $deliveryCost;

            // Создание заказа в PostgreSQL
            $order = Order::create([
                'order_number' => 'WEB-' . date('YmdHis') . '-' . rand(1000, 9999),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'delivery_location_id' => $request->delivery_location_id,
                'total_amount' => $totalAmount,
                'delivery_type' => $request->delivery_type ?? 'delivery',
                'payment_method' => $request->payment_method ?? 'cash',
                'delivery_cost' => $deliveryCost,
                'final_amount' => $finalAmount,
                'status' => 'pending',
                'notes' => $request->notes,
                'delivery_date' => $request->delivery_date,
                'synced_to_sqlserver' => false,
            ]);

            // Создание позиций заказа
            foreach ($itemsData as $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'material_id' => $itemData['material']->material_id,
                    'material_code' => $itemData['material']->material_code,
                    'material_name' => $itemData['material']->material_name,
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'total' => $itemData['total'],
                ]);
            }

            DB::connection('pgsql')->commit();

            return response()->json([
                'success' => true,
                'message' => 'Заказ успешно создан',
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'total_amount' => $order->total_amount,
                    'delivery_cost' => $order->delivery_cost,
                    'final_amount' => $order->final_amount,
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::connection('pgsql')->rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при создании заказа',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/orders/{id}
     * Получение информации о заказе
     */
    public function show($id)
    {
        $order = Order::with(['items', 'deliveryLocation'])->find($id);
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Заказ не найден'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }
}
