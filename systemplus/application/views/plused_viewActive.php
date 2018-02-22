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
		$( "li#boaccounting" ).addClass("current");
		$( "li#boaccounting a" ).addClass("open");		
		$( "li#boaccounting ul.sub" ).css('display','block');	
		$( "li#boaccounting ul.sub li#boaccounting_1" ).addClass("current");	
		$( ".dialogbtn" ).click(function() {
				var iddia = $(this).attr("id").replace('_btn','');
				//alert(iddia.replace('_btn',''));
				$( "#"+iddia ).dialog("open");
				return false;
		});
		$( ".windia" ).dialog({
				autoOpen: false,
				modal: true,
				buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}]
		});
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<h1 class="grid_12 margin-top no-margin-top-phone">Clear active booking</h1>
			<div class="grid_4">
				<div class="box">
					<div class="header">
						<h2>Select Campus</h2>
					</div>
					<div class="content">
							<form style="margin:10px;" id="box_campus" name="box_campus" action="<?php echo base_url(); ?>index.php/bo_accounting/view_active" method="post">  
										<select name="centri" id="centricampus">
												<option <?if($campus=="all"){?>selected <?php }?>value="all">All campus</option>
										<?php
											 foreach($centri as $key=>$item){?>
											 <option <?if($campus==$item['id']){?>selected <?php }?>value="<?php echo $item['id']?>"><?php echo $item['nome_centri']?></option>
										<?php 	 }
										?>
									</select> 
							<input type="hidden" name="date_in" value="<?php echo $datafrom;?>">  
							<input type="hidden" name="date_out" value="<?php echo $datato;?>">
							<input type="hidden" name="agenzia_in" value="<?php echo $agenziefrom;?>">  
							</form>					
					</div>
				</div>
			</div>
			<div class="grid_4">
				<div class="box">
					<div class="header">
						<h2>Select Agency</h2>
					</div>
					<div class="content">
							<form style="margin:10px;" id="box_agency" name="box_agency" action="<?php echo base_url(); ?>index.php/bo_accounting/view_active" method="post">  
										<select name="agenzia_in" id="agenzia_in">
												<option <?php if($agenziefrom=="all"){?>selected <?php }?>value="all">All agencies</option>
										<?php
											 foreach($tutte_agenzie as $key=>$item){?>
											 <option <?php if($agenziefrom==$item['id']){?>selected <?php }?>value="<?php echo $item['id']?>"><?php echo $item['businessname']?></option>
										<?php 	 }
										?>
									</select> 
								  <input type="hidden" name="centri" value="<?php echo $campus;?>">
							<input type="hidden" name="date_in" value="<?php echo $datafrom;?>">  
							</form>				
					</div>
				</div>
			</div>
			<div class="grid_4">
				&nbsp;
			</div>				
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Clear active booking</h2>
					</div>
					<form name="clear_records" id="clear_records" action="<?php echo base_url(); ?>index.php/bo_accounting/clear_records" method="POST">
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="dynamic styled" data-table-tools='{"display":false}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Booking Ref.</th>
									<th>Select</th>									
									<th>Deposit</th>
									<th>Payment</th>
									<th>Payment date</th>
									<th>Notes</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($all_books as $book){
								$da=explode("-",$book["arrival_date"]);
								$dd=explode("-",$book["departure_date"]);
								$accos=$book["all_acco"];
								$agdett=$book["agency"][0];
							?>
								<tr>
									<td class="center"><?php echo $book["id_year"]?>_<?php echo $book["id_book"]?> - <?php echo $book["centro"]?><br /><?php echo $da[2]?>/<?php echo $da[1]?>/<?php echo $da[0]?> - <?php echo $dd[2]?>/<?php echo $dd[1]?>/<?php echo $dd[0]?><input style="width:50px;" class="edit-pax" type="hidden" name="pax-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" id="pax-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" value="<?php echo $book["tot_pax"]?>" /><br /><strong><?php echo $agdett["businessname"]?></strong><br /><a href="javascript:void(0);" id="dialog_modal_btn_<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" class="dialogbtn">[View]</a> 
									<div style="display: none;" id="dialog_modal_<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" title="Booking detail - <?php echo $book["id_year"]?>_<?php echo $book["id_book"]?> - <?php echo $book["centro"]?>" class="windia">
										<p><strong>Date in: </strong><?php echo $da[2]?>/<?php echo $da[1]?>/<?php echo $da[0]?><br /><strong>Date out: </strong><?php echo $dd[2]?>/<?php echo $dd[1]?>/<?php echo $dd[0]?></p>
										<p><strong>Weeks: </strong><?php echo $book["weeks"]?></p>
										<p><strong>Accomodations</strong></p>
										<p>
											<ul>
										<?php
											foreach($accos as $acco){
												$tipo=$acco->tipo_pax;
												$accom=$acco->accomodation;
												$contot=$acco->contot;
										?>
											<li><strong><?php echo $tipo ?>: </strong><?php echo $accom ?>(<?php echo $contot ?>)</li>
										<?php
											}
										?>
											</ul>
										</p>
									</div></td>
									<td class="center"><input class="check-book" type="checkbox" name="clear-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" id="clear-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" /></td>
									<?php
										$costocampus=$book['valore_acconto'];
									?>
									<td style="text-align:center;padding:0;">
										<input type="hidden" name="costocampus-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" id="costocampus-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" value="<?php echo $costocampus*1?>" />
										<input type="hidden" name="valuta-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" id="valuta-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" value="<?php echo $book['valuta']?>" />
										<input style="text-align:right;width:60px;" class="edit-deposit" type="text" name="deposit-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" id="deposit-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" value="<?php echo $book['tot_pax']*$costocampus; ?>" /><span><?php echo $book['valuta']?></span>
									</td>	
									<td class="center">
										<select name="payment-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" id="payment-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>">
											<?php
												 foreach($payTypes as $key=>$item){?>
												 <option value="<?php echo $item['pfcpt_name']?>"><?php echo $item['pfcpt_name']?></option>
											<?php 	 }
											?>
										</select>
									</td>
									<td class="center"><input type="text" value="" class="currencyD" name="currencyDate-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" id="currencyDate-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" style="width:70px;margin:5px 10px 10px 25px;"></td>
									<td class="center"><input style="width:90%;" type="text" placeholder="Insert notes here" name="notes-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" id="notes-<?php echo $book['id_year']?>_<?php echo $book['id_book']?>" value="" /></td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>	
						<table class="styled" >
							<tfoot>
								<tr>
									<td style="text-align:right;"><button class="button red block" id="clear_all" name="clear_all" class="alt_btn">Confirm cleared bookings</button></td>
								</tr>
							</tfoot>
						</table>
					</div><!-- End of .content -->
					</form>
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->
		</section><!-- End of #content -->
	</div><!-- End of #main -->
<script>
$(document).ready(function(){
	$('#centricampus').change(function(){
		$('#loading-data').show();
		$('#box_campus').submit();
	});
	$('#agenzia_in').change(function(){
		$('#loading-data').show();
		$('#box_agency').submit();
	});
	$('#clear_all').click(function(e){
		e.preventDefault();
		var nbook = $('.check-book:checked').length;
		if(nbook <= 0){
			alert("Check at least ONE booking to clear!");
		}else{
			if(confirm("Really want to clear the checked bookings? Only the visible bookings will be cleared!")){
				$('#clear_records').submit();	
			}
		}
	});	
	$( ".currencyD" ).datepicker({
			defaultDate: "+1d",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "yy-mm-dd",		
			numberOfMonths: 1,
	});

	
})
</script>
<?php $this->load->view('plused_footer');?>
