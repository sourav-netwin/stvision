<?php
/**
 * @modified_by Arunsankar S
 * @date : 07-04-2016
 */
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<link rel="dns-prefetch" href="http://fonts.googleapis.com" />
	<link rel="dns-prefetch" href="http://themes.googleusercontent.com" />
	<link rel="dns-prefetch" href="http://ajax.googleapis.com" />
	<link rel="dns-prefetch" href="http://cdnjs.cloudflare.com" />
	<link rel="dns-prefetch" href="http://agorbatchev.typepad.com" />
	<!-- Use the .htaccess and remove these lines to avoid edge case issues.
	   More info: h5bp.com/b/378 -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $title ?></title>
	<meta name="description" content="<?php echo $title ?>">
	<meta name="author" content="plus-ed.com">

	<!-- Mobile viewport optimized: h5bp.com/viewport -->
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!-- iPhone: Don't render numbers as call links -->
	<meta name="format-detection" content="telephone=no">

	<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
	<!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
	<!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->


	<!-- The Styles -->
	<!-- ---------- -->

	<!-- Layout Styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/grid.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/layout.css">

	<!-- Icon Styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/icons.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/fonts/font-awesome.css">
	<!--[if IE 8]><link rel="stylesheet" href="<?php echo base_url(); ?>css/fonts/font-awesome-ie7.css"><![endif]-->

	<!-- External Styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery-ui-1.8.21.custom.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery.chosen.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery.cleditor.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery.colorpicker.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery.elfinder.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery.fancybox.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery.jgrowl.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery.plupload.queue.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/syntaxhighlighter/shCore.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/syntaxhighlighter/shThemeDefault.css" />

	<!-- eventCalendar -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/calendar/eventCalendar.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/calendar/eventCalendar_theme_responsive.css">

	<!-- Elements -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/elements.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/forms.css">

	<!-- OPTIONAL: Print Stylesheet for Invoice -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/print-invoice.css">

	<!-- Typographics -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/typographics.css">

	<!-- Responsive Design -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/media-queries.css">

	<!-- Bad IE Styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/ie-fixes.css">

	<!-- Added Styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/added.css">

        <!-- Tuition Styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/extra_tuition.css?1.2">

	<link rel="stylesheet" href="<?php echo base_url(); ?>css/excursion.css?version=1.0">



	<!-- The Scripts -->
	<!-- ----------- -->


	<!-- JavaScript at the top (will be cached by browser) -->

	<!-- Load Webfont loader-->
	<script type="text/javascript">
		window.WebFontConfig = {
			google: { families: [ 'PT Sans:400,700' ] },
			//active: function(){ $(window).trigger('fontsloaded') }
		};
	</script>
	<script defer async src="https://ajax.googleapis.com/ajax/libs/webfont/1.0.28/webfont.js"></script>

	<!-- Essential polyfills -->
	<script src="<?php echo base_url(); ?>js/mylibs/polyfills/modernizr-2.6.1.min.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/polyfills/respond.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/polyfills/matchmedia.js"></script>
	<!--[if lt IE 9]><script src="<?php echo base_url(); ?>js/mylibs/polyfills/selectivizr-min.js"></script><![endif]-->
	<!--[if lt IE 10]><script src="<?php echo base_url(); ?>js/mylibs/charts/excanvas.js"></script><![endif]-->
	<!--[if lt IE 10]><script src="<?php echo base_url(); ?>js/mylibs/polyfills/classlist.js"></script><![endif]-->

	<!-- Grab frameworks from CDNs -->
		<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>js/libs/jquery-1.7.2.min.js"><\/script>')</script>
	<script type="text/javascript">
	var baseUrl = "<?php echo base_url(); ?>";
	var siteUrl = "<?php echo site_url(); ?>/";
	</script>
		<!-- Do the same with jQuery UI -->
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
	<script>window.jQuery.ui || document.write('<script src="<?php echo base_url(); ?>js/libs/jquery-ui-1.8.21.min.js"><\/script>')</script>

		<!-- Do the same with Lo-Dash.js -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/lodash.js/0.4.2/lodash.min.js"></script>
	<script>window._ || document.write('<script src="<?php echo base_url(); ?>js/libs/lodash.min.js"><\/script>')</script>



	<!-- scripts concatenated and minified via build script -->

	<!-- General Scripts -->
	<script src="<?php echo base_url(); ?>js/mylibs/jquery.hashchange.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/jquery.idle-timer.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/jquery.plusplus.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/jquery.jgrowl.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/jquery.scrollTo.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/jquery.ui.touch-punch.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/jquery.ui.multiaccordion.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/number-functions.js"></script>

	<!-- Forms -->
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.autosize.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.checkbox.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.chosen.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.cleditor.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.colorpicker.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.ellipsis.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.fileinput.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.fullcalendar.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.maskedinput.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.mousewheel.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.placeholder.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.pwdmeter.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.ui.datetimepicker.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.ui.spinner.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.validate.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/uploader/plupload.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/uploader/plupload.html5.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/uploader/plupload.html4.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/uploader/plupload.flash.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/forms/uploader/jquery.plupload.queue/jquery.plupload.queue.js"></script>

	<!-- Charts -->
	<script src="<?php echo base_url(); ?>js/mylibs/charts/jquery.flot.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/charts/jquery.flot.orderBars.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/charts/jquery.flot.pie.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/charts/jquery.flot.resize.js"></script>

	<!-- Explorer -->
	<script src="<?php echo base_url(); ?>js/mylibs/explorer/jquery.elfinder.js"></script>

	<!-- Fullstats -->
	<script src="<?php echo base_url(); ?>js/mylibs/fullstats/jquery.css-transform.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/fullstats/jquery.animate-css-rotate-scale.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/fullstats/jquery.sparkline.js"></script>

	<!-- Syntax Highlighter -->
	<script src="<?php echo base_url(); ?>js/mylibs/syntaxhighlighter/shCore.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/syntaxhighlighter/shAutoloader.js"></script>

	<!-- Dynamic Tables -->
	<script src="<?php echo base_url(); ?>js/mylibs/dynamic-tables/jquery.dataTables.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/dynamic-tables/jquery.dataTables.tableTools.zeroClipboard.js"></script>
	<script src="<?php echo base_url(); ?>js/mylibs/dynamic-tables/jquery.dataTables.tableTools.js"></script>

	<!-- Gallery -->
	<script src="<?php echo base_url(); ?>js/mylibs/gallery/jquery.fancybox.js"></script>

	<!-- Tooltips -->
	<script src="<?php echo base_url(); ?>js/mylibs/tooltips/jquery.tipsy.js"></script>

	<!-- Form -->
	<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.form.js"></script>

	<!-- Do not touch! -->
	<script src="<?php echo base_url(); ?>js/mango.js"></script>
	<script src="<?php echo base_url(); ?>js/plugins.js"></script>
	<script src="<?php echo base_url(); ?>js/script.js"></script>

	<!-- Your custom JS goes here -->
	<script src="<?php echo base_url(); ?>js/app.js"></script>

	<!-- end scripts -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35948030-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();


</script>
</head>
<body>

	<!----------------------->
	<!-- Some dialogs etc. -->

	<!-- The loading box -->
	<div id="loading-overlay"></div>
	<div id="loading">
		<span>Loading...</span>
	</div>
	<!-- End of loading box -->
	<section id="toolbar">
		<div class="container_12">
			<!-- Left side -->
			<div class="left">
				<ul class="breadcrumb">
					<li><a href="javascript:void(0);">plus-ed.com</a></li>
					<li><a href="javascript:void(0);"><?php echo $breadcrumb1 ?></a></li>
					<?php if($breadcrumb2){ ?>
					<li><a href="javascript:void(0);"><?php echo $breadcrumb2 ?></a></li>
					<?php } ?>
				</ul>
			</div>
			<div class="right">
				<ul>
                                    <?php
                                        $bOArray = array(200,300,400,100,550);
                                    ?>
                                        <?php if(in_array($this->session->userdata('role'),$bOArray)){?>
                                        <li><a href="<?php echo base_url(); ?>index.php/backoffice/profile"><span class="icon i14_admin-user"></span>Profile</a></li>
					<?php }elseif($this->session->userdata('role')== 502){ ?>
					<li><a href="<?php echo base_url(); ?>index.php/students/profile"><span class="icon i14_admin-user"></span>Profile</a></li>
					<?php }elseif($this->session->userdata('role')!=97 && $this->session->userdata('role')!=500 && $this->session->userdata('role')!=501){ ?>
					<li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential"><span class="icon i14_admin-user"></span>Profile</a></li>
					<?php }elseif($this->session->userdata('role')== 500){ ?>
					<li><a href="<?php echo base_url(); ?>index.php/users/profile"><span class="icon i14_admin-user"></span>Profile</a></li>
					<?php }elseif($this->session->userdata('role')== 501){ ?>
					<li><a href="<?php echo base_url(); ?>index.php/survey/profile"><span class="icon i14_admin-user"></span>Profile</a></li>
					<?php }?>
					<?php if($this->session->userdata('role') == 100 || $this->session->userdata('role') == 400 || $this->session->userdata('role') == 550 ){ ?>
					<li class="red"><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
					<?php }else if($this->session->userdata('role') == 500){?>
					<li class="red"><a href="<?php echo base_url(); ?>index.php/users/logout">Logout</a></li>
					<?php }else{?>
					<li class="red"><a href="<?php echo base_url(); ?>index.php/<?php echo $this->uri->segment(1) ?>/logout">Logout</a></li>
					<?php }?>
				</ul>
			</div>
			<!-- Phone only items -->
			<div class="phone">
				<!-- User Link -->
                                <?php if(in_array($this->session->userdata('role'),$bOArray)){?>
                                <li><a href="<?php echo base_url(); ?>index.php/backoffice/profile"><span class="icon icon-user"></span></a></li>
				<?php }elseif($this->session->userdata('role')== 502){ ?>
                                <li><a href="<?php echo base_url(); ?>index.php/students/logout"><span class="icon icon-off"></span></a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/students/profile"><span class="icon icon-user"></span></a></li>
                                <?php }elseif($this->session->userdata('role')== 501){ ?>
                                <li><a href="<?php echo base_url(); ?>index.php/survey/logout"><span class="icon icon-off"></span></a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/survey/profile"><span class="icon icon-user"></span></a></li>
                                <?php }elseif($this->session->userdata('role')== 500){ ?>
                                <li><a href="<?php echo base_url(); ?>index.php/users/logout"><span class="icon icon-off"></span></a></li>
				<li><a href="<?php echo base_url(); ?>index.php/users/profile"><span class="icon icon-user"></span></a></li>
				<?php }else{?>
				<li><a href="<?php echo base_url(); ?>index.php/agents/profile"><span class="icon icon-user"></span></a></li>
				<?php }?>
				<!-- Navigation -->
				<li><a class="navigation" href="#"><span class="icon icon-list"></span></a></li>
			</div><!-- End of phone items -->

		</div><!-- End of .container_12 -->
	</section><!-- End of #toolbar -->

	<!-- The header containing the logo -->
	<header class="container_12">
		<!-- Your logos -->
		<a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/logo.png" alt="plus-ed.com" width="191" height="60"></a>
		<a class="phone-title" href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/logo-mobile.png" alt="plus-ed.com" height="22" width="70" /></a>
	</header><!-- End of header -->
