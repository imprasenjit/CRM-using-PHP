<?php
if (isset($result)) {
    $title = "Edit User Information";
    $uid = $result->uid;
    $user_name = $result->user_name;
    $uname = $result->uname;
    $user_no = $result->user_no;
    $user_mail = $result->user_mail;
    $utype = $result->utype;
    $utype_name = getusertype($utype);
    $user_address = $result->user_address;
    
    $user_rights = $result->user_rights;
    if(strlen($user_rights) > 0) {
        $rights = explode(",", $user_rights);
        $call_add = in_array("call_add", $rights)?'checked="checked"':'';
        $call_edit = in_array("call_edit", $rights)?'checked="checked"':'';
        $ticket_add = in_array("ticket_add", $rights)?'checked="checked"':'';
        $ticket_edit = in_array("ticket_edit", $rights)?'checked="checked"':'';
        $ticket_assign = in_array("ticket_assign", $rights)?'checked="checked"':'';
        $ticket_mark = in_array("ticket_mark", $rights)?'checked="checked"':'';
    }
} else {
    $title = "New User Registration";
    $uid = "";
    $user_name = set_value("user_name");
    $uname = set_value("uname");
    $user_no = set_value("user_no");
    $user_mail = set_value("user_mail");
    $utype = "";
    $utype_name = "Select";
    $user_address = set_value("user_address");
} ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Users - EODB Support</title>      
        <?php $this->load->view('requires/cssjs'); ?>
        <script src="<?=base_url('public/js/password.js')?>"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#pass").passwordValidation({"confirmField": "#confpass"}, function(element, valid, match, failedCases) {
                    $("#passerrors").html("<pre>" + failedCases.join("\n") + "</pre>");
                     if(valid) $(element).css("border","2px solid green");
                     if(!valid) $(element).css("border","2px solid red");
                     if(valid && match) $("#confpass").css("border","2px solid green");
                     if(!valid || !match) $("#confpass").css("border","2px solid red");
                });

                $(document).on("click","#submitbtn",function(){
                    var errors = $("#passerrors").html();
                    //alert(errors.length);
                    if(errors.length > 15) {
                        $("#passerrors").html('<font style="color:red">Error in password validation!</font>');
                    } else {
                        $("#regfrm").submit();
                    }//End of if else
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
                    <li class="breadcrumb-item active">Users</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card frmcard border-primary">
                            <form id="regfrm" action="<?=base_url('users/save')?>" method="post">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                <input type="hidden" name="uid" id="uid" value="<?=$uid?>" />
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                <div class="card-header">
                                    <i class="fa fa-university"></i> <?=$title?>
                                </div>
                                <div class="card-body">                                    
                                    <div class="row">
                                        <div class=" col-md-6 form-group">
                                            <label>Name<span class="text-danger">*</span></label>
                                            <input type="text" name="user_name" value="<?=$user_name?>" class="form-control" autocomplete="off" />
                                            <?=form_error("user_name")?>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>Username<span class="text-danger">*</span></label>
                                            <input type="text" name="uname" value="<?=$uname?>" class="form-control" />
                                            <?=form_error("uname")?>
                                        </div>
                                    </div> <!-- End of .row -->

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Contact No.<span class="text-danger">*</span></label>
                                            <input type="text" name="user_no" value="<?=$user_no?>" class="form-control" maxlength="10" />
                                            <?=form_error("user_no")?>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Email ID<span class="text-danger">*</span></label>
                                            <input type="text" name="user_mail" value="<?=$user_mail?>" class="form-control" />
                                            <?=form_error("user_mail")?>
                                        </div>
                                    </div> <!-- End of .row -->

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Choose Password<span class="text-danger">*</span></label>
                                            <input type="password" name="pass" id="pass" value="" class="form-control" />
                                            <?=form_error("pass")?>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Confirm Password<span class="text-danger">*</span></label>
                                            <input type="password" name="confpass" id="confpass" value="" class="form-control" />
                                            <?=form_error("confpass")?>
                                        </div>
                                        <div id="passerrors" class="col-md-12"></div>
                                    </div> <!-- End of .row -->

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>User type<span class="text-danger">*</span></label>
                                            <select name="utype" class="form-control">
                                                <option value="<?=$utype?>" selected="selected"><?=$utype_name?></option>
                                                <?php
                                                if($utype != 2) {
                                                    echo '<option value="2">Staff</option>';
                                                } 
                                                if($utype != 3) {
                                                    echo '<option value="3">CCE</option>';
                                                }                                                 
                                                if($utype != 4) {
                                                    echo '<option value="4">Dept.</option>';
                                                }
                                                ?>
                                            </select>
                                            <?=form_error("utype")?>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Address</label>
                                            <input type="text" name="user_address" value="<?=$user_address?>" class="form-control" />
                                            <?=form_error("user_address")?>
                                        </div>
                                    </div> <!-- End of .row -->
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr class="table-dark" style="text-transform: uppercase">
                                                        <th colspan="7">User rights allocation:</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="table-danger">
                                                        <td class="font-weight-bold">Call : </td>
                                                        <td style="width: 20px; text-align: center">
                                                            <input name="user_rights[]" value="call_add" type="checkbox" <?= isset($call_add) ? $call_add : "" ?> />
                                                        </td>
                                                        <td>Add new call</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td style="width: 20px; text-align: center">
                                                            <input name="user_rights[]" value="call_edit" type="checkbox" <?= isset($call_edit) ? $call_edit : "" ?> />
                                                        </td>
                                                        <td>Edit existing call</td>
                                                    </tr>
                                                    <tr class="table-info">
                                                        <td class="font-weight-bold" style="vertical-align: middle; border-right: 1px solid #e9ecef;" rowspan="2">
                                                            Support : 
                                                        </td>
                                                        <td style="width: 20px; text-align: center">
                                                            <input name="user_rights[]" value="ticket_add" type="checkbox" <?= isset($ticket_add) ? $ticket_add : "" ?> />
                                                        </td>
                                                        <td>Generate new ticket</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td style="width: 20px; text-align: center">
                                                            <input name="user_rights[]" value="ticket_edit" type="checkbox" <?= isset($ticket_edit) ? $ticket_edit : "" ?> />
                                                        </td>
                                                        <td>Edit existing ticket</td>
                                                    </tr>
                                                    <tr class="table-info">
                                                        <td style="width: 20px; text-align: center">
                                                            <input name="user_rights[]" value="ticket_assign" type="checkbox" <?= isset($ticket_assign) ? $ticket_assign : "" ?> />
                                                        </td>
                                                        <td>Assign ticket to user</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td style="width: 20px; text-align: center">
                                                            <input name="user_rights[]" value="ticket_mark" type="checkbox" <?= isset($ticket_mark) ? $ticket_mark : "" ?> />
                                                        </td>
                                                        <td>Marked ticket to users</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div><!-- End of .col-md-12 -->
                                    </div><!-- End of .row -->

                                </div><!--End of .card-body-->
                                
                                <div class="card-footer text-center">
                                    <button type="reset" class="btn btn-danger">
                                        <i class="fa fa-remove"></i> Reset
                                    </button>
                                    <button id="submitbtn" class="btn btn-success" type="button">
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
