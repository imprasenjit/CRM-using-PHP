<?php
defined("BASEPATH") OR exit("No direct script access allowed");
if(!function_exists("getgender")){
    function getgender($par){
        if ($par ==1) {
            $val = "Male";
        } elseif ($par == 2){
            $val = "Female";
        } elseif ($par == 3) {
            $val = "Other";
        } else {
            $val = "Select";
        }
        return $val;
    } // End of getgender()
} // End of if statement