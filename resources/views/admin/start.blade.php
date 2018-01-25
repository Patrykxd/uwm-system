@extends('admin')

@section('content')

<h1>zalogowany: <?= $name; ?></h1>
<style>
    .chart{
        position:relative;
        float:left;
        margin:10px;
    } 
</style>
<div id="piechart1" class="chart" style="width: 100%;"></div>
<div id="piechart" class=" chart" style="width: 45%;"></div>
<div id="chart_div" class=" chart" style="width: 45%;"></div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawChart1);
    google.charts.setOnLoadCallback(drawChart2);
    
    <?php $arrayChart = ''; ?>
    <?php foreach ($charts as $name => $value): ?>
        <?php $arrayChart .= "['$name'" . ',' . $value . "],"; ?>
    <?php endforeach; ?>
        
    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Nazwa', 'Wartość'],<?= $arrayChart; ?>
        ]);

        var options = {
            title: 'Ilość linków według znaczników rel (brak podzielony na 1000 dla czytelności)',
            width: '400px',
            height: '300px'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);

    }
    function drawChart1() {
        var data = google.visualization.arrayToDataTable([
            ['Nazwa', 'Wartość'],<?= $arrayChart; ?>
        ]);

        var options = {
            title: 'Ilość linków według znaczników rel',
            legend: {position: 'none'},
        };

        var chart = new google.visualization.Histogram(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

    function drawChart2() {
        var data = google.visualization.arrayToDataTable([
            ['Nazwa', 'Wartość'],
            ['Projektów', <?= $projects_count; ?>],
            ['Url', <?= $distinct_links_count; ?>],
            ['linków (dla czytelności podzielona na 100)', <?= $links_count; ?>],
        ]);

        var options = {
            title: 'Ogólne statystyi systemu',
            width: 800,
            legend: {position: 'none'},
            chart: {

                subtitle: 'popularity by percentage'},
            axes: {
                x: {
                    0: {side: 'top', label: 'White to move'} // Top x-axis.
                }
            },
            bar: {groupWidth: "90%"}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('piechart1'));

        chart.draw(data, options);
    }
</script>



@endsection