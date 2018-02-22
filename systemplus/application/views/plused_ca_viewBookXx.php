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
					<legend>View/Book extra excursions for booking <?php echo $bookTitle ?> - <?php echo $agencyName ?></legend>
					<input type="hidden" id="gl_select" name="gl_select" value="all" />
						<div class="row">
							<label for="center_select">
								<strong>Extra excursion</strong>
							</label>
							<div>
								<select name=ee_select id=ee_select class="search required" data-placeholder="Choose an excursion">
									<option value=""></option>
									<?php
									foreach($excursions as $exc){
									?>
									<option value="<?php echo $exc["exc_id"] ?>"><?php echo ucfirst($exc["exc_length"]) ?> - <?php echo $exc["exc_excursion"] ?></option> 
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
					<input type="hidden" name="passNUMSTD" id="passNUMSTD" value="" />
					<input type="hidden" name="passPRICESTD" id="passPRICESTD" value="" />
					<input type="hidden" name="passCURRENCY" id="passCURRENCY" value="" />						
					</fieldset>
					<div class="actions">
						<div class="right">
							<input type="button" class="blue bookForGroup" value="Book this excursion for group <?php echo $bookTitle ?>" name="bookExc" />
						</div>
					</div><!-- End of .actions -->
				</form>
			</div>

		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
	<script>
	$(document).ready(function() {
		$("#ee_select").val("");
		$("#passNUMSTD").val("");
		$("#passPRICESTD").val("");
		$("#passCURRENCY").val("");
		$( "li#cabookings" ).addClass("current");
		$( "li#cabookings a" ).addClass("open");		
		$( "li#cabookings ul.sub" ).css('display','block');	
		$( "li#cabookings ul.sub li#cabookings_1" ).addClass("current");	
		
		$(".bookForGroup").click(function(){
			var valoreE = $("#ee_select").val();
			if(valoreE==""){
				alert("You have to select an excursion from the list!");
				return void(0);
			}else{
				var patt = /^[0-9]+\,[0-9][0-9]$/;
				var result = patt.test($("#amountRec").val());
				if(!result){
					alert("You have to insert an amount with two decimal places, comma separated");
					return void(0);
				}else{
					if(confirm("Are you sure you want to book this excursion for the selected group declairing to have received an amount of "+$("#amountRec").val()+" "+$("#passCURRENCY").val()+" from the agent?")){
						window.location.replace("<?php echo base_url(); ?>index.php/backoffice/bookCA_ExtraExcursionForGroup/bookExc_"+$("#ee_select").val()+"_<?php echo $bookId ?>_noCode_"+$("#amountRec").val().replace(",","comma"));
					}
				}
			}
		});
		$("#ee_select").change(function(){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>index.php/agents/bestBusPriceForExcursion/"+$(this).val()+"/<?php echo $numALL ?>/<?php echo $numSTD ?>",
				success: function(msg){
					if (msg != ''){
						$("#rowAmount").show();
						arrMsg = msg.split("___");
						$("#passNUMSTD").val(arrMsg[0]);
						$("#passPRICESTD").val(arrMsg[1]);
						$("#passCURRENCY").val(arrMsg[2]);
						$("#retrievedCurr").html("("+arrMsg[2]+")");
						$("#complprices").html("<p><b>Excursion total price: <font style='color:#f00;'>"+(arrMsg[1].replace(",",".")*<?php echo $numSTD ?>).toFixed(2).replace(".",",")+" "+arrMsg[2]+"</font></b></p>").show();
						$("#allprices").html("<p><b>Price per pax (only Students): <font style='color:#f00;'>"+arrMsg[1]+" "+arrMsg[2]+"</font></b></p>").show();
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
