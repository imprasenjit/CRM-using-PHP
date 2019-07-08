<?php
defined("BASEPATH") OR exit("No direct script access allowed");

if(!function_exists("base64url_encode")){
    function base64url_encode($val) {
        $key = '0242319A1p1456295';
        $encryptedID = base64_encode($val.$key);
        return urlencode($encryptedID);
    }//End of if base64url_encode()
}//End of if statement

if(!function_exists("base64url_decode")){
    function base64url_decode($encryptedID) {
        $key = '0242319A1p1456295';
        $encID = urldecode($encryptedID);
        return preg_replace(sprintf('/%s/', $key), '', base64_decode($encID));
    }//End of if base64url_decode()
}//End of if statement