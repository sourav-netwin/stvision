<div class="row">
	<div class="col-md-12">
		<form id="boTmplSelForm">
			<table class="table vertical-middle">
				<tr>
					<td colspan="2" class="text-center" >Please select a template before print</td>
				</tr>
				<tr>
					<td>
						<div class="form-group">
							<label for="templSelWhole">Template</label>
							<select id="templSelWhole" name="templSelWhole" required class="form-control">
								<option value="">Select one option</option>
								<?php
								
								foreach($templates as $template){ 
								$tempTitle = '';
								if ($template['template'] == 'UKIR') {
									$tempTitle = 'UK/Ireland';
								}
								if ($template['template'] == 'USA') {
									$tempTitle = 'USA';
								}
								if ($template['template'] == 'MAL') {
									$tempTitle = 'Malta';
								}
								if ($template['template'] == 'UKIRGLSTD') {
									$tempTitle = 'UK/Ireland - GL Standard';
								}
								if ($template['template'] == 'UKIRSTDSTD') {
									$tempTitle = 'UK/Ireland - STD Standard';
								}
								if ($template['template'] == 'UKIRSTDST') {
									$tempTitle = 'UK/Ireland - STD Short Term';
								}
								?>
									<option value="<?php echo $template['tempMap']; ?>"><?php echo $tempTitle ?></option>
									
								<?php }
								
								?>
								
								
								<!--<option value="UKIR">UK/Ireland</option>
								<option value="USA">USA</option>
								<option value="MAL">Malta</option>-->
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="text-center"><input type="submit" class="btn btn-xs btn-primary" value="Print VISA" id="printBackVisa" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<input type="hidden" id="visaTmplBook" value="<?php echo $bookId ?>" />