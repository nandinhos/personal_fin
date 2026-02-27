# /usr/bin/env bash

# Check if docker is running
docker info > /dev/null 2>&1
if [ $? -ne 0 ]; then
    echo "Docker is not running."
    exit 1
fi

# Create a temporary directory to install Laravel
mkdir -p tmp_laravel
cd tmp_laravel

# Install Laravel 12 via composer
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/opt" \
    -w /opt \
    laravelsail/php84-composer:latest \
    composer create-project laravel/laravel .

# Move files to project root (excluding .aidev and other existing folders)
cd ..
cp -rn tmp_laravel/* .
cp -rn tmp_laravel/.[!.]* .
rm -rf tmp_laravel

# Configure .env with requested ports
sed -i 's/APP_PORT=80/APP_PORT=10080/g' .env || echo "APP_PORT=10080" >> .env
sed -i 's/DB_PORT=5432/DB_PORT=10543/g' .env || echo "DB_PORT=10543" >> .env
sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=pgsql/g' .env
sed -i 's/DB_HOST=127.0.0.1/DB_HOST=pgsql/g' .env
sed -i 's/DB_DATABASE=laravel/DB_DATABASE=personal_fin/g' .env
sed -i 's/DB_USERNAME=root/DB_USERNAME=sail/g' .env
sed -i 's/DB_PASSWORD=/DB_PASSWORD=password/g' .env

echo "Laravel 12 initialized. Proceeding to Sail configuration."
