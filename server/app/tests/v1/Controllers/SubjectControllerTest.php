<?php

use Way\Tests\Factory;

/**
 * Description of LoginControllerTest
 *
 * @author adekunleadedayo
 */
class SubjectControllerTest extends TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    public function testSubjectIsNotCreatedIfValidationErrorOccurs() {
        $data['title'] = '';

        $repo = Mockery::mock('Neartutor\Repository\SubjectRepository');
        $repo->shouldReceive('create')->never();
        App::instance('Neartutor\Repository\SubjectRepository', $repo);

        $response = $this->call('POST', "v1/subject", $data);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertArrayHasKey('errors', (array) $data);
        $this->assertContains('The title field is required.', (array) $data->errors);
    }

    public function testSubjectIsNotCreatedIfSubjectAlreadyExists() {
        $data['title'] = 'Hello';

        $subject = Factory::make('Neartutor\Models\Subject');
        $repo = Mockery::mock('Neartutor\Repository\SubjectRepository');
        $repo->shouldReceive('create')->never();
        $repo->shouldReceive('getSubjectByName')->once()->
                andReturn($subject);

        App::instance('Neartutor\Repository\SubjectRepository', $repo);

        $response = $this->call('POST', "v1/subject", $data);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertArrayHasKey('errors', (array) $data);
        $this->assertContains('Subject title exists', (array) $data->errors);
    }

    public function testSubjectIsCreatedIfNoErrorOccurs() {
        $data['title'] = 'hello';

        $subject = Factory::make('Neartutor\Models\Subject', ['id' => 20]);
        $repo = Mockery::mock('Neartutor\Repository\SubjectRepository');
        $repo->shouldReceive('create')->once()->andReturn($subject);
        $repo->shouldReceive('getSubjectByName')->once()->andReturn(null);

        App::instance('Neartutor\Repository\SubjectRepository', $repo);

        $response = $this->call('POST', "v1/subject", $data);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->subject->id, $subject->id);
    }

    public function testGetSubjectByIdFailsGivenInvalidId() {
        $id = 10000;

        $repo = Mockery::mock('Neartutor\Repository\SubjectRepository');
        $repo->shouldReceive('get')->once()->with($id)->andReturn(null);
        App::instance('Neartutor\Repository\SubjectRepository', $repo);

        $response = $this->call('GET', "v1/subject/{$id}");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertContains("No subject with ID {$id}", $data->errors);
        //$this->assertEquals($data->errors, );
    }

   
    public function testGetSubjectByNameFailsGivenInvalidName() {
        $name = 'tilapia';

        $repo = Mockery::mock('Neartutor\Repository\SubjectRepository');
        $repo->shouldReceive('getSubjectByName')->once()->with($name)->andReturn(null);
        App::instance('Neartutor\Repository\SubjectRepository', $repo);

        $response = $this->call('GET', "v1/subject/by_name", array("subject" => $name));

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertContains("No subject with name {$name}", $data->errors);
        //$this->assertEquals($data->message, "No subject with name {$name}");
    }

     
    public function testGetSubjectSucceedsGivenValidId() {
        $id = 15;

        $subject = Factory::make('Neartutor\Models\Subject', ['id' => $id]);
        $repo = Mockery::mock('Neartutor\Repository\SubjectRepository');
        $repo->shouldReceive('get')->once()->with($id)->andReturn($subject);
        
       //ß $subject->shouldReceive("toArray")->once()->andReturn($subject->toArray());
        App::instance('Neartutor\Repository\SubjectRepository', $repo);

        $response = $this->call('GET', "v1/subject/{$id}");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->subject->id, $id);
    }

    
    public function testGetSubjectSucceedsGivenValidName() {

        $subject = Factory::make('Neartutor\Models\Subject');
        $repo = Mockery::mock('Neartutor\Repository\SubjectRepository');
        $repo->shouldReceive('getSubjectByName')->once()->with($subject->title)->andReturn($subject);
        App::instance('Neartutor\Repository\SubjectRepository', $repo);

        $response = $this->call('GET', "v1/subject/by_name", array('subject' => $subject->title));

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->subject->title, $subject->title);
    }

    
    public function testDeleteSubjectFailsGivenInvalidId() {
        $id = 15;

        $repo = Mockery::mock('Neartutor\Repository\SubjectRepository');
        $repo->shouldReceive('delete')->once()->with($id)->andReturn(false);
        App::instance('Neartutor\Repository\SubjectRepository', $repo);

        $response = $this->call('GET', "v1/subject/{$id}/delete");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertContains("An error occured", $data->errors);
        //$this->assertEquals($data->message, "An error occured");
    }

    
    public function testDeleteSubjectSucceedsGivenValidId() {
        $id = 15;

        $repo = Mockery::mock('Neartutor\Repository\SubjectRepository');
        $repo->shouldReceive('delete')->once()->with($id)->andReturn(true);
        App::instance('Neartutor\Repository\SubjectRepository', $repo);

        $response = $this->call('GET', "v1/subject/{$id}/delete");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->id, $id);
    }

    
    public function testGetAllSubjects() {
        
        $sub = Mockery::mock('Neartutor\Models\Subject');
        
        $subject1 = Factory::make('Neartutor\Models\Subject');
        $subject2 = Factory::make('Neartutor\Models\Subject');
        $subjects = compact("subject1", "subject2");

        $repo = Mockery::mock('Neartutor\Repository\SubjectRepository');
        $repo->shouldReceive('all')->once()->andReturn($sub);
        $sub->shouldReceive('toArray')->andReturn($subjects);
        App::instance('Neartutor\Repository\SubjectRepository', $repo);

        $response = $this->call('GET', "v1/subject");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertCount(2, (array) $data->subjects);
    }

}
