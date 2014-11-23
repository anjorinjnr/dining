<?php

namespace Chefme\Repository;

use Chefme\Models\Subject;

class SubjectRepository extends Repository {

    public function create($data) {
        $subject = $this->getSubjectByName($data['title']);
        return ($subject) ? $subject : Subject::create($data);
    }

    public function get($id) {
        $subject = Subject::where('id', $id)->with('categories')->first();
        return $subject;
    }

    public function getSubjectByName($name) {
        $subject = Subject::where('title', $name)->first();
        return $subject;
    }

    public function all($filter) {
        $subjects = null;
        if (is_null($filter)) {
            $subjects = Subject::approved()->select('id', 'title')->with('categories')->get();
        } else {
            $subjects = Subject::approved()->select('id', 'title')->with('categories')->where('title', 'like', "%{$filter}%")->get();
        }

        return $subjects;
    }

    public function delete($id) {
        $subject = Subject::find($id);
        if ($subject) {
            return $subject->delete();
        }
    }

    public function update($data) {
        
    }

}
