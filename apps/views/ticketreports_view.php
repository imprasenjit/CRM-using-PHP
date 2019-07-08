<?php $qtypes = $this->querytypes_model->get_rows(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Tickets Reports - EODB Support</title>      
        <?php $this->load->view('requires/cssjs'); ?>
        <link rel="stylesheet" href="<?=base_url('public/css/loading.css')?>" />
        <script src="<?= base_url('public/js/jQuery.print.min.js')?>"></script>
        <link rel="stylesheet" href="<?=base_url('public/datatables/css/dataTables.bootstrap4.min.css')?>" />
        <script src="<?=base_url('public/datatables/js/jquery.dataTables.min.js')?>"></script>
        <script src="<?=base_url('public/datatables/js/dataTables.bootstrap4.min.js')?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                
                $(document).on("change", "#query_type", function(){
                    var query_type = $("#query_type").val();
                    if(query_type.length == 0) {
                        $("#query_type").notify("Please select a type");
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "<?=base_url('ticketreports/getrecords')?>",
                            data: {"query_type":query_type},
                            beforeSend:function(){
                                $("#reports_div").html("<div class='loading'></div>");
                            },
                            success: function(res){ //alert(res);
                                $("#reports_div").html(res);
                            }
                        });//End of ajax()
                    }//End of if else
                });//End of onChange #query_type
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
                        <a href="<?=base_url('welcome')?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Tickets reports</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card tblcard border-secondary">
                            <div class="card-header" style="line-height:30px">
                                <i class="fa fa-list-alt"></i> Tickets reports
                                <div style="float:right">                           
                                    <select id="query_type" class="form-control" style="display: inline-block;">
                                        <?php if($qtypes) {
                                            echo '<option value="">Select Query Type</option>';
                                            foreach($qtypes as $qtyp) {
                                                if($qtyp->qtype_id != $qtype_id) {
                                                    echo '<option value="'.$qtyp->qtype_id.'">'.$qtyp->qtype_name.'</option>';
                                                }
                                            } //End of foreach  
                                        } else {
                                            echo "<option value=''>No records found</option>";
                                        } //End of if else ?>
                                    </select>
                                </div>                                
                            </div>
                            <div id="reports_div" class="card-body card-body-padding table-responsive" style="padding: 1px">
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
