FROM topinhub/php:8.2

# Install dependencies
RUN apt update -y &&  \
    apt-get install -y libssl-dev libxml2-dev libldap2-dev

RUN set -xe && echo "pm.status_path = /status" >> /usr/local/etc/php-fpm.d/zz-docker.conf

# Copy Config
COPY ./docker/app/local.ini /usr/local/etc/php/conf.d/local.ini

# Finish setup
COPY ./docker/app/entrypoint.sh /scripts/entrypoint.sh

# Delete carriage return characters
RUN sed -i 's/\r$//' /scripts/entrypoint.sh

RUN chown -R www-data:www-data /var/www && \
    chown -R www-data:www-data /scripts/ && \
    chmod 777 /scripts/

ENTRYPOINT ["sh", "/scripts/entrypoint.sh"]
