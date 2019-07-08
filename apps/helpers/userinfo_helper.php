<?php
defined("BASEPATH") OR exit("No direct script access allowed");
if(!function_exists("infos")){
    function infos(){
        $ci =& get_instance();
        $ci->load->library('user_agent');
        if ($ci->agent->is_browser()) {
            $agent = $ci->agent->browser() . ' ' . $ci->agent->version();
        } elseif ($ci->agent->is_robot()) {
            $agent = $ci->agent->robot();
        } elseif ($ci->agent->is_mobile()) {
            $agent = $ci->agent->mobile();
        } else {
            $agent = 'Unidentified';
        }
        return $ci->agent->platform().", ".$agent; 
    } // End of infos
} // End of if statement