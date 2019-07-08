<?php
if (isset($result)) {
    $title = "Edit Customer Information";
    $customer_id = $result->customer_id;
    $customer_name = $result->customer_name;
    $company_name = $result->company_name;
    $contact_no = $result->contact_no;
    $email_id = $result->email_id;
    $address = $result->address;
} else {
    $title = "New Customer Registration";
    $customer_id = "";
    $customer_name = set_value("customer_name");
    $company_name = set_value("company_name");
    $contact_no = set_value("contact_no");
    $email_id = set_value("email_id");
    $address = set_value("address");
} ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Customers - EODB Support</title>      
        <?php $this->load->view('requires/cssjs'); ?>
        <script src="<?=base_url('public/tinymce/tinymce.min.js')?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                tinymce.init({ 
                    selector:"textarea.content",
                    height: 150,
                    plugins: "table"

                }); //End of tinymce
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
                    <li class="breadcrumb-item active">Customers</li>
                    <li style="float: right">
                        <a href="javascript:history.back(-1)" class="btn btn-info" style="margin: 0px; padding: 4px;">
                            <i class="fa fa-chevron-circle-left"></i> Back
                        </a>
                    </li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card frmcard border-primary">
                            <form action="<?=base_url('customers/save')?>" method="post">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                <div class="card-header">
                                    <i class="fa fa-university"></i> <?=$title?>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="customer_id" id="customer_id" value="<?=$customer_id?>" />
                                    <div class="row">
                                        <div class=" col-md-6 form-group">
                                            <label>Customer Name<span class="text-danger">*</span></label>
                                            <input type="text" name="customer_name" value="<?=$customer_name?>" class="form-control" autocomplete="off" />
                                            <?=form_error("customer_name")?>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>Company<span class="text-danger">*</span></label>
                                            <input type="text" name="company_name" value="<?=$company_name?>" class="form-control" />
                                            <?=form_error("company_name")?>
                                        </div>
                                    </div> <!-- End of .row -->

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Contact No.<span class="text-danger">*</span></label>
                                            <input type="text" name="contact_no" value="<?=$contact_no?>" class="form-control" maxlength="10" />
                                            <?=form_error("contact_no")?>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Email ID<span class="text-danger">*</span></label>
                                            <input type="text" name="email_id" value="<?=$email_id?>" class="form-control" />
                                            <?=form_error("email_id")?>
                                        </div>
                                    </div> <!-- End of .row -->

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Address<span class="text-danger">*</span></label>
                                            <textarea name="address" class="form-control content"><?=$address?></textarea>
                                            <?=form_error("address")?>
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