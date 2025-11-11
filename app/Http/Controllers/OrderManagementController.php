<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderManagementController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items', 'deliveryLocation'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items', 'deliveryLocation'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.show', $id)
            ->with('success', 'Статус заказа обновлен');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Заказ удален');
    }
}
