<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
  <div class="modal-dialog modal-default" id="frmEntry">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b><span id="judul-form"> </span>HARGA BERLAKU</b></h4>
      </div>
      <?php echo form_open_multipart(site_url('ekonomi_makro_mikro/harga_berlaku/create'), array('id' => 'formEntry')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <div class="row">
          <input type="hidden" id="id_pdrb" name="id_pdrb">
          <!--id_subsidi_kategori -->

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label style="font-size:16px;"><b>Lapangan Usaha </b></label>
              <?php echo form_dropdown('id_lapusaha', $lapusaha, $this->input->post('id_lapusaha', TRUE), 'class="select-all" id="id_lapusaha"'); ?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label style="font-size:16px;"><b>Triwulan Ke </b></label>
              <?php echo form_dropdown('triwulan', array('' => '-- Semua Triwulan --', 'Triwulan I' => 'Triwulan I', 'Triwulan II' => 'Triwulan II', 'Triwulan III' => 'Triwulan III', 'Triwulan IV' => 'Triwulan IV'), $this->input->post('triwulan'), 'class="select-all" id="triwulan"'); ?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label style="font-size:16px;"><b>Berdasarkan Tahun </b></label>
              <?php echo form_dropdown('tahun', array('' => '-- Semua Tahun --', 2023 => '2023', 2022 => '2022', 2021 => '2021', 2020 => '2020', 2019 => '2019', 2018 => '2018'), $this->input->post('rujukan'), 'class="select-all" id="tahun"'); ?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="jenis_pdrb" class="control-label"><b>Jenis PDRB <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="jenis_pdrb" id="jenis_pdrb" value="harga berlaku" placeholder="Harga berlaku" readonly>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="harga_berlaku" class="control-label"><b>Harga Berlaku <font color="red">*</font></b></label>
              <input step="0.01" type="number" class="form-control" name="harga_berlaku" id="harga_berlaku" placeholder="Harga Berlaku ">
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