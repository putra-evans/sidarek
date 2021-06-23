<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="judul-form"> </span>HARGA KOMODITAS</b></h4>
            </div>
            <?php echo form_open_multipart(site_url('ekonomisubsidi/subsidi/create'), array('id' => 'formEntry')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>
                <div class="row">
                    <input type="hidden" name="id_komoditas_harga" id="id_komoditas_harga">

                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group required">
                            <label for="id_komoditas" class="control-label"><b>Komoditas<font color="red">*</font></b></label>
                            <?php echo form_dropdown('id_komoditas', $komoditas, $this->input->post('id_komoditas', TRUE), 'class="select-all" id="id_komoditas"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group required">
                            <label for="id_komoditas_kategori" class="control-label"><b>Kategori</b></label>
                            <?php echo form_dropdown('id_komoditas_kategori', array('' => 'Pilih Kategori'), $this->input->post('id_komoditas_kategori', TRUE), 'class="select-all" id="id_komoditas_kategori"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group required">
                            <label for="id_komoditas_jenis" class="control-label"><b>Jenis<font color="red">*</font></b></label>
                            <?php echo form_dropdown('id_komoditas_jenis', array('' => 'Pilih Jenis'), $this->input->post('id_komoditas_jenis', TRUE), 'class="select-all" id="id_komoditas_jenis"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="nomor" class="control-label"><b>Tanggal <font color="red">*</font></b></label>
                            <div class="input-group date" data-provide="datepicker" id="monday_date_datepicker">
                                <input type="text" id="monday_date" name="monday_date" class="form-control" data-date-format="yyyy-mm-dd" readonly>
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="minggu_tahun" class="control-label"><b>Minggu Ke- <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="minggu_tahun" id="minggu_tahun" placeholder="Minggu Tahun" readonly>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-8">
                        <div class="form-group required">
                            <label for="harga" class="control-label"><b>Harga <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group required">
                            <label for="satuan" class="control-label"><b>Satuan&nbsp; </b></label>
                            <span class="form-control" id="satuan-html"></span>
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


<div class="modal fade in" id="modalEntryBulk" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="frmEntryBulk">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnCloseBulk" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="judul-form"> </span>HARGA KOMODITAS</b></h4>
            </div>
            <?php echo form_open_multipart(site_url('ekonomisubsidi/subsidi/create'), array('id' => 'formEntryBulk')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>
                <div class="row mastertable">
                    <div class="col-md-12">
                        <table id="master-table" class="table table-bordered promotable">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <div class="modal-footer" style="margin-top:0px;padding:10px 15px 15px 0px;">
                <button type="button" class="btn btn-default btnCloseBulk" style="padding:12px 16px;"><i class="fa fa-times"></i> CANCEL</button>
                <button type="submit" class="btn btn-primary" name="save" id="save" style="padding:12px 16px;"><i class="fa fa-check"></i> SUBMIT</button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->