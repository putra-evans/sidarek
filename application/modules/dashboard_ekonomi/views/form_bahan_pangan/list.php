<div class="container">
    <div class="row" id="formParent">
        <div class="col-xs-12 col-sm-12">
            <?php echo $this->session->flashdata('message'); ?>
            <div id="errSuccess"></div>
        </div>

        <div class="col-xs-12 col-sm-12">
            <button class="btn btn-default" aria-controls="mainTbl" type="button" title="btnDetail" style="margin-right:10px; margin-bottom:20px;" id="btnDetail"><span>2021</span></button>
        </div>


        <div id="container"></div>

    </div>
</div><!-- container -->

<?php $this->load->view("dashboard_ekonomi/form_bahan_pangan/modal.php") ?>
<?php $this->load->view("dashboard_ekonomi/form_bahan_pangan/js.php") ?>