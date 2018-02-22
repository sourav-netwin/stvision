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
	<!--[if IE 8]><link rel="stylesheet" href="css/fonts/font-awesome-ie7.css"><![endif]-->
	
	<!-- External Styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery-ui-1.8.21.custom.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery.chosen.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery.cleditor.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery.colorpicker.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery.elfinder.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery.fancybox.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery.jgrowl.css">
	<link rel="stylesheet" href="css/external/jquery.plupload.queue.css">
	<link rel="stylesheet" href="css/external/syntaxhighlighter/shCore.css" />
	<link rel="stylesheet" href="css/external/syntaxhighlighter/shThemeDefault.css" />
	
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
	<script src="<?php echo base_url(); ?>js/app.js"></script>
	
	<!-- end scripts -->
	
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
				<li><a href="#"><span class="icon icon-home"></span></a></li>
				<!-- Navigation -->
				<li><a href="#"><span class="icon icon-heart"></span></a></li>
			
			</div><!-- End of .phone -->
			
		</div><!-- End of .container_12 -->
	</section><!-- End of #toolbar -->
	
	<!-- The header containing the logo -->
	<header class="container_12">
		
		<div class="container">
		
			<!-- Your logos -->
			<a href="<?php echo base_url(); ?>index.php/agents"><img src="<?php echo base_url(); ?>img/logo-light.png" alt="plus-ed.com" width="210" height="67"></a>
			<a class="phone-title" href="login.html"><img src="<?php echo base_url(); ?>img/logo-mobile.png" alt="plus-ed.com" height="22" width="70" /></a>
			
			<!-- Right link -->
			<div class="right">
				<span>Already have an account?</span>
				<a href="<?php echo base_url(); ?>index.php/agents/">Login</a>
			</div>
			
		</div><!-- End of .container -->
	
	</header><!-- End of header -->
	
	<!-- The container of the sidebar and content box -->
	<section id="login" class="container_12 clearfix">
	
		<form action="<?php echo base_url(); ?>index.php/agents/confirm_registration" method="post" class="box validate box_large">
		
			<div class="header">
				<h2><span class="icon icon-user"></span>Register</h2>
			</div>
			
			<div class="content">
				
			
				<!-- The form -->
				<div class="form-box">
				
					<div class="row">
						<label for="business_name">
							<strong>Business name</strong>
						</label>
						<div>
							<input tabindex=1 type="text" class="required" name=business_name id=business_name />
						</div>
					</div>
					<div class="row">
						<label for="address">
							<strong>Address</strong>
						</label>
						<div>
							<input tabindex=2 type="text" class="noerror" name=address id=address />
						</div>
					</div>
					<div class="row">
						<label for="postal_code">
							<strong>Postal code</strong>
						</label>
						<div>
							<input tabindex=3 type="text" class="noerror" name=postal_code id=postal_code />
						</div>
					</div>
					<div class="row">
						<label for="city">
							<strong>City</strong>
						</label>
						<div>
							<input tabindex=4 type="text" class="required" name=city id=city />
						</div>
					</div>	
					<div class="row">
						<label for="country">
							<strong>Country</strong>
						</label>
						<div>
							<select tabindex=5 name=country id=country class="required">
								<option value="" selected="selected">Select Country</option> 
								<option value="Afghanistan">Afghanistan</option> 
								<option value="Albania">Albania</option> 
								<option value="Algeria">Algeria</option> 
								<option value="American Samoa">American Samoa</option> 
								<option value="Andorra">Andorra</option> 
								<option value="Angola">Angola</option> 
								<option value="Anguilla">Anguilla</option> 
								<option value="Antarctica">Antarctica</option> 
								<option value="Antigua and Barbuda">Antigua and Barbuda</option> 
								<option value="Argentina">Argentina</option> 
								<option value="Armenia">Armenia</option> 
								<option value="Aruba">Aruba</option> 
								<option value="Australia">Australia</option> 
								<option value="Austria">Austria</option> 
								<option value="Azerbaijan">Azerbaijan</option> 
								<option value="Bahamas">Bahamas</option> 
								<option value="Bahrain">Bahrain</option> 
								<option value="Bangladesh">Bangladesh</option> 
								<option value="Barbados">Barbados</option> 
								<option value="Belarus">Belarus</option> 
								<option value="Belgium">Belgium</option> 
								<option value="Belize">Belize</option> 
								<option value="Benin">Benin</option> 
								<option value="Bermuda">Bermuda</option> 
								<option value="Bhutan">Bhutan</option> 
								<option value="Bolivia">Bolivia</option> 
								<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> 
								<option value="Botswana">Botswana</option> 
								<option value="Bouvet Island">Bouvet Island</option> 
								<option value="Brazil">Brazil</option> 
								<option value="British Indian Ocean Territory">British Indian Ocean Territory</option> 
								<option value="Brunei Darussalam">Brunei Darussalam</option> 
								<option value="Bulgaria">Bulgaria</option> 
								<option value="Burkina Faso">Burkina Faso</option> 
								<option value="Burundi">Burundi</option> 
								<option value="Cambodia">Cambodia</option> 
								<option value="Cameroon">Cameroon</option> 
								<option value="Canada">Canada</option> 
								<option value="Cape Verde">Cape Verde</option> 
								<option value="Cayman Islands">Cayman Islands</option> 
								<option value="Central African Republic">Central African Republic</option> 
								<option value="Chad">Chad</option> 
								<option value="Chile">Chile</option> 
								<option value="China">China</option> 
								<option value="Christmas Island">Christmas Island</option> 
								<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> 
								<option value="Colombia">Colombia</option> 
								<option value="Comoros">Comoros</option> 
								<option value="Congo">Congo</option> 
								<option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option> 
								<option value="Cook Islands">Cook Islands</option> 
								<option value="Costa Rica">Costa Rica</option> 
								<option value="Cote D'ivoire">Cote D'ivoire</option> 
								<option value="Croatia">Croatia</option> 
								<option value="Cuba">Cuba</option> 
								<option value="Cyprus">Cyprus</option> 
								<option value="Czech Republic">Czech Republic</option> 
								<option value="Denmark">Denmark</option> 
								<option value="Djibouti">Djibouti</option> 
								<option value="Dominica">Dominica</option> 
								<option value="Dominican Republic">Dominican Republic</option> 
								<option value="Ecuador">Ecuador</option> 
								<option value="Egypt">Egypt</option> 
								<option value="El Salvador">El Salvador</option> 
								<option value="Equatorial Guinea">Equatorial Guinea</option> 
								<option value="Eritrea">Eritrea</option> 
								<option value="Estonia">Estonia</option> 
								<option value="Ethiopia">Ethiopia</option> 
								<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> 
								<option value="Faroe Islands">Faroe Islands</option> 
								<option value="Fiji">Fiji</option> 
								<option value="Finland">Finland</option> 
								<option value="France">France</option> 
								<option value="French Guiana">French Guiana</option> 
								<option value="French Polynesia">French Polynesia</option> 
								<option value="French Southern Territories">French Southern Territories</option> 
								<option value="Gabon">Gabon</option> 
								<option value="Gambia">Gambia</option> 
								<option value="Georgia">Georgia</option> 
								<option value="Germany">Germany</option> 
								<option value="Ghana">Ghana</option> 
								<option value="Gibraltar">Gibraltar</option> 
								<option value="Greece">Greece</option> 
								<option value="Greenland">Greenland</option> 
								<option value="Grenada">Grenada</option> 
								<option value="Guadeloupe">Guadeloupe</option> 
								<option value="Guam">Guam</option> 
								<option value="Guatemala">Guatemala</option> 
								<option value="Guinea">Guinea</option> 
								<option value="Guinea-bissau">Guinea-bissau</option> 
								<option value="Guyana">Guyana</option> 
								<option value="Haiti">Haiti</option> 
								<option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option> 
								<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> 
								<option value="Honduras">Honduras</option> 
								<option value="Hong Kong">Hong Kong</option> 
								<option value="Hungary">Hungary</option> 
								<option value="Iceland">Iceland</option> 
								<option value="India">India</option> 
								<option value="Indonesia">Indonesia</option> 
								<option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option> 
								<option value="Iraq">Iraq</option> 
								<option value="Ireland">Ireland</option> 
								<option value="Israel">Israel</option> 
								<option value="Italy">Italy</option> 
								<option value="Jamaica">Jamaica</option> 
								<option value="Japan">Japan</option> 
								<option value="Jordan">Jordan</option> 
								<option value="Kazakhstan">Kazakhstan</option> 
								<option value="Kenya">Kenya</option> 
								<option value="Kiribati">Kiribati</option> 
								<option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option> 
								<option value="Korea, Republic of">Korea, Republic of</option> 
								<option value="Kuwait">Kuwait</option> 
								<option value="Kyrgyzstan">Kyrgyzstan</option> 
								<option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option> 
								<option value="Latvia">Latvia</option> 
								<option value="Lebanon">Lebanon</option> 
								<option value="Lesotho">Lesotho</option> 
								<option value="Liberia">Liberia</option> 
								<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> 
								<option value="Liechtenstein">Liechtenstein</option> 
								<option value="Lithuania">Lithuania</option> 
								<option value="Luxembourg">Luxembourg</option> 
								<option value="Macao">Macao</option> 
								<option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option> 
								<option value="Madagascar">Madagascar</option> 
								<option value="Malawi">Malawi</option> 
								<option value="Malaysia">Malaysia</option> 
								<option value="Maldives">Maldives</option> 
								<option value="Mali">Mali</option> 
								<option value="Malta">Malta</option> 
								<option value="Marshall Islands">Marshall Islands</option> 
								<option value="Martinique">Martinique</option> 
								<option value="Mauritania">Mauritania</option> 
								<option value="Mauritius">Mauritius</option> 
								<option value="Mayotte">Mayotte</option> 
								<option value="Mexico">Mexico</option> 
								<option value="Micronesia, Federated States of">Micronesia, Federated States of</option> 
								<option value="Moldova, Republic of">Moldova, Republic of</option> 
								<option value="Monaco">Monaco</option> 
								<option value="Mongolia">Mongolia</option> 
								<option value="Montserrat">Montserrat</option> 
								<option value="Morocco">Morocco</option> 
								<option value="Mozambique">Mozambique</option> 
								<option value="Myanmar">Myanmar</option> 
								<option value="Namibia">Namibia</option> 
								<option value="Nauru">Nauru</option> 
								<option value="Nepal">Nepal</option> 
								<option value="Netherlands">Netherlands</option> 
								<option value="Netherlands Antilles">Netherlands Antilles</option> 
								<option value="New Caledonia">New Caledonia</option> 
								<option value="New Zealand">New Zealand</option> 
								<option value="Nicaragua">Nicaragua</option> 
								<option value="Niger">Niger</option> 
								<option value="Nigeria">Nigeria</option> 
								<option value="Niue">Niue</option> 
								<option value="Norfolk Island">Norfolk Island</option> 
								<option value="Northern Mariana Islands">Northern Mariana Islands</option> 
								<option value="Norway">Norway</option> 
								<option value="Oman">Oman</option> 
								<option value="Pakistan">Pakistan</option> 
								<option value="Palau">Palau</option> 
								<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> 
								<option value="Panama">Panama</option> 
								<option value="Papua New Guinea">Papua New Guinea</option> 
								<option value="Paraguay">Paraguay</option> 
								<option value="Peru">Peru</option> 
								<option value="Philippines">Philippines</option> 
								<option value="Pitcairn">Pitcairn</option> 
								<option value="Poland">Poland</option> 
								<option value="Portugal">Portugal</option> 
								<option value="Puerto Rico">Puerto Rico</option> 
								<option value="Qatar">Qatar</option> 
								<option value="Reunion">Reunion</option> 
								<option value="Romania">Romania</option> 
								<option value="Russian Federation">Russian Federation</option> 
								<option value="Rwanda">Rwanda</option> 
								<option value="Saint Helena">Saint Helena</option> 
								<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
								<option value="Saint Lucia">Saint Lucia</option> 
								<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> 
								<option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> 
								<option value="Samoa">Samoa</option> 
								<option value="San Marino">San Marino</option> 
								<option value="Sao Tome and Principe">Sao Tome and Principe</option> 
								<option value="Saudi Arabia">Saudi Arabia</option> 
								<option value="Senegal">Senegal</option> 
								<option value="Serbia and Montenegro">Serbia and Montenegro</option> 
								<option value="Seychelles">Seychelles</option> 
								<option value="Sierra Leone">Sierra Leone</option> 
								<option value="Singapore">Singapore</option> 
								<option value="Slovakia">Slovakia</option> 
								<option value="Slovenia">Slovenia</option> 
								<option value="Solomon Islands">Solomon Islands</option> 
								<option value="Somalia">Somalia</option> 
								<option value="South Africa">South Africa</option> 
								<option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option> 
								<option value="Spain">Spain</option> 
								<option value="Sri Lanka">Sri Lanka</option> 
								<option value="Sudan">Sudan</option> 
								<option value="Suriname">Suriname</option> 
								<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> 
								<option value="Swaziland">Swaziland</option> 
								<option value="Sweden">Sweden</option> 
								<option value="Switzerland">Switzerland</option> 
								<option value="Syrian Arab Republic">Syrian Arab Republic</option> 
								<option value="Taiwan">Taiwan</option> 
								<option value="Tajikistan">Tajikistan</option> 
								<option value="Tanzania, United Republic of">Tanzania, United Republic of</option> 
								<option value="Thailand">Thailand</option> 
								<option value="Timor-leste">Timor-leste</option> 
								<option value="Togo">Togo</option> 
								<option value="Tokelau">Tokelau</option> 
								<option value="Tonga">Tonga</option> 
								<option value="Trinidad and Tobago">Trinidad and Tobago</option> 
								<option value="Tunisia">Tunisia</option> 
								<option value="Turkey">Turkey</option> 
								<option value="Turkmenistan">Turkmenistan</option> 
								<option value="Turks and Caicos Islands">Turks and Caicos Islands</option> 
								<option value="Tuvalu">Tuvalu</option> 
								<option value="Uganda">Uganda</option> 
								<option value="Ukraine">Ukraine</option> 
								<option value="United Arab Emirates">United Arab Emirates</option> 
								<option value="United Kingdom">United Kingdom</option> 
								<option value="United States">United States</option> 
								<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> 
								<option value="Uruguay">Uruguay</option> 
								<option value="Uzbekistan">Uzbekistan</option> 
								<option value="Vanuatu">Vanuatu</option> 
								<option value="Venezuela">Venezuela</option> 
								<option value="Viet Nam">Viet Nam</option> 
								<option value="Virgin Islands, British">Virgin Islands, British</option> 
								<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> 
								<option value="Wallis and Futuna">Wallis and Futuna</option> 
								<option value="Western Sahara">Western Sahara</option> 
								<option value="Yemen">Yemen</option> 
								<option value="Zambia">Zambia</option> 
								<option value="Zimbabwe">Zimbabwe</option>
							</select>
						</div>
					</div>	
					<div class="row">
						<label for="email">
							<strong>Email</strong>
						</label>
						<div>
							<input tabindex=6 type="text" class="required email" name=email id=email />
						</div>
					</div>	
					<div class="row">
						<label for="phone">
							<strong>Telephone</strong>
						</label>
						<div>
							<input tabindex=7 type="text" class="required" name=phone id=phone />
						</div>
					</div>	
					<div class="row">
						<label for="firstname">
							<strong>First name</strong>
						</label>
						<div>
							<input tabindex=8 type="text" class="required" name=firstname id=firstname />
						</div>
					</div>	
					<div class="row">
						<label for="familyname">
							<strong>Family name</strong>
						</label>
						<div>
							<input tabindex=8 type="text" class="required" name=familyname id=familyname />
						</div>
					</div>	
					<div class="row">
						<label for="hmstudents">
							<strong>How many students did you<br />send abroad last year?</strong>
						</label>
						<div>
							<select tabindex=9 name=hmstudents id=hmstudents class="required">
								<option value="">Please select</option>
								<option value="1">1-49</option>
								<option value="200">50-199</option>
								<option value="200">200-500</option>
								<option value="501">501-1500</option>
								<option value="1501">1501 and over</option>
							</select>
						</div>
					</div>
					<div class="row" style="line-height:30px;height:30px;"><strong>How were these students apportioned according to the following categories?</strong></div>		
					<div class="row">
						<label for="portionjs">
							<strong>Junior Summer</strong>
						</label>
						<div>
							<select tabindex=10 name=portionjs id=portionjs class="required">
								<option value="1">1-10 %</option>
								<option value="11">11-30 %</option>
								<option value="30">30-60 %</option>
								<option value="60">+60 %</option>
							</select>
						</div>
					</div>	
					<div class="row">
						<label for="portionll">
							<strong>Language learning</strong>
						</label>
						<div>
							<select tabindex=11 name=portionll id=portionll class="required">
								<option value="1">1-10 %</option>
								<option value="11">11-30 %</option>
								<option value="30">30-60 %</option>
								<option value="60">+60 %</option>
							</select>
						</div>
					</div>	
					<div class="row">
						<label for="portionup">
							<strong>University placement</strong>
						</label>
						<div>
							<select tabindex=12 name=portionup id=portionup class="required">
								<option value="1">1-10 %</option>
								<option value="11">11-30 %</option>
								<option value="30">30-60 %</option>
								<option value="60">+60 %</option>
							</select>
						</div>
					</div>	
					<div class="row">
						<label for="destinations">
							<strong>Which Countries are the<br />most popular destination?</strong>
						</label>
						<div>
							<select multiple class="dualselects required" data-size=small id=destinations name=destinations[] >
							<?php
								foreach($pref_dest as $singledest){
							?>
								<option name="<?php echo $singledest['pp_id'] ?>"><?php echo $singledest['pp_dest'] ?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>					
					
				</div><!-- End of .form-box -->
				
			</div><!-- End of .content -->
			
			<div class="actions">
				<div class="right">
					<input tabindex=13 type="submit" value="Register" name="login_btn" />
				</div>
			</div><!-- End of .actions -->
			
		</form><!-- End of form -->

	</section>
	
	<!-- Spawn $$.loaded -->
	<script>
		$$.loaded();
	</script>
	
	<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
	   chromium.org/developers/how-tos/chrome-frame-getting-started -->
	<!--[if lt IE 7 ]>
	<script defer src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->

</body>
</html>
