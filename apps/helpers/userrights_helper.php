<?php
defined("BASEPATH") OR exit("No direct script access allowed");
if(!function_exists("isRight")){
    function isRight($par){
        $ci =& get_instance();
        $session_rights = $ci->session->session_rights;
        if(strlen($session_rights) > 0) {
            $rights = explode(",", $session_rights);
            return in_array($par, $rights)?TRUE:FALSE;
        } else {
            return FALSE;
        }//End of if else
    }//End of isRight()
}//End of if statement