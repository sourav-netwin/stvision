<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8"/>
	<title>Dashboard I Admin Panel</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin_layout.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/overlay-apple.css" type="text/css" media="screen" />
        <style>

                /* use a semi-transparent image for the overlay */
                #overlay {
                        background-image:url(../../images/transparent.png);
                        color:#FFFFFF;
                        /*height:450px;*/
                }
                div.contentWrap {
                    height:500px;
                    overflow-y:auto;
                    
                                    }
	</style>
        <!--[if lt IE 9]>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin_ie.css" type="text/css" media="screen" />
	<![endif]-->
        <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js" type="text/javascript"></script-->
	<script src="http://cdn.jquerytools.org/1.2.5/full/jquery.tools.min.js"></script>
	<script src="<?php echo base_url(); ?>js/hideshow.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.equalHeight.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ts_picker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/onBeforeLoad.js"></script>
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
			<h1 class="site_title"><a href="index.html">Website Admin</a></h1>
			<h2 class="section_title">Dashboard</h2><div class="btn_view_site"><a href="http://www.medialoot.com">View Site</a></div>
		</hgroup>
	</header> <!-- end of header bar -->