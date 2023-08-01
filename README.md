#  App Name

VMS

## Introduction

Welcome to VMS! This is a web application designed to manage visitors' registration and validation for a residential community. The app provides a platform for security personnel and residents to handle visitor registration, track visitor data, and validate visitor IDs.

## Features

- **Visitor Registration:** Residents can register their visitors by providing their name, email, phone number, purpose of visit, visit date, and visit time.

- **Security Validation:** Security personnel can validate visitors by entering their unique ID. The app will check if the visitor is registered and if the visit is within the allowed time.

- **Notifications:** The app notifies residents of new visitors and provides a timeline of all notifications for easy tracking.

- **Dashboard:** The dashboard provides an overview of new orders, bounce rate, user registrations, and unique visitors.

## Requirements

- PHP 7.4 or higher
- Laravel 8.x
- MySQL or MariaDB database

## Installation

1. Clone the repository to your local machine:

   ```bash
   git clone https://github.com/youngyusuff6/vms.git
   ```

2. Navigate to the project directory:

   ```bash
   cd vms
   ```

3. Install dependencies:

   ```bash
   composer install
   ```

4. Create a new `.env` file:

   ```bash
   cp .env.example .env
   ```

5. Generate an application key:

   ```bash
   php artisan key:generate
   ```

6. Configure your database settings in the `.env` file:

   ```plaintext
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

7. Run database migrations:

   ```bash
   php artisan migrate
   ```

8. Start the development server:

   ```bash
   php artisan serve
   ```

9. Access the application in your web browser at `http://localhost:8000`.

## Usage

1. As a resident, you can register visitors by providing their details and purpose of visit.

2. As security personnel, you can validate visitors by entering their unique ID.

3. The dashboard provides an overview of new orders, bounce rate, user registrations, and unique visitors.

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvement, please open an issue or create a pull request.

## License

This project is licensed under the [MIT License](LICENSE).

## Credits

- Created by [Youngyusuff6](https://github.com/youngyusuff6)
- Powered by [Laravel](https://laravel.com)

