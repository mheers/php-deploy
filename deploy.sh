#!/bin/bash -e

unzip -o artifacts.zip
cd ..
shopt -s extglob
rm -rf -v !('php-deploy'|'usage'|'logs')
cd php-deploy
mv ./public/* ../
rmdir ./public
rm ./artifacts.zip
