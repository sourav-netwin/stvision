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
	
	
	<!-- The Scripts -->
	<!-- ----------- -->
	
	
	<!-- JavaScript at the top (will be cached by browser) -->
	
	<!-- Load Webfont loader -->
	<script type="text/javascript">
		window.WebFontConfig = {
			google: { families: [ 'PT Sans:400,700' ] },
			active: function(){ $(window).trigger('fontsloaded') }
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
	
	<!-- Do not touch! -->
	<script src="<?php echo base_url(); ?>js/mango.js"></script>
	<script src="<?php echo base_url(); ?>js/plugins.js"></script>
	<script src="<?php echo base_url(); ?>js/script.js"></script>
	
	<!-- Your custom JS goes here -->
<!--	<script src="<?php echo base_url(); ?>js/app.js"></script>-->
	
	<!-- end scripts -->
	<style>
            a{
                text-decoration: underline;
            }
            .alert{
                width: 92% !important;
            }
            .error{
                color: #f00;
            }
            
            .row div.error{
                border: none !important;
            }
/*            .sel_dob select{
                width: 49px!important;
                float: left;
                margin: 20px 10px 0 2px !important;
            }
            .sel_dob label{
                width: 30px!important;
                float: left;
                margin: 20px 10px 0 2px !important;
            }
            .sel_dob label:last-of-type{
                width: 30px!important;
                clear: both;
                margin: 20px 10px 0 2px !important;
            }
            .sel_dob select:last-of-type{
                width: 60px!important;
                margin: 20px 10px 10px 2px !important;
            }*/

            .sel_dob .grid_3{
                margin: 20px 0 !important;
                width: 30% !important;
            }
            @media only screen and (max-width: 500px) {
                .sel_dob .grid_3{
                    margin: 20px 0 10px 0 !important;
                    width: 50% !important;
                }
                .sel_dob .grid_3:last-of-type{
                    margin: 2px 0 !important;
                    width: 50% !important;
                }
            }
            .login-phone div.error:not(.alert){
                width: 137px!important;
                margin: 0px !important;
            }
            .login-phone input.error{
                margin-bottom: 2px !important;
            }
            .login-phone input{
                margin-top: 15px !important;
                margin-bottom: 2px !important;
            }
        </style>
</head>

<body class=login>

	<!-- Some dialogs etc. -->

	<!-- The loading box -->
	<div id="loading-overlay"></div>
	<div id="loading">
		<span>Loading...</span>
	</div>
	<!-- End of loading box -->
	
	<!--------------------------------->
	<!-- Now, the page itself begins -->
	<!--------------------------------->
	
	<!-- The toolbar at the top -->
	<section id="toolbar">
		<div class="container_12">
			<div class="left"></div>
			<div class="right"></div><!-- End of .right -->
			<!-- Phone only items -->
			<div class="phone">
				
				<!-- User Link -->
<!--				<li><a href="#"><span class="icon icon-home"></span></a></li>
				 Navigation 
				<li><a href="#"><span class="icon icon-heart"></span></a></li>-->
			
			</div><!-- End of .phone -->
			
		</div><!-- End of .container_12 -->
	</section><!-- End of #toolbar -->
	
	<!-- The header containing the logo -->
	<header class="container_12">
		
		<div class="container">
		
			<!-- Your logos -->
			<a href="<?php echo base_url(); ?>index.php/survey"><img src="<?php echo base_url(); ?>img/logo-light.png" alt="plus-ed.com" width="210" height="67"></a>
			<a class="phone-title" href="login.html"><img src="<?php echo base_url(); ?>img/logo-mobile.png" alt="plus-ed.com" height="22" width="70" /></a>
			
			<!-- Right link -->
<!--			<div class="right">
				<span>Don’t have an account?</span>
				<a href="<?php //echo base_url(); ?>index.php/backoffice/register">Register</a>
			</div>-->
			
		</div><!-- End of .container -->
	
	</header><!-- End of header -->
	
	<!-- The container of the sidebar and content box -->
	<section id="login" class="container_12 clearfix">
	
		<form id="frmLogin" action="<?php echo base_url(); ?>index.php/survey/login" method="post" class="box validate login-phone">
		
			<div class="header">
				<h2><span class="icon icon-lock"></span>Login</h2>
			</div>
			
			<div class="content">
			<?php
				$loginFailed = $this->session->flashdata('login_failed');
				if($loginFailed){
				?>
					<div class="alert error">
						<span class="icon"></span><span class="close">x</span>
						<strong>Error!</strong> Invalid credentials.
					</div>
				<?php /*
            			?>
					<div class="alert success">
						<span class="icon"></span><span class="close">x</span>
						<strong>Success!</strong> Within the next 24 hours you'll receive a confirmation email.
					</div>
				<?php
					*/
				}
			?>
				
				<!-- Login messages -->
				<div class="login-messages">
					<div class="message welcome">Welcome back!</div>
					<div class="message failure">Invalid credentials.</div>
				</div>
			
				<!-- The form -->
				<div class="form-box">
				
					<div class="row">
						<label for="login_name">
							<strong>Name</strong>
						</label>
						<div>
							<input tabindex=1 type="text" class="required noerror" name="login_name" id="login_name" />
						</div>
					</div>
                                        <div class="row">
						<label for="login_surname">
							<strong>Surname</strong>
						</label>
						<div>
							<input tabindex=1 type="text" class="required noerror" name="login_surname" id="login_surname" />
						</div>
					</div>
					
					<div class="row">
						<label for="login_dob">
							<strong>Date of birth</strong>
						</label>
						<div class="sel_dob">
                                                    <?php 
                                                    /*
                                                    <input type="text" autocomplete="off" placeholder="Day" id="txtDay" name="selDay" value="" />
                                                    <input type="text" autocomplete="off" placeholder="Month" id="txtMonth" name="selMonth" value="" />
                                                    <input type="text" autocomplete="off" placeholder="Year" id="txtYear" name="selYear" value="" />
                                                    <?php
                                                     */ ?>
                                                    <div class="grid_3">
                                                        <label for="selDay">
                                                            <strong>Day</strong>
                                                        </label>
                                                        <select id="selDay" name="selDay" >
                                                            <?php 
                                                            for($day = 1;$day < 32; $day++){
                                                                ?><option value="<?php echo $day;?>" ><?php echo str_pad($day, 2, '0', STR_PAD_LEFT);?></option><?php 
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="grid_3">
                                                    <label for="selMonth">
							<strong>Month</strong>
                                                    </label>
                                                    <select id="selMonth" name="selMonth" >
                                                        <?php 
                                                        for($month = 1;$month < 13; $month++){
                                                            ?><option value="<?php echo $month;?>" ><?php echo str_pad($month, 2, '0', STR_PAD_LEFT);?></option><?php 
                                                        }
                                                        ?>
                                                    </select>
                                                    </div>
                                                    <div class="grid_3">
                                                    <label for="selYear">
							<strong>Year</strong>
                                                    </label>
                                                    <select id="selYear" name="selYear" >
                                                        <?php 
                                                        for($year = 2010;$year > 1944; $year--){
                                                            ?><option value="<?php echo $year;?>" ><?php echo $year;?></option><?php 
                                                        }
                                                        ?>
                                                    </select>
                                                    </div>
						</div>
					</div>
					
				</div><!-- End of .form-box -->
				
			</div><!-- End of .content -->
			
			<div class="actions">
				<div class="right">
					<input tabindex=3 type="submit" value="Sign In" name="login_btn" />
				</div>
			</div><!-- End of .actions -->
			
		</form><!-- End of form -->

	</section>
	
	<!-- Spawn $$.loaded -->
<!--        <script src="<?php echo base_url();?>js/jquery_validations1.9.0.js"></script>-->
	<style>
/*            #txtDay{
                width: 45px
            }
            #txtYear, #txtMonth{
                width:60px;
            }*/
        </style>
	<script>
		$$.loaded();
                
//                $( ".sel_dob input" ).datepicker({
//                    changeMonth: true,
//                    changeYear: true,
//                    maxDate: new Date(1999, 12 - 1, 31),
//                    onSelect: function(dateText, inst) { 
//                        var date = $(this).datepicker('getDate'),
//                            day  = date.getDate(),  
//                            month = date.getMonth() + 1,              
//                            year =  date.getFullYear();
//                        $("#txtDay").val(day);
//                        $("#txtMonth").val(month);
//                        $("#txtYear").val(year);
//                    }
//                });
                
                $.validator.addMethod(
                    "australianDate",
                    function(value, element) {
                        return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
                    },
                    "Please enter a date in the format dd/mm/yyyy"
                );
                
                $("#frmLogin").validate({
                    errorElement:"div",
                    ignore: "",
                    rules: {
                        login_name: {
                            required: true
                        },
                        login_surname: {
                            required: true
                        }//,
//                        login_dob: {
//                            australianDate: true,
//                            required: true
//                        }
                    },
                    messages: {
                        login_name: "Please enter your name",
                        login_surname: "Please enter your surname"//,
                        //login_dob: "Please enter your date of birth"
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
                $(".chzn-container").remove();
                $("select").css('display','block');
	</script>
	
	<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
	   chromium.org/developers/how-tos/chrome-frame-getting-started -->
	<!--[if lt IE 7 ]>
	<script defer src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->

</body>
</html>
