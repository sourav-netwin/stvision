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
	<body style="background-color:#fff;height:100%;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="box">
						<div class="content">
							<form name="replyTicketForm" id="replyTicketForm" method="POST" action="" enctype="multipart/form-data">

								<div class="row form-group">
									<label for="tktFromCm"><strong>CM Message</strong></label>
									<div class="form-data" style="padding-top: 20px;" >
										<?php
										echo $ticketDetail['ptc_content'];
										?>
									</div>	
								</div>
								<div class="row form-group">
									<label for="tktContent"><strong>Reply</strong></label>
									<div class="form-data" >
										<textarea name="tktMessage" id="tktMessage" class="form-control required" style="max-width: 100%" maxlength="2000" ><?php echo empty($ticket['ptc_content']) ? '' : $ticket['ptc_content'] ?></textarea>
									</div>	
								</div>	
								<div class="row form-group">
									<label for="fileAttachment"><strong>Attachment</strong></label>
									<div class="form-data" >
										<input type="file" id="fileAttachment" name="fileAttachment" />
										<div class="fileInfo" style="margin-top: -15px">Max. file size allowed is 2 MB</div>
									</div>	
								</div>	
								<div class="row form-group" style="text-align: center; padding: 10px;">
									<input class="btn btn-primary" id="btnSave" name="btnReply" value="Reply" type="submit">
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
		<script src="<?php echo base_url(); ?>js/app.js"></script>

		<script type="text/javascript">
			$(function(){
				$('select').chosen();
				$('input[type=file]').fileInput();
			});
			$('#replyTicketForm').submit(function(e){
				e.preventDefault();
				var replyContent = $('#tktMessage').val();
				if(replyContent == '' || typeof replyContent == 'undefined'){
					alert('Please enter a message');
				}
				else{
					var data = new FormData($('#replyTicketForm')[0]);
					$.ajax({
						url: siteUrl+'ticketmanagement/replyTicket/<?php echo $ptc_id ?>',
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						type: 'POST',
						success: function(data){
							if(data == 1){
								parent.$('#box_tktFltr')[0].submit();
							}
							else{
								alert(data);
							}
						},
						error: function(){
							alert('Failed to reply ticket');
						}
					});
				}
				
			});
			
			$('body').on('reset', '#replyTicketForm', function(e)
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
