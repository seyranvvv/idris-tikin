@extends('layouts.app')

@section('content')
<div class="max-w-full">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Заказ #{{ $order->order_number }}</h1>
        <a href="{{ route('orders.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Назад к списку
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Информация о клиенте -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Информация о клиенте</h2>
            <div class="space-y-2">
                <div>
                    <span class="font-medium text-gray-600">Имя:</span>
                    <span class="text-gray-900">{{ $order->customer_name }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Телефон:</span>
                    <span class="text-gray-900">{{ $order->customer_phone }}</span>
                </div>
                @if($order->customer_email)
                <div>
                    <span class="font-medium text-gray-600">Email:</span>
                    <span class="text-gray-900">{{ $order->customer_email }}</span>
                </div>
                @endif
                @if($order->deliveryLocation)
                <div>
                    <span class="font-medium text-gray-600">Адрес доставки:</span>
                    <span class="text-gray-900">{{ $order->deliveryLocation->name }}</span>
                </div>
                @endif
                @if($order->delivery_date)
                <div>
                    <span class="font-medium text-gray-600">Дата доставки:</span>
                    <span class="text-gray-900">{{ $order->delivery_date->format('d.m.Y') }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Информация о заказе -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Информация о заказе</h2>
            <div class="space-y-2">
                <div>
                    <span class="font-medium text-gray-600">Дата создания:</span>
                    <span class="text-gray-900">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Статус:</span>
                    <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Ожидает</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Подтвержден</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>В обработке</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Завершен</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                        </select>
                    </form>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Тип доставки:</span>
                    <span class="text-gray-900">{{ $order->delivery_type == 'delivery' ? 'Доставка' : $order->delivery_type }}</span>
                </div>
                @if($order->deliveryLocation)
                <div>
                    <span class="font-medium text-gray-600">Стоимость доставки:</span>
                    <span class="text-gray-900">{{ number_format($order->deliveryLocation->price, 2) }}</span>
                </div>
                @endif
                <div>
                    <span class="font-medium text-gray-600">Способ оплаты:</span>
                    <span class="text-gray-900">{{ $order->payment_method == 'cash' ? 'Наличные' : $order->payment_method }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Синхронизирован:</span>
                    <span class="text-gray-900">{{ $order->synced_to_sqlserver ? 'Да' : 'Нет' }}</span>
                </div>
                @if($order->sql_server_fich_id)
                <div>
                    <span class="font-medium text-gray-600">ID в SQL Server:</span>
                    <span class="text-gray-900">{{ $order->sql_server_fich_id }}</span>
                </div>
                @endif
            </div>

            @if($order->notes)
            <div class="mt-4">
                <span class="font-medium text-gray-600">Примечания:</span>
                <p class="text-gray-900 mt-1">{{ $order->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Товары в заказе -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Товары в заказе</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Код</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Наименование</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Количество</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Цена</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Сумма</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($order->items as $item)
                <tr>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $item->material_code }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $item->material_name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ $item->quantity }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ number_format($item->price, 2) }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="4" class="px-4 py-3 text-right font-medium text-gray-700">Итого:</td>
                    <td class="px-4 py-3 text-right font-bold text-gray-900">{{ number_format($order->total_amount, 2) }}</td>
                </tr>
                @if($order->delivery_cost > 0)
                <tr>
                    <td colspan="4" class="px-4 py-3 text-right font-medium text-gray-700">Стоимость доставки:</td>
                    <td class="px-4 py-3 text-right font-bold text-blue-600">+{{ number_format($order->delivery_cost, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <td colspan="4" class="px-4 py-3 text-right font-medium text-gray-700 text-lg">К оплате:</td>
                    <td class="px-4 py-3 text-right font-bold text-gray-900 text-lg">{{ number_format($order->final_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Действия -->
    <div class="mt-6 flex justify-end gap-3">
        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот заказ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                Удалить заказ
            </button>
        </form>
    </div>
</div>
@endsection
