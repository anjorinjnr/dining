<?php

/**
 * Description of SubjectRepositoryTest
 * 
 * DO NOT TEST REPOSITORIES IN PRODUCTION SERVER 
 *
 * @author adekunleadedayo
 */
class SubjectRepositoryTest extends TestCase {

    private $subjectRepository;

    public function setUp() {
        $this->subjectRepository = new \Neartutor\Repository\SubjectRepository();
        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    public function testSubjectCreationSuccess() {
        $input = array("title" => "rextidone");
        $subject = $this->subjectRepository->create($input);

        $this->assertEmpty($this->subjectRepository->errors());
        $this->assertEquals($subject->title, $input['title']);
    }

    public function testSubjectIsNotCreatedIfSubjectAlreadyExists() {
        $this->subjectRepository = new \Neartutor\Repository\SubjectRepository();
        $subject = $this->subjectRepository->create(array("title" => "pentilary"));

        $this->assertEmpty($this->subjectRepository->errors());
        $this->assertEquals($subject->title, "pentilary");

        $existing_subject = $this->subjectRepository->create(array("title" => "pentilary"));
        $this->assertFalse($existing_subject);
        $this->assertNotEmpty($this->subjectRepository->errors());
        $this->assertEquals($this->subjectRepository->error(), "Subject name exists");
    }

    public function testGetSubjectReturnSuccess() {
        
    }

    public function testGetSubjectReturnsNullWhenPassedInvalidID() {
        
    }

    public function testGetSubjectByNameSuccess() {
        
    }

    public function testGetSubjectByNameReturnsNullWhenPassedInvalidName() {
        
    }

    public function testGetAllCategoriesReturnsAllCategoriesIfThereIsNoFilter() {
        
    }

    public function testGetAllCategoriesReturnsCorrectNumberOfCategoriesWhenFilterIsApplied() {
        
    }

    public function testDeleteSubjectSuccess() {
        
    }


}
