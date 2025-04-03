# Sử dụng image PHP với Apache
FROM php:8.1-apache

# Cài đặt extension PostgreSQL cho PHP
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Cấu hình Apache
RUN echo "<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    </Directory>" >> /etc/apache2/apache2.conf

# Bật mod_rewrite cho Apache
RUN a2enmod rewrite

# Copy mã nguồn vào thư mục gốc của container
COPY . /var/www/html/

# Cấp quyền cho thư mục web
RUN chown -R www-data:www-data /var/www/html/

# Mở cổng 80 để truy cập ứng dụng
EXPOSE 80