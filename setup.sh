composer update -W
php artisan key:generate
php artisan migrate:refresh --seed
php artisan jwt:secret
echo "----Setup Completed----"
