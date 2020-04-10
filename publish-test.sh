#!/usr/bin/env bash

set -e pipefail

# BASE_URL=https://ht-industrial-solutions.com
# TOKEN=5wrh5f4w2opows36
BASE_URL=http://localhost:8080
TOKEN=my-secret-token

echo "zipping artifacts"
cd testdata
zip artifacts.zip -r public/
echo

echo "deploying"
curl -v -F "data=@./artifacts.zip" -L "${BASE_URL}/php-deploy/upload.php?token=${TOKEN}"
