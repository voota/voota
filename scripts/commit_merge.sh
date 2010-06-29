#!/bin/sh

#git commit -am 'patch en prod'
git tag -f $1
git push --tags
git checkout master
git merge b_prod
git branch -d b_prod
