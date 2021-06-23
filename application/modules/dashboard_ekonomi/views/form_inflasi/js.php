<script src="https://code.highcharts.com/highcharts.js"></script>


<script type="text/javascript">
    var site = '<?php echo site_url(); ?>';
    var year = new Date().getFullYear();

    $(document).ready(function() {

        renderChart(year);
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
        renderChart(year);
    });


    function renderChart(year) {

        $('#container').empty();

        $.ajax({
            url: site + '/api/inflasi/data/' + year,
            type: "GET",
            success: function(data) {
                //(data);

                var container = document.getElementById('container');

                if (data.length === 0) {
                    $('#container').append(`<div class="col-xs-12 col-sm-12"> 
                                <div class="panel">
                                        <p>No Data Available</p>
                                </div> 
                            </div>`);
                } else {

                    $.each(data, function(key, item) {

                        $('#container').append(`<div class="col-xs-12 col-sm-12"> 
                                <div class="panel">
                                    <div class="panel-body collapse in" >
                                        <div id="${key}"> </div> 
                                    </div> 
                                </div> 
                            </div>`);

                        var dataseries = [];

                        $.each(item, function(ikey, value) {

                            dataseries.push({
                                'data': value,
                                'name': ikey
                            });
                        });

                        //(dataseries);


                        const chart = Highcharts.chart(key, {
                            chart: {
                                type: 'line'
                            },
                            title: {
                                text: `${key}`
                            },
                            xAxis: {
                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                            },
                            yAxis: {
                                title: {
                                    text: 'Persen Inflasi'
                                }
                            },
                            series: dataseries,
                        });

                    });
                }




            },
        });
    }
</script>