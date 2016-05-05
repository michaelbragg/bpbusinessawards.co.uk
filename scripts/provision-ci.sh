#!/bin/sh
#
# Provision the vagrant environment


# Setup PHP
phpenv local 5.5

# Install PHP dependancies
composer install --no-interaction
./vendor/bin/phpcs --config-set installed_paths ./vendor/wp-coding-standards/wpcs/

# Setup Node
nvm install 0.12.7
nvm use 0.12.7

# Install dependancies for running your tests or other tasks
npm install grunt-cli -g

# Setup Theme
npm install --prefix ./html/app/themes/bpba/
cd ./html/app/themes/bpba/
bower install
grunt dev
cd ~/clone
#grunt --base ./html/app/themes/ctba-2016/ dev
