<?php
if ($this->settings_model->get_row()) {
    $result = $this->settings_model->get_row();
    $setting_id = $result->setting_id;
    $superuser = $result->superuser;
    $superuserName = ($this->users_model->get_row($superuser))?$this->users_model->get_row($superuser)->user_name:"None";
    $assigneduser = $result->assigneduser;
    $assigneduserName = ($this->users_model->get_row($assigneduser))?$this->users_model->get_row($assigneduser)->user_name:"None";
} else {
    $this->session->set_flashdata("flashMsg", "No settings found");
    redirect(site_url("users"));
} ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Users - EODB Support</title>      
        <?php $this->load->view('requires/cssjs'); ?>
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
                    <li class="breadcrumb-item active">Default settings</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card frmcard border-primary">
                            <form action="<?=base_url('settings/save')?>" method="post">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                <div class="card-header">
                                    <i class="fa fa-university"></i> Default settings
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="setting_id" id="setting_id" value="<?=$setting_id?>" />
                                    <div class="row">
                                        <div class=" col-md-6 form-group">
                                            <label>Super admin<span class="text-danger">*</span></label>
                                            <input type="text" name="superuser" value="<?=$superuserName?>" class="form-control" disabled="disabled" />
                                            <?=form_error("superuser")?>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>Default Ticket Assigned User<span class="text-danger">*</span></label>
                                            <select name="assigneduser" class="form-control">
                                                <?php if($this->users_model->get_staffrows()) {
                                                    echo '<option value="'.$assigneduser.'">'.$assigneduserName.'</option>';
                                                    foreach($this->users_model->get_staffrows() as $usr) {
                                                        if($usr->uid != $assigneduser) {
                                                            echo '<option value="'.$usr->uid.'"">'.$usr->user_name.'</option>';
                                                        }
                                                    } //End of foreach  
                                                } else {
                                                    echo "<option value=''>No records found</option>";
                                                } //End of if else ?>
                                            </select>
                                            <?=form_error("assigneduser")?>
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
