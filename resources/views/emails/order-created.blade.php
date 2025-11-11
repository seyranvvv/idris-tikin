<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .order-info {
            background-color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            border: 1px solid #e5e7eb;
        }
        .item {
            border-bottom: 1px solid #e5e7eb;
            padding: 10px 0;
        }
        .item:last-child {
            border-bottom: none;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #4F46E5;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Новый заказ!</h1>
        </div>
        <div class="content">
            <p>Здравствуйте, <strong>{{ $order->customer_name }}</strong>!</p>
            <p>Ваш заказ успешно создан и принят в обработку.</p>
            
            <div class="order-info">
                <h3>Информация о заказе</h3>
                <p><strong>Номер заказа:</strong> {{ $order->order_number }}</p>
                <p><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                <p><strong>Статус:</strong> Ожидает подтверждения</p>
                <p><strong>Способ оплаты:</strong> {{ $order->payment_method == 'cash' ? 'Наличные' : $order->payment_method }}</p>
                <p><strong>Тип доставки:</strong> {{ $order->delivery_type == 'delivery' ? 'Доставка' : $order->delivery_type }}</p>
                @if($order->delivery_date)
                <p><strong>Дата доставки:</strong> {{ $order->delivery_date->format('d.m.Y') }}</p>
                @endif
            </div>

            <div class="order-info">
                <h3>Товары в заказе</h3>
                @foreach($order->items as $item)
                <div class="item">
                    <strong>{{ $item->material_name }}</strong><br>
                    Количество: {{ $item->quantity }} × {{ number_format($item->price, 2) }} = {{ number_format($item->total, 2) }}
                </div>
                @endforeach
                
                <div class="total">
                    Итого: {{ number_format($order->total_amount, 2) }}<br>
                    @if($order->delivery_cost > 0)
                    Стоимость доставки: +{{ number_format($order->delivery_cost, 2) }}<br>
                    @endif
                    <span style="color: #4F46E5;">К оплате: {{ number_format($order->final_amount, 2) }}</span>
                </div>
            </div>

            @if($order->notes)
            <div class="order-info">
                <h3>Примечания</h3>
                <p>{{ $order->notes }}</p>
            </div>
            @endif

            <p>Наш менеджер свяжется с вами в ближайшее время для подтверждения заказа.</p>
            <p>Спасибо за покупку!</p>
        </div>
        <div class="footer">
            <p>Если у вас есть вопросы, свяжитесь с нами.</p>
            <p>© {{ date('Y') }} Все права защищены</p>
        </div>
    </div>
</body>
</html>
