<?php

use Way\Tests\Factory;

/**
 * Description of MessageControllerTest
 *
 * @author adekunleadedayo
 */
class MessageControllerTest extends TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    public function testMessageSendSuccess() {
        $input = Factory::make('Neartutor\Models\Message');
        $repo = Mockery::mock('Neartutor\Repository\MessageRepository');
        $repo->shouldReceive('create')->once()->andReturn(true);
        $repo->shouldReceive('errors')->andReturn(array());
        App::instance('Neartutor\Repository\MessageRepository', $repo);

        $response = $this->call('POST', "api/v1/message", $input->toArray());

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->message, "Message sent successfully");
        //$this->assertEquals($data->id, $id);
    }

    public function testMessageSendingFailsWhenValidationErrorOccurs() {
        $input = array();
        $repo = Mockery::mock('Neartutor\Repository\MessageRepository');
        $repo->shouldReceive('create')->never();
        $repo->shouldReceive('errors')->never();
        App::instance('Neartutor\Repository\MessageRepository', $repo);

        $response = $this->call('POST', "api/v1/message", $input);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertArrayHasKey("errors", (array) $data);
    }

    public function testMessageSendingFailsWhenAnErrorOccurs() {
        $input = Factory::make('Neartutor\Models\Message');
        $repo = Mockery::mock('Neartutor\Repository\MessageRepository');
        $repo->shouldReceive('create')->once()->andReturn(true);
        $repo->shouldReceive('errors')->andReturn(array("An error occured"));
        App::instance('Neartutor\Repository\MessageRepository', $repo);

        $response = $this->call('POST', "api/v1/message", $input->toArray());

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertArrayHasKey("errors", (array) $data);
        $this->assertContains("An error occured", $data->errors);
    }

    public function testMessageMarkedAsRead() {
        $input = Factory::make('Neartutor\Models\Message');
        $repo = Mockery::mock('Neartutor\Repository\MessageRepository');
        $repo->shouldReceive('markAsRead')->once()->andReturn(true);
        App::instance('Neartutor\Repository\MessageRepository', $repo);

        $response = $this->call('POST', "api/v1/message/read", $input->toArray());

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->message, "Operation Successful");
    }

    public function testFetchInbox() {
        
    }

}
