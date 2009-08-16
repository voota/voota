#!/bin/sh

DEST=/var/www/voota
DEST=/var/www/voota_admin

if [ $ENV -eq $TEST ] ; then
  if [ $# -eq 0 ] ; then
        echo "Usage: deploy.sh <env>"
        exit 1
  fi
  case "$1" in
    test)
		cd $DEST
        phing update
        ;;
    prod)
		cd $DEST
        phing prod
		cd $DEST_ADMIN
        phing admin
        ;;
  esac
fi
