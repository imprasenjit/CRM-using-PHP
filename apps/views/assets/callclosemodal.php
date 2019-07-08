<div class="modal fade" id="callcloseModal" tabindex="-1" role="dialog" aria-labelledby="callcloseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?=base_url('calls/close')?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                <input id="call_id" name="call_id" type="hidden" />
                <div class="modal-header">
                    <h5 class="modal-title" id="callcloseModalLabel">Do you want to close this call?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Remarks(If any)</label>
                    <textarea class="form-control"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        <i class="fa fa-remove"></i> Close
                    </button>
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-remove"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>