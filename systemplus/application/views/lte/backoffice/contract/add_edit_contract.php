<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<div class="row">
	<?php
        if(isset($error_message))
            showSessionMessageIfAny($this,"",$error_message);
        else
            showSessionMessageIfAny($this);
	?>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box">

			<div class="box-header with-border">
				<h2 class="box-title"><?php echo $breadcrumb2; ?></h2>

			</div>

			<div class="box-body">
				<form method="post" id="frmTeacher" action="">
					<div class="row form-group">
						<div class="col-md-2">
							<label for="selApplicant">
								<strong>Applicant</strong>
							</label>
						</div>

						<div class="form-data col-md-5">
							<select id="selApplicant" name="selApplicant" class="form-control"   >
								<option value="">Select applicant</option>
								<?php
								if (!empty($applicants)) {
									foreach ($applicants as $applicant) {
										?>
										<option <?php echo ($formData['selApplicant'] == $applicant['ta_id'] ? "selected='selected'" : ''); ?> value="<?php echo $applicant['ta_id'] ?>"><?php echo $applicant['ta_firstname'] . ' ' . $applicant['ta_lastname'] ?></option>
										<?php
									}
								}
								?>
							</select>
							<?php if ($edit_id) { ?>
								<input type="hidden" name="selApplicant" value="<?php echo $formData['selApplicant']; ?>" />
							<?php } ?>
							<div for="selApplicant" generated="true" class="error"><?php echo form_error('selApplicant'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtEmail">
								<strong>Email</strong>
							</label>
						</div>
						<div class="form-data col-md-5">
							<input type="text" class="respon-width form-control"  placeholder="Email" id="txtEmail" name="txtEmail" value="<?php echo set_value('txtEmail', $formData['txtEmail']); ?>" >
							<div class="error"><?php echo form_error('txtEmail'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="selPosition" >
								<strong>Position</strong>
							</label>
						</div>
						<div class="form-data col-md-5">
							<select   id="selPosition" name="selPosition" class=" form-control"  >
								<option value="">Select position</option>
								<?php
								if (!empty($positions)) {
									foreach ($positions as $position) {
										?>
										<option <?php echo ($formData['selPosition'] == $position['pos_id'] ? "selected='selected'" : ''); ?> value="<?php echo $position['pos_id'] ?>"><?php echo $position['pos_position'] ?></option>
										<?php
									}
								}
								?>
							</select>
							<div for="selPosition" generated="true" class="error"><?php echo form_error('selPosition'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtCalFromDate">
								<strong>Period</strong>
							</label>
						</div>
						<div class="form-data col-md-10">
							<div class="row">
								<div class="col-md-3">
									<label>From date: </label>
									<input type="text" class="form-control" id="txtConFromDate" name="fd" value="<?php echo (!empty($formData['txtConFromDate']) ? date('d/m/Y', strtotime($formData['txtConFromDate'])) : '') ?>"   />
								</div>

								<div class="col-md-3">
									<label>To date: </label>
									<input class="form-control" type="text" id="txtConToDate" name="td" if="<?php echo $formData['txtConToDate'] ?>" value="<?php echo (!empty($formData['txtConToDate']) ? date('d/m/Y', strtotime($formData['txtConToDate'])) : ''); ?>"  /> 
								</div>
								<span style="clear: both;" for="txtConFromDate" generated="true" class="error"></span>
								<span style="clear: both;" for="txtConToDate" generated="true" class="error"></span>
							</div>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-2">
							<label for="selCampus">
								<strong>Campus</strong>
							</label>
						</div>
						<div class="form-data col-md-5">
							<select   id="selCampus" name="selCampus" class="form-control"  >
								<option value="">Select campus</option>
								<?php
								if (!empty($campuses)) {
									foreach ($campuses as $campus) {
										?>
										<option <?php echo ($formData['selCampus'] == $campus['id'] ? "selected='selected'" : ''); ?> value="<?php echo $campus['id'] ?>"><?php echo $campus['nome_centri'] ?></option>
										<?php
									}
								}
								?>
							</select>
							<div for="selCampus" generated="true" class="error"><?php echo form_error('selCampus'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="selWages" >
								<strong>Wages</strong>
							</label>
						</div>
						<div class="form-data col-md-5" >
							<select id="selWages"    name="selWages" class="form-control" >
								<option value="">Select wages</option>
								<option <?php echo ($formData['selWages'] == "Hourly" ? "selected='selected'" : ""); ?> value="Hourly">Hourly</option>
								<option <?php echo ($formData['selWages'] == "Weekly" ? "selected='selected'" : ""); ?> value="Weekly">Weekly</option>
							</select>
							<div for="selWages" generated="true" class="error"><?php echo form_error('selWages'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtSalary" >
								<strong>Salary</strong>
							</label>
						</div>
						<div class="form-data col-md-5" >
							<input type="text" id="txtSalary" name="txtSalary"  decimal-only  class="form-control" maxlength="13" value="<?php echo set_value('txtSalary', $formData['txtSalary']); ?>" >
							<div class="error"><?php echo form_error('txtSalary'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="selCurrency" >
								<strong>Currency</strong>
							</label>
						</div>
						<div class="form-data col-md-5" >
							<select   id="selCurrency" name="selCurrency" class="form-control"  >
								<option value="">Select currency</option>
								<option <?php echo ($formData['selCurrency'] == 'GBP' ? "selected='selected'" : ''); ?>  value="GBP">GBP</option>
								<option <?php echo ($formData['selCurrency'] == 'EUR' ? "selected='selected'" : ''); ?> value="EUR">EUR</option>
								<option <?php echo ($formData['selCurrency'] == 'USD' ? "selected='selected'" : ''); ?> value="USD">USD</option>
							</select>
							<div for="selCurrency" generated="true" class="error"><?php echo form_error('selCurrency'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="selResidential" >
								<strong>Residential</strong>
							</label>
						</div>
						<div class="form-data col-md-5" >
							<select   id="selResidential" name="selResidential" class="form-control"  >
								<option value="">Select residential</option>
								<option <?php echo ($formData['selResidential'] == 'Residential' ? "selected='selected'" : ''); ?> value="Residential">Residential</option>
								<option <?php echo ($formData['selResidential'] == 'Non-residential' ? "selected='selected'" : ''); ?> value="Non-residential">Non-residential</option>
							</select>
							<div for="selResidential" generated="true" class="error"><?php echo form_error('selResidential'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtHoursPerWeek" >
								<strong>Hours/week</strong>
							</label>
						</div>
						<div class="form-data col-md-5" >
							<input type="text" id="txtHoursPerWeek" class="form-control" name="txtHoursPerWeek"   onkeypress="return keyRestrict(event,'1234567890');"  style="width:75px;"  maxlength="6" value="<?php echo set_value('txtHoursPerWeek', $formData['txtHoursPerWeek']); ?>" >
							<div class="error"><?php echo form_error('txtHoursPerWeek'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="selExtraActivity" >
								<strong>Extra activity</strong>
							</label>

						</div>
						<div class="form-data col-md-5" >
							<select class="form-control" id="selExtraActivity" name="selExtraActivity" >
								<option value="">Select extra activity</option>
								<option <?php echo ($formData['selExtraActivity'] == 'A' ? "selected='selected'" : ''); ?> value="A">A</option>
								<option <?php echo ($formData['selExtraActivity'] == 'B' ? "selected='selected'" : ''); ?> value="B">B</option>
								<option <?php echo ($formData['selExtraActivity'] == 'C' ? "selected='selected'" : ''); ?> value="C">C</option>
							</select>
							<div for="selExtraActivity" generated="true" class="error"><?php echo form_error('selExtraActivity'); ?></div>
						</div>
					</div>
                                        <div class="row form-group">
						<div class="col-md-2">
							<label for="selBoard" >
								<strong>Board as basis</strong>
							</label>

						</div>
						<div class="form-data col-md-5" >
							<select class="form-control" id="selBoard" name="selBoard" >
								<option value="">Select board</option>
								<option <?php echo ($formData['selBoard'] == 'full board basis' ? "selected='selected'" : ''); ?> value="full board basis">full board basis</option>
                                                                <option <?php echo ($formData['selBoard'] == 'self-catering basis' ? "selected='selected'" : ''); ?> value="self-catering basis">self-catering basis</option>
								<option <?php echo ($formData['selBoard'] == 'self-catering basis with lunches on work days only' ? "selected='selected'" : ''); ?> value="self-catering basis with lunches on work days only">self-catering basis with lunches on work days only</option>
								<!--option <?php //echo ($formData['selBoard'] == 'Lunches on work days only' ? "selected='selected'" : ''); ?> value="Lunches on work days only">Lunches on work days only</option -->
							</select>
							<div for="selExtraActivity" generated="true" class="error"><?php echo form_error('selExtraActivity'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="rdoReturnee" >
								<strong>Returnee</strong>
							</label>
						</div>
						<div class="form-data col-md-5" >
							<input <?php echo ($formData['rdoReturnee'] == '1' ? "checked='checked'" : ''); ?> type="checkbox" name="rdoReturnee" id="rdoReturnee" />
							<div class="error"><?php echo form_error('rdoReturnee'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="rdoContractSigned" >
								<strong>Contract status</strong>
							</label>
						</div>
						<div class="form-data col-md-5" >
							<input <?php echo ($formData['rdoContractSigned'] == '1' ? "checked='checked'" : ''); ?> value="1" type="checkbox" name="rdoContractSigned" id="rdoContractSigned" />
							<label for="rdoContractSigned">Contract signed and that we have received it.</label>
							<div class="error"><?php echo form_error('rdoContractSigned'); ?></div>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-12">
							<h4>Address</h4>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtAddress" >
								<strong>Address</strong>
							</label>
						</div>
						<div class="form-data col-md-5" >
							<textarea rows="3" class="  respon-width form-control" placeholder="Address" id="txtAddress" name="txtAddress"><?php echo set_value('txtAddress', $formData['txtAddress']); ?></textarea>
							<div class="error"><?php echo form_error('txtAddress'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtCity" >
								<strong>City</strong>
							</label>
						</div>
						<div class="form-data col-md-5" >
							<input type="text" class="  respon-width form-control" placeholder="City" id="txtCity" name="txtCity" value="<?php echo set_value('txtCity', $formData['txtCity']); ?>" >
							<div class="error"><?php echo form_error('txtCity'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="selPostCode" >
								<strong>Postcode</strong>
							</label>
						</div>
						<div class="form-data col-md-5" >
							<select id="selPostCode" name="selPostCode" class="form-control"  >
								<?php
								if ($postcodeData) {
									foreach ($postcodeData as $postcode) {
										?><option <?php echo ($formData['selPostCode'] == $postcode['code'] ? "selected='selected'" : ""); ?> value="<?php echo $postcode['code']; ?>"><?php echo $postcode['area']; ?></option><?php
							}
						}
								?>
							</select>
							<div for="selPostCode" generated="true" class="error"><?php echo form_error('selPostCode'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="selCountry" >
								<strong>Country</strong>
							</label>
						</div>
						<div class="form-data col-md-5" >
							<select id="selCountry" class="form-control" name="selCountry">
								<option <?php echo ($formData['selCountry'] == 'Afganistan' ? "selected='selected'" : ''); ?> value='Afganistan'>Afganistan</option>
								<option <?php echo ($formData['selCountry'] == 'Albania' ? "selected='selected'" : ''); ?> value='Albania'>Albania</option>
								<option <?php echo ($formData['selCountry'] == 'Algeria' ? "selected='selected'" : ''); ?> value='Algeria'>Algeria</option>
								<option <?php echo ($formData['selCountry'] == 'American Samoa' ? "selected='selected'" : ''); ?> value='American Samoa'>American Samoa</option>
								<option <?php echo ($formData['selCountry'] == 'Andorra' ? "selected='selected'" : ''); ?> value='Andorra'>Andorra</option>
								<option <?php echo ($formData['selCountry'] == 'Angola' ? "selected='selected'" : ''); ?> value='Angola'>Angola</option>
								<option <?php echo ($formData['selCountry'] == 'Anguilla' ? "selected='selected'" : ''); ?> value='Anguilla'>Anguilla</option>
								<option <?php echo ($formData['selCountry'] == 'Antigua &amp; Barbuda' ? "selected='selected'" : ''); ?> value='Antigua &amp; Barbuda'>Antigua &amp; Barbuda</option>
								<option <?php echo ($formData['selCountry'] == 'Argentina' ? "selected='selected'" : ''); ?> value='Argentina'>Argentina</option>
								<option <?php echo ($formData['selCountry'] == 'Armenia' ? "selected='selected'" : ''); ?> value='Armenia'>Armenia</option>
								<option <?php echo ($formData['selCountry'] == 'Aruba' ? "selected='selected'" : ''); ?> value='Aruba'>Aruba</option>
								<option <?php echo ($formData['selCountry'] == 'Australia' ? "selected='selected'" : ''); ?> value='Australia'>Australia</option>
								<option <?php echo ($formData['selCountry'] == 'Austria' ? "selected='selected'" : ''); ?> value='Austria'>Austria</option>
								<option <?php echo ($formData['selCountry'] == 'Azerbaijan' ? "selected='selected'" : ''); ?> value='Azerbaijan'>Azerbaijan</option>
								<option <?php echo ($formData['selCountry'] == 'Bahamas' ? "selected='selected'" : ''); ?> value='Bahamas'>Bahamas</option>
								<option <?php echo ($formData['selCountry'] == 'Bahrain' ? "selected='selected'" : ''); ?> value='Bahrain'>Bahrain</option>
								<option <?php echo ($formData['selCountry'] == 'Bangladesh' ? "selected='selected'" : ''); ?> value='Bangladesh'>Bangladesh</option>
								<option <?php echo ($formData['selCountry'] == 'Barbados' ? "selected='selected'" : ''); ?> value='Barbados'>Barbados</option>
								<option <?php echo ($formData['selCountry'] == 'Belarus' ? "selected='selected'" : ''); ?> value='Belarus'>Belarus</option>
								<option <?php echo ($formData['selCountry'] == 'Belgium' ? "selected='selected'" : ''); ?> value='Belgium'>Belgium</option>
								<option <?php echo ($formData['selCountry'] == 'Belize' ? "selected='selected'" : ''); ?> value='Belize'>Belize</option>
								<option <?php echo ($formData['selCountry'] == 'Benin' ? "selected='selected'" : ''); ?> value='Benin'>Benin</option>
								<option <?php echo ($formData['selCountry'] == 'Bermuda' ? "selected='selected'" : ''); ?> value='Bermuda'>Bermuda</option>
								<option <?php echo ($formData['selCountry'] == 'Bhutan' ? "selected='selected'" : ''); ?> value='Bhutan'>Bhutan</option>
								<option <?php echo ($formData['selCountry'] == 'Bolivia' ? "selected='selected'" : ''); ?> value='Bolivia'>Bolivia</option>
								<option <?php echo ($formData['selCountry'] == 'Bonaire' ? "selected='selected'" : ''); ?> value='Bonaire'>Bonaire</option>
								<option <?php echo ($formData['selCountry'] == 'Bosnia &amp; Herzegovina' ? "selected='selected'" : ''); ?> value='Bosnia &amp; Herzegovina'>Bosnia &amp; Herzegovina</option>
								<option <?php echo ($formData['selCountry'] == 'Botswana' ? "selected='selected'" : ''); ?> value='Botswana'>Botswana</option>
								<option <?php echo ($formData['selCountry'] == 'Brazil' ? "selected='selected'" : ''); ?> value='Brazil'>Brazil</option>
								<option <?php echo ($formData['selCountry'] == 'British Indian Ocean Ter' ? "selected='selected'" : ''); ?> value='British Indian Ocean Ter'>British Indian Ocean Ter</option>
								<option <?php echo ($formData['selCountry'] == 'Brunei' ? "selected='selected'" : ''); ?> value='Brunei'>Brunei</option>
								<option <?php echo ($formData['selCountry'] == 'Bulgaria' ? "selected='selected'" : ''); ?> value='Bulgaria'>Bulgaria</option>
								<option <?php echo ($formData['selCountry'] == 'Burkina Faso' ? "selected='selected'" : ''); ?> value='Burkina Faso'>Burkina Faso</option>
								<option <?php echo ($formData['selCountry'] == 'Burundi' ? "selected='selected'" : ''); ?> value='Burundi'>Burundi</option>
								<option <?php echo ($formData['selCountry'] == 'Cambodia' ? "selected='selected'" : ''); ?> value='Cambodia'>Cambodia</option>
								<option <?php echo ($formData['selCountry'] == 'Cameroon' ? "selected='selected'" : ''); ?> value='Cameroon'>Cameroon</option>
								<option <?php echo ($formData['selCountry'] == 'Canada' ? "selected='selected'" : ''); ?> value='Canada'>Canada</option>
								<option <?php echo ($formData['selCountry'] == 'Canary Islands' ? "selected='selected'" : ''); ?> value='Canary Islands'>Canary Islands</option>
								<option <?php echo ($formData['selCountry'] == 'Cape Verde' ? "selected='selected'" : ''); ?> value='Cape Verde'>Cape Verde</option>
								<option <?php echo ($formData['selCountry'] == 'Cayman Islands' ? "selected='selected'" : ''); ?> value='Cayman Islands'>Cayman Islands</option>
								<option <?php echo ($formData['selCountry'] == 'Central African Republic' ? "selected='selected'" : ''); ?> value='Central African Republic'>Central African Republic</option>
								<option <?php echo ($formData['selCountry'] == 'Chad' ? "selected='selected'" : ''); ?> value='Chad'>Chad</option>
								<option <?php echo ($formData['selCountry'] == 'Channel Islands' ? "selected='selected'" : ''); ?> value='Channel Islands'>Channel Islands</option>
								<option <?php echo ($formData['selCountry'] == 'Chile' ? "selected='selected'" : ''); ?> value='Chile'>Chile</option>
								<option <?php echo ($formData['selCountry'] == 'China' ? "selected='selected'" : ''); ?> value='China'>China</option>
								<option <?php echo ($formData['selCountry'] == 'Christmas Island' ? "selected='selected'" : ''); ?> value='Christmas Island'>Christmas Island</option>
								<option <?php echo ($formData['selCountry'] == 'Cocos Island' ? "selected='selected'" : ''); ?> value='Cocos Island'>Cocos Island</option>
								<option <?php echo ($formData['selCountry'] == 'Colombia' ? "selected='selected'" : ''); ?> value='Colombia'>Colombia</option>
								<option <?php echo ($formData['selCountry'] == 'Comoros' ? "selected='selected'" : ''); ?> value='Comoros'>Comoros</option>
								<option <?php echo ($formData['selCountry'] == 'Congo' ? "selected='selected'" : ''); ?> value='Congo'>Congo</option>
								<option <?php echo ($formData['selCountry'] == 'Cook Islands' ? "selected='selected'" : ''); ?> value='Cook Islands'>Cook Islands</option>
								<option <?php echo ($formData['selCountry'] == 'Costa Rica' ? "selected='selected'" : ''); ?> value='Costa Rica'>Costa Rica</option>
								<option <?php echo ($formData['selCountry'] == 'Cote DIvoire' ? "selected='selected'" : ''); ?> value='Cote DIvoire'>Cote DIvoire</option>
								<option <?php echo ($formData['selCountry'] == 'Croatia' ? "selected='selected'" : ''); ?> value='Croatia'>Croatia</option>
								<option <?php echo ($formData['selCountry'] == 'Cuba' ? "selected='selected'" : ''); ?> value='Cuba'>Cuba</option>
								<option <?php echo ($formData['selCountry'] == 'Curaco' ? "selected='selected'" : ''); ?> value='Curaco'>Curaco</option>
								<option <?php echo ($formData['selCountry'] == 'Cyprus' ? "selected='selected'" : ''); ?> value='Cyprus'>Cyprus</option>
								<option <?php echo ($formData['selCountry'] == 'Czech Republic' ? "selected='selected'" : ''); ?> value='Czech Republic'>Czech Republic</option>
								<option <?php echo ($formData['selCountry'] == 'Denmark' ? "selected='selected'" : ''); ?> value='Denmark'>Denmark</option>
								<option <?php echo ($formData['selCountry'] == 'Djibouti' ? "selected='selected'" : ''); ?> value='Djibouti'>Djibouti</option>
								<option <?php echo ($formData['selCountry'] == 'Dominica' ? "selected='selected'" : ''); ?> value='Dominica'>Dominica</option>
								<option <?php echo ($formData['selCountry'] == 'Dominican Republic' ? "selected='selected'" : ''); ?> value='Dominican Republic'>Dominican Republic</option>
								<option <?php echo ($formData['selCountry'] == 'East Timor' ? "selected='selected'" : ''); ?> value='East Timor'>East Timor</option>
								<option <?php echo ($formData['selCountry'] == 'Ecuador' ? "selected='selected'" : ''); ?> value='Ecuador'>Ecuador</option>
								<option <?php echo ($formData['selCountry'] == 'Egypt' ? "selected='selected'" : ''); ?> value='Egypt'>Egypt</option>
								<option <?php echo ($formData['selCountry'] == 'El Salvador' ? "selected='selected'" : ''); ?> value='El Salvador'>El Salvador</option>
								<option <?php echo ($formData['selCountry'] == 'Equatorial Guinea' ? "selected='selected'" : ''); ?> value='Equatorial Guinea'>Equatorial Guinea</option>
								<option <?php echo ($formData['selCountry'] == 'Eritrea' ? "selected='selected'" : ''); ?> value='Eritrea'>Eritrea</option>
								<option <?php echo ($formData['selCountry'] == 'Estonia' ? "selected='selected'" : ''); ?> value='Estonia'>Estonia</option>
								<option <?php echo ($formData['selCountry'] == 'Ethiopia' ? "selected='selected'" : ''); ?> value='Ethiopia'>Ethiopia</option>
								<option <?php echo ($formData['selCountry'] == 'Falkland Islands' ? "selected='selected'" : ''); ?> value='Falkland Islands'>Falkland Islands</option>
								<option <?php echo ($formData['selCountry'] == 'Faroe Islands' ? "selected='selected'" : ''); ?> value='Faroe Islands'>Faroe Islands</option>
								<option <?php echo ($formData['selCountry'] == 'Fiji' ? "selected='selected'" : ''); ?> value='Fiji'>Fiji</option>
								<option <?php echo ($formData['selCountry'] == 'Finland' ? "selected='selected'" : ''); ?> value='Finland'>Finland</option>
								<option <?php echo ($formData['selCountry'] == 'France' ? "selected='selected'" : ''); ?> value='France'>France</option>
								<option <?php echo ($formData['selCountry'] == 'French Guiana' ? "selected='selected'" : ''); ?> value='French Guiana'>French Guiana</option>
								<option <?php echo ($formData['selCountry'] == 'French Polynesia' ? "selected='selected'" : ''); ?> value='French Polynesia'>French Polynesia</option>
								<option <?php echo ($formData['selCountry'] == 'French Southern Ter' ? "selected='selected'" : ''); ?> value='French Southern Ter'>French Southern Ter</option>
								<option <?php echo ($formData['selCountry'] == 'Gabon' ? "selected='selected'" : ''); ?> value='Gabon'>Gabon</option>
								<option <?php echo ($formData['selCountry'] == 'Gambia' ? "selected='selected'" : ''); ?> value='Gambia'>Gambia</option>
								<option <?php echo ($formData['selCountry'] == 'Georgia' ? "selected='selected'" : ''); ?> value='Georgia'>Georgia</option>
								<option <?php echo ($formData['selCountry'] == 'Germany' ? "selected='selected'" : ''); ?> value='Germany'>Germany</option>
								<option <?php echo ($formData['selCountry'] == 'Ghana' ? "selected='selected'" : ''); ?> value='Ghana'>Ghana</option>
								<option <?php echo ($formData['selCountry'] == 'Gibraltar' ? "selected='selected'" : ''); ?> value='Gibraltar'>Gibraltar</option>
								<option <?php echo ($formData['selCountry'] == 'Great Britain' ? "selected='selected'" : ''); ?> value='Great Britain'>Great Britain</option>
								<option <?php echo ($formData['selCountry'] == 'Greece' ? "selected='selected'" : ''); ?> value='Greece'>Greece</option>
								<option <?php echo ($formData['selCountry'] == 'Greenland' ? "selected='selected'" : ''); ?> value='Greenland'>Greenland</option>
								<option <?php echo ($formData['selCountry'] == 'Grenada' ? "selected='selected'" : ''); ?> value='Grenada'>Grenada</option>
								<option <?php echo ($formData['selCountry'] == 'Guadeloupe' ? "selected='selected'" : ''); ?> value='Guadeloupe'>Guadeloupe</option>
								<option <?php echo ($formData['selCountry'] == 'Guam' ? "selected='selected'" : ''); ?> value='Guam'>Guam</option>
								<option <?php echo ($formData['selCountry'] == 'Guatemala' ? "selected='selected'" : ''); ?> value='Guatemala'>Guatemala</option>
								<option <?php echo ($formData['selCountry'] == 'Guinea' ? "selected='selected'" : ''); ?> value='Guinea'>Guinea</option>
								<option <?php echo ($formData['selCountry'] == 'Guyana' ? "selected='selected'" : ''); ?> value='Guyana'>Guyana</option>
								<option <?php echo ($formData['selCountry'] == 'Haiti' ? "selected='selected'" : ''); ?> value='Haiti'>Haiti</option>
								<option <?php echo ($formData['selCountry'] == 'Hawaii' ? "selected='selected'" : ''); ?> value='Hawaii'>Hawaii</option>
								<option <?php echo ($formData['selCountry'] == 'Honduras' ? "selected='selected'" : ''); ?> value='Honduras'>Honduras</option>
								<option <?php echo ($formData['selCountry'] == 'Hong Kong' ? "selected='selected'" : ''); ?> value='Hong Kong'>Hong Kong</option>
								<option <?php echo ($formData['selCountry'] == 'Hungary' ? "selected='selected'" : ''); ?> value='Hungary'>Hungary</option>
								<option <?php echo ($formData['selCountry'] == 'Iceland' ? "selected='selected'" : ''); ?> value='Iceland'>Iceland</option>
								<option <?php echo ($formData['selCountry'] == 'India' ? "selected='selected'" : ''); ?> value='India'>India</option>
								<option <?php echo ($formData['selCountry'] == 'Indonesia' ? "selected='selected'" : ''); ?> value='Indonesia'>Indonesia</option>
								<option <?php echo ($formData['selCountry'] == 'Iran' ? "selected='selected'" : ''); ?> value='Iran'>Iran</option>
								<option <?php echo ($formData['selCountry'] == 'Iraq' ? "selected='selected'" : ''); ?> value='Iraq'>Iraq</option>
								<option <?php echo ($formData['selCountry'] == 'Ireland' ? "selected='selected'" : ''); ?> value='Ireland'>Ireland</option>
								<option <?php echo ($formData['selCountry'] == 'Isle of Man' ? "selected='selected'" : ''); ?> value='Isle of Man'>Isle of Man</option>
								<option <?php echo ($formData['selCountry'] == 'Israel' ? "selected='selected'" : ''); ?> value='Israel'>Israel</option>
								<option <?php echo ($formData['selCountry'] == 'Italy' ? "selected='selected'" : ''); ?> value='Italy'>Italy</option>
								<option <?php echo ($formData['selCountry'] == 'Jamaica' ? "selected='selected'" : ''); ?> value='Jamaica'>Jamaica</option>
								<option <?php echo ($formData['selCountry'] == 'Japan' ? "selected='selected'" : ''); ?> value='Japan'>Japan</option>
								<option <?php echo ($formData['selCountry'] == 'Jordan' ? "selected='selected'" : ''); ?> value='Jordan'>Jordan</option>
								<option <?php echo ($formData['selCountry'] == 'Kazakhstan' ? "selected='selected'" : ''); ?> value='Kazakhstan'>Kazakhstan</option>
								<option <?php echo ($formData['selCountry'] == 'Kenya' ? "selected='selected'" : ''); ?> value='Kenya'>Kenya</option>
								<option <?php echo ($formData['selCountry'] == 'Kiribati' ? "selected='selected'" : ''); ?> value='Kiribati'>Kiribati</option>
								<option <?php echo ($formData['selCountry'] == 'Korea North' ? "selected='selected'" : ''); ?> value='Korea North'>Korea North</option>
								<option <?php echo ($formData['selCountry'] == 'Korea Sout' ? "selected='selected'" : ''); ?> value='Korea Sout'>Korea Sout</option>
								<option <?php echo ($formData['selCountry'] == 'Kuwait' ? "selected='selected'" : ''); ?> value='Kuwait'>Kuwait</option>
								<option <?php echo ($formData['selCountry'] == 'Kyrgyzstan' ? "selected='selected'" : ''); ?> value='Kyrgyzstan'>Kyrgyzstan</option>
								<option <?php echo ($formData['selCountry'] == 'Laos' ? "selected='selected'" : ''); ?> value='Laos'>Laos</option>
								<option <?php echo ($formData['selCountry'] == 'Latvia' ? "selected='selected'" : ''); ?> value='Latvia'>Latvia</option>
								<option <?php echo ($formData['selCountry'] == 'Lebanon' ? "selected='selected'" : ''); ?> value='Lebanon'>Lebanon</option>
								<option <?php echo ($formData['selCountry'] == 'Lesotho' ? "selected='selected'" : ''); ?> value='Lesotho'>Lesotho</option>
								<option <?php echo ($formData['selCountry'] == 'Liberia' ? "selected='selected'" : ''); ?> value='Liberia'>Liberia</option>
								<option <?php echo ($formData['selCountry'] == 'Libya' ? "selected='selected'" : ''); ?> value='Libya'>Libya</option>
								<option <?php echo ($formData['selCountry'] == 'Liechtenstein' ? "selected='selected'" : ''); ?> value='Liechtenstein'>Liechtenstein</option>
								<option <?php echo ($formData['selCountry'] == 'Lithuania' ? "selected='selected'" : ''); ?> value='Lithuania'>Lithuania</option>
								<option <?php echo ($formData['selCountry'] == 'Luxembourg' ? "selected='selected'" : ''); ?> value='Luxembourg'>Luxembourg</option>
								<option <?php echo ($formData['selCountry'] == 'Macau' ? "selected='selected'" : ''); ?> value='Macau'>Macau</option>
								<option <?php echo ($formData['selCountry'] == 'Macedonia' ? "selected='selected'" : ''); ?> value='Macedonia'>Macedonia</option>
								<option <?php echo ($formData['selCountry'] == 'Madagascar' ? "selected='selected'" : ''); ?> value='Madagascar'>Madagascar</option>
								<option <?php echo ($formData['selCountry'] == 'Malaysia' ? "selected='selected'" : ''); ?> value='Malaysia'>Malaysia</option>
								<option <?php echo ($formData['selCountry'] == 'Malawi' ? "selected='selected'" : ''); ?> value='Malawi'>Malawi</option>
								<option <?php echo ($formData['selCountry'] == 'Maldives' ? "selected='selected'" : ''); ?> value='Maldives'>Maldives</option>
								<option <?php echo ($formData['selCountry'] == 'Mali' ? "selected='selected'" : ''); ?> value='Mali'>Mali</option>
								<option <?php echo ($formData['selCountry'] == 'Malta' ? "selected='selected'" : ''); ?> value='Malta'>Malta</option>
								<option <?php echo ($formData['selCountry'] == 'Marshall Islands' ? "selected='selected'" : ''); ?> value='Marshall Islands'>Marshall Islands</option>
								<option <?php echo ($formData['selCountry'] == 'Martinique' ? "selected='selected'" : ''); ?> value='Martinique'>Martinique</option>
								<option <?php echo ($formData['selCountry'] == 'Mauritania' ? "selected='selected'" : ''); ?> value='Mauritania'>Mauritania</option>
								<option <?php echo ($formData['selCountry'] == 'Mauritius' ? "selected='selected'" : ''); ?> value='Mauritius'>Mauritius</option>
								<option <?php echo ($formData['selCountry'] == 'Mayotte' ? "selected='selected'" : ''); ?> value='Mayotte'>Mayotte</option>
								<option <?php echo ($formData['selCountry'] == 'Mexico' ? "selected='selected'" : ''); ?> value='Mexico'>Mexico</option>
								<option <?php echo ($formData['selCountry'] == 'Midway Islands' ? "selected='selected'" : ''); ?> value='Midway Islands'>Midway Islands</option>
								<option <?php echo ($formData['selCountry'] == 'Moldova' ? "selected='selected'" : ''); ?> value='Moldova'>Moldova</option>
								<option <?php echo ($formData['selCountry'] == 'Monaco' ? "selected='selected'" : ''); ?> value='Monaco'>Monaco</option>
								<option <?php echo ($formData['selCountry'] == 'Mongolia' ? "selected='selected'" : ''); ?> value='Mongolia'>Mongolia</option>
								<option <?php echo ($formData['selCountry'] == 'Montserrat' ? "selected='selected'" : ''); ?> value='Montserrat'>Montserrat</option>
								<option <?php echo ($formData['selCountry'] == 'Morocco' ? "selected='selected'" : ''); ?> value='Morocco'>Morocco</option>
								<option <?php echo ($formData['selCountry'] == 'Mozambique' ? "selected='selected'" : ''); ?> value='Mozambique'>Mozambique</option>
								<option <?php echo ($formData['selCountry'] == 'Myanmar' ? "selected='selected'" : ''); ?> value='Myanmar'>Myanmar</option>
								<option <?php echo ($formData['selCountry'] == 'Nambia' ? "selected='selected'" : ''); ?> value='Nambia'>Nambia</option>
								<option <?php echo ($formData['selCountry'] == 'Nauru' ? "selected='selected'" : ''); ?> value='Nauru'>Nauru</option>
								<option <?php echo ($formData['selCountry'] == 'Nepal' ? "selected='selected'" : ''); ?> value='Nepal'>Nepal</option>
								<option <?php echo ($formData['selCountry'] == 'Netherland Antilles' ? "selected='selected'" : ''); ?> value='Netherland Antilles'>Netherland Antilles</option>
								<option <?php echo ($formData['selCountry'] == 'Netherlands' ? "selected='selected'" : ''); ?> value='Netherlands'>Netherlands</option>
								<option <?php echo ($formData['selCountry'] == 'Nevis' ? "selected='selected'" : ''); ?> value='Nevis'>Nevis</option>
								<option <?php echo ($formData['selCountry'] == 'New Caledonia' ? "selected='selected'" : ''); ?> value='New Caledonia'>New Caledonia</option>
								<option <?php echo ($formData['selCountry'] == 'New Zealand' ? "selected='selected'" : ''); ?> value='New Zealand'>New Zealand</option>
								<option <?php echo ($formData['selCountry'] == 'Nicaragua' ? "selected='selected'" : ''); ?> value='Nicaragua'>Nicaragua</option>
								<option <?php echo ($formData['selCountry'] == 'Niger' ? "selected='selected'" : ''); ?> value='Niger'>Niger</option>
								<option <?php echo ($formData['selCountry'] == 'Nigeria' ? "selected='selected'" : ''); ?> value='Nigeria'>Nigeria</option>
								<option <?php echo ($formData['selCountry'] == 'Niue' ? "selected='selected'" : ''); ?> value='Niue'>Niue</option>
								<option <?php echo ($formData['selCountry'] == 'Norfolk Island' ? "selected='selected'" : ''); ?> value='Norfolk Island'>Norfolk Island</option>
								<option <?php echo ($formData['selCountry'] == 'Norway' ? "selected='selected'" : ''); ?> value='Norway'>Norway</option>
								<option <?php echo ($formData['selCountry'] == 'Oman' ? "selected='selected'" : ''); ?> value='Oman'>Oman</option>
								<option <?php echo ($formData['selCountry'] == 'Pakistan' ? "selected='selected'" : ''); ?> value='Pakistan'>Pakistan</option>
								<option <?php echo ($formData['selCountry'] == 'Palau Island' ? "selected='selected'" : ''); ?> value='Palau Island'>Palau Island</option>
								<option <?php echo ($formData['selCountry'] == 'Palestine' ? "selected='selected'" : ''); ?> value='Palestine'>Palestine</option>
								<option <?php echo ($formData['selCountry'] == 'Panama' ? "selected='selected'" : ''); ?> value='Panama'>Panama</option>
								<option <?php echo ($formData['selCountry'] == 'Papua New Guinea' ? "selected='selected'" : ''); ?> value='Papua New Guinea'>Papua New Guinea</option>
								<option <?php echo ($formData['selCountry'] == 'Paraguay' ? "selected='selected'" : ''); ?> value='Paraguay'>Paraguay</option>
								<option <?php echo ($formData['selCountry'] == 'Peru' ? "selected='selected'" : ''); ?> value='Peru'>Peru</option>
								<option <?php echo ($formData['selCountry'] == 'Phillipines' ? "selected='selected'" : ''); ?> value='Phillipines'>Phillipines</option>
								<option <?php echo ($formData['selCountry'] == 'Pitcairn Island' ? "selected='selected'" : ''); ?> value='Pitcairn Island'>Pitcairn Island</option>
								<option <?php echo ($formData['selCountry'] == 'Poland' ? "selected='selected'" : ''); ?> value='Poland'>Poland</option>
								<option <?php echo ($formData['selCountry'] == 'Portugal' ? "selected='selected'" : ''); ?> value='Portugal'>Portugal</option>
								<option <?php echo ($formData['selCountry'] == 'Puerto Rico' ? "selected='selected'" : ''); ?> value='Puerto Rico'>Puerto Rico</option>
								<option <?php echo ($formData['selCountry'] == 'Qatar' ? "selected='selected'" : ''); ?> value='Qatar'>Qatar</option>
								<option <?php echo ($formData['selCountry'] == 'Republic of Montenegro' ? "selected='selected'" : ''); ?> value='Republic of Montenegro'>Republic of Montenegro</option>
								<option <?php echo ($formData['selCountry'] == 'Republic of Serbia' ? "selected='selected'" : ''); ?> value='Republic of Serbia'>Republic of Serbia</option>
								<option <?php echo ($formData['selCountry'] == 'Reunion' ? "selected='selected'" : ''); ?> value='Reunion'>Reunion</option>
								<option <?php echo ($formData['selCountry'] == 'Romania' ? "selected='selected'" : ''); ?> value='Romania'>Romania</option>
								<option <?php echo ($formData['selCountry'] == 'Russia' ? "selected='selected'" : ''); ?> value='Russia'>Russia</option>
								<option <?php echo ($formData['selCountry'] == 'Rwanda' ? "selected='selected'" : ''); ?> value='Rwanda'>Rwanda</option>
								<option <?php echo ($formData['selCountry'] == 'St Barthelemy' ? "selected='selected'" : ''); ?> value='St Barthelemy'>St Barthelemy</option>
								<option <?php echo ($formData['selCountry'] == 'St Eustatius' ? "selected='selected'" : ''); ?> value='St Eustatius'>St Eustatius</option>
								<option <?php echo ($formData['selCountry'] == 'St Helena' ? "selected='selected'" : ''); ?> value='St Helena'>St Helena</option>
								<option <?php echo ($formData['selCountry'] == 'St Kitts-Nevis' ? "selected='selected'" : ''); ?> value='St Kitts-Nevis'>St Kitts-Nevis</option>
								<option <?php echo ($formData['selCountry'] == 'St Lucia' ? "selected='selected'" : ''); ?> value='St Lucia'>St Lucia</option>
								<option <?php echo ($formData['selCountry'] == 'St Maarten' ? "selected='selected'" : ''); ?> value='St Maarten'>St Maarten</option>
								<option <?php echo ($formData['selCountry'] == 'St Pierre &amp; Miquelon' ? "selected='selected'" : ''); ?> value='St Pierre &amp; Miquelon'>St Pierre &amp; Miquelon</option>
								<option <?php echo ($formData['selCountry'] == 'St Vincent &amp; Grenadines' ? "selected='selected'" : ''); ?> value='St Vincent &amp; Grenadines'>St Vincent &amp; Grenadines</option>
								<option <?php echo ($formData['selCountry'] == 'Saipan' ? "selected='selected'" : ''); ?> value='Saipan'>Saipan</option>
								<option <?php echo ($formData['selCountry'] == 'Samoa' ? "selected='selected'" : ''); ?> value='Samoa'>Samoa</option>
								<option <?php echo ($formData['selCountry'] == 'Samoa American' ? "selected='selected'" : ''); ?> value='Samoa American'>Samoa American</option>
								<option <?php echo ($formData['selCountry'] == 'San Marino' ? "selected='selected'" : ''); ?> value='San Marino'>San Marino</option>
								<option <?php echo ($formData['selCountry'] == 'Sao Tome &amp; Principe' ? "selected='selected'" : ''); ?> value='Sao Tome &amp; Principe'>Sao Tome &amp; Principe</option>
								<option <?php echo ($formData['selCountry'] == 'Saudi Arabia' ? "selected='selected'" : ''); ?> value='Saudi Arabia'>Saudi Arabia</option>
								<option <?php echo ($formData['selCountry'] == 'Senegal' ? "selected='selected'" : ''); ?> value='Senegal'>Senegal</option>
								<option <?php echo ($formData['selCountry'] == 'Seychelles' ? "selected='selected'" : ''); ?> value='Seychelles'>Seychelles</option>
								<option <?php echo ($formData['selCountry'] == 'Sierra Leone' ? "selected='selected'" : ''); ?> value='Sierra Leone'>Sierra Leone</option>
								<option <?php echo ($formData['selCountry'] == 'Singapore' ? "selected='selected'" : ''); ?> value='Singapore'>Singapore</option>
								<option <?php echo ($formData['selCountry'] == 'Slovakia' ? "selected='selected'" : ''); ?> value='Slovakia'>Slovakia</option>
								<option <?php echo ($formData['selCountry'] == 'Slovenia' ? "selected='selected'" : ''); ?> value='Slovenia'>Slovenia</option>
								<option <?php echo ($formData['selCountry'] == 'Solomon Islands' ? "selected='selected'" : ''); ?> value='Solomon Islands'>Solomon Islands</option>
								<option <?php echo ($formData['selCountry'] == 'Somalia' ? "selected='selected'" : ''); ?> value='Somalia'>Somalia</option>
								<option <?php echo ($formData['selCountry'] == 'South Africa' ? "selected='selected'" : ''); ?> value='South Africa'>South Africa</option>
								<option <?php echo ($formData['selCountry'] == 'Spain' ? "selected='selected'" : ''); ?> value='Spain'>Spain</option>
								<option <?php echo ($formData['selCountry'] == 'Sri Lanka' ? "selected='selected'" : ''); ?> value='Sri Lanka'>Sri Lanka</option>
								<option <?php echo ($formData['selCountry'] == 'Sudan' ? "selected='selected'" : ''); ?> value='Sudan'>Sudan</option>
								<option <?php echo ($formData['selCountry'] == 'Suriname' ? "selected='selected'" : ''); ?> value='Suriname'>Suriname</option>
								<option <?php echo ($formData['selCountry'] == 'Swaziland' ? "selected='selected'" : ''); ?> value='Swaziland'>Swaziland</option>
								<option <?php echo ($formData['selCountry'] == 'Sweden' ? "selected='selected'" : ''); ?> value='Sweden'>Sweden</option>
								<option <?php echo ($formData['selCountry'] == 'Switzerland' ? "selected='selected'" : ''); ?> value='Switzerland'>Switzerland</option>
								<option <?php echo ($formData['selCountry'] == 'Syria' ? "selected='selected'" : ''); ?> value='Syria'>Syria</option>
								<option <?php echo ($formData['selCountry'] == 'Tahiti' ? "selected='selected'" : ''); ?> value='Tahiti'>Tahiti</option>
								<option <?php echo ($formData['selCountry'] == 'Taiwan' ? "selected='selected'" : ''); ?> value='Taiwan'>Taiwan</option>
								<option <?php echo ($formData['selCountry'] == 'Tajikistan' ? "selected='selected'" : ''); ?> value='Tajikistan'>Tajikistan</option>
								<option <?php echo ($formData['selCountry'] == 'Tanzania' ? "selected='selected'" : ''); ?> value='Tanzania'>Tanzania</option>
								<option <?php echo ($formData['selCountry'] == 'Thailand' ? "selected='selected'" : ''); ?> value='Thailand'>Thailand</option>
								<option <?php echo ($formData['selCountry'] == 'Togo' ? "selected='selected'" : ''); ?> value='Togo'>Togo</option>
								<option <?php echo ($formData['selCountry'] == 'Tokelau' ? "selected='selected'" : ''); ?> value='Tokelau'>Tokelau</option>
								<option <?php echo ($formData['selCountry'] == 'Tonga' ? "selected='selected'" : ''); ?> value='Tonga'>Tonga</option>
								<option <?php echo ($formData['selCountry'] == 'Trinidad &amp; Tobago' ? "selected='selected'" : ''); ?> value='Trinidad &amp; Tobago'>Trinidad &amp; Tobago</option>
								<option <?php echo ($formData['selCountry'] == 'Tunisia' ? "selected='selected'" : ''); ?> value='Tunisia'>Tunisia</option>
								<option <?php echo ($formData['selCountry'] == 'Turkey' ? "selected='selected'" : ''); ?> value='Turkey'>Turkey</option>
								<option <?php echo ($formData['selCountry'] == 'Turkmenistan' ? "selected='selected'" : ''); ?> value='Turkmenistan'>Turkmenistan</option>
								<option <?php echo ($formData['selCountry'] == 'Turks &amp; Caicos Is' ? "selected='selected'" : ''); ?> value='Turks &amp; Caicos Is'>Turks &amp; Caicos Is</option>
								<option <?php echo ($formData['selCountry'] == 'Tuvalu' ? "selected='selected'" : ''); ?> value='Tuvalu'>Tuvalu</option>
								<option <?php echo ($formData['selCountry'] == 'Uganda' ? "selected='selected'" : ''); ?> value='Uganda'>Uganda</option>
								<option <?php echo ($formData['selCountry'] == 'Ukraine' ? "selected='selected'" : ''); ?> value='Ukraine'>Ukraine</option>
								<option <?php echo ($formData['selCountry'] == 'United Arab Erimates' ? "selected='selected'" : ''); ?> value='United Arab Erimates'>United Arab Erimates</option>
								<option <?php echo ($formData['selCountry'] == 'United Kingdom' ? "selected='selected'" : ''); ?> value='United Kingdom'>United Kingdom</option>
								<option <?php echo ($formData['selCountry'] == 'United States of America' ? "selected='selected'" : ''); ?> value='United States of America'>United States of America</option>
								<option <?php echo ($formData['selCountry'] == 'Uraguay' ? "selected='selected'" : ''); ?> value='Uraguay'>Uraguay</option>
								<option <?php echo ($formData['selCountry'] == 'Uzbekistan' ? "selected='selected'" : ''); ?> value='Uzbekistan'>Uzbekistan</option>
								<option <?php echo ($formData['selCountry'] == 'Vanuatu' ? "selected='selected'" : ''); ?> value='Vanuatu'>Vanuatu</option>
								<option <?php echo ($formData['selCountry'] == 'Vatican City State' ? "selected='selected'" : ''); ?> value='Vatican City State'>Vatican City State</option>
								<option <?php echo ($formData['selCountry'] == 'Venezuela' ? "selected='selected'" : ''); ?> value='Venezuela'>Venezuela</option>
								<option <?php echo ($formData['selCountry'] == 'Vietnam' ? "selected='selected'" : ''); ?> value='Vietnam'>Vietnam</option>
								<option <?php echo ($formData['selCountry'] == 'Virgin Islands (Brit)' ? "selected='selected'" : ''); ?> value='Virgin Islands (Brit)'>Virgin Islands (Brit)</option>
								<option <?php echo ($formData['selCountry'] == 'Virgin Islands (USA)' ? "selected='selected'" : ''); ?> value='Virgin Islands (USA)'>Virgin Islands (USA)</option>
								<option <?php echo ($formData['selCountry'] == 'Wake Island' ? "selected='selected'" : ''); ?> value='Wake Island'>Wake Island</option>
								<option <?php echo ($formData['selCountry'] == 'Wallis &amp; Futana Is' ? "selected='selected'" : ''); ?> value='Wallis &amp; Futana Is'>Wallis &amp; Futana Is</option>
								<option <?php echo ($formData['selCountry'] == 'Yemen' ? "selected='selected'" : ''); ?> value='Yemen'>Yemen</option>
								<option <?php echo ($formData['selCountry'] == 'Zaire' ? "selected='selected'" : ''); ?> value='Zaire'>Zaire</option>
								<option <?php echo ($formData['selCountry'] == 'Zambia' ? "selected='selected'" : ''); ?> value='Zambia'>Zambia</option>
								<option <?php echo ($formData['selCountry'] == 'Zimbabwe' ? "selected='selected'" : ''); ?> value='Zimbabwe'>Zimbabwe</option>
							</select>
							<div for="selCountry" generated="true" class="error"><?php echo form_error('selCountry'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-3 col-md-offset-2" >
							<input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id; ?>" />
							<input class="btn btn-sm btn-primary" type="submit" id="btnSave" name="btnSave" value="Submit" />
							<input class="btn btn-sm btn-danger" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url(); ?>index.php/contract'" />
						</div>
					</div>
				</form>
			</div><!-- End of .content -->
		</div><!-- End of .box -->
	</div><!-- End of .col-md-12 -->
</div>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script>
	var pageHighlightMenu = "contract";
	$(document).ready(function() {
		$('input[type="checkbox"]').iCheck({checkboxClass: 'icheckbox_square-blue'});
		$( "#txtConFromDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$(".txtConFromDate").val(selectedDate);
				$( "#txtConToDate" ).datepicker( "option", "minDate", selectedDate );
			}
		});
            
		$( "#txtConToDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$(".txtConToDate").val(selectedDate);
				$( "#txtConFromDate" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
            
		$.validator.addMethod("nonzero", function(value, element) {
			if(value > 0)
				return true;
			else
				return false;
		}, "Should not be zero(0)");
            
		$.validator.addMethod(
		"australianDate",
		function(value, element) {
			return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
		},
		"Please enter a date in the format dd/mm/yyyy"
	);
            
            
		$("#frmTeacher").validate({
			errorElement:"div",
			ignore: "",
			rules: {
				selApplicant: "required",
				selPosition: "required",
				txtEmail: {
					required: true,
					email: true
				},
				fd:{
					australianDate: true,
					required: true
				},
				td: {
					australianDate: true,
					required: true
				},
				selCampus:{
					required:true
				},
				selWages:{
					required:true
				},
				txtSalary:{
					required:true,
					nonzero: true
				},
				selCurrency:{
					required:true
				},
				selResidential:{
					required:true
				},
				txtHoursPerWeek:{
					required: true,
					nonzero: true
				},
				//                    selExtraActivity:{
				//                        required: true
				//                    },
                                selBoard:{
                                    required: true
                                },
				txtAddress:{
					required: true
				},
				txtCity:{
					required: true
				},
				selPostCode:{
					required: true
				},
				selCountry:{
					required: true
				}
			},
			messages: {
				selApplicant: "Please select applicant",
				selPosition: "Please select position",
				txtEmail: "Please enter your email address",
				fd: {
					required: "Please select valid from date"
				},
				td: {
					required: "Please select valid to date"
				},
				selCampus: "Please select campus",
				selWages: "Please select wages",
				selCurrency: "Please select currency",
				selResidential: "Please select residential",
				txtHoursPerWeek: {
					required: "Please enter hours per week"
				},
				txtSalary: {
					required: "Please enter salary"
				},
				selExtraActivity: "Please select extra activity",
                                selBoard: "Please select board as basis",
				txtAddress: "Please enter your address",
				txtCity: "Please enter your city",
				selPostCode: "Please select postcode",
				selCountry: "Please select country"
			},
			submitHandler: function(form) {
				form.submit();
			}
		});
            
            
            
            
            
<?php if ($edit_id) { ?>
			$("#selApplicant").attr('disabled','disabled');
	<?php
}
else {
	?>
				$( "body" ).on( "change", "#selApplicant", function() {
					var applicantId = $(this).val();
					$.post( siteUrl + "contract/getApplicantProfile",{'applicantId':applicantId}, function( data ) {
						if(parseInt(data.status))
						{
							$("#txtEmail").val(data.result.email);
							$("#txtAddress").val(data.result.address);
							$("#txtCity").val(data.result.city);
							$("#selPostCode").val(data.result.postcode);
							$("#selCountry").val(data.result.country);
						}
						else
						{
							$("#txtEmail").val('');
							$("#txtAddress").val('');
							$("#txtCity").val('');
							$("#selPostCode").val('');
							$("#selCountry").val('');
						}
					},'json'); 
				});
<?php } ?>
            
<?php
if (isset($contract_app_id)) {
	if ($contract_app_id) {
		?>
						$("#selApplicant").val('<?php echo $contract_app_id; ?>');
                                                $("#selApplicant").trigger('change');
		<?php
	}
}
?>
	});
	
</script>	
