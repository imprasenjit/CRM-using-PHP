<?php $sid = $this->session->session_uid; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Dashboard - Welcome to EODB Support</title>      
        <?php $this->load->view('requires/cssjs'); ?>
        <link rel="stylesheet" href="<?=base_url('public/css/loading.css')?>" />
        <link rel="stylesheet" href="<?=base_url('public/datatables/css/dataTables.bootstrap4.min.css')?>" />
        <script src="<?=base_url('public/datatables/js/jquery.dataTables.min.js')?>"></script>
        <script src="<?=base_url('public/datatables/js/dataTables.bootstrap4.min.js')?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".dtbl").DataTable({
                    "order": [[0, 'desc']],
                    "lengthMenu": [[5, 20, 50, 100, 200], [5, 20, 50, 100, 200]]
                });
                
                $("#callviewModal").on("show.bs.modal", function (e) {
                    var call_id = e.relatedTarget.id;
                    $.ajax({
                        type: "POST",
                        url: "<?=base_url('calls/getDetails')?>",
                        data: {"call_id" : call_id, "<?=$this->security->get_csrf_token_name()?>" : "<?=$this->security->get_csrf_hash()?>"},
                        beforeSend: function(){
                            $("#callviewModalBody").html("<div class='loading'></div>");
                        },
                        success: function(res){
                            $("#callviewModalBody").html(res);
                        }
                    }); //End of ajax()
                }); // End of .on moda
                
                $("#supportviewModal").on("show.bs.modal", function (e) {
                    var support_id = e.relatedTarget.id;
                    $.ajax({
                        type: "POST",
                        url: "<?=base_url('tickets/getDetails')?>",
                        data: {"support_id" : support_id, "<?=$this->security->get_csrf_token_name()?>" : "<?=$this->security->get_csrf_hash()?>"},
                        beforeSend: function(){
                            $("#supportviewModalBody").html("<div class='loading'></div>");
                        },
                        success: function(res){
                            $("#supportviewModalBody").html(res);
                        }
                    }); //End of ajax()
                }); // End of .on modal
            });
        </script>
        <style type="text/css">
            .table td, .table th {
                padding: .3rem;
                vertical-align: middle;
                border-top: 1px solid #e9ecef;
            }
        </style>
    </head>
    </head>
    <body class="fixed-nav sticky-footer bg-dark" id="page-top">
        <?php if ($this->session->flashdata("accessMsg")) { ?>
            <script type="text/javascript">
                $.notify("<?=$this->session->flashdata("accessMsg")?>", "warn");
            </script>
        <?php } ?>
        <?php $this->load->view('requires/navbar'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?=base_url('')?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">My Dashboard</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-primary o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fa fa-fw fa-comments"></i>
                                </div>
                                <div class="mr-5"><?=$this->ticketsnew_model->tot_userrows($sid)?> NEW!</div>
                            </div>
                            <a href="<?=base_url('supports')?>" class="card-footer text-white clearfix small z-1">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                    <i class="fa fa-angle-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-warning o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fa fa-fw fa-folder-open-o"></i>
                                </div>
                                <div class="mr-5"><?=$this->ticketsopen_model->tot_userrows($sid)?> OPEN!</div>
                            </div>
                            <a href="<?=base_url('ticketsopen')?>" class="card-footer text-white clearfix small z-1">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                    <i class="fa fa-angle-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-success o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fa fa-fw fa-check-square-o"></i>
                                </div>
                                <div class="mr-5"><?=$this->ticketsclose_model->tot_userrows($sid)?> RESOLVED!</div>
                            </div>
                            <a href="<?=base_url('ticketsclose')?>" class="card-footer text-white clearfix small z-1">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                    <i class="fa fa-angle-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-danger o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fa fa-fw fa-phone-square"></i>
                                </div>
                                <div class="mr-5"><?=$this->tickets_model->tot_userrows($sid)?> TOTAL</div>
                            </div>
                            <a href="<?=base_url('tickets')?>" class="card-footer text-white clearfix small z-1">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                    <i class="fa fa-angle-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                                
                <div class="row">
                    <div class="col-md-12" style="padding-left:10px; padding-right: 10px;">
                        <div class="card tblcard border-secondary">
                            <div class="card-header">
                                <i class="fa fa-info-circle"></i> Last tickets generated
                                <a href="<?=base_url('supports/addnew')?>" class="btn btn-primary" style="margin: 0px; padding: 4px; float: right">
                                    <i class="fa fa-plus-circle"></i> Generate new tickets
                                </a>
                            </div>
                            <div class="card-body card-body-padding" style="padding: 1px">
                                <table class="table table-bordered dtbl">
                                    <thead>
                                        <tr>
                                            <th>Ticket ID.</th>
                                            <th>Query Type</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if($this->supports_model->get_lastuserrows($sid)) {
                                            foreach ($this->supports_model->get_lastuserrows($sid) as $rows) {
                                                $support_id = $rows->support_id;
                                                $cname  = $rows->cname;
                                                $status = getstatus($rows->support_status);
                                                ?>
                                                <tr>
                                                    <td><?=sprintf("%05d", $support_id)?></td>
                                                    <td>
                                                        <a id="<?=$support_id?>" data-toggle="modal" data-target="#supportviewModal" href="javascript:void(0)">
                                                            <?=word_limiter($cname, 2)?>
                                                        </a>
                                                    </td>
                                                    <td><?=$status?></td>
                                                </tr>
                                            <?php                     
                                            }// End of foreach
                                        }// End of if  
                                        ?>                           
                                    </tbody>
                                </table>
                            </div><!--End of card-body-->
                        </div><!--End of .card-->
                    </div><!--End of .col-md-12-->
                </div><!--End of .row-->
            </div><!--End of container-fluid-->
            <?php $this->load->view('requires/footer'); ?>
            <?php $this->load->view('assets/callviewmodal'); ?>
            <?php $this->load->view('assets/supportviewmodal'); ?>
            <?php $this->load->view('requires/logoutmodal'); ?>
        </div>
    </body>
</html>


