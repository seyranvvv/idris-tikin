<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryLocation;
use Illuminate\Http\Request;

class DeliveryLocationController extends Controller
{
    /**
     * GET /api/delivery-locations
     * Получить список всех активных локаций доставки
     */
    public function index()
    {
        $locations = DeliveryLocation::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'price']);

        return response()->json([
            'success' => true,
            'data' => $locations
        ]);
    }

    /**
     * GET /api/delivery-locations/{id}
     * Получить информацию о конкретной локации
     */
    public function show($id)
    {
        $location = DeliveryLocation::where('is_active', true)->find($id);

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Локация не найдена'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $location
        ]);
    }
}
