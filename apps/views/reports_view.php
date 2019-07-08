<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Tickets Reports - EODB Support</title>      
        <?php $this->load->view('requires/cssjs'); ?>
        <link rel="stylesheet" href="<?=base_url('public/css/loading.css')?>" />
        <link href="<?=base_url('public/jquery-ui-1.12.1/jquery-ui.min.css')?>" rel="stylesheet" type="text/css" />
        <script src="<?= base_url('public/js/jQuery.print.min.js')?>"></script>
        <script src="<?=base_url('public/jquery-ui-1.12.1/jquery-ui.min.js')?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                
                $(".dp").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    maxDate: "0d",
                    dateFormat: "yy-mm-dd"
                }); //End of onclick .datepicker
                                
                $(document).on("click", "#searchbtn", function(){
                    var frmdt = $("#frmdt").val();
                    var todt = $("#todt").val(); //alert(frmdt+" - "+todt);
                    if(frmdt == "") {
                        $("#frmdt").notify("Please select a date");
                    } else if(todt == "") {
                        $("#todt").notify("Please select a date");
                    } else {
                        var startDate = Date.parse(frmdt);
                        var endDate = Date.parse(todt);
                        var timeDiff = endDate - startDate;
                        var daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));                    
                        if(daysDiff>0 && daysDiff<=31) {//alert(daysDiff);
                            $.ajax({
                                type: "POST",
                                url: "<?=base_url('reports/daterecords')?>",
                                data: {"frmdt":frmdt, "todt":todt, "<?=$this->security->get_csrf_token_name()?>" : "<?=$this->security->get_csrf_hash()?>"},
                                beforeSend:function(){
                                    $("#reports_div").html("<div class='loading'></div>");
                                },
                                success: function(res){ //alert(res);
                                    $("#reports_div").html(res);
                                }
                            });//End of ajax()
                        } else {
                            $.notify("Invalid date selection! Date range must be 0-31 days only");
                        }//End of if else
                    }//End of if else
                }); //End of onChange #searchbtn
                
                $(document).on("click", ".print-btn", function(){
                    $(".print-content").print({
                        globalStyles : true,
                        mediaPrint : false,
                        stylesheet : null,
                        iframe : false,
                        noPrintSelector : ".avoid-me",
                        append : null,
                        prepend : null
                    });
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
                        <a href="<?=base_url('welcome')?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Tickets reports</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card tblcard border-secondary">
                            <div class="card-header" style="line-height:30px">
                                <i class="fa fa-list-alt"></i> Date wise reports
                                <div style="float:right">
                                    From
                                    <input id="frmdt" class="dp form-control" style="width:120px; display: inline-block" placeholder="From Date" type="text" />
                                    to
                                    <input id="todt" class="dp form-control" style="width:120px; display: inline-block" placeholder="To Date" type="text" />
                                    <button id="searchbtn" class="btn btn-primary" type="button"><i class="fa fa-search"></i> Search</button>
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
