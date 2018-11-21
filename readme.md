# Authentication API using Lumen

This API developed in process of testing Lumen framework, you are welcoem to take advantage of this repo.

Do fork it but avoid making changes in master, rather put PRs.

Very basic but functional Auth api based of api_token.

## About Me
	
	visit www.danyal.dk
	
## Features 
 
 * Register new user
 * Login (new api token will be return upon login)
 * Change password
 * User Profile
 * Verify api_token for user
 * Logout (api_token will be destroyed)
 
## Routes 
API based on following routes.

	POST /api/auth/register
	POST /api/auth/login
	GET /api/auth/logout
	GET /api/auth/verify
	GET /api/user/profile
	GET /api/users
	POST /api/user/change-password
	GET /key/generate
	
There is a public link available for documentation.

	https://documenter.getpostman.com/view/66154/RzZFBbbC

## Steps of usage
From project folder:

	composer install	
	artisan migrate
	artisan db:seed


or run following command to list all available artisan commands 

	php artisan

## Serving Your Application
To serve your project locally, you may use the Laravel Homestead virtual machine, Laravel Valet, or the built-in PHP development server:

php -S localhost:8000 -t public

## Configuration
All of the configuration options for the Lumen framework are stored in the .env file. Once Lumen is installed, you should also configure your local environment.

#### Application Key
The next thing you should do after installing Lumen is set your application key to a random string. Typically, this string should be 32 characters long. The key can be set in the .env environment file. If you have not renamed the .env.example file to .env, you should do that now. If the application key is not set, your user encrypted data will not be secure!

You can use /key/generate to generate APIKEY, then store it in .env file.
