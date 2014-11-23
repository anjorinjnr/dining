<?php

/**
 * Description of UserServiceTest
 *
 * @author adekunleadedayo
 */
class StudentServiceTest extends TestCase {

    public function setUp() {
        @session_start();
        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    /** Create Student tests * */
    public function testStudentIsNotCreatedGivenInvalidData() {
      /*  $studentRepository = Mockery::mock("Neartutor\Repository\StudentRepository");
        $userService = Mockery::mock("Neartutor\Services\Registration\UserService");
        $studentService = new Neartutor\Services\Registration\StudentService($studentRepository, $userService);

        $userService->shouldReceive('create');
        $userService->shouldReceive('errors')->andReturn(array('An error occured'));

        $input = array();
        $student = $studentService->create($input);

        $this->assertFalse($student);
        $this->assertNotEmpty($studentService->errors());*/
    }

    public function testUserIsDeletedIfErrorOccuredWhileCreatingStudent() {
        /*$studentRepository = Mockery::mock("Neartutor\Repository\StudentRepository");
        $userService = Mockery::mock("Neartutor\Services\Registration\UserService");
        $studentService = new Neartutor\Services\Registration\StudentService($studentRepository, $userService);
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

        $userService->shouldReceive('create')
                ->once()
                ->with($input)
                ->andReturn($user);

        $userService->shouldReceive('errors')->andReturn(array());
        $studentRepository->shouldReceive('create')->andReturn(false);

        $user->shouldReceive('getAttribute')->once();
        $user->shouldReceive('delete')->once();
        $student = $studentService->create($input);

        $this->assertFalse($student);
        $this->assertNotEmpty($studentService->errors());
    }

    public function testStudentCreateSuccess() {
        $studentRepository = Mockery::mock("Neartutor\Repository\StudentRepository");
        $userService = Mockery::mock("Neartutor\Services\Registration\UserService");
        $studentService = new Neartutor\Services\Registration\StudentService($studentRepository, $userService);
        $user = Mockery::mock("Neartutor\Models\User");
        $studentMock = Mockery::mock("Neartutor\Models\Student");

        $input = array(
            "email" => 'sumbatele@yahoo.com',
            "password" => 'tretretr',
            "first_name" => 'rewrew',
            "last_name" => 'fdsfds',
            "state_id" => 1,
            "town_id" => 2,
            "area_id" => 3,
            "phone_number" => 'fdsfdsfds');

        $userService->shouldReceive('create')
                ->once()
                ->with($input)
                ->andReturn($user);

        $userService->shouldReceive('errors')->andReturn(array());
        $studentRepository->shouldReceive('create')->andReturn($studentMock);

        $user->shouldReceive('getAttribute')->once();
        $student = $studentService->create($input);

        $this->assertEmpty($studentService->errors());
        $this->assertInstanceOf('\Neartutor\Models\Student', $student);*/
    }

}
