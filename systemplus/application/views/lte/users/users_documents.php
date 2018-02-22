<div class="row">
	<?php
	showSessionMessageIfAny($this);
	?>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header with-border">
				<h2 class="box-title">
					<?php echo $breadcrumb2; ?>
				</h2>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-6 mr-top-4">
						<strong>Profile</strong>
					</div>
					<div class="col-xs-6">
						<input type="button" class="btn btn-primary btn-sm pull-right" id="btnEditProfile" value="Edit" />
					</div>
				</div>
				<hr class="mr-top-10">
				<div class="detailsDiv">
					<?php
					if ($usersData) {
						?>
						<div class="row">
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Name:</strong></div>
							<div class="col-sm-9 col-md-9 break-word mr-bt-tp-3">
								<input type="hidden" id="hiddTeacherAppId" value="<?php echo $usersData -> ta_id; ?>" />
								<input type="hidden" id="hiddFirstName" value="<?php echo $usersData -> ta_firstname; ?>" />
								<input type="hidden" id="hiddLastName" value="<?php echo $usersData -> ta_lastname; ?>" />
								<input type="hidden" id="hiddAbilityFromDate" value="<?php echo date('d/m/Y', strtotime($usersData -> ta_ablility_from)); ?>" />
								<input type="hidden" id="hiddAbilityToDate" value="<?php echo date('d/m/Y', strtotime($usersData -> ta_ablility_to)); ?>" />
								<?php echo html_entity_decode($usersData -> teacher_full_name); ?>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Date of birth:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo date('d/m/Y', strtotime($usersData -> ta_date_of_birth)); ?></div>

							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Nationality:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo (empty($usersData -> ta_nationality) ? '-' : ucfirst($usersData -> ta_nationality)); ?></div>
						</div>
						<div class="row">
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Gender:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo (empty($usersData -> ta_sex) ? '-' : $usersData -> ta_sex); ?></div>

							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Email:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($usersData -> ta_email == "" ? "-" : $usersData -> ta_email); ?></div>
						</div>
						<div class="row">
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Telephone:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($usersData -> ta_telephone == '' ? '-' : $usersData -> ta_telephone); ?></div>

							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Teach years:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($usersData -> ta_teach_years == '' ? '-' : $usersData -> ta_teach_years); ?></div>
						</div>
						<div class="row">
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Available from:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo date('d/m/Y', strtotime($usersData -> ta_ablility_from)); ?></div>

							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Available to:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo date('d/m/Y', strtotime($usersData -> ta_ablility_to)); ?></div>
						</div>
						<div class="row">
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Address:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($usersData -> ta_address == '' ? '-' : $usersData -> ta_address); ?></div>

							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>City:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($usersData -> ta_city == '' ? '-' : $usersData -> ta_city); ?></div>
						</div>
						<div class="row">
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Country:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($usersData -> ta_country == '' ? '-' : $usersData -> ta_country); ?></div>

							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Postcode:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($usersData -> postcode_area == '' ? '-' : $usersData -> ta_postcode . ' ' . $usersData -> postcode_area); ?></div>
						</div>
						<div class="row">
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Diplomas:</strong></div>
							<div class="col-sm-9 col-md-9 break-word mr-bt-tp-3"><?php
							if ($usersData -> ta_celta)
								echo "<span>CELTA</span>";
							if ($usersData -> ta_trinity_tesol)
								echo "<span>Trinity TESOL</span>";
							if ($usersData -> ta_delta)
								echo "<span>DELTA</span>";
							if ($usersData -> ta_dip_tesol)
								echo "<span>Dip. TESOL</span>";
							if ($usersData -> ta_b_ed)
								echo "<span>B.Ed.</span>";
							if ($usersData -> ta_pgce)
								echo "<span>PGCE (Primary, English or MFL)</span>";
							if ($usersData -> ta_ma_elt_tesol)
								echo "<span>MA in ELT//TESOL</span>";
							if (!empty($usersData -> ta_other_diploma))
								echo "<span>" . $usersData -> ta_other_diploma . "</span>";
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>CV File:</strong></div>
							<div class="col-sm-9 col-md-9 break-word mr-bt-tp-3"><a target="_blank" href="<?php echo base_url() . CV_FILE_PATH . $usersData -> ta_cv; ?>"><?php echo $usersData -> ta_cv; ?></a></div>
						</div>
						<div class="row">
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Other document:</strong></div>
							<div class="col-sm-9 col-md-9 break-word mr-bt-tp-3"><a target="_blank" href="<?php echo base_url() . OTHER_FILE_PATH . $usersData -> ta_other_document; ?>"><?php echo $usersData -> ta_other_document; ?></a></div>
						</div>
						<div class="row">
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Passport or id card:</strong></div>
							<div class="col-sm-9 col-md-9 break-word mr-bt-tp-3"><a target="_blank" href="<?php echo base_url() . PASSPORT_ID_CARD_FILE . $usersData -> ta_passport_or_id_card; ?>"><?php echo $usersData -> ta_passport_or_id_card; ?></a></div>
						</div>
					</div>
					<div class="detailsDiv">
						<br/>
						<strong>Additional information</strong>
						<hr />
						<div class="row">
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>NI number:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $usersData -> ta_ni_number; ?></div>

							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Right to work in UK:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($usersData -> ta_right_to_work_uk == '1' ? 'Yes' : 'No'); ?></div>
						</div>

						<div class="row">
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>NI category:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $usersData -> ta_ni_category; ?></div>

							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Making student loan repayment:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($usersData -> ta_making_slr == '1' ? 'Yes' : 'No'); ?></div>
						</div>

						<div class="row">
							<?php if ($usersData -> ta_making_slr == '1') { ?>
								<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Student loan repayment plan:</strong></div>
								<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $usersData -> ta_slr_plan; ?></div>

								<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Providing P45:</strong></div>
								<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($usersData -> ta_p45_status == '1' ? 'Yes' : 'No'); ?></div>

								<?php
							}
							else {
								?>
								<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Providing P45:</strong></div>
								<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($usersData -> ta_p45_status == '1' ? 'Yes' : 'No'); ?></div>
							<?php } ?>
						</div>

						<?php if ($usersData -> ta_p45_status == '0') { ?>
							<div class="row">
								<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Starter declaration:</strong></div>
								<div class="col-sm-9 col-md-9 break-word mr-bt-tp-3"><?php
					switch ($usersData -> ta_p45_starter_declaration) {
						case 'A':
							echo "Starter Declaration A: This is my first job since last 6 April and I have not been receiving taxable Jobseeker's Allowance, Employment and Support Allowance, taxable Incapacity Benefit, State or Occupational Pension.";
							break;
						case 'B':
							echo "Starter Declaration B: This is now my only job but since last 6 April I have had another job, or received taxable Jobseeker's Allowance, Employment and Support Allowance or taxable Incapacity Benefit. I do not receive a State or Occupational Pension.";
							break;
						case 'C':
							echo "Starter Declaration C: As well as my new job, I have another job or receive a State or Occupational Pension.";
							break;
						default:
							break;
					}
							?></div>
							</div>
						<?php } ?>




					</div>
					<div class="detailsDiv">
						<br/>
						<strong>Other files uploaded for office use</strong>
						<hr />
						<?php
						if ($appOtherFiles) {
							foreach ($appOtherFiles as $otherAppFile) {
								?>
								<div class="row">
									<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong><?php echo $otherAppFile['tof_title']; ?>:</strong></div>
									<div class="col-sm-9 col-md-9 break-word mr-bt-tp-3"><a target="_blank" href="<?php echo base_url() . OFFICE_OTHER_FILE_PATH . $otherAppFile['tof_filename']; ?>"><?php echo $otherAppFile['tof_filename']; ?></a></div>
								</div>
								<?php
							}
						}
					}
					else {
						echo "<div>Unable to find users profile.</div>";
					}
					?>
				</div>
				<div class="detailsDiv">
					<div class="row">
						<div class="col-xs-10 mr-top-4">
							<strong>Bank details</strong>
						</div>
						<div class="col-xs-2 text-right">
							<input type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#bankEditModal" id="btnBankEdit" value="Edit" />
						</div>
					</div>
					<hr class="mr-top-10">
					<div class="row">
						<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Currency type:</strong></div>
						<div class="col-xs-9 col-xs-9 break-word mr-bt-tp-3">
							<?php echo $usersData -> tbd_currency_type; ?>
						</div>
					</div>
					<div class="row">
						<?php if ($usersData -> tbd_currency_type == 'GBP') { ?>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Account name:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $usersData -> tbd_account_name; ?></div>

							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Sort code:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($usersData -> tbd_sort_code); ?></div>
							<?php
						}
						else {
							?>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Account name:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $usersData -> tbd_account_name; ?></div>

							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>IBAN:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($usersData -> tbd_iban); ?></div>
						<?php } ?>
					</div>
					<div class="row">
						<?php if ($usersData -> tbd_currency_type == 'GBP') { ?>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Account number:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $usersData -> tbd_account_number; ?></div>
							<?php
						}
						else {
							?>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Swift/BIC:</strong></div>
							<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($usersData -> tbd_swift_bic); ?></div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade modalRply" id="bankEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Bank details</h4>
			</div>
			<div class="modal-body">
				<form id="frmBankDetail" action="">
					<div class="row">
						<div class="col-md-2">
							<label>
								<strong>Currency type</strong>
							</label>
						</div>
						<div class="form-data col-md-10" >
							<select autocomplete="off" id="selCurrencyType" name="selCurrencyType" class="required form-control">
								<option <?php echo ($usersData -> tbd_currency_type == 'GBP' ? 'selected="selected"' : ''); ?> value="GBP">GBP(&pound;)</option>
								<option <?php echo ($usersData -> tbd_currency_type == 'Overseas' ? 'selected="selected"' : ''); ?> value="Overseas">Overseas</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<label for="txtAccountName">
								<strong>Account name</strong>
							</label>
						</div>
						<div class="form-data col-md-10">
							<input title="If this is not your account we require written authorisation from you
								   " data-toggle="tooltip" type="text" placeholder="Account name" name="txtAccountName" id="txtAccountName" class="required form-control"   maxlength="100" value="<?php echo $usersData -> tbd_account_name; ?>" >
							<div class="error"></div>
						</div>
					</div>
					<div class="row grGBP">
						<div class="col-md-2">
							<label for="txtSortCode">
								<strong>Sort code</strong>
							</label>
						</div>
						<div class="form-data col-md-10">
							<input type="text" placeholder="Sort code" name="txtSortCode" id="txtSortCode" class="required form-control"   maxlength="100" value="<?php echo $usersData -> tbd_sort_code; ?>" >
							<div class="error"></div>
						</div>
					</div>
					<div class="row grGBP">
						<div class="col-md-2">
							<label for="txtAccountNumber">
								<strong>Account number</strong>
							</label>
						</div>
						<div class="form-data col-md-10">
							<input type="text" placeholder="Account number" name="txtAccountNumber" id="txtAccountNumber" class="required form-control"   maxlength="100" value="<?php echo $usersData -> tbd_account_number; ?>" >
							<div class="error"></div>
						</div>
					</div>
					<div class="row grOverseas">
						<div class="col-md-2">
							<label for="txtIBAN">
								<strong>IBAN</strong>
							</label>
						</div>
						<div class="form-data col-md-10">
							<input type="text" placeholder="IBAN" name="txtIBAN" id="txtIBAN" class="required form-control"   maxlength="100" value="<?php echo $usersData -> tbd_iban; ?>" >
							<div class="error"></div>
						</div>
					</div>
					<div class="row grOverseas">
						<div class="col-md-2">
							<label for="txtSwiftBIC">
								<strong>Swift/BIC</strong>
							</label>
						</div>
						<div class="form-data col-md-10">
							<input type="text" placeholder="Swift/BIC" name="txtSwiftBIC" id="txtSwiftBIC" class="required form-control"   maxlength="100" value="<?php echo $usersData -> tbd_swift_bic; ?>" >
							<div class="error"></div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div id="bank-detail-msg"></div>
				</div>
				<div class="row">
					<div class="col-md-12 text-center">
						<button class="submit btn btn-primary btn-sm" id="submitBankDetails">Submit</button>
						<button class="cancel btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script type="text/javascript">
        
	$(document).ready(function() {	
		$("#frmBankDetail").validate();
		$( "body" ).on( "click", "#btnEditProfile",function(){
			window.location.href = siteUrl + "users/editprofile";
		});

		$( "body" ).on( "change", "#selCurrencyType",function(){
			var myVal = $(this).val();
			if(myVal == 'GBP')
			{
				$(".grOverseas").hide();
				$(".grGBP").show();
			}
			else if(myVal == 'Overseas'){
				$(".grOverseas").show();
				$(".grGBP").hide();
			}
			else
			{
				$(".grOverseas").hide();
				$(".grGBP").hide();
			}
			$("#frmBankDetail .form-data").css('height','69px');
		});
            
		$("#selCurrencyType").trigger('change');
	});
	$('#bankEditModal').on('hidden.bs.modal', function () {
		$("#frmBankDetail")[0].reset();
	});
	$('#bankEditModal').on('shown.bs.modal', function () {
		$('#frmBankDetail').valid({
			txtAccountName: {
				required: 'Account number is mandatory'
			}
		});
	});
	$('body').on('click','#submitBankDetails',function(){
		
		$("#bank-detail-msg").html('');
		if ($('#frmBankDetail').valid()) {
			var selCurrencyType = $("#selCurrencyType").val();
			var txtAccountName = $('#txtAccountName').val();
			var txtSortCode = $('#txtSortCode').val();
			var txtAccountNumber = $('#txtAccountNumber').val();
			var txtIBAN = $('#txtIBAN').val();
			var txtSwiftBIC = $('#txtSwiftBIC').val();
			var allowed = true;
			if(selCurrencyType == "GBP")
			{
				$( "#txtSortCode" ).rules( "add", {
					maxlength: 6,
					minlength: 6,
					digits: true,
					messages: {
						maxlength: jQuery.validator.format("Sort code should be {0} digit in length"),
						minlength: jQuery.validator.format("Sort code should be {0} digit in length")
					}
				});
                            
				$( "#txtAccountNumber" ).rules( "add", {
					maxlength: 8,
					minlength: 8,
					digits: true,
					messages: {
						maxlength: jQuery.validator.format("Account number should be {0} digit in length"),
						minlength: jQuery.validator.format("Account number should be {0} digit in length")
					}
				});
                            
				$el = $("button.submit").parents('.ui-dialog-content');
				if(!$('#frmBankDetail').valid())
					allowed = false;
				$( "#txtSortCode" ).rules( "remove", "maxlength minlength numeric" );
				$( "#txtAccountNumber" ).rules( "remove", "maxlength minlength numeric" );
			}
			if(allowed)
				$.post( siteUrl + "users/updatebankdetails",{
					'selCurrencyType':selCurrencyType,
					'txtAccountName':txtAccountName,
					'txtSortCode':txtSortCode,
					'txtAccountNumber':txtAccountNumber,
					'txtIBAN':txtIBAN,
					'txtSwiftBIC':txtSwiftBIC
				}, function( data ) {
				if(parseInt(data.result))
				{
					$("#bank-detail-msg").html('<div class="col-md-12"><div class="alert alert-success alert-dismissable text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div></div>');
					//$el.find('form')[0].reset();
					setTimeout(function(){
						$('#bankEditModal').modal('toggle');
						window.location.reload();
					},'1500');
				}
				else
				{
					$("#bank-detail-msg").html('<div class="col-md-12"><div class="alert alert-danger alert-dismissable text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div></div>');
				}
			},'json');
		}
	});
</script>

