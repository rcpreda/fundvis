
# Laravel Task Manager

A small Laravel-based task management system that supports:

- Tasks with multiple subtasks
- Polymorphic relationships (`taskable`)
- Multilingual fields (`name` and `description`) in EN, FR, and GE
- Authorization policies per user/tasks 
- Soft deletes
- Translatable fields via [spatie/laravel-translatable](https://github.com/spatie/laravel-translatable)


## Install guide and usage
 - git clone git@github.com:rcpreda/fundvis.git
 - composer install
 - npm install && npm run dev
 - cp .env.example .env
 - php artisan key:generate
 - php artisan migrate --seed
 - php artisan serve
 - use rcpreda@gmail.com as login or create a new user (pass: test1234)


# Improvements
 - Filtering and Searching in the Task List

- Allow filtering by status, keyword in name, user, etc.

Example: ?status=pending&query=invoice

## Pagination

- Use paginate() instead of get() in the index() method and display navigation links.

- Display Translations Based on Language

- Show name and description according to app()->getLocale().

- Mark as Done

 - Check off a task or subtask as "done" directly from the list (without full edit).


## Security / Access Control Improvements
 - Custom Middleware

 - Restrict access to task routes for unauthorized users.

 - Role-Based Permissions

 - Use a simple roles system (admin, user) or integrate spatie/laravel-permission.


## Technical & Scalability Improvements
 - Transformation with API Resources

 - Livewire or Inertia.js for a Modern UX

 - Eliminate full page reloads.

 - Centralized Validation for Supported Languages

 - Create a helper that generates rules for all locales.
