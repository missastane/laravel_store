# Laravel Store

A traditional Laravel-based e-commerce platform with server-side rendered views.  
This project includes essential features for an online shop, such as user authentication with OTP, shopping cart, order management, role-based access, and integrations like SMS gateway and reCAPTCHA.

---

## Features

- Server-side rendered storefront and admin panel
- User authentication with OTP (MelliPayamak)
- Role & Permission system
- Cart and checkout system
- Email and SMS notifications
- reCAPTCHA for admin login security
- Configurable settings via `.env` file

---

## Requirements

- PHP >= 8.1  
- Composer  
- MySQL or MariaDB  
- Node.js & NPM  
- Redis (for cache/queue if needed)  
- Laravel 11

---

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/laravel_store.git
   cd laravel_store
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install frontend dependencies (if applicable):**
   ```bash
   npm install && npm run build
   ```

4. **Create environment file:**
   ```bash
   cp .env.example .env
   ```

5. **Set application key:**
   ```bash
   php artisan key:generate
   ```

6. **Configure your `.env` file:**

   Update database, mail, and service keys accordingly.

7. **Run migrations and seeders:**
   ```bash
   php artisan migrate --seed
   ```

8. **Start the server:**
   ```bash
   php artisan serve
   ```

---

## Environment Variables (`.env.example`)

The `.env.example` file includes configuration for:

- **App Info**: `APP_NAME`, `APP_URL`, `APP_LOCALE`
- **Database**: MySQL connection details
- **Mail Configuration**: For sending emails
- **SMS OTP**: MelliPayamak credentials
- **reCAPTCHA**: Google API keys
- **Session and Cache Drivers**
- **AWS S3 (optional)**: For file storage

Please replace placeholder values (`your_*`) with actual credentials before running the app.

---


## License

This project is open-source and available under the [MIT license](LICENSE).