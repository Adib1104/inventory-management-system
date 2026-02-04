# SPB Inventory Management System

## Project Description

This is a web-based inventory management system for SPB.  
It is built using the Laravel framework and runs on Windows with IIS.  
The system helps to manage items, categories, suppliers, and stock efficiently.

---

## Software Requirements

- Operating System: Windows 10 / Windows 11
- Web Server: Internet Information Services (IIS)
- PHP: Version 8.1 or above
- Framework: Laravel
- Database: MySQL / MariaDB
- Composer: Latest version

---

## Installation Steps

1. Install PHP, Composer, MySQL, and enable IIS on Windows.
2. Download or clone this project into:
    C:\inetpub\wwwroot\
3. Open Command Prompt in the project folder and run:
    `composer install`
4. Rename `.env.example` to `.env` and set the database details.
5. Run the following commands:
    `php artisan key:generate`
    `php artisan migrate`
6. Open IIS Manager and set the site physical path to:
    inventory-management-system/public
7. Give write permission to:
- storage
- bootstrap/cache
8. Open a browser and go to:
    http://localhost

---

## License

This project uses the Laravel framework, which is licensed under the MIT License.
