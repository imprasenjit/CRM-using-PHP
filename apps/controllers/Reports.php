<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
class Reports extends Alom {
    
    function __construct() {
        parent::__construct();
        $this->isloggedin();
    }//End of __construct()
    
    function index() {
        $this->load->view("reports_view");
    }//End of index()
    
    function daterecords() {
        $this->load->model("tickets_model");
        $startDate=$this->input->post("frmdt");
        $endDate=$this->input->post("todt"); ?>
        <table class="table table-bordered print-content" id="dtbl">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>New Tickets</th>
                    <th>Open Tickets</th>
                    <th>Resolved Tickets</th>
                    <th>Total Tickets</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totNewTickets = 0;
                $totOpenTickets = 0;
                $totClosedTickets = 0;
                $totTickets = 0;
                while($endDate >= $startDate) {
                    $ticketRow = $this->tickets_model->get_datetickets($endDate);
                    $tot_ticket = $ticketRow?$ticketRow->tot_ticket:0;
                    $totTickets = $totTickets+$tot_ticket;
                    
                    $newTicketRow = $this->tickets_model->get_datetypetickets($endDate, 1);
                    $tot_newticket = $newTicketRow?$newTicketRow->tot_ticket:0;
                    $totNewTickets = $totNewTickets+$tot_newticket;
                    
                    $closedTicketRow = $this->tickets_model->get_datetypetickets($endDate, 5);
                    $tot_closedticket = $closedTicketRow?$closedTicketRow->tot_ticket:0;
                    $totClosedTickets = $totClosedTickets+$tot_closedticket;
                    
                    $tot_openticket = $tot_ticket-($tot_newticket+$tot_closedticket);
                    $totOpenTickets = $totOpenTickets+$tot_openticket; ?>
                    <tr>
                        <td><?=date("l, j<\s\up>S</\s\up> F Y", strtotime($endDate))?></td>
                        <td><?=sprintf("%03d", $tot_newticket)?></td>
                        <td><?=sprintf("%03d", $tot_openticket)?></td>
                        <td><?=sprintf("%03d", $tot_closedticket)?></td>
                        <td><?=sprintf("%03d", $tot_ticket)?></td>
                    </tr>
                <?php $endDate = date('Y-m-d',strtotime($endDate . "-1 days")); }//End of while()?>                         
            </tbody>
            <tfoot>
                <tr>
                    <th>Total Tickets</th>
                    <th><?=sprintf("%05d", $totNewTickets)?></th>
                    <th><?=sprintf("%05d", $totOpenTickets)?></th>
                    <th><?=sprintf("%05d", $totClosedTickets)?></th>
                    <th><?=sprintf("%05d", $totTickets)?></th>
                </tr>
                <tr class="avoid-me">
                    <td colspan="5" class="text-center">
                        <button class="btn btn-primary print-btn">
                            <i class="fa fa-print"></i> Print Report
                        </button>
                    </td>
                </tr>
            </tfoot>
        </table>
    <?php }//End of daterecords()
    
    function calls() {
        $this->load->view("callreports_view");
    }//End of calls()
    
    function callreports() {
        $this->load->model("calls_model");
        $startDate=$this->input->post("frmdt");
        $endDate=$this->input->post("todt"); ?>
        <table class="table table-bordered print-content" id="dtbl">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Calls</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totCalls = 0;
                while($endDate >= $startDate) {
                    $callRow = $this->calls_model->get_datecalls($endDate);
                    $tot_call = $callRow?$callRow->tot_calls:0;
                    $totCalls = $totCalls+$tot_call;?>
                    <tr>
                        <td><?=date("l, j<\s\up>S</\s\up> F Y", strtotime($endDate))?></td>
                        <td><?=sprintf("%03d", $tot_call)?></td>
                    </tr>
                <?php $endDate = date('Y-m-d',strtotime($endDate . "-1 days")); }//End of while()?>                         
            </tbody>
            <tfoot>
                <tr>
                    <th>Total Calls</th>
                    <th><?=sprintf("%05d", $totCalls)?></th>
                </tr>
                <tr class="avoid-me">
                    <td colspan="5" class="text-center">
                        <button class="btn btn-primary print-btn">
                            <i class="fa fa-print"></i> Print Report
                        </button>
                    </td>
                </tr>
            </tfoot>
        </table>
    <?php }//End of callreports()
}//End of Reports