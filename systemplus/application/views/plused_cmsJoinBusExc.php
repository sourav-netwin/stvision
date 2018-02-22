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
<?php $this->load->view('plused_sidebar');
	$CC = $excursion;
?>		
	<script>
	$(document).ready(function() {
		$( "li#cms_campus" ).addClass("current");
		$( "li#cms_campus a" ).addClass("open");		
		$( "li#cms_campus ul.sub" ).css('display','block');	
		$( "li#cms_campus ul.sub li#cms_campus_2" ).addClass("current");	
	});
	</script>			

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/hammer-screwdriver.png">Manage bus for excursion <?php echo $CC['exc_excursion'] ?> FROM <?php echo $CC['exc_centro'] ?> <a id="addMe" style="float:right;" href="javascript:void(0);" title="Add bus for excursion <?php echo $CC['exc_excursion'] ?>"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/plus-button.png" class="icon">Add new bus</a></h2>
					</div>	
				<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">	
								<?php echo $CC['exc_excursion'] ?> from <?php echo $CC['exc_centro'] ?> | <?php echo $CC['exc_type'] ?> | <?php echo $CC['exc_length'] ?>							
							</div>
						</div>
						<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[[0,"asc"]],"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Coach company</th>
									<th>Bus</th>
									<th>Seats</th>
									<th>Price</th>
									<th style="width:100px;">&nbsp;</th>							
								</tr>
							</thead>
							<tbody>
							<?php 
								foreach($allBus as $bus){
					
							?>
								<tr>
									<td><?php echo $bus["tra_cp_name"]?></td>
									<td><?php echo $bus["tra_bus_name"]?></td>
									<td style="text-align:right;"><?php echo $bus["tra_bus_seat"]?> seats</td>
									<td style="text-align:right;"><input type="text" value="<?php echo str_replace(".",",",$bus["jn_price"])?>" name="prez_<?php echo $bus["jn_id"]?>" id="prez_<?php echo $bus["jn_id"]?>"> <?php echo $bus["jn_currency"]?></td>
									<td class="center containremover" style="width:100px;">
										<a data-gravity="s" class="button small grey tooltip busEDIT" href="javascript:void(0);" original-title="Edit bus <?php echo $bus["tra_bus_name"]?>" style="margin-left:0;" id="bus_<?php echo $bus["jn_id"]?>"><i class="icon-edit"></i></a>										
										<a data-gravity="s" class="button small grey tooltip busREMOVE" href="javascript:void(0);" original-title="Remove bus <?php echo $bus["tra_bus_name"]?>" style="margin-left:0;" id="bus_<?php echo $bus["jn_id"]?>"><i class="icon-remove"></i></a>										
									</td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
				</div>				
				<div class="clearfix"></div>
				
				</div>
			</div>
			<div id="dialog-modal" style="display:none;" title="Add bus for excursion <?php echo $CC['exc_excursion'] ?> FROM <?php echo $CC['exc_centro'] ?>">
				<form style="border:none;background-color:transparent;" name="addBusE" id="addBusE" action="<?php echo base_url(); ?>index.php/backoffice/cmsAddBusToExc/<?php echo $CC['exc_id'] ?>/<?php echo $CC['exc_id_centro'] ?>" method="POST">
					Bus<br>
					<select name="add_buse" id="add_buse" class="grid_12">
							<?php 
								foreach($totalBus as $bs){
							?>
							<option value="<?php echo $bs["tra_bus_id"]?>"><?php echo $bs["tra_cp_name"]?> - <?php echo $bs["tra_bus_seat"]?> seats</option>
							<?php
								} 
							?>
						</select>
						<br><br>
						Price<br><input type="text" name="prezzoAdd" id="prezzoAdd" value="" class="grid_6">
						<br><br><br>
						Currency
						<br>
							<select name="add_curr" id="add_curr" class="grid_6">
							<?php 
								foreach($curs as $cur){
							?>		
								<option value="<?php echo $cur["cur_id"]?>"><?php echo $cur["cur_codice"]?> - <?php echo $cur["cur_nome_esteso"]?></option>
							<?php
								} 
							?>							
							</select>
				</form>
			</div>
		</section><!-- End of #content -->

<script>



$(document).ready(function(){

		$( "td.containremover a.busREMOVE" ).live('click',function(e){
			e.preventDefault();
			if(confirm("Are you sure you want to remove this bus from <?php echo $CC['exc_excursion'] ?>?")){
				var myid = $(this).attr("id").split("_");
				window.location.href="<?php echo base_url(); ?>index.php/backoffice/cmsDelBusExc/"+myid[1]+"/<?php echo $CC['exc_id'] ?>";
			}
		});
		
		$( "td.containremover a.busEDIT" ).live('click',function(e){
			e.preventDefault();
			var myid = $(this).attr("id").split("_");
			var prezid = "prez_"+myid[1];
			var prezzo = $("#"+prezid).val();
			var re =  /^[+\-]?\d+,\d{2}$/
			if(re.test(prezzo)){
				prezzoOK = prezzo.split(",");
				window.location.href="<?php echo base_url(); ?>index.php/backoffice/cmsUpdateBusExcPrice/"+myid[1]+"/<?php echo $CC['exc_id'] ?>/"+prezzoOK[0]+"/"+prezzoOK[1];
			}else{
				alert("Price format is not corrected! It MUST have two decimals, comma separated!");
				return false;
			}
		});		

		$("a#addMe").click(function(){
			$( "#dialog-modal" ).dialog({
				height: 400,
				width: 550,
				modal: true,
				buttons: {
					"Add Bus": function() {
						var re =  /^[+\-]?\d+,\d{2}$/
						if(re.test($("#prezzoAdd").val())){
							$("#addBusE").submit();
						}else{
							alert("Price format is not corrected! It MUST have two decimals, comma separated!");
							return false;
						}
						
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});
	
});
</script>		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>
