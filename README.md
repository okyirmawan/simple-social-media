# Simple Social Media

This is an API for simple social media applications. The available API starts from user registration to creating an account. After successfully creating an account, the user can log in to get a token. The authentication system used is Laravel Sanctum. Several endpoints, such as follow, unfollow, and list followers, must use tokens to access them.

## Installation

To use this API, you can follow the following steps.

- Clone project from this repository.
- Run `composer install` to download all dependency.
- Add file .env to this project, you can copy from .env.example
- Create database.
- Run `php artisan migrate`.

## Demo

API Documentation can be accessed at the following url http://{{baseurl}}/api/documentation.
