<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" id="frmEntry">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b><span id="judul-form"> </span>PERAGAAN KOPERASI</b></h4>
      </div>
      <?php echo form_open_multipart(site_url('kebijakan/produk/create'), array('id' => 'formEntry')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <div class="row">
          <input type="hidden" id="id_peragaan_koperasi" name="id_peragaan_koperasi">
          <!--id_subsidi_kategori -->

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label style="font-size:16px;"><b>Tahun </b></label>
              <?php echo form_dropdown('tahun', array('' => '-- Semua Tahun --', 2023 => '2023', 2022 => '2022', 2021 => '2021', 2020 => '2020', 2019 => '2019', 2018 => '2018', 2017 => '2017', 2016 => '2016', 2015 => '2015', 2014 => '2014', 2013 => '2013', 2012 => '2012', 2011 => '2011', 2010 => '2010', 2009 => '2009'), $this->input->post('rujukan'), 'class="select-all" id="tahun"'); ?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_jumlah_unit" class="control-label"><b>total_jumlah_unit <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_jumlah_unit" id="total_jumlah_unit" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_unit_aktif" class="control-label"><b>total_unit_aktif <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_unit_aktif" id="total_unit_aktif" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_unit_nonaktif" class="control-label"><b>total_unit_nonaktif <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_unit_nonaktif" id="total_unit_nonaktif" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_jumlah_anggota" class="control-label"><b>total_jumlah_anggota <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_jumlah_anggota" id="total_jumlah_anggota" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_anggota_laki" class="control-label"><b>total_anggota_laki <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_anggota_laki" id="total_anggota_laki" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_anggota_perempuan" class="control-label"><b>total_anggota_perempuan <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_anggota_perempuan" id="total_anggota_perempuan" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_jumlah_manager" class="control-label"><b>total_jumlah_manager <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_jumlah_manager" id="total_jumlah_manager" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_manager_laki" class="control-label"><b>total_manager_laki <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_manager_laki" id="total_manager_laki" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_manager_perempuan" class="control-label"><b>total_manager_perempuan <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_manager_perempuan" id="total_manager_perempuan" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_jumlah_karyawan" class="control-label"><b>total_jumlah_karyawan <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_jumlah_karyawan" id="total_jumlah_karyawan" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_karyawan_laki" class="control-label"><b>total_karyawan_laki <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_karyawan_laki" id="total_karyawan_laki" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_karyawan_perempuan" class="control-label"><b>total_karyawan_perempuan <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_karyawan_perempuan" id="total_karyawan_perempuan" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group required">
              <label for="total_unit_rat" class="control-label"><b>total_unit_rat <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_unit_rat" id="total_unit_rat" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group required">
              <label for="total_persen_rat" class="control-label"><b>total_persen_rat <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_persen_rat" id="total_persen_rat" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group required">
              <label for="total_modal_sendiri" class="control-label"><b>total_modal_sendiri <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_modal_sendiri" id="total_modal_sendiri" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group required">
              <label for="total_modal_luar" class="control-label"><b>total_modal_luar <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_modal_luar" id="total_modal_luar" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_aset" class="control-label"><b>total_aset <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_aset" id="total_aset" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_volume_usaha" class="control-label"><b>total_volume_usaha <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_volume_usaha" id="total_volume_usaha" placeholder="Angka">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group required">
              <label for="total_snu" class="control-label"><b>total_snu <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="total_snu" id="total_snu" placeholder="Angka">
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