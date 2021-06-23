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
                    <input type="hidden" name="id_koperasi" id="id_koperasi">

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="id_regency" class="control-label"><b>Kab / Kota <font color="red">*</font></b></label>
                            <?php echo form_dropdown('id_regency', $regency, $this->input->post('id_regency', TRUE), 'class="select-all" id="id_regency"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="nama" class="control-label"><b>Nama Koperasi <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Koperasi">
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

                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group required">
                            <label for="status" class="control-label"><b>Status <font color="red">*</font></b></label>
                            <?php echo form_dropdown('status', ['' => '-- Pilih Status --', 'Izin Penuh' => 'Izin Penuh'], $this->input->post('status', TRUE), 'class="select-all" id="status"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group required">
                            <label for="badan_hukum" class="control-label"><b>Badan Hukum <font color="red">*</font></b></label>
                            <?php echo form_dropdown('badan_hukum', ['' => '-- Pilih Badan Hukum --', 'Koperasi' => 'Koperasi', 'PT' => 'PT'], $this->input->post('badan_hukum', TRUE), 'class="select-all" id="badan_hukum"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group required">
                            <label for="jenis_usaha" class="control-label"><b>Jenis Usaha <font color="red">*</font></b></label>
                            <?php echo form_dropdown('jenis_usaha', ['' => '-- Pilih Jenis Usaha --', 'Syariah' => 'Syariah', 'Konvensional' => 'Konvensional'], $this->input->post('jenis_usaha', TRUE), 'class="select-all" id="jenis_usaha"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="izin_usaha" class="control-label"><b>Izin Usaha <font color="red">*</font></b></label>
                            <textarea class="form-control" name="izin_usaha" id="izin_usaha" rows="2" placeholder="Izin Usaha"></textarea>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="tanggal_izin_usaha" class="control-label"><b>Tanggal Terbit Izin Usaha<font color="red">*</font></b></label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" id="tanggal_izin_usaha" name="tanggal_izin_usaha" class="form-control" data-date-format="yyyy-mm-dd" readonly>
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>

                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="surat_ojk" class="control-label"><b>Surat OJK <font color="red">*</font></b></label>
                            <textarea class="form-control" name="surat_ojk" id="surat_ojk" rows="2" placeholder="Surat OJK"></textarea>
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