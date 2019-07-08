<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>My Tickets - EODB Supports</title>      
        <?php $this->load->view('requires/cssjs'); ?>
        <link rel="stylesheet" href="<?=base_url('public/datatables/css/dataTables.bootstrap4.min.css')?>" />
        <script src="<?=base_url('public/datatables/js/jquery.dataTables.min.js')?>"></script>
        <script src="<?=base_url('public/datatables/js/dataTables.bootstrap4.min.js')?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#dtbl").DataTable({
                    "order": [[0, 'desc']],
                    "lengthMenu": [[10, 20, 50, 100, 200], [10, 20, 50, 100, 200]]
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
                    <li class="breadcrumb-item active">Tickets</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card tblcard border-secondary">
                            <div class="card-header">
                                <i class="fa fa-list-alt"></i> Tickets list
                            </div>
                            <div class="card-body card-body-padding" style="padding: 1px">
                                <table class="table table-bordered" id="dtbl">
                                    <thead>
                                        <tr>
                                            <th>Query Time</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Query type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(isset($tickets)) {
                                            foreach ($tickets as $rows) {
                                                $support_id = $rows["support_id"];
                                                $cname = $rows["cname"];
                                                $email = $rows["email"];
                                                $query  = $rows["query"];
                                                $query_type  = $rows["query_type"];
                                                $qtype = ($this->querytypes_model->get_row($query_type))?$this->querytypes_model->get_row($query_type)->qtype_name:"Not found";
                                                $qtyp = '<a href='.base_url("supports/details/".$support_id).'>' . word_limiter($qtype, 3) . '</a>';
                                                $support_time = date("d/m/Y H:i", strtotime($rows["support_time"]));
                                                ?>
                                                <tr>
                                                    <td><?=$support_time?></td>
                                                    <td>
                                                        <a id="<?=$support_id?>" data-toggle="modal" data-target="#supportviewModal" href="javascript:void(0)">
                                                            <?=word_limiter($cname, 3)?>
                                                        </a>
                                                    </td>
                                                    <td><?=$email?></td>
                                                    <td><?=$qtyp?></td>
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