<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

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
</head>
<body style="background-color:transparent;">
<div class="container-fluid">
    <ul class="nav nav-pills" role="tablist">
        <li role="presentation" class="active"><a href="#z"><span class="glyphicon glyphicon-pencil"></span> Enrol</a></li>
		<li role="presentation" class="disabled"><a href="#"><span class="glyphicon glyphicon-search"></span> Booking details</a></li>
        <li role="presentation" class="disabled"><a href="#"><span class="glyphicon glyphicon-user"></span> Booking roster</a></li>
        <li role="presentation" class="disabled"><a href="#"><span class="glyphicon glyphicon-random"></span> Transfer and excursions</a></li>
        <li role="presentation" class="disabled"><a href="#"><span class="glyphicon glyphicon-calendar"></span> Calendar view</a></li>
        <li role="presentation" class="disabled"><a href="#"><span class="glyphicon glyphicon-inbox"></span> Uploaded documents</a></li>
    </ul>
	<?php
		$da=explode("-",$book[0]["arrival_date"]);
		$dd=explode("-",$book[0]["departure_date"]);
		$accos=$book[0]["all_acco"];
	?>
    <div class="tab-content" style="margin-top:10px;">
        <div class="tab-pane fade in active" id="z">
            <div class="panel panel-primary">
                <div class="panel-body">
					<div class="row">
						<div class="col-md-4">
							<address>
							  <strong><?php echo $book[0]["id_year"] ?>_<?php echo $book[0]["id_book"] ?></strong><br>
							  <?php echo $book[0]["centro"] ?><br>
							  <strong>Date in: </strong><?php echo $da[2]?>/<?php echo $da[1]?>/<?php echo $da[0]?><br>
							  <strong>Date out: </strong><?php echo $dd[2]?>/<?php echo $dd[1]?>/<?php echo $dd[0]?><br>
							  <abbr title="Phone">P:</abbr> <?php echo $agente[0]["businesstelephone"] ?>
							</address>
						</div>					
						<div class="col-md-4">
							<address>
							  <strong><img style="margin-top:-1px;" class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $agente[0]["businesscountry"]?>.png" alt="<?php echo $agente[0]["businesscountry"]?>" title="<?php echo $agente[0]["businesscountry"]?>" /><?php echo $agente[0]["businessname"] ?></strong><br>
							  <?php echo $agente[0]["businessaddress"] ?><br>
							  <?php echo $agente[0]["businesscity"] ?>, <?php echo $agente[0]["businesscountry"] ?><br>
							  <abbr title="Phone">P:</abbr> <?php echo $agente[0]["businesstelephone"] ?>
							</address>
						</div>
						<div class="col-md-4">
							<address>
							  <strong><?php echo $agente[0]["mainfirstname"] ?> <?php echo $agente[0]["mainfamilyname"] ?></strong><br>
							  <a href="mailto:<?php echo $agente[0]["email"] ?>"><?php echo $agente[0]["email"] ?></a>
							</address>
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
<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
		$('#backToList').click(function(){
			parent.history.back();
			return false;
		});
	});
</script>
</body>
</html>