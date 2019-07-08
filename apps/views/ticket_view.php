<?php
$title = "Raise a new ticket";
$email = set_value("email");
$cno = set_value("cno");
$ubin = set_value("ubin");
$cname = set_value("cname");
$caddress = set_value("caddress");
$qtype_id = set_value("query_type");
$qtype_name = ($this->querytypes_model->get_row($qtype_id))?$this->querytypes_model->get_row($qtype_id)->qtype_name:"Select type";
$query = set_value("query");
$remarks = set_value("remarks");
$support_time = date("d-m-Y H:i:s");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" href="<?=base_url('public/imgs/favicon.ico')?>" type="image/ico">
        <link href="<?=base_url('public/bootstrap-4/css/bootstrap.min.css')?>" rel="stylesheet">
        <link href="<?=base_url('public/font-awesome-4.7.0/css/font-awesome.min.css')?>" rel="stylesheet">
        <link href="<?=base_url('public/css/animate.css')?>" rel="stylesheet">
        <script src="<?=base_url('public/js/notify.min.js')?>"></script>
        <link href="<?=base_url('public/css/site.css')?>" rel="stylesheet">
        <title>EODB Supports</title>
        <style type="text/css">            
            .card-header {
                font-size: 22px; 
                padding: .3rem 1.25rem; 
                text-transform: uppercase;
                font-weight: bold;
            }
        </style>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src="<?=base_url('public/js/jquery-3.3.1.min.js')?>"></script>
        <script src="<?=base_url('public/tinymce/tinymce.min.js')?>"></script>
        <script src="<?=base_url('public/pekeupload/js/pekeUpload.js')?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {                
                tinymce.init({ 
                    selector:"textarea.content",
                    height: 150,
                    plugins: "table"
                }); //End of tinymce
                
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
        <section class="features-icons bg-light" style="padding-top: 10px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card frmcard border-primary">
                            <form action="<?=base_url('ticket/save')?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                <div class="card-header">
                                    <i class="fa fa-edit"></i> <?=$title?>
                                </div>
                                <div class="card-body">
                                    <?php if ($this->session->flashdata("flashMsg")) { ?>
                                        <div class="alert alert-success" role="alert"><?=$this->session->flashdata("flashMsg")?></div>
                                    <?php } ?>    
                                    <div class="row">
                                        <div class=" col-md-6 form-group">
                                            <label>Email<span class="text-danger">*</span></label>
                                            <input type="text" name="email" id="email" value="<?=$email?>" class="form-control" autocomplete="off" />
                                            <?=form_error("email")?>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Contact no.<span class="text-danger">*</span></label>
                                            <input type="text" name="cno" id="cno" value="<?=$cno?>" class="form-control" maxlength="10" />
                                            <?=form_error("cno")?>
                                        </div>
                                    </div> <!-- End of .row -->                                
                                    <div class="row">
                                        <div class=" col-md-12 form-group">
                                            <label>UBIN/UAIN<span class="text-danger">*</span></label>
                                            <input type="text" name="ubin" id="ubin" value="<?=$ubin?>" class="form-control" autocomplete="off" />
                                            <?=form_error("ubin")?>
                                        </div>
                                    </div> <!-- End of .row -->

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Name<span class="text-danger">*</span></label>
                                            <input type="text" name="cname" id="cname" value="<?=$cname?>" class="form-control" />
                                            <?=form_error("cname")?>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Query Type<span class="text-danger">*</span></label>
                                            <select name="query_type" class="form-control">
                                                <option value="<?=$qtype_id?>" selected="selected"><?=$qtype_name?></option>
                                                <?php 
                                                if(isset($qtypes)) {
                                                    foreach($qtypes as $qtyp) { ?>
                                                    <option value="<?=$qtyp->qtype_id?>" >
                                                        <?=$qtyp->qtype_name?>
                                                    </option>
                                                    <?php } //End of foreach  ?>
                                                <?php } else {
                                                    echo "<option value=''>No records found</option>";
                                                } //End of if else ?>
                                            </select>
                                            <?=form_error("query_type")?>
                                        </div>
                                    </div> <!-- End of .row -->
                                    <p style="font-weight:bold">
                                        <strong style="color: #dd4b39;">NOTE : </strong>For any Departmental issues related  to applications which has exceeded the time limit or any other Departmental related grievance ,please go to this link and submit :
                                        <a href="https://easeofdoingbusinessinassam.in/homepage/grievance.php" target="_blank">  Public Grievances </a>
                                    </p>

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Query<span class="text-danger">*</span></label>
                                            <textarea name="query" class="form-control content"><?=$query?></textarea>
                                            <?=form_error("query")?>
                                        </div>
                                    </div> <!-- End of .row -->
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>File (If Any)</label><br />
                                            <input type="file" name="files" id="files" />
                                        </div>
                                    </div><!--End of .row-->
                                    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="g-recaptcha" data-sitekey="<?=SITE_KEY?>"></div>
                                        </div>
                                    </div><!--End of .row-->
                                </div><!--End of .card-body-->
                                
                                <div class="card-footer text-center">
                                    <button type="reset" class="btn btn-danger">
                                        <i class="fa fa-remove"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-check"></i> Save
                                    </button>
                                </div><!--End of .card-footer-->
                            </form>
                        </div><!--End of .card-->
                    </div>
                </div>
            </div>
        </section>       
        <?php $this->load->view("requires/sitefooter"); ?>
    </body>
</html>

