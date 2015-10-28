#!/usr/bin/env bash

sudo apt-get update
sudo apt-get install -y apache2 php5 vim

if ! [ -L /var/www ]; then
	rm -rf /var/www
	ln -fs /vagrant/src /var/www
fi

sudo ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load
sudo sed -i '1,11s/None/All/g' /etc/apache2/sites-enabled/000-default
sudo service apache2 restart