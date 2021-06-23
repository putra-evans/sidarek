<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" id="frmEntry">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b><span id="judul-form"> </span>PRODUK KEBIJAKAN</b></h4>
      </div>
      <?php echo form_open_multipart(site_url('kebijakan/produk/create'), array('id' => 'formEntry'));?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <div class="row">
          <input type="hidden" id="id_produk" name="id_produk">
          <!--id_bidang -->
          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="id_bidang" class="control-label"><b>Bidang Ekonomi <font color="red">*</font></b></label>
              <?php echo form_dropdown('id_bidang', $list_bidang, $this->input->post('id_bidang'), 'class="select-all" id="id_bidang"');?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="id_tipe" class="control-label"><b>Tipe Kebijakan <font color="red">*</font></b></label>
              <?php echo form_dropdown('id_tipe', array(''=>'Pilih Data', 1=>'Pusat', 2=>'Daerah'), $this->input->post('id_tipe'), 'class="select-all" id="id_tipe"');?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="id_bidang" class="control-label"><b>Tahun Kebijakan <font color="red">*</font></b></label>
              <?php echo form_dropdown('tahun', array(''=>'Pilih Data', 2020=>'2020', 2019=>'2019', 2018=>'2018'), $this->input->post('tahun'), 'class="select-all" id="tahun"');?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="nomor" class="control-label"><b>Tanggal Terbit <font color="red">*</font></b></label>
              <div class="input-group date" data-provide="datepicker">
                  <input type="text" id="tanggal_terbit" name="tanggal_terbit" class="form-control" data-date-format="yyyy-mm-dd" readonly>
                  <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                  </div>
              </div>

              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="nomor" class="control-label"><b>Nomor Kebijakan <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="nomor" id="nomor" placeholder="Nomor Kebijakan">
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="pemerintah" class="control-label"><b>Pemerintah <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="pemerintah" id="pemerintah" placeholder="Pemerintah">
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="judul" class="control-label"><b>Judul Kebijakan <font color="red">*</font></b></label>
              <textarea class="form-control" name="judul" id="judul" rows="2" placeholder="Judul Kebijakan"></textarea>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="sasaran" class="control-label"><b>Sasaran Kebijakan <font color="red">*</font></b></label>
              <textarea class="form-control" name="sasaran" id="sasaran" rows="2" placeholder="Sasaran Kebijakan"></textarea>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="target" class="control-label"><b>Target Kebijakan <font color="red">*</font></b></label>
              <textarea class="form-control" name="target" id="target" rows="2" placeholder="Target Kebijakan"></textarea>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="target" class="control-label"><b>File Kebijakan <font color="red">*</font></b></label>
              <div class="add" >
                  <input type="file" id="file_to_upload" name="file_to_upload" class="custom-file-upload" >
              </div>
              <div class="showupdate" >
                <span id="file-to-text" class="col-xs-12 col-sm-12"></span>
                <a target="_blank" href="#" class="btn btn-default" id="seefile">Lihat File</a>
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
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->