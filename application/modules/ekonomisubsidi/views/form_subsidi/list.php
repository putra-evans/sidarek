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
                    <h4><?php echo $page_name; ?></h4>
                </div>
                <div class="panel-body collapse in">

                    <!-- <div class="clearfix">
                        <div class="pull-left form-group clearfix">
                            <button type="button" class="btn btn-primary" id="btnAdd"><b><i class="fa fa-plus"></i> Tambah Data</b></button>
                        </div>
                    </div> -->
                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered table-striped" id="mainTbl" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kategori</th>
                                    <th>Subsidi</th>
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

<?php $this->load->view("ekonomisubsidi/form_subsidi/modal.php") ?>
<?php $this->load->view("ekonomisubsidi/form_subsidi/js.php") ?>