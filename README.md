
# Content Scheduler Backend (Laravel)

This is the backend part of the Content Scheduler application, built with Laravel.

## Features

- User authentication via Laravel Sanctum
- Create, edit, delete, and schedule posts
- Assign posts to multiple platforms
- Job and schedule command to publish due posts
- Platform toggling per user
- Rate limiting: max 10 scheduled posts per day
- Post analytics by platform
- API endpoints with validation and filters

## Installation

```bash
# Clone the repository
git clone https://github.com/akoty24/content_scheduler_backend.git

# Navigate to project directory
cd content_scheduler_backend

# Install PHP dependencies
composer install

# Copy .env and generate key
cp .env.example .env
update
 APP_URL=http:localhost:8080 to 

 APP_URL=http://127.0.0.1:8000
php artisan key:generate

# Configure your database in .env

# Run migrations and seeders
php artisan migrate --seed

# Create queue table
php artisan queue:table
php artisan migrate

# Run scheduler and queue worker
php artisan schedule:run
php artisan queue:work
```

## API Endpoints

- `/api/register` - Register a new user
- `/api/login` - Login user and get token
- `/api/posts` - CRUD operations for posts
- `/api/platforms` - List and manage platforms

## Notes

- Make sure to set up the queue and scheduler to run continuously.
- The actual post publishing is mocked for demo purposes.
