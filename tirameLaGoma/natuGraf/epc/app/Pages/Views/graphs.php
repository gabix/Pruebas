<?php
var_dump($monthly_expenses);die;
?>    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Days');
        data.addColumn('number', 'Expenses');
        data.addColumn('number', 'Poverty line');
        data.addRows(4);
        data.setValue(0, 0, '2004');
        data.setValue(0, 1, 1000);
        data.setValue(0, 2, 400);
        data.setValue(1, 0, '2005');
        data.setValue(1, 1, 1170);
        data.setValue(1, 2, 460);
        data.setValue(2, 0, '2006');
        data.setValue(2, 1, 860);
        data.setValue(2, 2, 580);
        data.setValue(3, 0, '2007');
        data.setValue(3, 1, 1030);
        data.setValue(3, 2, 540);

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, {width: $('#chart_div').width(), height: $(window).height()*0.5, title: 'Company Performance'});
      }
    </script>
<nav>
<?php echo View::compose('components/global/navigation',array('is_logged_in'=>$is_logged_in))?>
</nav>
<article>
    <h1>Expenses tracker v0.0.2</h1>
    <section>
      <div id="chart_div"></div>
    </section>
</article>
