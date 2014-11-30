$(document).ready(function () {
  $.get(window.location.origin + '/WebArena/Apis/barchart', function (data) {
    var datajson = $.parseJSON(data);
    var xp = [];
    var ticks = [];
    $.each(datajson, function (key,val) {
      xp.push(parseInt(val.Fighter.xp));
      ticks.push(val.Fighter.name);
    });

    var plot1 = $.jqplot ('chart1', [xp],
    {
      title: "5 Most Experienced Players",
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.BarRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          fillToZero: true
        }
      },
      axes: {
        xaxis: {
          renderer: $.jqplot.CategoryAxisRenderer,
          ticks: ticks
        }
      }
    });
  });

  $.get(window.location.origin + '/WebArena/Apis/piechart', function (data) {
    var datajson = $.parseJSON(data);
    var piedata = [['Health', parseInt(datajson[0].Fighter.skill_health)], ['Sight', parseInt(datajson[0].Fighter.skill_sight)], ['Strength', parseInt(datajson[0].Fighter.skill_strength)]];
    var plot2 = $.jqplot('chart2', [piedata], {
      title: "Most Experienced Player Statistics",
      seriesDefaults: {
        renderer: jQuery.jqplot.PieRenderer,
        rendererOptions: {
          showDataLabels: true
        }
      },
      legend: {
        show: true,
        location: 'e'
      }
    });
  });

  $.get(window.location.origin + '/WebArena/Apis/monthlyevents', function (data) {
    var datajson = $.parseJSON(data);
    var linedata2 = [];
    var d= new Date();
    d.setMonth(d.getMonth()-1);
    d.setHours(0,0,0,0)

    for (var i = datajson.length - 1; i >= 0; i--) {
      var tmp=[];
      tmp.push(datajson[i][0].date + ' 0:00');
      tmp.push(parseInt(datajson[i][0].nbevents));
      linedata2.push(tmp);
    };

    var plot3 = $.jqplot('chart3', [linedata2], {
      title: "Number of Events this Month",
      axes: {
        xaxis: {
          renderer: $.jqplot.DateAxisRenderer,
          tickOptions: {formatString:'%b %#d'},
          min:d,
          tickInterval: '1 day'
        }
      },
      series: [{
        markerOptions:{style:'square'}
      }]
    });
  });

  $.get(window.location.origin + '/WebArena/Apis/membersinguilds', function (data) {
    var datajson = $.parseJSON(data);
    var members = [];
    var guilds = [];
    $.each(datajson, function (key,val) {
      members.push(parseInt(val[0].members));
      guilds.push(val.Guild.name);
    });

    var plot1 = $.jqplot ('chart4', [members],
    {
      title: 'Top 5 Guilds',
      seriesDefaults: {
        renderer: jQuery.jqplot.BarRenderer,
        rendererOptions: {
          barWidth: 50,
          fillToZero: true
        }
      },
      axes: {
        xaxis: {
          renderer: $.jqplot.CategoryAxisRenderer,
          ticks: guilds
        }
      }
    });
  });
});