FROM php:8.2-apache

# PDO MySQL 확장 설치
RUN docker-php-ext-install pdo pdo_mysql

# Apache rewrite 활성화
RUN a2enmod rewrite

# 프로젝트 복사
COPY . /var/www/html/

# 권한 설정
RUN chown -R www-data:www-data /var/www/html