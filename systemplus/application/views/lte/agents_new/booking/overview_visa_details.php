<div class="container-fluid">
	<ul class="nav nav-pills" role="tablist">
		<li id="pill_a" role="presentation" class="active"><a href="#a" data-toggle="pill"><span class="glyphicon glyphicon-search"></span> Booking details</a></li>
		<li id="pill_b" role="presentation"><a href="#b" data-toggle="pill"><span class="glyphicon glyphicon-user"></span> VISA</a></li>
		<?php
			if (isset($_SERVER["HTTP_REFERER"]))
			{
				if (!strpos($_SERVER["HTTP_REFERER"], "dashboard"))
				{
		?>
					<li role="presentation" class="pull-right"><a id="backToList" data-toggle="pill"><span class="glyphicon glyphicon-chevron-left"></span> Back</a></li>
				<?php
				}
			}
		?>
	</ul>

	<?php
		$dayToArrive = round((time() - strtotime( $booking_details["enrol_arrival_date"] )) / 86400 * -1);
	?>
	<div class="tab-content" style="margin-top:10px;">
	  <div class="tab-pane fade in active" id="a">
	    <div class="panel panel-primary">
	      <div class="panel-heading booking-panel">
	        <h3 class="panel-title">Booking details -
	          <strong>
	            <?php echo date('Y', strtotime( $booking_details['enrol_created_on'] ) ); ?>_
	            <?php echo $booking_details['enroll_id']; ?>
	          </strong>
	        </h3>
	      </div>
	      <div class="panel-body">
	        <div class="row">
	          <div class="col-md-3">
	            <address>
	              <strong>
	                <?php echo date('Y', strtotime( $booking_details['enrol_created_on'] ) ); ?>_
	                <?php echo $booking_details['enroll_id']; ?>
	                <!-- <?php if ($book[0]["id_ref_overnight"]) { ?> -
	                <span style="color:#f00;">OVERNIGHT (
	                  <?php echo $book[0]["id_ref_overnight"] ?>)
	                </span>
	                <?php } ?> -->
	              </strong>
	              <br>
	              <?php echo $booking_details["nome_centri"] ?> - [
	              <?php echo $dayToArrive ?> days to arrival]
	              <br>
	              <strong>Date in:
	              </strong>
	              <span id="ok_A_Date">
	              	<?php echo date('d/m/Y', strtotime( $booking_details['enrol_arrival_date'] ) );?>
              	</span>
	              <br>
	              <strong>Date out:
	              </strong>
	              	<?php echo date('d/m/Y', strtotime( $booking_details['enrol_departure_date'] ) );?>
	              <br>
	              <abbr title="Phone">P:
	              </abbr>
	              <?php echo $agent_details["businesstelephone"] ?>
	            </address>
	          </div>
	          <div class="col-md-3">
	            <address>
	              <strong>
	                <img style="margin-top:-1px;" class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $agent_details["businesscountry"] ?>.png" alt="<?php echo $agent_details["businesscountry"] ?>" title="<?php echo $agent_details["businesscountry"] ?>" />
	                <?php echo $agent_details["businessname"] ?>
	              </strong>
	              <br>
	              <?php echo $agent_details["businessaddress"] ?>
	              <br>
	              <?php echo $agent_details["businesscity"] ?>,
	              <?php echo $agent_details["businesscountry"] ?>
	              <br>
	              <abbr title="Phone">P:
	              </abbr>
	              <?php echo $agent_details["businesstelephone"] ?>
	            </address>
	          </div>
	          <div class="col-md-3">
	            <address>
	              <strong>
	                <?php echo $agent_details["mainfirstname"] ?>
	                <?php echo $agent_details["mainfamilyname"] ?>
	              </strong>
	              <br>
	              <a href="mailto:<?php echo $agent_details["email"] ?>">
	                <?php echo $agent_details["email"] ?>
	              </a>
	            </address>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	  <div class="tab-pane fade in" id="b">
      <div class="panel panel-primary">
        <div class="panel-heading visa-panel">
          <h3 class="panel-title">
          	Booking roster - <strong><?php echo date('Y', strtotime( $booking_details['enrol_created_on'] ) ); ?>_<?php echo $booking_details['enroll_id']; ?></strong>
          	<?php if ( $booking_details["enrol_lock_pax"] == 1 ) { ?>
          		<span class="rLocked">LOCKED</span>
        		<?php } else { ?>
        			<span id="lockDisp"></span>
      			<?php } ?>
            <a id="printVisaPax" data-book="<?php echo $booking_details['enroll_id'] ?>" target="_blank" style="float:right; margin-left: 5px;" href="javascript:void(0)" data-href="<?php echo site_url() ?>/agents/pdfLockedVisas/<?php echo $booking_details['enroll_id'] ?>">
            	<span class="glyphicon glyphicon-print"></span> Print VISA for locked pax
          	</a>
            <?php
            	if( $booking_details["enrol_lock_pax"] != 1 )
            	{
            ?>
                &nbsp;<a id="lockWholeRoster" data-centro="<?php echo $booking_details['centri_id']; ?>" data-id="<?php echo $booking_details['enroll_id']; ?>"  data-year="<?php echo date('Y', strtotime( $booking_details['enrol_created_on'] ) ); ?>" style="float:right; margin-left: 5px;" href="javascript:void(0)" ><span class="glyphicon glyphicon-lock"></span> Lock whole roster</a>
            <?php
            	}
            ?>
          </h3>
        </div>

        <div class="panel-body visa-panel-body">
          <div class="row-fluid">
            <div class="col-12">
              <table id="NA_Roster" class="table table-bordered table-condensed table-striped">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th></th>
                    <th></th>
                    <th class="text-center">Accomodation/Composition</th>
                    <th>Group leader</th>
                    <th>Info</th>
                    <th>Share room</th>
                    <th class="text-center">Campus dates</th>
                    <th class="text-center">Arrival flight info</th>
                    <th class="text-center">Departure flight info</th>
                    <th class="text-center">Template</th>
                    <th class="text-center"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
	                  $counter = 1;
	                  foreach ( $booked_pax as $pax )
	                  {
	                  	if( $pax['pcomp_week'] != "" && $pax['accom_name'] != "" && $pax['courses_type'] != "" && $pax['act_activity_name'] != "" )
						            $package_comp = $pax['pcomp_week'].' Week - '.$pax['accom_name'].' - '.$pax['courses_type'].' - '.$pax['act_activity_name'];
						          else if ( $pax['pcomp_week'] != "" && $pax['accom_name'] != "" )
						          {
						            if( $pax['courses_type'] == "" && $pax['act_activity_name'] == "" )
						            {
						              $package_comp = $pax['pcomp_week'].' Week - '.$pax['accom_name'];
						            }
						            else if( $pax['courses_type'] == "" && $pax['act_activity_name'] != "" )
						            {
						              $package_comp = $pax['pcomp_week'].' Week - '.$pax['accom_name'].' - '.$pax['act_activity_name'];
						            }
						            else if( $pax['courses_type'] != "" && $pax['act_activity_name'] == "" )
						            {
						              $package_comp = $pax['pcomp_week'].' Week - '.$pax['accom_name'].' - '.$pax['courses_type'];
						            }
						          }
                  ?>
                    	<div style="display: none;" id="dialog_modal_<?php echo $pax["booked_pax_id"] ?>" title="Roster detail - <?php echo htmlentities($pax["booked_pax_name"] . ' ' . $pax['booked_pax_surname']); ?>" class="windia">
                        <div class="row">
                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Name: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $pax["booked_pax_name"] ?></div>

                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Surname: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $pax["booked_pax_surname"] ?></div>
                        </div>
                        <div class="row">
                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>DOB: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo date("d/m/Y", strtotime($pax["booked_pax_dob"])); ?></div>

                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>DOC: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $pax["booked_pax_passport_no"]; ?></div>
                        </div>
                        <div class="row">
                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Type of pax: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $pax["booked_tipo_pax"]; ?></div>

                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Sex: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $pax["booked_pax_gender"]; ?></div>
                        </div>
                        <div class="row">
                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Accommodation/Composition type: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3">
                          <?php
                          	if( $pax["booked_tipo_pax"] == 'GL' )
                        			echo $pax['gl_accom_name'];
                        		else
                        			echo $package_comp;
                      		?>
                          </div>

                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Group leader: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo ($pax["booked_pax_gl_rif"]); ?></div>
                        </div>
                        <div class="row">
                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Info: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo ($pax["booked_pax_salute"]); ?></div>

                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Share room: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo ($pax["booked_pax_share_room"]); ?></div>
                        </div>
                        <div class="row">
                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Campus arrival date: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo date("d/m/Y", strtotime($pax["booked_pax_campus_arrival_date"])); ?></div>

                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Campus departure date: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo date("d/m/Y", strtotime($pax["booked_pax_campus_departure_date"])); ?></div>
                        </div>
                        <div class="row">
                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Arrival flight number: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $pax["booked_pax_arrival_flight_number"]; ?></div>

                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Arrival flight date and time: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo date("d/m/Y", strtotime($pax["booked_pax_arrival_flight_date"])) . ' ' . date("H:i", strtotime($pax["booked_pax_arrival_flight_date"])); ?></div>
                        </div>
                        <div class="row">
                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Arrival airport: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $pax["booked_pax_arrival_airport"]; ?></div>

                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Departure airport for the arrival flight: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $pax["booked_pax_departure_arrival_airport"]; ?></div>
                        </div>
                        <div class="row">
                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Departure flight number: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $pax["booked_pax_departure_flight_number"]; ?></div>

                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Departure flight date and time: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo date("d/m/Y", strtotime($pax["booked_pax_departure_flight_date"])) . ' ' . date("H:i", strtotime($pax["booked_pax_departure_flight_date"])); ?></div>
                        </div>
                        <div class="row">
                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Departure airport: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $pax["booked_pax_departure_airport"]; ?></div>

                          <div class="col-xs-6 col-md-3 col-lg-3"><strong>Arrival airport for the departure flight: </strong></div>
                          <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $pax["booked_pax_arrival_departure_airport"]; ?></div>
                        </div>
                    	</div>
                    	<tr>
                        <td class="text-center"><?php echo $counter ?></td>
                        <td class="infoPax">
                        	<span <?php if ($pax["booked_tipo_pax"] == "GL") { ?> class="tdGl infoName" <?php } else { ?> class="infoName" <?php } ?>><?php echo $pax["booked_pax_surname"] ?> <?php echo $pax["booked_pax_name"] ?></span><br />DOB: <?php echo date("d/m/Y", strtotime($pax["booked_pax_dob"])) ?> - DOC#: <?php echo $pax["booked_pax_passport_no"] ?></td>
                        <td class="text-center info35"><span class="infoSex infoTipoPax"><?php echo $pax["booked_tipo_pax"] ?></span></td>
                        <td class="text-center info20"><span class="infoSex"><?php echo $pax["booked_pax_gender"] ?></span></td>
                        <td class="text-center infoAcco">
                        	<?php
                        		if( $pax["booked_tipo_pax"] == 'GL' )
                        			echo $pax['gl_accom_name'];
                        		else
                        			echo $package_comp;
                      		?>
                      	</td>
                        <td><?php echo $pax["booked_pax_gl_rif"] ?></td>
                        <td>
                        	<?php
                            if ($pax["booked_pax_salute"])
                            {
                              echo $pax["booked_pax_salute"];
                            }
                    			?>
                  			</td>
                        <td><?php echo $pax["booked_pax_share_room"] ?></td>
                        <td class="text-center">
                        	<?php echo date("d/m/Y", strtotime($pax["booked_pax_campus_arrival_date"])) ?><br /><?php echo date("d/m/Y", strtotime($pax["booked_pax_campus_departure_date"])) ?>
                      	</td>
                        <td class="text-center infoFlights">
                        	Flight <strong><?php echo $pax["booked_pax_arrival_flight_number"] ?></strong> - <?php echo date("d/m/Y", strtotime($pax["booked_pax_arrival_flight_date"])) ?><br />
                        	<?php echo date("H:i", strtotime($pax["booked_pax_arrival_flight_date"])) ?> at <strong><?php echo $pax["booked_pax_arrival_airport"] ?></strong> from <?php echo $pax["booked_pax_departure_arrival_airport"] ?>
                      	</td>
                        <td class="text-center infoFlights">
                        	Flight <strong><?php echo $pax["booked_pax_departure_flight_number"] ?></strong> - <?php echo date("d/m/Y", strtotime($pax["booked_pax_departure_flight_date"])) ?><br />
                        	<?php echo date("H:i", strtotime($pax["booked_pax_departure_flight_date"])) ?> from <strong><?php echo $pax["booked_pax_departure_airport"] ?></strong> at <?php echo $pax["booked_pax_arrival_departure_airport"] ?></td>
                        <td class="text-center" id="td_<?php echo $pax["booked_pax_id"]; ?>">
                        <?php
                          if ( !empty($templates) )
                          {
                            if ( $booking_details["enrol_lock_pax"] == 1 )
                            {
                              $marSus = 0;
                              if ( $pax["booked_template"] != '' )
                              {
                        ?>
                                <input class="tempSel" type="hidden" id="selTemp_<?php echo $pax["booked_pax_id"] ?>" value="<?php echo $pax["booked_template"] ?>" />
                        <?php }
                              if ($pax["booked_template"] != '')
                              {
                                if ($pax["booked_template"] == 'UKIR')
                                {
                                  $tempTitle = 'UK/Ireland';
                                }
                                if ($pax["booked_template"] == 'USA')
                                {
                                  $tempTitle = 'USA';
                                }
                                if ($pax["booked_template"] == 'MAL')
                                {
                                  $tempTitle = 'Malta';
                                }
                                if ($pax["booked_template"] == 'UKIRGLSTD')
                                {
                                  $tempTitle = 'UK/Ireland - GL Standard';
                                }
                                if ($pax["booked_template"] == 'UKIRSTDSTD')
                                {
                                  $tempTitle = 'UK/Ireland - STD Standard';
                                }
                                if ($pax["booked_template"] == 'UKIRSTDST')
                                {
                                  $tempTitle = 'UK/Ireland - STD Short Term';
                                }
                              }
                            ?>
                              <select style="width: 77px" <?php if ($pax["booked_template"] != '') { ?> disabled="disabled" title="<?php echo $tempTitle; ?>" <?php } else { ?>  class="tempSel" id="selTemp_<?php echo $pax["booked_pax_id"] ?>" <?php } ?>>
                             	<?php
                               	if ( $pax["booked_template"] == '' )
                               	{
                                 	$dspCnt = 1;
                                 	foreach ( $templates as $template )
                                 	{
                                    $chk = 0;
                                   	$tempTitle = '';
                                   	if ($template['template'] == 'UKIR')
                                   	{
                                     	$tempTitle = 'UK/Ireland';
                                     	if ($template['template'] . $pax["nat_id"] == $template['tempMap'])
                                     	{
                                       	$chk += 1;
                                     	}
                                   	}
                                   	if ($template['template'] == 'USA')
                                   	{
                                     	$tempTitle = 'USA';
                                     	if ($template['template'] . $pax["nat_id"] == $template['tempMap'])
                                     	{
                                       	$chk += 1;
                                     	}
                                   	}
                                   	if ($template['template'] == 'MAL')
                                   	{
                                     	$tempTitle = 'Malta';
                                     	if ($template['template'] . $pax["nat_id"] == $template['tempMap'])
                                     	{
                                       	$chk += 1;
                                     	}
                                   	}
                                   	if ($template['template'] == 'UKIRGLSTD')
                                   	{
                                     	$tempTitle = 'UK/Ireland - GL Standard';
                                     	if ($template['template'] . $pax["nat_id"] == $template['tempMap'])
                                     	{
                                        $chk += 1;
                                     	}
                                   	}
                                   	if ($template['template'] == 'UKIRSTDSTD')
                                   	{
                                   		$tempTitle = 'UK/Ireland - STD Standard';
                                     	if ($template['template'] . $pax["nat_id"] == $template['tempMap'])
                                     	{
                                        $chk += 1;
                                      }
                                   	}
                                   	if ($template['template'] == 'UKIRSTDST')
                                   	{
                                     	$tempTitle = 'UK/Ireland - STD Short Term';
                                     	if ($template['template'] . $pax["nat_id"] == $template['tempMap'])
                                     	{
                                        $chk += 1;
                                      }
                                   	}

                                   	if ($chk > 0)
                                   	{
                                     	$marSus += 1;
                                     	if ($dspCnt == 1)
                                     	{
                                   	?>
                                      	<option value="">Select</option>
                                    <?php
                                      $dspCnt += 1;
                                  	}
                                    ?>
                                        <option value="<?php echo $template['template'] ?>"><?php echo $tempTitle ?></option>
                                  <?php
                                    }
                                    $chk = 0;
                                  }
                                  if ($marSus == 0)
                                  {
                                ?>
                                    <option value="">NA</option>
                                <?php
                                  }
                                }
                                else
                                {
	                                $tempTitle = '';
	                              	if ($pax["booked_template"] == 'UKIR')
	                              	{
	                                  $tempTitle = 'UK/Ireland';
	                              	}
	                                if ($pax["booked_template"] == 'USA')
	                                {
	                                  $tempTitle = 'USA';
	                                }
	                                if ($pax["booked_template"] == 'MAL')
	                                {
	                                  $tempTitle = 'Malta';
	                                }
	                                if ($pax["booked_template"] == 'UKIRGLSTD')
	                                {
	                                  $tempTitle = 'UK/Ireland - GL Standard';
	                                }
	                                if ($pax["booked_template"] == 'UKIRSTDSTD')
	                                {
	                                  $tempTitle = 'UK/Ireland - STD Standard';
	                                }
	                                if ($pax["booked_template"] == 'UKIRSTDST')
	                                {
	                                  $tempTitle = 'UK/Ireland - STD Short Term';
	                                }
                              ?>
                                	<option selected="selected" value="<?php echo $pax['booked_template'] ?>"><?php echo $tempTitle ?></option>
                              <?php
                                }
                              ?>
                            </select>
                            <span class="selTmplDemo" data-id="<?php echo $pax['booked_pax_id'] ?>" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 20px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>
                            <?php
                              } elseif ($pax["booked_lock_pax"] == 1) {
                                    $marSus = 0;
                                    ?>
                                    <?php if ($pax["booked_template"] != '') {
                                        ?>
                                        <input class="tempSel" type="hidden" id="selTemp_<?php echo $pax["booked_pax_id"] ?>" value="<?php echo $pax["booked_template"] ?>" />
                                    <?php } ?>
                                    <select  style="width: 77px"
                                    <?php
                                    if ($pax["booked_template"] != '') {
                                        $tempTitle = '';
                                        if ($pax["booked_template"] == 'UKIR') {
                                            $tempTitle = 'UK/Ireland';
                                        }
                                        if ($pax["booked_template"] == 'USA') {
                                            $tempTitle = 'USA';
                                        }
                                        if ($pax["booked_template"] == 'MAL') {
                                            $tempTitle = 'Malta';
                                        }
                                        if ($pax["booked_template"] == 'UKIRGLSTD') {
                                            $tempTitle = 'UK/Ireland - GL Standard';
                                        }
                                        if ($pax["booked_template"] == 'UKIRSTDSTD') {
                                            $tempTitle = 'UK/Ireland - STD Standard';
                                        }
                                        if ($pax["booked_template"] == 'UKIRSTDST') {
                                            $tempTitle = 'UK/Ireland - STD Short Term';
                                        }
                                        ?> disabled="disabled" title="<?php echo $tempTitle; ?>"
                                                 <?php
                                             } else {
                                                 ?> id="selTemp_<?php echo $pax["booked_pax_id"] ?>"  class="tempSel" <?php } ?> >
                                             <?php
                                             if ($pax["booked_template"] == '') {
                                                 $dspCnt = 1;
                                                 foreach ($templates as $template) {
                                                     $chk = 0;
                                                     $tempTitle = '';
                                                     if ($template['template'] == 'UKIR') {
                                                         $tempTitle = 'UK/Ireland';
                                                         if ($template['template'] . $pax["nat_id"] == $template['tempMap']) {
                                                             $chk += 1;
                                                         }
                                                     }
                                                     if ($template['template'] == 'USA') {
                                                         $tempTitle = 'USA';
                                                         if ($template['template'] . $pax["nat_id"] == $template['tempMap']) {
                                                             $chk += 1;
                                                         }
                                                     }
                                                     if ($template['template'] == 'MAL') {
                                                         $tempTitle = 'Malta';
                                                         if ($template['template'] . $pax["nat_id"] == $template['tempMap']) {
                                                             $chk += 1;
                                                         }
                                                     }
                                                     if ($template['template'] == 'UKIRGLSTD') {
                                                         $tempTitle = 'UK/Ireland - GL Standard';
                                                         if ($template['template'] . $pax["nat_id"] == $template['tempMap']) {
                                                             $chk += 1;
                                                         }
                                                     }
                                                     if ($template['template'] == 'UKIRSTDSTD') {
                                                         $tempTitle = 'UK/Ireland - STD Standard';
                                                         if ($template['template'] . $pax["nat_id"] == $template['tempMap']) {
                                                             $chk += 1;
                                                         }
                                                     }
                                                     if ($template['template'] == 'UKIRSTDST') {
                                                         $tempTitle = 'UK/Ireland - STD Short Term';
                                                         if ($template['template'] . $pax["nat_id"] == $template['tempMap']) {
                                                             $chk += 1;
                                                         }
                                                     }
                                                     if ($chk > 0) {
                                                         $marSus += 1;
                                                         if ($dspCnt == 1) {
                                                             ?>
                                                        <option value="">Select</option>
                                                        <?php
                                                        $dspCnt += 1;
                                                    }
                                                    ?>
                                                    <option value="<?php echo $template['template'] ?>"><?php echo $tempTitle ?></option>
                                                    <?php
                                                }
                                            }
                                            if ($marSus == 0) {
                                                ?>
                                                <option value="">NA</option>
                                                <?php
                                            }
                                        } else {
                                            $tempTitle = '';
                                            if ($pax["booked_template"] == 'UKIR') {
                                                $tempTitle = 'UK/Ireland';
                                            }
                                            if ($pax["booked_template"] == 'USA') {
                                                $tempTitle = 'USA';
                                            }
                                            if ($pax["booked_template"] == 'MAL') {
                                                $tempTitle = 'Malta';
                                            }
                                            if ($pax["booked_template"] == 'UKIRGLSTD') {
                                                $tempTitle = 'UK/Ireland - GL Standard';
                                            }
                                            if ($pax["booked_template"] == 'UKIRSTDSTD') {
                                                $tempTitle = 'UK/Ireland - STD Standard';
                                            }
                                            if ($pax["booked_template"] == 'UKIRSTDST') {
                                                $tempTitle = 'UK/Ireland - STD Short Term';
                                            }
                                            ?>
                                            <option selected="selected" value="<?php echo $pax['booked_template'] ?>"><?php echo $tempTitle ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="selTmplDemo" data-id="<?php echo $pax['booked_pax_id'] ?>" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 20px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>
                                    <?php
                                }
                            } else {
                                if ($booking_details["enrol_lock_pax"] == 1) {
                                    ?>
                                    <select style="width: 77px"><option value="">NA</option></select>
                                    <?php
                                } elseif ($pax["booked_lock_pax"] == 1) {
                                    ?>
                                    <select style="width: 77px"><option value="">NA</option></select>
                                    <?php
                                }
                            }
                            ?>
                        </td>
                        <th class="text-center">
                            <?php
                            if ($booking_details["enrol_lock_pax"] == 1) {
                                ?>
                                <span class="glyphicon glyphicon-lock locked error" title="Roster Locked."></span>
                                <?php
                                if (!empty($templates)) {
                                    ?>
                                    <a id="prntVisa_<?php echo $pax["booked_pax_id"]; ?>" href="javascript:void(0)" data-href="<?php echo site_url() ?>/agentroster/pdfSingleVisa/<?php echo $pax["booked_pax_id"]; ?>/<?php echo $booking_details['enroll_id']; ?>" title="Print VISA" target="_blank" class="prinOpen"><span class="glyphicon glyphicon-print"></span></a>
                                    <?php
                                }
                            } elseif ($pax["booked_lock_pax"] == 1) {
                                ?>
                                <span class="glyphicon glyphicon-lock locked error" title="Roster Locked."></span>
                                <?php
                                if (!empty($templates)) {
                                    ?>
                                    <a id="prntVisa_<?php echo $pax["booked_pax_id"]; ?>"  href="javascript:void(0)" data-href="<?php echo site_url() ?>/agentroster/pdfSingleVisa/<?php echo $pax["booked_pax_id"]; ?>/<?php echo $booking_details['enroll_id']; ?>" title="Print VISA" target="_blank"  class="prinOpen"><span class="glyphicon glyphicon-print"></span></a>
                                    <?php
                                }
                            } else {
                                ?>
                                <a href="javascript:void(0);" class="lockRoster" data-centro="<?php echo $booking_details['centri_id']; ?>" id="paxLoc_<?php echo $pax["booked_pax_id"] ?>" data-toggle="tooltip" title="Lock roster"><span class="glyphicon glyphicon-lock"></span></a>
                                <?php
                            }
                            ?>

                            <a href="javascript:void(0);" class="paxOpenClass" id="paxOpn_<?php echo $pax["booked_pax_id"] ?>"><span class="glyphicon glyphicon-eye-open dialogbtn_visa" title="View details" data-toggle="tooltip" data-id="dialog_modal_btn_<?php echo $pax["booked_pax_id"]; ?>"></span></a>
                        </th>
                    </tr>
                    <?php
                    $counter++;
                }
                ?>
                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	</div>

</div>
<script type="text/javascript">
	$('#backToList').click(function(){
    parent.history.back();
    return false;
  });

	$(document).ready( function(e) {

		$(document).on('click', '.lockRoster', function(e) {
    	e.preventDefault();
    	var c = confirm('Are you sure to lock roster?');
    	if(c)
    	{
        var elm = $(this);
        var parent = elm.parent();
        var pax_id = elm.attr('id').replace('paxLoc_', '');
        var campus_id = elm.attr('data-centro');
        $.ajax({
          url: siteUrl + 'agentroster/lockSingleRoster',
          type: 'POST',
          dataType: 'json',
          data: {
            pax_id: pax_id,
            campus_id: campus_id
          },
          success: function(data){
            if( data.status == 1 )
            {
              elm.remove();
              $('#td_'+pax_id).html(data.result+'<span class="selTmplDemo" data-id="'+pax_id+'" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 20px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>');
              parent.prepend('<span class="glyphicon glyphicon-lock locked" style="color: #FF0000" title="Roster Locked."></span>&nbsp<a id="prntVisa_'+pax_id+'" href="javascript:void(0)" data-href="'+siteUrl+'agentroster/pdfSingleVisa/'+pax_id+'/<?php echo $booking_details['enroll_id']; ?>" title="Print VISA"  class="prinOpen"><span class="glyphicon glyphicon-print"></span></a>');
              swal("Success",'Roster locked successfully');
            }
            else if(data.status == 3)
            {
              elm.remove();
              $('#td_'+pax_id).html(data.result+'<span class="selTmplDemo" data-id="'+pax_id+'" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 20px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>');
              parent.prepend('<span class="glyphicon glyphicon-lock locked" style="color: #FF0000" title="Roster Locked."></span>');
              swal("Success",'Roster locked successfully');
            }
            else if(data.status == 2)
            {
              swal("Error",'Roster details are not complete. Failed to lock');
            }
            else
            {
              swal("Error",'Failed to lock Roster');
            }
          },
          error: function(){
            swal("Error",'Failed to lock Roster');
          }
        });
    	}
		});

		$(document).on('click', '#lockWholeRoster', function(e){
      e.preventDefault();
      var c = confirm('Are you sure to lock whole roster?');
      if(c)
      {
        var elm = $(this);
        var enroll_id = elm.attr('data-id');
        var year = elm.attr('data-year');
        var campus_id = elm.attr('data-centro');
        $.ajax({
	        url: siteUrl + 'agentroster/lockWholeRoster',
	        type: 'POST',
	        dataType: 'json',
	        data: {
            enroll_id: enroll_id,
            year: year,
            campus_id: campus_id
	        },
          success: function(data){
            if(data.status == 1)
            {
             	$("#dialog_modal_booking_detail").modal('hide');
             	$('.visaPopup[data-id="'+enroll_id+'"]').trigger('click');
             	setTimeout(function(){
             		$("#pill_b a").trigger('click');
             	}, 1000);

              return false;
            }
            else
            {
              swal("Error",'There are incomplete rosters. Please fill all the details and retry.');
            }
          },
          error: function(){
            swal("Error",'Failed to lock Whole Roster');
          }
        });
      }
    });

    $(document).on('click', ".dialogbtn_visa", function() {
      var iddia = $(this).attr("data-id").replace('_btn','');
      var bookDetails = $( "#"+iddia ).html();
      var bookDetailsTitle = $( "#"+iddia ).attr('title');
      $("#dialog_modal_booking_detail_visa .modal-body").html(bookDetails);
      $("#dialog_modal_booking_detail_visa #dmbdv_title").html(bookDetailsTitle);
      $("#dialog_modal_booking_detail_visa").modal('show');
      return false;
  	});

  	$(document).on('click', '.prinOpen', function(e){
      e.preventDefault();
      var elm = $(this);
      var pax_id = $(this).attr('id').replace('prntVisa_','');
      var template_value = $('#selTemp_'+pax_id).val();
      var c = true;
      var enroll_id = elm.attr('data-href').split('/').pop();
      if(template_value == '' || typeof template_value == 'undefined')
      {
        swal("Error",'Please select template');
        return false;
      }
      else
      {
        if(!$('#selTemp_'+pax_id).is('input[type=hidden]'))
        {
          c = confirm('Are you sure to print VISA? The template once selected can not change again.');
        }
        if(c)
        {
          $.ajax({
            url: siteUrl+'agentroster/lockTemplate',
            type: 'POST',
            async: false,
            data: {
              pax_id: pax_id,
              template_value: template_value
            },
            success: function(data){
              if(data == 1)
              {
                $('#selTemp_'+pax_id).attr('disabled','disabled');
                $(".selTmplDemo[data-id='"+pax_id+"']").remove();
                window.open(elm.attr('data-href')+'/'+template_value);
                return false;
              }
              else if(data == 2)
              {
                swal("Error",'Nationality not found/Invalid nationality');
              }
              else
              {
                swal("Error",'Error occured. Could not print visa');
              }
            },
            error: function(){
              swal("Error",'Error occured. Could not print visa');
            }
          });
        }
      }
  	});

    $('#printVisaPax').on('click', function(e){
      e.preventDefault();
      var elm = $(this);
      var enroll_id = elm.attr('data-book');
      var lockedPax = $('.locked').length;
      if( lockedPax )
      {
        $.ajax({
          url: siteUrl+'agentroster/getPaxTemplate',
          type: 'POST',
          dataType: 'json',
          data: {
            enroll_id: enroll_id
          },
          success: function(data){
            if( data.result != "" )
            {
              $("#dialog_modal_print_visa").modal('show');
              $("#dialog_modal_print_visa .modal-body").html( data.result );
              return false;
            }
            else
            {
              swal("Error",'Error occured. Could not print visa');
            }
          }
        });
      }
      else
      {
        swal("Error",'No locked VISA found. Lock some  VISA and try again');
      }
    });

    $(document).on('change', '.tempSel', function(){
      var templ = $(this).val();
      var rowId = $(this).attr('id').replace('selTemp_', '');
      if(templ != '' && typeof templ != 'undefined')
        $('.selTmplDemo[data-id='+rowId+']').css('display','inline-block');
      else
        $('.selTmplDemo[data-id='+rowId+']').css('display','none');
    });

    $(document).on('click','.selTmplDemo', function(){
      var id = $(this).attr('data-id');
      var templ = $('#selTemp_'+id).val();
      if(templ != '' && typeof templ != 'undefined')
        window.open(siteUrl+'agentroster/visaPDFDemo/'+templ);
    });

	});
</script>