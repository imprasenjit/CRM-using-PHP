<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
class Ticket extends Alom {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('encode');
        define("SITE_KEY", "6Lf9HDYUAAAAANi0ml8WqwAmQSECP0hg2yNzpWtl");
        define("SECRET_KEY", "6Lf9HDYUAAAAAPa9-nEGAGuXJH8llHC45HGp7N1U");
    }//End of __construct()

    function index() {
        $data = array();
        $this->load->model("querytypes_model");
        $this->load->helper("priority");
        if ($this->querytypes_model->get_rows()) {
            $data["qtypes"] = $this->querytypes_model->get_rows();
        }//End of if
        $this->load->view("ticket_view", $data);
    }//End of index()    
    
    function save() {
        $recaptcha = $this->input->post("g-recaptcha-response");
        if($recaptcha) {
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response=".$recaptcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
            $res = json_decode($response, TRUE);
            if($res['success']) {
                $this->load->library("form_validation");
                $this->form_validation->set_rules("email", "Email", "required|valid_email");
                $this->form_validation->set_rules("cno", "Mobile", "required|integer|exact_length[10]");
                $this->form_validation->set_rules("cname", "Name", "required");
                $this->form_validation->set_rules("ubin", "UBIN/UAIN", "required");
                $this->form_validation->set_rules("query", "Query", "required");
                $this->form_validation->set_rules("query_type", "Type", "required");
                $this->form_validation->set_error_delimiters("<font class='error animated fadeIn'>", "</font>");
                if ($this->form_validation->run() == FALSE) {
                    $this->session->set_flashdata("flashMsg", "Please check the inputs and try again");
                    $this->index();
                } else {
                    $this->load->model("settings_model");
                    $this->load->model("supports_model");
                    $this->load->helper("sendmail");

                    $nowTime = date("Y-m-d H:i:s");
                    $ticket_no = strtoupper(uniqid());
                    $email = $this->security->xss_clean($this->input->post("email"));
                    $cno = $this->input->post("cno");
                    $ubin = $this->security->xss_clean($this->input->post("ubin"));
                    $cname = $this->security->xss_clean($this->input->post("cname"));
                    $query = $this->security->xss_clean($this->input->post("query"));
                    $query_type = $this->input->post("query_type");
                    if($_FILES["files"]["name"] !="") {
                        $upload_file = $_FILES["files"]["name"];
                        $tmp=explode(".", $upload_file);
                        $file_extension = strtolower(end($tmp));
                        $renameFile=sha1(uniqid(rand())).".".$file_extension;
                        $src = "storage/temps/".$upload_file;
                        $dst = "storage/uploads/".$renameFile;
                        copy($src, $dst);
                        unlink($src);
                    } else {
                        $renameFile = NULL;
                    }//End of if else
                    $assigneduser = $this->settings_model->getdefultusr();
                    $data = array(
                        "ticket_no" => $ticket_no,
                        "email" => $email,
                        "cno" => $cno,
                        "ubin" => $ubin,
                        "cname" => $cname,
                        "query_type" => $query_type,
                        "query" => $query,
                        "query_file" => $renameFile,
                        "support_time" => $nowTime,
                        "priority" => 3,
                        "uid" => $assigneduser,
                        "support_status" => 1
                    );
                    $this->supports_model->add_row($data);
                    $support_id = $this->db->insert_id();
                    $body = "Thank you for contacting our support team. A support ticket( #".$ticket_no.") has been generated for your request. You will be notified when a response is made by email.";
                    sendmail($email, $ticket_no, $body);
                    $msg = "Ticket Created #".$ticket_no."<br />Your ticket has been successfully created. An email has been sent to your address with the ticket information.";
                    $this->session->set_flashdata("flashMsg", $msg);
                    redirect(site_url("ticket"));
                }//End of if else
            } else {
                $captchaError = $res['error-codes'][0];
                $this->session->set_flashdata("flashMsg", "Captcha does not matched".$captchaError);
                $this->index();
            }//End of if else
        } else {
            $this->session->set_flashdata("flashMsg", "Captcha cannot be empty");
            $this->index();
        }//End of if else
    }//End of save()
    
    function track() {
        $this->load->model("querytypes_model");
        $this->load->view("tickettrack_view");
    }//End of track()
        
    function details() {
        $data = array();        
        $this->load->model("supports_model");
        $this->load->model("supportprocess_model");
        $this->load->model("querytypes_model");
        $this->load->model("users_model");
        $this->load->helper("ticketstatus");
        $this->load->helper("priority");
        
        $this->load->library("form_validation");
        $this->form_validation->set_rules("ticket_no", "Ticket no.", "required");
        $this->form_validation->set_error_delimiters("<font class='error animated fadeIn'>", "</font>");
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("flashMsg", "Please check the inputs and try again");
            $this->track();
        } else {
            $ticket_no = $this->security->xss_clean($this->input->post("ticket_no"));            
            if ($this->supports_model->get_trackrow($ticket_no)) {
                $data["result"] = $this->supports_model->get_trackrow($ticket_no);
                $support_id = $this->supports_model->get_trackrow($ticket_no)->support_id;
                if ($this->supportprocess_model->get_replyrows($support_id)) {
                    $data["results"] = $this->supportprocess_model->get_replyrows($support_id);
                }
            } else {
                $this->session->set_flashdata("flashMsg", "The ticket no. you have entered does not exist! Please check the ticket no. and try again.");
            }//End of if else
            $this->load->view("tickettrack_view", $data);
        }//End of if else
    }//End of details()
    
    function reply($ticket_no=NULL) {
        $encryptedToken = $this->security->xss_clean($ticket_no);
        $ticket_no = base64url_decode($encryptedToken);
        $data = array();        
        $this->load->model("supports_model");
        $this->load->model("supportprocess_model");
        $this->load->model("querytypes_model");
        $this->load->model("users_model");
        $this->load->helper("ticketstatus");
        $this->load->helper("priority");
        
        if ($this->supports_model->get_trackrow($ticket_no)) {
            $data["result"] = $this->supports_model->get_trackrow($ticket_no);
            $support_id = $this->supports_model->get_trackrow($ticket_no)->support_id;
            if ($this->supportprocess_model->get_replyrows($support_id)) {
                $data["results"] = $this->supportprocess_model->get_replyrows($support_id);
            }
        } else {
            $this->session->set_flashdata("flashMsg", "The ticket no. you have entered does not exist! Please check the ticket no. and try again.");
        }//End of if else
        $this->load->view("tickettrack_view", $data);
    }//End of reply()
    
    function replied() {
        $ticket_no = $this->security->xss_clean($this->input->post("ticket_no"));
        $encryptedToken = base64url_encode($ticket_no);
        $this->load->library("form_validation");
        $this->form_validation->set_rules("msg", "Reply Message", "required");
        $this->form_validation->set_error_delimiters("<font class='error animated fadeIn'>", "</font>");
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("flashMsg", "Invalid inputs");
            $this->reply($encryptedToken);
        } else {
            $nowTime = date("Y-m-d H:i:s");
            $msg = $this->security->xss_clean($this->input->post("msg"));
            if($_FILES["files"]["name"] !="") {
                $upload_file = $_FILES["files"]["name"];
                $tmp=explode(".", $upload_file);
                $file_extension = strtolower(end($tmp));
                $renameFile=sha1(uniqid(rand())).".".$file_extension;
                $src = "storage/temps/".$upload_file;
                $dst = "storage/uploads/".$renameFile;
                copy($src, $dst);
                unlink($src);
            } else {
                $renameFile = NULL;
            }//End of if else           
            
            $this->load->model("supports_model");
            $this->load->model("supportprocess_model");
            $support_id = $this->supports_model->get_trackrow($ticket_no)->support_id; //die($ticket_no." :: ".$support_id);
            $this->supports_model->edit_row($support_id, array("support_status"=>4));
            $data = array(
                "support_id" => $support_id,
                "process_time" => $nowTime,
                "process_msg" => $msg,
                "process_file" => $renameFile,
                "process_type" => 5
            );
            $this->supportprocess_model->add_row($data);
            $this->session->set_flashdata("flashMsg", "Data has been successfully submitted!");
            redirect(site_url("ticket/reply/".$encryptedToken));
        }
    }//End of reply()
}//End of Ticket
