<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
class Ticketsclose extends Alom {
    
    function __construct() {
        parent::__construct();
        $this->isloggedin();
    }//End of __construct()
    
    function index() {
        $this->load->view("ticketsclose_view");
    }//End of index()

    function getRecords() {
        $this->load->model("ticketsclose_model");
        $this->load->model("querytypes_model");
        $this->load->model("users_model");
        $this->load->helper("ticketstatus");
        $this->load->helper("text");
        $columns = array(
            0 => "support_time",
            1 => "cname",
            2 => "query_type",
            3 => "uid",
            4 => "support_status"
        );
        $limit = $this->input->post("length");
        $start = $this->input->post("start");
        $order = $columns[$this->input->post("order")[0]["column"]];
        $dir = $this->input->post("order")[0]["dir"];
        $totalData = $this->ticketsclose_model->tot_rows();
        $totalFiltered = $totalData;
        if (empty($this->input->post("search")["value"])) {
            $records = $this->ticketsclose_model->all_rows($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post("search")["value"];
            $records = $this->ticketsclose_model->search_rows($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->ticketsclose_model->tot_search_rows($search);
        }
        $data = array();
        if (!empty($records)) {
            foreach ($records as $rows) {
                $support_id = $rows->support_id;
                $cname = $rows->cname;
                $support_time = date("d/m/Y H:i", strtotime($rows->support_time));
                $query_type = $rows->query_type;
                $qtype = ($this->querytypes_model->get_row($query_type)) ? $this->querytypes_model->get_row($query_type)->qtype_name : "Not found";
                $qtyp = '<a id="' . $support_id . '" data-toggle="modal" data-target="#supportviewModal" href="javascript:void(0)">' . word_limiter($qtype, 3) . '</a>';
                $uid = $rows->uid;
                $assignto = ($this->users_model->get_row($uid))?$this->users_model->get_row($uid)->user_name:"Not found!";
                $status = getstatus($rows->support_status);
            
                $nestedData["support_time"] = $support_time;
                $nestedData["cname"] = word_limiter($cname, 3);
                $nestedData["query_type"] = $qtyp;
                $nestedData["uid"] = word_limiter($assignto, 3);
                $nestedData["support_status"] = $status;
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }//End of getRecords()

    function getUserRecords() {
        $uid = $this->session->userdata("session_uid");
        $this->load->model("ticketsclose_model");
        $this->load->model("querytypes_model");
        $this->load->model("users_model");
        $this->load->helper("ticketstatus");
        $this->load->helper("text");
        $columns = array(
            0 => "support_time",
            1 => "cname",
            2 => "query_type",
            3 => "uid",
            4 => "support_status"
        );
        $limit = $this->input->post("length");
        $start = $this->input->post("start");
        $order = $columns[$this->input->post("order")[0]["column"]];
        $dir = $this->input->post("order")[0]["dir"];
        $totalData = $this->ticketsclose_model->tot_userrows($uid);
        $totalFiltered = $totalData;
        if (empty($this->input->post("search")["value"])) {
            $records = $this->ticketsclose_model->all_userrows($uid, $limit, $start, $order, $dir);
        } else {
            $search = $this->input->post("search")["value"];
            $records = $this->ticketsclose_model->search_userrows($uid, $limit, $start, $search, $order, $dir);
            $totalFiltered = $this->ticketsclose_model->tot_search_userrows($uid, $search);
        }
        $data = array();
        if (!empty($records)) {
            foreach ($records as $rows) {
                $support_id = $rows->support_id;
                $cname = $rows->cname;
                $support_time = date("d/m/Y H:i", strtotime($rows->support_time));
                $query_type = $rows->query_type;
                $qtype = ($this->querytypes_model->get_row($query_type)) ? $this->querytypes_model->get_row($query_type)->qtype_name : "Not found";
                $qtyp = '<a id="' . $support_id . '" data-toggle="modal" data-target="#supportviewModal" href="javascript:void(0)">' . word_limiter($qtype, 3) . '</a>';
                $uid = $rows->uid;
                $assignto = ($this->users_model->get_row($uid))?$this->users_model->get_row($uid)->user_name:"Not found!";
                $status = getstatus($rows->support_status);
            
                $nestedData["support_time"] = $support_time;
                $nestedData["cname"] = word_limiter($cname, 3);
                $nestedData["query_type"] = $qtyp;
                $nestedData["uid"] = $assignto;
                $nestedData["support_status"] = $status;
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }//End of getUserRecords()
}//End of Ticketsclose
