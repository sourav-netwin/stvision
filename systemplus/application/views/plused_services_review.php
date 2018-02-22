<?php $this->load->view('plused_header');?>
	<!-- The container of the sidebar and content box -->
	<div role="main" id="main" class="container_12 clearfix">
	
		<!-- The blue toolbar stripe -->
		<section class="toolbar">
			<div class="user">
				<div class="avatar">
					<img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
					<!-- Evidenziare per icone attenzione <span>3</span> -->
				</div>
				<span><?echo $this->session->userdata('businessname') ?></span>
				<ul>
					<li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential">Profile</a></li>
					<li class="line"></li>
					<li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
				</ul>
			</div>
		</section><!-- End of .toolbar-->
<?php $this->load->view('plused_sidebar');?>		
	<script>
	$(document).ready(function() {
		$( "li#botransport" ).addClass("current");
		$( "li#botransport a" ).addClass("open");		
		$( "li#botransport ul.sub" ).css('display','block');	
		$( "li#botransport ul.sub li#botransport_8" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<form style="margin:10px;" id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/servicesReview" method="post">  
				<h1 class="grid_12 margin-top no-margin-top-phone">Services review</h1>
				<div class="grid_3">
					<div class="box">
						<div class="header">
							<h2>Select Campus</h2>
						</div>
						<div class="content" style="margin:8px 4px;">
							<select name="centri" id="centricampus">
								<option <?if($campus==""){?>selected <?php }?>value="">All campus</option>
								<?php
									 foreach($centri as $key=>$item){?>
								 <option <?if($campus==$item['id']){?>selected <?php }?>value="<?php echo $item['id']?>"><?php echo $item['nome_centri']?></option>
								<?php 	 }
								?>
							</select> 
						</div>
					</div>
				</div>
				<div class="grid_2">
					<div class="box">
						<div class="header">
							<h2>Select Type</h2>
						</div>
						<div class="content" style="margin:8px 4px;">
							<select name="tipo" id="tipo">
								<option <?php if($tipo=="planned"){?>selected <?php }?>value="planned">Included</option>
							</select> 		
						</div>
					</div>
				</div>	
				<div class="grid_4">
					<div class="box">
						<div class="header">
							<h2>Select Range Date</h2>
						</div>
						<div class="content" style="margin:8px 4px;">						
							<label for="from">From</label>
							<input type="text" id="from" name="from" value="<?php echo $from ?>" style="width:80px;" />
							<label for="to">to</label>
							<input type="text" id="to" name="to" value="<?php echo $to ?>" style="width:80px;" />
						</div>
					</div>
				</div>	
				<div class="grid_2">
					<div class="box">
						<div class="header">
							<h2>Select Status</h2>
						</div>
						<div class="content" style="margin:8px 4px;">
							<select name="status" id="status">
								<option <?php if($status=="all"){?>selected <?php }?>value="all">All</option>							
								<option <?php if($status=="STANDBY"){?>selected <?php }?>value="STANDBY">Stand by</option>
								<option <?php if($status=="YES"){?>selected <?php }?>value="YES">Confirmed</option>
							</select> 		
						</div>
					</div>
				</div>				
				<div class="grid_1">
						<div class="content" style="margin-top:30px;text-align:center;">
							<input type="button" name="transpmi" id="transpmi" class="cercaid" value="Search" />
						</div>
				</div>	
			</form>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Services Review</h2>
					</div>
		
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[],"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": true},{"bSearchable": false,"bSortable": false},{"bSearchable": true,"bSortable": true},null]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th style="text-align:left;">Coach Company</th>								
									<th style="text-align:left;">Bus / Seats</th>
									<th style="text-align:left;">Campus</th>
									<th>Exc Date</th>
									<th style="text-align:left;">Excursion</th>
									<th>Excursion Date</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($all_services as $exc){
										$bPax = $exc["exb_tot_pax"];
										$bSeats = $exc["exb_tot_pax"];
										switch ($exc["exb_confirmed"]){
											case "YES":
												$refCOLOR = "refconfirmed";
												break;
											case "STANDBY":
												$refCOLOR = "refstandby";
											break;											
										}							
							?>
								<tr>
									<td><?php echo $exc["tra_cp_name"]?></td>
									<td>
										<span class="idofbook <?php echo $refCOLOR ?>"><?php echo $exc["pbe_rndcode"]?></span>
										<a class="viewBusList" href="javascript:openBusList('<?php echo $exc["pbe_rndcode"]?>');"><img width="16" height="16" alt="" src="http://plus-ed.com/vision_ag/img/icons/packs/fugue/16x16/information.png"></a>
									</td>
									<td class="center"><?php echo $exc["exc_centro"]?></td>
									<td class="center"><?php echo date("d/m/Y",strtotime($exc["pbe_excdate"]))?></td>
									<td class="neretto"><em><?php echo $exc["exc_excursion"]?></em><br /><?php echo $bPax ?> pax - <?php if($bPax > $bSeats){ ?><font style="color:#f00;">!! <?php } ?><?php echo $bSeats ?> seats<?php if($bPax > $bSeats){ ?> !!</font><?php } ?></td>
									<td class="center">
										<a data-gravity="s" class="button small grey dialogbtn" id="code_<?php echo $exc["pbe_rndcode"]?>" href="<?php echo base_url(); ?>index.php/backoffice/busExcDetail/code_<?php echo $exc["pbe_rndcode"]?>" title="View detail"><i class="icon-zoom-in" style="font-size:14px;"></i></a>
									</td>									
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
						<table class="styled" style="border-top:1px solid #ddd;">
						</table>						
					</div>
				</div>
			</div>
			<div style="display: none;overflow:scroll;width:800px;" id="dialog_modal_buslist" title="Bus List | Bus code" class="windia"></div>
		</section>
	</div>
<script>
$(document).ready(function(){
	$('#transpmi').click(function(){
		$('#loading-data').show();
		$('#box_transport').submit();
	});
})
</script>
  <script>
  $(document).ready(function(){
    $( "#from" ).datepicker({
      defaultDate: "+1d",
      changeMonth: true,
      numberOfMonths: 1,
	  dateFormat: "dd/mm/yy",	  
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1d",
      changeMonth: true,
      numberOfMonths: 1,
	  dateFormat: "dd/mm/yy",
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
	$( ".windia" ).dialog({
		autoOpen: false,
		modal: true,
		buttons: [{
			text: "Close",
			click: function() { $(this).dialog("close"); }
		}],
		width: 800
	});		
  });
  function openBusList(busCode){
	$("#dialog_modal_buslist").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
	$("#dialog_modal_buslist").dialog({title: "Bus List | Bus code "+busCode});
	$( "#dialog_modal_buslist" ).load('<?php echo base_url(); ?>index.php/backoffice/busDetailForExcursion/'+busCode);
  }    
  </script>
<?php $this->load->view('plused_footer');?>
