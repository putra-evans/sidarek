<div class="container">
  <div class="row" id="formParent">
    <div class="col-xs-12 col-sm-12">
      <?php echo $this->session->flashdata('message'); ?>
      <div id="errSuccess"></div>
    </div>

    <!-- Filter Table -->
    <div class="col-xs-12 col-sm-12">
      <div class="row">
        <!-- <div class="col-xs-12 col-sm-3">
          <h3 style="font-weight:bold;text-align:left;">
            <a href="javascript:void(0);" class="btnFilter" style="text-decoration:none;color:#000000;">
              <i class="fa fa-sliders"></i> Filter Data
            </a>
          </h3>
        </div> -->
        <div class="col-xs-12 col-sm-12">
          <?php echo form_open(site_url('#'), array('id' => 'formFilter', 'style' => 'display:none;margin-bottom:20px;')); ?>
          <div style="display:block;background:#FFF;padding:20px;border:1px solid #CCC;box-shadow:0px 0px 10px #CCC;">
            <div class="row">
              <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                  <label style="font-size:16px;"><b>Filter berdasarkan Bidang </b></label>
                  <?php echo form_dropdown('id_bidang', $list_bidang, $this->input->post('id_bidang', TRUE), 'class="select-all"'); ?>
                </div>
              </div>
              <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                  <label style="font-size:16px;"><b>Filter berdasarkan Tahun </b></label>
                  <div class="input-group date monday_date_datepicker1" data-provide="datepicker" id="monday_date_datepicker1">
                    <input type="text" id="tahun" name="tahun" class="form-control" data-date-format="yyyy" readonly>
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                  </div>
                  <!-- <?php echo form_dropdown('tahun', array('' => '-- Semua Tahun --', 2020 => '2020', 2019 => '2019', 2018 => '2018'), $this->input->post('tahun'), 'class="select-all" id="tahun"'); ?> -->
                </div>
              </div>
              <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                  <label style="font-size:16px;"><b>Filter berdasarkan Tipe </b></label>
                  <?php echo form_dropdown('id_tipe', array('' => '-- Semua Tipe --', 1 => 'Pusat', 2 => 'Daerah'), $this->input->post('id_tipe'), 'class="select-all" id="id_tipe"'); ?>
                </div>
              </div>
              <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                  <label style="font-size:16px;"><b>&nbsp;</b></label>
                  <div class="btn-toolbar">
                    <button type="submit" class="btn btn-primary" name="filter" id="filter"><i class="fa fa-filter"></i> LAKUKAN PENCARIAN</button>
                    <!-- <button type="button" class="btn btn-success btn-sm" id="printExcel"><i class="fa fa-file-excel-o"></i> EXPORT KE EXCEL </button> -->

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
          <h4>Daftar Kebijakan</h4>
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

          <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered" id="mainTbl" width="100%">
              <thead>
                <tr>
                  <th width="3%">#</th>
                  <th width="12%">Nomor</th>
                  <th width="5%">Tahun</th>
                  <th width="25%">Judul</th>
                  <th width="20%">Sasaran</th>
                  <th width="20%">Target</th>
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

<?php $this->load->view("kebijakan/form_produk/modal.php") ?>
<?php $this->load->view("kebijakan/form_produk/js.php") ?>