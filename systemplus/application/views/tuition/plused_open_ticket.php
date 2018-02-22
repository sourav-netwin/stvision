<?php $this -> load -> view('plused_header'); ?>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<style type="text/css">
	#selCategory_chzn{
		width: 50% !important;
	}
	#selRefBooking_chzn{
		width: 50% !important;
	}
	.customfile {
		width: 50% !important;
	}
	@media(max-width: 750px){
		#selCategory_chzn{
			width: 100% !important;
		}
		#selRefBooking_chzn{
			width: 100% !important;
		}
		input[type="text"]{
			width: 100% !important;
		}
		textarea{
			width: 100% !important;
			max-width: 100% !important;
		}
		.customfile{
			width: 100% !important;
		}
	}
</style>
<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix">

	<!-- The blue toolbar stripe -->
	<section class="toolbar">
		<div class="user">
			<div class="avatar">
				<img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
				<!-- Evidenziare per icone attenzione <span>3</span> -->
			</div>
			<span><? echo $this -> session -> userdata('businessname') ?></span>
			<ul>
				<li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential">Profile</a></li>
				<li class="line"></li>
				<li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
			</ul>
		</div>
	</section><!-- End of .toolbar-->	
	<?php $this -> load -> view('plused_sidebar'); ?>
	<!-- Here goes the content. -->
	<section id="content" class="container_12 clearfix" data-sort=true>
		<div class="grid_12">
			<?php
			$success_message = $this -> session -> flashdata('success_message');
			$error_message = $this -> session -> flashdata('error_message');
			if (!empty($success_message)) {
				?><div class="tuition_success"><?php echo $success_message; ?></div><?php
		}
		if (!empty($error_message)) {
				?><div class="tuition_error"><?php echo $error_message; ?></div><?php
		}
			?>
			<div class="box">
				<div class="header">
					<h2>Open Ticket</h2>
				</div>
				<div class="content">
					<form name="openTicketForm" class="validate" id="openTicketForm" method="POST" action="<?php echo site_url() ?>/backoffice/openTicket" enctype="multipart/form-data" onsubmit="return btnDsbl()">
						<div class="row form-group">
							<label for="tipo_pax"><strong>Priority</strong></label>
							<div class="form-data" style="height: 35px; ">
								<div>
									<input class="required" type="radio" name="priority" value="low" <?php echo $priority == 'low' ? 'checked' : '' ?> /><span style="color: #05ca05">Low</span>&nbsp;&nbsp;<input type="radio" name="priority" value="medium" class="required" <?php echo $priority == 'medium' ? 'checked' : '' ?> /><span style="color: #d0c100">Medium</span>&nbsp;&nbsp;<input class="required" type="radio" name="priority" value="high" <?php echo $priority == 'high' ? 'checked' : '' ?> /><span style="color: #FF0000">High</span>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label for="selCategory"><strong>Category</strong></label>
							<div class="form-data" style="margin-left: 85px;">
								<select name="selCategory" id="selCategory" class="form-control required">
									<option value="">Select Category</option>
									<option <?php echo $category == 'HEALTH & SAFETY' ? 'selected' : '' ?> value="HEALTH & SAFETY">HEALTH & SAFETY</option>
									<option <?php echo $category == 'ATTRACTION' ? 'selected' : '' ?> value="ATTRACTION">ATTRACTION</option>
									<option <?php echo $category == 'BULLYING' ? 'selected' : '' ?> value="BULLYING">BULLYING</option>
									<option <?php echo $category == 'CUSTOMER CARE' ? 'selected' : '' ?> value="CUSTOMER CARE">CUSTOMER CARE</option>
									<option <?php echo $category == 'FACILITIES' ? 'selected' : '' ?> value="FACILITIES">FACILITIES</option>
									<option <?php echo $category == 'TRANSPORTATION' ? 'selected' : '' ?> value="TRANSPORTATION">TRANSPORTATION</option>
									<option <?php echo $category == 'CATERING' ? 'selected' : '' ?> value="CATERING">CATERING</option>
									<option <?php echo $category == 'OTHERS' ? 'selected' : '' ?> value="OTHERS">OTHERS</option>
									<option <?php echo $category == 'HOME STAY' ? 'selected' : '' ?> value="HOME STAY">HOME STAY</option>
									<option <?php echo $category == 'ACTIVITY ON CAMPUS' ? 'selected' : '' ?> value="ACTIVITY ON CAMPUS">ACTIVITY ON CAMPUS</option>
									<option <?php echo $category == 'PLUS STAFF' ? 'selected' : '' ?> value="PLUS STAFF">PLUS STAFF</option>
								</select>
							</div>
						</div>

						<div class="row form-group">
							<label for="tktTitle"><strong>Title</strong></label>
							<div class="form-data" style="margin-left: 85px;">
								<input type="text" name="tktTitle" id="tktTitle" class="form-control required" maxlength="50" style="width: 50%" value="<?php echo $tktTitle; ?>" />
							</div>
						</div>
						<div class="row form-group">
							<label for="tktContent"><strong>Text</strong></label>
							<div class="form-data" style="margin-left: 85px;">
								<textarea name="tktContent" id="tktContent" class="form-control required" style="max-width: 50%; max-height: 200px;" maxlength="2000" ><?php echo empty($content) ? '' : $content ?></textarea>
							</div>						
						</div>	
						<div class="row form-group">
							<label for="fileAttachment"><strong>Attachment</strong></label>
							<div class="form-data" style="margin-left: 85px;">
								<input type="file" id="fileAttachment" name="fileAttachment" />
							</div>	
							<div class="fileInfo" style="margin-top: -15px">Max. file size allowed is 2 MB</div>
						</div>	
						<div class="row form-group">
							<label for="selRefBooking"><strong>Reference booking</strong></label>
							<div class="form-data" style="margin-left: 85px;">
								<select name="selRefBooking" required id="selRefBooking" class="form-control required">
									<option value="all">All</option>
									<?php
									if ($bookings) {
										foreach ($bookings as $booking) {
											?>
											<option <?php echo $booking['booking_id'] == $refBook ? 'selected' : '' ?> value="<?php echo $booking['booking_id'] ?>"><?php echo $booking['booking_id'] ?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<div class="form-data" style="margin-left: 85px;">
								<input class="btn btn-tuition" id="btnSave" name="btnSave" value="Submit" type="submit">
								<input class="btn btn-tuition" id="btnReset" name="btnReset" value="Reset" type="reset">

							</div>

						</div>
					</form>	
				</div>
			</div>
		</div>	
	</section>	

</div>	
<script>
	$(document).ready(function() {
		$( "li#mngTkt" ).addClass("current");
		$( "li#mngTkt a" ).addClass("open");		
		$( "li#mngTkt ul.sub" ).css('display','block');	
		$( "li#mngTkt ul.sub li#mngTkt_1" ).addClass("current");	
		
		/*if($('.tuition_error').length > 0){
			setTimeout(function(){
				$($('.tuition_error')).fadeOut(5000, function(){
					$('.tuition_error').remove();
				});
			},10000);
		}*/
		if($('.tuition_success').length > 0){
			setTimeout(function(){
				$($('.tuition_success')).fadeOut(5000, function(){
					$('.tuition_success').remove();
				});
			},10000);
		}
		/*$( ".windia_tra" ).dialog({
			autoOpen: false,
			modal: true,
			buttons: [{
				text: "Close",
				click: function() { $(this).dialog("close"); }
			}],
			height : 500,
			width: 800
	});	*/	
	});
	function btnDsbl(){
		if($('input:radio[name=priority]:checked').val() != '' && typeof $('input:radio[name=priority]:checked').val() != 'undefined'  && $('#selCategory').val() != '' && $('#tktTitle').val() != '' && $('#tktContent').val() != '' && $('#selRefBooking').val() != '' ){
			$('#btnSave').prop('disabled', true);
			return true;
		}
		
	}
	$('body').on('reset', '#openTicketForm', function(e){
		$(".customfile-feedback").removeClass (function (index, css) {
			return (css.match (/\bcustomfile-ext-\S+/g) || []).join(' ');
		});
		$('.customfile-feedback').removeClass('customfile-feedback-populated');
		$('.customfile-feedback').html('No file selected...');
	});
</script>	
<?php $this -> load -> view('plused_footer'); ?>
