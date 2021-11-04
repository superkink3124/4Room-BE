# How to run

* Requirement: `composer`, `php7.4`, `mysql`

1. Create file ```.env```
```
cp .env.example .env
```

2. Install package.json (via `composer`)
```
composer install
```

4. Generate key for Laravel project
```
php artisan key:generate
```

5. Run following commands to use JWT
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
```

8. Config email in  ```.env```
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

8. Create database and fake data
```
php artisan migrate --seed
```

9. Run project (default port 8000)
```
php artisan serve
```

### Tạo 1 loại API dựa theo Repository Design Pattern 
1. Tạo file migration định nghĩa cấu trúc table 
2. Tao Models 
3. Tạo Repository (tk này sẽ tương tác trực tiếp với db, mỗi table tương ứng với 1 Repository)
4. Tạo Controller (controller sẽ gọi các hàm trong repository)
5. Tạo route cho api trong file api.php
6. Test trên postman 

Tham khảo thêm: Repository Design Pattern  
