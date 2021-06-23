<script src="https://code.highcharts.com/highcharts.js"></script>


<script type="text/javascript">
    $('#selectize-dropdown').selectize({
        create: true,
        sortField: 'text'
    });

    document.addEventListener('DOMContentLoaded', function() {
        const chart = Highcharts.chart('container', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Inflasi Tahun 2020'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Persen Inflasi'
                }
            },
            series: [{
                name: '%yoy',
                data: [0.55, 0.50, 0.23, 0.55, 0.50, 0.23, 0.55, 0.50, 0.23, 0.55, 0.50, 0.23]
            }, {
                name: '%mom',
                data: [-0.12, 0.21, 0.12, -0.23, 0.11, 0.36, -0.13, -0.33, -0.27, -0.15, 0.17, 0.30]
            }, {
                name: '%dot',
                data: [0.34, 0.54, 0.23, 0.65, 0.50, 0.45, 0.48, 0.40, 0.39, 0.45, 0.37, 0.13]
            }]
        });
    });
</script>