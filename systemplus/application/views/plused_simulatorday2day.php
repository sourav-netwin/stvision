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
	<title>plus-ed.com | Simulator day 2 day</title>
	<meta name="description" content="plus-ed.com | Simulator day 2 day">
	<meta name="author" content="plus-ed.com">

	<!-- Mobile viewport optimized: h5bp.com/viewport -->
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!-- iPhone: Don't render numbers as call links -->
	<meta name="format-detection" content="telephone=no">
	
	<link rel="shortcut icon" href="http://plus-ed.com/vision_ag/favicon.ico" />
	<!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
	<!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->
	
	
	<!-- The Styles -->
	<!-- ---------- -->
	
	<!-- Layout Styles -->
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/style.css">
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/grid.css">
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/layout.css">
	
	<!-- Icon Styles -->
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/icons.css">
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/fonts/font-awesome.css">
	<!--[if IE 8]><link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/fonts/font-awesome-ie7.css"><![endif]-->
	
	<!-- External Styles -->
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/external/jquery-ui-1.8.21.custom.css">
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/external/jquery.chosen.css">
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/external/jquery.cleditor.css">
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/external/jquery.colorpicker.css">
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/external/jquery.elfinder.css">
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/external/jquery.fancybox.css">
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/external/jquery.jgrowl.css">
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/external/jquery.plupload.queue.css">
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/external/syntaxhighlighter/shCore.css" />
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/external/syntaxhighlighter/shThemeDefault.css" />
	
	<!-- eventCalendar -->
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/calendar/eventCalendar.css">
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/calendar/eventCalendar_theme_responsive.css">	
	
	<!-- Elements -->
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/elements.css">
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/forms.css">
	
	<!-- OPTIONAL: Print Stylesheet for Invoice -->
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/print-invoice.css">
	
	<!-- Typographics -->
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/typographics.css">
	
	<!-- Responsive Design -->
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/media-queries.css">
	
	<!-- Bad IE Styles -->
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/ie-fixes.css">
	
	<!-- Added Styles -->
	<link rel="stylesheet" href="http://plus-ed.com/vision_ag/css/added.css">
	
	
	
	
	
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
	<script src="http://plus-ed.com/vision_ag/js/mylibs/polyfills/modernizr-2.6.1.min.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/polyfills/respond.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/polyfills/matchmedia.js"></script>
	<!--[if lt IE 9]><script src="http://plus-ed.com/vision_ag/js/mylibs/polyfills/selectivizr-min.js"></script><![endif]-->
	<!--[if lt IE 10]><script src="http://plus-ed.com/vision_ag/js/mylibs/charts/excanvas.js"></script><![endif]-->
	<!--[if lt IE 10]><script src="http://plus-ed.com/vision_ag/js/mylibs/polyfills/classlist.js"></script><![endif]-->
	
	<!-- Grab frameworks from CDNs -->
		<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="http://plus-ed.com/vision_ag/js/libs/jquery-1.7.2.min.js"><\/script>')</script>
	
		<!-- Do the same with jQuery UI -->
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
	<script>window.jQuery.ui || document.write('<script src="http://plus-ed.com/vision_ag/js/libs/jquery-ui-1.8.21.min.js"><\/script>')</script>
	
		<!-- Do the same with Lo-Dash.js -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/lodash.js/0.4.2/lodash.min.js"></script>
	<script>window._ || document.write('<script src="http://plus-ed.com/vision_ag/js/libs/lodash.min.js"><\/script>')</script>
	
	
	
	<!-- scripts concatenated and minified via build script -->
	
	<!-- General Scripts -->
	<script src="http://plus-ed.com/vision_ag/js/mylibs/jquery.hashchange.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/jquery.idle-timer.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/jquery.plusplus.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/jquery.jgrowl.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/jquery.scrollTo.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/jquery.ui.touch-punch.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/jquery.ui.multiaccordion.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/number-functions.js"></script>
	
	<!-- Forms -->
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.autosize.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.checkbox.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.chosen.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.cleditor.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.colorpicker.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.ellipsis.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.fileinput.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.fullcalendar.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.maskedinput.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.mousewheel.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.placeholder.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.pwdmeter.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.ui.datetimepicker.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.ui.spinner.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/jquery.validate.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/uploader/plupload.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/uploader/plupload.html5.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/uploader/plupload.html4.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/uploader/plupload.flash.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/forms/uploader/jquery.plupload.queue/jquery.plupload.queue.js"></script>
		
	<!-- Charts -->
	<script src="http://plus-ed.com/vision_ag/js/mylibs/charts/jquery.flot.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/charts/jquery.flot.orderBars.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/charts/jquery.flot.pie.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/charts/jquery.flot.resize.js"></script>
	
	<!-- Explorer -->
	<script src="http://plus-ed.com/vision_ag/js/mylibs/explorer/jquery.elfinder.js"></script>
	
	<!-- Fullstats -->
	<script src="http://plus-ed.com/vision_ag/js/mylibs/fullstats/jquery.css-transform.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/fullstats/jquery.animate-css-rotate-scale.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/fullstats/jquery.sparkline.js"></script>
	
	<!-- Syntax Highlighter -->
	<script src="http://plus-ed.com/vision_ag/js/mylibs/syntaxhighlighter/shCore.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/syntaxhighlighter/shAutoloader.js"></script>
	
	<!-- Dynamic Tables -->
	<script src="http://plus-ed.com/vision_ag/js/mylibs/dynamic-tables/jquery.dataTables.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/dynamic-tables/jquery.dataTables.tableTools.zeroClipboard.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/mylibs/dynamic-tables/jquery.dataTables.tableTools.js"></script>
	
	<!-- Gallery -->
	<script src="http://plus-ed.com/vision_ag/js/mylibs/gallery/jquery.fancybox.js"></script>
	
	<!-- Tooltips -->
	<script src="http://plus-ed.com/vision_ag/js/mylibs/tooltips/jquery.tipsy.js"></script>
	
	<!-- Do not touch! -->
	<script src="http://plus-ed.com/vision_ag/js/mango.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/plugins.js"></script>
	<script src="http://plus-ed.com/vision_ag/js/script.js"></script>
	
	<!-- Your custom JS goes here -->
	<script src="http://plus-ed.com/vision_ag/js/app.js"></script>
	
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
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Simulator D2D</h2>
					</div>
					
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="styled simmy" data-table-tools='{"display":false}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Agency</th>
									<th>ID</th>
								<?php
									$datecycle = $datein;
									while (strtotime($datecycle) <= strtotime($dateout)) {
								?>
									<th><?php echo date("d/m",strtotime($datecycle)) ?></th>
								<?php
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
									}
								?>
									<th>Date in</th>
									<th>Date out</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								$contarighe=1;
								foreach($simbooking as $book){
									$da=explode("-",$book["arrival_date"]);
									$dd=explode("-",$book["departure_date"]);
							?>
								<tr id="riga_<?php echo $contarighe?>">
									<td class="n_<?php echo $book["status"] ?>"><?php echo $book["businessname"] ?><input type="hidden" value="<?php echo $book["num_in"] ?>" id="pax_<?php echo $contarighe?>"></td>
									<td class="center n_<?php echo $book["status"] ?>"><?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?></td>
								<?php
									//echo $datein."-->";
									$datecycle = date ("Y-m-d", strtotime("+0 day", strtotime($datein)));
									//$datecycle = $datein;								
									while (strtotime($datecycle) <= strtotime($dateout)) {
									//echo $datecycle."<br>";
									//sostituito <= con < nell'if successivo per liberare i posti oncampus il giorno della partenza!
									if($datecycle>=$book["arrival_date"] and $datecycle<$book["departure_date"]){
								?>
									<td class="n_<?php echo $book["status"] ?>"><input class="contapax nobbg" id="pax_<?php echo $contarighe?>_<?php echo strtotime($datecycle)?>" type="text" readonly value="<?php echo $book["num_in"] ?>"></td>
								<?php
									}else{
								?>
									<td class="n_<?php echo $book["status"] ?>"><input class="contapax nobbg" id="pax_<?php echo $contarighe?>_<?php echo strtotime($datecycle)?>" type="text" readonly value="-"></td>
								<?php
									}
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
									}
								?>									
									<td class="n_<?php echo $book["status"] ?>"><input class="chdatain datesim" id="datein_<?php echo $contarighe?>" type="text" value="<?php echo $book["arrival_date"] ?>"><input type="hidden" readonly id="hid_datein_<?php echo $contarighe?>" value="<?php echo strtotime($book["arrival_date"])?>"></td>
									<td class="n_<?php echo $book["status"] ?>"><input class="chdataout datesim" id="dateout_<?php echo $contarighe?>" type="text" value="<?php echo $book["departure_date"] ?>"><input type="hidden" readonly id="hid_dateout_<?php echo $contarighe?>" value="<?php echo strtotime($book["departure_date"])?>"></td>
								</tr>
							<?php
									$contarighe++;
								}
							?>
								<tr>
									<td colspan="2">Availability total</td>
								<?php
									$datecycle = $datein;	
									foreach($simcalendar as $cAva) {	
								?>
									<td><input id="totava_<?php echo strtotime($datecycle)?>" type="text" class="nobbg" readonly value="<?php echo $cAva["totale"]?>"></td>
								<?php
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
									}
								?>	
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2">Booked</td>
								<?php
									$datecycle = $datein;								
									while (strtotime($datecycle) <= strtotime($dateout)) {
								?>
									<td><input class="nobbg" type="text" readonly id="totpax_<?php echo strtotime($datecycle)?>" value="0"></td>
								<?php
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
									}
								?>	
									<td colspan="2">&nbsp;</td>
								</tr>	
								<tr>
									<td colspan="2">Availability left</td>
								<?php
									$datecycle = $datein;								
									while (strtotime($datecycle) <= strtotime($dateout)) {
								?>
									<td><input class="nobbg" type="text" readonly id="leftava_<?php echo strtotime($datecycle)?>" value="0" style="color:#fff;font-weight:bold;"></td>
								<?php
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
									}
								?>	
									<td colspan="2">&nbsp;</td>
								</tr>									
							</tbody>
						</table>
					</div><!-- End of .content -->
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->
		</section><!-- End of #content -->
<script>
function updatebkd(ggt, dateloop2){
	var i=0;
		while(i<dateloop2.length){
			var somma = 0;
			for(girx=1;girx<ggt;girx++){
				var idattualex = "#pax_"+girx+"_"+dateloop2[i];
				//alert(idattualex);
				//alert($(idattualex).val());
				iddasommare = $(idattualex).val();
				if(iddasommare=="-")
					iddasommare=0;
				somma = somma+(iddasommare*1);
				//alert(somma);
			}
				idttriga="#totpax_"+dateloop2[i];
				idttava="#totava_"+dateloop2[i];
				idleftava="#leftava_"+dateloop2[i];
				var totava = $(idttava).val();
				$(idttriga).val(somma);
				var leftava = totava*1-somma*1;
				var classeavanzo = "#060";
				if(leftava < 0)
					classeavanzo = "#600";
				$(idleftava).val(leftava);
				$(idleftava).parent("td").css("backgroundColor",classeavanzo);
			i++;
		}
		//alert(somma);
} 

$(document).ready(function(){
	var contabkgs = <?php echo $contarighe?>;
	dateloop = new Array(); 
	<?php
		$datecycle = $datein;	
		$contagirini = 0;
		while (strtotime($datecycle) <= strtotime($dateout)) {
	?>
		dateloop[<?php echo $contagirini?>]="<?php echo strtotime($datecycle)?>";
	<?php
			$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
			$contagirini++;
		}
	?>	
	updatebkd(contabkgs, dateloop);
	$(".chdatain").blur(function(){
		var unixtime = new Date($(this).val()).getTime() / 1000;
		var idtc = "#hid_"+$(this).attr("id");
		var idouttc = $(this).attr("id").replace("in","out");
		idouttc = "#hid_"+idouttc;
		var unixtimeout = $(idouttc).val();
		var splitidtc = idtc.split("_");
		var idriga = splitidtc[2];
		var idnpax = "#pax_"+idriga;
		var npax = $(idnpax).val();
		$(idtc).val(unixtime);
		var nomeriga = "#riga_"+idriga+" td input.contapax";
		$(nomeriga).each(function(){
			var idtd = $(this).attr("id");
			var splitidtd = idtd.split("_");
			var g_unix = splitidtd[2];
			//sostituito <= con < nell'if successivo per liberare i posti oncampus il giorno della partenza!
			if(g_unix >= unixtime && g_unix < unixtimeout)
				$(this).val(npax);
			else
				$(this).val("-");
		});
		updatebkd(contabkgs, dateloop);
	});


	$(".chdataout").blur(function(){
		var unixtime = new Date($(this).val()).getTime() / 1000;
		var idtc = "#hid_"+$(this).attr("id");
		var idouttc = $(this).attr("id").replace("out","in");
		idouttc = "#hid_"+idouttc;
		var unixtimeout = $(idouttc).val();
		var splitidtc = idtc.split("_");
		var idriga = splitidtc[2];
		var idnpax = "#pax_"+idriga;
		var npax = $(idnpax).val();		
		$(idtc).val(unixtime);
		var nomeriga = "#riga_"+idriga+" td input.contapax";
		$(nomeriga).each(function(){
			var idtd = $(this).attr("id");
			var splitidtd = idtd.split("_");
			var g_unix = splitidtd[2];
			//sostituito <= con < nell'if successivo per liberare i posti oncampus il giorno della partenza!
			if(g_unix >= unixtimeout && g_unix < unixtime)
				$(this).val(npax);
			else
				$(this).val("-");
		});
		updatebkd(contabkgs, dateloop);
	});	

});
</script>

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