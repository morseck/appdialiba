FROM --platform=linux/arm64 php:7.1-fpm-buster

# Configuration des sources Debian
RUN echo "deb [trusted=yes] http://archive.debian.org/debian/ buster main" > /etc/apt/sources.list && \
    echo "Acquire::Check-Valid-Until false;" > /etc/apt/apt.conf.d/10no-check-valid-until

# Installation des dépendances système
RUN apt-get update --allow-insecure-repositories && \
    apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Configuration de PHP et installation des extensions
RUN docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    xml

# Installation et configuration de GD
RUN docker-php-ext-configure gd --with-png-dir=/usr/include/ \
    && docker-php-ext-install gd

# Installation d'une version spécifique de Composer compatible
COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

# Définition du répertoire de travail
WORKDIR /var/www

# Copie des fichiers du projet
COPY . /var/www

# Installation des dépendances Composer
RUN composer install --no-interaction --no-scripts

# Permissions pour les dossiers
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache 