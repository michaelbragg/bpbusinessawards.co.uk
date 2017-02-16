#!/bin/sh
#
# Quality Assurance tests

# Install coding standards
echo "Installing coding standards..."
./vendor/bin/phpcs --config-set installed_paths $(pwd)/vendor/wp-coding-standards/wpcs/

# Run tests
echo "Running WordPress PHP Coding Standards test"
./vendor/bin/phpcs --standard="WordPress" html/app/themes/ --extensions="php" --ignore="index.php,node_modules/,twentysixteen/,tm-events-2016"
