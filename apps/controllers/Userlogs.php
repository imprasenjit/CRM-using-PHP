<?php
defined("BASEPATH") OR exit("No direct script access allowed");
class Userlogs extends Alom {
    
    function __construct() {
        parent::__construct();
        $this->isloggedin();
    }//End of __construct()
    
    function index() {
        $this->load->view("userlogs_view");
    }//End of index()
    
    function getDatatableRecords() {
        $this->load->model("users_model");
        $this->load->model("userlogs_model");
        $columns = array(
            0 => "log_id",
            1 => "uid",
            2 => "login_time",
            3 => "system_info",
            4 => "logout_time",
        );
        $limit = $this->input->post("length");
        $start = $this->input->post("start");
        $order = $columns[$this->input->post("order")[0]["column"]];
        $dir = $this->input->post("order")[0]["dir"];
        $totalData = $this->userlogs_model->tot_rows();
        $totalFiltered = $totalData;
        if (empty($this->input->post("search")["value"])) {
            $records = $this->userlogs_model->all_rows($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post("search")["value"];
            $records = $this->userlogs_model->search_rows($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->userlogs_model->tot_search_rows($search);
        }
        $data = array();
        if (!empty($records)) {
            foreach ($records as $rows) {
                $log_id = $rows->log_id;
                $uid = $rows->uid;
                if($this->users_model->get_row($uid)) {
                    $userRow = $this->users_model->get_row($uid);
                    $user_name = $userRow->user_name;
                    $uname = $userRow->uname;
                } else {
                    $user_name = $uname = "Not found!";
                }
                $login_time = date("d-m-Y h:i A", strtotime($rows->login_time));
                $system_info = $rows->system_info;
                $logout_time = $rows->logout_time;
                if(is_null($logout_time) && $logout_time == "") {
                    $logout_time = "No logout found!";
                } else {
                    $logout_time = date("d-m-Y h:i A", strtotime($rows->logout_time));
                }
                if($uname !== "alom") {
                    $nestedData["log_id"] = sprintf("%05d", $log_id);
                    $nestedData["uid"] = "<a href='".base_url('userlogs/userwise/').$uid."'>$user_name</a>";  
                    $nestedData["login_time"] = $login_time;
                    $nestedData["system_info"] = $system_info;
                    $nestedData["logout_time"] = $logout_time;
                    $data[] = $nestedData;
                }                    
            }
        }
        $json_data = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }//End of getDatatableRecords()
    
    function userwise($id=NULL) {     
        if($this->session->session_utype == 1) {
            $uid = (strlen($id) == 0)?$this->session->session_uid:$id;
        } else {
            $uid = $this->session->session_uid;
        }//End of if else        
        $data = array();
        $this->load->model("users_model");
        $this->load->model("userlogs_model");
        if ($this->userlogs_model->get_userwise($uid)) {
            $data["userlogs"] = $this->userlogs_model->get_userwise($uid);
        }
        $this->load->view("userwiselogs_view", $data);
    }//End of userwise()
    
    function delete() {
        $dt = date("Y-m-d");
        $this->load->model("userlogs_model");
        $nos = $this->userlogs_model->delete_row($dt);
        $this->session->set_flashdata("flashMsg", $nos." record(s) has been successfully deleted!");
        redirect(site_url("userlogs"));
    }// End of delete()
    
    function export() {
        $this->load->helper("directory");
        $this->load->helper("file");
        $dir = "storage/dbs/";
        $files = directory_map($dir);
        foreach($files as $file) {
            if(is_string($file) && $file !="index.html") {
                unlink(FCPATH.$dir.$file);
            }//End of if
        }//End of foreach
        
        $fileName = "db.sql";
        $this->load->dbutil();
        $prefs = array(
            'ignore' => array(),
            'format' => 'txt',
            'filename' => $fileName,
            'add_drop' => TRUE,
            'add_insert' => TRUE,
            'newline' => "\n"
        );
        $backup = $this->dbutil->backup($prefs);
        write_file($dir.$fileName, $backup);
        //echo $fileName;
        echo "<a href='".base_url('storage/dbs/'.$fileName)."'>Donload database</a> ";
    }//End of export()
}//End of Userlogs

