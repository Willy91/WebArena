$(document).ready(function() { 
	$('#sight_table').DataTable(); 
	$('#guild_table').DataTable(); 
	$('#damier').DataTable({
		"paging":   false
	});
} );

$(document).ready(function(){
  
var island = document.getElementById('some-div').firstChild;
var the_data = eval('(' + island.data + ')');
alert(the_data.prop2);
    var data = [
    ['Heavy Industry', 12],['Retail', 9], ['Light Industry', 14],
    ['Out of home', 16],['Commuting', 7], ['Orientation', 9]
  ];
  var plot1 = jQuery.jqplot ('chart1', [data],
    {
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
      legend: { show:true, location: 'e' }
    }
  );
});
