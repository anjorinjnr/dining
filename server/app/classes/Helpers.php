<?php

/**
 * Description of Helpers
 *
 * @author kayfun
 */
class Helpers {

    use \Neartutor\Traits\Location;

    public static function getHours() {
        $hours = array(12);
        for ($i = 1; $i <= 11; $i++) {
            $hours[] = $i;
        }

        return $hours;
    }

    public static function getMinutes() {
        $minutes = array();
        for ($i = 0; $i < 60; $i = $i + 5) {
            if ($i < 10) {
                $i = '0' . $i;
            }
            $minutes[] = $i;
        }
        return $minutes;
    }

    public static function generateTempPassword($length) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }

}
