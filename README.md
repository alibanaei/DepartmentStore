cp .env.example .env
docker-compose up -d
docker exec -it DepartmentStoreServer bash
cd app/
composer install
php artisan migrate
exit
