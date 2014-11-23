<?php

use Way\Tests\Factory;

/**
 * Description of LessonControllerTest
 *
 * @author adekunleadedayo
 */
class LessonControllerTest extends TestCase {

  public function setUp() {
	parent::setUp();
  }

  public function tearDown() {
	Mockery::close();
  }

  public function testBlank() {
	
  }
  /*
    public function testLessonIsNotCreatedIfValidationErrorOccurs() {
    $input = array();

    $repo = Mockery::mock('Neartutor\Repository\LessonRepository');
    $repo->shouldReceive('create')->never();
    App::instance('Neartutor\Repository\LessonRepository', $repo);

    $response = $this->call('POST', "v1/lesson/create", $input);

    $this->assertJson($response->getContent());
    $data = json_decode($response->getContent());
    $this->assertEquals($data->status, "error");
    $this->assertArrayHasKey('errors', (array) $data);
    $this->assertContains('The hours field is required.', (array) $data->errors);
    }


    public function testLessonIsCreatedIfNoErrorOccurs() {
    $lesson = Factory::make('Neartutor\Models\Lesson');
    $input = $lesson->toArray();

    $repo = Mockery::mock('Neartutor\Repository\LessonRepository');
    $repo->shouldReceive('create')->once()->andReturn($lesson);

    App::instance('Neartutor\Repository\LessonRepository', $repo);

    $response = $this->call('POST', "v1/lesson/create", $input);

    $this->assertJson($response->getContent());
    $data = json_decode($response->getContent());
    $this->assertEquals($data->status, "success");
    $this->assertEquals($data->lesson->id, $lesson->id);
    }


    public function testGetLessonByIdFailsGivenInvalidId() {
    $id = 10000;

    $repo = Mockery::mock('Neartutor\Repository\LessonRepository');
    $repo->shouldReceive('get')->once()->with($id)->andReturn(null);
    App::instance('Neartutor\Repository\LessonRepository', $repo);

    $response = $this->call('GET', "v1/lesson/{$id}");

    $this->assertJson($response->getContent());
    $data = json_decode($response->getContent());
    $this->assertEquals($data->status, "error");
    $this->assertEquals($data->message, "No lesson with ID {$id}");
    }


    public function testGetLessonSucceedsGivenValidId() {
    $id = 15;

    $lesson = Factory::make('Neartutor\Models\Lesson', ['id' => $id]);
    $repo = Mockery::mock('Neartutor\Repository\LessonRepository');
    $repo->shouldReceive('get')->once()->with($id)->andReturn($lesson);
    App::instance('Neartutor\Repository\LessonRepository', $repo);

    $response = $this->call('GET', "v1/lesson/{$id}");

    $this->assertJson($response->getContent());
    $data = json_decode($response->getContent());
    $this->assertEquals($data->status, "success");
    $this->assertEquals($data->lesson->id, $id);
    }

    public function testDeleteLessonFailsGivenInvalidId() {
    $id = 15;

    $repo = Mockery::mock('Neartutor\Repository\LessonRepository');
    $repo->shouldReceive('delete')->once()->with($id)->andReturn(false);
    App::instance('Neartutor\Repository\LessonRepository', $repo);

    $response = $this->call('GET', "v1/lesson/delete/{$id}");

    $this->assertJson($response->getContent());
    $data = json_decode($response->getContent());
    $this->assertEquals($data->status, "error");
    $this->assertEquals($data->message, "An error occured");
    }


    public function testDeleteLessonSucceedsGivenValidId() {
    $id = 15;

    $repo = Mockery::mock('Neartutor\Repository\LessonRepository');
    $repo->shouldReceive('delete')->once()->with($id)->andReturn(true);
    App::instance('Neartutor\Repository\LessonRepository', $repo);

    $response = $this->call('GET', "v1/lesson/delete/{$id}");

    $this->assertJson($response->getContent());
    $data = json_decode($response->getContent());
    $this->assertEquals($data->status, "success");
    $this->assertEquals($data->id, $id);
    } */
}
