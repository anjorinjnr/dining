<?php

namespace Chefme\Repository;

use Chefme\Models\Category;
use Chefme\Models\Subject;
use Chefme\Models\SubjectCategory;

class CategoryRepository extends Repository {

    public function create($data) {
        if ($this->getCategoryByName($data['category_name'])) {
            $this->addError("Category name exists");
            return false;
        }
        $category = Category::create($data);
        return $category;
    }

    public function get($id) {
        $category = Category::where('id', $id)->first();
        return $category;
    }

    public function addSubject($subject_id, $category_id) {
        $subject = Subject::where('id', $subject_id)->first();
        if (!$subject) {
            $this->addError("No subject with specified ID");
            return false;
        }

        $category = $this->get($category_id);
        if (!$category) {
            $this->addError("No category with specified ID");
            return false;
        }

        SubjectCategory::create(compact("subject_id", "category_id"));
    }

    public function getCategoryByName($name) {
        $category = Category::where('category_name', $name)->first();
        return $category;
    }

    public function all() {
        $categories = Category::all();
        return $categories;
    }

    public function delete($id) {
        $category = Category::find($id);
        if ($category) {
            return $category->delete();
        }
    }

    public function getSubjects($id) {
        $category = Category::find($id);
        if ($category) {
            return Category::find($id)->subjects;
        }
        return [];
    }

    public function update($data, $id) {
        
    }

}
