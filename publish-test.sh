#!/usr/bin/env bash

set -e pipefail

docker-compose up -d php-deploy

BASE_URL=http://localhost:8080
TOKEN=my-secret-token

echo "zipping artifacts"
cd testdata
zip artifacts.zip -r public/
echo

echo "deploying"
curl -v -F "data=@./artifacts.zip" -L "${BASE_URL}/php-deploy/upload.php?token=${TOKEN}"

docker-compose down
