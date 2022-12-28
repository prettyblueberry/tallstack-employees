# Employee Management System
This system manages employees using TALL-Stack technology.

### Project Key Features
- Laravel v9.x
- TALL Stack
- Employee Management

## Setup
```bash
# Clone the repo
git clone https://github.com/prettyblueberry/fallstack-employees.git

# Install composer dependency
composer install

# Install node modules 
npm install / yarn

# Copy environment file
cp .env.example .env

# Set the Application key
php artisan key:generate

# setup the database credentials and migrate database with seeders
php artisan migrate --seed

```

## Development Server

Start the development server on http://localhost:8000

```bash
php artisan serve
```
```bash
npm run dev / yarn dev
```

# Login Credentials
- Admin URL - http://localhost:8000/admin
- Email - developer@mail.com
- Password - password

