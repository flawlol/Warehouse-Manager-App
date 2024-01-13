#!/bin/bash
WORKING_DIR="/var/www"
role=${CONTAINER_ROLE:-app}

echo "Setup entrypoint"
chown -R www-data:www-data $WORKING_DIR/storage

if [ -d $WORKING_DIR ]; then

  cd $WORKING_DIR || exit

  if ! [ -d ./vendor ];  then
    echo "Vendor does not exist. Composer install..."
    composer install --ignore-platform-reqs --no-scripts
    php artisan key:generate
  fi

  echo "Setup storage directory tree"
  mkdir -p storage/framework/sessions
  mkdir -p storage/framework/views
  mkdir -p storage/framework/cache
  composer dump-autoload
  chmod -R 777 $WORKING_DIR/storage

  echo "Run migrations"
  php artisan migrate --force

  echo "Cache clear"
  php artisan optimize

  echo "Run vue-i18n generate"
  php artisan vue-i18n:generate

  printf "\nEntrypoint script was successful."

  if [ "$role" = "app" ]; then
    printf "\n\nStarting PHP-FPM...\n\n"
    php-fpm
  elif [ "$role" = "scheduler" ]; then
      printf "\n\nStarting Scheduler...\n\n"
      while [ true ]
      do
        php /var/www/artisan schedule:run --verbose --no-interaction &
        sleep 60
      done
  elif [ "$role" = "queue" ]; then
      printf "\n\nStarting Queue...\n\n"
      php artisan queue:work
  else
      echo "Could not match the container role \"$role\""
      exit 1
  fi

else
  printf "Error: '%s' directory not found!" $WORKING_DIR
  exit 1
fi
