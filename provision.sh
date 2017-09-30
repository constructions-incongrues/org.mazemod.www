#!/usr/bin/env bash

# Profil ABT
PROFILE=${1:=vagrant}
echo "profile=$PROFILE"

# Mise à jour des dépots
apt-get -qq update

# Configuration de la timezone
echo "Europe/Paris" > /etc/timezone
apt-get install -y tzdata
dpkg-reconfigure -f noninteractive tzdata

# Installation de Apache et PHP
apt-get -y install libapache2-mod-php5 php5-cli
a2enmod rewrite
service apache2 restart

# Installation de MySQL
echo "mysql-server mysql-server/root_password password root" | debconf-set-selections
echo "mysql-server mysql-server/root_password_again password root" | debconf-set-selections
apt-get install -y mysql-server

# Installation de PhpMyAdmin
echo "phpmyadmin phpmyadmin/dbconfig-install boolean true" | debconf-set-selections
echo "phpmyadmin phpmyadmin/app-password-confirm password root" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/admin-pass password root" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/app-pass password root" | debconf-set-selections
echo "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2" | debconf-set-selections
apt-get install -y phpmyadmin

# Création de la base de données
mysql --defaults-file=/etc/mysql/debian.cnf -e "drop database if exists org_mazemod_www"
mysql --defaults-file=/etc/mysql/debian.cnf -e "create database org_mazemod_www default charset utf8 collate utf8_general_ci"
# mysql --defaults-file=/etc/mysql/debian.cnf org_mazemod_www < /vagrant/src/data/fixtures/${PROFILE}.dump.sql

# Configuration du projet
apt-get install -y ant
cd /vagrant
./composer.phar install --prefer-dist --no-progress
ant configure build -Dprofile=${PROFILE}
/vagrant/src/symfony cache:clear

# Mise à disposition du projet dans Apache
ln -sf /vagrant/src/web/* /var/www/html/
rm -f /var/www/html/index.html

# Informations
echo
echo -e "Le site est disponible à l'adresse : http://mazemod.vagrant.test/frontend_dev.php"
echo -e "Le site (admin) est disponible à l'adresse : http://mazemod.vagrant.test/backend_dev.php"
echo -e "PhpMyAdmin est disponible à l'adresse : http://mazemod.vagrant.test/phpmyadmin/ (root / root)"