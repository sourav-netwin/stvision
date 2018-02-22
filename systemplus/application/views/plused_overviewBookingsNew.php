<?php
$this -> load -> view('plused_header');
/**
 * @modified_by Arunsankar S
 * @date : 07-04-2016
 */
?>
<style type="text/css">
	@media(max-width: 767px){
		.grid_4{
			width: 98% !important;
		}
	}
	@media(max-width: 1099px){
		.searchBx{
			width: 98% !important;
			text-align: center;
		}
		.searchBtn{
			width: 98% !important;
			text-align: center;
			margin: 10px;
		}
	}
	@media(max-width: 650px){
		.box{
			margin: 10px;
		}
		.retrBtn{
			margin: 10px;
			text-align: center;
		}
	}
</style>
<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix">

	<!-- The blue toolbar stripe -->
	<section class="toolbar">
		<div class="user">
			<div class="avatar">
				<img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
				<!-- Evidenziare per icone attenzione <span>3</span> -->
			</div>
			<span><? echo $this -> session -> userdata('businessname') ?></span>
			<ul>
				<li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential">Profile</a></li>
				<li class="line"></li>
				<li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
			</ul>
		</div>
	</section><!-- End of .toolbar-->	

	<?php
	$this -> load -> view('plused_sidebar');
	?>		

	<!-- Here goes the content. -->
	<section id="content" class="container_12 clearfix" data-sort=true>
		<h1 class="grid_12 margin-top no-margin-top-phone">Overview bookings</h1>
		<div class="row" style="margin-right:10px;">
			<div class="grid_8">
				&nbsp;
			</div>
			<form style="margin:10px; margin-right: 0" id="searchForm">
				<div class="grid_4">
					<div class="box">
						<div class="header">
							<h2>Booking direct search</h2>
						</div>
						<div class="content" style="padding:10px;">
							<div class="grid_6 searchBx">
								<input type="text" name="searchBk" id="searchBk" style="width: 100%" />
							</div>
							<div class="grid_6 searchBtn">
								<input type="button" name="inviaBk" id="inviaBk" value="Search Booking" style="margin-left:20px;"/>
							</div>								
						</div>
					</div>
				</div>	
			</form>
		</div>
		<div class="row">
			<form style="margin:10px;border: none;" id="box_campus" name="box_campus" action="<?php echo base_url(); ?>index.php/backoffice/overviewBookingsNew" method="post">  
				<div class="grid_12">
					<div class="box">
						<div class="header">
							<h2>Campus
								<span style="float:right;">
									<a href="javascript:void(0);" id="s_USA">USA</a> - 
									<a href="javascript:void(0);" id="s_UK">UK</a> - 
									<a href="javascript:void(0);" id="s_EUR">EUR</a> - 
									<a href="javascript:void(0);" id="s_all">All</a> - 
									<a href="javascript:void(0);" id="s_none">None</a>
								</span>
							</h2>
						</div>
						<div class="content" style="padding:10px;">
							<div class="grid_3">
								<?php
								$contaCentri = 0;
								foreach ($centri as $key => $item) {
									?>
									<input type="checkbox" class="chCentri sel_<?php echo $item['valuta_fattura'] ?>" name="centri[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?><br />
									<?php
									$contaCentri++;
									if ($contaCentri % 5 == 0) {
										?>
									</div>
									<div class="grid_3">
										<?php
									}
								}
								?>	
							</div>
						</div>
					</div>
				</div>		
				<div class="grid_4">
					<div class="box">
						<div class="header">
							<h2>Season / Agency</h2>
						</div>
						<div class="content text-center" style="padding:10px;height:37px;">
							<select name="season" id="season">
								<?php for ($y = 2014; $y <= date("Y") + 1; $y++) { ?>
									<option <?php if ($season == $y) { ?>selected <?php } ?>value="<?php echo $y ?>"><?php echo $y ?> season</option>
<?php } ?>
							</select> 
						</div>		
						<div class="content text-center" style="padding:10px;height:37px;">
							<input type="text" name="ag_complete" id="ag_complete" class="ui-autocomplete-input" autocomplete="off" style="width:96%;">
						</div>							
					</div>
				</div>	
				<div class="grid_4">
					<div class="box">
						<div class="header">
							<h2>Bookings Status
								<span style="float:right;">
									<a href="javascript:void(0);" id="bk_all">All</a> - 
									<a href="javascript:void(0);" id="bk_none">None</a>
								</span>
							</h2>
						</div>
						<div class="content" style="padding:10px;">
							<input class="chStatus" type="checkbox" name="status[]" id="s_confirmed" value="confirmed">Confirmed<br />
							<input class="chStatus" type="checkbox" name="status[]" id="s_active" value="active">Active<br />
							<input class="chStatus" type="checkbox" name="status[]" id="s_elapsed" value="elapsed">Elapsed<br />
							<input class="chStatus" type="checkbox" name="status[]" id="s_tbc" value="tbc">To Be Confirmed<br />
							<input class="chStatus" type="checkbox" name="status[]" id="s_rejected" value="rejected">Rejected<br />
						</div>
					</div>
				</div>	
				<div class="grid_4">
					<div class="box">
						<div class="header">
							<h2>Bookings Flag</h2>
						</div>
						<div class="content" style="padding:10px;height:85px;">
							<input class="chFlag" type="checkbox" name="flag[]" id="f_lm" value="lm">Last Minute<br />
							<input class="chFlag" type="checkbox" name="flag[]" id="f_cfd" value="cfd">Cleared for Departure<br />
							<input class="chFlag" type="checkbox" name="flag[]" id="f_rlock" value="rlock">Locked Rosters<br />
						</div>
					</div>
				</div>	
		</div>
		<div class="row">
			<div class="grid_12 retrBtn">
				<input style="float:right;margin-right:20px;" type="button" name="inviaO" id="inviaO" value="Retrieve Bookings" />
			</div>		
			<input name="agenzia_in" id="idAgente" value="" type="hidden" />
			</form>
		</div>
	</section>	
</div>
<script type="text/javascript">
	var baseUrl = "<?php echo base_url(); ?>";
	var siteUrl = "<?php echo site_url(); ?>/";
</script>
<script>

	
	$(document).ready(function() {

		$("#inviaBk").click(function(e){
			$.ajax({
				type: "POST",
				data: "idsearch=" + $("#searchBk").val(),
				url: siteUrl + "backoffice/bookingExists",
				success: function(response){
					if(response==1){
						var diaH = $(window).height()* 0.9;
						e.preventDefault();
						$('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(' + baseUrl + '/img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
						.html($('<iframe/>', {
							'src' : siteUrl + "backoffice/newAvail/"+$("#searchBk").val(),
							'style' :'width:100%; height:100%;border:none;'
						})).appendTo('body')
						.dialog({
							'title' : 'Bookings detail',
							'width' : '90%',
							'height' : diaH,
							modal: true,
							buttons: [ {
									text: "Close",
									click: function() { $( this ).dialog( "close" ); }
								} ]
						});
					}else{
						alert("This booking id doesn't exists!");
					}
				}
			});
		});

	
		$("#s_USA").click(function(){
			$("input.chCentri").each(function(){
				$(this).attr("checked",false);
			});
			$("input.sel_USD").each(function(){
				$(this).attr("checked",true);
			});		
		});
	
		$("#s_UK").click(function(){
			$("input.chCentri").each(function(){
				$(this).attr("checked",false);
			});
			$("input.sel_GBP").each(function(){
				$(this).attr("checked",true);
			});		
		});	
	
		$("#s_EUR").click(function(){
			$("input.chCentri").each(function(){
				$(this).attr("checked",false);
			});
			$("input.sel_EUR").each(function(){
				$(this).attr("checked",true);
			});		
		});		
		$("#s_all").click(function(){
			$("input.chCentri").each(function(){
				$(this).attr("checked",true);
			});
		});	

		$("#s_none").click(function(){
			$("input.chCentri").each(function(){
				$(this).attr("checked",false);
			});
		});	
		$("#bk_all").click(function(){
			$("input.chStatus").each(function(){
				$(this).attr("checked",true);
			});
		});	

		$("#bk_none").click(function(){
			$("input.chStatus").each(function(){
				$(this).attr("checked",false);
			});
		});		
	
<?php
if ($pStatus == "tbc") {
	?>
			$("input.chCentri").each(function(){
				$(this).attr("checked",true);
			});
			$("#s_<?php echo $pStatus ?>").attr("checked",true);
	<?php
}
?>
	
	
		$( "#dateStart" ).datepicker({
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",
			maxDate: "+1Y"
		}).datepicker("setDate", new Date());;
	


		$('#inviaO').on('click', function(e){
			var centriChecked = $('input.chCentri:checked').length;
			var statusChecked = $('input.chStatus:checked').length;
			if(centriChecked==0){
				alert("Please, select one or more campus!");
				return false;
			}else{
				if(statusChecked==0){
					alert("Please, select one or more status!");
					return false;
				}				
			}
			if($("#ag_complete").val()==""){
				$("#idAgente").val("");
			}
			var diaH = $(window).height()* 0.9;
			e.preventDefault();
			passingData = $('#box_campus').serialize();
			$('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url('+ baseUrl +'img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
			.html($('<iframe/>', {
				'src' : siteUrl + "backoffice/overviewBookingsDetailNew/?"+passingData,
				'style' :'width:100%; height:100%;border:none;'
			})).appendTo('body')
			.dialog({
				'title' : 'Bookings detail',
				'width' : '90%',
				'height' : diaH,
				modal: true,
				buttons: [ {
						text: "Close",
						click: function() { $( this ).dialog( "close" ); }
					} ]
			});
		});	
	
		$("#ag_complete").autocomplete({
			source: function (request, response) {
				// request.term is the term searched for.
				// response is the callback function you must call to update the autocomplete's 
				// suggestion list.
				$.ajax({
					url: "getAgenciesForAutoComplete/"+request.term,
					dataType: "json",
					success: response,
					error: function () {
						response([]);
					}
				});
			}
		});
	
		$("#ag_complete").on("autocompleteselect", function (e, ui) {
			e.preventDefault();
			$("#idAgente").val(ui.item.id);
			this.value = ui.item.label;
		});	

		$( "li#bobooking" ).addClass("current");
		$( "li#bobooking a" ).addClass("open");		
		$( "li#bobooking ul.sub" ).css('display','block');	
		$( "li#bobooking ul.sub li#bobooking_1" ).addClass("current");	
		
	});
	$('#searchForm').submit(function(e){
		e.preventDefault();
	});
</script>	
<?php $this -> load -> view('plused_footer'); ?>
