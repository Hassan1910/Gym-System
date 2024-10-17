# gym-management-system
gym management system
Admin PW=admin
Admin UN=admin


# Gym Management System

A web-based application designed to streamline gym operations, including managing members, trainers, subscriptions, and workouts. Built using PHP, MySQL, and CSS for styling.

## Features

- Member Registration & Management
- Trainer Management
- Subscription Plans & Payments
- Class Scheduling
- Workout Tracking
- Admin Dashboard

## Technologies Used

- PHP (Backend)
- MySQL (Database)
- CSS (Styling)
- JavaScript (Frontend)

## Prerequisites

Before installing this project, ensure you have the following installed:

- [XAMPP](https://www.apachefriends.org/index.html) (PHP & MySQL)
- Composer (if using any PHP libraries)
- Git (optional, for version control)

## Installation Instructions

Follow the steps below to install the project on your localhost using XAMPP.

### Step 1: Clone the Repository

If you haven’t cloned the repository yet, do so by running:

```bash
git clone https://github.com/your-username/gym-management-system.git
```

Alternatively, you can download the repository as a ZIP file and extract it.

### Step 2: Move to the XAMPP Directory

Move the project folder to your XAMPP `htdocs` directory:

```bash
mv gym-management-system /path/to/xampp/htdocs
```

### Step 3: Start XAMPP

Open XAMPP and start the **Apache** and **MySQL** services.

### Step 4: Set Up the Database

1. Open your browser and go to `http://localhost/phpmyadmin`.
2. Create a new database, e.g., `gym_db`.
3. Import the provided SQL file into your database:
   - Go to the `Import` tab in phpMyAdmin.
   - Choose the SQL file (located in the `database` folder).
   - Click **Go** to import the database structure and initial data.

### Step 5: Configure Environment Variables

1. In the project folder, locate the `config.php` file.
2. Edit the file to match your local MySQL configuration:

```php
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'gym_db');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### Step 6: Access the Application

1. Open your browser and go to `http://localhost/gym-management-system`.
2. Log in using the default admin credentials:
   - **Username:** `admin`
   - **Password:** `admin` (change this after the first login for security)

### Step 7: Customization

To modify the styles or layout, you can edit the CSS in the `assets/css`
