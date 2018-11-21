<?php

$router->get('/', function () use ($router) {
	return $router->app->version();
});

$router->get('/key/generate', function () {
	return response()->json([str_random(64)]);
});

// Routes grouped by prefix api
$router->group(['prefix' => 'api'], function () use ($router) {

	// Routes requires auth
	$router->group(['middleware' => 'auth'], function () use ($router) {
		$router->get('auth/logout', 'User\AuthController@logout');
		$router->get('auth/verify', 'User\AuthController@verify');
		$router->get('user/profile', 'User\UserController@profile');

		$router->post('user/change-password', 'User\UserController@changePassword');

		// obviously this shouldn't be expose to every user, but based or permission or role.
		// this API don't cover that, but Laravel has policies and gates configurations, if you are interested.
		$router->get('/users', function () use ($router) {
			return \App\User::all();
		});
	});

	$router->post('auth/register', 'User\AuthController@register');
	$router->post('auth/login', 'User\AuthController@login');
});