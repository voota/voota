#!/bin/sh

git fetch --tags
git checkout $1 -b b_prod
