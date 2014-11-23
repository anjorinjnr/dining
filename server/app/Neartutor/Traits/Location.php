<?php

namespace Neartutor\Traits;

/**
 *  Functions to return Location details like towns, areas 
 * author: ebby@neartutors.com
 */
trait Location {

    public function getTowns($stateId) {
        return \Illuminate\Support\Facades\DB::table('towns')->where('state_id', $stateId)->get();
    }

    public function getAreas($townId) {
        return \Illuminate\Support\Facades\DB::table('areas')->where('town_id', $townId)->get();
    }

    public function getStates() {
        return array(
            "1" => "Abia",
            "2" => "Adamawa",
            "3" => "Akwa Ibom",
            "4" => "Anambra",
            "5" => "Bauchi",
            "6" => "Bayelsa",
            "7" => "Benue",
            "8" => "Borno",
            "9" => "Cross River",
            "10" => "Delta",
            "11" => "Ebonyi",
            "12" => "Edo",
            "13" => "Ekiti",
            "14" => "Enugu",
            "15" => "FCT",
            "16" => "Gombe",
            "17" => "Imo",
            "18" => "Jigawa",
            "19" => "Kaduna",
            "20" => "Kano",
            "21" => "katsina",
            "22" => "Kebbi",
            "23" => "Kogi",
            "24" => "Kwara",
            "25" => "Lagos",
            "26" => "Nasarawa",
            "27" => "Niger",
            "28" => "Ogun",
            "29" => "Ondo",
            "30" => "Osun",
            "31" => "Oyo",
            "32" => "Plateau",
            "33" => "Rivers",
            "34" => "Sokoto",
            "35" => "Taraba",
            "36" => "Yobe",
            "37" => "Zamfara",
        );
    }

}
