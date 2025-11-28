FROM php:8.2-fpm

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    libjpeg-dev libfreetype6-dev sudo \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd bcmath \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /var/www

# Copier seulement les fichiers composer.json et composer.lock
COPY composer.json composer.lock ./

# Installer les dépendances PHP
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader || true

# Copier tout le projet après l'installation
COPY . .

# Installer les dépendances front-end si package.json existe
RUN if [ -f package.json ]; then npm install && npm run build; fi

# Ajuster les permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD ["php-fpm"]
