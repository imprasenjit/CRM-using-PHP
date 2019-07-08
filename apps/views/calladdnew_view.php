<?php
$qtypes = $this->querytypes_model->get_rows(2);
if (isset($result)) {
    $title = "Edit Call Information";
    $call_id = $result->call_id;
    $cno = $result->cno;
    $email = $result->email;
    $cname = $result->cname;
    $qtype_id = $result->query_type;
    $qtypeRow = $this->querytypes_model->get_row($qtype_id);
    $qtype_name = ($qtypeRow)?$qtypeRow->qtype_name:"Not found";
    $query = $result->query;
    $remarks = $result->remarks;
} else {
    $title = "New Call Registration";
    $call_id = "";
    $cno = set_value("cno");
    $email = set_value("email");
    $cname = set_value("cname");
    $qtype_id = set_value("query_type");
    $qtypeRow = $this->querytypes_model->get_row($qtype_id);
    $qtype_name = ($qtypeRow)?$qtypeRow->qtype_name:"Select";
    $query = set_value("query");
    $remarks = set_value("remarks");
}//End of if else
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Calls - EODB Support</title>      
        <?php $this->load->view('requires/cssjs'); ?>
        <link href="<?=base_url('public/jquery-ui-1.12.1/jquery-ui.min.css')?>" rel="stylesheet" type="text/css" />
        <script src="<?=base_url('public/jquery-ui-1.12.1/jquery-ui.min.js')?>"></script>
        <script src="<?=base_url('public/tinymce/tinymce.min.js')?>"></script>
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
                
                $("#ticket").change(function() {
                    if(this.checked) {
                        $(".tickets").fadeIn("slow");
                    } else {
                        $(".tickets").fadeOut("slow");
                    }
                });
                
                $(document).on("blur", "#cno", function(){
                    var cno  = $(this).val();
                    if(cno.length === 10) {
                        $.ajax({
                            type: "POST",
                            url: "<?=base_url('calls/getcustinfo')?>",
                            dataType:"json",
                            data: {"cno" : cno},
                            success: function(res){
                                if(res.flag == "1") {
                                    $("#email").val(res.email);
                                    $("#cname").val(res.cname);
                                } else {
                                    $("#email").val("");
                                    $("#cname").val("");
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
                    <li class="breadcrumb-item active">Calls</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card frmcard border-primary">
                            <form action="<?=base_url('calls/save')?>" method="post">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                <div class="card-header">
                                    <i class="fa fa-university"></i> <?=$title?>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="call_id" id="call_id" value="<?=$call_id?>" />
                                    <div class="row">
                                        <div class=" col-md-6 form-group">
                                            <label>Mobile<span class="text-danger">*</span></label>
                                            <input type="text" name="cno" id="cno" value="<?=$cno?>" class="form-control" maxlength="10" autocomplete="off" />
                                            <?=form_error("cno")?>
                                        </div>
                                        
                                        <div class="col-md-6 form-group">
                                            <label>Name<span class="text-danger">*</span></label>
                                            <input type="text" name="cname" id="cname" value="<?=$cname?>" class="form-control" />
                                            <?=form_error("cname")?>
                                        </div>
                                    </div> <!-- End of .row -->

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Query Type<span class="text-danger">*</span></label>
                                            <select name="query_type" class="form-control">
                                                <option value="">Select</option>
                                                <?php if($qtypes) {
                                                    foreach($qtypes as $qtyp) {
                                                        if($qtyp->qtype_id == $qtype_id) {
                                                            echo '<option value="'.$qtyp->qtype_id.'" selected>'.$qtyp->qtype_name.'</option>'; 
                                                        } else {
                                                            echo '<option value="'.$qtyp->qtype_id.'"">'.$qtyp->qtype_name.'</option>';
                                                        }
                                                    } //End of foreach  
                                                } else {
                                                    echo "<option value=''>No records found</option>";
                                                } //End of if else ?>                               
                                            </select>
                                            <?=form_error("query_type")?>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Query</label>
                                            <textarea name="query" class="form-control content"><?=$query?></textarea>
                                            <?=form_error("query")?>
                                        </div>
                                    </div> <!-- End of .row -->

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Remarks/Description (If any)</label>
                                            <textarea name="remarks" class="form-control content"><?=$remarks?></textarea>
                                            <?=form_error("remarks")?>
                                        </div>
                                    </div> <!-- End of .row -->
                                    
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <div class="form-group form-check">
                                                <input name="isticket" value="IsTicket" type="checkbox" class="form-check-input" id="ticket">
                                                <label class="form-check-label" for="ticket">Raise a ticket</label>
                                            </div>
                                        </div>
                                    </div> <!-- End of .row -->
                                    
                                    <div class="row tickets" style="display: none">
                                        <div class=" col-md-6 form-group">
                                            <label>UBIN/UAIN<span class="text-danger">*</span></label>
                                            <input type="text" name="ubin" value="" class="form-control" autocomplete="off" />
                                            <?=form_error("ubin")?>
                                        </div>
                                        <div class=" col-md-6 form-group">
                                            <label>Email<span class="text-danger">*</span></label>
                                            <input type="text" name="email" id="email" value="<?=$email?>" class="form-control" autocomplete="off" />
                                            <?=form_error("email")?>
                                        </div>
                                    </div> <!-- End of .row -->

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