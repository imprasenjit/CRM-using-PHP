<?php
$results = $this->querytypes_model->get_records();
if (isset($result)) {
    $title = "Edit query type information";
    $qtype_id = $result->qtype_id;
    $qtype_name = $result->qtype_name;
    $qtype_status = $result->qtype_status;
} else {
    $title = "New query type registration";
    $qtype_id = "";
    $qtype_name = set_value("qtype_name");
    $qtype_status = set_value("qtype_status");
}//End of if else ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Query types - EODB Support</title>      
        <?php $this->load->view('requires/cssjs'); ?>
        <link rel="stylesheet" href="<?=base_url('public/datatables/css/dataTables.bootstrap4.min.css')?>" />
        <script src="<?=base_url('public/datatables/js/jquery.dataTables.min.js')?>"></script>
        <script src="<?=base_url('public/datatables/js/dataTables.bootstrap4.min.js')?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#dtbl").DataTable({
                    "order": [[0, 'asc']],
                    "lengthMenu": [[10, 20, 50, 100, 200], [10, 20, 50, 100, 200]]
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
                    <li class="breadcrumb-item active">Querytypes</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card frmcard border-primary">
                            <form action="<?=base_url('querytypes/save')?>" method="post">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                <div class="card-header">
                                    <i class="fa fa-university"></i> <?=$title?>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="qtype_id" id="qtype_id" value="<?=$qtype_id?>" />
                                    <div class="row">
                                        <div class=" col-md-6 form-group">
                                            <label>Query type name<span class="text-danger">*</span></label>
                                            <input type="text" name="qtype_name" value="<?=$qtype_name?>" class="form-control" autofocus="on" autocomplete="off" />
                                            <?=form_error("qtype_name")?>
                                        </div>
                                        <div class=" col-md-6 form-group">
                                            <label>Query type for<span class="text-danger">*</span></label>
                                            <select name="qtype_status" class="form-control">
                                                <option value="">Select</option>
                                                <?php if($qtype_status == 1) {
                                                    echo '<option value="1" selected="selected">Support</option>';
                                                    echo '<option value="2">Call</option>';
                                                } elseif($qtype_status == 2) {
                                                    echo '<option value="1">Support</option>';
                                                    echo '<option value="2" selected="selected">Call</option>';
                                                } else {
                                                    echo '<option value="1">Support</option>';
                                                    echo '<option value="2">Call</option>';
                                                }//End of if else ?>
                                            </select>
                                            <?=form_error("qtype_status")?>
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
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card tblcard border-secondary">
                            <div class="card-header">
                                <i class="fa fa-list-alt"></i> Registered query types
                            </div>
                            <div class="card-body card-body-padding" style="padding: 1px">
                                <table class="table table-bordered" id="dtbl">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">#ID</th>
                                            <th>Query Type Name</th>
                                            <th>Query Type For</th>
                                            <th class="text-center">Operations</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if($results) {
                                            foreach ($results as $rows) {
                                                $qtype_id = $rows->qtype_id;
                                                $qtype_name = $rows->qtype_name;
                                                $qtype_status = $rows->qtype_status;
                                                if($qtype_status == 1) {
                                                    $qstatus = "Support";
                                                } elseif($qtype_status == 2) {
                                                    $qstatus = "Call";
                                                } else {
                                                    $qstatus = "Undefined";
                                                }
                                                ?>
                                                <tr>
                                                    <td style="text-align:center"><?=sprintf("%02d", $qtype_id)?></td>
                                                    <td><?=$qtype_name?></td>
                                                    <td><?=$qstatus?></td>
                                                    <td class="text-center">
                                                        <a href="<?=base_url('querytypes/delete/'.$qtype_id)?>" class="btn btn-danger del">
                                                            <i class="fa fa-remove"></i>
                                                        </a>
                                                        <a href="<?=base_url('querytypes/index/'.$qtype_id)?>" class="btn btn-primary">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php                     
                                            }// End of foreach
                                        }// End of if  
                                        ?>                           
                                    </tbody>
                                </table>
                            </div><!--End of card-body-->
                        </div><!--End of .card-->
                    </div>
                </div><!--End of .row-->
            </div><!--End of container-fluid-->
            <?php $this->load->view('requires/footer'); ?>
            <?php $this->load->view('requires/logoutmodal'); ?>
        </div>
    </body>
</html>