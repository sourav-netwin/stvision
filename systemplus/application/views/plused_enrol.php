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
				<form action="<?php echo base_url(); ?>index.php/agents/insertGroup" name="enrolform" id="enrolform" class="grid12" method="POST">
					<fieldset>
					<legend>Product and destination</legend>
						<div class="row">
							<label for="prod_select">
								<strong>Product</strong>
							</label>
							<div>
								<select name=prod_select id=prod_select class="search required" data-placeholder="Choose a product">
									<option value=""></option>
									<option value="1">Plus Junior Summer</option> 
								</select>
							</div>
						</div>	
						<div class="row">
							<label for="center_select">
								<strong>Center</strong>
							</label>
							<div>
								<select name=center_select id=center_select class="search required" data-placeholder="Choose a destination">
									<option value=""></option>
								   <?php
									 if (count($centri)){
										foreach($centri as $key=>$item){ 
											if($item["attivo"]==1){ ?>
									<option value="<?php echo $item['id'];?>"><?php echo $item['nome_centri'];?></option> 
									<?php 
											}
										}
									 }
									?>									
								</select>
							</div>
						</div>								
					</fieldset>
					<fieldset>
					<legend>Students accomodations</legend>
						<div class="row" id="row_st_en" style="display:none;">
							<label for="st_ensuite">
								<strong>Ensuite</strong>
							</label>
							<div>
								<input class="contastudenti" data-type="spinner" name=st_ensuite id="st_ensuite" value="0" min="0" max="500" />
							</div>
						</div>	
						<div class="row" id="row_st_st" style="display:none;">
							<label for="st_standard">
								<strong>Standard</strong>
							</label>
							<div>
								<input class="contastudenti" data-type="spinner" name=st_standard id=st_standard value="0" min="0" max="500" />
							</div>
						</div>	
						<div class="row" id="row_st_ho" style="display:none;">
							<label for="st_homestay">
								<strong>Homestay</strong>
							</label>
							<div>
								<input class="contastudenti" data-type="spinner" name=st_homestay id=st_homestay value="0" min="0" max="500" />
							</div>
						</div>		
						<div class="row" id="row_st_tw" style="display:none;">
							<label for="st_twin">
								<strong>Twin</strong>
							</label>
							<div>
								<input class="contastudenti" data-type="spinner" name=st_twin id=st_twin value="0" min="0" max="500" />
							</div>
						</div>						
					</fieldset>	
					<fieldset>
					<legend>Group leaders accomodations</legend>
						<div class="row" id="row_gl_en" style="display:none;">
							<label for="gl_ensuite">
								<strong>Ensuite</strong>
							</label>
							<div>
								<input class="contagl" data-type="spinner" name=gl_ensuite id=gl_ensuite value="0" min="0" max="100" />
							</div>
						</div>	
						<div class="row" id="row_gl_st" style="display:none;">
							<label for="gl_standard">
								<strong>Standard</strong>
							</label>
							<div>
								<input class="contagl" data-type="spinner" name=gl_standard id=gl_standard value="0" min="0" max="100" />
							</div>
						</div>	
						<div class="row" id="row_gl_ho" style="display:none;">
							<label for="gl_homestay">
								<strong>Homestay</strong>
							</label>
							<div>
								<input class="contagl" data-type="spinner" name=gl_homestay id=gl_homestay value="0" min="0" max="100" />
							</div>
						</div>	
						<div class="row" id="row_gl_tw" style="display:none;">
							<label for="gl_twin">
								<strong>Twin</strong>
							</label>
							<div>
								<input class="contagl" data-type="spinner" name=gl_twin id=gl_twin value="0" min="0" max="100" />
							</div>
						</div>							
					</fieldset>	
				<fieldset>
					<legend>Arrival/departure dates and number of weeks on campus</legend>
					<div class="row">
						<label for="n_weeks">
							<strong>Weeks</strong>
						</label>
						<div>
							<input data-type="spinner" min=1 max=4 value=1 id=n_weeks name=n_weeks />
						</div>
					</div>						
					<div class="row">
						<label for="arrival_date">
							<strong>Arrival date</strong>
						</label>
						<div>
						<div class="row" id="alldates" style="border:0;color:#f00;"></div>
							<div data-type="date" data-id=arrival_date data-name=arrival_date data-show-button-panel=false data-number-of-months=3 data-min-date="06/01/2016"  data-max-date="09/30/2016" data-alt-field="#adate" data-alt-format="dd/mm/yy" data-alt-default-date=""></div>
						</div>
					</div>	
					<div class="row">
						<label for="departure_date">
							<strong>Departure date</strong>
						</label>
						<div>
							<div data-type="date" data-id=departure_date data-name=departure_date data-show-button-panel=false data-number-of-months=3 data-min-date="06/01/2016"  data-max-date="10/31/2016" data-alt-field="#ddate" data-alt-format="dd/mm/yy" data-alt-default-date=""></div>
						</div>
					</div>	
					<div class="row">
						<label>
							<strong>Enrol summary</strong>
						</label>
						<div>
							<table>
								<tr><td>Students total: </td><td><input type="text" id="sum_stud" value="0" readonly /></td></tr>
								<tr><td>Group Leader total: </td><td><input type="text" id="sum_gl" value="0" readonly /></td></tr>
								<tr><td>Arrival date: </td><td><input type="text" id="adate" value="0" readonly /></td></tr>
								<tr><td>Departure date: </td><td><input type="text" id="ddate" value="0" readonly></td></tr>
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
		$( "li#enrol" ).addClass("current");
		$( "li#enrol a" ).addClass("open");		
		$( "li#enrol ul.sub" ).css('display','block');	
		$( "li#enrol ul.sub li#enrol_1" ).addClass("current");	
		$( "#center_select" ).change(function(){
			//alert($(this).val());
			$("#alldates").html('searching dates ...');
			$.ajax({
				type: "POST",
				data: "idcentro=" + $(this).val(),
				url: "<?php echo base_url(); ?>index.php/agents/findDatesByCenter",
				success: function(msg){
					if (msg != ''){
						$("#alldates").html(msg).show();
					}
					else{
						$("#alldates").html('<em>No item result</em>');
					}
				}
			});
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
			$("#row_st_tw").hide();
			$("#row_gl_en").hide();
			$("#row_gl_st").hide();
			$("#row_gl_ho").hide();
			$("#row_gl_tw").hide();
			$("#st_ensuite").val(0);
			$("#st_standard").val(0);
			$("#st_homestay").val(0);
			$("#st_twin").val(0);
			$("#gl_ensuite").val(0);
			$("#gl_standard").val(0);
			$("#gl_homestay").val(0);
			$("#gl_twin").val(0);
			$("#sum_stud").val(0);
			$("#sum_gl").val(0);			
		});
		
		$( ".contastudenti" ).blur(function(){
			var studval = $("#st_ensuite").val()*1+$("#st_standard").val()*1+$("#st_homestay").val()*1+$("#st_twin").val()*1;
			$("#sum_stud").val(studval);
		});
		
		$( ".contagl" ).blur(function(){
			var glval = $("#gl_ensuite").val()*1+$("#gl_standard").val()*1+$("#gl_homestay").val()*1+$("#gl_twin").val()*1;
			$("#sum_gl").val(glval);
		});		

	
		
		$("#writebook").click(function(){
			var giornitotali = daydiff(parseDate($('#adate').val()), parseDate($('#ddate').val()))*1+1;
			//alert(giornitotali);
			var giornidaweek = $("#n_weeks").val()*7+1;
			//alert(giornidaweek);
			var nogiorniok=0;
			if(giornitotali!=giornidaweek){
				var nogiorniok=1;
			}
			var arrivo_ok=0;
			var partenza_ok=0;
			$(".datearrivo").each(function(index) {
				var miadataarrivo=$("#arrival_date").val().split("/");
				var miadataarrivook = miadataarrivo[1]+"/"+miadataarrivo[0]+"/"+miadataarrivo[2];
				//alert(miadataarrivook);
				//alert($(this).text());
				if(miadataarrivook==$(this).text()){
					arrivo_ok=1;
				}
			});	
			if($("#prod_select").val()==""){
				alert("Select a product!");
				return false;
			}
			if($("#center_select").val()==""){
				alert("Select a center!");
				return false;
			}		
			if($("#sum_stud").val()=="0"){
				alert("No students enroled!");
				return false;
			}	
			if($("#sum_gl").val()=="0"){
				alert("No group leaders enroled!");
				return false;
			}	
			if($("#arrival_date").val()==""){
				alert("No arrival date selected!");
				return false;
			}
			if($("#departure_date").val()==""){
				alert("No departure date selected!");
				return false;
			}	
			if(giornitotali<=0){
				alert("Please verify selected dates: "+giornitotali+"day(s) on campus!");
				return false;
			}				
			if(arrivo_ok==0){
				if(nogiorniok==0){
					if(confirm("Arrival date doesn't match with campus arrival dates! You want to continue anyway?")){
						document.getElementById("enrolform").submit();
					}else{
						return false;
					}			
				}else{
					if(confirm("Arrival date doesn't match with campus arrival dates and days on campus doesn't match with selected weeks! You want to continue anyway?")){
						document.getElementById("enrolform").submit();
					}else{
						return false;
					}
				}
			}else{
				if(nogiorniok==1){
					if(confirm("Days on campus doesn't match with selected weeks! You want to continue anyway?")){
						document.getElementById("enrolform").submit();
					}else{
						return false;
					}				
				}else{
						document.getElementById("enrolform").submit();
				}
			}			
			
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
