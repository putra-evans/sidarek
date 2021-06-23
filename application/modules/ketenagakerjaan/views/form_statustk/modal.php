<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="judul-form"> </span>STATUS KETENAGAKERJAAN</b></h4>
            </div>
            <?php echo form_open_multipart(site_url('ketenagakerjaan/statustk/create'), array('id' => 'formEntry')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <input type="hidden" name="id_status" id="id_status">
                            <label for="nama" class="control-label"><b>Status Ketenagakerjaan <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Status Ketenagakerjaan">
                            <div class="help-block"></div>
                        </div>
                    </div>

                </div>


            </div>
            <div class="modal-footer" style="margin-top:0px;padding:10px 15px 15px 0px;">
                <button type="button" class="btn btn-default btnClose" style="padding:12px 16px;"><i class="fa fa-times"></i> CANCEL</button>
                <button type="submit" class="btn btn-primary" name="save" id="save" style="padding:12px 16px;"><i class="fa fa-check"></i> SUBMIT</button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->