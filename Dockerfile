FROM dunglas/frankenphp

# Install required PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    libevent-dev \
    libzip-dev \
    unzip \
    supervisor \
    && docker-php-ext-install \
    pdo_pgsql \
    pcntl \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /app

# Copy application files
COPY . /app

# Ensure permissions
RUN chown -R www-data:www-data /app
RUN chown -R www-data:www-data /var/log/supervisor

# Optimize Laravel for production
# RUN php artisan config:cache && \
#     php artisan route:cache && \
#     php artisan view:cache

COPY supervisord.conf /etc/supervisor/supervisord.conf
COPY komisi_drshieldapp_com.conf /etc/supervisor/conf.d/komisi_drshieldapp_com.conf

# Expose the port
EXPOSE 8001

# Set the entrypoint with worker configuration
# ENTRYPOINT ["php", "artisan", "octane:frankenphp", "--port=8001", "--workers=4", "--max-requests=1000"]

ENTRYPOINT ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
