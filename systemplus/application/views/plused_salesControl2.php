<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vision - Plus-Ed</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>css/NA_style.css" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
    .panel-title{
        font-size:12px;
    }
</style>
<script type="text/javascript">
var arraycontabkgs = new Array();
</script>
</head>
<body style="background-color:transparent;margin-top:20px;">
<div class="container-fluid">
    <ul class="nav nav-pills" role="tablist">
        <li role="presentation" class="active"><a href="#london" data-toggle="pill"><span class="glyphicon glyphicon-calendar"></span> Sales on London Campus from 12/07/2015 to 12/08/2015</a></li>
		<li role="presentation"><a href="#usa" data-toggle="pill"><span class="glyphicon glyphicon-calendar"></span> Sales on USA Campus from 12/07/2015 to 12/08/2015</a></li>
    </ul>
    <div class="tab-content" style="margin-top:10px;">
        <div class="tab-pane fade in active" id="london">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-12">
							<div id="containerLondon" style="width: 90%; height: 500px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="usa">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-12">
							<div id="containerUsa" style="width: 90%; height: 500px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>		
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script>
$(function () {
    $('#containerLondon').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Sales'
        },
        xAxis: {
            categories: ['London Camden', 'London Chatham', 'London Greenwich', 'London Roehampton', 'London Tooting', 'London Twickenham']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Students/Nights'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -70,
            verticalAlign: 'top',
            y: 20,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black, 0 0 3px black'
                    }
                }
            }
        },
        series: [{
			color: '#ff9966',
            name: 'Elapsed',
            data: [22, 14, 14, 17, 12, 26],
			stack:0,
			pointPadding: 0
        }, {
			color: '#6699ff',
            name: 'To Be Confirmed',
            data: [12, 12, 13, 12, 11, 8],
			stack:0,
			pointPadding: 0
        }, {
			color: '#ffff99',
            name: 'Active',
            data: [33, 34, 34, 32, 35, 41],
			stack:0,
			pointPadding: 0
        }, {
			color: '#99cc99',		
            name: 'Confirmed',
            data: [83, 74, 94, 102, 85, 75],
			stack:0,
			pointPadding: 0
        }]
    });
	
$('#containerUsa').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Sales'
        },
        xAxis: {
            categories: ['Boston', 'Miami', 'New York Felician', 'New York Rider', 'San Francisco']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Students/Nights'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -70,
            verticalAlign: 'top',
            y: 20,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black, 0 0 3px black'
                    }
                }
            }
        },
        series: [{
			color: '#ff9966',
            name: 'Elapsed',
            data: [14, 14, 12, 12, 26],
			stack:0,
			pointPadding: 0
        }, {
			color: '#6699ff',
            name: 'To Be Confirmed',
            data: [8, 12, 12, 5, 8],
			stack:0,
			pointPadding: 0
        }, {
			color: '#ffff99',
            name: 'Active',
            data: [31, 34, 34, 32, 41],
			stack:0,
			pointPadding: 0
        }, {
			color: '#99cc99',		
            name: 'Confirmed',
            data: [84, 64, 94, 85, 55],
			stack:0,
			pointPadding: 0
        },{
			color: '#ff0000',
            name: 'Committment',
            data: [148,135,130,155,140],
			stack:1,
			pointPadding: 0.5,
			pointPlacement: -0.2,
			dataLabels:{enabled:false}
        }]
    });	
	
});
</script>
</body>
</html>