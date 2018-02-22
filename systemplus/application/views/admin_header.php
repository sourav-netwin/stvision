<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Dashboard I Admin Panel</title>
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin_layout.css" type="text/css" media="screen" />
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin_ie.css" type="text/css" media="screen" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!--script src="<?php echo base_url(); ?>js/jquery-1.5.2.min.js" type="text/javascript"></script-->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
	<script src="<?php echo base_url(); ?>js/hideshow.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.equalHeight.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ts_picker.js"></script>
	<script type="text/javascript">
	$(document).ready(function() 
    	{ 
      	  $(".tablesorter").tablesorter(); 
   	 } 
	);
	$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});
    </script>
    <script type="text/javascript">
    $(function(){
        $('.column').equalHeight();
    });
</script>

</head>
<body>

	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="<?php echo base_url();?>index.php/payroll/">Website Admin</a></h1>
			<h2 class="section_title">Dashboard</h2><div class="btn_view_site"><a href="<?php echo base_url();?>index.php/payroll/">Home Site</a></div>
		</hgroup>
	</header> <!-- end of header bar -->
<section id="secondary_bar">
		<div class="user">
			
			<a class="logout_user" href="<?php echo base_url();?>index.php/payroll/logout" title="Logout">Logout</a>
		</div>
		<div class="breadcrumbs_container">
		</div>
	</section><!-- end of secondary bar -->
	
	<aside id="sidebar" class="column">
		<form class="quick_search">
			<input type="text" value="Quick Search" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;">
		</form>
		<hr/>
		<h3>Center</h3>
		<ul class="toggle">
			<li><a href="<?php echo base_url();?>index.php/payroll/">Home</a></li>
		</ul>
		<h3>Users</h3>
		<ul class="toggle">
			<li>Campus Manager</li>
		</ul>		<footer>
			<hr />
			<p><strong>Copyright &copy; 2012 Plus Educational</strong></p>
		</footer>
	</aside><!-- end of sidebar -->