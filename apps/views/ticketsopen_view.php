<?php
$sutype = $this->session->session_utype;
$ajaxpath =($sutype == 1)?base_url('ticketsopen/getRecords'):base_url('ticketsopen/getUserRecords');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Open Tickets - EODB Support</title>      
        <?php $this->load->view('requires/cssjs'); ?>
        <link rel="stylesheet" href="<?=base_url('public/css/loading.css')?>" />
        <link rel="stylesheet" href="<?=base_url('public/datatables/css/dataTables.bootstrap4.min.css')?>" />
        <script src="<?=base_url('public/datatables/js/jquery.dataTables.min.js')?>"></script>
        <script src="<?=base_url('public/datatables/js/dataTables.bootstrap4.min.js')?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#dtbl").DataTable({
                    "columns": [
                        {"data": "support_time"},
                        {"data": "cname"},
                        {"data": "query_type"},
                        {"data": "uid"},
                        {"data": "support_status"}
                    ],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "<?=$ajaxpath?>",
                        "dataType": "json",
                        "type": "POST",
                        data: {
                            '<?=$this->security->get_csrf_token_name()?>' : '<?=$this->security->get_csrf_hash()?>'
                        }
                    },
                    language: {
                        processing: "<div class='loading'></div>",
                    },
                    "order": [[4, 'ASC']],
                    "lengthMenu": [[20, 30, 50, 100, 200], [20, 30, 50, 100, 200]]
                });                
                
                $("#supportviewModal").on("show.bs.modal", function (e) {
                    var support_id = e.relatedTarget.id;
                    $.ajax({
                        type: "POST",
                        url: "<?=base_url('tickets/getDetails')?>",
                        data: {"support_id" : support_id, "<?=$this->security->get_csrf_token_name()?>" : "<?=$this->security->get_csrf_hash()?>"},
                        beforeSend: function(){
                            $("#supportviewModalBody").html("<div class='loading'></div>");
                        },
                        success: function(res){
                            $("#supportviewModalBody").html(res);
                        }
                    }); //End of ajax()
                }); // End of .on modal
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
                    <li class="breadcrumb-item active">Open Tickets</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card tblcard border-secondary">
                            <div class="card-header">
                                <i class="fa fa-list-alt"></i> All open tickets
                                <a href="<?=base_url('supports/addnew')?>" class="btn btn-primary" style="margin: 0px; padding: 4px; float: right">
                                    <i class="fa fa-plus-circle"></i> Generate new tickets
                                </a>
                            </div>
                            <div class="card-body card-body-padding" style="padding: 1px">
                                <table class="table table-bordered" id="dtbl">
                                    <thead>
                                        <tr>
                                            <th>Query Time</th>
                                            <th>Name</th>
                                            <th>Query Type</th>
                                            <th>Assign to</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div><!--End of card-body-->
                        </div><!--End of .card-->
                    </div>
                </div><!--End of .row-->
            </div><!--End of container-fluid-->
            <?php $this->load->view('requires/footer'); ?>
            <?php $this->load->view('assets/supportviewmodal'); ?>
            <?php $this->load->view('requires/logoutmodal'); ?>
        </div>
    </body>
</html>
