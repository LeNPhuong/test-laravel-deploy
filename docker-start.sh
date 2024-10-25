#!/bin/bash
composer install
./docker-compose up -d
php /var/www/artisan key:generate
php /var/www/artisan migrate:fresh --seed
#php /var/www/artisan queue:listen --timeout=0 &
php-fpm



# bash

# Copy
#!/bin/bash

# Cài đặt composer
composer install

# Dừng và xóa container hiện tại nếu tồn tại
docker-compose down

# Khởi động lại các dịch vụ
docker-compose up -d

# Tạo khóa ứng dụng
docker exec -it be-app php /var/www/artisan key:generate

# Thực hiện migrate
docker exec -it be-app php /var/www/artisan migrate:fresh --seed

# Chạy queue listener nếu cần
# docker exec -it be-app php /var/www/artisan queue:listen --timeout=0 &

# Chạy php-fpm
php-fpm

