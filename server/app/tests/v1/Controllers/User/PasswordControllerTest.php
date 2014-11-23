<?php

/**
 * Description of UserControllerTest
 *
 * @author Adekunle Adedayo
 */
use \Mockery;

class PasswordControllerTest extends TestCase {

    public function setUp() {
        @session_start();
        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    public function testResetShouldFailIfDataIsInvalid() {
        // Empty data passed
        $input = array();

        $response = $this->call('POST', "v1/user/changepassword", $input);
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertArrayHasKey('errors', (array) $data);
    }

    public function testShouldFailIfOldPasswordIsIncorrect() {
        $input = array("id" => 3, "old_password" => "kunle", "password" => "sola", "confirm_password" => "sola");

        $user = Mockery::mock("Neartutor\Models\User");
        $sentry = Mockery::mock("Cartalyst\Sentry\Sentry");

        $sentry->shouldReceive('findUserById')
                ->once()
                ->with($input['id'])
                ->andReturn($user);

        $user->shouldReceive('checkPassword')
                ->once()
                ->with($input['old_password'])
                ->andReturn(false);

        $user->shouldReceive('save')
                ->never();

        $this->app->instance('Cartalyst\Sentry\Sentry', $sentry);

        $response = $this->call('POST', "v1/user/changepassword", $input);
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertContains("Old password is incorrect", $data->errors);
        //$this->assertEquals($data->error, "Old password is incorrect");
    }

    public function testShouldFailIdUserIdDoesntExist() {
        $input = array("id" => 3, "old_password" => "kunle", "password" => "sola", "confirm_password" => "sola");

        $sentry = Mockery::mock("Cartalyst\Sentry\Sentry");


        $sentry->shouldReceive('findUserById')
                ->once()
                ->with($input['id'])
                ->andThrow(new Cartalyst\Sentry\Users\UserNotFoundException);

        $this->app->instance('Cartalyst\Sentry\Sentry', $sentry);

        $response = $this->call('POST', "v1/user/changepassword", $input);
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertContains("User was not found", $data->errors);
        //$this->assertEquals($data->error, "User was not found");
    }

    public function testPasswordChangeSuccess() {
        $input = array("id" => 3, "old_password" => "kunle", "password" => "sola", "confirm_password" => "sola");

        $sentry = Mockery::mock("Cartalyst\Sentry\Sentry");
        $user = Mockery::mock("Neartutor\Models\User");

        $sentry->shouldReceive('findUserById')
                ->once()
                ->with($input['id'])
                ->andReturn($user);

        $user->shouldReceive('checkPassword')
                ->once()
                ->with($input['old_password'])
                ->andReturn(true);

        $user->shouldReceive('setAttribute')
                ->once()
                ->with('password', $input['password']);

        $user->shouldReceive('save')
                ->once()
                ->andReturn(true);

        $this->app->instance('Cartalyst\Sentry\Sentry', $sentry);

        $response = $this->call('POST', "v1/user/changepassword", $input);
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->message, "Password changed successfully");
    }

    function testSendPasswordResetInstructionFailsWhenAnErrorOccurs() {
        
    }

    function testSendPasswordResetInstructionSuccess() {
        
    }

}
