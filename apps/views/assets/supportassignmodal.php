<div class="modal fade" id="supportassignModal" tabindex="-1" role="dialog" aria-labelledby="supportassignModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?=base_url('supports/assign')?>" method="post">   
                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                <div class="modal-header">
                    <h5 class="modal-title" id="supportassignModalLabel">Assign ticket</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="assign_sid" name="support_id" type="hidden" />
                    <div class="form-group">
                        <label>Note (If any)</label>
                        <textarea name="note" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Assign to</label>
                        <select name="uid" class="form-control">
                            <option value="">Select</option>
                            <?php if($this->users_model->get_staffrows()) {
                                foreach($this->users_model->get_staffrows() as $usr) {
                                    $staffid = $usr->uid;
                                    $staffuname = $usr->uname;
                                    $staffname = $usr->user_name;
                                    if($staffuname != "admin") {
                                        echo '<option value="'.$staffid.'">'.$staffname.'</option>';
                                    }
                                } //End of foreach  
                            } else {
                                echo "<option value=''>No records found</option>";
                            } //End of if else ?>
                        </select>
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
                    
                    <div class="form-group">
                        <label>Priority<span class="text-danger">*</span></label><br />
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="priority" id="p1" value="1" style="margin-left: 0">
                            <label class="form-check-label" for="p1">High</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="priority" id="p2" value="2" style="margin-left: 0">
                            <label class="form-check-label" for="p2">Medium</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="priority" id="p3" value="3" style="margin-left: 0">
                            <label class="form-check-label" for="p3">Low</label>
                        </div>
                        <br />
                        <?=form_error("priority")?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        <i class="fa fa-remove"></i> Close
                    </button>
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-check"></i> Assign now
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
