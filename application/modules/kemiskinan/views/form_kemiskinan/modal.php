<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="judul-form"> </span>DATA KEMISKINAN</b></h4>
            </div>
            <?php echo form_open_multipart(site_url('kemiskinan/kemiskinan/create'), array('id' => 'formEntry')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>
                <div class="row">
                    <input type="hidden" name="id_kemiskinan" id="id_kemiskinan">

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="daerah" class="control-label"><b>Daerah <font color="red">*</font></b></label>
                            <?php echo form_dropdown('daerah', array('' => '-- Pilih Daerah --', 'Perkotaan' => 'Perkotaan', 'Desa' => 'Desa'), $this->input->post('daerah'), 'class="select-all" id="daerah"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="nomor" class="control-label"><b>Bulan/Tahun <font color="red">*</font></b></label>
                            <div class="input-group date monday_date_datepicker" data-provide="datepicker" id="monday_date_datepicker">
                                <input type="text" id="add_monday_date" name="monday_date" class="form-control" data-date-format="yyyy-mm-dd" readonly>
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="jumlah_pdd" class="control-label"><b>Jumlah Penduduk (orang)<font color="red">*</font></b></label>
                            <input min="0" type="number" class="form-control" name="jumlah_pdd" id="jumlah_pdd" placeholder="Jumlah Penduduk">
                            <div class="help-block"></div>
                        </div>
                    </div>

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


<!-- <div class="modal fade in" id="modalKomoditi" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 15px 10px 15px;">
                <button type="button" class="close btnCloseKomoditi" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><b><span id="judul-form-komoditi"> </span>KOMODITI</b></h4>
            </div>
            <?php echo form_open_multipart(site_url('sda/komoditi/create'), array('id' => 'formKomoditi')); ?>
            <div class="modal-body" style="padding:15px 15px 5px 15px;">
                <div id="errEntry"></div>
                <div class="row">
                    <input type="hidden" name="id_komoditi" id="id_komoditi">

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="id_sektor_for_komoditi" class="control-label"><b>Sektor Sumber Daya Alam <font color="red">*</font></b></label>
                            <?php echo form_dropdown('id_sektor_for_komoditi', array('' => '-- Pilih Sektor --'), $this->input->post('id_sektor_for_komoditi'), 'class="select-all" id="id_sektor_for_komoditi"'); ?>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group required">
                            <label for="nama_komoditi" class="control-label"><b>Nama Komoditi <font color="red">*</font></b></label>
                            <input type="text" class="form-control" name="nama_komoditi" id="nama_komoditi" placeholder="Nama Komoditi">
                            <div class="help-block"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer" style="margin-top:0px;padding:10px 15px 15px 0px;">
                <button type="button" class="btn btn-default btnCloseKomoditi" style="padding:12px 16px;"><i class="fa fa-times"></i> CANCEL</button>
                <button type="submit" class="btn btn-primary" name="save" id="save" style="padding:12px 16px;"><i class="fa fa-check"></i> SUBMIT</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div> -->

<!-- /.modal -->