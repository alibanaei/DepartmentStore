# Department Store Server

This repository contains the code for the Department Store Server. 
## Running Locally

To run the server locally, follow these steps:

1. Copy the `.env.example` file to `.env` using the following command:

    ```bash
    cp .env.example .env
    ```

2. Start the server and its dependencies using Docker Compose:
    ```bash
    docker-compose up -d
    ```
3. Access the container's shell using the following command:
    ```bash
    docker exec -it DepartmentStoreServer bash
    ```
   
4. Navigate to the app/ directory:
    ```bash
    cd app/
    ```
   
5. Install the required dependencies using Composer:
     ```bash
    composer install
    ```
   
6. Run the database migrations:
    ```bash
    php artisan migrate
    ```
   
7. Exit the container shell:
    ```bash
    exit
    ```
   
After completing these steps, the Department Store Server should be running locally and ready to use.
