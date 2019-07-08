<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
class Querytypes extends Alom {
    function index($id=NULL) {
        $this->isadmin();
        $this->isloggedin();
        $data = array();
        $this->load->model("querytypes_model");
        if ($this->querytypes_model->get_row($id)) {
            $data["result"] = $this->querytypes_model->get_row($id);
        }//End of if
        $this->load->view("querytypes_view", $data);
    }//End of addnew()
    
    function save() {
        $this->isloggedin();
        $this->isadmin();
        $qtype_id = $this->input->post("qtype_id");
        $this->load->library("form_validation");
        $this->form_validation->set_rules("qtype_name", "Name", "required");
        $this->form_validation->set_rules("qtype_status", "Type", "required");
        $this->form_validation->set_error_delimiters("<font class='error animated fadeIn'>", "</font>");
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("flashMsg", "Please check the inputs and try again");
            $this->addnew($qtype_id);
        } else {
            $qtype_name = $this->security->xss_clean($this->input->post("qtype_name"));
            $qtype_status = $this->security->xss_clean($this->input->post("qtype_status"));
            $data = array("qtype_name" => $qtype_name, "qtype_status" => $qtype_status);
            $this->load->model("querytypes_model");
            if ($qtype_id == "") {
                $this->querytypes_model->add_row($data);
                $msg = "Data has been successfully saved!";
            } else {
                $this->isloggedin("cust_edit");
                $this->querytypes_model->edit_row($qtype_id, $data);
                $msg = "Data has been successfully updated!";
            }//End of if else
            $this->session->set_flashdata("flashMsg", $msg);
            redirect(site_url("querytypes"));
        }//End of if else
    }//End of save()

    function delete($id = NULL) {
        $this->isloggedin();
        $this->isadmin();
        $this->load->model("querytypes_model");
        $this->querytypes_model->edit_row($id, array("qtype_status" => 0));
        $this->session->set_flashdata("flashMsg", "One record has been deleted successfully!");
        redirect(site_url("querytypes"));
    }// End of delete()
}//End of Querytypes