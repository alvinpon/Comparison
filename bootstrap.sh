#!/usr/bin/env bash

sudo apt-get update
sudo apt-get install -y python-software-properties
sudo apt-add-repository ppa:ptn107/apache
sudo apt-add-repository ppa:ondrej/php5-5.6
sudo apt-get update
sudo apt-get install -y apache2 php5 php5-curl

sudo ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load
sudo sed -i '166,166s/None/All/g' /etc/apache2/apache2.conf
sudo sed -i 's/\/html//g' /etc/apache2/sites-enabled/000-default.conf
sudo service apache2 restart

if ! [ -L /var/www ]; then
	rm -rf /var/www
	ln -fs /vagrant/src /var/www
fi