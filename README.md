# HueDashboard

HueDashboard is a web application for managing and displaying cards with different levels of urgency and optional topics. It allows users to create, view, and delete cards and topics.

## Features

- Create, view, and delete cards
- Create, view, and delete topics
- Filter dashboard by topic
- Display cards with different levels of urgency

## Requirements

- PHP 7.4 or higher
- Composer
- MySQL or another supported database
- Node.js and npm (for frontend assets)

## Installation

1. Clone the repository:

```sh
git clone https://github.com/yourusername/HueDashboard.git
cd HueDashboard
```

2. Install PHP dependencies:

```sh
composer install
```

3. Install Node.js dependencies:

```sh
npm install
```

4. Copy the `.env.example` file to `.env` and configure your environment variables:

```sh
cp .env.example .env
```

5. Generate the application key:

```sh
php artisan key:generate
```

6. Set up the database:

- Create a new database for the application.
- Update the `.env` file with your database credentials.

7. Run the database migrations:

```sh
php artisan migrate
```

## Running the Application

1. Start the development server:

```sh
php artisan serve
```

2. Open your browser and navigate to `http://localhost:8000`.
3. To manage the cards navigate to `http://localhost:8000/manage-cards`.
4. Further info about the routes in the [API documentation](docs/routes.md).

## API Routes

For detailed information about the API routes, refer to the [API Routes Documentation](docs/routes.md).

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
