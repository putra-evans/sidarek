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
                    <h4>Daftar Sektor</h4>
                </div>
                <div class="panel-body collapse in">


                    <!-- <div class="clearfix">
                        <div class="pull-left form-group clearfix">
                            <button type="button" class="btn btn-primary" id="btnAdd"><b><i class="fa fa-plus"></i> Tambah Sektor</b></button>
                        </div>
                    </div> -->


                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered table-striped" id="sektortbl" width="100%">
                            <thead>
                                <tr>
                                    <th width="3%">#</th>
                                    <th width="17%">Sektor</th>
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
                    <h4>Daftar Komoditi <span id="sektor-name"></span></h4>
                </div>
                <div class="panel-body collapse in">

                    <div class="clearfix">
                        <div class="pull-left form-group clearfix">
                            <button type="button" class="btn btn-primary" id="btnAddKomoditi"><b><i class="fa fa-plus"></i> Tambah Komoditi</b></button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered table-striped" id="komodititbl" width="100%">
                            <thead>
                                <tr>
                                    <th width="3%">#</th>
                                    <th width="25%">Komoditi</th>
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

<?php $this->load->view("sda/form_sektor/modal.php") ?>
<?php $this->load->view("sda/form_sektor/js.php") ?>