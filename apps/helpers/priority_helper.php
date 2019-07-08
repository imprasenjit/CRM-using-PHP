<?php
defined("BASEPATH") OR exit("No direct script access allowed");
if(!function_exists("getpriority")){
    function getpriority($par){
        if($par == 1) {
            $res = "<b style='color:#ff4221'>High</b>";
        } elseif($par == 2) {
            $res = "<b style='color:#1fc127'>Medium</b>";
        } elseif($par == 3) {
            $res = "<b style='color:#86888c'>Low</b>";
        } else {
            $res = "<b style='color:#444'>Undefined</b>";
        }//End of if else
        return $res;
    } // End of getpriority()
} // End of if statement