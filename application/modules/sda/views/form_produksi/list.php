<div class="container">
  <div class="row" id="formParent">
    <div class="col-xs-12 col-sm-12">
      <?php echo $this->session->flashdata('message'); ?>
      <div id="errSuccess"></div>
    </div>

    <!-- Filter Table -->
    <div class="col-xs-12 col-sm-12">
      <!-- <div class="row">
        <div class="col-xs-12 col-sm-3">
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
                <label style="font-size:16px;"><b>Filter Sektor </b></label>
                <?php echo form_dropdown('id_sektor_filter', $list_sektor, $this->input->post('id_sektor_filter', TRUE), 'class="select-all" id="id_sektor_filter"'); ?>
              </div>
            </div>

            <div class="col-xs-12 col-sm-3">
              <div class="form-group">
                <label style="font-size:16px;"><b>Filter Komoditi </b></label>
                <?php echo form_dropdown('id_komoditi_filter', array('' => 'Pilih Sektor dahulu'), $this->input->post('id_komoditi_filter', TRUE), 'class="select-all" id="id_komoditi_filter"'); ?>
              </div>
            </div>
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
        <h4>Daftar Kebijakan</h4>
        <h4 style="font-weight:bold;text-align:right; float:right;">
          <a href="javascript:void(0);" class="btnFilter" style="text-decoration:none;color:#FFFFFF;">
            <i class="fa fa-sliders"></i> Filter Data
          </a>
        </h4>
      </div>
      <div class="panel-body collapse in">
        <!-- <div class="clearfix">
          <div class="pull-left form-group clearfix">
            <button type="button" class="btn btn-primary" id="btnAdd"><b><i class="fa fa-plus"></i> Tambah Produk</b></button>
          </div>
        </div> -->
        <div class="clearfix">
          <div class="pull-right form-group clearfix">
            <button type="button" class="btn btn-success btn-sm" id="printExcel"><i class="fa fa-file-excel-o"></i> EXPORT KE EXCEL </button>
          </div>
        </div>
        <div class="table-responsive">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered table-striped" id="sdatbl" width="100%">
            <thead>
              <tr>
                <th width="3%">#</th>
                <th width="27%">Sektor</th>
                <th width="20%">Komoditas</th>
                <th width="15%">Tahun</th>
                <th class="text-right" width="20%">Produksi</th>
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

<?php $this->load->view("sda/form_produksi/modal.php") ?>
<?php $this->load->view("sda/form_produksi/js.php") ?>