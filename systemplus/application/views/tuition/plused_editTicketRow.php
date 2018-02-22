<?php
/**
 * @author Arunsankar S
 * @date : 08-06-2016
 */
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Vision - Plus-Ed</title>

		<!-- Bootstrap -->
		<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">-->
		<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">-->
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/external/jquery.chosen.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>css/layout.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/style.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/typographics.css" />
		<!--<link rel="stylesheet" href="<?php echo base_url() ?>css/grid.css" />-->
		<!--<link rel="stylesheet" href="<?php echo base_url() ?>css/NA_style.css" />-->
		<link rel="stylesheet" href="<?php echo base_url() ?>css/elements.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/forms.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/excursion.css" />

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			.panel-title{
				font-size:12px;
			}

			#selCategory_chzn{
				width: 50% !important;
			}
			#selRefBooking_chzn{
				width: 50% !important;
			}
			.customfile {
				width: 50% !important;
			}
			.chzn-container-single .chzn-single {
				border: 1px solid #a8acb0;
				border-radius: 0;
				background: url('<?php echo base_url() ?>/img/elements/select/bg.png') #eaebed;
				box-shadow: 0 1px 1px rgba(0,0,0,0.1);
			}
			form .row > div {
				position: relative !important;
				padding-left: 15px !important;
				border-left: 1px solid #d2d2d2 !important;
				margin-left: 120px !important;
			}

		</style>
		<script type="text/javascript">
			var arraycontabkgs = new Array();
		</script>
	</head>
	<body style="background-color:#fff; overflow: hidden !important;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="box">
						<div class="content">
							<form name="editTicketForm" id="editTicketForm" method="POST" action="" enctype="multipart/form-data">
								<div class="row form-group">
									<label for="tipo_pax"><strong>Priority</strong></label>
									<div class="form-data" >
										<div>
											<input class="required" type="radio" name="priority" value="low" <?php echo $ticket['ptc_priority'] == 'low' ? 'checked' : '' ?> /><span style="color: #05ca05">Low</span>&nbsp;&nbsp;<input type="radio" name="priority" value="medium" class="required" <?php echo $ticket['ptc_priority'] == 'medium' ? 'checked' : '' ?> /><span style="color: #d0c100">Medium</span>&nbsp;&nbsp;<input class="required" type="radio" name="priority" value="high" <?php echo $ticket['ptc_priority'] == 'high' ? 'checked' : '' ?> /><span style="color: #FF0000">High</span>
										</div>
									</div>
								</div>
								<div class="row form-group">
									<label for="selCategory"><strong>Category</strong></label>
									<div class="form-data" >
										<select name="selCategory" id="selCategory" class="form-control required">
											<option value="">Select Category</option>
											<option <?php echo $ticket['ptc_category'] == 'HEALTH & SAFETY' ? 'selected' : '' ?> value="HEALTH & SAFETY">HEALTH & SAFETY</option>
											<option <?php echo $ticket['ptc_category'] == 'ATTRACTION' ? 'selected' : '' ?> value="ATTRACTION">ATTRACTION</option>
											<option <?php echo $ticket['ptc_category'] == 'BULLYING' ? 'selected' : '' ?> value="BULLYING">BULLYING</option>
											<option <?php echo $ticket['ptc_category'] == 'CUSTOMER CARE' ? 'selected' : '' ?> value="CUSTOMER CARE">CUSTOMER CARE</option>
											<option <?php echo $ticket['ptc_category'] == 'FACILITIES' ? 'selected' : '' ?> value="FACILITIES">FACILITIES</option>
											<option <?php echo $ticket['ptc_category'] == 'TRANSPORTATION' ? 'selected' : '' ?> value="TRANSPORTATION">TRANSPORTATION</option>
											<option <?php echo $ticket['ptc_category'] == 'CATERING' ? 'selected' : '' ?> value="CATERING">CATERING</option>
											<option <?php echo $ticket['ptc_category'] == 'OTHERS' ? 'selected' : '' ?> value="OTHERS">OTHERS</option>
											<option <?php echo $ticket['ptc_category'] == 'HOME STAY' ? 'selected' : '' ?> value="HOME STAY">HOME STAY</option>
											<option <?php echo $ticket['ptc_category'] == 'ACTIVITY ON CAMPUS' ? 'selected' : '' ?> value="ACTIVITY ON CAMPUS">ACTIVITY ON CAMPUS</option>
											<option <?php echo $ticket['ptc_category'] == 'PLUS STAFF' ? 'selected' : '' ?> value="PLUS STAFF">PLUS STAFF</option>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<label for="tktTitle"><strong>Title</strong></label>
									<div class="form-data" >
										<input type="text" name="tktTitle" id="tktTitle" class="form-control required" maxlength="50" style="width: 50%" value="<?php echo $ticket['ptc_title']; ?>" />
									</div>
								</div>
								<div class="row form-group">
									<label for="tktContent"><strong>Text</strong></label>
									<div class="form-data" >
										<textarea name="tktContent" id="tktContent" class="form-control required" style="max-width: 100%" maxlength="2000" ><?php echo empty($ticket['ptc_content']) ? '' : $ticket['ptc_content'] ?></textarea>
									</div>	
								</div>	
								<div class="row form-group">
									<label for="fileAttachment"><strong>Attachment</strong></label>
									<div class="form-data" >
										<input type="file" id="fileAttachment" name="fileAttachment" />
										<div class="fileInfo" style="margin-top: -15px">Max. file size allowed is 2 MB</div>
										<?php
										if ($ticket['ptc_attachment']) {
											?>
											<div style="margin-top: -10px !important;"><a target="_blank" href="<?php echo TICKET_CM_DWNLD . $ticket['ptc_attachment'] ?>">Find added attachment</a>&nbsp;&nbsp;<span><a href="javascript:void(0)" style="color: #FF0000" id="removeAttachment" data-id="atmRem_<?php echo $ticket['ptc_id'] ?>">Remove attachment</a></span></div>
											<?php
										}
										?>
									</div>	
								</div>	
								<div class="row form-group">
									<label for="selRefBooking"><strong>Reference booking</strong></label>
									<div class="form-data" >
										<select name="selRefBooking" id="selRefBooking" class="form-control required">
											<option value="all">All</option>
											<?php
											if ($bookings) {
												foreach ($bookings as $booking) {
													?>
													<option <?php echo $booking['booking_id'] == $ticket['ptc_ref_booking'] ? 'selected' : '' ?> value="<?php echo $booking['booking_id'] ?>"><?php echo $booking['booking_id'] ?></option>
													<?php
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="row form-group" style="text-align: center">
									<input class="btn btn-primary" id="btnSave" name="btnSave" value="Update" type="submit">
									<input class="btn btn-danger" id="btnReset" name="btnReset" value="Reset" type="reset">
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

								</div>
							</form>	
						</div>
					</div>
				</div>	
			</div>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript">
			var baseUrl = "<?php echo base_url(); ?>";
			var siteUrl = "<?php echo site_url(); ?>/";
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>-->
		<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.chosen.js"></script>
		<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.fileinput.js"></script>

		<script type="text/javascript">
			$(function(){
				$('select').chosen();
				$('input[type=file]').fileInput();
			});
			$('#editTicketForm').submit(function(e){
				e.preventDefault();
				e.preventBubble=true;
				var error = 0;
				var priority = $('input:radio[name=priority]:checked').val();
				var category = $('#selCategory').val();
				var title = $('#tktTitle').val();
				var text = $('#tktContent').val();
				var ref = $('#selRefBooking').val();
				if(priority == '' || typeof priority == 'undefined'){
					error += 1;
					alert('Please select priority');
					return false;
				}
				if(category == '' || typeof category == 'undefined'){
					error += 1;
					alert('Please select category');
					return false;
				}
				if(title == '' || typeof title == 'undefined'){
					error += 1;
					alert('Please enter title');
					return false;
				}
				if(text == '' || typeof text == 'undefined'){
					error += 1;
					alert('Please enter text');
					return false;
				}
				if(ref == '' || typeof ref == 'undefined'){
					error += 1;
					alert('Please select reference booking');
					return false;
				}
				if(error == 0){
					var data = new FormData($('#editTicketForm')[0]);
					$.ajax({
						url: siteUrl+'backoffice/updateTicket/<?php echo $ticket['ptc_id'] ?>',
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						type: 'POST',
						success: function(data){
							if(data == 1){
								window.parent.location.reload();
							}
							else{
								alert(data);
							}
						},
						error: function(){
							alert('Failed to update ticket');
						}
					});
				}
				
			});
			
			$('#removeAttachment').on('click', function(){
				var c = confirm('Are you sure to delete?This can\'t be undone.');
				if(c){
					var selId = $(this).attr('data-id').replace('atmRem_', '');
					if(selId != '' && typeof selId != 'undefined'){
						$.ajax({
							url: siteUrl+'backoffice/removeAttachment',
							type: 'POST',
							data: {
								selId: selId
							},
							success: function(data){
								if(data == 1){
									//alert('Attachment removed successfully');
									window.parent.location.reload();
								}
								else{
									alert('Failed to remove attachment');
								}
							},
							error: function(){
								alert('Failed to remove attachment');
							}
						});
					}
				}
			});
			$('body').on('reset', '#editTicketForm', function(e)
			{
				$(".customfile-feedback").removeClass (function (index, css) {
					return (css.match (/\bcustomfile-ext-\S+/g) || []).join(' ');
				});
				$('.customfile-feedback').removeClass('customfile-feedback-populated');
				$('.customfile-feedback').html('No file selected...');
			});
		</script>	
	</body>
</html>
