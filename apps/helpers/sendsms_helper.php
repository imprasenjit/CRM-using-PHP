<?php
defined("BASEPATH") OR exit("No direct script access allowed");
if(!function_exists("sendsms")){
    function sendsms($no, $sms) {
        if (is_numeric($no) && strlen($no) == 10) {
            $res = file_get_contents("http://103.8.249.55/smsgwam/form_/send_api_edb_get.php?username=edbgov&password=edbdb@123&groupname=EDBGOV&to=$no&msg=".urlencode($sms));
            if ($res) {
                $file = FCPATH.'storage/logs/sms.txt';
                $write_text = PHP_EOL . "DATETIME : " . date("d-m-Y H:i:s") . "  Mobile Number : " . $no . "   Message : " . $sms . PHP_EOL;
                file_put_contents($file, $write_text, FILE_APPEND | LOCK_EX);
                return 1;
            }
        } else {
            //die("Invalid number");
            return 0;
        }//End of if else
    }//End of sendsms
} // End of if statement