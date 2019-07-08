<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="<?=base_url('welcome')?>">Dashboard</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <?php $this->load->view('requires/sidebar'); ?>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form action="<?=base_url('tickets/search')?>" method="post">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                    <div class="input-group">
                        <input name="searchkey" type="text" class="form-control" placeholder="Search by name, email, mobile, ubin or ticket no." style="width: 380px">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </li>
            <?php if($this->session->session_utype == 1) { ?>
            <li class="nav-item">
                <a  href="<?=base_url('settings')?>" class="nav-link">
                    <i class="fa fa-fw fa-gears"></i>Default Settings
                </a>
            </li>
            <?php } ?>
            <li class="nav-item">
                <a  href="<?=base_url('changepass')?>" class="nav-link">
                    <i class="fa fa-fw fa-gear"></i>Change password
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#logoutModal">
                    <i class="fa fa-fw fa-sign-out"></i>Logout
                </a>
            </li>
        </ul>
    </div>
</nav>
