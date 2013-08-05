<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
 

<title>Using Highcharts with PHP and MySQL</title>

<script type="text/javascript" src="js/jquery-1.7.1.min.js" ></script>
<script type="text/javascript" src="js/highcharts.js" ></script>

<script type="text/javascript">
	var chart;
			$(document).ready(function() {
				var options = {
					chart: {
						renderTo: 'demo',
						defaultSeriesType: 'line',
						marginRight: 130,
						marginBottom: 25
					},
					title: {
						text: 'Hourly Visits',
						x: -20 //center
					},
					subtitle: {
						text: '',
						x: -20
					},
					xAxis: {
						type: 'datetime',
						tickInterval: 3600 * 1000, // one hour
						tickWidth: 0,
						gridLineWidth: 1,
						labels: {
							align: 'center',
							x: -3,
							y: 20,
							formatter: function() {
								return Highcharts.dateFormat('%l%p', this.value);
							}
						}
					},
					yAxis: {
						title: {
							text: 'Visits'
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#808080'
						}]
					},
					tooltip: {
						formatter: function() {
				                return Highcharts.dateFormat('%l%p', this.x-(1000*3600)) +'-'+ Highcharts.dateFormat('%l%p', this.x) +': <b>'+ this.y + '</b>';
						}
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'top',
						x: -10,
						y: 100,
						borderWidth: 0
					},
					series: [{
						name: 'Count'
					}]
				}
				// Load data asynchronously using jQuery. On success, add the data
				// to the options and initiate the chart.
				// This data is obtained by exporting a GA custom report to TSV.
				// http://api.jquery.com/jQuery.get/
				jQuery.get('data.php', null, function(tsv) {
					var lines = [];
					traffic = [];
					sales = [];
					try {
						// split the data return into lines and parse them
						tsv = tsv.split(/\n/g);
						jQuery.each(tsv, function(i, line) {
							line = line.split(/\t/);
							date = Date.parse(line[0] +' UTC');
							traffic.push([
								date,
								parseInt(line[1].replace(',', ''), 10)
							]);
							sales.push([
								date,
								parseInt(line[2].replace(',', ''), 10)
						]);
						});
					} catch (e) {  }
					options.series[0].data = traffic;
					options.series[0].data = sales;
					chart = new Highcharts.Chart(options);
				});
			});
</script>

<script type="text/javascript">
jQuery(function($) {
    var options = {
        chart: {renderTo: 'container', defaultSeriesType:'column', height: 400},
        title: {text: 'Sales Performance'},
        xAxis: {title: {text: 'Sales Peoples'}, type: 'linear'},
        yAxis: {title: {text: 'Dollars'}, plotLines: [{ value: 0, width: 1, color: '#808080'}]},
        tooltip: {
            formatter: function() {
                return '<b>'+ this.series.name +'</b><br/>'+'('+this.x +' : '+ this.y +')';
            }
        },
        legend: {layout: 'vertical', align: 'left', verticalAlign: 'top', x: 40, y: 100,   borderWidth: 0, width: 300 },
        series: []
    };

    jQuery.get('data.php', null, function(tsv) {
        var data = {};
        tsv = tsv.split(/\n/g); // split into rows
        for (var row=0, rows=tsv.length; row<rows; row++) {
            var line = tsv[row].split(/\t/g), // split into columns
                series_name = line[0],
                x = Number(line[1]),
                y = Number(line[2]);
            if (!data[series_name]) data[series_name] = [];
            data[series_name].push([x,y]);
            //alert("The data is: "+series_name)
        }
        for (var series_name in data) {
            options.series.push({
                name: series_name,
                data: data[series_name]
            });
        }
        new Highcharts.Chart(options);
    });

});
</script>

<script type="text/javascript">
$(document).ready(function() {
    var options = {
        chart: {
            renderTo: 'pie',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Web Sales & Marketing Efforts'
        },
        tooltip: {
            formatter: function() {
                return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function() {
                        return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: []
        }]
    }
    
    $.getJSON("data2.php", function(json) {
        options.series[0].data = json;
        chart = new Highcharts.Chart(options);
    });

});   
</script>
<script type="text/javascript">
$(document).ready(function() {
    var options = {
        chart: {
            renderTo: 'area',
            type: 'area',
            marginRight: 130,
            marginBottom: 25
        },
        title: {
            text: 'Project Requests',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            title: {
                text: 'Requests'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                    this.x +': '+ this.y;
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -10,
            y: 100,
            borderWidth: 0
        },
        plotOptions: {
            area: {
                stacking: 'normal',
                lineColor: '#666666',
                lineWidth: 1,
                marker: {
                    lineWidth: 1,
                    lineColor: '#666666'
                }
            }
        },
        series: []
    }
    
    $.getJSON("data3.php", function(json) {
    options.xAxis.categories = json[0]['data'];
        options.series[0] = json[1];
        options.series[1] = json[2];
        options.series[2] = json[3];
        chart = new Highcharts.Chart(options);
    });
});
</script>
</head>
<body>

<div id="demo" style="width: 100%; height: 100%; margin: 0 auto"></div>

<div id="container" style="width: 100%; height: 100%; margin: 0 auto"></div>

<div id="pie" style="width: 100%; height: 100%; margin: 0 auto"></div>	

<div id="area" style="width: 100%; height: 100%; margin: 0 auto"></div>					

</body>
</html>