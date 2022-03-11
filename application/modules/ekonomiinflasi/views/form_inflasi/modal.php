<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
  <div class="modal-dialog modal-default" id="frmEntry">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b><span id="judul-form"> </span>DATA INFLASI</b></h4>
      </div>
      <?php echo form_open_multipart(site_url('ekonomisubsidi/realisasi/create'), array('id' => 'formEntry')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <div class="row">
          <input type="hidden" id="id_inflasi" name="id_inflasi">
          <!--id_subsidi_kategori -->

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="tahun_inflasi" class="control-label"><b>Tahun <font color="red">*</font></b></label>
              <?php echo form_dropdown('tahun_inflasi', array('' => 'Pilih Tahun', 2023 => '2023', 2022 => '2022', 2021 => '2021', 2020 => '2020', 2019 => '2019', 2018 => '2018'), $this->input->post('tahun_inflasi'), 'class="select-all" id="tahun"'); ?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="id_tipe_inflasi" class="control-label"><b>Tipe Inflasi <font color="red">*</font></b></label>
              <?php echo form_dropdown('id_tipe_inflasi', $tipe_inflasi, $this->input->post('id_tipe_inflasi', TRUE), 'class="select-all" id="id_tipe_inflasi"'); ?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12">
            <div class="form-group required">
              <label for="id_daerah_inflasi" class="control-label"><b>Kategori Inflasi <font color="red">*</font></b></label>
              <?php echo form_dropdown('id_daerah_inflasi', $daerah_inflasi, $this->input->post('id_daerah_inflasi', TRUE), 'class="select-all" id="id_daerah_inflasi"'); ?>
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
  <div class="modal-dialog modal-default" id="frmSecond">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b><span id="judul-form"> </span>RINCIAN <span id="daerah_second"></span> - <span id="tahun_second"></span> - <span id="tipe_second"></span></b></h4>
      </div>
      <?php echo form_open_multipart(site_url('ekonomisubsidi/detailrealisasi/create'), array('id' => 'formSecond')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <div class="row">
          <input type="hidden" id="id_inflasi" name="id_inflasi">
          <input type="hidden" id="id_inflasi_detail" name="id_inflasi_detail">


          <div class="col-md-8 col-md-offset-2">
            <table class='table table-bordered no-footer'>
              <thead>
                <tr>
                  <th>Bulan</th>
                  <th>Inflasi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($bulan as $key => $value) : ?>
                  <tr>
                    <td>
                      <?= $value ?>
                    </td>
                    <td class="text-center">
                      <a href="javascript:void(0)" id="bulan_<?= $key ?>" class="editable" data-bulan="<?= $key ?>" name="bulan[<?= $key ?>]" onclick="popup(this)"> 0.00</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
      <div class="modal-footer" style="margin-top:0px;padding:10px 15px 15px 0px;">
        <!-- <button type="button" class="btn btn-warning btnEditSecond" style="padding:12px 16px;"><i class="fa fa-times"></i> EDIT</button> -->
        <button type="button" class="btn btn-default btnClose" style="padding:12px 16px;"><i class="fa fa-times"></i> CLOSE</button>
      </div>
      <?php echo form_close(); ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade in" id="modalImportForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
  <div class="modal-dialog modal-default" id="frmThird">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b><span id="judul-form"> </span>IMPORT DATA INFLASI</b></h4>
      </div>
      <?php echo form_open_multipart(site_url('ekonomiinflasi/inflasi/import-from-excel'), array('id' => 'formThird')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <div class="row">

          <div class="form-group">
            <label for="excel_file" class="col-md-4 control-label"></label>
            <div class="col-md-6">
              <label for="excel_file" class="control-label">Format file import bisa didownload <a href="<?php echo base_url('assets/files/export_templates/template_inflasi.xlsx') ?>">disini</a></label>
            </div>
          </div>
          <div class="form-group">

            <label for="excel_file" class="col-md-4 control-label">CSV file to import</label>

            <div class="col-md-6">
              <input id="excel_file" type="file" class="form-control" name="excel_file" required="">
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="header" checked=""> Apakah file mempunyai header?
                </label>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer" style="margin-top:0px;padding:10px 15px 15px 0px;">
        <button type="button" class="btn btn-default btnClose" style="padding:12px 16px;"><i class="fa fa-times"></i> CLOSE</button>
        <button type="submit" class="btn btn-primary btnSubmitSecond" name="save" id="save" style="padding:12px 16px;"><i class="fa fa-upload"></i> IMPORT</button>
      </div>
      <?php echo form_close(); ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->