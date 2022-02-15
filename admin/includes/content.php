<!-- Content Row -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Views',     <?= $session->visitor_count(); ?>],
            ['Users',     <?= User::count_all(); ?>],
            ['Comments',       <?= Comment::count_all(); ?>],
            ['Photos',  <?= Photo::count_all(); ?>]

        ]);

        var options = {
            legend: 'none',
            title: 'Data',
            pieSliceText: 'label',
            backgroundColor: 'transparent'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
           <div class="mx-auto" id="piechart" style="width:500px; height:500px;"></div>

        </div>
    </div>
</div>
<div>
    <?php
        echo $session->visitor_count();
    ?>

</div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->