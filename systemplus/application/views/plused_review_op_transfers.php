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
		$( "li#botransfers" ).addClass("current");
		$( "li#botransfers a" ).addClass("open");		
		$( "li#botransfers ul.sub" ).css('display','block');	
		$( "li#botransfers ul.sub li#botransfers_4" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<form style="margin:10px;" id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/reviewOpTransfers" method="post">  
				<h1 class="grid_12 margin-top no-margin-top-phone">Review transfers</h1>
				<div class="grid_5">
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
				<div class="grid_5">
					<div class="box">
						<div class="header">
							<h2>Select Company</h2>
						</div>
						<div class="content" style="margin:8px 4px;">
							<select name="companies" id="centricompanies">
								<option <?if($company==""){?>selected <?php }?>value="">All companies</option>
								<?php
									 foreach($companies as $key=>$item){?>
								 <option <?if($company==$item['tra_cp_id']){?>selected <?php }?>value="<?php echo $item['tra_cp_id']?>"><?php echo $item['tra_cp_name']?></option>
								<?php 	 }
								?>
							</select> 
						</div>
					</div>
				</div>	
				<div class="grid_2">
						<div class="content" style="margin-top:30px;text-align:center;">
							<input type="button" name="transpmi" id="transpmi" class="cercaid" value="Search" />
						</div>
				</div>	
			</form>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">View booked transfers</h2>
					</div>
		
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[],"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Reference Code</th>
									<th>Transfer Date</th>
									<th>Company</th>
									<th>Campus</th>
									<th>Type</th>
									<th>Airport</th>
									<th>Detail</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							$totalefiltro = 0;
							foreach($all_transfers as $exc){
							?>
								<tr>
									<td class="center">
										<span class="idofbook"><?php echo $exc["pbe_rndcode"]?></span>
										<a class="viewBusList" href="javascript:openBusList('<?php echo $exc["pbe_rndcode"]?>');"><img width="16" height="16" alt="" src="http://plus-ed.com/vision_ag/img/icons/packs/fugue/16x16/information.png"></a>
									</td>
									<td class="center"><?php echo date("d/m/Y",strtotime($exc["pbe_excdate"]))?></td>
									<td class="center"><?php echo $exc["tra_cp_name"]?></td>
									<td class="center"><?php echo $exc["nome_centri"]?></td>	
									<td class="center">
									<?php 
										if($exc["ptt_type"]=="inbound"){ 
									?>
										<font style="color:#009900;font-weight:bold;">INBOUND</font>
									<?php
										}
									?>									
									<?php 
										if($exc["ptt_type"]=="outbound"){ 
									?>
										<font style="color:#990000;font-weight:bold;">OUTBOUND</font>
									<?php
										}
									?>	
									</td>									
									<?php 
										if($exc["ptt_type"]=="inbound"){ 
									?>
										<td class="center"><?php echo $exc["ptt_airport_to"]?></td>
									<?php
										}else{
									?>
										<td class="center"><?php echo $exc["ptt_airport_from"]?></td>
									<?php
										}
									?>
									<td class="center">
										<a data-gravity="s" class="button small grey dialogbtn" id="code_<?php echo $exc["pbe_rndcode"]?>" href="<?php echo base_url(); ?>index.php/backoffice/busTraDetail/code_<?php echo $exc["pbe_rndcode"]?>" title="View detail"><i class="icon-zoom-in" style="font-size:14px;"></i></a><br />
									</td>									
								</tr>
							<?php
								$totalefiltro += $exc["totalone"];
								}
							?>
							</tbody>
						</table>
						<table class="styled" style="border-top:1px solid #ddd;"><?php echo $totalefiltro ?>
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
