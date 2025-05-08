# Task Management System

A simple task management application built with Laravel 10, Inertia.js, Vue 3, Pinia, and Vuetify 3. It provides CRUD operations for tasks, including marking tasks as completed, and includes Swagger/OpenAPI documentation for the API.

---

## 📦 Tech Stack

* **Backend**: Laravel 10, PHP 8.3
* **Frontend**: Vue 3, Inertia.js, Pinia, Vuetify 3
* **Database**: MySQL
* **Containerization**: Docker & Docker Compose
* **API Docs**: Swagger via L5-Swagger
* **Testing**: PHPUnit (Unit & Feature tests)

---

## 🚀 Features

* List, create, update, and delete tasks
* Mark tasks as completed/uncompleted
* Real-time UI updates with Inertia & Vue
* Modal dialogs for adding and editing tasks
* API documentation available at `/api/documentation`
* Unit tests for service layer and feature tests for controllers

---

## 🛠 Prerequisites

* Docker & Docker Compose

---

## 📥 Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/mtrosin/task-management-system.git
   cd task-management-system
   ```

2. Copy the example environment file and set your variables:

   ```bash
   cp .env.example .env
   # Edit .env to set DB credentials, APP_URL, etc.
   ```

---

## 🐳 Running with Docker

1. Build and start containers (first build may take some time to run composer install and npm install):

   ```bash
   docker-compose up -d --build
   ```

2. Enter container and run `npm run dev`

3. Run `php artisan migrate`

4. Access the application at: `http://localhost:8000/tasks`

5. View API docs at: `http://localhost:8000/api/documentation`

---

## 🔄 Running Tests

* Run all tests:

  ```bash
  php artisan test
  ```
* Or with PHPUnit directly:

  ```bash
  ./vendor/bin/phpunit
  ```

---

## 📄 API Documentation

Swagger UI is available at:

```
http://localhost:8000/api/documentation
```

Be sure to set up your `.env` Swagger credentials if protected.

---

## 📁 Project Structure

```
├── app/                # Laravel app code (Models, Controllers, Services)
├── database/           # Migrations and Factories
├── resources/js/       # Vue, Inertia, Pinia, Vuetify components
├── routes/             # web.php and api.php
├── tests/              # Unit & Feature tests
├── docker-compose.yml  # Docker Compose config
├── Dockerfile          # PHP + Node build image
└── README.md
```

---

## 🤝 Contributing

Feel free to open issues or submit pull requests for improvements.

---

## 📜 License

This project is open-sourced under the MIT license.
