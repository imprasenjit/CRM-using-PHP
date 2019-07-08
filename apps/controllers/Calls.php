<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
class Calls extends Alom {
    
    function __construct() {
        parent::__construct();
        $this->isloggedin();
        $this->load->helper("text");
        $this->load->helper("ticketstatus");
        $this->load->model("calls_model");
        $this->load->model("querytypes_model");
    }


    function index() {
        $data = array();
        if($this->session->session_utype == 1){
            if ($this->calls_model->get_rows()) {
                $data["results"] = $this->calls_model->get_rows();
            }
        } else {
            $session_uid = $this->session->session_uid;
            if ($this->calls_model->get_userrows($session_uid)) {
                $data["results"] = $this->calls_model->get_userrows($session_uid);
            }
        }            
        $this->load->view("calls_view", $data);
    }//End of index()
    
    function addnew($id=NULL) {
        $id = $this->security->xss_clean($id);
        $this->isloggedin("call_add");
        $data = array();
        if ($this->calls_model->get_row($id)) {
            $this->isloggedin("call_edit");
            $data["result"] = $this->calls_model->get_row($id);
        }
        $this->load->view("calladdnew_view", $data);
    }//End of addnew()
    
    function getcustinfo() {
        $cno = $this->security->xss_clean($this->input->post("cno"));
        if ($this->calls_model->get_cnorow($cno)) {
            $res = $this->calls_model->get_cnorow($cno);
            $res["flag"]=1;
            
        } else {
            $res = array("flag"=>0);
        }
        echo json_encode($res);
    }//End of getcustinfo()

    function save() {
        $nowTime = date("Y-m-d H:i:s");
        $call_id = $this->security->xss_clean($this->input->post("call_id"));
        $isticket = $this->input->post("isticket");
        $this->load->library("form_validation");
        $this->form_validation->set_rules("cno", "Mobile", "required");
        if((strlen($isticket)>0)) {
            $this->form_validation->set_rules("ubin", "UBIN/UAIN", "required");
            //$this->form_validation->set_rules("priority", "Priority", "required");
            $this->form_validation->set_rules("email", "Email", "required");            
        }        
        $this->form_validation->set_rules("cname", "Name", "required");
        $this->form_validation->set_rules("query_type", "Query Type", "required");
        //$this->form_validation->set_rules("query", "Query", "required");
        $this->form_validation->set_error_delimiters("<font class='error animated fadeIn'>", "</font>");
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("flashMsg", "Please check the inputs and try again");
            $this->addnew($call_id);
        } else {
            $this->load->model("settings_model");
            $cno = $this->security->xss_clean($this->input->post("cno"));
            $email = $this->security->xss_clean($this->input->post("email"));
            $cname = $this->security->xss_clean($this->input->post("cname"));
            $query_type = $this->security->xss_clean($this->input->post("query_type"));
            $remarks = $this->security->xss_clean($this->input->post("remarks"));
            $query = $this->security->xss_clean($this->input->post("query"));            
            $data = array(
                "cno" => $cno,
                "email" => $email,
                "cname" => $cname,
                "query_type" => $query_type,
                "query" => $query,
                "remarks" => $remarks,
                "call_time" => $nowTime
            );
            if ($call_id == "") {
                $this->calls_model->add_row($data);
                $msg = "Data has been successfully saved!";
            } else {
                $this->calls_model->edit_row($call_id, $data);
                $msg = "Data has been successfully updated!";
            }//End of if else
                        
            if((strlen($isticket)>0)) {
                $ubin = $this->security->xss_clean($this->input->post("ubin"));
                $priority = 2;
                $ticket_no = strtoupper(uniqid());
                $assigneduser = $this->settings_model->getdefultusr();
                $ticketData = array(
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
                    "support_status" => 1
                );
                $this->load->model("supports_model");
                $this->load->model("supportprocess_model");
                $this->load->model("users_model");
                $this->load->helper("sendmail");
                $this->supports_model->add_row($ticketData);
                $support_id = $this->db->insert_id();
                $process_type = 1;
                
                $body = "Thank you for contacting our support team. A support ticket( #".$ticket_no.") has been generated for your request. You will be notified when a response is made by email.";
                sendmail($email, $ticket_no, $body);
                $pdata = array(
                    "support_id" => $support_id,
                    "process_time" => $nowTime,
                    "processed_by" => $this->session->session_uid,
                    "process_type" => $process_type,
                    "process_msg" => $body
                );
                $this->supportprocess_model->add_row($pdata);
            }
            $this->session->set_flashdata("flashMsg", $msg);
            redirect(site_url("calls"));
        }//End of if else
    }//End of save()

    function getRecords() {
        $this->load->helper("text");
        $columns = array(
            0 => "call_time",
            1 => "cname",
            2 => "cno"
        );
        $limit = $this->input->post("length");
        $start = $this->input->post("start");
        $order = $columns[$this->input->post("order")[0]["column"]];
        $dir = $this->input->post("order")[0]["dir"];
        $totalData = $this->calls_model->tot_rows();
        $totalFiltered = $totalData;
        if (empty($this->input->post("search")["value"])) {
            $records = $this->calls_model->all_rows($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post("search")["value"];
            $records = $this->calls_model->search_rows($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->calls_model->tot_search_rows($search);
        }
        $data = array();
        if (!empty($records)) {
            foreach ($records as $rows) {
                $call_id = $rows->call_id;
                $call_time = date("l, d F Y h:i A", strtotime($rows->call_time));
                $cname = $rows->cname;
                $cno = $rows->cno;
                $cust = '<a id="' . $call_id . '" data-toggle="modal" data-target="#callviewModal" href="javascript:void(0)">' . word_limiter($cname, 3) . '</a>';
                $nestedData["call_time"] = $call_time;
                $nestedData["cname"] = $cust;
                $nestedData["cno"] = $cno;
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
    
    function getDetails() {
        $call_id = $this->security->xss_clean($this->input->post("call_id"));
        $this->load->helper("ticketstatus");
        if ($this->calls_model->get_row($call_id)) {
            $result = $this->calls_model->get_row($call_id);
            $cno = $result->cno;
            $cname = $result->cname;
            $qtype_id = $result->query_type;
            $qtypeRow = $this->querytypes_model->get_row($qtype_id);
            $qtype_name = ($qtypeRow)?$qtypeRow->qtype_name:"Not found";
            $call_time = $result->call_time;
            $query = $result->query;
            $status = getstatus($result->call_status);
            ?>
            <div class="row">
                <div class="col-md-4">Call Time : </div>
                <div class="col-md-8"><?= date("D, d M Y h:i A", strtotime($call_time)) ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">Mobile No. : </div>
                <div class="col-md-8"><?= $cno ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">Name : </div>
                <div class="col-md-8"><?= $cname ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">Query Type : </div>
                <div class="col-md-8"><?= $qtype_name ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">Query : </div>
                <div class="col-md-8"><?= $query ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">Status : </div>
                <div class="col-md-8"><?= $status ?></div>
            </div>
            </div><!--End of .card-body-->
        <?php } else {
            echo "No records found!";
        }//End of if else
    }//End of getDetails()

    function close() {
        $call_id = $this->security->xss_clean($this->input->post("call_id"));
        $this->calls_model->edit_row($call_id, array("call_status" => 3));
        $this->session->set_flashdata("flashMsg", "One ticket has been closed successfully!");
        redirect(site_url("calls"));
    }// End of close() 

    function delete($id = NULL) {
        $this->isadmin();
        $this->calls_model->edit_row($id, array("call_status" => 0));
        $this->session->set_flashdata("flashMsg", "One record has been deleted successfully!");
        redirect(site_url("calls"));
    }// End of delete()
}//End of Calls