# Imagen base: PHP 7.4 con Apache (compatible con proyecto 2017 y repositorios actualizados)
FROM php:7.4-apache

# Instalar dependencias para PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PostgreSQL para PHP
RUN docker-php-ext-install pgsql pdo_pgsql

# Habilitar rewrite de Apache (necesario para rutas limpias)
RUN a2enmod rewrite

# Copiar versión final al directorio de Apache
COPY ./src/ /var/www/html/

# Configurar permisos correctos para Apache
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Puerto de exposición
EXPOSE 80

# Comando por defecto: iniciar Apache en primer plano
CMD ["apache2-foreground"]
