<div class="container">
  <div class="row" id="formParent">
    <div class="col-xs-12 col-sm-12">
      <?php echo $this->session->flashdata('message'); ?>
      <div id="errSuccess"></div>
    </div>

    <!-- Filter Table -->
    <div class="col-xs-12 col-sm-12">
      <div class="row">
        <div class="col-xs-12 col-sm-12">
          <?php echo form_open(site_url('#'), array('id' => 'formFilter', 'style' => 'display:none;margin-bottom:20px;')); ?>
          <div style="display:block;background:#FFF;padding:20px;border:1px solid #CCC;box-shadow:0px 0px 10px #CCC;">
            <div class="row">
              <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                  <label style="font-size:16px;"><b>Berdasarkan Perusahaan </b></label>
                  <?php echo form_dropdown('id_lapusaha_filter', $lapusaha, $this->input->post('id_lapusaha_filter', TRUE), 'class="select-all"'); ?>
                </div>
              </div>
              <div class="col-xs-12 col-sm-3">
                <div class="form-group required">
                  <label style="font-size:16px;"><b>Berdasarkan Tahun </b></label>
                  <?php echo form_dropdown('tahun_filter', array('' => '-- Semua Tahun --', 2023 => '2023', 2022 => '2022', 2021 => '2021', 2020 => '2020', 2019 => '2019', 2018 => '2018'), $this->input->post('rujukan'), 'class="select-all" id="tahun_filter"'); ?>
                  <div class="help-block"></div>
                </div>
              </div>
              <!-- <div class="col-xs-12 col-sm-3">
                <div class="form-group required">
                  <label style="font-size:16px;"><b>Berdasarkan Triwulan </b></label>
                  <?php echo form_dropdown('triwulan_filter', array('' => '-- Semua Triwulan --', 'Triwulan I' => 'Triwulan I', 'Triwulan II' => 'Triwulan II', 'Triwulan III' => 'Triwulan III', 'Triwulan IV' => 'Triwulan IV'), $this->input->post('triwulan_filter'), 'class="select-all" id="triwulan_filter"'); ?>
                  <div class="help-block"></div>
                </div>
              </div> -->

              <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                  <label style="font-size:16px;"><b>&nbsp;</b></label>
                  <div class="btn-toolbar">
                    <button type="submit" class="btn btn-primary" name="filter" id="filter"><i class="fa fa-filter"></i> LAKUKAN PENCARIAN</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>

    <!-- Table Data -->
    <div class="col-xs-12 col-sm-12">
      <div class="panel panel-green">
        <div class="panel-heading">
          <h4>Data Harga Konstan</h4>
          <h4 style="font-weight:bold;text-align:right; float:right;">
            <a href="javascript:void(0);" class="btnFilter" style="text-decoration:none;color:#FFFFFF;">
              <i class="fa fa-sliders"></i> Filter Data
            </a>
          </h4>
        </div>
        <div class="panel-body collapse in">
          <div class="clearfix">
            <div class="pull-right form-group clearfix">
              <button type="button" class="btn btn-success btn-sm" id="printExcel"><i class="fa fa-file-excel-o"></i> EXPORT KE EXCEL </button>
            </div>
          </div>
          <!-- <div class="clearfix">
            <div class="pull-left form-group clearfix">
              <button type="button" class="btn btn-primary" id="btnAdd"><b><i class="fa fa-plus"></i> Tambah Data</b></button>
            </div>
          </div> -->
          <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered" id="mainTbl" width="100%">
              <thead>
                <tr>
                  <th width="3%">#</th>
                  <th>Lapangan Usaha</th>
                  <th>Triwulan Ke</th>
                  <th>Tahun</th>
                  <th>Harga Konstan</th>
                  <th width="15%">Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- container -->

<?php $this->load->view("ekonomi_makro_mikro/form_harga_konstan/modal.php") ?>
<?php $this->load->view("ekonomi_makro_mikro/form_harga_konstan/js.php") ?>