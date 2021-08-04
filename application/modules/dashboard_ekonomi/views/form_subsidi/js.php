<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<!-- optional -->
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>


<script type="text/javascript">
    var site = '<?php echo site_url(); ?>';
    var year = new Date().getFullYear();
    var idSubsidi = '';

    $(document).ready(function() {

        idSubsidi = $('#id_subsidi').val();

        renderChart(year, idSubsidi);
    });




    $('#btnDetail').datepicker({
        "setDate": new Date(),
        "autoclose": true,
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        startDate: '-5y',
        endDate: '+1y'
    }).on('changeDate', function(ev) {
        currDate = ev.format();
        $('#btnDetail').html(currDate);
        year = currDate;
        renderChart(year, idSubsidi);
    });

    $(document).on('change', 'select[name="id_subsidi"]', function(e) {
        idSubsidi = $(this).val();
        renderChart(year, idSubsidi);
    });


    function renderChart(year) {

        $('#container').empty();

        $.ajax({
            url: site + '/api/subsidi/data/' + year + '/' + idSubsidi,
            type: "GET",
            success: function(data) {
                console.log(data);

                var container = document.getElementById('container');

                if (data.length === 0) {
                    $('#container').append(`<div class="col-xs-12 col-sm-12"> 
                                <div class="panel">
                                        <p>No Data Available</p>
                                </div> 
                            </div>`);
                } else {

                    $.each(data.dataseries, function(key, item) {



                        $.each(item, function(ikey, subitem) {

                            var dataseries = [];
                            var chartTitle = '';

                            chartTitle = key + '-' + ikey;
                            $('#container').append(`<div class="col-xs-12 col-sm-12"> 
                                <div class="panel">
                                    <div class="panel-body collapse in" >
                                        <div id="${chartTitle}" > </div> 
                                    </div> 
                                </div> 
                            </div>`);

                            $.each(subitem, function(jkey, jitem) {
                                dataseries.push({
                                    'data': jitem,
                                    'name': jkey
                                });

                            });

                            console.log(dataseries);


                            const chart = Highcharts.chart(chartTitle, {
                                chart: {
                                    type: 'bar'
                                },
                                title: {
                                    text: chartTitle
                                },
                                xAxis: {
                                    categories: data.categories
                                },
                                yAxis: {
                                    title: {
                                        text: 'Total Subsidi'
                                    }
                                },
                                exporting: {
                                    enabled: true
                                },
                                series: dataseries,
                            });


                        });



                    });

                }




            },
        });
    }
</script>