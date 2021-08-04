<div class="container">
    <div class="row" id="formParent">
        <div class="col-xs-12 col-sm-12">
            <?php echo $this->session->flashdata('message'); ?>
            <div id="errSuccess"></div>
        </div>

        <!-- Table Data Sektor -->
        <div class="col-xs-6 col-sm-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <h4>Data Komoditi Berdasarkan Kategori Bahan Pokok</h4>
                </div>
                <div class="panel-body collapse in">

                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered table-striped" id="mainTbl" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Komoditi</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
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
                    <h4>Rincian Data Berdasarkan Kategori <span id="komoditi-kategori-name"></span></h4>
                </div>
                <div class="panel-body collapse in">

                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered table-striped" id="secondTbl" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jenis</th>
                                    <th width="5%">Satuan</th>
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

<?php $this->load->view("ekonomidagang/form_bahanpokok/modal.php") ?>
<?php $this->load->view("ekonomidagang/form_bahanpokok/js.php") ?>