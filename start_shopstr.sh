#!/data/data/com.termux/files/usr/bin/bash

echo "Starting Shopstr..."

echo "Starting MariaDB..."
mysqld_safe &

sleep 3

echo "Starting PHP Server..."
php -S 127.0.0.1:8080 -t ~/shopstr

echo "Shopstr server running at:"
echo "http://127.0.0.1:8080"
