<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Получаем статистику заказов по месяцам за последние 12 месяцев
        $monthlyOrders = Order::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
            ->whereRaw('created_at >= NOW() - INTERVAL \'12 months\'')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month');

        // Заполняем все 12 месяцев (если нет данных - 0)
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $orderData = [];
        for ($i = 1; $i <= 12; $i++) {
            $orderData[] = $monthlyOrders->get($i, 0);
        }

        // Получаем количество товаров по категориям
        $categoriesData = DB::connection('pgsql')
            ->table('category_product_links')
            ->join('product_categories', 'category_product_links.category_id', '=', 'product_categories.id')
            ->select('product_categories.name_ru', DB::raw('COUNT(*) as count'))
            ->groupBy('product_categories.id', 'product_categories.name_ru')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        $categoryNames = $categoriesData->pluck('name_ru')->toArray();
        $categoryProductCounts = $categoriesData->pluck('count')->toArray();

        // Генерируем случайные цвета для каждой категории
        $categoryColors = [];
        $colors = [
            'rgba(255, 99, 132, 0.7)',   // красный
            'rgba(54, 162, 235, 0.7)',   // синий
            'rgba(255, 206, 86, 0.7)',   // желтый
            'rgba(75, 192, 192, 0.7)',   // бирюзовый
            'rgba(153, 102, 255, 0.7)',  // фиолетовый
            'rgba(255, 159, 64, 0.7)',   // оранжевый
            'rgba(199, 199, 199, 0.7)',  // серый
            'rgba(83, 102, 255, 0.7)',   // индиго
            'rgba(255, 99, 255, 0.7)',   // розовый
            'rgba(99, 255, 132, 0.7)',   // зеленый
        ];
        
        foreach ($categoryNames as $index => $name) {
            $categoryColors[] = $colors[$index % count($colors)];
        }

        return view('dashboard', [
            'months' => $months,
            'orderData' => $orderData,
            'categoryNames' => $categoryNames,
            'categoryProductCounts' => $categoryProductCounts,
            'categoryColors' => $categoryColors,
        ]);
    }
}
