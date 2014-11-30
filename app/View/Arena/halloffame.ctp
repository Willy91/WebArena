<h1>Hall of Fame</h1>
<hr>
<div class="col-md-6">
    <div id="chart1"></div>
    <hr>
    <div id="chart2"></div>
</div>

<div class="col-md-6">
    <div id="chart3"></div>
    <hr>
    <div id="chart4"></div>
</div>

<?php echo $this->Html->script('jquery.jqplot.min.js');
    echo $this->Html->script('jqplot.pieRenderer.min.js');
    echo $this->Html->script('plugins/jqplot.barRenderer.min.js');
    echo $this->Html->script('plugins/jqplot.categoryAxisRenderer.min.js');
    echo $this->Html->script('plugins/jqplot.pointLabels.min.js');
    echo $this->Html->script('plugins/jqplot.dateAxisRenderer.min.js');
    echo $this->Html->script('charts');
?>