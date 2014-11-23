<?php

/**
 * Description of RatingControllerTest
 *
 * @author adekunleadedayo
 */
class RatingControllerTest extends TestCase {

  public function setUp() {
	parent::setUp();
  }

  public function tearDown() {
	Mockery::close();
  }
  public function testBlank() {
	
  }

  /* public function testGetRatingCount() {
    $tutor_id = 30;

    $repo = Mockery::mock('Neartutor\Repository\RatingRepository');
    $repo->shouldReceive('count')->once()->with($tutor_id)->
    andReturn(20);

    App::instance('Neartutor\Repository\RatingRepository', $repo);

    $response = $this->call('GET', "v1/rating/count/{$tutor_id}");

    $this->assertJson($response->getContent());
    $data = json_decode($response->getContent());
    $this->assertEquals($data->status, "success");
    $this->assertEquals($data->count, 20);
    }

    public function testGetRatingAverage() {
    $tutor_id = 30;

    $repo = Mockery::mock('Neartutor\Repository\RatingRepository');
    $repo->shouldReceive('getAverageRating')->once()->with($tutor_id)->
    andReturn(20);

    App::instance('Neartutor\Repository\RatingRepository', $repo);

    $response = $this->call('GET', "v1/rating/average/{$tutor_id}");

    $this->assertJson($response->getContent());
    $data = json_decode($response->getContent());
    $this->assertEquals($data->status, "success");
    $this->assertEquals($data->average, 20);
    }

    public function testGetStarCount() {
    $tutor_id = 30;
    $star = 3;

    $repo = Mockery::mock('Neartutor\Repository\RatingRepository')->makePartial();
    $repo->shouldReceive('getStarCount')->twice()->with($tutor_id, $star)->
    andReturn(20);

    $repo->shouldReceive('count')->once()->with($tutor_id)->
    andReturn(50);

    App::instance('Neartutor\Repository\RatingRepository', $repo);

    $response = $this->call('GET', "v1/rating/star_count/{$tutor_id}/{$star}");

    $this->assertJson($response->getContent());
    $data = json_decode($response->getContent());
    $this->assertEquals($data->status, "success");
    $this->assertEquals($data->info->count, 20);
    $this->assertEquals($data->info->percentage, 40);
    } */
}
