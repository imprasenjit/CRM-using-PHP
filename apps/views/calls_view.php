<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Calls - EODB Support</title>      
        <?php $this->load->view('requires/cssjs'); ?>
        <link rel="stylesheet" href="<?=base_url('public/css/loading.css')?>" />
        <link rel="stylesheet" href="<?=base_url('public/datatables/css/dataTables.bootstrap4.min.css')?>" />
        <script src="<?=base_url('public/datatables/js/jquery.dataTables.min.js')?>"></script>
        <script src="<?=base_url('public/datatables/js/dataTables.bootstrap4.min.js')?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#dtbl").DataTable({
                    "columns": [
                        {"data": "call_time"},
                        {"data": "cname"},
                        {"data": "cno"}
                    ],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "<?=base_url('calls/getRecords')?>",
                        "dataType": "json",
                        "type": "POST",
                        data: {
                            '<?=$this->security->get_csrf_token_name()?>' : '<?=$this->security->get_csrf_hash()?>'
                        }
                    },
                    language: {
                        processing: "<div class='loading'></div>",
                    },
                    "order": [[0, 'DESC']],
                    "lengthMenu": [[20, 30, 50, 100, 200], [20, 30, 50, 100, 200]]
                });
                
                $("#callcloseModal").on("show.bs.modal", function (e) {
                    var call_id = e.relatedTarget.id;
                    $("#call_id").val(call_id);
                }); // End of .on modal
                
                $("#callviewModal").on("show.bs.modal", function (e) {
                    var call_id = e.relatedTarget.id;
                    $.ajax({
                        type: "POST",
                        url: "<?=base_url('calls/getDetails')?>",
                        data: {"call_id" : call_id, "<?=$this->security->get_csrf_token_name()?>" : "<?=$this->security->get_csrf_hash()?>"},
                        beforeSend: function(){
                            $("#callviewModalBody").html("<div class='loading'></div>");
                        },
                        success: function(res){
                            $("#callviewModalBody").html(res);
                        }
                    }); //End of ajax()
                }); // End of .on modal
            });
        </script>
        <style type="text/css">            
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
                    <li class="breadcrumb-item active">Calls</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card tblcard border-secondary">
                            <div class="card-header">
                                <i class="fa fa-list-alt"></i> Registered calls list
                                <a href="<?=base_url('calls/addnew')?>" class="btn btn-primary" style="margin: 0px; padding: 4px; float: right">
                                    <i class="fa fa-plus-circle"></i> Add new call
                                </a>
                            </div>
                            <div class="card-body card-body-padding" style="padding: 1px">
                                <table class="table table-bordered" id="dtbl">
                                    <thead>
                                        <tr>
                                            <th>Call Time</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div><!--End of card-body-->
                        </div><!--End of .card-->
                    </div>
                </div><!--End of .row-->
            </div><!--End of container-fluid-->
            <?php $this->load->view('requires/footer'); ?>
            <?php $this->load->view('assets/callclosemodal'); ?>
            <?php $this->load->view('assets/callviewmodal'); ?>
            <?php $this->load->view('requires/logoutmodal'); ?>
        </div>
    </body>
</html>


