<?php
defined("BASEPATH") OR exit("No direct script access allowed");
if(!function_exists("getprocesstype")){
    function getprocesstype($par){
        if($par == 0) {
            $res = "Inactive";
        } elseif($par == 1) {
            $res = "Active";
        } elseif($par == 2) {
            $res = "EODB Action";
        }  elseif($par == 3) {
            $res = "Assigned";
        } elseif($par == 4) {
            $res = "Comment";
        } elseif($par == 5) {
            $res = "Customer";
        } elseif($par == 6) {
            $res = "Mail";
        } else {
            $res = "Undefined";
        }//End of if else
        return $res;
    } // End of getprocesstype()
} // End of if statement
