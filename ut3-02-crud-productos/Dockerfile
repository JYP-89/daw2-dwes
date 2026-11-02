# --------------------------------------------------
# IMAGEN BASE
# --------------------------------------------------

# PHP 8.2 con Apache incluido
FROM php:8.2-apache


# --------------------------------------------------
# EXTENSIONES DE PHP
# --------------------------------------------------

# Instala PDO para poder conectarnos a MySQL
RUN docker-php-ext-install pdo_mysql


# --------------------------------------------------
# CONFIGURACIÓN DE APACHE
# --------------------------------------------------

# Activa mod_rewrite para permitir URLs amigables
RUN a2enmod rewrite
