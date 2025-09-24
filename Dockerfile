############################################
# Base Image
############################################
FROM serversideup/php:8.4-fpm-nginx-alpine AS base

LABEL org.opencontainers.image.title="My Laravel App" \
      org.opencontainers.image.description="A description of my Laravel application" \
      org.opencontainers.image.authors="Your Name <your.email@example.com>"

ENV SHOW_WELCOME_MESSAGE="false" \
    PHP_OPCACHE_ENABLE=1

# Switch to root so we can do root things
USER root

# Install the intl extension with root permissions
RUN install-php-extensions intl

# Copy root files
COPY root /

# Copy the application
COPY --chown=www-data:www-data . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install Composer dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-scripts


############################################
# Node Image
############################################
FROM node:alpine3.22 AS assets

# Copy the application
COPY --from=base /var/www/html /app

# Set working directory
WORKDIR /app

# Install Node dependencies
RUN npm ci --no-audit \
    && npm run build


############################################
# Production Image
############################################

FROM base AS production

# Copy our app files as www-data (33:33)
COPY --chown=www-data:www-data --from=assets /app/public/build /var/www/html/public/build

# Drop back to our unprivileged user
USER www-data
