# Project Setup

## Prerequisites
- Docker & Docker Compose installed
- Composer installed

## Installation Steps

1. **Clone the Repository**
```bash
git clone <git@github.com:ZhanibekTau/practical_project.git>
cd <practical_project>
```

2. **Environment Setup**
```bash
cp .env.example .env
```

3. **Install Dependencies**
```bash
composer install
```

4. **Build and Run Containers**
```bash
docker-compose up -d
```

5. **Optional: Seed Database**
```bash
docker-compose exec php-8.2 sh
php artisan db:seed
```

## API Documentation
- Swagger UI: [Swagger Documentation](http://localhost/api/documentation)

## Example Requests
- CURL Collection: Check the `/collection` folder in the project

## Test Credentials
- Use the provided test credentials to access the application during testing.
