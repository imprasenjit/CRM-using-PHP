<?php
if (isset($result)) {
    $title = "Edit Support Information";
    $support_id = $result->support_id;
    $email = $result->email;
    $cno = $result->cno;
    $ubin = $result->ubin;
    $cname = $result->cname;
    $caddress = $result->caddress;
    $qtype_id = $result->query_type;
    $qtype_name = ($this->querytypes_model->get_row($qtype_id))?$this->querytypes_model->get_row($qtype_id)->qtype_name:"Not found";
    $query = $result->query;
    $remarks = $result->remarks;
    $priority = $result->priority;
    $uid = $result->uid;
    $user_name = ($this->users_model->get_row($uid))?$this->users_model->get_row($uid)->user_name:"Not assigned";
    $mark_to = $result->mark_to;
} else {
    $title = "New Support Registration";
    $support_id = "";
    $email = set_value("email");
    $cno = set_value("cno");
    $ubin = set_value("ubin");
    $cname = set_value("cname");
    $caddress = set_value("caddress");
    $qtype_id = set_value("query_type");
    $qtype_name = ($this->querytypes_model->get_row($qtype_id))?$this->querytypes_model->get_row($qtype_id)->qtype_name:"Select";
    $query = set_value("query");
    $remarks = set_value("remarks");  
    $priority = 3;
    $uid = set_value("uid");
    $user_name = ($this->users_model->get_row($uid))?$this->users_model->get_row($uid)->user_name:"Select";
    $mark_to = set_value("mark_to");
}//End of if else

if(strlen($mark_to) > 0) {
    $mrksto = explode(",", $mark_to);
} else {
    $mrksto = array();
}//End of if else
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>New Ticket - EODB Support</title>      
        <?php $this->load->view('requires/cssjs'); ?>        
        
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <link rel="stylesheet" href="<?=base_url('public/css/jquery.multiselect.css')?>" />
        <link href="<?=base_url('public/jquery-ui-1.12.1/jquery-ui.min.css')?>" rel="stylesheet" type="text/css" />
        <script src="<?=base_url('public/jquery-ui-1.12.1/jquery-ui.min.js')?>"></script>
        <script src="<?=base_url('public/tinymce/tinymce.min.js')?>"></script>
        <script src="<?=base_url('public/js/jquery.multiselect.js')?>" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".dp").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    maxDate: "-1m -1d",
                    dateFormat: "dd-mm-yy"
                }); //End of onclick .datepicker
                
                tinymce.init({ 
                    selector:"textarea.content",
                    height: 150,
                    plugins: "table"

                }); //End of tinymce
                    
                $("#mark_to").multiselect({
                    columns: 1,
                    placeholder: "Select Recipient(s)",
                    search: true,
                    selectAll: true
                });
    
                $(document).on("blur", "#email", function(){
                    var email  = $(this).val();
                    if(email.length > 5) {
                        $.ajax({
                            type: "POST",
                            url: "<?=base_url('supports/getcustinfo')?>",
                            dataType:"json",
                            data: {"email" : email, "<?=$this->security->get_csrf_token_name()?>" : "<?=$this->security->get_csrf_hash()?>"},
                            success: function(res){
                                if(res.flag == "1") {
                                    $("#cno").val(res.cno);
                                    $("#cname").val(res.cname);
                                    $("#caddress").val(res.caddress);
                                    $("#ubin").val(res.ubin);
                                } else {
                                    $("#cno").val("");
                                    $("#cname").val("");
                                    $("#caddress").val("");
                                    $("#ubin").val("");
                                }                                
                            }
                        }); //End of ajax()
                    }
                });
            });
        </script>
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
                    <li class="breadcrumb-item active">Supports</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card frmcard border-primary">
                            <form action="<?=base_url('supports/save')?>" method="post">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                <div class="card-header">
                                    <i class="fa fa-university"></i> <?=$title?>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="support_id" id="support_id" value="<?=$support_id?>" />
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
                                        <div class="col-md-6 form-group">
                                            <label>Name<span class="text-danger">*</span></label>
                                            <input type="text" name="cname" id="cname" value="<?=$cname?>" class="form-control" />
                                            <?=form_error("cname")?>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>UBIN/UAIN<span class="text-danger">*</span></label>
                                            <input type="text" name="ubin" id="ubin" value="<?=$ubin?>" class="form-control" autocomplete="off" />
                                            <?=form_error("ubin")?>
                                        </div>
                                    </div> <!-- End of .row -->

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Query Type<span class="text-danger">*</span></label>
                                            <select name="query_type" class="form-control">
                                                <?php if(isset($qtypes)) {
                                                    echo '<option value="'.$qtype_id.'">'.$qtype_name.'</option>';
                                                    foreach($qtypes as $qtyp) {
                                                        if($qtyp->qtype_id != $qtype_id) {
                                                            echo '<option value="'.$qtyp->qtype_id.'">'.$qtyp->qtype_name.'</option>';
                                                        }
                                                    } //End of foreach  
                                                } else {
                                                    echo "<option value=''>No records found</option>";
                                                } //End of if else ?>
                                            </select>
                                            <?=form_error("query_type")?>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Priority<span class="text-danger">*</span></label><br />
                                            <div class="form-check form-check-inline">
                                                <input <?=($priority=="1")?"checked":""?> class="form-check-input" type="radio" name="priority" id="p1" value="1" style="margin-left: 0">
                                                <label class="form-check-label" for="p1">High</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input <?=($priority=="2")?"checked":""?> class="form-check-input" type="radio" name="priority" id="p2" value="2" style="margin-left: 0">
                                                <label class="form-check-label" for="p2">Medium</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input <?=($priority=="3")?"checked":""?> class="form-check-input" type="radio" name="priority" id="p3" value="3" style="margin-left: 0">
                                                <label class="form-check-label" for="p3">Low</label>
                                            </div>
                                            <br />
                                            <?=form_error("priority")?>
                                        </div>
                                    </div> <!-- End of .row -->

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Query<span class="text-danger">*</span></label>
                                            <textarea name="query" class="form-control content"><?=$query?></textarea>
                                            <?=form_error("query")?>
                                        </div>
                                    </div> <!-- End of .row -->
                                    
                                    <div class="row">
                                        <div class=" col-md-6 form-group">
                                            <label>Assign to</label>
                                            <select name="uid" class="form-control" <?=isRight("ticket_assign")?"":"disabled"?>>
                                                <?php if($this->users_model->get_staffrows()) {
                                                    echo '<option value="'.$uid.'">'.$user_name.'</option>'; 
                                                    foreach($this->users_model->get_staffrows() as $usr) {
                                                        if($usr->uid != $uid) {
                                                            echo '<option value="'.$usr->uid.'"">'.$usr->user_name.'</option>';
                                                        }
                                                    } //End of foreach  
                                                } else {
                                                    echo "<option value=''>No records found</option>";
                                                } //End of if else ?>
                                            </select>
                                            <?=form_error("uid")?>
                                        </div>
                                        
                                        
                                        <div class=" col-md-6 form-group">
                                            <label>Mark to</label>
                                            <select name="mark_to[]" id="mark_to" class="form-control" multiple="multiple">
                                                <?php 
                                                if($this->users_model->get_deptrows()) {
                                                    foreach($this->users_model->get_deptrows() as $usr) {
                                                        echo '<option value="'.$usr->uid.'">'.$usr->user_name.'</option>';
                                                    } //End of foreach  
                                                } else {
                                                    echo "<option value=''>No records found</option>";
                                                } //End of if else ?>
                                            </select>
                                            <?=form_error("uid")?>
                                        </div>
                                    </div>
                                    
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
                    </div><!--End of .col-md-12-->
                </div><!--End of .row-->
            </div><!--End of container-fluid-->
            <?php $this->load->view('requires/footer'); ?>
            <?php $this->load->view('requires/logoutmodal'); ?>
        </div>
    </body>
</html>