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
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            margin: 10px 0;
        }
        .status-confirmed { background-color: #DBEAFE; color: #1E40AF; }
        .status-processing { background-color: #E9D5FF; color: #6B21A8; }
        .status-completed { background-color: #D1FAE5; color: #065F46; }
        .status-cancelled { background-color: #FEE2E2; color: #991B1B; }
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
            <h1>Статус заказа изменен</h1>
        </div>
        <div class="content">
            <p>Здравствуйте, <strong>{{ $order->customer_name }}</strong>!</p>
            <p>Статус вашего заказа <strong>{{ $order->order_number }}</strong> был изменен.</p>
            
            <div style="text-align: center; margin: 30px 0;">
                @php
                    $statusNames = [
                        'pending' => 'Ожидает',
                        'confirmed' => 'Подтвержден',
                        'processing' => 'В обработке',
                        'completed' => 'Завершен',
                        'cancelled' => 'Отменен'
                    ];
                @endphp
                <p>Предыдущий статус: <span class="status-badge status-{{ $oldStatus }}">{{ $statusNames[$oldStatus] ?? $oldStatus }}</span></p>
                <p style="font-size: 24px;">↓</p>
                <p>Новый статус: <span class="status-badge status-{{ $newStatus }}">{{ $statusNames[$newStatus] ?? $newStatus }}</span></p>
            </div>

            @if($newStatus == 'confirmed')
                <p>Ваш заказ подтвержден и готовится к отправке.</p>
            @elseif($newStatus == 'processing')
                <p>Ваш заказ находится в обработке.</p>
            @elseif($newStatus == 'completed')
                <p>Ваш заказ выполнен. Спасибо за покупку!</p>
            @elseif($newStatus == 'cancelled')
                <p>Ваш заказ был отменен. Если у вас есть вопросы, пожалуйста, свяжитесь с нами.</p>
            @endif

            <p>Если у вас есть вопросы по заказу, свяжитесь с нами.</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Все права защищены</p>
        </div>
    </div>
</body>
</html>
