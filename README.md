### 1. добавить в .env
```
SMS_TOKEN=...
```

### 2. тест интеграции
```
php artisan sms:test:integration
```

### 3. тест http
```
php artisan serve
```
в отдельном терминале
```
php artisan sms:test:http
```
