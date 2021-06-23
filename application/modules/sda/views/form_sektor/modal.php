<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="judul-form"> </span>SEKTOR</b></h4>
            </div>
            <?php echo form_open_multipart(site_url('sda/sektor/create'), array('id' => 'formEntry')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>
                <div class="row">
                    <input type="hidden" name="id_sektor" id="id_sektor">
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="nama_sektor" class="control-label"><b>Nama Sektor <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="nama_sektor" id="nama_sektor" placeholder="Nama Sektor">
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


<div class="modal fade in" id="modalKomoditi" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnCloseKomoditi" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="judul-form-komoditi"> </span>KOMODITI</b></h4>
            </div>
            <?php echo form_open_multipart(site_url('sda/komoditi/create'), array('id' => 'formKomoditi')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>
                <div class="row">
                    <input type="hidden" name="id_komoditi" id="id_komoditi">

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                        <label for="id_sektor_for_komoditi" class="control-label"><b>Sektor Sumber Daya Alam <font color="red">*</font></b></label>
                        <?php echo form_dropdown('id_sektor_for_komoditi', array('' => '-- Pilih Sektor --') , $this->input->post('id_sektor_for_komoditi'), 'class="select-all" id="id_sektor_for_komoditi"');?>
                        <div class="help-block"></div>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="nama_komoditi" class="control-label"><b>Nama Komoditi <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="nama_komoditi" id="nama_komoditi" placeholder="Nama Komoditi">
                            <div class="help-block"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer" style="margin-top:0px;padding:10px 15px 15px 0px;">
                <button type="button" class="btn btn-default btnCloseKomoditi" style="padding:12px 16px;"><i class="fa fa-times"></i> CANCEL</button>
                <button type="submit" class="btn btn-primary" name="save" id="save" style="padding:12px 16px;"><i class="fa fa-check"></i> SUBMIT</button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->