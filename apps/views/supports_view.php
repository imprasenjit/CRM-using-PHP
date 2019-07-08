<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Supports - EODB Support</title>      
        <?php $this->load->view('requires/cssjs'); ?>
        <link rel="stylesheet" href="<?=base_url('public/css/loading.css')?>" />
        <link rel="stylesheet" href="<?=base_url('public/datatables/css/dataTables.bootstrap4.min.css')?>" />
        <script src="<?=base_url('public/datatables/js/jquery.dataTables.min.js')?>"></script>
        <script src="<?=base_url('public/datatables/js/dataTables.bootstrap4.min.js')?>"></script>
        <link rel="stylesheet" href="<?=base_url('public/css/jquery.multiselect.css')?>" />
        <script src="<?=base_url('public/js/jquery.multiselect.js')?>" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#dtbl").DataTable({
                    "order": [],
                    "lengthMenu": [[20, 50, 100, 200], [20, 50, 100, 200]]
                });
                
                $("#mark_to").multiselect({
                    columns: 1,
                    placeholder: "Select Recipient(s)",
                    search: true,
                    selectAll: true
                });
                                
                $("#supportreplyModal").on("show.bs.modal", function (e) {
                    var support_id = e.relatedTarget.id;
                    $("#reply_sid").val(support_id);
                }); // End of .on modal
                
                $("#supportcloseModal").on("show.bs.modal", function (e) {
                    var support_id = e.relatedTarget.id;
                    $("#close_sid").val(support_id);
                }); // End of .on moda                
            });
        </script>
        <style type="text/css">
            .btn {
                padding: .2rem .4rem;
            }
            p {
                margin: 0px;
            }
            .table td, .table th {
                padding: .3rem;
                vertical-align: middle;
                border-top: 1px solid #e9ecef;
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
                        <a href="<?=base_url('welcome')?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Supports</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card tblcard border-secondary">
                            <div class="card-header">
                                <i class="fa fa-list-alt"></i> Registered supports list
                                <a href="<?=base_url('supports/addnew')?>" class="btn btn-primary" style="margin: 0px; padding: 4px; float: right">
                                    <i class="fa fa-plus-circle"></i> Generate new tickets
                                </a>
                            </div>
                            <div class="card-body card-body-padding" style="padding: 1px">
                                <table class="table table-bordered" id="dtbl">
                                    <thead>
                                        <tr>
                                            <th>TID</th>
                                            <th>Ticket no.</th>
                                            <th>Query Time</th>
                                            <th>Email</th>
                                            <th>Query Type</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(isset($results)) {
                                            foreach ($results as $rows) {
                                                $support_id = $rows->support_id;
                                                $ticket_no = $rows->ticket_no;
                                                $email = $rows->email;
                                                $priority = getpriority($rows->priority);
                                                $query_type  = $rows->query_type;
                                                $qtype = ($this->querytypes_model->get_row($query_type))?$this->querytypes_model->get_row($query_type)->qtype_name:"Not found";
                                                $query  = $rows->query;
                                                $support_time = date("d/m/y H:i", strtotime($rows->support_time));
                                                $status  = $rows->support_status;
                                                if($status == 1) {
                                                    echo '<tr class="table-danger" data-toggle="tooltip" title="New Ticket" data-placement="right">';
                                                } else {
                                                    echo '<tr class="table-info" data-toggle="tooltip" title="Replied Ticket" data-placement="right">';
                                                }
                                                ?>
                                                    <td><?= sprintf("%05d", $support_id)?></td>
                                                    <td><?=$ticket_no?></td>
                                                    <td><?=$support_time?></td>
                                                    <td><?=$email?></td>
                                                    <td>
                                                        <a href="<?=base_url('supports/details/'.$support_id)?>">
                                                            <?=word_limiter($qtype, 3)?>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="<?=base_url('supports/delete/'.$support_id)?>" class="btn btn-danger del" data-toggle="tooltip" title="Delete">
                                                            <i class="fa fa-remove"></i>
                                                        </a>
                                                        <a href="<?=base_url('supports/addnew/'.$support_id)?>" class="btn btn-info" data-toggle="tooltip" title="Edit">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <span id="<?=$support_id?>" data-toggle="modal" data-target="#supportreplyModal">
                                                            <a href="javascript:void(0)" class="btn btn-primary" data-toggle="tooltip" title="Reply">
                                                                <i class="fa fa-mail-forward"></i>
                                                            </a>
                                                        </span>
                                                            
                                                        <span id="<?=$support_id?>" data-toggle="modal" data-target="#supportcloseModal">
                                                            <a href="javascript:void(0)" class="btn btn-warning" data-toggle="tooltip" title="Resolve">
                                                                <i class="fa fa-check-circle"></i>
                                                            </a>
                                                        </span>
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
            <?php $this->load->view('assets/supportreplymodal'); ?>
            <?php $this->load->view('assets/supportclosemodal'); ?>
            <?php $this->load->view('requires/logoutmodal'); ?>
        </div>
    </body>
</html>
