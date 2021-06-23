<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
  <div class="modal-dialog" id="frmEntry">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b><span id="judul-form"> </span>KOMODITAS PENYUMBANG</b></h4>
      </div>
      <?php echo form_open_multipart(site_url('ekonomiinflasi/komoditas_penyumbang/create'), array('id' => 'formEntry')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <div class="row">
          <input type="hidden" id="id_komoditas" name="id_komoditas">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="judul" class="control-label"><b>Jenis Komoditas Penyumbang Inflasi dan Deflasi <font color="red">*</font></b></label>
              <?php echo form_dropdown('jenis_komoditas', $jenis_komoditas, $this->input->post('jenis_komoditas'), 'class="select-all" id="jenis_komoditas"'); ?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="sasaran" class="control-label"><b>Nama Komoditas Penyumbang <font color="red">*</font></b></label>
              <input type="text" placeholder="Nama Komoditas Penyumbang" class="form-control" name="namakomoditas" id="namakomoditas">
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