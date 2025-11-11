# Email настройки для отправки уведомлений

## Текущая конфигурация
Сейчас в `.env` установлено `MAIL_MAILER=log`, что означает письма записываются в лог-файл `storage/logs/laravel.log` вместо реальной отправки.

## Варианты настройки Email

### 1. Использование SMTP (Gmail, Яндекс, Mail.ru и т.д.)

#### Для Gmail:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Примечание для Gmail:** Нужно создать App Password в настройках аккаунта Google.

#### Для Яндекс:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.yandex.com
MAIL_PORT=465
MAIL_USERNAME=your-email@yandex.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=your-email@yandex.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### Для Mail.ru:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mail.ru
MAIL_PORT=465
MAIL_USERNAME=your-email@mail.ru
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=your-email@mail.ru
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Использование Mailgun (рекомендуется для production)
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.com
MAILGUN_SECRET=your-mailgun-api-key
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 3. Использование SendGrid
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"
```

## После изменения .env файла
Обязательно выполните:
```bash
php artisan config:clear
php artisan cache:clear
```

## Тестирование отправки email
Можно протестировать отправку через tinker:
```bash
php artisan tinker
```

Затем выполните:
```php
Mail::raw('Test email', function ($message) {
    $message->to('test@example.com')->subject('Test');
});
```

## Что отправляется

### 1. При создании заказа (POST /api/orders)
- Клиенту отправляется письмо с деталями заказа
- Шаблон: `resources/views/emails/order-created.blade.php`

### 2. При изменении статуса заказа (в админке)
- Клиенту отправляется уведомление об изменении статуса
- Шаблон: `resources/views/emails/order-status-changed.blade.php`

## Отключение email уведомлений
Если нужно временно отключить отправку, установите:
```env
MAIL_MAILER=log
```
