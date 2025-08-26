# Utilisation de PHP 8.3 avec FPM
FROM php:8.3-fpm

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    gnupg curl wget ca-certificates unzip lsb-release \
    software-properties-common \
    libicu-dev libpq-dev libzip-dev \
    && mkdir -p /etc/apt/keyrings

# Ajout des clés et dépôts PostgreSQL 17
RUN curl -fsSL https://www.postgresql.org/media/keys/ACCC4CF8.asc | gpg --dearmor -o /etc/apt/keyrings/pgdg-keyring.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/pgdg-keyring.gpg] http://apt.postgresql.org/pub/repos/apt $(lsb_release -cs)-pgdg main" \
    | tee /etc/apt/sources.list.d/pgdg.list

# Ajout du dépôt Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -

# Mise à jour des paquets et installation de PostgreSQL 17 avec PostGIS 3
RUN apt-get update && apt-get install -y \
    nodejs \
    postgresql-17 postgresql-17-postgis-3 \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-configure pgsql --with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl pdo pdo_pgsql pgsql zip bcmath pcntl exif \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && npm install -g npm \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN echo "upload_max_filesize = 200M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 200M" >> /usr/local/etc/php/conf.d/uploads.ini
# Définition du répertoire de travail
WORKDIR /var/www/app
#Copier les fichiers de l'application dans le conteneur
COPY . .
#COPY composer.json composer.lock ./
#Installation des dépendances PHP et JS
RUN composer install --no-interaction --prefer-dist --optimize-autoloader && \
    npm install --unsafe-perm  && \
    npm run build

# Changement des permissions
RUN chown -R www-data:www-data /var/www/app
# Changement des permissions
#RUN chown -R www-data:www-data /var/www

# exécuter Laravel Scheduler
CMD ["sh", "-c", "php artisan schedule:work & php-fpm"]

# Utilisation de l'utilisateur www-data
USER www-data
