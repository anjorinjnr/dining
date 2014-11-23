<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Neartutor\Controllers;

/**
 * Description of LocationController
 *
 * @author eanjorin
 */
use Neartutor\Repository\LocationRepository;
use Neartutor\Models\State;
use Neartutor\Models\Town;

class LocationController extends BaseController {

    //put your code here

    private $locRepo;

    public function __construct(LocationRepository $locRepo) {
	    parent::__construct();
        $this->locRepo = $locRepo;
    }

    public function states() {
        return $this->locRepo->states()->toJson();
    }

    public function townsInState(State $state) {
        // Why does it work without toJson?
        return $state->towns()->get()->toJson();
    }

    public function areasInTown(Town $town) {
        return $town->areas()->get()->toJson();
    }

}
