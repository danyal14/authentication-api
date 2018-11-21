<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;
use Validator;


/**
 * Class LoginController
 *
 * @author Danyal AB <mig@danyal.dk>
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
	/**
	 * Register
	 *
	 * @param Request $request
	 * @return array|\Illuminate\Http\JsonResponse
	 */
	public function register(Request $request) {

		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'username' => 'required|string|email|max:255|unique:users,email',
			'password' => 'required|string|min:6',
			'confirm_password' => 'required|same:password'
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 'fail',
				'message' => 'Validation errors.',
				'errors' => $validator->errors()
			], 400);
		}

		$post = json_decode($request->getContent(), true);

		try {
			// Create new user
			User::create([
				'name' => $request->name,
				'email' => $request->username,
				'password' => app('hash')->make($post['password']),
			]);

			return response()->json( [
				'status' => 'success',
				'message' => 'Your account is created successfully.'
			], 201);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 'fail',
				'message' => 'Internal Server Error.',
				'exception' => $e->getMessage()
			], 500);
		}
	}

	/**
	 * Login
	 *
	 * @param Request $request
	 * @return array|\Illuminate\Http\JsonResponse
	 */
	public function login(Request $request) {

		$validator = Validator::make($request->all(), [
			'username' => 'required|string|email|max:255,email',
			'password' => 'required|string|min:6',
		]);
		
		if ($validator->fails()) {
			return response()->json([
				'status' => 'fail',
				'message' => 'Validation errors.',
				'errors' => $validator->errors()
			], 400);
		}

		$post = json_decode($request->getContent(), true);

		// Validate email existence
		$user = User::where('email', $post['username'])->first();
		if (!$user) {
			return UserService::unauthorizedResponse();
		}

		// Validate
		if (!Hash::check($post['password'], $user->password)) {
			return UserService::unauthorizedResponse();
		}

		// regenerate api token upon login, that will invalidate the previous token.
		$user->api_token = app('hash')->make($post['password'] . '_' . $post['username']);
		$user->save();

		return [
			'status' => 'success',
			'api_token' => $user->api_token
		];
	}

	/**
	 * logout
	 *
	 * @return array|\Illuminate\Http\JsonResponse
	 */
	public function logout() {

		// remove the api_token, when logging out
		$user = Auth::user();
		$user->api_token = '';
		$user->save();

		return [
			'status' => 'success',
			'message' => 'Logout successfully.'
		];
	}

	/**
	 * Verify
	 *
	 * @return array|\Illuminate\Http\JsonResponse
	 */
	public function verify() {

		return [
			'status' => 'success',
			'message' => 'Token is verified.'
		];
	}
}