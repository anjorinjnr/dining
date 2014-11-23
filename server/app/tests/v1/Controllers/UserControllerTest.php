<?php

use Way\Tests\Factory;
/**
 * Description of UserControllerTest
 *
 * @author Adekunle Adedayo
 */
use \Mockery;

class UserControllerTest extends TestCase {

    public function setUp() {
        @session_start();
        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    public function testUserUpdateSuccess() {
        $userService = Mockery::mock("Neartutor\Services\Registration\UserService");
        $repo = Mockery::mock('Neartutor\Repository\TutorRepository');
        $input = array("email" => "email");

        $user = Mockery::mock("Neartutor\Models\User");
        $tutor = Factory::make('Neartutor\Models\Tutor', ['id' => 100]);

        $userService->shouldReceive('create')->once()->with($input)->andReturn($user);
        $userService->shouldReceive('errors')->once()->andReturn(array());
        $repo->shouldReceive('create')->andReturn($tutor);

        $user->shouldReceive('getAttribute')->once();
        App::instance('Neartutor\Services\Registration\UserService', $userService);
        App::instance('Neartutor\Repository\TutorRepository', $repo);

        $response = $this->call('POST', "v1/user/8", $input);
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->tutor->id, 100);
    }

}
