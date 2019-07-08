<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
class Tickets extends Alom {
    
    function __construct() {
        parent::__construct();
        $this->isloggedin();
    }//End of __construct()
    
    function index() {
        $this->load->view("tickets_view");
    }//End of index()
    
    function all() {
        $this->load->view("ticketsall_view");
    }//End of all()

    function getRecords() {
        $this->load->model("tickets_model");
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
        $totalData = $this->tickets_model->tot_rows();
        $totalFiltered = $totalData;
        if (empty($this->input->post("search")["value"])) {
            $records = $this->tickets_model->all_rows($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post("search")["value"];
            $records = $this->tickets_model->search_rows($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->tickets_model->tot_search_rows($search);
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
        $this->load->model("tickets_model");
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
        $totalData = $this->tickets_model->tot_userrows($uid);
        $totalFiltered = $totalData;
        if (empty($this->input->post("search")["value"])) {
            $records = $this->tickets_model->all_userrows($uid, $limit, $start, $order, $dir);
        } else {
            $search = $this->input->post("search")["value"];
            $records = $this->tickets_model->search_userrows($uid, $limit, $start, $search, $order, $dir);
            $totalFiltered = $this->tickets_model->tot_search_userrows($uid, $search);
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
    }//End of getUserRecords()
    
    function search() {
        $search = $this->input->post("searchkey");
        $this->load->model("tickets_model");
        $this->load->helper("ticketstatus");
        $this->load->model("querytypes_model");
        $this->load->model("users_model");
        $this->load->helper("text");
        $this->load->helper("priority");
        $data["searchkey"] = $search;
        if($this->tickets_model->search_rows(10, 0, $search, "support_time", "DESC")) {
            $data["results"] = $this->tickets_model->search_rows(10, 0, $search, "support_time", "DESC");
        }
        $this->load->view("ticketsearch_view", $data);
    }//End of search()

    function getDetails() {
        $support_id = $this->security->xss_clean($this->input->post("support_id"));
        $this->getTicket($support_id);
    }//End of getDetails()

    function getTicket($support_id=NULL) {
        $this->load->model("supports_model");
        $this->load->model("supportprocess_model");
        $this->load->model("querytypes_model");
        $this->load->model("users_model");
        $this->load->helper("ticketstatus");
        $this->load->helper("priority");
        $this->load->helper("ticketprocesstype");
        if ($this->supports_model->get_row($support_id)) {
            $result = $this->supports_model->get_row($support_id);
            $ticket_no = $result->ticket_no;
            $email = $result->email;
            $cno = $result->cno;
            $ubin = $result->ubin;
            $cname = $result->cname;
            $qtype_id = $result->query_type;
            $qtype_name = ($this->querytypes_model->get_row($qtype_id)) ? $this->querytypes_model->get_row($qtype_id)->qtype_name : "Not found";
            $query = $result->query;
            $query_file = $result->query_file;
            if(strlen($query_file) > 10) {
                $queryFile = '<a href="'.base_url('storage/uploads/'.$query_file).'" target="_blank"><i class="fa fa-cloud-download"></i> Download/View File</a>';
            } else {
                $queryFile = "Not uploaded";
            }
            $uid = $result->uid;
            $assignto = ($this->users_model->get_row($uid))?$this->users_model->get_row($uid)->user_name:"Not found!";
            $support_time = $result->support_time;
            $priority = getpriority($result->priority);
            $status = getstatus($result->support_status);
            ?>
            <div class="row">
                <div class="col-md-4">Ticket ID. : </div>
                <div class="col-md-8"><?= $support_id ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">Ticket No. : </div>
                <div class="col-md-8"><?= $ticket_no ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">Ticket Time : </div>
                <div class="col-md-8"><?= date("D, d M Y h:i A", strtotime($support_time)) ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">Name : </div>
                <div class="col-md-8"><?= $cname ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">Email ID : </div>
                <div class="col-md-8"><?= $email ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">Mobile No. : </div>
                <div class="col-md-8"><?= $cno ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">UBIN / UAIN : </div>
                <div class="col-md-8"><?= $ubin ?></div>
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
                <div class="col-md-4">File uploaded (If Any) : </div>
                <div class="col-md-8"><?=$queryFile?></div>
            </div>
            <div class="row">
                <div class="col-md-4">Assign to : </div>
                <div class="col-md-8"><?= $assignto ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">Priority : </div>
                <div class="col-md-8"><?= $priority ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">Current status : </div>
                <div class="col-md-8"><?= $status ?></div>
            </div>
            </div><!--End of .card-body-->
            <hr />
            <ul class="">
            <?php
            if ($this->supportprocess_model->get_supportrows($support_id)) {
                foreach ($this->supportprocess_model->get_supportrows($support_id) as $rows) {
                    $process_time = date("D, d M h:i A", strtotime($rows->process_time));                    
                    $process_type  = $rows->process_type;
                    if($process_type == 6) {
                        $pby = (strlen($rows->processed_bymail)>4)?$rows->processed_bymail:"Not found";
                    } elseif($process_type == 5) {
                        $support_id = $rows->support_id;
                        $pby = $this->supports_model->get_trackrow($ticket_no)->cname;
                    } else {
                        $processed_by  = $rows->processed_by;
                        $pby = ($this->users_model->get_row($processed_by))?$this->users_model->get_row($processed_by)->user_name:"Not found";
                    }
                    $process_file  = $rows->process_file;
                    if(strlen($process_file) > 10) {
                        $processFile = '<a href="'.base_url('storage/uploads/'.$process_file).'" target="_blank"><i class="fa fa-cloud-download"></i> Download/View File</a>';
                    } else {
                        $processFile = "";
                    }
                    $process_msg = $rows->process_msg; ?>
                    <li style="list-style-type: none; margin-bottom: 1rem;">
                        <p style="line-height: 22px; padding: 10px">
                            <b><?= $pby ?></b><br />
                            <?=$processFile?><br />
                            <?= $process_msg ?><br />
                            <span style="float: right; font-size: 12px; padding-right: 20px"><?= $process_time ?></span>
                        </p>                                    
                    </li><?php
                }
            } ?>
            </ul><?php
        } else {
            echo "<h2 style='text-align:center; color:red'>No records found!</h2>";
        }//End of if else
    }//End of getTicket()
}//End of Tickets

