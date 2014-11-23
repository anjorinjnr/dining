<?php

/**
 * Description of LocationControllerTest
 *
 * @author adekunleadedayo
 */
class LocationControllerTest extends TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    public function testGetStates() {
        $response = $this->call('GET', "v1/location/state");
        $this->assertJson($response->getContent());
    }

    public function testGetTowns() {
        $response = $this->call('GET', "v1/location/state/1/towns");
        $this->assertJson($response->getContent());
    }

    public function testGetAreas() {
        $response = $this->call('GET', "v1/location/town/1/areas");
        $this->assertJson($response->getContent());
    }

}
