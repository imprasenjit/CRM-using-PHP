<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Customers - EODB Support</title>      
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
                        <a href="<?=base_url('welcome')?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Customers</li>
                    <li style="float: right">
                        <a href="javascript:history.back(-1)" class="btn btn-info" style="margin: 0px; padding: 4px;">
                            <i class="fa fa-chevron-circle-left"></i> Back
                        </a>
                    </li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card tblcard border-secondary">
                            <div class="card-header">
                                <i class="fa fa-list-alt"></i> Registered customers list
                                <a href="<?=base_url('customers/addnew')?>" class="btn btn-primary" style="margin: 0px; padding: 4px; float: right">
                                    <i class="fa fa-plus-circle"></i> Add new customer
                                </a>
                            </div>
                            <div class="card-body card-body-padding" style="padding: 1px">
                                <table class="table table-bordered" id="dtbl">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">CID</th>
                                            <th>Customer name</th>
                                            <th>Company name</th>
                                            <th>Contact no.</th>
                                            <th>Email id</th>
                                            <th class="text-center">Operations</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(isset($results)) {
                                            foreach ($results as $rows) {
                                                $customer_id = $rows->customer_id;
                                                $customer_name = $rows->customer_name;
                                                $company_name = $rows->company_name;
                                                $contact_no = $rows->contact_no;
                                                $email_id = $rows->email_id;
                                                $address = $rows->address;
                                                ?>
                                                <tr>
                                                    <td style="text-align:center"><?=sprintf("%02d", $customer_id)?></td>
                                                    <td><?=$customer_name?></td>
                                                    <td><?=$company_name?></td>
                                                    <td><?=$contact_no?></td>
                                                    <td><?=$email_id?></td>
                                                    <td class="text-center">
                                                        <a href="<?=base_url('customers/delete/')?><?=$customer_id?>.htm" class="btn btn-danger del">
                                                            <i class="fa fa-remove"></i>
                                                        </a>
                                                        <a href="<?=base_url('customers/addnew/')?><?=$customer_id?>.htm" class="btn btn-primary">
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