<?php

use Way\Tests\Factory;

/**
 * Description of CategoryControllerTest
 *
 * @author adekunleadedayo
 */
class CategoryControllerTest extends TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    public function testGetAllCategories() {
        $cat = Mockery::mock('Neartutor\Models\Category');

        $category1 = Factory::make('Neartutor\Models\Category');
        $category2 = Factory::make('Neartutor\Models\Category');
        $repo = Mockery::mock('Neartutor\Repository\CategoryRepository');
        App::instance('Neartutor\Repository\CategoryRepository', $repo);

        $categories = compact("category1", "category2");
        $repo->shouldReceive('all')->andReturn($cat);
        $cat->shouldReceive('toArray')->andReturn($categories);
        $response = $this->call('GET', "v1/category");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertCount(2, (array) $data->categories);
    }

    public function testGetCategoryGivenInvalidId() {
        $id = 15;

        $repo = Mockery::mock('Neartutor\Repository\CategoryRepository');
        $repo->shouldReceive('get')->once()->with($id)->andReturn(null);
        App::instance('Neartutor\Repository\CategoryRepository', $repo);

        $response = $this->call('GET', "v1/category/{$id}");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertContains("No category with ID {$id}", $data->errors);
        // $this->assertEquals($data->message, "No category with ID {$id}");
    }

    public function testGetCategorySuccess() {
        $id = 15;

        $category = Factory::make('Neartutor\Models\Category', ['id' => $id]);
        $repo = Mockery::mock('Neartutor\Repository\CategoryRepository');
        $repo->shouldReceive('get')->once()->with($id)->andReturn($category);
        App::instance('Neartutor\Repository\CategoryRepository', $repo);

        $response = $this->call('GET', "v1/category/{$id}");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->category->id, $id);
    }

    public function testGetSubjects() {
        $sub = Mockery::Mock('Neartutor\Models\Subject');
        $subject1 = Factory::make('Neartutor\Models\Subject');
        $subject2 = Factory::make('Neartutor\Models\Subject');
        $repo = Mockery::mock('Neartutor\Repository\CategoryRepository');
        App::instance('Neartutor\Repository\CategoryRepository', $repo);

        $subjects = compact("subject1", "subject2");

        $repo->shouldReceive('getSubjects')->andReturn($sub);
        $sub->shouldReceive('toArray')->andReturn($subjects);

        $response = $this->call('GET', "v1/category/15/subject");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertCount(2, (array) $data->subjects);
    }

    public function testGetSubjectsWithEmptyList() {
        $repo = Mockery::mock('Neartutor\Repository\CategoryRepository');
        App::instance('Neartutor\Repository\CategoryRepository', $repo);

        $repo->shouldReceive('getSubjects')->andReturn(array());
        $response = $this->call('GET', "v1/category/15/subject");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertCount(0, $data->subjects);
    }

    public function testAddSubjectSuccess() {
        $repo = Mockery::mock('Neartutor\Repository\CategoryRepository');
        App::instance('Neartutor\Repository\CategoryRepository', $repo);


        $input = array("subject_id" => 1, "category_id" => 2);
        $repo->shouldReceive('addSubject')->andReturn(true);
        $repo->shouldReceive('errors')->andReturn(array());
        $response = $this->call('POST', "v1/category/subject", $input);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals("Subject has been added to category", $data->message);
    }

    public function testAddSubjectWithError() {
        $repo = Mockery::mock('Neartutor\Repository\CategoryRepository');
        App::instance('Neartutor\Repository\CategoryRepository', $repo);


        $input = array("subject_id" => 1, "category_id" => 2);
        $repo->shouldReceive('addSubject')->andReturn(true);
        $repo->shouldReceive('errors')->andReturn(array("An error occured"));
        $response = $this->call('POST', "v1/category/subject", $input);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertContains("An error occured", $data->errors);
        // $this->assertEquals("Subject has been added to category", $data->message);
    }

    public function testAddCategoryWithValidationError() {
        $data['category_name'] = '';

        $repo = Mockery::mock('Neartutor\Repository\CategoryRepository');
        $repo->shouldReceive('create')->never();
        App::instance('Neartutor\Repository\CategoryRepository', $repo);

        $response = $this->call('POST', "v1/category", $data);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertContains('The category name field is required.', (array) $data->errors);
    }

    public function testAddCategorySuccess() {
        $data['category_name'] = 'hello';

        $category = Factory::make('Neartutor\Models\Category', ['id' => 20]);
        $repo = Mockery::mock('Neartutor\Repository\CategoryRepository');
        $repo->shouldReceive('create')->once()->andReturn($category);

        App::instance('Neartutor\Repository\CategoryRepository', $repo);

        $response = $this->call('POST', "v1/category", $data);

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->category->id, $category->id);
    }

    public function testDeleteCategoryError() {
        $id = 15;

        $repo = Mockery::mock('Neartutor\Repository\CategoryRepository');
        $repo->shouldReceive('delete')->once()->with($id)->andReturn(false);
        App::instance('Neartutor\Repository\CategoryRepository', $repo);

        $response = $this->call('GET', "v1/category/{$id}/delete");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "error");
        $this->assertContains("An error occured", $data->errors);
        //$this->assertEquals($data->message, "An error occured");
    }

    public function testDeleteCategorySuccess() {
        $id = 15;

        $repo = Mockery::mock('Neartutor\Repository\CategoryRepository');
        $repo->shouldReceive('delete')->once()->with($id)->andReturn(true);
        App::instance('Neartutor\Repository\CategoryRepository', $repo);

        $response = $this->call('GET', "v1/category/{$id}/delete");

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent());
        $this->assertEquals($data->status, "success");
        $this->assertEquals($data->id, $id);
    }

}
