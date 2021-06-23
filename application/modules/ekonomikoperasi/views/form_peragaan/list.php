<style>
  .table thead,
  .table th {
    text-align: center;
  }

  th.dt-center,
  td.dt-center {
    text-align: center;
  }

  table.dataTable thead>tr>th {
    padding-right: 5px !important;
    padding-left: 5px !important;
    vertical-align: middle !important;
  }
</style>

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
          <h4>Data Peragaan Koperasi</h4>
        </div>
        <div class="panel-body collapse in">
          <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered" id="mainTbl" width="100%">
              <thead>
                <tr>
                  <th rowspan="2">Tahun</th>
                  <th colspan="3" class="cyany">Koperasi (Unit)</th>
                  <!-- <th colspan="3" class="cyany">Anggota</th>
                  <th colspan="3" class="cyany">Manager</th>
                  <th colspan="3" class="cyany">Karyawan</th> -->
                  <th rowspan="2">RAT</th>
                  <th rowspan="2">%RAT</th>
                  <th rowspan="2">Modal Sendiri</th>
                  <th rowspan="2">Modal Luar</th>
                  <th rowspan="2">Aset</th>
                  <th rowspan="2">Volume Usaha</th>
                  <th rowspan="2">SNU</th>
                  <th rowspan="2">Kab/Kota</th>
                  <th rowspan="2">Prov</th>
                  <th rowspan="2">Aksi</th>

                </tr>
                <tr>
                  <th>jml</th>
                  <th>akt</th>
                  <th>nonakt</th>
                  <!-- <th>jml</th>
                  <th>L</th>
                  <th>P</th>
                  <th>jml</th>
                  <th>L</th>
                  <th>P</th>
                  <th>jml</th>
                  <th>L</th>
                  <th>P</th> -->
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- container -->

<?php $this->load->view("ekonomikoperasi/form_peragaan/modal.php") ?>
<?php $this->load->view("ekonomikoperasi/form_peragaan/js.php") ?>