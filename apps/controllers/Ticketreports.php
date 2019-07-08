<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
class Ticketreports extends Alom {
    
    function __construct() {
        parent::__construct();
        $this->isloggedin();
        $this->load->model("querytypes_model");
        $this->load->model("ticketreports_model");
        $this->load->model("ticketsopen_model");
        $this->load->model("querytypes_model");
        $this->load->model("users_model");
        $this->load->helper("ticketstatus");
        $this->load->helper("text");
    }//End of __construct()
    
    function index() {
        $this->load->view("ticketreports_view");
    }//End of index()
    
    function getrecords() {
        $query_type=$this->input->post("query_type"); ?>
        <table class="table table-bordered print-content">
            <thead>
                <tr>
                    <th>New Tickets</th>
                    <th>Open Tickets</th>
                    <th>Staff Replied</th>
                    <th>Resolved Tickets</th>
                    <th>Total Tickets</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totTickets = $this->ticketreports_model->get_counts('query_type', $query_type); //die("Tot : ".$totTickets);
                $totNewTickets = $this->ticketreports_model->get_counts('query_type', $query_type, 'support_status', 1);
                $totStaffRepliedTickets = $this->ticketreports_model->get_counts('query_type', $query_type, 'support_status', 2);
                $totClosedTickets = $this->ticketreports_model->get_counts('query_type', $query_type, 'support_status', 5);
                $totOpenTickets = $totTickets-($totNewTickets+$totClosedTickets);
                ?>
                <tr>
                    <td><?=sprintf("%03d", $totNewTickets)?></td>
                    <td><?=sprintf("%03d", $totOpenTickets)?></td>
                    <td><?=sprintf("%03d", $totStaffRepliedTickets)?></td>
                    <td><?=sprintf("%03d", $totClosedTickets)?></td>
                    <td><?=sprintf("%03d", $totTickets)?></td>
                </tr>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#dtbl").DataTable({
                    "columns": [
                        {"data": "support_time"},
                        {"data": "cname"},
                        {"data": "query_type"},
                        {"data": "uid"},
                        {"data": "support_status"}
                    ],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "<?=base_url('ticketreports/getdtrecords')?>",
                        "dataType": "json",
                        "type": "POST",
                        data: {"query_type":<?=$query_type?>}
                    },
                    language: {
                        processing: "<div class='loading'></div>",
                    },
                    "order": [[4, 'ASC']],
                    "lengthMenu": [[20, 30, 50, 100, 200], [20, 30, 50, 100, 200]]
                });
            });
        </script>
        <table class="table table-bordered" id="dtbl">
            <thead>
                <tr>
                    <th>Query Time</th>
                    <th>Name</th>
                    <th>Query Type</th>
                    <th>Assign to</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    <?php }//End of getrecords()
    
    
    function getdtrecords() {
        $columns = array(
            0 => "support_time",
            1 => "cname",
            2 => "query_type",
            3 => "uid",
            4 => "support_status"
        );
        $query_type = $this->input->post("query_type");
        $limit = $this->input->post("length");
        $start = $this->input->post("start");
        $order = $columns[$this->input->post("order")[0]["column"]];
        $dir = $this->input->post("order")[0]["dir"];
        $totalData = $this->ticketreports_model->tot_rows('query_type', $query_type);
        $totalFiltered = $totalData;
        if (empty($this->input->post("search")["value"])) {
            $records = $this->ticketreports_model->all_rows('query_type', $query_type, $limit, $start, $order, $dir);
        } else {
            $search = $this->input->post("search")["value"];
            $records = $this->ticketreports_model->search_rows('query_type', $query_type, $limit, $start, $search, $order, $dir);
            $totalFiltered = $this->ticketreports_model->tot_search_rows('query_type', $query_type, $search);
        }
        $data = array();
        if (!empty($records)) {
            foreach ($records as $rows) {
                $support_id = $rows->support_id;
                $cname = $rows->cname;
                $support_time = date("d/m/Y H:i", strtotime($rows->support_time));
                $query_type = $rows->query_type;
                $qtypeRow = $this->querytypes_model->get_row($query_type);
                $qtype = ($qtypeRow)?$qtypeRow->qtype_name : "Not found";
                $qtyp = word_limiter($qtype, 3);
                $uid = $rows->uid;
                $assignto = ($this->users_model->get_row($uid))?$this->users_model->get_row($uid)->user_name:"Not found!";
                $status = getstatus($rows->support_status);
            
                $nestedData["support_time"] = $support_time;
                $nestedData["cname"] = '<a href="'.base_url('supports/details/').$support_id.'">'.word_limiter($cname, 3).'</a>';
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
    }//End of getdtrecords()
}//End of Ticketreports