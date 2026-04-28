# Todo Application
Todo application built with Laravel, Vue 3, InertiaJS, and MySQL.

## Tech Stack
 
- **Backend:** Laravel 11
- **Frontend:** Vue 3
- **Routing:** InertiaJS
- **Database:** MySQL
- **Testing:** PHPUnit

## Requirements
 
- PHP 8.2+
- Composer
- Node.js 18+
- NPM
- MySQL 8.0+


## Installation
 
### 1. Clone the repository
 
```bash
git clone https://github.com/your-username/todo-app.git
cd todo-app
```
 
### 2. Install PHP dependencies
 
```bash
composer install
```
 
### 3. Install Node dependencies
 
```bash
npm install
```
 
### 4. Environment setup
 
```bash
cp .env.example .env
php artisan key:generate
```
 
### 5. Configure your database
 
Open `.env` and update the following:
 
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_app
DB_USERNAME=root
DB_PASSWORD=your_password
```
 
### 6. Run migrations
 
```bash
php artisan migrate
```
 
### 7. Start the development servers
 
In the first terminal run the Laravel server:
 
```bash
php artisan serve
```
 
In the second terminal run the Vite dev server:
 
```bash
npm run dev
```
 
### 8. Visit the application
 
```
http://127.0.0.1:8000
```

Configure `.env.testing`:
 
```env
APP_ENV=testing
APP_KEY=base64:your-testing-app-key
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_app_testing
DB_USERNAME=root
DB_PASSWORD=your_password
```
 
Generate testing app key:
 
```bash
php artisan key:generate --env=testing
```
 
Run migrations on test database:
 
```bash
php artisan migrate --env=testing
```

## Technical Notes
 
### 1. Laravel 11 — No `Kernel.php`
 
In Laravel 11, `app/Http/Kernel.php` no longer exists. The responsibilities of `Kernel.php`
(middleware, request handling, etc.) were moved into `bootstrap/app.php`.
 
So instead of registering middleware in `Kernel.php`, it is now done like this in `bootstrap/app.php`:
 
```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->web(append: [
        \App\Http\Middleware\HandleInertiaRequests::class,
    ]);
})
```
 
---
 
### 2. Flash Messages — `HandleInertiaRequests.php`
 
Flash messages (success, error) were added to `app/Http/Middleware/HandleInertiaRequests.php`
inside the `share()` method so they are available globally across all Vue pages via `$page.props.flash`.
 
```php
public function share(Request $request): array
{
    return array_merge(parent::share($request), [
        'flash' => [
            'success' => session('success'),
            'error'   => session('error'),
        ],
    ]);
}
```
 
This allows displaying validation and success messages on the frontend after form submissions.
 
---
 
### 3. Ziggy — Laravel Named Routes in Vue
 
This project uses [Ziggy](https://github.com/tightenco/ziggy) to make Laravel named routes
available in Vue components.
 
**Why Ziggy?**
 
| Without Ziggy | With Ziggy |
|---|---|
| Routes are hardcoded strings e.g. `'/todos'` | Routes use Laravel named routes e.g. `route('todos.index')` |
| If a route URL changes, you must update every Vue file manually | If a route URL changes, Ziggy updates it automatically everywhere |
| Error prone in large applications | Safe and maintainable in large applications |
 
For a small application hardcoded URLs work fine, but for larger applications Ziggy is
the recommended approach to keep routes consistent and maintainable.
 
---
 
## License
 
This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).