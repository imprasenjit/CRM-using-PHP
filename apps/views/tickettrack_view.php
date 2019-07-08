<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" href="<?=base_url('public/imgs/favicon.ico')?>" type="image/ico">
        <link href="<?=base_url('public/bootstrap-4/css/bootstrap.min.css')?>" rel="stylesheet">
        <link href="<?=base_url('public/font-awesome-4.7.0/css/font-awesome.min.css')?>" rel="stylesheet">
        <link href="<?=base_url('public/css/animate.css')?>" rel="stylesheet">
        <link href="<?=base_url('public/css/site.css')?>" rel="stylesheet">
        <title>Track ticket :: EODB Supports</title>
        <style type="text/css">
            .card-header {
                font-size: 22px; 
                padding: .3rem 1.25rem; 
                text-transform: uppercase;
                font-weight: bold;
            }
            p {
                padding-left: 10px;
                margin-bottom: 0rem;
            }
            .close {
                cursor: pointer;
            }
        </style>
        <script src="<?=base_url('public/js/jquery-3.3.1.min.js')?>"></script>
        <script src="<?=base_url('public/js/notify.min.js')?>"></script>
        <script src="<?=base_url('public/bootstrap-4/js/bootstrap.bundle.min.js')?>"></script>
        <script src="<?=base_url('public/pekeupload/js/pekeUpload.js')?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".alert").alert();
                $("#files").pekeUpload({
                    bootstrap: true,
                    limit: 1,
                    maxSize: 5,
                    url: "<?=base_url('public/pekeupload/upload.php')?>"
                });
            });            
        </script>
    </head>
    <body>
        <?php $this->load->view("requires/sitenavbar"); ?>
        <section class="features-icons bg-light">
            <div class="container" style="min-height: 300px">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card frmcard border-primary">
                            <div class="card-header">
                                <i class="fa fa-search-plus"></i> Track your ticket status
                                <a href="javascript:history.back(-1)" class="btn btn-info" style="float: right; margin: 0px; padding: 4px;">
                                    <i class="fa fa-chevron-circle-left"></i> Back
                                </a>
                            </div>
                            <div class="card-body">                                
                                <?php
                                if (isset($result)) {
                                    $title = "Edit Support Information";
                                    $ticket_no = $result->ticket_no;
                                    $email = $result->email;
                                    $cno = $result->cno;
                                    $ubin = $result->ubin;
                                    $cname = $result->cname;
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
                                    $support_status = $result->support_status;
                                    $status = getstatus($support_status); ?>
                                <div class="row">
                                    <div class="col-md-4">Ticket No. : </div>
                                    <div class="col-md-8"><?=$ticket_no?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Ticket Time : </div>
                                    <div class="col-md-8"><?= date("D, d M Y h:i A", strtotime($support_time)) ?></div>
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
                                    <div class="col-md-4">Current status : </div>
                                    <div class="col-md-8"><?=$status?></div>
                                </div>
                                </div><!--End of .card-body-->
                                <hr />
                                <ul class="">
                                    <?php
                                    if(isset($results)) {
                                        foreach ($results as $rows) {
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
                                            ?>
                                            <li style="list-style-type: none; margin-bottom: 1rem;">
                                                <p style="line-height: 22px; padding: 10px">
                                                <b><?=$pby?></b><br />
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
                                <?php if($support_status > 0 AND $support_status < 5) { ?>
                                <form action="<?=base_url('ticket/replied')?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                    <input type="hidden" name="ticket_no" value="<?=$ticket_no?>" />
                                    <div class="row">
                                        <div class="col-md-12 form-group" style="padding-left:50px; padding-right: 50px">
                                            <label>Reply<span class="text-danger">*</span></label>
                                            <textarea name="msg" class="form-control"></textarea>
                                            <?=form_error("msg")?>
                                        </div><!--End of .col-md-12-->
                                    </div><!--End of .row-->
                                    <div class="row">
                                        <div class="col-md-12 form-group" style="padding-left:50px; padding-right: 50px">
                                            <label>File (If Any)</label><br />
                                            <input type="file" name="files" id="files" />
                                        </div>
                                    </div><!--End of .row-->
                                    <div class="row">
                                        <div class="col-md-12 text-center" style="margin-bottom:15px">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-check"></i> Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <?php }
                                } else { ?>
                                    <?php if ($this->session->flashdata("flashMsg")) { ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <?= $this->session->flashdata("flashMsg") ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php } ?>
                                    <form action="<?= base_url('ticket/details') ?>" method="post" class="form-inline">
                                        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 5px; text-align: right; vertical-align: middle">
                                                        Ticket number : 
                                                    </td>
                                                    <td style="padding: 5px; text-align: center; vertical-align: middle">
                                                        <input name="ticket_no" value="<?=set_value("ticket_no")?>" type="text" class="form-control" id="support_id" placeholder="Enter your ticket number" />
                                                        <br /><?=form_error("ticket_no")?>
                                                    </td>
                                                    <td style="padding: 5px; text-align: left; vertical-align: middle">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fa fa-check"></i>
                                                            Track now
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                <?php }//End of if else ?>
                            </div><!--End of .card-body-->
                        </div><!--End of .card-->
                    </div>
                </div>
            </div>
        </section>       
        <?php $this->load->view("requires/sitefooter"); ?>
    </body>
</html>

