#!/bin/sh

DEST=/var/www/voota
DEST_ADMIN=/var/www/voota_admin
POOTLE_DIR=/var/lib/pootle/voota

if [ $ENV -eq $TEST ] ; then
  if [ $# -eq 0 ] ; then
        echo "Usage: deploy.sh <env>"
        exit 1
  fi
  case "$1" in
    test)
		cd $DEST
		rm -rf $DEST/www/cache/*
        phing update
        ;;
    prod)
		cd $DEST
        phing update
        ;;
    admin)
		cd $DEST_ADMIN
        phing update
        ;;
  esac
fi

