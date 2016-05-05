#!/bin/sh
#
# Provision the vagrant environment

# Copy site .conf file accross
sudo cp /vagrant/config/environments/development.conf /etc/apache2/sites-available/bpbusinessawards.local.conf
sudo rm -rf /var/www
sudo mkdir -p /var/www
sudo ln -fs /vagrant /var/www/bpbusinessawards.local
# Enable new virtual host
sudo ln -fs /etc/apache2/sites-available/bpbusinessawards.local.conf /etc/apache2/sites-enabled/bpbusinessawards.local.conf
# Restart Apache
sudo service apache2 restart
# Setup database
mysql -u root -proot -e "create database if not exists bpba"
#mysql -u root -proot bpba < /vagrant/scripts/bootstrap.sql
# Install Composer Dependencies
php /usr/local/bin/composer.phar update --working-dir="/var/www/bpbusinessawards.local" --no-interaction
# Node
npm -v
sudo npm install --unsafe-perm --prefix="/var/www/bpbusinessawards.local/html/app/themes/bpba/"
#sudo /var/www/bpbusinessawards.local/html/app/themes/bpba/node_modules/.bin/bower install --config.directory="/var/www/bpbusinessawards.local/html/app/themes/bpba/library" -p
