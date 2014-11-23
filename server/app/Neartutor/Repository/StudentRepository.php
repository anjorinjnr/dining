<?php

namespace Neartutor\Repository;

use Neartutor\Models\Student;

class StudentRepository extends Repository {

    /**
     * 
     * @param Array $data
     * @return \Neartutor\Models\Student
     */
    public function create($data) {
        $student = Student::create($data);
        return($this->get($student->id));
    }

    /**
     * 
     * @param int $id
     * @return  \Neartutor\Models\Student
     */
    public function get($id) {
        return Student::with('user')->find($id);
    }

    public function delete($id) {
        
    }

    public function all() {
        
    }

    public function update($data) {
        
    }

}
