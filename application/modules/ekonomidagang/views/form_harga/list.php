<style>
    .bootstrap-datepicker-widget .datepicker-days table tbody tr:hover {
        background-color: #eee;
    }

    .bootstrap-datepicker-widget tr:hover {
        background-color: #808080;
    }

    .datepicker td.highlight {
        background: #eeeeee;
        cursor: pointer;
    }

    .highlight {
        background: #eeeeee;
        cursor: pointer;
    }

    .datepicker table tbody tr:hover td {
        background-color: #eee;
        border-radius: 0;
    }

    .ui-datepicker table tbody .ui-datepicker-week-col {
        cursor: pointer;
        color: red
    }
</style>
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
                                    <label style="font-size:16px;"><b>Berdasarkan Komoditas </b></label>
                                    <?php echo form_dropdown('id_komoditas_filter', $komoditas, $this->input->post('id_komoditas_filter', TRUE), 'class="select-all"'); ?>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-3">
                                <div class="form-group">
                                    <label style="font-size:16px;"><b>Berdasarkan Tahun </b></label>
                                    <?php echo form_dropdown('tahun_filter', array('' => 'Pilih Tahun', 2022 => '2022', 2021 => '2021', 2020 => '2020', 2019 => '2019', 2018 => '2018'), $tahun_filter, 'class="select-all" id="tahun_filter"'); ?>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-3">
                                <div class="form-group">
                                    <label style="font-size:16px;"><b>Berdasarkan Minggu </b></label>
                                    <?php echo form_dropdown('minggu_tahun_filter', $minggu_tahunes, $minggu_tahun_filter, 'class="select-all" id="minggu_tahun_filter"'); ?>
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
                    <h4><?php echo $page_name; ?></h4>
                    <h4 style="font-weight:bold;text-align:right; float:right;">
                        <a href="javascript:void(0);" class="btnFilter" style="text-decoration:none;color:#FFFFFF;">
                            <i class="fa fa-sliders"></i> Filter Data
                        </a>
                    </h4>
                </div>
                <div class="panel-body collapse in">


                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered table-striped" id="mainTbl" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <!-- <th>Tanggal</th>
                                    <th>Minggu</th> -->
                                    <th>Komoditas</th>
                                    <th>Kategori</th>
                                    <th>Jenis</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <!-- <th width="7%">Aksi</th> -->
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- container -->

<?php $this->load->view("ekonomidagang/form_harga/modal.php") ?>
<?php $this->load->view("ekonomidagang/form_harga/js.php") ?>