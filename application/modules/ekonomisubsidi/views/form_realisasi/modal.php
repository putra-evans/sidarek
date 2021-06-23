<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
  <div class="modal-dialog modal-default" id="frmEntry">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b><span id="judul-form"> </span>REALISASI SUBSIDI</b></h4>
      </div>
      <?php echo form_open_multipart(site_url('ekonomisubsidi/realisasi/create'), array('id' => 'formEntry')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <div class="row">
          <input type="hidden" id="id_subsidi_realisasi" name="id_subsidi_realisasi">
          <!--id_subsidi_kategori -->
          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="id_regency" class="control-label"><b>Kab / Kota <font color="red">*</font></b></label>
              <?php echo form_dropdown('id_regency', $regency, $this->input->post('id_regency', TRUE), 'class="select-all" id="id_regency"'); ?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="id_subsidi" class="control-label"><b>Item Subsidi <font color="red">*</font></b></label>
              <?php echo form_dropdown('id_subsidi', $subsidi, $this->input->post('id_subsidi', TRUE), 'class="select-all" id="id_subsidi"'); ?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="id_bidang" class="control-label"><b>Tahun <font color="red">*</font></b></label>
              <?php echo form_dropdown('tahun', array('' => 'Pilih Data', 2021 => '2021', 2020 => '2020', 2019 => '2019', 2018 => '2018'), $this->input->post('tahun'), 'class="select-all" id="tahun"'); ?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="alokasi" class="control-label"><b>Alokasi Subsidi <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="alokasi" id="alokasi" placeholder="Alokasi Subsidi">
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="realokasi_i" class="control-label"><b>Realokasi I <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="realokasi_i" id="realokasi_i" placeholder="Realokasi I Subsidi">
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="realokasi_ii" class="control-label"><b>Realokasi II <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="realokasi_ii" id="realokasi_ii" placeholder="Realokasi II Subsidi">
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="realisasi" class="control-label"><b>Realisasi Subsidi <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="realisasi" id="realisasi" placeholder="Realisasi Subsidi">
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




<div class="modal fade in" id="modalSecondForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" id="frmSecond">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b><span id="judul-form"> </span>RINCIAN REALISASI <span id="subsidi_second"></span> tahun <span id="tahun_second"></span> di <span id="regency_second"></span></b></h4>
      </div>
      <?php echo form_open_multipart(site_url('ekonomisubsidi/detailrealisasi/create'), array('id' => 'formSecond')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <div class="row">
          <input type="hidden" id="id_subsidi_detail" name="id_subsidi_detail">
          <input type="hidden" id="id_subsidi_realisasi_fordetail" name="id_subsidi_realisasi_fordetail">


          <?php foreach ($months as $key => $value) : ?>
            <div class="col-xs-2 col-sm-2">
              <div class="form-group required">
                <label for="id_regency" class="control-label"><b><?= $value ?></b></label>
                <input type="text" class="form-control" name="detail[<?= $key ?>]" id="detail" placeholder="<?= $value ?>" value="0">
                <input type="hidden" class="form-control" name="id_subsidi_detail[<?= $key ?>]" id="id_subsidi_detail">
                <div class="help-block"></div>
              </div>
            </div>
          <?php endforeach; ?>



        </div>
      </div>
      <div class="modal-footer" style="margin-top:0px;padding:10px 15px 15px 0px;">
        <button type="button" class="btn btn-warning btnEditSecond" style="padding:12px 16px;"><i class="fa fa-times"></i> EDIT</button>
        <button type="button" class="btn btn-default btnClose" style="padding:12px 16px;"><i class="fa fa-times"></i> CLOSE</button>
        <button type="button" class="btn btn-danger btnCancel" style="padding:12px 16px;"><i class="fa fa-times"></i> CANCEL</button>
        <button type="submit" class="btn btn-primary btnSubmitSecond" name="save" id="save" style="padding:12px 16px;"><i class="fa fa-check"></i> SUBMIT</button>
      </div>
      <?php echo form_close(); ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->