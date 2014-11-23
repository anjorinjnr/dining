<?php

namespace Chefme\Controllers\Tutor;

use Chefme\Repository\SubjectRepository;
use Chefme\Repository\TutorRepository;
use Chefme\Validators\Tutor\SubjectValidator;

class SubjectController extends \BaseController {

    private $subjectRepository;
    private $tutorRepository;

    public function __construct(SubjectRepository $subjectRepository, TutorRepository $tutorRepository) {
        $this->subjectRepository = $subjectRepository;
        $this->tutorRepository = $tutorRepository;
    }

    public function create() {
        $validator = new SubjectValidator(\Input::all());

        if (!$validator->passes()) {
            return $this->json(array('status' => 'error',
                        'errors' => $validator->getValidator()->messages()->all()));
        }
        
        $data = $validator->getData();
        
        if (is_int($data['subject'])) {
            $subject_id = $data['subject'];
        } else {
            // If tutor is attempting to  
            $subject = $this->subjectRepository->create(array('subject' => $data['subject']));
            if ($subject) {
                $subject_id = $subject->id;
            } else {
                return $this->json(array('status' => 'error',
                            'error' => $this->subjectRepository->errors()));
            }
        }

        if ($data['supporting_document']) {
            $supporting_document = $this->addSupportingDocument();
            if (!$supporting_document) {
                return $this->json(array('status' => 'error',
                            'error' => 'File upload error occured'));
            }
            $data['supporting_document'] = $supporting_document;
        }

        $data['subject_id'] = $subject_id;
        if ($this->tutorRepository->addSubject($data)) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }

    private function addSupportingDocument() {
        try {
            $file = \Input::file('supporting_document');
            $destinationPath = '/upload/';
            $filename = $file->getClientOriginalName();
            $file->move(public_path() . $destinationPath, $filename);

            return $destinationPath . $filename;
        } catch (Exception $ex) {
            return false;
        }
    }

}
