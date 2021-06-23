<div class="container">
    <div class="row" id="formParent">
        <div class="col-xs-12 col-sm-12">
            <?php echo $this->session->flashdata('message'); ?>
            <div id="errSuccess"></div>
            <div class="clearfix">
                <div class="pull-left form-group clearfix">
                    <button type="button" class="btn btn-primary" id="btnAdd"><b><i class="fa fa-plus"></i> Tambah Data Ketimpangan</b></button>
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
                                    <th width="15%">Daerah</th>
                                    <th width="15%">Susenas</th>
                                    <th width="10%">40% Berpengeluaran Rendah</th>
                                    <th width="20%">40% Berpengeluaran Menengah</th>
                                    <th width="20%">20% Berpengeluaran Tinggi</th>
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
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered table-striped" id="secTbl" width="100%">
                            <thead>
                                <tr>
                                    <th width="3%">#</th>
                                    <th width="15%">Daerah</th>
                                    <th width="15%">Susenas</th>
                                    <th width="10%">40% Berpengeluaran Rendah</th>
                                    <th width="20%">40% Berpengeluaran Menengah</th>
                                    <th width="20%">20% Berpengeluaran Tinggi</th>
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

<?php $this->load->view("ketimpangan/form_ketimpangan/modal.php") ?>
<?php $this->load->view("ketimpangan/form_ketimpangan/js.php") ?>