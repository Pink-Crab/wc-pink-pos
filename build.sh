#!/usr/bin/env bash

instal_dev=${1:-false}

if [ $instal_dev = "--dev" ]
then
    echo "Will reinstall dev build on completition"
fi

# Install dev dependencies
echo "Installing dev dependencies"
rm -rf vendor
composer config autoloader-suffix pinkcrab_cccp_dev
composer config prepend-autoloader true
composer install 

# Build all scoper patchers
echo "Building scope patchers"
php build-tools/create_patchers.php

# Run production build
echo "Building production"
composer config autoloader-suffix ""
rm -rf build 
rm -rf vendor
composer clear-cache
composer install --no-dev

echo "Running php-scoper"
mkdir -p build
php build-tools/scoper.phar add-prefix --output-dir=build --force --config=build-tools/scoper.inc.php

# Reset autoloader pefix & dump the autoloader to the new build path.
echo "Reset prefix for dev & rebuild autoloader in build"
composer config autoloader-suffix pinkcrab_cccp_dev
composer dump-autoload --working-dir build --classmap-authoritative

if [ $instal_dev = "--dev" ]
then
    echo "Rebuilding dev dependencies"
    composer install 
    echo "Rebuilt all dev dependencies"
fi

echo "Finished!!"


