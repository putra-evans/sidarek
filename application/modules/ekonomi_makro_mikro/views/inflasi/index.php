<div class="page-title">
    <h4><?php echo $page_name; ?></h4>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-2">
                        <select id="selectize-dropdown">
                            <option value="" disabled selected>Select Year...</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="container" style="width:100%; height:400px;"></div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view("ekonomi_makro_mikro/inflasi/js.php") ?>