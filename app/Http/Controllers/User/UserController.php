<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

/**
 * Class UserController
 *
 * @author Danyal AB <mig@danyal.dk>
 * @package App\Http\Controllers\User
 */
class UserController extends Controller
{

	/**
	 * User profile for Auth user
	 *
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function profile()
	{
		return Auth::user();
	}

	public function changePassword(Request $request) {

		$validator = Validator::make($request->all(), [
			'username' => [
				'required',
				'string',
				'email',
				'max:255',
				'exists:users,email'
			], 'email',
			'old_password' => 'required|string|min:6',
			'new_password' => 'required|string|min:6',
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
		if (!Hash::check($post['old_password'], $user->password)) {
			return UserService::unauthorizedResponse();
		}

		$user->password = app('hash')->make($post['new_password']);
		$user->save();

		return [
			'status' => 'success',
			'message' => 'Password is midified successfully.'
		];
	}
}