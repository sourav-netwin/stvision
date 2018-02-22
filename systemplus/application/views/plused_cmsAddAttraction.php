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
	<script>
	$(document).ready(function() {
		$( "li#cms_campus" ).addClass("current");
		$( "li#cms_campus a" ).addClass("open");		
		$( "li#cms_campus ul.sub" ).css('display','block');	
		$( "li#cms_campus ul.sub li#cms_campus_3" ).addClass("current");	
	});
	</script>			

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12 profile">
			
				<div class="header">
				
					<div class="title">
						<h2>Add new attraction</h2>
					</div>
					<div class="avatar">
						<img src="<?php echo base_url(); ?>img/elements/profile/avatar_campus.png" />
					</div>
					
					<ul class="info">
						<li>
							<a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageAttractions" title="Back to attractions"><small>Back to attractions</small></a>
						</li>
					</ul><!-- End of ul.info -->
				</div><!-- End of .header -->
				<form class="validate" name="persoprofile" id="persoprofile" action="<?php echo base_url(); ?>index.php/backoffice/cmsInsertAttraction" method="POST">
				<div class="details grid_12">
					<h2>Attraction Details</h2>
					<section>
						<table>
							<tr>
								<th style="width:150px;">Attraction:</th><td><input type="text" style="width:300px;" name="pat_name" id="pat_name"  value=""></td>
							</tr>
							<tr>
								<th style="width:150px;">Type:</th>
									<td>
										<select style="width:300px;" name="pat_type_id" id="pat_type_id">
										<?php foreach($types as $type){ ?>
											<option value="<?php echo $type['patt_id'] ?>"><?php echo $type['patt_name'] ?></option>
										<?php } ?>
										</select>
									</td>
							</tr>							
							<tr>
								<th style="width:150px;">Entertainment Group</th><td><input type="text" style="width:300px;" name="pat_entertainment_group" id="pat_entertainment_group" class="required" value=""></td>
							</tr>
							<tr>
								<th style="width:150px;">Students price:</th><td><input type="text" style="width:300px;" name="pat_student_price" id="pat_student_price" class="required" value=""></td>
							</tr>	
							<tr>
								<th style="width:150px;">Adults price:</th><td><input type="text" style="width:300px;" name="pat_adult_price" id="pat_adult_price" class="required" value=""></td>
							</tr>
							<tr>
								<th style="width:150px;">Currency:</th>
									<td>
										<select style="width:300px;" name="pat_currency_id" id="pat_currency_id">
										<?php foreach($curs as $cur){ ?>
											<option value="<?php echo $cur['cur_id'] ?>"><?php echo $cur['cur_nome_esteso'] ?> (<?php echo $cur['cur_codice'] ?>)</option>
										<?php } ?>
										</select>
									</td>
							</tr>								
							<tr>
								<th style="width:150px;">Address:</th><td><input type="text" style="width:450px;" name="pat_address" id="pat_address" class="required" value=""></td>
							</tr>
							<tr>
								<th style="width:150px;">Region:</th>
									<td>
										<select style="width:300px;" name="pat_regione_id" id="pat_regione_id">
										<?php foreach($regs as $reg){ ?>
											<option value="<?php echo $reg['reg_id'] ?>"><?php echo $reg['reg_descrizione'] ?></option>
										<?php } ?>
										</select>
									</td>
							</tr>
							<tr>
								<th style="width:150px;">Country:</th>
									<td>
										<select style="width:300px;" name="pat_country_id" id="pat_country_id">
										<?php foreach($cous as $cou){ ?>
											<option value="<?php echo $cou['cou_id'] ?>"><?php echo $cou['cou_descrizione'] ?></option>
										<?php } ?>
										</select>
									</td>
							</tr>
							<tr>
								<th style="width:150px;">City:</th>
									<td>
										<select style="width:300px;" name="pat_city_id" id="pat_city_id">
										<?php foreach($cits as $cit){ ?>
											<option value="<?php echo $cit['cit_id'] ?>"><?php echo $cit['cit_descrizione'] ?></option>
										<?php } ?>
										</select>
									</td>
							</tr>							
							<tr>
								<th style="width:150px;">Attraction map</th>
								<td>
									<div id="map-canvas" style="width: 600px; height: 300px;border:1px solid #aaa;"></div>
								</td>
								<input type="hidden" id="actualAddress" name="actualAddress" value="">
								<input type="hidden" id="actualLat" name="actualLat" value="">
								<input type="hidden" id="actualLon" name="actualLon" value="">
							</tr>
							<tr>
								<th style="width:150px;">Description</th><td><textarea style="width:600px;height:400px;" name="pat_desc" id="pat_desc" class="editor required"></textarea></td>
							</tr>
							<tr>
								<th style="width:150px;">Opening time</th><td><textarea style="width:600px;height:400px;" name="pat_opening_time" id="pat_opening_time" class="editor required"></textarea></td>
							</tr>	
							<tr>
								<th style="width:150px;">Notes</th><td><textarea style="width:600px;height:400px;" name="pat_notes_1" id="pat_notes_1" class="editor required"></textarea></td>
							</tr>									
							<tr>
								<th style="width:150px;">Phone number:</th><td><input type="text" style="width:300px;" name="pat_phone" id="pat_phone" class="required" value=""></td>
							</tr>
							<tr>
								<th style="width:150px;">Email:</th><td><input type="text" style="width:300px;" name="pat_email" id="pat_email" value=""></td>
							</tr>	
							<tr>
								<th style="width:150px;">Website:</th><td><input type="text" style="width:300px;" name="pat_website" id="pat_website" value=""></td>
							</tr>								
						</table>					
					</section>
					<div class="actions">
						<div class="right">
							<input id="modprofile" type="submit" value="Insert new attraction" name=modprofile />
						</div>
					</div>	
				</div>				
				<div class="clearfix"></div>
				</form>
				
				
			</div>
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
	
	$("#pat_address").blur(function(){
		updateHidAddress();		
	});
	
});
</script>		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>
