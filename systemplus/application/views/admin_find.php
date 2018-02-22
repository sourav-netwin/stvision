<html>
<head>
<title><?=$title;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 

<style type="text/css">

#header { display:block; margin:0 auto; }

#menu_up {margin:0 0 10px 0;; padding:6px 0 6px 0; width:1000px; text-align:center; background-color:#e5ebf0}
#menu_up a{margin:16px; padding: 8px 0 0px 0; text-decoration: none;  font-size:13px;}
#menu_up a:hover{color:#cc9;}
/* -- CONTENITORI ----------------------*/

#main			{ display:block; margin: 10px 0 0 0; width:1000px; text-align:center; background-color:fff}
html>body #main { display:block; margin: 10px 0 0 0; width:1000px  text-align:center; background-color:fff}

#container			 { display:block; float:left; margin: 0 ;   width:1000px; background-color:#fff;}
html>body #container { display:block; float:left; margin: 0 auto;   width:1000px; background-color:#fff; }

h5{
	font-family: Lucida Grande, Verdana, Sans-serif;
	margin:10px 10px 10px 0;
	font-size: 11px;
	color: #aaa57c;

}
td {
	width:80px;
	background-color:#eee;
	padding:6px;
}
table{
	margin:10px;
}
.block_brown{
	margin:10px 0 4px 0;
	padding:10px; 
	border:2px solid #d5d1af; 
	background:#EBF0CC; 
	color: #aaa57c;
}
.blue{
	background-color:#9c9;
	color:#fff;
	padding:10px;
}

input, select{
	margin:4px;
}
hr.gray {
	margin:4px 0 4px 0;color:#fff; background-color:#fff; border: 1px dotted #ccc; border-style: none none dotted;
}
.desc_left{
	display:block; 
	float:left; 
	margin:10px 0 0 10px; 
	padding:4px; 
	width:180px; 
	text-align:left;
}
.input_find{
	display:block; 
	margin:10px; 
	text-align:left;
}
</style>

</head>
<body>
<center>
<div id="main">
<div id="container">
		
		<div id="menu_up">
			<?php	echo anchor("cms/","Home");  ?>

		</div>

	<div style="width:800px; background-color:#fff;">
		<div class="desc_left">Select Status</div>
		<div class="input_find">
		<?php
			echo form_open("cms/filter");
				
				  $options = array(
				  ''=>'',
                  'unread'=> 'unread',
                  'interesting'=> 'interesting',
				  'interview'=> 'interview',
				  'notofinterest'=> 'not of interest',
				  'underreview'=> 'under review',
				  'sentcontract'=> 'sent contract', 
				  'employed'=> 'employed'
                );

			echo form_dropdown('status', $options);
			?>
			</div>
			
			<hr class="gray">
			<div class="desc_left">Select Centre</div>
			<div  class="input_find">
			<?
				  $options = array(
                  ''=>'',
				  'BATH'=>'BATH',
                  'BEDFORD'=>'BEDFORD',
				  'CAMBRIDGE'=>'CAMBRIDGE',
				  'CANTERBURY'=>'CANTERBURY',
				  'CHATHAM'=>'CHATHAM',
				  'CHELMSFORD'=>'CHELMSFORD',
				  'CHELTENHAM'=>'CHELTENHAM',
				  'CHESTER'=>'CHESTER',
				  'EDINBURGH'=>'EDINBURGH',
				  'LEICESTER'=>'LEICESTER',
				  'LONDON GREENWICH'=>'LONDON GREENWICH',
				  'LONDON DOCKLANDS'=>'LONDON DOCKLANDS',
				  'LONDON ROEHAMPTON'=>'LONDON ROEHAMPTON',
				  'LOUGHBOROUGH'=>'LOUGHBOROUGH',
				  'MAYNOOTH'=>'MAYNOOTH',
				  'NORWICH'=>'NORWICH',
				  'PLYMOUTH'=>'PLYMOUTH',
				  'PORTSMOUTH'=>'PORTSMOUTH',
				  'SHEFFIELD'=>'SHEFFIELD',
				  'STANDREWS'=>'ST. ANDREWS',
				  'DUBLIN'=>'DUBLIN',
				  'GALWAY'=>'GALWAY'
                );

			echo form_dropdown('preferredcentre', $options, 'choose');
			?>
			</div>

			<hr class="gray">
			<div class="desc_left">Select Position</div>
			<div  class="input_find">
		<?
				  $options = array(
                  ''=>'',
                  'Activity Leader'=>'Activity Leader',
				  'Airport Co-ordinator'=>'Airport Co-ordinator',
				  'Campus Manager'=>'Campus Manager',
				  'Choreographer'=>'Choreographer',
				  'Course Director'=>'Course Director',
				  'Assistant Course Director'=>'Assistant Course Director',
				  'Sport Leader'=>'Sport Leader',
				  'Teacher'=>'Teacher'

                );
			
			echo form_dropdown('preferredposition', $options, 'choose');
			?>
			</div>
			<hr class="gray">
			<div class="desc_left">Select Date (yyyy-mm-dd)</div>
			<div  class="input_find">
		
				  <input type="text" name="datainsert" value="" size="25" />
              
			</div>
			<hr class="gray">
			<div class="desc_left">Available for summer work from (Month)</div>
			<div  class="input_find">
			<?
				  $options = array(
                  ''=> '',
				  '1'=> '1',
                  '2'=> '2',
				  '3'=> '3',
				  '4'=> '4',
				  '5'=> '5',
				  '6'=> '6',
				  '7'=> '7',
				  '8'=> '8',
				  '9'=> '9',
				  '10'=> '10',
				  '11'=> '11',
				  '12'=> '12'
                );

			echo form_dropdown('monthworkfrom', $options);
			?>
			</div>
			<hr class="gray">
			<div class="desc_left">Require accomodation</div>
			<div  class="input_find">
			<?
				  $options = array(
                  ''=>'',
				  'yes'=>'Yes',
                  'no'=>'No'
                );

			echo form_dropdown('accomodationcentre', $options);
			?>
			</div>
			<hr class="gray">
			<div class="desc_left">worked for PLUS before</div>
			<div  class="input_find">
			<?
				  $options = array(
                   ''=>'',
				  'yes'=>'Yes',
                  'no'=>'No'
                );

			echo form_dropdown('workplusbefore', $options);
			?>
			</div>
			<hr class="gray">
			<div class="desc_left">Town</div>
			<div  class="input_find">
				<input type="text" name="towncity" value="" size="25" />
			</div>
			<div class="desc_left">Surname</div>
			<div  class="input_find">
				<input type="text" name="surname" value="" size="25" />
			</div>
			<hr class="gray">

			<?
			echo "<br/>" . form_submit('submit','Search');
			echo form_close();
			?>
		<div class="error"><?=$info?></div>
	</div>		
	</div>
	<div id="footer_job">Cms Plus-ed</div>
</div>
</center>
</body>