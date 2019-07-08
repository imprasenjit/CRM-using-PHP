<?php
$sutype = $this->session->session_utype;
if (isset($result)) {
    $support_id = $result->support_id;
    $ticket_no = $result->ticket_no;
    $email = $result->email;
    $cno = $result->cno;
    $ubin = $result->ubin;
    $cname = $result->cname;
    $caddress = $result->caddress;
    $qtype_id = $result->query_type;
    $qtype_name = ($this->querytypes_model->get_row($qtype_id))?$this->querytypes_model->get_row($qtype_id)->qtype_name:"Not found";
    $query = $result->query;
    $query_file = $result->query_file;
    if(strlen($query_file) > 10) {
        $queryFile = '<a href="'.base_url('storage/uploads/'.$query_file).'" target="_blank"><i class="fa fa-cloud-download"></i> Download/View File</a>';
    } else {
        $queryFile = "Not uploaded";
    }
    $remarks = $result->remarks;
    $support_time = $result->support_time;
    $priority = getpriority($result->priority);
    $uid = $result->uid;
    $user_name = ($this->users_model->get_row($uid))?$this->users_model->get_row($uid)->user_name:"Not yet assign";
    $status = getstatus($result->support_status);
} else {
    die("No records found!");
}//End of if else
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Ticket details - EODB Support</title>      
        <?php $this->load->view('requires/cssjs'); ?>
        <link rel="stylesheet" href="<?=base_url('public/css/jquery.multiselect.css')?>" />
        <script src="<?=base_url('public/js/jquery.multiselect.js')?>" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".mark_to").multiselect({
                    columns: 1,
                    placeholder: "Select Recipient(s)",
                    search: true,
                    selectAll: true
                });
                
                $("#supportassignModal").on("show.bs.modal", function (e) {
                    var support_id = e.relatedTarget.id;
                    $("#assign_sid").val(support_id);
                }); // End of .on modal
                
                $("#supportreplyModal").on("show.bs.modal", function (e) {
                    var support_id = e.relatedTarget.id;
                    $("#reply_sid").val(support_id);
                }); // End of .on modal
                
                $("#supportcloseModal").on("show.bs.modal", function (e) {
                    var support_id = e.relatedTarget.id;
                    $("#close_sid").val(support_id);
                }); // End of .on modal
            });
        </script>
        <style type="text/css">
            p {
                padding-left: 10px;
                margin-bottom: 0rem;
            }
        </style>
    </head>
    <body class="fixed-nav sticky-footer bg-dark" id="page-top">
        <?php if ($this->session->flashdata("flashMsg")) { ?>
            <script type="text/javascript">
                $.notify("<?=$this->session->flashdata("flashMsg")?>", "success");
            </script>
        <?php } ?>
        <?php $this->load->view('requires/navbar'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <ol class="breadcrumb" style="padding: .5rem; margin-bottom: 1rem">
                    <li class="breadcrumb-item">
                        <a href="<?=base_url('')?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Ticket details</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card frmcard border-primary">
                            <div class="card-header">
                                <i class="fa fa-university"></i> Supports details
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">Ticket ID. : </div>
                                    <div class="col-md-8"><?= $support_id ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Ticket No. : </div>
                                    <div class="col-md-8"><?=$ticket_no?></div>
                                </div>
			        <div class="row">
				    <div class="col-md-4">Ticket Time : </div>
				    <div class="col-md-8"><?= date("D, d M Y h:i A", strtotime($support_time)) ?></div>
			        </div>
                                <div class="row">
                                    <div class="col-md-4">Name : </div>
                                    <div class="col-md-8"><?=$cname?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Email ID : </div>
                                    <div class="col-md-8"><?=$email?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Mobile No. : </div>
                                    <div class="col-md-8"><?=$cno?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">UBIN / UAIN : </div>
                                    <div class="col-md-8"><?=$ubin?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Query Type : </div>
                                    <div class="col-md-8"><?=$qtype_name?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Query : </div>
                                    <div class="col-md-8"><?=$query?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">File uploaded (If Any) : </div>
                                    <div class="col-md-8"><?=$queryFile?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Priority : </div>
                                    <div class="col-md-8"><?=$priority?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Current status : </div>
                                    <div class="col-md-8">
                                        <?=$status?>   
                                        <?php if($sutype != 4) { ?>
                                        <span id="<?=$support_id?>" data-toggle="modal" data-target="#supportcloseModal" style="float:right; margin:0px 5px">
                                            <a href="javascript:void(0)" class="btn btn-warning" data-toggle="tooltip" title="Resolve">
                                                <i class="fa fa-check-circle"></i> Resolve
                                            </a>
                                        </span>                                        
                                        <?php }
                                        if(isRight("ticket_assign")) { ?>
                                            <span id="<?=$support_id?>" data-toggle="modal" data-target="#supportassignModal" style="float:right; margin:0px 5px">
                                                <a href="javascript:void(0)" class="btn btn-success" data-toggle="tooltip" title="Assign">
                                                    <i class="fa fa-user-plus"></i> Assign
                                                </a>
                                            </span>
                                        <?php } ?> 
                                        
                                        <span id="<?=$support_id?>" data-toggle="modal" data-target="#supportreplyModal" style="float:right">
                                            <a href="javascript:void(0)" class="btn btn-primary" data-toggle="tooltip" title="Reply">
                                                <i class="fa fa-envelope-o"></i> Reply
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div><!--End of .card-body-->
                            <hr />
                            <ul class="">
                                <?php
                                if(isset($results)) {
                                    foreach ($results as $rows) {
                                        $support_id = $rows->support_id;
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
                                        $process_msg = $rows->process_msg;
                                        $typ = $rows->process_type;
                                        $ptype = ($typ>1)?" (".getprocesstype($rows->process_type).")":"";
                                        ?>
                                        <li style="list-style-type: none; margin-bottom: 1rem;">
                                            <p style="line-height: 22px;">
                                            <b><?=$pby?></b><?=$ptype?><br />
                                            <?=$process_msg?><br />
                                            <?=$processFile?><br />
                                            <span style="float: right; font-size: 12px; padding-right: 20px"><?=$process_time?></span>
                                            </p>                                    
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
			    <!--
                            <form action="<?=base_url('comments/save')?>" method="post">
                                <input type="hidden" name="support_id" id="support_id" value="<?=$support_id?>" />
                                <div class="row">
                                    <div class="col-md-12 form-group" style="padding-left:30px; padding-right: 30px">
                                        <label>Comment (If any)</label>
                                        <textarea name="comment" class="content"></textarea>
                                        <?=form_error("comment")?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center" style="margin-bottom:15px">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-check"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </form>-->
                        </div><!--End of .card-->
                    </div><!--End of .col-md-12-->
                </div><!--End of .row-->
            </div><!--End of container-fluid-->
            <?php $this->load->view('requires/footer'); ?>
            <?php $this->load->view('assets/supportreplymodal'); ?>
            <?php $this->load->view('assets/supportassignmodal'); ?>
            <?php $this->load->view('assets/supportclosemodal'); ?>
            <?php $this->load->view('requires/logoutmodal'); ?>
        </div>
    </body>
</html>

