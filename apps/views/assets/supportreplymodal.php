<div class="modal fade" id="supportreplyModal" tabindex="-1" role="dialog" aria-labelledby="supportreplyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?=base_url('supports/reply')?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                <div class="modal-header">
                    <h5 class="modal-title" id="supportreplyModalLabel">Support reply</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="reply_sid" name="support_id" type="hidden" />
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="msg" class="form-control"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Mark to</label>
                        <select name="mark_to[]" class="form-control mark_to" multiple="multiple">
                            <?php if($this->users_model->get_deptrows()) {
                                foreach($this->users_model->get_deptrows() as $usr) {
                                    $staffid = $usr->uid;
                                    $staffname = $usr->user_name;
                                    echo '<option value="'.$staffid.'">'.$staffname.'</option>';
                                } //End of foreach  
                            } else {
                                echo "<option value=''>No records found</option>";
                            } //End of if else ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        <i class="fa fa-remove"></i> Close
                    </button>
                    <button class="btn btn-success" type="submit" name="actiontype" value="replyclose">
                        <i class="fa fa-check"></i> Reply and Resolve
                    </button>
                    <button class="btn btn-primary" type="submit" name="actiontype" value="reply">
                        <i class="fa fa-check"></i> Reply
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

