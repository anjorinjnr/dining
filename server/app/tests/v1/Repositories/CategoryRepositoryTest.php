<?php
use Way\Tests\Factory;
/**
 * Description of CategoryRepositoryTest
 * 
 * DO NOT TEST REPOSITORIES IN PRODUCTION SERVER 
 *
 * @author adekunleadedayo
 */
class CategoryRepositoryTest extends TestCase {

    private $categoryRepository;

    public function setUp() {
        $this->categoryRepository = new \Neartutor\Repository\CategoryRepository();
        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    public function testCategoryCreationSuccess() {
        $input = array("category_name" => "rextidone");
        $category = $this->categoryRepository->create($input);

        $this->assertEmpty($this->categoryRepository->errors());
        $this->assertEquals($category->category_name, $input['category_name']);
    }

    public function testCategoryIsNotCreatedIfCategoryAlreadyExists() {
        $this->categoryRepository = new \Neartutor\Repository\CategoryRepository();
        $category = $this->categoryRepository->create(array("category_name" => "pentilary"));

        $this->assertEmpty($this->categoryRepository->errors());
        $this->assertEquals($category->category_name, "pentilary");

        $existing_category = $this->categoryRepository->create(array("category_name" => "pentilary"));
        $this->assertFalse($existing_category);
        $this->assertNotEmpty($this->categoryRepository->errors());
        $this->assertEquals($this->categoryRepository->error(), "Category name exists");
    }

    public function testGetCategoryReturnSuccess() {
        
    }

    public function testGetCategoryReturnsNullWhenPassedInvalidID() {
        
    }

    public function testGetCategoryByNameSuccess() {
        
    }

    public function testGetCategoryByNameReturnsNullWhenPassedInvalidName() {
        
    }

    public function testGetAllCategoriesReturnsAllCategories() {
        
    }

    public function testGetAllCategoriesReturnsEmptyArrayWhenCategoryTableIsEmpty() {
        
    }

    public function testDeleteCategorySuccess() {
        
    }

    public function testAddSubjectFailsWhenInvalidSubjectIDIsPassed() {
        
    }

    public function testAddSubjectFailsWhenInvalidCategoryIDIsPassed() {
        
    }

    public function testAddSubjectSuccess() {
        
    }

    public function getTestSubjectsSuccess() {
        
    }

}
