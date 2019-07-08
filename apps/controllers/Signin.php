<?php
defined("BASEPATH") OR exit("No direct script access allowed");
class Signin extends CI_Controller {
    function index(){
        $this->load->view("signin_view");
    } //End of index()
    
    function process(){
        $this->load->library("form_validation");
        $this->form_validation->set_rules("uname", "Username", "required");
        $this->form_validation->set_rules("pass", "Password", "required");        
        $this->form_validation->set_error_delimiters("<font class='error animated fadeIn'>", "</font>");      
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("flashMsg", "Invalid/Empty Input fields!");
            $this->index();
        } else {
            $uname = $this->security->xss_clean($this->input->post("uname"));
            $pass = $this->security->xss_clean($this->input->post("pass"));
            $this->load->model("signin_model");
            if($this->signin_model->process($uname, $pass)) {
                $welcome = "Welcome Mr. ".$this->session->userdata("session_username")."!";
                $this->session->set_flashdata("flashMsg", $welcome);
                redirect(site_url("welcome"));
            } else {
                $this->session->set_flashdata("flashMsg", "Invalid Username or Password!");
                redirect(site_url("signin"));
            }
        } // End of if else
    } //End of process()
    
    function logout(){
        if($this->session->userdata("session_login")){
            $log_id = $this->session->userdata("session_logid");
            $this->load->model("signin_model");
            $this->signin_model->logsupdate($log_id);
        }
        $this->session->unset_userdata("session_uid");
        $this->session->unset_userdata("session_username");
        $this->session->unset_userdata("session_uname");
        $this->session->unset_userdata("session_utype");
        $this->session->unset_userdata("session_rights");
        $this->session->unset_userdata("session_logid");
        $this->session->unset_userdata("session_login");
        $this->session->set_flashdata("flashMsg", "You have successfully logout!");
        redirect(site_url("signin"));
    } //End of logout()
}//End of Signin