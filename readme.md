# Authentication API using Lumen

This API developed in process of testing Lumen framework, you are welcoem to take advantage of this repo.

Do fork it but avoid making changes in master, rather put PRs.

Very basic but functional Auth api based of api_token.

## Features 
 
 * Register new user
 * Login (new api token will be return upon login)
 * Change password
 * User Profile
 * Verify api_token for user
 * Logout (api_token will be destroyed)

## Routes 
	
There is a public link for list of available routes

	https://documenter.getpostman.com/view/66154/RzZFBbbC

## Artisan Commands
	
	artisan migrate
	artisan db:seed

or run following command to list all available artisan commands 

	php artisan


## Testing 

    artisan migrate --env="testing"
    artisan migrate:reset --env="testing"
    artisan db:seed --env="testing"