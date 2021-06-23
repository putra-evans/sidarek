<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="judul-form"> </span>PERUSAHAAN</b></h4>
            </div>
            <?php echo form_open_multipart(site_url('ekonomisubsidi/subsidi/create'), array('id' => 'formEntry')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>
                <div class="row">
                    <input type="hidden" name="id_umkmb" id="id_umkmb">

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="id_regency" class="control-label"><b>Kab / Kota <font color="red">*</font></b></label>
                            <?php echo form_dropdown('id_regency', $regency, $this->input->post('id_regency', TRUE), 'class="select-all" id="id_regency"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="id_bidang" class="control-label"><b>Tahun <font color="red">*</font></b></label>
                            <?php echo form_dropdown('tahun', array('' => 'Pilih Data', 2020 => '2020', 2019 => '2019', 2018 => '2018'), $this->input->post('tahun'), 'class="select-all" id="tahun"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="umk" class="control-label"><b>Usaha UMK <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="umk" id="umk" placeholder="UMK">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="umb" class="control-label"><b>Usaha UMB <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="umb" id="umb" placeholder="UMB">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="tk_umk" class="control-label"><b>Kerja UMK <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="tk_umk" id="tk_umk" placeholder="Tenaga Kerja UMK">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="tk_umb" class="control-label"><b>Kerja UMB <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="tk_umb" id="tk_umb" placeholder="Tenaga Kerja UMB">
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