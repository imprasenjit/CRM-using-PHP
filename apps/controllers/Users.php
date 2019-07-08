<?php
defined("BASEPATH") OR exit("No direct script access allowed");
class Users extends Alom {
    function index() {
        $this->isloggedin();
        $this->isadmin();
        $data = array();
        $this->load->model("users_model");
        if ($this->users_model->get_rows()) {
            $data["results"] = $this->users_model->get_rows();
        }
        $this->load->view("users_view", $data);
    }//End of index()
    
    function addnew($id=NULL) {
        $this->isloggedin();
        $data = array();
        $this->load->model("users_model");
        $this->load->helper("usertypes");
        if ($this->users_model->get_row($id)) {
            $data["result"] = $this->users_model->get_row($id);
        }
        $this->load->view("useraddnew_view", $data);
    }//End of addnew()

    function save() {
        if($this->input->post($this->security->get_csrf_token_name()) == $this->security->get_csrf_token_name()) {
            die("Token does not matched!"); exit();
        }
        $this->isloggedin();
        $this->isadmin();
        $uid = $this->input->post("uid");
        $this->load->library("form_validation");
        if ($uid == "") {
            $this->form_validation->set_rules("user_name", "Username", "required|is_unique[users.uname]");
            $this->form_validation->set_rules("pass", "Password", "required|min_length[4]|max_length[15]");
            $this->form_validation->set_rules('confpass', 'Confirm Password', 'required|matches[pass]');
        } else {
            $this->form_validation->set_rules("uname", "Name", "required");
        }//End of if else
        $this->form_validation->set_rules("user_name", "Name", "required|min_length[3]");
        $this->form_validation->set_rules("user_no", "Contact No.", "integer|required|exact_length[10]");
        $this->form_validation->set_rules("user_mail", "Mail", "required|valid_email");
        $this->form_validation->set_rules("utype", "Type", "required");
        $this->form_validation->set_error_delimiters("<font class='error animated fadeIn'>", "</font>");
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("flashMsg", "Invalid inputs");
            $this->addnew($uid);
        } else {
            $doe = date("Y-m-d");
            $utype = $this->input->post("utype");
            $uname = $this->security->xss_clean($this->input->post("uname"));
            $pass = $this->input->post("pass");
            $user_rights = implode(",", $this->input->post("user_rights"));
            $salt = uniqid("", true);
            $algo = "6";
            $rounds = "5050";
            $cryptSalt = '$' . $algo . '$rounds=' . $rounds . '$' . $salt;
            $hashedPassword = crypt($pass, $cryptSalt);
            
            $user_name = $this->security->xss_clean($this->input->post("user_name"));
            $user_no = $this->security->xss_clean($this->input->post("user_no"));
            $user_mail = $this->security->xss_clean($this->input->post("user_mail"));
            $user_address = $this->security->xss_clean($this->input->post("user_address"));            
            $this->load->model("users_model");
            if ($uid == "") {
                $data = array(
                    "doe" => $doe,
                    "utype" => $utype,
                    "uname" => $uname,
                    "pass" => $hashedPassword,
                    "user_name" => $user_name,
                    "user_no" => $user_no,
                    "user_mail" => $user_mail,
                    "user_address" => $user_address,
                    "user_rights" => $user_rights
                );
                $this->users_model->add_row($data);
                $msg = "Data has been successfully saved!";
            } else {
                $data = array(
                    "doe" => $doe,
                    "utype" => $utype,
                    "user_name" => $user_name,
                    "user_no" => $user_no,
                    "user_mail" => $user_mail,
                    "user_address" => $user_address,
                    "user_rights" => $user_rights
                );
                $this->users_model->edit_row($uid, $data);
                $msg = "Data has been successfully updated!";
            }
            $this->session->set_flashdata("flashMsg", $msg);
            redirect(site_url("users"));
        }
    }//End of save()

    function delete($id = NULL) {
        $this->isloggedin();
        $this->isadmin();
        $this->load->model("users_model");
        $this->users_model->edit_row($id, array("status" => 0));
        $this->session->set_flashdata("flashMsg", "One record has been deleted successfully!");
        redirect(site_url("users"));
    }// End of delete()
    
    function unlink(){
        $id = $this->input->post("uid");
        $old_file = $this->input->post("old_file");
        $src = "storage/users/".$old_file;
        unlink($src);
        $this->load->model("users_model");
        $this->users_model->edit_row($id, array("user_image"=>NULL));
    } // End of unlink()
}//End of Users