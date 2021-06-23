<div class="container">
  <div class="row" id="formParent">
    <div class="col-xs-12 col-sm-12">
      <?php echo $this->session->flashdata('message'); ?>
      <div id="errSuccess"></div>
    </div>




    <!-- Table Data -->
    <div class="col-xs-12 col-sm-12">
      <div class="panel panel-green">
        <div class="panel-heading">
          <h4>Data Komoditas Penyumbang</h4>
          <h4 style="font-weight:bold;text-align:right; float:right;">
          </h4>
        </div>
        <div class="panel-body collapse in">

          <!-- <div class="clearfix">
            <div class="pull-right form-group clearfix">
              <button type="button" class="btn btn-success btn-sm" id="printExcel"><i class="fa fa-file-excel-o"></i> EXPORT KE EXCEL </button>
            </div>
          </div> -->

          <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered" id="mainTbl" width="100%">
              <thead>
                <tr>
                  <th width="5%">#</th>
                  <th width="12%">Nomor</th>
                  <th width="30%">Jenis Komoditas</th>
                  <th width="40%">Nama Komoditas Penyumbang</th>
                  <th width="10%">Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- container -->

<?php $this->load->view("ekonomiinflasi/form_komoditas_penyumbang/modal.php") ?>
<?php $this->load->view("ekonomiinflasi/form_komoditas_penyumbang/js.php") ?>