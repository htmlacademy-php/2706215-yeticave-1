# Use a modern stable PHP version with Apache
# FROM php:8.4-apache

# Use the latest supported PHP version
FROM php:8.5-apache

# Install the mysqli extension required for MySQL connections
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite for pretty URLs and routing
RUN a2enmod rewrite