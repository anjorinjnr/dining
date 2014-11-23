<?php

use Way\Tests\Factory;

/**
 * Description of TutorControllerTest
 *
 * @author Adekunle Adedayo
 */
class TutorControllerTest extends TestCase {

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

    public function testGetTutorFailsWhenTutorDoesntExist() {
        $id = 15;

        $repo = Mockery::mock('Neartutor\Repository\TutorRepository');
        $repo->shouldReceive('get')->once()->with($id)->andReturn(null);
        App::instance('Neartutor\Repository\TutorRepository', $repo);

        $response = $this->call('GET', "v1/tutor/{$id}");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertContains("No tutor with ID {$id}", $data->errors);
        //$this->assertEquals($data->error, "No tutor with ID {$id}");
    }

    
    public function testGetTutorSuccess() {
        $id = 28;

        $tutor = Factory::make('Neartutor\Models\Tutor', ['id' => $id]);
     
        $repo = Mockery::mock('Neartutor\Repository\TutorRepository');
        $repo->shouldReceive('get')->once()->with($id)->andReturn($tutor);
        $this->app->instance('Neartutor\Repository\TutorRepository', $repo);

        $response = $this->call('GET', "v1/tutor/{$id}");
 
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->tutor->id, $id);
    }

    

}
