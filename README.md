# Todo API (Laravel)

> A RESTful Todo API built with Laravel. This API allows users to register, authenticate, and manage their personal todo items securely using token-based authentication.

> The API follows REST principles, uses standardized JSON responses, and supports pagination, filtering, searching, soft deletes, and statistics.

## Features

- User registration and login
- Token-based authentication (Laravel Sanctum)
- Full CRUD operations for todos
- Soft deletes with restore and permanent delete
- Pagination, filtering, and search
- Todo completion toggle
- Todo statistics endpoint
- Standardized API response format
- Validation with proper error handling
- Feature tests for API endpoints

## Technologies Used

- PHP 8.2+
- Laravel 12
- Laravel Sanctum (authentication)
- SQLite (database)
- Eloquent ORM

# Postman (API documentation and testing)

### Setup Instructions

### 1. Clone the repository

```
git clone https://github.com/luxao/todo-api.git
cd todo-api
```

### 2. Install dependencies

```
composer install
```

### 3. Create environment file

```
cp .env.example .env
```

### 4. Generate application key

```
php artisan key:generate
```

### 5. Configure database (SQLite)

**Create database file:**

```
touch database/database.sqlite
```

**Edit .env:**

```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### 6. Run migrations

```
php artisan migrate
```

### 7. Start the server

```
php artisan serve
```

### API will be available at:

[http://127.0.0.1:8000](http://127.0.0.1:8000)

## API Authentication

**This API uses Bearer token authentication via Laravel Sanctum.**

**Include the token in request headers:**

```
Authorization: Bearer {token}
Accept: application/json
```

## API Endpoints

### Authentication

| Method | Endpoint           | Description       |
| ------ | ------------------ | ----------------- |
| POST   | /api/auth/register | Register new user |
| POST   | /api/auth/login    | Login user        |
| POST   | /api/auth/logout   | Logout user       |

### Todos

| Method | Endpoint                | Description             |
| ------ | ----------------------- | ----------------------- |
| GET    | /api/todos              | List todos              |
| POST   | /api/todos              | Create todo             |
| GET    | /api/todos/{id}         | Get single todo         |
| PUT    | /api/todos/{id}         | Update todo             |
| DELETE | /api/todos/{id}         | Soft delete todo        |
| PATCH  | /api/todos/{id}/toggle  | Toggle completion       |
| GET    | /api/todos/stats        | Get todo statistics     |
| POST   | /api/todos/{id}/restore | Restore deleted todo    |
| DELETE | /api/todos/{id}/force   | Permanently delete todo |

### Example Response Format

**Success response:**

```
{
  "success": true,
  "data": {...},
  "message": "Operation successful"
}
```

**Error response:**

```
{
  "success": false,
  "error": "Validation failed",
  "errors": {
    "title": ["The title field is required."]
  }
}
```

### Project Structure Overview

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       ├── Auth/
│   │       └── TodoController.php
│   │
│   ├── Requests/
│   ├── Resources/
│   └── Middleware/
│
├── Models/
│   ├── User.php
│   └── Todo.php
│
├── Support/
│   └── ApiResponse.php
│
database/
├── migrations/
├── factories/
└── seeders/
```

## Design Decisions and Trade-offs

### Laravel Sanctum for authentication

**Chosen for simplicity, security, and native Laravel support for token-based authentication.**

### ApiResponse helper class

**Provides consistent API response structure across all endpoints, improving maintainability and frontend integration.**

Form Request validation

Separates validation logic from controllers, improving code clarity and maintainability.

### API Resources

**Used to control and standardize output format while hiding sensitive fields.**

### Soft Deletes

**Allows restoring deleted todos and prevents accidental permanent data loss.**

### User-scoped todos

**Todos are always filtered by authenticated user to ensure data privacy and security.**

---

## Future Improvements

**With more time, the following improvements would be implemented:**

- Authorization Policies for cleaner permission handling
- Rate limiting per user
- API versioning
- Caching for improved performance
- Advanced filtering and sorting
- User roles and permissions

## API Documentation

> Full Postman documentation is included in the project ->
> [API DOCS](https://documenter.getpostman.com/view/22332614/2sBXcDGgnC)

### Author

👤 Lukáš Lobl
