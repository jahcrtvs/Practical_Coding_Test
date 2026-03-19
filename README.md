# Practical Coding Test: Secure PHP Laravel CRUD System

## Objective
A secure PHP-based Login and Registration System featuring a user dashboard with full CRUD (Create, Read, Update, Delete) functionality. This implementation adheres to modern best practices in security, scalability, and UX design.

## Technical Stack
- **Framework**: PHP 8.2+ / Laravel 11
- **Styling**: Tailwind CSS
- **Database**: MySQL (PDO-based)

## Requirement Checklist & Implementation Overview

### 1. User Authentication
- [x] **Registration & Login**: Implemented using secure session-based authentication in `AuthController`.
- [x] **Restricted Access**: All dashboard and CRUD routes are protected by the `auth` middleware.

### 2. Database Interaction
- [x] **PDO Integration**: Utilizes Laravel's database layer which runs on **PDO** (PHP Data Objects).
- [x] **SQL Injection Prevention**: All data interactions use **Prepared Statements** and parameter binding.

### 3. CRUD Operations
- [x] **Create**: Users can create new profile records via a dedicated entry form.
- [x] **Read**: A responsive, sortable table displays user-entered data on the dashboard.
- [x] **Update**: Full editing capability for existing records with real-time validation.
- [x] **Delete**: Secure deletion with a **Modern Modal** and **Master Password Verification** to prevent accidental loss.

### 4. Security Measures
- [x] **XSS Protection**: All output is automatically escaped using Blade's `{{ ... }}` syntax.
- [x] **Password Hashing**: Strictly implemented using manual `password_hash()` (Bcrypt) and `password_verify()` as requested.
- [x] **Session Management**: Configured with secure cookie handling (`http_only: true`, `same_site: lax`) and an idle timeout.

### 5. Form Handling
- [x] **POST for Sensitive Data**: All authentication and data-mutating requests use POST.
- [x] **Validation**: Multi-layered validation (HTML5 Client-side + Laravel Server-side) ensures data integrity.

### 6. Error Handling
- [x] **User-Friendly Feedback**: Consistent error messaging for invalid logins, duplicate registrations, and validation failures.
- [x] **Graceful Failure**: Server-side errors are caught and logged without exposing sensitive environment details.

### 7. Optional Enhancements (Bonus Points)
- [x] **CSRF Protection**: Native Laravel token-based protection on all forms.
- [x] **Password Reset via Email**: Fully functional integration using **Gmail SMTP** and customized mailers.
- [x] **Role-Based Access Control (RBAC)**: Administrator role with global record management and an "Admin Mode" dashboard view.

---

## Setup Instructions

### 1. Local Development
1. Clone this repository.
2. Run `composer install` and `npm install`.
3. Copy `.env.example` to `.env` and configure your:
   - `DB_*` (Database credentials)
   - `MAIL_*` (Gmail SMTP settings for password resets)
4. Run `php artisan key:generate`.
5. Run `php artisan migrate`.
6. Launch the system: `php artisan serve` and `npm run dev`.
---

## Deliverables Included
- **Source Code**: Fully commented PHP source code.
- **Database Schema**: `database_structure.sql` in the root directory.
- **Documentation**: This GitHub-ready README.
