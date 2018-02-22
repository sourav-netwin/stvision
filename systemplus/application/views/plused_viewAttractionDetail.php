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
	$CC = $attraction[0];
?>		
	<script>
	$(document).ready(function() {
		$( "li#ag_attractions" ).addClass("current");
		$( "li#ag_attractions a" ).addClass("open");		
		$( "li#ag_attractions ul.sub" ).css('display','block');	
		$( "li#ag_attractions ul.sub li#ag_attractions_1" ).addClass("current");	
	});
	</script>			

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12 profile">
			
				<div class="header">
				
					<div class="title">
						<h2><?php echo $CC['pat_name'] ?></h2>
						<h3><?php echo $CC['pat_entertainment_group'] ?></h3>
						<h3 style="float:right;margin-right:10px;color:#000"><?php echo $CC['patt_name'] ?></h3>
					</div>
					<div class="avatar">
						<img src="<?php echo base_url(); ?>img/elements/profile/avatar_campus.png" />
					</div>
					
					<ul class="info">
						<li>
							<a href="<?php echo base_url(); ?>index.php/agents/viewAttractions" title="Back to attractions"><small>Back to attractions</small></a>
						</li>
					</ul><!-- End of ul.info -->
				</div><!-- End of .header -->
				<div class="details grid_12">
					<h2>Attraction Details</h2>
					<section>
						<table>
							<tr>
								<th style="width:150px;vertical-align:top;"><b>Description: </b></th><td><?php echo $CC['pat_desc'] ?></td>
							</tr>						
							<tr>
								<th style="width:150px;vertical-align:top;"><b>Address: </b></th><td><?php echo $CC['pat_address'] ?> - <?php echo $CC['cit_descrizione'] ?> (<?php echo $CC['cou_descrizione'] ?>)</td>
							</tr>
							<tr>
								<th style="width:150px;vertical-align:top;"><b>Map: </b></th><td><div id="map-canvas" style="width: 600px; height: 300px;border:1px solid #aaa;"></div></td>
								<input type="hidden" id="actualAddress" name="actualAddress" value="<?php echo $CC['pat_address'] ?>">
								<input type="hidden" id="actualLat" name="actualLat" value="<?php echo $CC['pat_lat'] ?>, <?php echo $CC['pat_lat'] ?>">
								<input type="hidden" id="actualLon" name="actualLon" value="<?php echo $CC['pat_lon'] ?>, <?php echo $CC['pat_lon'] ?>">
							</tr>	
							<tr>
								<th style="width:150px;vertical-align:top;"><b>Opening time: </b></th><td><?php echo $CC['pat_opening_time'] ?></td>
							</tr>
							<tr>
								<th style="width:150px;vertical-align:top;"><b>Adult prices: </b></th><td><?php echo $CC['pat_adult_price'] ?> <?php echo $CC['cur_codice'] ?></td>
							</tr>		
							<tr>
								<th style="width:150px;vertical-align:top;"><b>Student prices: </b></th><td><?php echo $CC['pat_student_price'] ?> <?php echo $CC['cur_codice'] ?></td>
							</tr>	
							<tr>
								<th style="width:150px;vertical-align:top;"><b>Notes: </b></th><td><?php echo $CC['pat_notes_1'] ?></td>
							</tr>		
							<tr>
								<th style="width:150px;vertical-align:top;"><b>Phone number: </b></th><td><?php echo $CC['pat_phone'] ?></td>
							</tr>	
							<tr>
								<th style="width:150px;vertical-align:top;"><b>Email: </b></th><td><a href="mailto:<?php echo $CC['pat_email'] ?>" title="Write an email"><?php echo $CC['pat_email'] ?></a></td>
							</tr>	
							<tr>
								<th style="width:150px;vertical-align:top;"><b>Website: </b></th><td><a href="<?php if(!strpos($CC['pat_website'],"http://")){ ?>http://<?php } ?><?php echo $CC['pat_website'] ?>" target="_blank" title="Visit official website"><?php echo $CC['pat_website'] ?></a></td>
							</tr>								
						</table>
					</section>
				</div>									
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<?php if($viewBook==1){ ?>
			<div class="grid_12">
				<form>
					<fieldset>
						<legend>Book Attraction</legend>
						<div class="row">
							<?php 
							if(count($all_books) > 0){
							?>
							<table style="width:100%;margin:15px 0;">
								<thead>
									<tr>
										<th style="text-align:left;padding:4px 0;">Book Id</th>
										<th style="text-align:left;padding:4px 0;">Campus</th>
										<th style="text-align:left;padding:4px 0;">Students</th>
										<?php /* <th style="text-align:left;padding:4px 0;">Estimated price</th> */ ?>
										<th>Book Now</th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach($all_books as $eex){
									?>
									<tr>
										<td style="padding:4px 1px;"><?php echo $eex["id_year"]?>_<?php echo $eex["id_book"]?></td>
										<td style="padding:4px 1px;"><?php echo $eex["centro"]?></td>
										<td style="padding:4px 1px;"><?php echo $eex["tot_pax"]?></td>
										<?php /*<td style="padding:4px 1px;"><?php echo number_format(str_replace(",",".",$CC['pat_student_price'])*1 * $eex["tot_pax"]*1,2,",","") ?> <?php echo $CC['cur_codice'] ?></td> */ ?>
										<td style="padding:4px 1px;text-align:center;">
											<a data-gravity="s" class="button small blue tooltip prenAtt" href="javascript:void(0);" name="Book attraction now" original-title="Book attraction now" style="margin-left:0;" id="bookA_<?php echo $eex["id_year"]?>_<?php echo $eex["id_book"]?>_<?php echo $eex["id_centro"]?>"><i class="icon-edit"></i></a>
										</td>
									</tr>
									<?php
										}
									?>
								</tbody>
							</table>
							<?php
							}else{
							?>
							<table>
								<tr><td>No confirmed bookings available</td></tr>
							</table>							
							<?php
							}
							?>
						</div>							
					</fieldset>
				</form>	
				<form name="bookThisAtt" id="bookThisAtt" action="<?php echo base_url(); ?>index.php/agents/bookAttractionNow" method="POST">
					<input type="hidden" name="hidIdAtt" id="hidIdAtt" value="<?php echo $idA?>">
					<input type="hidden" name="hidIdBook" id="hidIdBook" value="">
					<input type="hidden" name="hidIdYear" id="hidIdYear" value="">
					<input type="hidden" name="hidIdCampus" id="hidIdCampus" value="">
				</form>
			</div>	
			<?php } ?>			
		</section><!-- End of #content -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSwGdc1633JshX29JtxSZzqt5sbgmUK-M&sensor=false"></script>

<script>
var geocoder;
var map;

function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(-34.397, 150.644);

  var mapOptions = {
    zoom: 17,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.HYBRID
  }
  map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
}

function codeAddress() {
  var address = document.getElementById('actualAddress').value;
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
	  $("#actualLat").val(results[0].geometry.location.lat());
	  $("#actualLon").val(results[0].geometry.location.lon());
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

function updateHidAddress(){
	$("#actualAddress").val($("#pat_address").val());
	codeAddress();
}



$(document).ready(function(){
	initialize();
	codeAddress();
	
	$("#pat_address").blur(function(){
		updateHidAddress();		
	});
	
	$(".prenAtt").click(function(e){
		arrattID = ($(this).attr("id")).split("_");
		$("#hidIdYear").val(arrattID[1]);
		$("#hidIdBook").val(arrattID[2]);
		$("#hidIdCampus").val(arrattID[3]);
		$("#bookThisAtt").submit();
	});
	
});
</script>		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>
