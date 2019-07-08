<?php $sutype = $this->session->session_utype; ?>
<ul class="navbar-nav navbar-sidenav" id="sidebar" style="overflow-y: auto; overflow-x: hidden">
    <?php if($sutype == 1) { ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('users')?>">
            <i class="fa fa-fw fa-user-plus"></i>
            <span class="nav-link-text">Users</span>
        </a>
    </li>
    <?php } if($sutype == 1 || $sutype == 3) { ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('calls')?>">
            <i class="fa fa-fw fa-phone"></i>
            <span class="nav-link-text">Calls</span>
        </a>
    </li>
    <?php } if($sutype == 1) { ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('ticketsnew')?>">
            <i class="fa fa-edit"></i>
            <span class="nav-link-text">New Tickets</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('ticketsopen')?>">
            <i class="fa fa-folder-open-o"></i>
            <span class="nav-link-text">Open Tickets</span>
        </a>
    </li>
    <?php } elseif($sutype == 4) { ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('ticketsmarked')?>">
            <i class="fa fa-folder-open-o"></i>
            <span class="nav-link-text">My Tickets</span>
        </a>
    </li>
    <?php } else { ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('ticketsopen')?>">
            <i class="fa fa-folder-open-o"></i>
            <span class="nav-link-text">My Tickets</span>
        </a>
    </li>
    <?php } ?>
    
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('ticketsclose')?>">
            <i class="fa fa-check-square"></i>
            <span class="nav-link-text">Resolved Tickets</span>
        </a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#reportsmenu" data-toggle="collapse" data-target="#reportsmenu" aria-expanded="false">
            <i class="fa fa-file-pdf-o"></i>
            Datewise Reports
        </a>
        <div class="collapse" id="reportsmenu" aria-expanded="false" style="">                        
            <ul class="flex-column pl-2 nav">                            
                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url('reports/')?>">
                        <i class="fa fa-question-circle-o"></i>
                        <span class="nav-link-text">Tickets Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url('reports/calls')?>">
                        <i class="fa fa-phone"></i>
                        <span class="nav-link-text">Calls Reports</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    
    <?php if($sutype == 1) { ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('querytypes')?>">
            <i class="fa fa-list-ol"></i>
            <span class="nav-link-text">Query Types</span>
        </a>
    </li>
    <?php } if($sutype == 1) {?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('userlogs')?>">
            <i class="fa fa-list-ul"></i>
            <span class="nav-link-text">Login reports</span>
        </a>
    </li>    
    <?php } else { ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('userlogs/userwise/').$this->session->session_uid?>">
            <i class="fa fa-list-ul"></i>
            <span class="nav-link-text">Login reports</span>
        </a>
    </li>
    <?php } ?>
</ul>

