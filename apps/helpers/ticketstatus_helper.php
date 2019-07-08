<?php
defined("BASEPATH") OR exit("No direct script access allowed");
if(!function_exists("getstatus")){
    function getstatus($par){
        if($par == 0) {
            $res = "<b style='color:#a4a5a4'>Inactive</b>";
        } elseif($par == 1) {
            $res = "<b style='color:#f44141'>New</b>";
        } elseif($par == 2) {
            $res = "<b style='color:#007bff'>Staff Replied</b>";
        } elseif($par == 3) {
            $res = "<b style='color:#ff9205'>Assigned</b>";
        } elseif($par == 4) {
            $res = "<b style='color:#1cad00'>Customer Replied</b>";
        } elseif($par == 5) {
            $res = "<b style='color:#5a725a'>Closed</b>";
        } else {
            $res = "<b>Undefined</b>";
        }//End of if else
        return $res;
    } // End of getstatus()
} // End of if statement