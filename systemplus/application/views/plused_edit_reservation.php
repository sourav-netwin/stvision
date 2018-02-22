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
<?php 
		$book = $booking_detail[0];
		//print_r($book);
		$campusid = $book["id_centro"];
		$indate = explode("-",$book["arrival_date"]);
		$outdate = explode("-",$book["departure_date"]);
		$myindate = $indate[1]."/".$indate[2]."/".$indate[0];
		$myoutdate = $outdate[1]."/".$outdate[2]."/".$outdate[0];
?>		
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<form action="<?php echo base_url(); ?>index.php/backoffice/editGroup/<?php echo $book["id_book"]?>/<?php echo $book["id_year"]?>" name="enrolform" id="enrolform" class="grid12" method="POST">
					<fieldset>
					<?php /* VECCHIA TESTATA CON UPLOAD PAX PRE-ROSTER
					<legend>Booking summary - ID: <?php echo $book["id_year"]?>_<?php echo $book["id_book"]?> [<?php echo $book["agente_name"]?>]<a class="detailPax" id="detail_<?php echo $book["id_book"]?>_<?php echo $book["id_year"]?>" name="detailPax" style="float:right;" href="javascript:void(0);">View pax list</a><?php if($book["id_agente"]!=795){ ?><span style="float:right;margin:0 15px;">|</span><a class="uploadPax" id="upload_<?php echo $book["id_book"]?>_<?php echo $book["id_year"]?>" name="uploadPax" style="float:right;" href="javascript:void(0);">Upload pax list</a><?php } ?></legend>
					*/ ?>
					<legend>Booking summary - ID: <?php echo $book["id_year"]?>_<?php echo $book["id_book"]?> [<?php echo $book["agente_name"]?>]<a class="detailPax" id="detail_<?php echo $book["id_book"]?>_<?php echo $book["id_year"]?>" name="detailPax" style="float:right;" href="javascript:void(0);">View pax list</a><?php if($book["lockPax"]==1){ ?><span style="float:right;margin:0 15px;">|</span><a class="unlockPax" id="unlock_<?php echo $book["id_book"]?>_<?php echo $book["id_year"]?>" name="unlockPax" style="float:right;" href="javascript:void(0);">Unlock pax roster</a><?php } ?></legend>
						<div class="row">
							<label for="prod_select">
								<strong>Product</strong>
							</label>
							<div>
								<?php if($book["id_prodotto"]=="1"){?><input type="text" name="noprod" value="Plus Junior Summer" disabled><?php }?> 
							</div>
						</div>	
						<div class="row">
							<label for="center_select">
								<strong>Center</strong>
							</label>
							<div>
								<input type="text" name="nocentro" value="<?php echo $book["centro_name"]?>" disabled>
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
								<input class="contastudenti" data-type="spinner" name=st_ensuite id="st_ensuite" value="0" min="0" max="400" />
							</div>
						</div>	
						<div class="row" id="row_st_st" style="display:none;">
							<label for="st_standard">
								<strong>Standard</strong>
							</label>
							<div>
								<input class="contastudenti" data-type="spinner" name=st_standard id=st_standard value="0" min="0" max="400" />
							</div>
						</div>	
						<div class="row" id="row_st_ho" style="display:none;">
							<label for="st_homestay">
								<strong>Homestay</strong>
							</label>
							<div>
								<input class="contastudenti" data-type="spinner" name=st_homestay id=st_homestay value="0" min="0" max="400" />
							</div>
						</div>			
						<div class="row" id="row_st_tw" style="display:none;">
							<label for="st_twin">
								<strong>Twin</strong>
							</label>
							<div>
								<input class="contastudenti" data-type="spinner" name=st_twin id=st_twin value="0" min="0" max="400" />
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
							<input data-type="spinner" min=1 max=4 value=<?php echo $book["weeks"]?> id=n_weeks name=n_weeks />
						</div>
					</div>						
					<div class="row">
						<label for="arrival_date">
							<strong>Arrival date</strong>
						</label>
						<div>
						<div class="row" id="alldates" style="border:0;color:#f00;"></div>
							<div data-type="date" data-id=arrival_date data-name=arrival_date data-show-button-panel=false data-number-of-months=3 data-min-date="06/01/2017"  data-max-date="09/30/2017" data-alt-field="#adate" data-alt-format="dd/mm/yy" data-default-date="<?php echo $myindate?>"></div>
						</div>
					</div>	
					<div class="row">
						<label for="departure_date">
							<strong>Departure date</strong>
						</label>
						<div>
							<div data-type="date" data-id=departure_date data-name=departure_date data-show-button-panel=false data-number-of-months=3 data-min-date="06/01/2017"  data-max-date="10/31/2017" data-alt-field="#ddate" data-alt-format="dd/mm/yy" data-default-date="<?php echo $myoutdate?>"></div>
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
						<div class="right">
							<?php /* disabilitato per accrocchio import automatico da dev, rimosso on request in data 13/02/2014 <input <?php if($book["id_agente"]==795 || $pax_uploaded > 0){ ?>disabled <?php } ?>id="writebook" type="button" value="Submit" name=writebook /> */ ?>
							<input <?php if($pax_uploaded > 0){ ?>disabled <?php } ?>id="writebook" type="button" value="Submit" name=writebook />
						</div>
					</div><!-- End of .actions -->
				</form>
			</div><!-- End of .grid_12 -->	
			<div style="display: none;overflow:scroll;width:800px;" id="dialog_modal_<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" title="Pax List | Booking detail - <?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" class="windia"></div>
			<?php if($book["id_agente"]!=795){ ?>
			<div style="display: none;overflow:hidden;width:800px;" id="upload_dialog_modal_<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" title="Upload Pax List | Booking detail - <?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" class="uplodia"></div>
			<?php } ?>
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
	<script>
	$(document).ready(function() {
		$( "li#bobooking" ).addClass("current");
		$( "li#bobooking a" ).addClass("open");		
		$( "li#bobooking ul.sub" ).css('display','block');	
		$( "li#bobooking ul.sub li#bobooking_1" ).addClass("current");	
		$.ajax({
				type: "POST",
				data: "idcentro=" + <?php echo $book["id_centro"]?>,
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
				data: "idcentro=" + <?php echo $book["id_centro"]?>,
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
		$("#st_ensuite").val(<?php echo $book["stens"]?>);
		$("#st_standard").val(<?php echo $book["ststa"]?>);
		$("#st_homestay").val(<?php echo $book["sthom"]?>);
		$("#st_twin").val(<?php echo $book["sttwi"]?>);
		$("#gl_ensuite").val(<?php echo $book["glens"]?>);
		$("#gl_standard").val(<?php echo $book["glsta"]?>);
		$("#gl_homestay").val(<?php echo $book["glhom"]?>);
		$("#gl_twin").val(<?php echo $book["gltwi"]?>);
		$("#sum_stud").val($("#st_ensuite").val()*1+$("#st_standard").val()*1+$("#st_homestay").val()*1+$("#st_twin").val()*1);
		$("#sum_gl").val($("#gl_ensuite").val()*1+$("#gl_standard").val()*1+$("#gl_homestay").val()*1+$("#gl_twin").val()*1);			
		$("#arrival_date").val("<?php echo $myindate?>");
		$("#departure_date").val("<?php echo $myoutdate?>");
	
	
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

		$( ".windia" ).dialog({
				autoOpen: false,
				modal: true,
				buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}],
			height : 500,
			width: 800
		});
		
		$(".detailPax").click(function(){
				$( "#dialog_modal_<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" ).load('<?php echo base_url(); ?>index.php/backoffice/detMyPax/<?php echo $book["id_year"]?>/<?php echo $book["id_book"]?>').dialog("open");
				return false;			
		});
		
		<?php if($book["id_agente"]!=795){ ?>
		<?php
		/* VECCHIO UPLOAD PRE ROSTER
		
		$( ".uplodia" ).dialog({
				autoOpen: false,
				modal: true,
				buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}],
			height : 300,
			width: 300
		});

		
		$(".uploadPax").click(function(){
				$( "#upload_dialog_modal_<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" ).load('<?php echo base_url(); ?>index.php/backoffice/uploadFormPax/<?php echo $book["id_year"]?>/<?php echo $book["id_book"]?>/<?php echo $campusid ?>').dialog("open");
				return false;			
		});
		*/?>
		<?php } ?>
	
		$(".unlockPax").click(function(){
			if(confirm("Are you sure you want to unlock this roster?")){
				window.location.href = '<?php echo base_url(); ?>index.php/backoffice/unlockRoster/<?php echo $book["id_book"]?>';
			}else{
				return false;
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
