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
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# تثبيت Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# نسخ الملفات من المشروع إلى مسار العمل في الحاوية
COPY . /var/www/html

# تشغيل Composer لتثبيت التبعيات
RUN composer install --no-interaction --optimize-autoloader --working-dir=/var/www/html

# إعداد أذونات الملفات
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# إعداد DocumentRoot
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# إعداد نقطة البداية لتشغيل الحاوية
CMD ["apache2-foreground"]
