<?php

use Way\Tests\Factory;

/**
 * Description of SearchControllerTest
 *
 * @author adekunleadedayo
 */
class SearchControllerTest extends TestCase {

    const SORT_LOWEST_PRICE = 1;
    const SORT_HIGHEST_PRICE = 2;
    const SORT_RATING = 3;
    const SORT_BEST_MATCH = 4;

    public function setUp() {
        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    public function testFindTutorsSucceedsWhenTutorIsEmpty() {
        $input = array('subject' => 2);
        $tutors = array();

        $repo = Mockery::mock('Neartutor\Repository\TutorRepository');
        $repo->shouldReceive('getTutorsByBestMatch')->once()->
                andReturn($tutors);

        App::instance('Neartutor\Repository\TutorRepository', $repo);

        $response = $this->call('GET', "v1/search/tutors", $input);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->message, 'Your search returned no result');
    }

    public function testFindTutorsByLowestPrice() {

        $input = array('sort' => self::SORT_LOWEST_PRICE, 'subject' => 2);
        $tutors = array();

        $tut = Mockery::mock('Neartutor\Models\Tutor');
        $tutors[] = Factory::make('Neartutor\Models\Tutor');
        $tutors[] = Factory::make('Neartutor\Models\Tutor');


        $repo = Mockery::mock('Neartutor\Repository\TutorRepository');
        $repo->shouldReceive('getTutorsByLowestPrice')->once()->
                andReturn($tut);
        $tut->shouldReceive('toArray')->andReturn($tutors);

        App::instance('Neartutor\Repository\TutorRepository', $repo);

        $response = $this->call('GET', "v1/search/tutors", $input);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals(count($data->tutors), 2);
    }

    public function testFindTutorsByHighestPrice() {
        $input = array('sort' => self::SORT_HIGHEST_PRICE, 'subject' => 2);
        $tutors = array();

        $tut = Mockery::mock('Neartutor\Models\Tutor');
        $tutors[] = Factory::make('Neartutor\Models\Tutor');
        $tutors[] = Factory::make('Neartutor\Models\Tutor');


        $repo = Mockery::mock('Neartutor\Repository\TutorRepository');
        $repo->shouldReceive('getTutorsByHighestPrice')->once()->
                andReturn($tut);
        $tut->shouldReceive('toArray')->andReturn($tutors);

        App::instance('Neartutor\Repository\TutorRepository', $repo);

        $response = $this->call('GET', "v1/search/tutors", $input);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals(count($data->tutors), 2);
    }

    public function testFindTutorByRating() {
        $input = array('sort' => self::SORT_RATING, 'subject' => 2);
        $tutors = array();

        $tut = Mockery::mock('Neartutor\Models\Tutor');
        $tutors[] = Factory::make('Neartutor\Models\Tutor');
        $tutors[] = Factory::make('Neartutor\Models\Tutor');


        $repo = Mockery::mock('Neartutor\Repository\TutorRepository');
        $repo->shouldReceive('getTutorsByHighestRating')->once()->
                andReturn($tut);
        $tut->shouldReceive('toArray')->andReturn($tutors);

        App::instance('Neartutor\Repository\TutorRepository', $repo);

        $response = $this->call('GET', "v1/search/tutors", $input);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals(count($data->tutors), 2);
    }

    public function testFindTutorByBestMatch() {
        $input = array('sort' => self::SORT_BEST_MATCH, 'subject' => 2);
        $tutors = array();

        $tut = Mockery::mock('Neartutor\Models\Tutor');
        $tutors[] = Factory::make('Neartutor\Models\Tutor');
        $tutors[] = Factory::make('Neartutor\Models\Tutor');


        $repo = Mockery::mock('Neartutor\Repository\TutorRepository');
        $repo->shouldReceive('getTutorsByBestMatch')->once()->
                andReturn($tut);
        $tut->shouldReceive('toArray')->andReturn($tutors);

        App::instance('Neartutor\Repository\TutorRepository', $repo);

        $response = $this->call('GET', "v1/search/tutors", $input);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals(count($data->tutors), 2);
    }

}
