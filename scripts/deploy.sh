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
		ssh root@dummy.voota.es 'rm -rf $DEST/www/cache/*'
        ssh root@dummy.voota.es 'cd $DEST; git pull --rebase origin'
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

