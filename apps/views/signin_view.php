<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Sign in - EODB Support</title>
        <link rel="icon" href="<?=base_url('public/imgs/favicon.ico')?>" type="image/ico">
        <link href="<?=base_url('public/bootstrap-4/css/bootstrap.min.css')?>" rel="stylesheet">
        <link href="<?=base_url('public/font-awesome-4.7.0/css/font-awesome.min.css')?>" rel="stylesheet">
        <link href="<?=base_url('public/css/admin.css')?>" rel="stylesheet">
        <link href="<?=base_url('public/css/animate.css')?>" rel="stylesheet">
        <script src="<?=base_url('public/js/jquery-3.3.1.min.js')?>"></script>
        <script src="<?=base_url('public/js/notify.min.js')?>"></script>
    </head>
    <body class="bg-dark">
        <?php if ($this->session->flashdata("accessMsg")) { ?>
            <script>$.notify("<?= $this->session->flashdata("accessMsg"); ?>", "error");</script>
        <?php } ?>
        <?php if ($this->session->flashdata("flashMsg")) { ?>
            <script>$.notify("<?= $this->session->flashdata("flashMsg"); ?>", "error");</script>
        <?php } ?>
        <div class="container">
            <div class="card card-login mx-auto mt-5">
                <div class="card-header">Please sign in to continue access the system</div>
                <div class="card-body">
                    <form action="<?=base_url('signin/process')?>" method="post">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input class="form-control" name="uname" type="text" placeholder="Enter usename">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input class="form-control" name="pass" type="password" placeholder="Password">
                        </div>
                        <a href="<?=base_url()?>">Back to home page</a>
                        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
