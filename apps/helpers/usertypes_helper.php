<?php
defined("BASEPATH") OR exit("No direct script access allowed");
if(!function_exists("getgender")){
    function getusertype($par){
        if ($par ==1) {
            $val = "Superuser";
        } elseif ($par == 2){
            $val = "Staff";
        } elseif ($par == 3) {
            $val = "CCE";
        } elseif ($par == 4) {
            $val = "Departments";
        } elseif ($par == 5) {
            $val = "Other";
        } else {
            $val = "Select";
        }
        return $val;
    } // End of getusertype()
} // End of if statement