<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="judul-form"> </span>IMPOR</b></h4>
            </div>
            <?php echo form_open_multipart(site_url('ekonomi_makro_mikro_impor/cif/create'), array('id' => 'formEntry')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>
                <div class="row">

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label style="font-size:16px;"><b>Golongan Barang </b></label>
                            <input type="hidden" name="id_impor" id="id_impor">
                            <?php echo form_dropdown('id_golongan', $golongan, $this->input->post('id_golongan', TRUE), 'class="select-all" id="id_golongan"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="nomor" class="control-label"><b>Bulan/Tahun <font color="red">*</font></b></label>
                            <div class="input-group date monday_date_datepicker" data-provide="datepicker" id="monday_date_datepicker">
                                <input type="text" id="add_monday_date" name="monday_date" class="form-control" data-date-format="yyyy-mm-dd" readonly>
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="nilaicif" class="control-label"><b>Nilai CIF <font color="red">*</font></b></label>
                            <input step="0.01" type="number" class="form-control" name="nilaicif" id="nilaicif" placeholder="Nilai CIF">
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