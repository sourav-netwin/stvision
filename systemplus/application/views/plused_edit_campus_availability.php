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
			<input type="search" data-source="extras/search.php" placeholder="Search..." autocomplete="off" class="tooltip" title="e.g. Canterbury" data-gravity=s>
		</section><!-- End of .toolbar-->	
	
<?php $this->load->view('plused_sidebar');?>		
		
		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<form action="<?php echo base_url(); ?>index.php/backoffice/insertCampusAvailability" name="ca_form" id="ca_form" class="grid12" method="POST">
					<fieldset>
					<legend>Campus</legend>
						<div class="row">
							<label for="center_select">
								<strong>Center</strong>
							</label>
							<div>
								<select name=center_select id=center_select class="search required" data-placeholder="Choose a destination">
									<option value=""></option>
								   <?php
									 if (count($centri)){
										foreach($centri as $key=>$item){ ?>
									<option value="<?php echo $item['id'];?>"><?php echo $item['nome_centri'];?></option> 
									<?php 
										}
									 }
									?>									
								</select>
							</div>
						</div>								
					</fieldset>
					<fieldset>
					<legend>Accomodations availability</legend>
						<div class="row" id="row_st_en" style="display:none;">
							<label for="st_ensuite">
								<strong>Ensuite</strong>
							</label>
							<div>
								<input class="contastudenti" data-type="spinner" name=st_ensuite id=st_ensuite value="0" min="0" max="1500" />
							</div>
						</div>	
						<div class="row" id="row_st_st" style="display:none;">
							<label for="st_standard">
								<strong>Standard</strong>
							</label>
							<div>
								<input class="contastudenti" data-type="spinner" name=st_standard id=st_standard value="0" min="0" max="1500" />
							</div>
						</div>	
						<div class="row" id="row_st_ho" style="display:none;">
							<label for="st_homestay">
								<strong>Homestay</strong>
							</label>
							<div>
								<input class="contastudenti" data-type="spinner" name=st_homestay id=st_homestay value="0" min="0" max="1500" />
							</div>
						</div>							
					</fieldset>	
					<fieldset>
					<legend>Start/finish availability period</legend>
					<div class="row">
						<label for="arrival_date">
							<strong>Start date</strong>
						</label>
						<div>
							<div data-type="date" data-id=arrival_date data-name=arrival_date data-show-button-panel=false data-number-of-months=3 data-min-date="06/01/2014"  data-max-date="09/30/2014" data-alt-field="#adate" data-alt-format="dd/mm/yy" data-alt-default-date=""></div>
						</div>
					</div>	
					<div class="row">
						<label for="departure_date">
							<strong>Finish date</strong>
						</label>
						<div>
							<div data-type="date" data-id=departure_date data-name=departure_date data-show-button-panel=false data-number-of-months=3 data-min-date="06/01/2014"  data-max-date="10/31/2014" data-alt-field="#ddate" data-alt-format="dd/mm/yy" data-alt-default-date=""></div>
						</div>
					</div>	
					<div class="row">
						<label>
							<strong>Availability summary</strong>
						</label>
						<div>
							<table>
								<tr><td>Total availability: </td><td><input type="text" id="sum_stud" value="0" readonly /></td></tr>
								<tr><td>Start date: </td><td><input type="text" id="adate" value="0" readonly /></td></tr>
								<tr><td>Finish date: </td><td><input type="text" id="ddate" value="0" readonly></td></tr>
							</table>
						</div>
					</div>					
				</fieldset>	
					<div id="accomodations" style="display:none;"></div>
					<div class="actions">
						<div class="left">
							<input type="reset" value="Cancel" />
						</div>
						<div class="right">
							<input id="writebook" type="button" value="Submit" name=writebook />
						</div>
					</div><!-- End of .actions -->
				</form>
			</div><!-- End of .grid_12 -->	

		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
	<script>
	$(document).ready(function() {
		$( "li#bocampus" ).addClass("current");
		$( "li#bocampus a" ).addClass("open");		
		$( "li#bocampus ul.sub" ).css('display','block');	
		$( "li#bocampus ul.sub li#bocampus_1" ).addClass("current");	
		$( "#center_select" ).change(function(){
			$.ajax({
				type: "POST",
				data: "idcentro=" + $(this).val(),
				url: "<?php echo base_url(); ?>index.php/agents/findAccoByCenter",
				success: function(msg){
					if (msg != ''){
						$("#accomodations").html(msg).show();
					}
					else{
						$("#accomodations").html('<em>No item result</em>');
					}
				}
			});
			$("#row_st_en").hide();
			$("#row_st_st").hide();
			$("#row_st_ho").hide();
			$("#st_ensuite").val(0);
			$("#st_standard").val(0);
			$("#st_homestay").val(0);
			$("#sum_stud").val(0);
		});
		
		$( ".contastudenti" ).blur(function(){
			var studval = $("#st_ensuite").val()*1+$("#st_standard").val()*1+$("#st_homestay").val()*1;
			$("#sum_stud").val(studval);
		});
	
		
		$("#writebook").click(function(){
			var giornitotali = daydiff(parseDate($('#adate').val()), parseDate($('#ddate').val()))*1;
			//alert(giornitotali);

			if($("#center_select").val()==""){
				alert("Select a center!");
				return false;
			}		
			if($("#sum_stud").val()=="0"){
				alert("No availability inserted!");
				return false;
			}	
			if($("#arrival_date").val()==""){
				alert("No start date selected!");
				return false;
			}
			if($("#departure_date").val()==""){
				alert("No finish date selected!");
				return false;
			}	
			if(giornitotali<=0){
				alert("Please verify selected dates: "+giornitotali+"day(s) interval!");
				return false;
			}		
			document.getElementById("ca_form").submit();			
		});
	});
	function parseDate(str) {
		var mdy = str.split('/')
		return new Date(mdy[2], mdy[1], mdy[0]-1);
	}

	function daydiff(first, second) {
		return (second-first)/(1000*60*60*24)
	}
	
	</script>	
<?php $this->load->view('plused_footer');?>
