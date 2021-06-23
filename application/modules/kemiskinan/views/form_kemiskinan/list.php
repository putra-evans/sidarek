<div class="container">
    <div class="row" id="formParent">
        <div class="col-xs-12 col-sm-12">
            <?php echo $this->session->flashdata('message'); ?>
            <div id="errSuccess"></div>
            <div class="clearfix">
                <div class="pull-left form-group clearfix">
                    <button type="button" class="btn btn-primary" id="btnAdd"><b><i class="fa fa-plus"></i> Tambah Data Kemiskinan</b></button>
                </div>
            </div>
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
                                    <label style="font-size:16px;"><b>Jenis Ketenagakerjaan </b></label>
                                    <?php echo form_dropdown('status', $stt, $this->input->post('status', TRUE), 'class="select-all"'); ?>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <div class="form-group required">
                                    <label for="nomor" class="control-label"><b>Bulan/Tahun <font color="red">*</font></b></label>
                                    <div class="input-group date monday_date_datepicker1" data-provide="datepicker" id="monday_date_datepicker1">
                                        <input type="text" id="add_monday_date1" name="monday_date" class="form-control" data-date-format="yyyy-mm-dd" readonly>
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <div class="help-block"></div>
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
        <!-- Table Data Sektor -->
        <div class="col-xs-6 col-sm-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <h4>Data Perkotaan</h4>
                </div>
                <div class="panel-body collapse in">
                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered table-striped" id="mainTbl" width="100%">
                            <thead>
                                <tr>
                                    <th width="3%">#</th>
                                    <th width="15%">Tipe Daerah</th>
                                    <th width="10%">Bulan</th>
                                    <th width="20%">Jumlah</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Data Komoditi -->
        <div class="col-xs-6 col-sm-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <h4>Data Pedesaan <span id="sektor-name"></span></h4>
                </div>
                <div class="panel-body collapse in">



                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered table-striped" id="desatbl" width="100%">
                            <thead>
                                <tr>
                                    <th width="3%">#</th>
                                    <th width="15%">Tipe Daerah</th>
                                    <th width="10%">Bulan</th>
                                    <th width="20%">Jumlah</th>
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

<?php $this->load->view("kemiskinan/form_kemiskinan/modal.php") ?>
<?php $this->load->view("kemiskinan/form_kemiskinan/js.php") ?>