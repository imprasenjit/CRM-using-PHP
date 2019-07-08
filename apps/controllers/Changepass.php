<?php
defined("BASEPATH") OR exit("No direct script access allowed");
class Changepass extends Alom {
    function index($id=NULL) {
        $this->isloggedin();
        $uid = $this->session->userdata("session_uid");
        $this->load->model("users_model");
        $data["profile"] = $this->users_model->get_row($uid);
        $this->load->view("changepass_view", $data);
    }//End of index()
    
    function save() {
        $this->isloggedin();
        $this->load->library("form_validation");
        $this->form_validation->set_rules("newpass", "Pasword", "required|min_length[4]");
        $this->form_validation->set_rules("confpass", "Confirmation Password", "required|matches[newpass]");
        $this->form_validation->set_error_delimiters("<font class='error animated fadeIn'>", "</font>");
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("errorMsg", "Input(s) field cannot be empty!");
            $this->index();
        } else {
            $uid = $this->session->userdata("session_uid");
            $pass = $this->security->xss_clean($this->input->post("newpass"));
            $salt = uniqid("", true);
            $algo = "6";
            $rounds = "5050";
            $cryptSalt = '$' . $algo . '$rounds=' . $rounds . '$' . $salt;
            $hashedPassword = crypt($pass, $cryptSalt); //die($uid." = ".$hashedPassword);
            $this->load->model("users_model");
            $this->users_model->edit_row($uid, array("pass" => $hashedPassword));
            redirect(site_url("signin/logout"));
        }
    }//End of save()
}//End of Changepass