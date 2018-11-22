<?php

/**
 * Class UserTest
 */
class UserTest extends TestCase
{
	private $user = [
		'name' => 'Sally',
		'username' => 'test@test.test',
		'password' => 'Sally1234',
		'confirm_password' => 'Sally1234',

	];

    private $userPasswordMismatch = [
        'name' => 'Sally',
        'username' => 'test@test.test',
        'password' => 'Sally1234',
        'confirm_password' => 'Sally12345',

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
            ->seeStatusCode(201)
            ->seeJson([
				'status' => 'success',
			]);

	}

    /**
     * Test user registration with password mismatch
     */
    public function testRegisterUserWithPasswordMismatch()
    {
        $this->post('/api/auth/register', $this->userPasswordMismatch)
            ->seeStatusCode(400)
            ->seeJson([
                'status' => 'fail'
            ]);

    }

    /**
     * Test user registration
     */
    public function testRegisterExistingUser()
    {
        $this->post('/api/auth/register', $this->user)
            ->seeStatusCode(201)
            ->seeJson([
                'status' => 'success',
            ]);

        $this->post('/api/auth/register', $this->user)
            ->seeStatusCode(400)
            ->seeJson([
                'status' => 'fail',
            ]);
    }

}
