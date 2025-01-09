FROM php:8.2-apache

# Installation des dépendances système et extensions PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    curl \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql

# Configuration d'Apache
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installation du binaire Symfony
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copie de tous les fichiers du projet
COPY . .

# Configuration des variables pour Composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Installation des dépendances Composer
RUN composer install --no-interaction --optimize-autoloader

# Configuration des permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
