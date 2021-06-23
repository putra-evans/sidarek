<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" id="frmEntry">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b><span id="judul-form"> </span>PRODUKSI SUMBER DAYA ALAM</b></h4>
      </div>
      <?php echo form_open_multipart(site_url('sda/produksi/create'), array('id' => 'formEntry'));?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <div class="row">
          <input type="hidden" id="id_produksi_sda" name="id_produksi_sda">
          <!--id_bidang -->
          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="id_sektor" class="control-label"><b>Sektor Sumber Daya Alam <font color="red">*</font></b></label>
              <?php echo form_dropdown('id_sektor', $list_sektor, $this->input->post('id_sektor'), 'class="select-all" id="id_sektor"');?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="id_komoditi" class="control-label"><b>Komoditi Sumber Daya Alam <font color="red">*</font></b></label>
              <?php echo form_dropdown('id_komoditi', array('' => 'Pilih Sektor dahulu'), $this->input->post('id_komoditi'), 'class="select-all" id="id_komoditi"');?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="tahun" class="control-label"><b>Tahun Produksi <font color="red">*</font></b></label>
              <?php echo form_dropdown('tahun', array(''=>'Pilih Data', 2020=>'2020', 2019=>'2019', 2018=>'2018'), $this->input->post('tahun'), 'class="select-all" id="tahun"');?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="produksi" class="control-label"><b>Jumlah Produksi <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="produksi" id="produksi" placeholder="Jumlah Produksi">
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