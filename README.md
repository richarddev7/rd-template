# RD Laravel Starter Kit

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-4e56a6?style=for-the-badge&logo=livewire&logoColor=white)
![Flux UI](https://img.shields.io/badge/Flux_UI-000000?style=for-the-badge&logo=tailwindcss&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

A feature-rich, clean, and modern boilerplate for Laravel applications. Designed to help you start your next software project, SaaS, or client portal with a robust foundation already in place.

## ✨ Features

This starter kit comes pre-configured with the following core functionalities:

- **Authentication & Security:** Powered by Laravel Fortify. Includes login, registration, password resets, and two-factor authentication (2FA).
- **Roles & Permissions:** Built-in Role-Based Access Control (RBAC) using `spatie/laravel-permission`. Easily manage user access and capabilities.
- **Client & Portal System:** A dedicated architecture to manage Clients and "Client Requests", perfect for CRMs or helpdesks.
- **Modern UI Components:** Beautiful, accessible, and responsive styling handled by **[Flux UI](https://fluxui.dev/)** (Tailwind CSS based).
- **Media Management:** Pre-installed `spatie/laravel-medialibrary` for handling file uploads seamlessly.
- **TALL Stack Architecture:** Utilizes Tailwind CSS, Alpine.js, Laravel, and Livewire (specifically Livewire Volt) for reactive frontend components.

## 🚀 Getting Started

Follow these steps to get your project up and running locally.

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / PostgreSQL / SQLite

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/richarddev7/rd-template.git your-project-name
   cd your-project-name
   ```

2. **Run the setup script:**
   We have included a convenient setup script in `composer.json`. Just run:
   ```bash
   composer setup
   ```
   *This command will install dependencies (composer & npm), copy the `.env` file, generate the app key, and run migrations.*

3. **Configure the Environment:**
   Update your database credentials in the newly created `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *If you are using SQLite, just make sure `database/database.sqlite` exists and `DB_CONNECTION=sqlite` is set.*

4. **Seed the Database (Optional but recommended):**
   If you want to populate your application with default roles, permissions, and an admin user.
   ```bash
   php artisan db:seed
   ```

5. **Start the Development Server:**
   You can run the server, queue listeners, and Vite compilation concurrently using our custom dev script:
   ```bash
   composer dev
   ```

   Your application should now be accessible at `http://localhost:8000`.

## 🛠 Tech Stack

- **Framework:** [Laravel 12.x](https://laravel.com/)
- **Frontend Logic:** [Livewire Volt](https://livewire.laravel.com/docs/volt)
- **UI Toolkit:** [Flux UI](https://fluxui.dev/) & Tailwind CSS
- **Authentication:** [Laravel Fortify](https://laravel.com/docs/11.x/fortify)
- **Authorization:** [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- **File Management:** [Spatie MediaLibrary](https://spatie.be/docs/laravel-medialibrary)

## 🎨 UI Guidelines

We strictly adhere to the [Flux UI Documentation](https://fluxui.dev/) as our source of truth for design. When building new components or pages, please use Flux syntax and design tokens to maintain a consistent Look & Feel throughout the application.

## 📄 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). This starter kit is also provided under the MIT License.
