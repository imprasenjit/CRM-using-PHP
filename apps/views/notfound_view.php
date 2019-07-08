<!DOCTYPE html>
<html>
    <head>
        <title>Page Not Found</title>
        <link href="<?=base_url('public/imgs/favicon.ico')?>" rel="shortcut icon" type="image/x-icon" />
        <link href="<?=base_url('public/bootstrap-4/css/bootstrap.min.css')?>" rel="stylesheet" />
        <link href="<?=base_url('public/font-awesome-4.7.0/css/font-awesome.min.css')?>" rel="stylesheet" />
        <style type="text/css">
            body { 
                background: #F5F5F5;
                font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            }
            .error-template {
                padding: 40px 15px;
                text-align: center;
            }
            h1 {
                margin-top: 10%;
                font-size: 36px;
                line-height: 38px;
            }
            h2 {
                border-bottom:2px solid #333;
            }
            .error-details {
                font-size: 16px;
            }
            .error-actions {
                margin-top:15px;
                margin-bottom:15px;
            }
            .error-actions .btn { 
                margin-right:10px; 
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="error-template">
                        <h1><span class="fa fa-warning-sign"></span> Oops!</h1>
                        <h2>404 Not Found</h2>
                        <div class="error-details">
                            Sorry, an error has occured, Requested page <b>not found</b>!
                        </div>
                        <div class="error-actions">
                            <a href="<?= base_url(); ?>" class="btn btn-primary btn-lg">
                                <span class="fa fa-home"></span>
                                Home 
                            </a>
                            <a href="mailto:skalomcs@gmaiil.com" class="btn btn-info btn-lg">
                                <span class="fa fa-envelope"></span> Contact 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>