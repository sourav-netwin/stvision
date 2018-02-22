<html>
<head>
<title><?=$title?></title>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/ddlevelsfiles/ddlevelsmenu-base.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/ddlevelsfiles/ddlevelsmenu-topbar.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/ddlevelsfiles/ddlevelsmenu-sidebar.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>/css/ddlevelsfiles/ddlevelsmenu.js"></script>
<script type="text/javascript">
	ddlevelsmenu.setup("ddtopmenubar", "topbar");
</script>
<style type="text/css">

h5{
	font-family: Georgia, Times New Roman, Times, serif;
	margin:9px 0 0 0;
	

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

</style>
</head>
<body>
<center>
<div id="main">
<div id="container">
		<img src="<?php echo base_url(); ?>images/up_job.jpg"/>
		<div id="menu_up">
			<?php $this->load->view('menu_up');?>
			
		</div>

		
		<div id="left">
			<img src="<?php echo base_url(); ?>images/image001.jpg">
		</div>
		<div id="middle">		
		<h1 class="blu">Your form is successfully trasmitted!</h1>

	<?
		echo ("Thank you ");
		echo ($_POST['malefemale'] . "&nbsp;" . $_POST['nome'] . "<br/>");
		echo "your request is successfully trasmitted<br/>";
		echo "<br/><br/>";
		echo ($_POST['nome'] . "<br/>");
		echo ($_POST['cognome'] . "<br/>");
		echo ($_POST['indirizzo'] . "<br/>");
		echo ($_POST['phonenumber'] . "<br/>");
		echo ("<br/> <strong>email:</strong> " . $_POST['myemail'] . "<br/>");
		echo  "<br/><br/>";
		
		
	?>

<p>

<?php echo anchor('job', 'Back to Home'); ?></p>
</div>	
	<div id="right">
		<img  src="<?php echo base_url(); ?>images/image001_small.jpg">
		
	</div>
		
	<div id="footer">init</div>		
</div>
</center>

</body>
</html