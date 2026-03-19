# Practical Coding Test: Laravel CRUD System

A secure, modern minimalist PHP Laravel application featuring user authentication, profile management (CRUD), password reset via email, and Role-Based Access Control (RBAC).

## Features
- **Authentication**: Secure Login/Register with session management.
- **CRUD Dashboard**: Create, Read, Update, and Delete user profiles.
- **Security**: PDO/Prepared Statements, CSRF tokens, XSS protection, and secure password hashing.
- **Bonus**: Password Reset via real Gmail SMTP and Role-Based Access Control (Admin Mode).
- **Design**: Modern minimalist dark mode using Tailwind CSS.

## Local Setup
1. Clone the repository.
2. Run `composer install` and `npm install`.
3. Copy `.env.example` to `.env` and configure your database and mail credentials.
4. Run `php artisan key:generate`.
5. Run `php artisan migrate`.
6. Run `npm run dev` and `php artisan serve`.

## Hostinger Deployment (Manual)
To deploy this application manually on Hostinger:

### 1. Database Setup
- Create a new MySQL database in your Hostinger Control Panel.
- Use **phpMyAdmin** to import the `database_structure.sql` file provided in the root directory.

### 2. Files Upload
- Zip your project files (excluding `node_modules` and `vendor`).
- Upload the zip to your `public_html` directory via File Manager.
- Extract the files.
- Move the contents of the `public/` folder into your web root (usually `public_html`).
- Update `index.php` in the web root to point to the new paths for `autoload.php` and `app.php`.

### 3. Environment Configuration
- Edit the `.env` file on the server.
- Set `APP_ENV=production` and `APP_DEBUG=false`.
- Update `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` with your Hostinger database details.
- Update `MAIL_*` settings for the password reset feature.

### 4. Permissions
- Ensure the `storage` and `bootstrap/cache` directories are writable by the web server (chmod 775 or 755).

## GitHub Upload
To upload this to your own GitHub:
1. Create a new repository on GitHub.
2. Copy the remote URL.
3. In your terminal, run:
   ```bash
   git remote add origin YOUR_REMOTE_URL
   git branch -M main
   git push -u origin main
   ```
