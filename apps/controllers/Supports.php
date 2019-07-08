<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
class Supports extends Alom {
    
    function __construct() {
        parent::__construct();
        define("SITE_KEY", "6Lf9HDYUAAAAANi0ml8WqwAmQSECP0hg2yNzpWtl");
        define("SECRET_KEY", "6Lf9HDYUAAAAAPa9-nEGAGuXJH8llHC45HGp7N1U");
    }//End of __construct()
    
    function index() {
        $this->isloggedin();
        $data = array();
        $this->load->helper("text");
        $this->load->helper("ticketstatus");
        $this->load->model("ticketsnew_model");
        $this->load->model("querytypes_model");
        $this->load->model("users_model");
        $this->load->helper("priority");
        $session_uid = $this->session->session_uid;
        if ($this->ticketsnew_model->get_userrows($session_uid)) {
            $data["results"] = $this->ticketsnew_model->get_userrows($session_uid);
        }//End of if statement
        $this->load->view("supports_view", $data);
    }//End of index()
    
    function addnew($id=NULL) {
        $this->isloggedin("ticket_add");
        $data = array();
        $this->load->model("supports_model");
        $this->load->model("users_model");
        $this->load->model("querytypes_model");
        $this->load->helper("priority");
        if ($this->users_model->get_rows()) {
            $data["users"] = $this->users_model->get_rows();
        }
        if ($this->querytypes_model->get_rows()) {
            $data["qtypes"] = $this->querytypes_model->get_rows();
        }
        if ($this->supports_model->get_row($id)) {
            $data["result"] = $this->supports_model->get_row($id);
        }
        $this->load->view("supportaddnew_view", $data);
    }//End of addnew()
    
    function details($id=NULL) {
        $data = array();
        $this->load->model("supports_model");
        $this->load->model("supportprocess_model");
        $this->load->model("querytypes_model");
        $this->load->model("users_model");
        $this->load->helper("ticketstatus");
        $this->load->helper("priority");
        $this->load->helper("ticketprocesstype");
        if ($this->users_model->get_rows()) {
            $data["users"] = $this->users_model->get_rows();
        }
        if ($this->supports_model->get_row($id)) {
            $data["result"] = $this->supports_model->get_row($id);
        }
        if ($this->supportprocess_model->get_supportrows($id)) {
            $data["results"] = $this->supportprocess_model->get_supportrows($id);
        }
        $this->load->view("supportdetails_view", $data);
    }//End of details()
    
    function getcustinfo() {
        $email = $this->input->post("email");
        $this->load->model("supports_model");
        if ($this->supports_model->get_emailrow($email)) {
            $res = $this->supports_model->get_emailrow($email);
            $res["flag"]=1;
            
        } else {
            $res = array("flag"=>0);
        }
        echo json_encode($res);
    }//End of getcustinfo()

    function save() {
        $this->isloggedin();
        $support_id = $this->input->post("support_id");        
        $recaptcha = $this->input->post("g-recaptcha-response");
        if($recaptcha) {
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response=".$recaptcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
            $res = json_decode($response, TRUE);
            if($res['success']) {
                $nowTime = date("Y-m-d H:i:s");
                $this->load->library("form_validation");
                $this->form_validation->set_rules("email", "Email", "required");
                $this->form_validation->set_rules("cno", "Mobile", "required");
                $this->form_validation->set_rules("cname", "Name", "required");
                $this->form_validation->set_rules("query", "Query", "required");
                $this->form_validation->set_rules("ubin", "UBIN/UAIN", "required");
                $this->form_validation->set_rules("query_type", "Type", "required");
                $this->form_validation->set_rules("priority", "Priority", "required");
                $this->form_validation->set_error_delimiters("<font class='error animated fadeIn'>", "</font>");
                if ($this->form_validation->run() == FALSE) {
                    $this->session->set_flashdata("flashMsg", "Please check the inputs and try again");
                    $this->addnew($support_id);
                } else {
                    $this->load->model("settings_model");
                    $this->load->model("supports_model");
                    $this->load->model("supportprocess_model");
                    $this->load->model("users_model");
                    $this->load->helper("sendmail");

                    $email = $this->input->post("email");
                    $cno = $this->input->post("cno");
                    $ubin = $this->input->post("ubin");
                    $cname = $this->input->post("cname");
                    $query = $this->input->post("query");
                    $query_type = $this->input->post("query_type");
                    $priority = $this->input->post("priority");
                    $uid = $this->input->post("uid");
                    $assign = ($this->users_model->get_row($uid))?"and assigned to ".$this->users_model->get_row($uid)->user_name:"";
                    $mto = $this->input->post("mark_to");
                    $mark_to = ($mto)?implode(",", $mto):"";
                    $assigneduser = $this->settings_model->getdefultusr();

                    if ($support_id == "") {
                        $ticket_no = strtoupper(uniqid());
                        $data = array(
                            "ticket_no" => $ticket_no,
                            "email" => $email,
                            "cno" => $cno,
                            "ubin" => $ubin,
                            "cname" => $cname,
                            "query_type" => $query_type,
                            "query" => $query,
                            "support_time" => $nowTime,
                            "priority" => $priority,
                            "uid" => $assigneduser,
                            "support_status" => 1,
                            "mark_to" => $mark_to
                        );
                        $this->supports_model->add_row($data);
                        $support_id = $this->db->insert_id();
                        $process_msg = "Ticket (#".$support_id.") has been successfully generated ".$assign; 
                        $process_type = 1;
                        $body = "Thank you for contacting our support team. A support ticket( #".$ticket_no.") has been generated for your request. You will be notified when a response is made by email.";
                        sendmail($email, $ticket_no, $body);
                        $msg = "Data has been successfully saved!";
                    } else {            
                        $this->isloggedin("ticket_edit");    
                        $data = array(
                            "email" => $email,
                            "cno" => $cno,
                            "ubin" => $ubin,
                            "cname" => $cname,
                            "query_type" => $query_type,
                            "query" => $query,
                            "priority" => $priority,
                            "uid" => $uid,
                            "mark_to" => $mark_to,
                            "support_status" => 3
                        );
                        $this->supports_model->edit_row($support_id, $data);
                        $process_msg = "Ticket (#".$support_id.") has been successfully updated ".$assign;
                        $process_type = 3;
                        $msg = "Data has been successfully updated!";
                    }//End of if else

                    $pdata = array(
                        "support_id" => $support_id,
                        "process_time" => $nowTime,
                        "processed_by" => $this->session->session_uid,
                        "process_type" => $process_type,
                        "process_msg" => $process_msg
                    );
                    $this->supportprocess_model->add_row($pdata);

                    $this->session->set_flashdata("flashMsg", $msg);
                    redirect(site_url("supports"));
                }//End of if else
            } else {
                $captchaError = $res['error-codes'][0];
                $this->session->set_flashdata("flashMsg", "Captcha does not matched".$captchaError);
                $this->addnew($support_id);
            }//End of if else
        } else {
            $this->session->set_flashdata("flashMsg", "Captcha cannot be empty");
            $this->addnew($support_id);
        }//End of if else        
    }//End of save()

    function reply() {
        $this->isloggedin();
        $nowTime = date("Y-m-d H:i:s");
        $support_id = $this->input->post("support_id");
        $msg = $this->input->post("msg");
        $actiontype = $this->input->post("actiontype");
        $mto = $this->input->post("mark_to");
        $mark_to = ($mto)?implode(",", $mto):"";
        $this->load->model("supports_model");
        $this->load->model("supportprocess_model");
        $this->load->helper("sendmail");
        if($this->supports_model->get_row($support_id)) {
            $supportRow = $this->supports_model->get_row($support_id);
            $email = $supportRow->email;
            $ticket_no = $supportRow->ticket_no;
            sendmail($email, $ticket_no, $msg);
        }        
        $pdata = array(
            "support_id" => $support_id,
            "process_time" => $nowTime,
            "processed_by" => $this->session->session_uid,
            "process_msg" => $msg,
            "process_type" => 2
        );
        $this->supportprocess_model->add_row($pdata);
        $this->supports_model->edit_row($support_id, array("support_status" => 2, "mark_to" => $mark_to));        
        if($actiontype=="replyclose") {
            $this->resolved($support_id);
        }
        $this->session->set_flashdata("flashMsg", "One ticket has been relpied successfully!");
        redirect(site_url("supports"));
    }// End of reply()

    function close() {
        $this->isloggedin();
        $support_id = $this->input->post("support_id");
        $note = $this->input->post("note");        
        if($this->resolved($support_id, $note)) {
            $this->session->set_flashdata("flashMsg", "One ticket has been closed successfully!");
        } else {
            $this->session->set_flashdata("flashMsg", "No ticket found!");
        }
        redirect(site_url("supports"));
    }// End of close()
    
    function resolved($support_id, $rem=NULL) {
        $nowTime = date("Y-m-d H:i:s");
        $this->load->model("supports_model");
        $this->load->model("supportprocess_model");
        $this->load->helper("sendmail");
        $this->load->helper("sendsms");
        $remarks = (strlen($rem) > 5)?"<b style='color:#f44141'>REMARKS : </b>".$rem."<br /><br />":"";
        
        $this->supports_model->edit_row($support_id, array("support_status" => 5));
        if($this->supports_model->get_row($support_id)) {
            $supportRow = $this->supports_model->get_row($support_id);
            $email = $supportRow->email;
            $cno = $supportRow->cno;
            $ticket_no = $supportRow->ticket_no;
            $msg = $remarks.". Ticket (#".$ticket_no.") for EODB supports has been resolved. If you have any further query please visit our site http://www.support.easeofdoingbusinessinassam.in and raise a new ticket. Thank you.";
            $pdata = array(
                "support_id" => $support_id,
                "process_time" => $nowTime,
                "processed_by" => $this->session->session_uid,
                "process_msg" => $msg,
                "process_type" => 2
            );
            $this->supportprocess_model->add_row($pdata);            
            sendmail($email, $ticket_no, $msg);
            $sms = "Ticket (#".$ticket_no.") for EODB supports has been resolved. If you have any further query please visit our site and raise a new ticket. Thank you.";
            sendsms($cno, $sms);
            return TRUE;
        } else {
            return FALSE;
        }
    }// End of resolved()

    function assign() {
        $this->isloggedin();
        $this->load->model("supports_model");
        $this->load->model("supportprocess_model");
        $this->load->model("users_model");
        
        $nowTime = date("Y-m-d H:i:s");
        $support_id = $this->input->post("support_id");
        $note = $this->input->post("note");
        $remarks = (strlen($note) > 5)?"<br /><br /><b style='color:#f44141'>NOTE : </b>".$note:"";
        $uid = $this->input->post("uid");
        $mto = $this->input->post("mark_to");
        $mark_to = ($mto)?implode(",", $mto):"";
        $assignto = ($this->users_model->get_row($uid))?$this->users_model->get_row($uid)->user_name:"Not found!";
        $priority = $this->input->post("priority");
        $msg = "Ticket (#".$support_id.") has been successfully assigned to ".$assignto;
        $this->supports_model->edit_row($support_id, array("uid" => $uid, "mark_to"=>$mark_to, "priority"=>$priority, "support_status" => 3));
        $pdata = array(
            "support_id" => $support_id,
            "process_time" => $nowTime,
            "processed_by" => $this->session->session_uid,
            "process_msg" => $msg.$remarks,
            "process_type" => 3
        );
        $this->supportprocess_model->add_row($pdata);
        $this->session->set_flashdata("flashMsg", $msg);
        redirect(site_url("supports"));
    }// End of assign()

    function delete($id = NULL) {
        $this->isloggedin();
        $this->isadmin();
        $this->load->model("supports_model");
        $this->supports_model->edit_row($id, array("support_status" => 0));
        $this->session->set_flashdata("flashMsg", "One record has been deleted successfully!");
        redirect(site_url("supports"));
    }// End of delete()
}//End of Supports

