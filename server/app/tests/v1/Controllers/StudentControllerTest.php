<?php

use Way\Tests\Factory;

/**
 * Description of StudentControllerTest
 *
 * @author Adekunle Adedayo
 */
class StudentControllerTest extends TestCase {

    public function setUp() {
        @session_start();
        parent::setUp();
    }
    
    public function tearDown() {
        Mockery::close();
    }

    /** Get student tests * */
    /* public function testGetUserFailsWithoutUserId() {
      $response = $this->call('GET', 'v1/student');

      $data = $response->getContent();
      dd($data);
      /*  $this->assertJson($data);
      $this->assertEquals($data->status, "error");
      $this->assertEquals($data->message, "User ID is required");
      } */

    public function testGetStudentFailsWhenUserDoesntExist() {
        $id = 15;

        $repo = Mockery::mock('Neartutor\Repository\StudentRepository');
        $repo->shouldReceive('get')->once()->with($id)->andReturn(null);
        App::instance('Neartutor\Repository\StudentRepository', $repo);

        $response = $this->call('GET', "v1/student/{$id}");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertEquals($data->message, "No student with ID {$id}");
    }

    public function testGetStudentSuccess() {
        $id = 15;

        $student = Factory::make('Neartutor\Models\Student', ['id' => $id]);
        $repo = Mockery::mock('Neartutor\Repository\StudentRepository');
        $repo->shouldReceive('get')->once()->with($id)->andReturn($student);
        App::instance('Neartutor\Repository\StudentRepository', $repo);

        $response = $this->call('GET', "v1/student/{$id}");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->student->id, $id);
    }

    /** Create Student tests * */
    public function testCreateStudentFailsGivenInvalidData() {
        $input = array();
        $response = $this->call('POST', "v1/student/create", $input);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertArrayHasKey('errors', (array) $data);
    }

    public function testCreateStudentFailsGivenExistingEmail() {
        $userRepository = Mockery::mock("Neartutor\Repository\UserRepository");
        $sentry = Mockery::mock("Cartalyst\Sentry\Sentry");

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
                ->once();

        $userRepository->shouldReceive('errors')
                ->once()
                ->andReturn(array('User with email already exists'));

        $sentry->shouldReceive('createUser')
                ->once()
                ->with($input)
                ->andThrow(new Cartalyst\Sentry\Users\UserExistsException);

        $userRepository->shouldReceive('addError')
                ->once()
                ->with("User with email already exists")
                ->andReturn(false);

        $this->app->instance('Cartalyst\Sentry\Sentry', $sentry);
        $this->app->instance('Neartutor\Repository\UserRepository', $userRepository);

        $input['confirm_password'] = 'tretretr';
        $response = $this->call('POST', "v1/student/create", $input);


        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertArrayHasKey('errors', (array) $data);
        $this->assertContains('User with email already exists', (array) $data->errors);
    }

    public function testCreateStudentSuccess() {
        $userRepository = Mockery::mock("Neartutor\Repository\UserRepository");
        $studentRepository = Mockery::mock("Neartutor\Repository\StudentRepository");
        $sentry = Mockery::mock("Cartalyst\Sentry\Sentry");

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
                ->andReturn(new \Neartutor\Models\User);

        $userRepository->shouldReceive('errors')
                ->once()
                ->andReturn(array());
        
         $studentRepository->shouldReceive('create')
                ->once()
                 ->andReturn(new \Neartutor\Models\Student);

       

        $this->app->instance('Cartalyst\Sentry\Sentry', $sentry);
        $this->app->instance('Neartutor\Repository\UserRepository', $userRepository);
        $this->app->instance('Neartutor\Repository\StudentRepository', $studentRepository);

        $input['confirm_password'] = 'tretretr';
        $response = $this->call('POST', "v1/student/create", $input);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
    }

}
