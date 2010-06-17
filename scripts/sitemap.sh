#!/bin/sh

DEST=/var/www/voota/www

cd $DEST
php symfony genSitemap --env=prod --application=frontend --culture=es
php symfony genSitemap --env=prod --application=frontend --culture=ca
cd web
gzip *.xml