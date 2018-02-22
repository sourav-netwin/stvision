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
				<form>
					<fieldset>
					<legend>Booking <?php echo $bookYear ?>_<?php echo $bookId ?> @ <?php echo $campusName ?></legend>
						<div class="row">
							<label for="center_select">
								<strong>Select excursion</strong>
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
								<input type="hidden" name="gl_select" value="all" id="gl_select" />
							</div>
						</div>								
					</fieldset>
					<div class="actions">
						<div class="right">
							<input id="readpax" type="button" value="Retrieve students for excursion and prices" name=readpax />
						</div>
					</div><!-- End of .actions -->
				</form>
			</div>
			<div class="grid_12">
				<form>
					<fieldset>
						<legend>Group leader and students involved in extra excursion</legend>
						<div class="row" id="allstudents" style="border:0;"></div>
						<div class="row" id="allprices" style="border:0;"></div>
					</fieldset>
				</form>
			</div><!-- End of .grid_12 -->	

		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
	<script>
	$(document).ready(function() {
		$( "li#ag_excursions" ).addClass("current");
		$( "li#ag_excursions a" ).addClass("open");		
		$( "li#ag_excursions ul.sub" ).css('display','block');	
		$( "li#ag_excursions ul.sub li#ag_excursions_3" ).addClass("current");
		$("#ee_select").change(function(){
			$("#writeextra").attr("disabled","disabled");
			$("#allstudents").empty();
			$("#allprices").empty();
		});		
		$("#readpax").click(function(){
			if($("#ee_select").val()==""){
				alert("Select an excursion!");
				return false;
			}	
			$("#allstudents").html('retrieving students ...');
			$.ajax({
				type: "POST",
				data: "gluuid=" + $("#gl_select").val(),
				url: "<?php echo base_url(); ?>index.php/agents/retrieveStudentsByGl/<?php echo $bookId ?>",
				success: function(msg){
					if (msg != ''){
						$("#allstudents").html(msg).show();
						$("#writeextra").attr("disabled",false);
					}
					else{
						$("#allstudents").html('<em>No item results</em>');
					}
				}
			});
			$.ajax({
				type: "POST",
				//data: "gluuid=" + $("#gl_select").val(),
				url: "<?php echo base_url(); ?>index.php/agents/bestBusPriceForExcursion/"+$("#ee_select").val()+"/<?php echo $allNum ?>/<?php echo $stdNum ?>",
				success: function(msg){
					if (msg != ''){
						arrMsg = msg.split("___");
						$("#passNUMSTD").val(arrMsg[0]);
						$("#passPRICESTD").val(arrMsg[1]);
						$("#passCURRENCY").val(arrMsg[2]);
						$("#allprices").html("<p><b>Price per pax (only Students): <font style='color:#f00;'>"+arrMsg[1]+" "+arrMsg[2]+"</font></b></p>").show();
					}
					else{
						$("#allprices").html('<em>No prices retrieved</em>');
					}
				}
			});	
		});
	
	});

	
	</script>	
<?php $this->load->view('plused_footer');?>
