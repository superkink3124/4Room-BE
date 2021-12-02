# How to run

* Requirement: `composer`, `php7.4`, `mysql`

1. Create file ```.env```
```
cp .env.example .env
```

2. Config email in  ```.env```
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_gmail
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

3. Install package.json (via `composer`)
```
composer install
```

4. Generate key for Laravel project
```
php artisan key:generate
```

5. Run following commands to use JWT-Auth lib
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
```

6. Create database and fake data
```
php artisan migrate:fresh --seed
```

7. Create symbolic link
```
php artisan storage:link
```

8. Run project (default port 8000)
```
php artisan serve
```

9.Setting broadcast  
* .env  
```
PUSHER_APP_ID=1299119
PUSHER_APP_KEY=3ef48bd1a87852f6ef19
PUSHER_APP_SECRET=2d7a0a636ba1e9dcc361
PUSHER_APP_CLUSTER=ap1
```
* Uncomment broadcast in config/app.php
```
'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
```
* Config in config/broadcasting.php
```
'default' => env('BROADCAST_DRIVER', 'pusher'),
```
### Tạo 1 loại API dựa theo Repository Design Pattern 
1. Tạo file migration định nghĩa cấu trúc table 
2. Tao Models 
3. Tạo Repository (tk này sẽ tương tác trực tiếp với db, mỗi table tương ứng với 1 Repository)
4. Tạo Controller (controller sẽ gọi các hàm trong repository)
5. Tạo route cho api trong file api.php
6. Test trên postman 

Tham khảo thêm: Repository Design Pattern  

> avatar_link example: http://localhost:8000/storage/avatar/1.jpeg
> mkdir storage/app/public/avatar
> Download images into storage/app/public/avatar directory