<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
class Ticketsmarked extends Alom {
    
    function __construct() {
        parent::__construct();
        $this->isloggedin();
    }//End of __construct()
    
    function index() {
        $sid = $this->session->session_uid;
        $data = array();
        $myTickets = array();
        $this->load->model("supports_model");
        $this->load->model("querytypes_model");
        if($this->supports_model->get_rows()) {
            foreach ($this->supports_model->get_rows() as $rows) {
                $support_id = $rows->support_id;
                $cname = $rows->cname;
                $support_time = date("d-m-Y h:i A", strtotime($rows->support_time));
                $email = $rows->email;
                $query = $rows->query;
                $query_type = $rows->query_type;
                $mark_to = $rows->mark_to;

                if (strlen($mark_to) > 0) {
                    $markto = explode(",", $mark_to);
                    if(in_array($sid, $markto)) {
                        $arr = array(
                            "support_id" => $support_id,
                            "cname" => $cname,
                            "email" => $email,
                            "query" => $query,
                            "query_type" => $query_type,
                            "support_time" => $support_time
                        );
                        array_push($myTickets, $arr);
                    }//End of if
                }//End of if
            }//End of foreach
            $data["tickets"] = $myTickets;
        }//End of if
        $this->load->view("ticketsmarked_view", $data);
    }//End of index()
}//End of Ticketsmarked

