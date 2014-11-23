<?php

use Neartutor\Models\User;

/**
 * Description of LoginControllerTest
 *
 * @author adekunleadedayo
 */
class LoginControllerTest extends TestCase {

    public function setUp() {
        parent::setUp();
    }
    
    public function tearDown() {
        Mockery::close();
    }

    public function testUserNotFoundExceptionIsThrown() {
        $sentry = Mockery::mock("Cartalyst\Sentry\Sentry");
        $input = array('email' => 'adedayokunle@gmail.com', 'password' => 'love');

        $sentry->shouldReceive('authenticate')
                ->once()
                ->with($input, false)
                ->andThrow(new Cartalyst\Sentry\Users\UserNotFoundException);

        $this->app->instance('Cartalyst\Sentry\Sentry', $sentry);

        $response = $this->call('POST', 'v1/login', $input);
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
       // $this->assertArrayHasKey($data, $input);
    }

    public function testSuccessfulLogin() {
        $sentry = Mockery::mock("Cartalyst\Sentry\Sentry");
        $input = array('email' => 'adedayokunle@gmail.com', 'password' => 'love');
        
        
        //$attributes = array("permissions"=>array());
        //$user = Factory::attributesFor('Neartutor\Models\User', ['permissions' => array(), 'attributes'=>$attributes]);
        $user = new User;
        
        //var_dump($user);
        $sentry->shouldReceive('authenticate')
                ->once()
                ->with($input, false)
                ->andReturn($user);

        $this->app->instance('Cartalyst\Sentry\Sentry', $sentry);

        $response = $this->call('POST', 'v1/login', $input);
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
    }

}
