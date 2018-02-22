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
	$CC = $campus[0];
?>
	<script>
	$(document).ready(function() {
		$( "li#cms_campus" ).addClass("current");
		$( "li#cms_campus a" ).addClass("open");
		$( "li#cms_campus ul.sub" ).css('display','block');
		$( "li#cms_campus ul.sub li#cms_campus_1" ).addClass("current");
	});
	</script>

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12 profile">

				<div class="header">

					<div class="title">
						<h2><?php echo $CC['nome_centri'] ?></h2>
						<h3><?php echo $CC['school_name'] ?></h3>
					</div>
					<div class="avatar">
						<img src="<?php echo base_url(); ?>img/elements/profile/avatar_campus.png" />
					</div>

					<ul class="info">
						<li>
							<a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageCampus" title="Back to campus"><small>Back to campus</small></a>
						</li>
					</ul><!-- End of ul.info -->
				</div><!-- End of .header -->
				<form class="validate" name="persoprofile" id="persoprofile" action="<?php echo base_url(); ?>index.php/backoffice/cmsUpdateCampus/<?php echo $CC['id'] ?>" method="POST">
				<div class="details grid_12">
					<h2>Campus Details</h2>
					<section>
						<table>
							<tr>
								<th style="width:150px;">Campus:</th><td><input type="text" style="width:300px;" name="nome_centri" id="nome_centri"  value="<?php echo $CC['nome_centri'] ?>" readonly></td>
							</tr>
							<tr>
								<th style="width:150px;">School name:</th><td><input type="text" style="width:300px;" name="school_name" id="school_name" class="required" value="<?php echo $CC['school_name'] ?>"></td>
							</tr>
							<tr>
								<th style="width:150px;">Address:</th><td><input type="text" style="width:450px;" name="address" id="address" class="required" value="<?php echo $CC['address'] ?>"></td>
							</tr>
							<tr>
								<th style="width:150px;">Post Code:</th><td><input type="text" style="width:300px;" name="post_code" id="post_code" class="required" value="<?php echo $CC['post_code'] ?>"></td>
							</tr>
							<tr>
								<th style="width:150px;">Campus map</th>
								<td>
									<div id="map-canvas" style="width: 600px; height: 300px;border:1px solid #aaa;"></div>
								</td>
								<input type="hidden" id="actualAddress" name="actualAddress" value="<?php echo $CC['school_name'] ?>, <?php echo $CC['address'] ?> <?php echo $CC['post_code'] ?>">
							</tr>
							<tr>
								<th style="width:150px;">Located in:</th><td>
									<select style="width:300px;" name="located_in" id="located_in" class="required">
										<option value="Ireland"<?php if($CC["located_in"]=="Ireland"){?> selected <?php } ?>>Ireland</option>
										<option value="Malta"<?php if($CC["located_in"]=="Malta"){?> selected <?php } ?>>Malta</option>
										<option value="United Kingdom"<?php if($CC["located_in"]=="United Kingdom"){?> selected <?php } ?>>United Kingdom</option>
										<option value="USA"<?php if($CC["located_in"]=="USA"){?> selected <?php } ?>>USA</option>
									</select></td>
							</tr>
							<tr>
								<th style="width:150px;">Accomodations</th>
								<td>
									<ul style="float:left;">
										<?php
										//print_r($campusSis);
										foreach($allSis as $sis){
											$sisExists=0;
											foreach($campusSis as $cSis){
												if($cSis["sistemazione"]== $sis["tba_type_join"]){
													$sisExists = 1;
												}
											}
										?>
										<li style="float: left;line-height: 30px;height: 30px;list-style-type: none;margin-right: 20px;"><label style="margin-right:10px;"><?php echo $sis["tba_type_join"] ?></label><input type="checkbox" name="sisacco[]" id="sisacco_<?php echo $sis["tba_type_join"] ?>" value="<?php echo $sis["tba_type_join"] ?>" <?php if($sisExists==1){ ?>checked="checked"<?php } ?>></li>
										<?php } ?>
									</ul>
								</td>
							</tr>
							<tr>
								<th style="width:150px;">Destination</th><td><textarea style="width:600px;height:400px;" name="page_1" id="page_1" class="editor required"><?php echo $CC['page_1'] ?></textarea></td>
							</tr>
							<tr>
								<th style="width:150px;">Courses</th><td><textarea style="width:600px;height:400px;" name="page_3" id="page_3" class="editor required"><?php echo $CC['page_3'] ?></textarea></td>
							</tr>
							<tr>
								<th style="width:150px;">Plus contact fullname:</th><td><input type="text" style="width:300px;" name="plus_contact" id="plus_contact" class="required" value="<?php echo $CC['plus_contact'] ?>"></td>
							</tr>
							<tr>
								<th style="width:150px;">Plus contact number:</th><td><input type="text" style="width:300px;" name="plus_contact_number" id="plus_contact_number" class="required" value="<?php echo $CC['plus_contact_number'] ?>"></td>
							</tr>
							<tr>
								<th style="width:150px;">Campus manager email:</th><td><input type="text" style="width:300px;" name="cm_mail" id="cm_mail" class="required" value="<?php echo $CC['cm_mail'] ?>"></td>
							</tr>
						</table>
					</section>
					<h2>Included services</h2>
					<section>
						<table>
							<?php
							foreach($psg as $sg){
							?>
							<tr>
								<th style="width:150px;"><?php echo $sg["psg_servizio"] ?>:</th>
								<td>
									<div style="width:700px;height:300px;"><textarea class="editor" name="cpsg_<?php echo $sg["psg_id"] ?>" id="cpsg_<?php echo $sg["psg_id"] ?>"><?php foreach($campus_psg as $cpsg){if($cpsg["jn_cpsg_ids"]==$sg["psg_id"]){ ?><?php echo $cpsg["jn_cpsg_text"]; ?><?php }}?></textarea></div>
								</td>
							</tr>
							<?php
							}
							?>
						</table>
					</section>
					<h2>Optional services</h2>
					<section>
						<table>
							<?php
							foreach($pso as $so){
							?>
							<tr>
								<th style="width:150px;"><?php echo $so["pso_servizio"] ?>:</th>
								<td>
									<div style="width:700px;height:300px;"><textarea class="editor" name="cpso_<?php echo $so["pso_id"] ?>" id="cpso_<?php echo $so["pso_id"] ?>"><?php foreach($campus_pso as $cpso){if($cpso["jn_cpso_ids"]==$so["pso_id"]){ ?><?php echo $cpso["jn_cpso_text"]; ?><?php }}?></textarea></div>
								</td>
							</tr>
							<?php
							}
							?>
						</table>
					</section>
					<div class="actions">
						<div class="right">
							<input id="modprofile" type="submit" value="Update campus details" name=modprofile />
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
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

function updateHidAddress(){
	//$("#actualAddress").val($("#school_name").val()+", "+$("#address").val()+" "+$("#post_code").val());
}




$(document).ready(function(){
	initialize();
	codeAddress();

	$("school_name").blur(function(){
		updateHidAddress()
	});
	$("address").blur(function(){
		updateHidAddress()
	});
	$("post_code").blur(function(){
		updateHidAddress()
	});

});
</script>
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>
