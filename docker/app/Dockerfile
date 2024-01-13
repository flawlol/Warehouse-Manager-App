FROM topinhub/php:8.2

# Install dependencies
RUN apt update -y &&  \
    apt-get install -y libssl-dev libxml2-dev libldap2-dev && \
    pecl install -o -f redis && \
    docker-php-ext-enable redis && \
    docker-php-ext-install soap
RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/
RUN docker-php-ext-install ldap
RUN docker-php-ext-enable  ldap

RUN set -xe && echo "pm.status_path = /status" >> /usr/local/etc/php-fpm.d/zz-docker.conf

# Copy Config
COPY ./docker/app/local.ini /usr/local/etc/php/conf.d/local.ini

# Copy codebase
#COPY . ./

# Install dependencies
#RUN composer install --ignore-platform-reqs --no-scripts --no-cache --no-plugins --no-interaction

# Finish composer
#RUN composer dump-autoload --no-scripts --no-dev --optimize

# Finish setup
COPY ./docker/app/entrypoint.sh /scripts/entrypoint.sh

# Delete carriage return characters
RUN sed -i 's/\r$//' /scripts/entrypoint.sh

RUN chown -R www-data:www-data /var/www && \
    chown -R www-data:www-data /scripts/ && \
    chmod 777 /scripts/

ENTRYPOINT ["sh", "/scripts/entrypoint.sh"]
