<?php $this -> load -> view('plused_header'); ?>
<style type="text/css">
	@media(max-width: 650px){
		.box{
			margin-bottom: 10px !important;
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
		<h1 class="grid_12 margin-top no-margin-top-phone">Review Campus by Date</h1>
		<div class="grid_3">
			<div class="box">
				<div class="header">
					<h2>Select Date</h2>
				</div>
				<div class="content" style="padding:10px;text-align:center;height:68px;">
					<input type="text" readonly id="dateStart" name="dateStart" value="" style="cursor:pointer;" />		
				</div>
			</div>
		</div>	
		<div class="grid_3">
			<div class="box">
				<div class="header">
					<h2>Retrieve data</h2>
				</div>
				<div class="content" style="padding:10px;text-align:center;height:68px;">
					<input type="button" name="inviaO" id="inviaO" value="Retrieve Data" />			
				</div>
			</div>
		</div>
	</section>	
</div>
<div style="display: none;overflow:scroll;width:100px;" id="dialog_modal" title="Pax List | Booking detail  (Please set orientation to LANDSCAPE before print!)" class="windia"></div>
<div style="display: none;overflow:scroll;width:800px;" id="dialog_modal_tra" title="Transfers | Bus codes details" class="windia_tra"></div>						
<div style="display: none;overflow:scroll;width:800px;" id="dialog_modal_exc" title="Planned Excursions | Bus codes details" class="windia_exc"></div>					
<div style="display: none;overflow:scroll;width:800px;" id="dialog_modal_exc_extra" title="Extra Excursions | Bus codes details" class="windia_exc_extra"></div>
<input type="hidden" value="" name="hidDate" id="hidDate" />
<input type="hidden" value="" name="typeForCsv" id="typeForCsv" />
<input type="hidden" value="" name="accoForCsv" id="accoForCsv" />
<input type="hidden" value="" name="accoForChList" id="accoForChList" />
<input type="hidden" value="" name="accoForBook" id="accoForBook" />
<input type="hidden" value="" name="transDate" id="transDate" />
<script src="<?php echo base_url() ?>js/jquery.browser.min.js"></script>	
<script src="<?php echo base_url() ?>js/jquery.printElement.min.js"></script>
<script>
	$(document).ready(function() {
		
		$( ".windia" ).dialog({
			autoOpen: false,
			modal: true,
			buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				},{
					text: "Print",
					click: function() { $(".windia table").printElement(); }
				},{
					text: "Export as Excel file",
					click: function() {
						var myHidDate = window.parent.$("#hidDate").val().replace(/\-/g,'');
						//var myHidDate = window.parent.$("#hidDate").val();
						var myTypeForCsv = window.parent.$("#typeForCsv").val();
						var myAccoForCsv = window.parent.$("#accoForCsv").val();
						var myAccoForChList = window.parent.$("#accoForChList").val();
						var myAccoForBook = window.parent.$("#accoForBook").val();
						if(myTypeForCsv == ''){
							myTypeForCsv = 'null';
						}
						if(myAccoForChList == ''){
							myAccoForChList = 'null';
						}
						window.location.href = '<?php echo base_url(); ?>index.php/backoffice/csvArrivalPax_pax/<?php echo $campus ?>/'+myAccoForCsv+'/'+myHidDate+'/confirmed/'+myTypeForCsv+'/'+myAccoForChList+'/'+myAccoForBook;
					}
				}],
			height : 600,
			width: 1300
		});
		$( ".windia_tra" ).dialog({
			autoOpen: false,
			modal: true,
			buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				},{
					text: "Print",
					click: function() { $(".windia_tra #printDiv").printElement(); }
				},{
					text: "Export as Excel file",
					click: function() {
						var myTransDate = window.parent.$("#transDate").val();
						window.location.href = '<?php echo base_url(); ?>index.php/backoffice/csvTrasferBus_pax/<?php echo $campus ?>/'+myTransDate;
					}
				}],
			height : 600,
			width: 1300
		});
			

		$( ".windia_exc" ).dialog({
			autoOpen: false,
			modal: true,
			buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}],
			height : 500,
			width: 800
		});	

		$( ".windia_exc_extra" ).dialog({
			autoOpen: false,
			modal: true,
			buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}],
			height : 500,
			width: 800
		});			
		$( "li#campus_ca" ).addClass("current");
		$( "li#campus_ca a" ).addClass("open");		
		$( "li#campus_ca ul.sub" ).css('display','block');	
		$( "li#campus_ca ul.sub li#campus_ca_2" ).addClass("current");	
		
		$( "#dateStart" ).datepicker({
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",
			maxDate: "+1Y"
		}).datepicker("setDate", new Date());
		
		$('#inviaO').on('click', function(e){
			var selDate = $('#dateStart').val();
			if(selDate == '' || typeof selDate == 'undefined'){
				alert('Please select a date');
				return false;
			}
			var selDateAct = selDate;
			selDate = selDate.replace(/\//g, '-');
			var diaH = $(window).height()* 0.9;
			e.preventDefault();
			$('<div/>', {'class':'myDlgRevDate', 'style' :'background:#fff url(<?php echo base_url(); ?>img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
            .html($('<iframe/>', {
                'src' : "<?php echo site_url(); ?>/backoffice/reviewByDate/"+encodeURI(selDate),
                'style' :'width:100%; height:100%;border:none;'
            })).appendTo('body')
            .dialog({
                'title' : 'Review by date - '+selDateAct,
                'width' : '90%',
                'height' : diaH,
                modal: true,
                buttons: [ {
						text: "Close",
						click: function() { $( this ).dialog( "close" ); }
					} ]
            });
		});
		
	});
</script>	
<?php $this -> load -> view('plused_footer'); ?>
