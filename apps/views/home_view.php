<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" href="<?=base_url('public/imgs/favicon.ico')?>" type="image/ico">
        <link href="<?=base_url('public/bootstrap-4/css/bootstrap.min.css')?>" rel="stylesheet">
        <link href="<?=base_url('public/font-awesome-4.7.0/css/font-awesome.min.css')?>" rel="stylesheet">
        <link href="<?=base_url('public/css/animate.css')?>" rel="stylesheet">
        <link href="<?=base_url('public/css/site.css')?>" rel="stylesheet">
        <title>EODB Supports</title>
    </head>
    <body>
        <?php $this->load->view("requires/sitenavbar"); ?>
        <section class="features-icons bg-light text-center">
            <div class="container" style="min-height: 300px">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                            <div class="features-icons-icon d-flex">
                                <i class="fa fa-edit m-auto text-primary"></i>
                            </div>
                            <h3><a href="<?=base_url('ticket')?>">Raise a ticket</a></h3>
                            <p class="lead mb-0">
                                Submit your query to our dedicated professionals for review &amp; respond.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                            <div class="features-icons-icon d-flex">
                                <i class="fa fa-search-plus m-auto text-primary"></i>
                            </div>
                            <h3><a href="<?=base_url('ticket/track')?>">Track your ticket</a></h3>
                            <p class="lead mb-0">
                                Click here to track or check the status of your raised ticket.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php $this->load->view("requires/sitefooter"); ?>
    </body>
</html>
