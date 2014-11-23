<?php

namespace Neartutor\Controllers;

use Jenssegers\Date\Date;

class RandomController extends BaseController {

    public function pageSummary() {
        $metric = \Input::get('metric');
        $startdate = \Input::get('startdate');
        $enddate = \Input::get('enddate');

        $count = rand(1, 500000);
        $data = compact("metric", "startdate", "enddate", "count");

        return $this->json($data);
    }

    public function pageDSummary() {
        $data = $pageviews = array();

        for ($i = 0; $i < 10; $i++) {
            $pageviews[$i] = rand(1, 5000);
        }
        $total_pageviews = array_sum($pageviews);

        for ($i = 0; $i < 10; $i++) {
            $page['"url"'] =  self::generateTempPassword(rand(4, 7)) . ".html";
            $page['"pageviews"'] = $pageviews[$i];
            $page['"pageviews_percent"'] = (int) (($pageviews[$i] / $total_pageviews) * 100);

            $data[] = $page;
        }

        //self::aasort($pages, "pageviews");
        $metric = \Input::get('metric');
        $startdate = \Input::get('startdate');
        $enddate = \Input::get('enddate');

        $result = compact("metric", "startdate", "enddate", "data");
        return $this->json($result);
    }

    public function pageOverview() {
        $categories = array();
        $data = array();

        $date = Date::now();
        for ($i = 0; $i < 30; $i++) {
            $categories[] = $date->format("j F");
            /* if ($i % 3 == 0) {
              $categories[] = $date->format("j F");
              } else {
              $categories[] = "";
              } */

            $data[] = rand(0, 1000);

            $date = $date->add('1 day');
        }

        $metric = \Input::get('metric');
        $startdate = \Input::get('startdate');
        $enddate = \Input::get('enddate');

        $r = compact("metric", "startdate", "enddate", "categories", "data");
        return $this->json($r);
    }

    public static function generateTempPassword($length) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }

    static function aasort(&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }
        $array = $ret;
    }

}
