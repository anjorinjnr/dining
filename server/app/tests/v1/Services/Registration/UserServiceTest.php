<?php

/**
 * Description of UserServiceTest
 *
 * @author adekunleadedayo
 */
class UserServiceTest extends TestCase {

    public function setUp() {
        @session_start();
        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    /** Create Student tests * */
    public function testCreateUserFailsGivenInvalidData() {
        $userRepository = Mockery::mock("Neartutor\Repository\UserRepository");
        $notificationService = Mockery::mock("Neartutor\Services\NotificationService");
        $userService = new Neartutor\Services\UserService($userRepository, $notificationService);
		echo $userService;

        $input = array();
        $user = $userService->create($input);

        $this->assertFalse($user);
        $this->assertNotEmpty($userService->errors());
    }

    public function testCreateUserFailsGivenExistingEmail() {
        $userRepository = Mockery::mock("Neartutor\Repository\UserRepository");
        $notificationService = Mockery::mock("Neartutor\Services\NotificationService");
        $userService = new Neartutor\Services\UserService($userRepository, $notificationService);
        // $sentry = Mockery::mock("Cartalyst\Sentry\Sentry");

        $input = array(
            "email" => 'sumbatele@yahoo.com',
            "password" => 'tretretr',
            "first_name" => 'rewrew',
            "last_name" => 'fdsfds',
            "state_id" => 1,
            "town_id" => 2,
            "area_id" => 3,
            "phone_number" => 'fdsfdsfds');


        $userRepository->shouldReceive('errors')->andReturn(array('User with email already exists'));
        $userRepository->shouldReceive('create')
                ->once()
                ->andReturn(false);


        /* $sentry->shouldReceive('createUser')
          ->once()
          ->with($input)
          ->andThrow(new Cartalyst\Sentry\Users\UserExistsException);


          $userRepository->shouldReceive('addError')
          ->once()
          ->with("User with email already exists")
          ->andReturn(false);

          $userRepository->shouldReceive('errors')
          ->twice()
          ->andReturn(array('User with email already exists')); */

        //$this->app->instance('Cartalyst\Sentry\Sentry', $sentry);
        //$this->app->instance('Neartutor\Repository\UserRepository', $userRepository);

        $input['confirm_password'] = 'tretretr';
        $user = $userService->create($input);

        $this->assertFalse($user);
        $this->assertContains('User with email already exists', $userService->errors());
    }

    public function testCreateUserSuccess() {
        $userRepository = Mockery::mock("Neartutor\Repository\UserRepository");
        $notificationService = Mockery::mock("Neartutor\Services\NotificationService");
        $userService = new Neartutor\Services\UserService($userRepository, $notificationService);

        $user = Mockery::mock("Neartutor\Models\User");
        $input = array(
            "email" => 'sumbatele@yahoo.com',
            "password" => 'tretretr',
            "first_name" => 'rewrew',
            "last_name" => 'fdsfds',
            "state_id" => 1,
            "town_id" => 2,
            "area_id" => 3,
            "phone_number" => 'fdsfdsfds');

        $userRepository->shouldReceive('create')
                ->once()
                ->with($input)
                ->andReturn($user);

        $userRepository->shouldReceive('errors')
                ->once()
                ->andReturn(array());
        
        $user->shouldReceive('getActivationCode')->once()->andReturnNull();
        $user->shouldReceive('getAttribute')->twice();
        $user->shouldReceive('getFullName')->once();
        $notificationService->shouldReceive('sendEmail')->andReturn(true);


        $input['confirm_password'] = 'tretretr';
        $u = $userService->create($input);

        $this->assertNotFalse($u);
        $this->assertInstanceOf('\Neartutor\Models\User', $u);
    }

}
