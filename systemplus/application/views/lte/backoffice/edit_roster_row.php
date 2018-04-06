<div class="margin-5">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<form name="postaPax" id="postaPax" method="POST" action="<?php echo site_url() ?>/backoffice/confModRosterPax/<?php echo $idPax; ?>/<?php echo $idBook; ?>">
						<?php
						$idFirstLine = $paxs[0]["id_prenotazione"];
						$contarighe = 1;
						foreach ($paxs as $pax) {
							if (is_null($pax["pax_dob"]) or $pax["pax_dob"] == "0000-00-00")
								$pax["pax_dob"] = "1970-01-01";
							?>
							<div class="row form-group">
								<div class="col-md-6">
									<label for="tipo_pax">Type</label>
									<select name="tipo_pax" required id="tipo_pax" class="form-control">
										<option value="GL" <?php if ($pax["tipo_pax"] == "GL") { ?>selected<?php } ?>>Group Leader</option>
										<option value="STD" <?php if ($pax["tipo_pax"] == "STD") { ?>selected<?php } ?>>Student</option>
									</select>
								</div>
								<div class="col-md-6">
									<label for="accomodation">Accomodation</label>
									<select name="accomodation" required id="accomodation" class="form-control">
										<?php foreach ($accoS as $acco) { ?>
											<option value="<?php echo strtolower($acco["sistemazione"]); ?>" <?php if ($pax["accomodation"] == strtolower($acco["sistemazione"])) { ?>selected<?php } ?>><?php echo $acco["sistemazione"]; ?></option>
										<?php } ?>
									</select>
									<input type="hidden" name="old_accomodation" id="old_accomodation" value="<?php echo $pax["accomodation"]; ?>" />
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-6"><label for="cognome">Surname</label><input required class="form-control" id="cognome" name="cognome" type="text" value="<?php echo $pax["cognome"] ?>" /></div>
								<div class="col-md-6"><label for="nome">Name</label><input required class="form-control" id="nome" name="nome" type="text" value="<?php echo $pax["nome"] ?>" /></div>
							</div>
							<div class="row form-group">
								<div class="col-md-6"><label for="sesso">Sex</label><select required id="sesso" name="sesso" class="form-control">
										<option value="">Select</option>
										<option value="M" <?php if ($pax["sesso"] == "M") { ?>selected<?php } ?>>Male</option>
										<option value="F" <?php if ($pax["sesso"] == "F") { ?>selected<?php } ?>>Female</option>
									</select>
								</div>
								<div class="col-md-6"><label for="pax_dob">Date of Birth</label><input required  class="chooseDOB form-control datepicker" id="pax_dob"name="pax_dob" type="text" value="<?php echo date("d/m/Y", strtotime($pax["pax_dob"])) ?>" /></div>
							</div>
							<div class="row form-group">
								<div class="col-md-6"><label for="nazionalita">Citizenship</label><input required class="form-control nationality_ac" id="nazionalita" name="nazionalita" type="text" value="<?php echo $pax["nazionalita"] ?>" /></div>
								<div class="col-md-6"><label for="numero_documento">Passport No</label><input required class="form-control" id="numero_documento" name="numero_documento" type="text" value="<?php echo $pax["numero_documento"] ?>" /></div>
							</div>
							<div class="row form-group">								
								<div class="col-md-6"><label for="salute">Health Info</label><input class="form-control" id="salute" name="salute" type="text" value="<?php echo $pax["salute"] ?>" /></div>
								<div class="col-md-6 td_gl_rif"><label for="gl_rif">GL Ref.</label><input class="reqField form-control" id="gl_rif" name="gl_rif" type="text" value="<?php echo $pax["gl_rif"] ?>" /></div>
							</div>
							<div class="row form-group">								
								<div class="col-md-6"><label for="data_arrivo_campus">Campus Date In</label><input required class="chooseDate1 form-control datepicker" id="data_arrivo_campus"name="data_arrivo_campus" type="text" value="<?php echo date("d/m/Y", strtotime($pax["data_arrivo_campus"])) ?>" /></div>
								<div class="col-md-6"><label for="data_partenza_campus">Campus Date Out</label><input required class="chooseDate2 form-control datepicker" id="data_partenza_campus" name="data_partenza_campus" type="text" value="<?php echo date("d/m/Y", strtotime($pax["data_partenza_campus"])) ?>" /></div>
							</div>
							<div class="row form-group">								
								<div class="col-md-6"><label for="andata_data_arrivo">Arrival Flight Date</label><input required class="chooseDateTime1 form-control datepicker" id="andata_data_arrivo"name="andata_data_arrivo" type="text" value="<?php echo date("d/m/Y", strtotime($pax["andata_data_arrivo"])) ?>" /></div>
								<div class="col-md-6"><label for="ora_arrivo_volo">Arrival Flight Time</label><input class="chooseTime1 form-control timepicker" id="ora_arrivo_volo" name="ora_arrivo_volo" type="text" value="<?php echo date("H:i", strtotime($pax["andata_data_arrivo"])) ?>" /></div>
							</div>
							<div class="row form-group">								
								<div class="col-md-4"><label for="andata_apt_arrivo">Arrival Airport</label><input class="airport_ac form-control" id="andata_apt_arrivo"name="andata_apt_arrivo" type="text" value="<?php echo $pax["andata_apt_arrivo"] ?>" /></div>
								<div class="col-md-4"><label for="andata_volo">Flight Number In</label><input class="form-control" id="andata_volo" name="andata_volo" type="text" value="<?php echo $pax["andata_volo"] ?>" /></div>
								<div class="col-md-4"><label for="transfer_in">Transfer In</label><label class="checkbox text-center"><input type="checkbox" id="transfer_in" name="transfer_in" <?php if ($pax["transfer_in"] == 1) { ?>checked="checked"<?php } ?>></label></div>									
							</div>
							<div class="row form-group">										
								<div class="col-md-6"><label for="ritorno_data_partenza">Departure Flight Date</label><input required class="chooseDateTime2 form-control datepicker" id="ritorno_data_partenza" name="ritorno_data_partenza" type="text" value="<?php echo date("d/m/Y", strtotime($pax["ritorno_data_partenza"])) ?>" /></div>							
								<div class="col-md-6">
									<label for="ora_partenza_volo">Departure Flight Time</label>
									<input required class="chooseTime2 form-control timepicker" id="ora_partenza_volo" name="ora_partenza_volo" type="text" value="<?php echo date("H:i", strtotime($pax["ritorno_data_partenza"])) ?>" />
								</div>					
							</div>
							<div class="row form-group">									
								<div class="col-md-4"><label for="ritorno_apt_partenza">Departure Airport</label><input class="airport_ac form-control" id="ritorno_apt_partenza" name="ritorno_apt_partenza" type="text" value="<?php echo $pax["ritorno_apt_partenza"] ?>" /></div>								
								<div class="col-md-4"><label for="ritorno_volo">Flight Number Out</label><input class="form-control" id="ritorno_volo" name="ritorno_volo" type="text" value="<?php echo $pax["ritorno_volo"] ?>" /></div>		
								<div class="col-md-4"><label for="transfer_out">Transfer Out</label><label class="checkbox text-center"><input type="checkbox" id="transfer_out" name="transfer_out" <?php if ($pax["transfer_out"] == 1) { ?>checked="checked"<?php } ?>></label></div>										
							</div>	
							<div class="row form-group">									
								<div class="col-md-6"><label for="andata_apt_partenza">Departure airport for the arrival flight</label><input class="airport_ac form-control" id="andata_apt_partenza" name="andata_apt_partenza" type="text" value="<?php echo $pax["andata_apt_partenza"] ?>" required /></div>								
								<div class="col-md-6"><label for="ritorno_apt_arrivo">Arrival airport for the departure flight</label><input class="airport_ac form-control" id="ritorno_apt_arrivo" name="ritorno_apt_arrivo" type="text" value="<?php echo $pax["ritorno_apt_arrivo"] ?>" required /></div>		

							</div>	
							<div class="row form-group">
								<div class="col-md-6"><label for="share_room">Share room with</label><input class="form-control" id="share_room" name="share_room" type="text" value="<?php echo $pax["share_room"] ?>" /></div>
								<?php
								if (!empty($courseDetails) && $pax["tipo_pax"] != 'GL') {
									?>
									<div class="col-md-6" id="suppl-div"><label for="share_room">Academy Type</label>
										<select class="form-control" id="suppl" name="suppl">
											<option value="">Select</option>
											<?php
											foreach ($courseDetails as $course) {
												if ($course['plr_id'] == $pax['plr_id']) {
													?>
													<option selected="selected" value="<?php echo $course['plr_id'] ?>"><?php echo $course['description'] ?></option>
													<?php
												}
												else {
													?>
													<option value="<?php echo $course['plr_id'] ?>"><?php echo $course['description'] ?></option>
													<?php
												}
											}
											?>
										</select>
									</div>
									<?php
								}
								elseif (!empty($courseDetails) && $pax["tipo_pax"] == 'GL') {
									?>
									<div class="col-md-6" style="display: none" id="suppl-div"><label for="share_room">Academy Type</label>
										<select class="form-control" id="suppl" disabled="disabled" name="suppl">
											<option value="">Select</option>
											<?php
											foreach ($courseDetails as $course) {
												?>
												<option value="<?php echo $course['plr_id'] ?>"><?php echo $course['description'] ?></option>
												<?php
											}
											?>
										</select>
									</div>
									<?php
								}
								?>
							</div>
							<?php
							$contarighe++;
						}
						?>
						<div class="row form-group">									
							<div class="col-md-12 text-right">
								<button type="submit" class="btn btn-success">Save pax</button>
							</div>										
						</div>								
					</form>		
				</div>	
			</div>
		</div>
	</div>
</div>
