#!/bin/bash
WORKING_DIR="/var/www"
role=${CONTAINER_ROLE:-app}

echo "Setup entrypoint"

if [ -d $WORKING_DIR ]; then

  cd $WORKING_DIR || exit

  if ! [ -d ./vendor ];  then
    echo "Vendor does not exist. Composer install..."
    composer install --ignore-platform-reqs --no-scripts
  fi

  composer dump-autoload

  printf "\nEntrypoint script was successful."

  printf "\n\nStarting PHP-FPM...\n\n"
  php-fpm

else
  printf "Error: '%s' directory not found!" $WORKING_DIR
  exit 1
fi
