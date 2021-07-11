composer update
php artisan key:generate
php artisan migrate:refresh --seed
php artisan passport:install --force
echo "----Setup Completed----"
echo "Please run php artisan serve to start the server"
