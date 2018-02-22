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
		
		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>	
			<div class="grid_12">
				<form id="falseForm">
					<fieldset>
					<legend>View/Book attractions for booking <?php echo $bookTitle ?> - <?php echo $agencyName ?></legend>
					<input type="hidden" id="gl_select" name="gl_select" value="all" />
						<div class="row">
							<label for="center_select">
								<strong>Attractions</strong>
							</label>
							<div>
								<select name=ee_select id=ee_select class="search required" data-placeholder="Choose an attraction">
									<option value=""></option>
									<?php
									foreach($excursions as $exc){
									?>
									<option value="<?php echo $exc["pat_id"] ?>"><?php echo ucfirst($exc["pat_name"]) ?> (<?php echo ucfirst($exc["patt_name"]) ?>)  <?php echo $exc["cou_descrizione"] ?> | <?php echo $exc["cit_descrizione"] ?></option> 
									<?php
									}
									?>								
								</select>
							</div>
						</div>
						<div id="rowAmount" class="row" style="display:none;">
							<label for="center_select">
								<strong>Amount received</strong> <span id="retrievedCurr"></span>
							</label>
							<div>
								<input type="text" name="amountRec" id="amountRec" value="0,00">
							</div>
						</div>
						<div class="row" id="complprices" style="border:0;"></div>
						<div class="row" id="allprices" style="border:0;"></div>	
					<input type="hidden" name="passTOTPAX" id="passTOTPAX" value="<?php echo $numALL ?>" />
					<input type="hidden" name="passPRICE" id="passPRICE" value="" />
					<input type="hidden" name="passCURRENCY" id="passCURRENCY" value="" />	
					<input type="hidden" name="passCAMPUS" id="passCAMPUS" value="<?php echo $idCampus ?>" />	
					<input type="hidden" name="passATTR" id="passATTR" value="" />					
					</fieldset>
					<div class="actions">
						<div class="right">
							<input type="button" class="blue bookForGroup" value="Book this attraction for group <?php echo $bookTitle ?>" name="bookExc" />
						</div>
					</div><!-- End of .actions -->
				</form>
			</div>

		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
	<script>
	$(document).ready(function() {
		$("#ee_select").val("");
		$("#passPRICE").val("");
		$("#passCURRENCY").val("");
		$("#passATTR").val("");
		$( "li#cabookings" ).addClass("current");
		$( "li#cabookings a" ).addClass("open");		
		$( "li#cabookings ul.sub" ).css('display','block');	
		$( "li#cabookings ul.sub li#cabookings_1" ).addClass("current");	
		
		$(".bookForGroup").click(function(){
			var valoreE = $("#ee_select").val();
			if(valoreE==""){
				alert("You have to select an attraction from the list!");
				return void(0);
			}else{
				var patt = /^[0-9]+\,[0-9][0-9]$/;
				var result = patt.test($("#amountRec").val());
				if(!result){
					alert("You have to insert an amount with two decimal places, comma separated");
					return void(0);
				}else{
					if(confirm("Are you sure you want to book this attraction for the selected group declairing to have received an amount of "+$("#amountRec").val()+" "+$("#passCURRENCY").val()+" from the agent?")){
						window.location.replace("<?php echo base_url(); ?>index.php/backoffice/bookCA_AttractionForGroup/bookExc_<?php echo $bookId ?>_<?php echo $yearId ?>_"+$("#ee_select").val()+"_<?php echo $idCampus ?>_<?php echo $numALL ?>_"+$("#passPRICE").val().replace(",","comma")+"_"+$("#passCURRENCY").val()+"_"+$("#amountRec").val().replace(",","comma"));
					}
				}
			}
		});
		$("#ee_select").change(function(){
			$("#passATTR").val($(this).val());						
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>index.php/backoffice/ca_getPriceForAttraction/"+$(this).val()+"/<?php echo $numGL ?>/<?php echo $numSTD ?>",
				success: function(msg){
					if (msg != ''){
						$("#rowAmount").show();
						arrMsg = msg.split("___");
						priceForGL = (arrMsg[0].replace(",",".")*1).toFixed(2).replace(".",",");
						priceForSTD = (arrMsg[1].replace(",",".")*1).toFixed(2).replace(".",",");
						totalPrice = ((arrMsg[1].replace(",",".")*1)+(arrMsg[0].replace(",",".")*1)+10*1).toFixed(2).replace(".",",");
						$("#passPRICE").val(totalPrice);
						$("#passCURRENCY").val(arrMsg[2]);
						$("#retrievedCurr").html("("+arrMsg[2]+")");
						$("#complprices").html("<p><b>Group leader total price: <font style='color:#f00;'>"+priceForGL+" "+arrMsg[2]+"</font> (for <?php echo $numGL ?> GL)</b></p><p><b>Students total price: <font style='color:#f00;'>"+priceForSTD+" "+arrMsg[2]+"</font> (for <?php echo $numSTD ?> STD)</b></p><p><b>Fee: <font style='color:#f00;'>10,00 "+arrMsg[2]+"</font></b></p>").show();
						$("#allprices").html("<p><b>Total price: <font style='color:#f00;'>"+totalPrice+" "+arrMsg[2]+"</font></b></p>").show();
					}
					else{
						("#complprices").html('');
						$("#allprices").html('<em>No prices retrieved</em>');
					}
				}
			});	
		});
		
	});

	
	</script>	
<?php $this->load->view('plused_footer');?>
