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
        <script type="text/javascript">
            $(document).ready(function () {
                $("#dtbl").DataTable({
                    "order": [],
                    "lengthMenu": [[20, 50, 100, 200], [20, 50, 100, 200]]
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
                    <li class="breadcrumb-item active">Search results</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card tblcard border-secondary">
                            <div class="card-header">
                                <i class="fa fa-list-alt"></i> Ticket search list for <b>"<?=$searchkey?>"</b>
                            </div>
                            <div class="card-body card-body-padding" style="padding: 1px">
                                <table class="table table-bordered" id="dtbl">
                                    <thead>
                                        <tr>
                                            <th>Ticket no.</th>
                                            <th>Query Time</th>
                                            <th>Email</th>
                                            <th>Query Type</th>
                                            <th>Status</th>
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
                                                $uid = $rows->uid;
                                                $assignto = ($this->users_model->get_row($uid))?$this->users_model->get_row($uid)->user_name:"Not found!";
                                                $status = getstatus($rows->support_status);
                                                ?>
                                                <tr>
                                                    <td><?=$ticket_no?></td>
                                                    <td><?=$support_time?></td>
                                                    <td><?=$email?></td>
                                                    <td>
                                                        <a id="<?=$support_id?>" data-toggle="modal" data-target="#supportviewModal" href="javascript:void(0)">
                                                            <?=word_limiter($qtype, 2)?>
                                                        </a>
                                                    </td>
                                                    <td><?=$status?></td>
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
            <?php $this->load->view('assets/supportviewmodal'); ?>
            <?php $this->load->view('requires/logoutmodal'); ?>
        </div>
    </body>
</html>
