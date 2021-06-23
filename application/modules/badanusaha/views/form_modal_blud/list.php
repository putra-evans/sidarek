<div class="container">
    <div class="row" id="formParent">
        <div class="col-xs-12 col-sm-12">
            <?php echo $this->session->flashdata('message'); ?>
            <div id="errSuccess"></div>
        </div>

        <?php if (!isset($id_profil_bu)) { ?>

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
                                        <label style="font-size:16px;"><b>Filter Badan Usaha </b></label>
                                        <?php echo form_dropdown('id_profil_bu_filter', $profil_bus, $this->input->post('id_profil_bu_filter', true), 'class="select-all"'); ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <div class="form-group">
                                        <label style="font-size:16px;"><b>Filter Tahun </b></label>
                                        <?php echo form_dropdown('tahun_filter', array('' => '-- Semua Tahun --', 2020 => '2020', 2019 => '2019', 2018 => '2018', 2017 => '2017', 2016 => '2016'), $this->input->post('tahun_filter'), 'class="select-all" id="tahun_filter"'); ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <div class="form-group">
                                        <label style="font-size:16px;"><b>&nbsp;</b></label>
                                        <div class="btn-toolbar">
                                            <button type="submit" class="btn btn-primary" name="filter" id="filter"><i class="fa fa-filter"></i> FILTER</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>

        <?php } ?>

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
                        <div class="clearfix">
                            <div class="pull-right form-group clearfix">
                                <button type="button" class="btn btn-success btn-sm" id="printExcel"><i class="fa fa-file-excel-o"></i> EXPORT KE EXCEL </button>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="pull-left form-group clearfix">
                                <button type="button" class="btn btn-primary" id="btnAdd"><b><i class="fa fa-plus"></i> Tambah Produk</b></button>
                            </div>
                        </div>
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered table-striped" id="penyertaanmodaltbl" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Badan Usaha</th>
                                    <th>Tahun</th>
                                    <th>Penyertaan Modal</th>
                                    <th>Dividen</th>
                                    <th>Komponen</th>
                                    <!-- <th>Aset</th>
                                    <th>Liabilitas</th>
                                    <th>Ekuitas</th>
                                    <th>Pendapatan</th>
                                    <th>Laba Rugi</th> -->
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- container -->

<?php $this->load->view("badanusaha/form_modal_blud/modal.php") ?>
<?php $this->load->view("badanusaha/form_modal_blud/js.php") ?>