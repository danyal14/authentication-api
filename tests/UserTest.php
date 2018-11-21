<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * Class UserTest
 */
class UserTest extends TestCase
{
	use DatabaseTransactions;


	private $user = [
		'name' => 'Sally',
		'username' => 'test@test.test',
		'password' => 'Sally1234',
		'confirm_password' => 'Sally1234',

	];

    /**
     * Test API root
     *
     * @return void
     */
    public function testAPIRoot()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }

	/**
	 * Test user registration
	 */
	public function testRegisterUser()
	{
		$this->post('/api/auth/register', $this->user)
			->seeJson([
				'status' => 'success',
			]);

	}



}
