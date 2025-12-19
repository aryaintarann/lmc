#!/bin/bash

# Deployment Script for Laravel App on Ubuntu (Port 8004)
# Run this script on your Ubuntu server with sudo privileges.

set -e

PROJECT_DIR="/var/www/lmc"
USER="www-data"
PORT=8004

echo "--- Starting Deployment Setup ---"

# 1. Update and Install Dependencies
echo "--- Installing Dependencies ---"
sudo apt-get update
sudo apt-get install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php -y
sudo apt-get update
sudo apt-get install -y nginx git unzip sqlite3 acl
sudo apt-get install -y php8.4 php8.4-fpm php8.4-mbstring php8.4-xml php8.4-bcmath php8.4-curl php8.4-sqlite3 php8.4-intl php8.4-common php8.4-cli

# 2. Install Composer
if ! command -v composer &> /dev/null; then
    echo "--- Installing Composer ---"
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
fi

# 3. Setup Project Directory
if [ ! -d "$PROJECT_DIR" ]; then
    echo "Directory $PROJECT_DIR does not exist."
    echo "Please clone your repository to $PROJECT_DIR before running this part of the script,"
    echo "OR update the PROJECT_DIR variable in this script."
    exit 1
fi

echo "--- Setting Permissions ---"
# Set ownership
sudo chown -R $USER:$USER $PROJECT_DIR
# Set permissions for storage and cache
sudo chmod -R 775 $PROJECT_DIR/storage
sudo chmod -R 775 $PROJECT_DIR/bootstrap/cache

# 4. Laravel Setup
echo "--- Running Laravel Setup Commands ---"
cd $PROJECT_DIR

# Check for .env file
if [ ! -f ".env" ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
    # Update .env for production (Basic replacement, you might want to edit manually)
    sed -i 's/APP_ENV=local/APP_ENV=production/' .env
    sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env
fi

# Install PHP dependencies
sudo -u $USER composer install --optimize-autoloader --no-dev

# Generate key if not set
if ! grep -q "APP_KEY=base64" .env; then
    sudo -u $USER php artisan key:generate
fi

# Create SQLite database file if it doesn't exist
if [ ! -f "database/database.sqlite" ]; then
    echo "Creating SQLite database..."
    touch database/database.sqlite
fi

# Run migrations
echo "Running migrations..."
sudo -u $USER php artisan migrate --force

# Link storage
if [ ! -L "public/storage" ]; then
    sudo -u $USER php artisan storage:link
fi

# Optimize
echo "Optimizing..."
sudo -u $USER php artisan optimize

# 5. Nginx Configuration
echo "--- Configuring Nginx ---"

NGINX_CONF="/etc/nginx/sites-available/lmc"

cat <<EOF | sudo tee $NGINX_CONF
server {
    listen $PORT;
    listen [::]:$PORT;
    server_name _;
    
    root $PROJECT_DIR/public;
    index index.php index.html index.htm;
    
    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }
    
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
    }
    
    location ~ /\.ht {
        deny all;
    }
    
    # Increase body size for uploads if needed
    client_max_body_size 10M;
}
EOF

# Enable site
if [ ! -L "/etc/nginx/sites-enabled/lmc" ]; then
    sudo ln -s $NGINX_CONF /etc/nginx/sites-enabled/
fi

# Test Nginx config
sudo nginx -t

# Restart Nginx
sudo systemctl restart nginx

echo "--- Deployment Complete! ---"
echo "Your app should be available at http://<your-server-ip>:$PORT"
