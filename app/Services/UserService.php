<?php

namespace App\Services;

/**
 * Class UserService
 *
 * @author Danyal AB <mig@danyal.dk>
 * @package App\Services
 */
class UserService
{
	/**
	 * Unauthorized response
	 *
	 * @param null $message
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function unauthorizedResponse($message = null) {
		return response()->json([
			'status' => 'fail',
			'message' => $message ? $message : 'Unauthorized, invalid email or password!'
		], '401');
	}
}