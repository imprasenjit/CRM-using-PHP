<?php
defined("BASEPATH") OR exit("No direct script access allowed");
class Settings extends Alom {
    function index() {
        $this->isloggedin();
        $this->isadmin();
        $this->load->model("users_model");
        $this->load->model("settings_model"); //die("Default : ".$this->settings_model->getdefultusr());        
        $this->load->view("settings_view");
    }//End of index()
    
    function save() {
        $this->isloggedin();
        $this->isadmin();
        $setting_id = $this->input->post("setting_id");         
        $this->load->model("settings_model");
        $this->load->library("form_validation");
        $this->form_validation->set_rules("assigneduser", "User", "required|greater_than[0]");
        $this->form_validation->set_error_delimiters("<font class='error animated fadeIn'>", "</font>");
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("flashMsg", "Invalid inputs");
            $this->index();
        } else {            
            $assigneduser = $this->security->xss_clean($this->input->post("assigneduser"));
            $data = array("assigneduser" => $assigneduser);
            $this->settings_model->edit_row($setting_id, $data);
            $msg = "Settings has been successfully updated!";
            $this->session->set_flashdata("flashMsg", $msg);
            redirect(site_url("settings"));
        }
    }//End of save()
}//End of Settings