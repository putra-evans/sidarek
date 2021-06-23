<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
  <div class="modal-dialog modal-default" id="frmEntry">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b><span id="judul-form"> </span>REALISASI SUBSIDI</b></h4>
      </div>
      <?php echo form_open_multipart(site_url('ekonomicsr/csr/create'), array('id' => 'formEntry')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <div class="row">
          <input type="hidden" id="id_csr" name="id_csr">
          <!--id_subsidi_kategori -->

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label style="font-size:16px;"><b>Perusahaan </b></label>
              <?php echo form_dropdown('id_perusahaan', $perusahaan, $this->input->post('id_perusahaan_filter', TRUE), 'class="select-all" id="id_perusahaan"'); ?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label style="font-size:16px;"><b>Berdasarkan Tahun </b></label>
              <?php echo form_dropdown('tahun', array('' => '-- Semua Tahun --', 2020 => '2020', 2019 => '2019', 2018 => '2018'), $this->input->post('rujukan'), 'class="select-all" id="tahun"'); ?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="alokasi_dana" class="control-label"><b>Alokasi Dana <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="alokasi_dana" id="alokasi_dana" placeholder="Alokasi Dana">
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="realisasi_kemitraan" class="control-label"><b>Realisasi Kemitraan  <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="realisasi_kemitraan" id="realisasi_kemitraan" placeholder="Realisasi Kemitraan ">
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="realisasi_bina_lingkungan" class="control-label"><b>Realisasi Bina Lingkungan  <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="realisasi_bina_lingkungan" id="realisasi_bina_lingkungan" placeholder="Realisasi Bina Lingkungan ">
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="jumlah_realisasi" class="control-label"><b>Jumlah Realisasi  <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="jumlah_realisasi" id="jumlah_realisasi" placeholder="Jumlah Realisasi ">
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="keterangan" class="control-label"><b>Keterangan  <font color="red">*</font></b></label>
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