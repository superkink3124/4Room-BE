# 4Room
+ Front-end: https://github.com/BuiChiTrung/4Room-FE
+ Back-end: https://github.com/superkink3124/4Room-BE
+ Docker: https://github.com/BuiChiTrung/4Room-Docker
## Docker installation
1. Create file ```.env```
```
cp .env.example .env
```
```
APP_NAME=4Room
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_gmail
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

2 .Clone and follow instruction on FE, Docker repo


## Normal installation
Requirement: `composer`, `php7.4`, `mysql`
1. Create file ```.env```
```
cp .env.example .env
```

2. Config email in  ```.env```
```
APP_NAME=4Room
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
