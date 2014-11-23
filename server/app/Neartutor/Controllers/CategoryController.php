<?php

namespace Neartutor\Controllers;

use Neartutor\Repository\CategoryRepository;
use Neartutor\Validators\CategoryValidator;

class CategoryController extends BaseController {

    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function all() {
        $categories = $this->categoryRepository->all();
        return $this->json($categories->toArray());
    }

    public function get($id) {
        $category = $this->categoryRepository->get($id);
        if ($category) {
            return $this->json(array("status" => "success", "category" => $category->toArray()));
        } else {
            return $this->json(array("status" => "error", "errors" => array("No category with ID {$id}")));
        }
    }

    public function getSubjects($category_id) {
        $subjects = $this->categoryRepository->getSubjects($category_id);
        if ($subjects) {
            return $this->json(array("status" => "success", "subjects" => $subjects->toArray()));
        }
        return $this->json(array("status" => "success", "subjects" => array()));
    }

    public function addSubject() {
        $data = \Input::all();
        if (!isset($data['subject_id']) || !isset($data['category_id'])) {
            return $this->json(array("status" => "error", "errors" => array("Subject and Category IDs required")));
        }

        $subject_id = $data['subject_id'];
        $category_id = $data['category_id'];

        $this->categoryRepository->addSubject($subject_id, $category_id);
        if ($this->categoryRepository->errors()) {
            return $this->json(array("status" => "error", "errors" => $this->categoryRepository->errors()));
        }
        return $this->json(array("status" => "success", "message" => "Subject has been added to category"));
    }

    public function create() {

        $input = \Input::all();
        $validator = new CategoryValidator($input);

        if (!$validator->passes()) {
            return $this->json(array('status' => 'error',
                        'errors' => $validator->getValidator()->messages()->all()));
        }

        $data = $validator->getData();
        /**
         * @todo Apply trimming to subject also 
         */
        $data['category_name'] = trim($data['category_name']);
        $category = $this->categoryRepository->create($data);
        return $this->json(array("status" => "success", "category" => $category->toArray()));
    }

    public function delete($id) {
        if ($this->categoryRepository->delete($id)) {
            return json_encode(array("status" => "success", "id" => $id));
        } else {
            return $this->errorResponse();
        }
    }

}
