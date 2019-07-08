<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Change Password - EODB Support</title>      
        <?php $this->load->view('requires/cssjs'); ?>
        
        <style type="text/css">
            .mytable {
                width: 600px; 
                margin: 0px auto 100px auto;
                border: 1px solid #ddd;
            }
            .mytable td {
                padding: 10px 5px;
                font-size: 1rem;
                font-family: sans-serif;
            }
            h1.myHeader {
                width: 600px;
                margin: 100px auto 0px auto;
                background-color: #1fa67a;
                border-top: 1px solid #34a782;
                border-top-left-radius: 5px;
                border-top-right-radius: 5px;
                font-size: 1.2rem;
                font-family: proxima-nova,"Helvetica Neue",Helvetica,Arial,sans-serif;
                font-weight: bold;
                text-align: center;
                text-transform: uppercase;
                color: #fff;
                padding: 5px;
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
                        <a href="<?=base_url('')?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Querytypes</li>
                </ol><!-- End of .breadcrumb-item-->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card frmcard border-primary">
                            <form action="<?=base_url('changepass/save')?>" method="post">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                            <h1 class="myHeader">New password information</h1>
                            <table class="mytable">
                                <tbody>
                                    <tr class="table-danger">
                                        <td style="width:200px">New Password</td>
                                        <td style="width: 20px; text-align: center; font-weight: bold">:</td>
                                        <td>
                                            <input name="newpass" class="form-control" autocomplete="off" type="password" />
                                            <?=form_error("newpass")?>
                                        </td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>Confirm Password</td>
                                        <td style="width: 20px; text-align: center; font-weight: bold">:</td>
                                        <td>
                                            <input name="confpass" class="form-control" autocomplete="off" type="password" />
                                            <?=form_error("confpass")?>
                                        </td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td colspan="3" style="text-align: center">
                                            <button type="reset" class="btn btn-danger">
                                                <i class="fa fa-remove"></i> Reset
                                            </button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-check"></i> Save
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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