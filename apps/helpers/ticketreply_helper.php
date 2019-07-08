<?php
defined("BASEPATH") OR exit("No direct script access allowed");
if (!function_exists("reply_ticket")) {
    function reply_ticket($ticket_no, $msg, $process_by=NULL, $process_file=NULL) {
        $ci = & get_instance();
        $ptype = (strlen($process_by) > 4)?6:5;
        $nowTime = date("Y-m-d H:i:s");
        $ci->load->model("supports_model");
        $ci->load->model("supportprocess_model");
        if ($ci->supports_model->get_trackrow($ticket_no)) {
            $support_id = $ci->supports_model->get_trackrow($ticket_no)->support_id;
            $data = array(
                "support_id" => $support_id,
                "process_time" => $nowTime,
                "processed_bymail" => $process_by,
                "process_msg" => $msg,
                "process_file" => $process_file,
                "process_type" => $ptype
            );
            $ci->supports_model->edit_row($support_id, array("support_status"=>4));
            $ci->supportprocess_model->add_row($data);
            return "Data has been successfully submitted!";
        } else {
            return "Something went wrong!";
        }//End of if else
    }//End of reply_ticket()
}//End of if

