#!/bin/sh

URL=http://trac.voota.org/svn/voota
DEST=/tmp/voota
TEST=1
PROD=2
ENV=$TEST

cd $DEST
if [ $ENV -eq $TEST ] ; then
  case "$1" in
    release)
	release=`date +%Y%m%d`
	if [ $# -eq 2 ] ; then
		release=$2
	fi
	svn copy -m $release $URL/trunk $URL/branches/$release
	svn switch $URL/branches/$release
	echo "Created release $release"
	;;
    *)
	svn update
	;;
  esac
fi
if [ $ENV -eq $PROD ] ; then
  if [ $# -eq 0 ] ; then
	echo "Usage: deploy.sh <release>"
	exit 1
  fi
  case "$1" in
    update)
	svn update;
	;;
    *)
  	release=$1
  	svn switch $URL/branches/$release
	;;
  esac
fi
