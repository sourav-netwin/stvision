<div class="margin-5">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body">
					<form name="replyTicketForm" id="replyTicketForm" method="POST" action="" enctype="multipart/form-data">

						<div class="form-group">
							<label for="tktFromCm">
								<strong><?php echo $ticketDetail['ptc_sender_type'] ?> message</strong>
							</label>
							<div class="form-data">
								<?php
								echo $ticketDetail['ptc_content'];
								?>
							</div>
						</div>
						<div class="form-group">
							<label for="tktContent"><strong>Reply</strong></label>
							<div class="form-data" >
								<textarea name="tktMessage" id="tktMessage" class="form-control required" style="max-width: 100%" maxlength="2000" ><?php echo empty($ticket['ptc_content']) ? '' : $ticket['ptc_content'] ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="fileAttachment"><strong>Attachment</strong></label>
							<div class="form-data" >
								<input type="file" id="fileAttachment" name="fileAttachment" />
								<div class="fileInfo" style="margin-top: -15px">Max. file size allowed is 2 MB</div>
							</div>
						</div>
						<input type="hidden" id="ptc_id" name="ptc_id" value="<?php echo $ptc_id; ?>" />
						<div class="form-group" style="text-align: center; padding: 10px;">
							<input class="btn btn-primary" id="btnSave" name="btnReply" value="Reply" type="submit">
							<input class="btn btn-danger" id="btnReset" name="btnReset" value="Reset" type="reset">
							<?php
							showSessionMessageIfAny($this);
							?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>