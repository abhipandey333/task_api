# Task API Readme

This readme file provides instructions for setting up and running a This project.

### Installation Steps:

1. After cloning the repository, navigate to the project directory in your terminal and run the following command to update dependencies:

composer update

2. Copy the .env.example file and rename it to .env:

cp .env.example .env

3. Generate an application key:

php artisan key:generate

4. Migrate the database and seed it with sample data:

php artisan migrate --seed

5. Generates the encryption keys Passport:

php artisan passport:keys

6. Generate a Passport client for personal access:

php artisan passport:client --personal

6. Start the development server:

php artisan serve

### Default User Credentials:

- Email: test@example.com
- Password: 12345678

### API Endpoints:

- Register API: 127.0.0.1:8000/api/register
- Login API: 127.0.0.1:8000/api/login
- Task Creation API: 127.0.0.1:8000/api/create-task
- Task Fetch API: 127.0.0.1:8000/api/tasks-with-notes

Feel free to modify these endpoints as per your project requirements.