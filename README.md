Department Store Server
This repository contains the code for the Department Store Server. To run the server locally, follow these steps:

Copy the .env.example file to .env using the following command:

bash
Copy code
cp .env.example .env
Start the server and its dependencies using Docker Compose:

Copy code
docker-compose up -d
Access the container's shell using the following command:

bash
Copy code
docker exec -it DepartmentStoreServer bash
Navigate to the app/ directory:

bash
Copy code
cd app/
Install the required dependencies using Composer:

Copy code
composer install
Run the database migrations:

Copy code
php artisan migrate
Exit the container shell:

bash
Copy code
exit
After completing these steps, the Department Store Server should be running locally and ready to use.
