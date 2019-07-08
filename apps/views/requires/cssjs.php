<link rel="icon" href="<?=base_url('public/imgs/favicon.ico')?>" type="image/ico">
<link href="<?=base_url('public/bootstrap-4/css/bootstrap.min.css')?>" rel="stylesheet">
<link href="<?=base_url('public/font-awesome-4.7.0/css/font-awesome.min.css')?>" rel="stylesheet">
<link href="<?=base_url('public/css/animate.css')?>" rel="stylesheet">
<link href="<?=base_url('public/css/admin.css')?>" rel="stylesheet">

<script src="<?=base_url('public/js/jquery-3.3.1.min.js')?>"></script>
<script src="<?=base_url('public/bootstrap-4/js/bootstrap.bundle.min.js')?>"></script>
<script src="<?=base_url('public/js/notify.min.js')?>"></script>
<script src="<?=base_url('public/js/admin.js')?>"></script>
<script type="text/javascript">
$(document).ready(function () {
    $(document).on("click", ".del", function () {
        if (confirm("Do you want to delete this record permamently?")) {
            return true;
        } else {
            return false;
        }
    }); //End of onclick .del
    $('[data-toggle="tooltip"]').tooltip();    
});
</script>
