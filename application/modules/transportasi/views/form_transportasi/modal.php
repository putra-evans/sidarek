<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="judul-form"> </span>TRANSPORTASI </b></h4>
            </div>
            <?php echo form_open_multipart(site_url('transportasi/transportasi/create'), array('id' => 'formEntry')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>
                <div class="row">

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label style="font-size:16px;"><b>Jenis Penerbangan </b></label>
                            <input type="hidden" name="id_transportasi" id="id_transportasi">
                            <?php echo form_dropdown('jenis_penerbangan', array('' => '-- Jenis Penerbangan --', 'Domestik' => 'Domestik', 'Internasional' => 'Internasional'), $this->input->post('jenis_penerbangan'),  'class="select-all" id="jenis_penerbangan"'); ?>
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
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="jumlah_datang" class="control-label"><b>Jumlah Datang (orang)<font color="red">*</font></b></label>
                            <input min="0" type="number" class="form-control" name="jumlah_datang" id="jumlah_datang" placeholder="Jumlah Datang">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="jumlah_berangkat" class="control-label"><b>Jumlah Berangkat (orang)<font color="red">*</font></b></label>
                            <input min="0" type="number" class="form-control" name="jumlah_berangkat" id="jumlah_berangkat" placeholder="Jumlah Berangkat">
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