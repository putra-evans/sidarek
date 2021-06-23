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
                    <input type="hidden" name="id_ekraf" id="id_ekraf">

                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group required">
                            <label for="id_regency" class="control-label"><b>Kab / Kota <font color="red">*</font></b></label>
                            <?php echo form_dropdown('id_regency', $regency, $this->input->post('id_regency', TRUE), 'class="select-all" id="id_regency"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group required">
                            <label for="id_district" class="control-label"><b>Kecamatan <font color="red">*</font></b></label>
                            <?php echo form_dropdown('id_district', array('' => 'Pilih Kecamatan'), $this->input->post('id_district', TRUE), 'class="select-all" id="id_district"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group required">
                            <label for="id_village" class="control-label"><b>Kelurahan <font color="red">*</font></b></label>
                            <?php echo form_dropdown('id_village', array('' => 'Pilih Kelurahan'), $this->input->post('id_village', TRUE), 'class="select-all" id="id_village"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="usaha_nama" class="control-label"><b>Nama Usaha <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="usaha_nama" id="usaha_nama" placeholder="Nama Usaha">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="usaha_owner" class="control-label"><b>Nama Owner<font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="usaha_owner" id="usaha_owner" placeholder="Nama Owner">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="no_hp" class="control-label"><b>No Handphone<font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No Handphone">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="id_jenis_ekraf" class="control-label"><b>Jenis Ekraf <font color="red">*</font></b></label>
                            <?php echo form_dropdown('id_jenis_ekraf', $jenis_ekraf, $this->input->post('id_jenis_ekraf', TRUE), 'class="select-all" id="id_jenis_ekraf"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="alamat_jalan" class="control-label"><b>Alamat Jalan <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="alamat_jalan" id="alamat_jalan" placeholder="Alamat Jalan">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="alamat_nomor" class="control-label"><b>Alamat Nomor <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="alamat_nomor" id="alamat_nomor" placeholder="Alamat Nomor">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="alamat_rt_rw" class="control-label"><b>Alamat RT / RW <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="alamat_rt_rw" id="alamat_rt_rw" placeholder="Alamat RT / RW">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="kode_pos" class="control-label"><b>Kode POS <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="kode_pos" id="kode_pos" placeholder="Kode POS">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="usaha_umur" class="control-label"><b>Umur Usaha <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="usaha_umur" id="usaha_umur" placeholder="Umur Dalam Bulan">
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