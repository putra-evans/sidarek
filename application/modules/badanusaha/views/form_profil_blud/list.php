<style>
    .btn-belt {
        color: #212529;
        background-color: transparent;
        border-color: #212529;
        box-shadow: none;
        margin-bottom: 10px;
        border: 1px solid;
        border-radius: 5px;
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
                    <h4>Daftar Profil BLUD</h4>
                </div>
                <div class="panel-body collapse in">
                    <div class="clearfix">
                        <div class="pull-left form-group clearfix">
                            <button type="button" class="btn btn-primary" id="btnAdd"><b><i class="fa fa-plus"></i> Tambah Produk</b></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered table-striped" id="profiltbl" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="20%">Nama</th>
                                    <th width="25%">Alamat / Telp / Email</th>
                                    <th>Tahun</th>
                                    <th width="20%">Bidang Usaha</th>
                                    <th>Modal Dasar</th>
                                    <th>Informasi Lanjut</th>
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

<?php $this->load->view("badanusaha/form_profil_blud/modal.php") ?>
<?php $this->load->view("badanusaha/form_profil_blud/js.php") ?>