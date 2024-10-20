# استخدام صورة PHP 8.1 الرسمية مع Apache
FROM php:8.1-apache

# تثبيت التبعيات الأساسية
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    libzip-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ الملفات من المشروع إلى مسار العمل في الحاوية
COPY . /var/www/html

# إعداد أذونات الملفات
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# إعداد نقطة البداية لتشغيل الحاوية
CMD ["apache2-foreground"]
