<?php

use Way\Tests\Factory;

/**
 * Description of ContractControllerTest
 *
 * @author adekunleadedayo
 */
class ContractControllerTest extends TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    public function testContractIsCreated() {
        $id = 15;

        $repo = Mockery::mock('Neartutor\Repository\CategoryRepository');
        $repo->shouldReceive('delete')->once()->with($id)->andReturn(true);
        App::instance('Neartutor\Repository\CategoryRepository', $repo);

        $response = $this->call('POST', "api/v1/contract");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->id, $id);
    }

}
