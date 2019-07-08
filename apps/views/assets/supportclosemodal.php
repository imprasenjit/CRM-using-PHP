<div class="modal fade" id="supportcloseModal" tabindex="-1" role="dialog" aria-labelledby="supportcloseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?=base_url('supports/close')?>" method="post"> 
                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                <div class="modal-header">
                    <h5 class="modal-title" id="supportcloseModalLabel">Do you want to close this ticket?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="close_sid" name="support_id" type="hidden" />
                    <label>Remarks(If any)</label>
                    <textarea name="note" class="form-control"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        <i class="fa fa-remove"></i> Close
                    </button>
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-check"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
