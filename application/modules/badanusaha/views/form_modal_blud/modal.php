<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="judul-form"> </span>PENYERTAAN MODAL</b></h4>
            </div>
            <?php echo form_open_multipart(site_url('sda/sektor/create'), array('id' => 'formEntry')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="id_profil_bu" class="control-label"><b>Bidang Usaha <font color="red">*</font></b></label>
                            <?php echo form_dropdown('id_profil_bu', $profil_bus, isset($id_profil_bu) ? $id_profil_bu : null , 'class="select-all" id="id_profil_bu"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="tahun" class="control-label"><b>Tahun Penyertaan Modal <font color="red">*</font></b></label>
                            <?php echo form_dropdown('tahun', array('' => '-- Pilih Tahun --', 2020 => '2020', 2019 => '2019', 2018 => '2018', 2017 => '2017', 2016 => '2016'), $this->input->post('tahun'), 'class="select-all" id="tahun"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="penyertaan_modal" class="control-label"><b>Total Penyertaan Modal <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="penyertaan_modal" id="penyertaan_modal" placeholder="">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="dividen" class="control-label"><b>Dividen <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="dividen" id="dividen" placeholder="">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    

                    <div class="col-xs-12 col-sm-12 descBox"></div>  

                </div>


            </div>
            <div class="modal-footer" style="margin-top:0px;padding:10px 15px 15px 0px;">
                <button type="button" class="btn btn-default btnClose" style="padding:12px 16px;"><i class="fa fa-times"></i> CANCEL</button>
                <button type="submit" class="btn btn-primary" name="save" id="save" style="padding:12px 16px;"><i class="fa fa-check"></i> SUBMIT</button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade in" id="penyertaanmodal" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="tipe-penyertaanmodal"></span>&nbsp;<span id="badan-usaha-title"></span></b></h4>
            </div>
            <?php echo form_open_multipart(site_url('badanusaha/modal/create'), array('id' => 'formPenyertaanModal')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>
                <div class="row">
                    <input type="hidden" name="id_modal_pertahun" id="id_modal_pertahun">
                    <input type="hidden" name="id_komponen" id="id_komponen">
                    <input type="hidden" name="komponen" id="komponen">
                    <div class="col-xs-12 col-sm-12 boxKomponen"></div>

                </div>
            </div>
            <div class="modal-footer" style="margin-top:0px;padding:10px 15px 15px 0px;">
                <button type="button" class="btn btn-default btnClose" style="padding:12px 16px;"><i class="fa fa-times"></i> CANCEL</button>
                <button type="submit" class="btn btn-primary" name="save" id="save" style="padding:12px 16px;"><i class="fa fa-check"></i> SUBMIT</button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->