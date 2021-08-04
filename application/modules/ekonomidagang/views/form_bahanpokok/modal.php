<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="judul-form"> </span>KOMODITI</b></h4>
            </div>
            <?php echo form_open_multipart(site_url('ekonomidagang/bahanpokok/create'), array('id' => 'formEntry')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>
                <div class="row">
                    <input type="hidden" name="id_komoditas" id="id_komoditas">
                    <input type="hidden" name="id_komoditas_kategori" id="id_komoditas_kategori">
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="nama_komoditas" class="control-label"><b>Nama Komoditas <font color="red">*</font></b></label>
                            <?php echo form_dropdown('nama_komoditas', $list_komoditi, $this->input->post('nama_komoditas', TRUE), 'class="select-all" id="nama_komoditas"'); ?>
                            <!-- <input type="text" class="form-control" name="nama_komoditas" id="nama_komoditas" placeholder="Nama Komoditas"> -->
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="nama_kategori" class="control-label"><b>Nama Kategori <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" placeholder="Nama Kategori">
                            <div class="help-block"></div>
                            <!-- <em>
                                <p>Kategori tidak perlu diisi jika <code>Komoditi</code> tidak <code>Memiliki Kategori</code></p>
                            </em> -->
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


<div class="modal fade in" id="modalJenis" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" id="frmSecond">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnCloseKomoditi" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="judul-form-komoditi"> </span>Jenis Komoditi</b></h4>
            </div>
            <?php echo form_open_multipart(site_url('ekonomidagang/komoditas/create'), array('id' => 'formJenis')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>
                <div class="row">
                    <input type="hidden" name="id_komoditas_jenis" id="id_komoditas_jenis">

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="id_komoditas_for_jenis" class="control-label"><b>Komoditi <font color="red">*</font></b></label>
                            <?php echo form_dropdown('id_komoditas_for_jenis', array('' => '-- Pilih Sektor --'), $this->input->post('id_komoditas_for_jenis'), 'class="select-all" id="id_komoditas_for_jenis"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="id_kategori_for_jenis" class="control-label"><b>Kategori <font color="red">*</font></b></label>
                            <?php echo form_dropdown('id_kategori_for_jenis', array('' => '-- Pilih Sektor --'), $this->input->post('id_kategori_for_jenis'), 'class="select-all" id="id_kategori_for_jenis"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="nama_jenis" class="control-label"><b>Nama Jenis <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="nama_jenis" id="nama_jenis" placeholder="Nama Jenis">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="satuan" class="control-label"><b>Satuan <font color="red">*</font></b></label>
                            <?php echo form_dropdown('satuan', array('' => '-- Pilih Satuan --', 'Kg' => 'Kg', 'Liter' => 'Liter', 'Ekor' => 'Ekor', '10 Butir' => '10 Butir'), $this->input->post('satuan'), 'class="select-all" id="satuan"'); ?>
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