<html>
<head>
<title><?=$title?></title>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" /> 
<style type="text/css">

h5{
	font-family: Tahoma, sans-serif;
	margin:9px 0 0 0;
	font-size: 10px;
	color: #999;

}
.small{
	font-size: 9px;
	color: #999;
}
form {
		
	font-size: 12px;
	background:#EBF0F5; 
	color: #002166;
	display: block;
	padding:0 0 0 10px;
}

input {
	margin:0 0 10px 0;
	border:1px solid #ccc;
	background-color:#f5f5f5;
}
.location {
 display:block;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 9px;
 color: #3d7db5;
 margin:0 0 0 16px;
 list-style-type:square ;
}

</style>
</head>
<body>
<center>
<div id="main">
<div id="container">
		<img src="<?php echo base_url(); ?>images/up_job.jpg"/>
		<div id="menu_up">
			
		</div>

		
		<div id="left">
		</div>
		
		<div id="middle">		
		<h1 class="blu">Application Form</h1>
			<?php echo $this->validation->error_string; 
				  $idsegment="cms/updatepdf/" . $this->uri->segment(3);
				  
			?>
			
			<?php echo form_open_multipart($idsegment); ?>

			<input type="hidden" name="idannuncio" value="<? echo $this->uri->segment(3) ?>" />
			<br/>
			
			
			<h5>Please upload an up-to-date CV (.pdf max or .doc 500Kb)</h5>
			<input type="file" name="cvfile" size="20" />
			<h5>Please upload your degree certificate Browse (.pdf or .doc max 500Kb)</h5>
			<input type="file" name="userfile" size="20" />
			
			
			<div><input type="submit" value="Submit" /></div>
			

			</form>
			<h5 class="red"><a href="<?php echo base_url(); ?>index.php/cms">Come Back to panel</h5><br/>
</div>	
	<div id="right">
				
	</div>
		
	
</div>
</center>

</body>
