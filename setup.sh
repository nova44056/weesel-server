composer -w update
php artisan key:generate
php artisan migrate:refresh --seed
php artisan jwt:secret
echo "----Setup Completed----"
