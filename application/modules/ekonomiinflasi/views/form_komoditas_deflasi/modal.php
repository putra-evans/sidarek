<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
  <div class="modal-dialog modal-default" id="frmEntry">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b><span id="judul-form"> </span>DATA DEFLASI</b></h4>
      </div>
      <?php echo form_open_multipart(site_url('ekonomiinflasi/komoditas_deflasi/create'), array('id' => 'formEntry')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <div class="row">
          <input type="hidden" id="id_kom_inflasi" name="id_kom_inflasi">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="komoditas" class="control-label"><b>Komoditas Penyumbang Deflasi <font color="red">*</font></b></label>
              <?php echo form_dropdown('komoditas', $komoditas_penyumbang, $this->input->post('komoditas'), 'class="select-all" id="komoditas"'); ?>
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="inflasi" class="control-label"><b>Deflasi <font color="red">*</font></b></label>
              <input type="text" placeholder="Deflasi (%mtm)" class="form-control" name="inflasi" id="inflasi">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="andil" class="control-label"><b>Andil <font color="red">*</font></b></label>
              <input type="text" placeholder="Andil (%mtm)" class="form-control" name="andil" id="andil">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-8">
            <div class="form-group required">
              <label for="nomor" class="control-label"><b>Tanggal <font color="red">*</font></b></label>
              <div class="input-group date monday_date_datepicker" data-provide="datepicker" id="monday_date_datepicker">
                <input type="text" id="add_monday_date" name="monday_date" class="form-control" data-date-format="yyyy-mm-dd" readonly>
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
              </div>
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
    </div>
  </div>
</div>