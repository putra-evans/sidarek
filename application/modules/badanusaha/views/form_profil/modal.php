<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="judul-form"> </span>PROFIL BADAN USAHA</b></h4>
            </div>
            <?php echo form_open_multipart(site_url('sda/sektor/create'), array('id' => 'formEntry')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>

                <div class="row">
                    <input type="hidden" name="id_profil_bu" id="id_profil_bu">

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="nama_bu" class="control-label"><b>Nama Badan Usaha <font color="red">*</font></b></label>
                            <input type="text" class="form-control" rows="2" name="nama_bu" id="nama_bu" placeholder="Nama Badan Usaha">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="bidang_usaha" class="control-label"><b>Bidang Usaha</label>
                            <textarea class="form-control" name="bidang_usaha" id="bidang_usaha" rows="2" placeholder="Bidang Usaha"></textarea>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group required">
                            <label for="id_jenis_bu" class="control-label"><b>Jenis Badan Usaha <font color="red">*</font></b></label>
                            <?php echo form_dropdown('id_jenis_bu', $jenis_bu, $this->input->post('id_jenis_bu'), 'class="select-all" id="id_jenis_bu"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group required">
                            <label for="id_bentuk_bu" class="control-label"><b>Bentuk Badan Usaha <font color="red">*</font></b></label>
                            <?php echo form_dropdown('id_bentuk_bu', $bentuk_bu, $this->input->post('id_bentuk_bu'), 'class="select-all" id="id_bentuk_bu"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group required">
                            <label for="no_telp" class="control-label"><b>Nomor Telp <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="Nomor Telepon">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group required">
                            <label for="email" class="control-label"><b>Email <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group required">
                            <label for="tahun_berdiri" class="control-label"><b>Tahun Berdiri <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="tahun_berdiri" id="tahun_berdiri" placeholder="Tahun Berdiri">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group required">
                            <label for="persen_kepemilikan" class="control-label"><b>Persen Kepemilikan <font color="red">*</font></b></label>
                            <input type="number" class="form-control" name="persen_kepemilikan" id="persen_kepemilikan" step=".01" placeholder="Persen Kepemilikan">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group required">
                            <label for="modal_dasar" class="control-label"><b>Modal Dasar <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="modal_dasar" id="modal_dasar" placeholder="Modal Dasar">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group required">
                            <label for="nomor_perda_pendirian" class="control-label"><b>Nomor Perda Pendirian</label>
                            <input type="text" class="form-control" name="nomor_perda_pendirian" id="nomor_perda_pendirian" placeholder="Nomor Perda Pendirian">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="alamat" class="control-label"><b>Alamat <font color="red">*</font></b></label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="2" placeholder="Alamat"></textarea>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group required">
                            <label for="jumlah_komisaris" class="control-label"><b>Jumlah Komisari <font color="red">*</font></b></label>
                            <input type="number" class="form-control" name="jumlah_komisaris" id="jumlah_komisaris" placeholder="Modal Dasar">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group required">
                            <label for="jumlah_direksi" class="control-label"><b>Jumlah Direksi <font color="red">*</font></b></label>
                            <input type="number" class="form-control" name="jumlah_direksi" id="jumlah_direksi" placeholder="Modal Dasar">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="keterangan" class="control-label"><b>Keterangan <font color="red">*</font></b></label>
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="2" placeholder="Keterangan"></textarea>
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


<div class="modal fade in" id="penyertaanmodal" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="tipe-penyertaanmodal"> </span>&nbsp;<span id="badan-usaha-title"> </span></b></h4>
            </div>
            <?php echo form_open_multipart(site_url('sda/sektor/create'), array('id' => 'formEntry')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>


            </div>
            <div class="modal-footer" style="margin-top:0px;padding:10px 15px 15px 0px;">
                <button type="button" class="btn btn-default btnClose" style="padding:12px 16px;"><i class="fa fa-times"></i> CANCEL</button>
                <button type="submit" class="btn btn-primary" name="save" id="save" style="padding:12px 16px;"><i class="fa fa-check"></i> SUBMIT</button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->