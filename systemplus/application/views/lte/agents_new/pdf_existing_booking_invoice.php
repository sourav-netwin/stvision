<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>plus-ed.com | booking invoice</title>
        <style>
          table, td, th {
              border: 1px solid black;
          }
          table {
              border-collapse: collapse;
              width: 100%;
          }
          td {
              height: 26px;
              vertical-align: top;
              padding: 4px;
          }
        </style>
    </head>
    <body style="font-family: Tahoma;font-size: 12px; background-color:#ffffff; margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;">
      <?php 
      
      //var_dump($book);die;
      
        // store invoice data into database....
        $invoiceAdd = array(
            'inv_booking_id' => $book['id_book'],
            'inv_old_booking' => 1,
            'inv_campus_id' => $book['pack_campus_id'],
            'inv_agent_id' => $book['id_agente'],
            'inv_package_id' => $book['pbmap_package_id'],
            'inv_number_of_pax' => 0,
            'inv_number_of_gl' => 0,
            'inv_number_of_week' => $book['weeks'],
            'inv_date' => date("Y-m-d")
        );
        $invoiceId = $this->packagesmodel->saveInvoiceData($invoiceAdd);
        
      ?>
        <div style="padding: 10px 20px 10px 20px;">
         <img src="<?php echo base_url(); ?>img/tuition/logo.png" alt=""/>
          <div style="width:100%;font-size: 16px;font-weight: bold;margin-top: -90px;"> 
            <h4 style="text-align: center;">BOOKING INVOICE</h4>
            <h3 style="text-align: center;">Booking Id - <?php echo date('Y', strtotime( $book['data_insert'] ) ) ?>_<?php echo $book['id_book']; ?> - <?php echo $book['nome_centri']; ?></h3>
          </div>
          <?php 
            $agentDetails = $this->agent_booking_model->getBookingAgentDetails($book['id_agente']);
          ?>
            <div style="text-align: justify;clear: both; padding-top: 15px;">
                <div style="margin-top: 2px;">
                        <div >
                          <div style="margin-bottom: 10px;">
                              <table>
                              <tr>
                                <td>
                                  From<br/>
                                  Plus-ed.<br/>
                                  000 xxxx xxxxxx,<br/>
                                  Phone: (000) 000-1234<br/>
                                  Email: info@plus-ed.com
                                </td>
                                <td>
                                  <?php if($agentDetails > 0){
                                    ?>
                                    To<br/>
                                    <?php echo $agentDetails['businessname'];?><br/>
                                    <?php echo $agentDetails['businessaddress'];?>,<br/>
                                    <?php echo $agentDetails['businesscity'];?>, <br/>
                                    <?php echo $agentDetails['businesspostalcode'];?>,
                                    <?php echo $agentDetails['businesscountry'];?>.<br/>
                                    Phone: <?php echo $agentDetails['businesstelephone'];?>
                                  <?php }?>
                                </td>
                                <td>
                                  Invoice Id: <label id="invoiceLabel"><?php echo $invoiceId;?></label><br />
                                  Booking Id: <?php echo date('Y', strtotime( $book['data_insert'] ) ) ?>_<?php echo $book['id_book']; ?><br />
                                  Campus: <?php echo $book['nome_centri']; ?><br/>
                                  Payment Due: <?php echo date('d/m/Y');?>
                                </td>
                              </tr>
                            </table>
                          </div>
                          <div>
                            <table >
                              <tr style="background-color: silver;">
                                <th>Package</th>
                                <th>Date in</th>
                                <th>Date out</th>
                                <th>Week(s)</th>
                              </tr>
                              <tr>
                                <td><?php echo $book['pack_package'];?></td>
                                <td><?php echo date('d/m/Y', strtotime( $book['arrival_date'] ) ); ?></td>
                                <td><?php echo date('d/m/Y', strtotime( $book['departure_date'] ) ); ?></td>
                                <td><?php echo $book['weeks']; ?></td>
                              </tr>
                            </table>
                          </div>
                          <p><strong>Package compositions:</strong></p>
                          <?php 
                              $pack_id = $book['pbmap_package_id'];
                              $weeks = $book['weeks'] . " Week";
                              $resultDataExcursion = $this->packagesmodel->getPackExcActivities($pack_id,"Excursion",$weeks);
                              
                          if($resultDataExcursion)
                            {
                          ?>
                          <div >
                            <p><strong>Excursion</strong></p>
                            <table >
                              <tr style="background-color: silver;">
                                <th style="width:70%">Excursion name</th>
                                <th>Cost</th>
                              </tr>
                              <?php 
                                foreach($resultDataExcursion as $excursion)
                                {
                                  ?>
                                    <tr>
                                      <td><?php echo $excursion['service_name'] . " (" . $excursion['serv_week'].")";?></td>
                                      <td style="text-align: right;"><?php echo $book['valuta'].number_format($excursion['serv_cost'],2,',','');?></td>
                                    </tr>
                                  <?php 
                                }
                              ?>
                            </table>
                          </div>
                          <?php }
                          $resultDataAccommodation = $this->packagesmodel->getPackExcActivities($pack_id,"Accommodation");
                          if($resultDataAccommodation)
                            {
                          ?>
                          <div >
                            <p><strong>Accommodation</strong></p>
                            <table >
                              <tr style="background-color: silver;">
                                <th style="width:70%">Accommodation</th>
                                <th>Extra night cost</th>
                                <th>Cost</th>
                              </tr>
                              <?php 
                                foreach($resultDataAccommodation as $accommodation)
                                {
                                  ?>
                                    <tr>
                                        <td><?php echo $accommodation['service_name'];?></td>
                                        <td style="text-align: right;"><?php echo $book['valuta'].number_format($accommodation['serv_extra_night'],2,',','');?></td>
                                        <td style="text-align: right;"><?php echo $book['valuta'].number_format($accommodation['serv_cost'],2,',','');?></td>
                                    </tr>
                                  <?php 
                                }
                              ?>
                            </table>
                          </div>
                          <?php }
                          $resultDataActivities = $this->packagesmodel->getPackExcActivities($pack_id,"Activity");
                          if($resultDataActivities)
                            {
                          ?>
                            <div >
                              <p><strong>Activities</strong></p>
                              <table >
                                <tr style="background-color: silver;">
                                  <th style="width:70%">Activity</th>
                                  <th >Cost</th>
                                </tr>
                                <?php 
                                  foreach($resultDataActivities as $activity)
                                  {
                                    ?>
                                      <tr>
                                        <td><?php echo $activity['service_name'];?></td>
                                        <td style="text-align: right;"><?php echo $book['valuta'].number_format($activity['serv_cost'],2,',','');?></td>
                                      </tr>
                                    <?php 
                                  }
                                ?>
                              </table>
                            </div>
                      <?php 
                            }
                          $resultDataCoursesType = $this->packagesmodel->getPackExcActivities($pack_id,"Course Type");
                          if($resultDataCoursesType)
                            {
                         ?>
                            <div >
                              <p><strong>Course type</strong></p>
                              <table >
                                <tr style="background-color: silver;">
                                  <th style="width:70%">Course type</th>
                                  <th>Extra tuition day cost</th>
                                  <th>Cost</th>
                                </tr>
                                <?php 
                                  foreach($resultDataCoursesType as $courseType)
                                  {
                                    ?>
                                      <tr>
                                        <td><?php echo $courseType['service_name'];?></td>
                                        <td style="text-align: right;"><?php echo $book['valuta'].number_format($courseType['serv_extra_tuition'],2,',','');?></td>
                                        <td style="text-align: right;"><?php echo $book['valuta'] . number_format($courseType['serv_cost'],2,',','');?></td>
                                      </tr>
                                    <?php 
                                  }
                                ?>
                              </table>
                            </div>
                        <?php 
                            }?>
                          <p><strong>Enrollment summary:</strong>
                          </p>
                          <p>
                            <table >
                              <thead>
                                <tr style="background-color: silver;">
                                  <th>Type</th>
                                  <th>Composition</th>
                                  <th>Pax</th>
                                  <th >Free GL(s)</th>
                                  <th >Cost per pax</th>
                                  <th>Total cost</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $totalInvoiceCost = 0;
                                $totalPax = 0;
                                $totalGL = 0;
                                  if( $booking_composition )
                                  {
                                    foreach ( $booking_composition as $bc )
                                    {
                                      $package_comp = "";

                                      if( $bc['pcomp_week'] != "" && $bc['accom_name'] != "" && $bc['courses_type'] != "" && $bc['act_activity_name'] != "" )
                                        $package_comp = $bc['pcomp_week'].' Week - '.$bc['accom_name'].' - '.$bc['courses_type'].' - '.$bc['act_activity_name'];
                                      else if ( $bc['pcomp_week'] != "" && $bc['accom_name'] != "" )
                                      {
                                        if( $bc['courses_type'] == "" && $bc['act_activity_name'] == "" )
                                        {
                                          $package_comp = $bc['pcomp_week'].' Week - '.$bc['accom_name'];
                                        }
                                        else if( $bc['courses_type'] == "" && $bc['act_activity_name'] != "" )
                                        {
                                          $package_comp = $bc['pcomp_week'].' Week - '.$bc['accom_name'].' - '.$bc['act_activity_name'];
                                        }
                                        else if( $bc['courses_type'] != "" && $bc['act_activity_name'] == "" )
                                        {
                                          $package_comp = $bc['pcomp_week'].' Week - '.$bc['accom_name'].' - '.$bc['courses_type'];
                                        }
                                      }
                                ?>
                                      <tr>
                                        <td>
                                          <?php echo $bc['tipo_pax'] ?>
                                        </td>
                                        <td>
                                          <?php echo $package_comp ?>
                                        </td>
                                        <td>
                                          <?php echo $bc['cnt'];
                                            if($bc['tipo_pax'] == "STD")
                                                $totalPax = $totalPax + $bc['cnt'];
                                            if($bc['tipo_pax'] == "GL")
                                                $totalGL = $totalPax + $bc['cnt'];
                                          ?>
                                        </td>
                                        <td style="text-align: center;">
                                          <?php 
                                          // is qualified for free gl
                                          $freeGlPerPax = $bc['pack_free_gl_per_pax'];
                                          $extraGLPrice = $bc['pack_extra_gl_price'] * $book['weeks'];
                                          $extrGL = 0;
                                          $payableGl = 0;
                                          $freeGL = (int)($book['students_count'] / $freeGlPerPax);
                                          $remaingPaxToReachFreeGL = $book['students_count'] % $freeGlPerPax;
                                          if($bc['tipo_pax'] == "GL")
                                          {
                                            if($freeGL == $totalGL)
                                            {
                                                echo $totalGL;
                                                $payableGl = 0;
                                            }
                                            elseif($freeGL > $totalGL)
                                            {
                                                echo $totalGL;
                                                $payableGl = 0;
                                            }
                                            elseif($freeGL > 0)
                                            {
                                                echo $freeGL;
                                                $extrGL = $totalGL - $freeGL;
                                            }
                                            else
                                            {
                                                echo 0;
                                                $payableGl = $totalGL;
                                            }
                                           }
                                          ?>
                                        </td>
                                        <td style="text-align: right;">
                                    <?php
                                    $display_price = 0;
                                    
                                    if( $book['students_count'] >= 0 && $book['students_count'] <= 19 )
                                    {
                                        $display_price = $bc['pcomp_price_a'];
                                    }
                                    else if( $book['students_count'] >= 20 && $book['students_count'] <= 39 )
                                    {
                                        $display_price = $bc['pcomp_price_b'];
                                    }
                                    else if( $book['students_count'] >= 40 )
                                    {
                                        $display_price = $bc['pcomp_price_c'];
                                    }
                                    else
                                    {
                                        $display_price = $bc['pcomp_full_price'];
                                    }
                                    
                                    // CALCULATIONS-
                                        if($bc['tipo_pax'] != "GL") 
                                        {
                                            echo $book['valuta'] . number_format($display_price, 2, ',', '');
                                        } else 
                                        {
                                            if ($extrGL)  // it means there are some free GLs
                                            {
                                                // calculate the ratio cost.
                                                $ratioCost = ($display_price / $freeGlPerPax) * ($freeGlPerPax - $remaingPaxToReachFreeGL);
                                                
                                                if($ratioCost < $extraGLPrice)
                                                    $extraGLPrice = $ratioCost;
                                                echo $book['valuta'] . number_format($extraGLPrice, 2, ',', '');
                                                
                                            } else 
                                            {
                                                // IF THERE ARE NO EXTRA GL MEANS NO FREE GL
                                                // THEN USE COMPOSITION PRICE WITH THE FORMULA TO CALCULATE GL COST
                                                $gl_formula_price = $display_price / $freeGlPerPax * ($freeGlPerPax - $remaingPaxToReachFreeGL);
                                                if ($gl_formula_price > 0)
                                                    echo $book['valuta'] . number_format($gl_formula_price, 2, ',', '');
                                                else
                                                    echo $book['valuta'] . number_format(0, 2, ',', '');
                                            }
                                        }
                                          ?>
                                        </td>
                                        <td style="text-align: right;">
                                          <?php 
                                          if($bc['tipo_pax'] == "GL"){
                                                if($extrGL)
                                                {
                                                    $totalInvoiceCost = $totalInvoiceCost + ($extrGL * ($extraGLPrice));
                                                    echo $book['valuta'].number_format($extrGL * ($extraGLPrice), 2, ',', '');
                                                }
                                                else{
                                                    $gl_formula_price = $display_price / $freeGlPerPax * ($freeGlPerPax - $remaingPaxToReachFreeGL);
                                                    if($gl_formula_price > 0)
                                                    {
                                                        $totalInvoiceCost = $totalInvoiceCost + ($payableGl * $gl_formula_price);
                                                        echo $book['valuta'].number_format($payableGl * $gl_formula_price, 2, ',', '');
                                                    }else{
                                                        echo $book['valuta'].number_format(0, 2, ',', '');
                                                    }
                                                }
                                          }
                                          else
                                          {
                                            $totalInvoiceCost = $totalInvoiceCost + ($bc['cnt'] * $display_price);
                                            echo $book['valuta'].number_format($bc['cnt'] * $display_price, 2, ',', '');
                                          }
                                        ?>
                                            
                                        </td>
                                      </tr>
                                <?php
                                    }
                                  }
                              ?>
                                      <tr>
                                        <td colspan="5" style="text-align: right;">
                                          Extra night charges: <br />
                                          Extra tuition day charges: <br />
                                          Total number of GL: <?php echo $totalGL;?><br />
                                          Total number of STD: <?php echo $totalPax;?>
                                        </td>
                                        <td style="text-align: right;">
                                            <?php echo $book['valuta'].number_format($bookingExtraNightCharges, 2, ',', '');
                                            $totalInvoiceCost = $totalInvoiceCost + $bookingExtraNightCharges;
                                            ?>
                                            <br />
                                            <?php echo $book['valuta'].number_format($bookingExtraTuitionCharges, 2, ',', '');
                                            $totalInvoiceCost = $totalInvoiceCost + $bookingExtraTuitionCharges;
                                            ?>
                                            <br />
                                            <?php echo $book['valuta'].number_format($totalInvoiceCost, 2, ',', ''); ?>
                                        </td>
                                      </tr>
                              </tbody>
                            </table>
                        </p>
                        <p>
                          <strong>Staff charges[per week]:</strong>
                          <?php 
                            $staffCharges = 0;
                            $staffChargesA = 0;
                            $staffChargesB = 0;
                          ?>
                        </p>
                        <table >
                          <thead>
                            <tr style="background-color: silver;">
                              <th style="width: 40%;">Component</th>
                              <th style="text-align: right;">Cost</th>
                              <th style="width: 40%;">Component</th>
                              <th style="text-align: right;">Cost</th>
                            </tr>
                            <tr>
                              <td>Course director salary</td>
                              <td style="text-align: right;"><?php $staffChargesA = $staffChargesA + $book['pack_cd_salary']; echo $book['valuta'].number_format($book['pack_cd_salary'], 2, ',', '');?></td>
                              <td>Course director accommodation</td>
                              <td style="text-align: right;"><?php $staffChargesB = $staffChargesB + $book['pack_cd_accomodation']; echo $book['valuta'].number_format($book['pack_cd_accomodation'], 2, ',', '');?></td>
                            </tr>
                            <tr>
                              <td>Assistant course director salary</td>
                              <td style="text-align: right;"><?php $staffChargesA = $staffChargesA + $book['pack_acd_salary']; echo $book['valuta'].number_format($book['pack_acd_salary'], 2, ',', '');?></td>
                              <td>Assistant course director accommodation</td>
                              <td style="text-align: right;"><?php $staffChargesB = $staffChargesB + $book['pack_acd_accomodation']; echo $book['valuta'].number_format($book['pack_acd_accomodation'], 2, ',', '');?></td>
                            </tr>
                            <tr>
                              <td>Campus manager salary</td>
                              <td style="text-align: right;"><?php $staffChargesA = $staffChargesA + $book['pack_cm_salary']; echo $book['valuta'].number_format($book['pack_cm_salary'], 2, ',', '');?></td>
                              <td>Campus manager accommodation</td>
                              <td style="text-align: right;"><?php $staffChargesB = $staffChargesB + $book['pack_cm_accomodation']; echo $book['valuta'].number_format($book['pack_cm_accomodation'], 2, ',', '');?></td>
                            </tr>
                            <tr>
                              <td>Assistant campus manager salary</td>
                              <td style="text-align: right;"><?php $staffChargesA = $staffChargesA + $book['pack_acm_salary']; echo $book['valuta'].number_format($book['pack_acm_salary'], 2, ',', '');?></td>
                              <td>Assistant campus manager accommodation</td>
                              <td style="text-align: right;"><?php $staffChargesB = $staffChargesB + $book['pack_acm_accomodation']; echo $book['valuta'].number_format($book['pack_acm_accomodation'], 2, ',', '');?></td>
                            </tr>
                            <tr>
                              <td>Teacher accommodation</td>
                              <td style="text-align: right;"><?php $staffChargesA = $staffChargesA + $book['pack_teacher_accomodation']; echo $book['valuta'].number_format($book['pack_teacher_accomodation'], 2, ',', '');?></td>
                              <td>Teacher lunch</td>
                              <td style="text-align: right;"><?php $staffChargesB = $staffChargesB + $book['pack_teacher_lunch']; echo $book['valuta'].number_format($book['pack_teacher_lunch'], 2, ',', '');?></td>
                            </tr>
                            <tr>
                              <td style="text-align: right;">Total</td>
                              <td style="text-align: right;"><?php echo $book['valuta'].number_format($staffChargesA, 2, ',', '');?></td>
                              <td style="text-align: right;">Total</td>
                              <td style="text-align: right;"><?php echo $book['valuta'].number_format($staffChargesB, 2, ',', '');?></td>
                            </tr>
                            <tr>
                              <td colspan="3" style="text-align: right;">Total</td>
                              <td style="text-align: right;"><?php $staffCharges = $staffChargesA + $staffChargesB; echo $book['valuta'].number_format(($staffCharges), 2, ',', '');?></td>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                        <p>
                          <strong>Other charges:</strong>
                        </p>
                        <table >
                          <thead>
                            <tr style="background-color: silver;">
                              <th style="width: 40%;">Component</th>
                              <th style="text-align: right;">Cost</th>
                              <th style="width: 40%;">Component</th>
                              <th style="text-align: right;">Cost</th>
                            </tr>
                            <tr>
                              <td>Travel</td>
                              <td style="text-align: right;"><?php echo $book['valuta'].number_format($book['pack_travelling'], 2, ',', '');?></td>
                              <td>Printing / Stationery</td>
                              <td style="text-align: right;"><?php echo $book['valuta'].number_format($book['pack_printing_stationary'], 2, ',', '');?></td>
                            </tr>
                            <tr>
                              <td>Books</td>
                              <td style="text-align: right;"><?php echo $book['valuta'].number_format($book['pack_books'], 2, ',', '');?></td>
                              <td>Expenses</td>
                              <td style="text-align: right;"><?php echo $book['valuta'].number_format($book['pack_expenses'], 2, ',', '');?></td>
                            </tr>
                            <tr>
                              <td style="text-align: right;">Total</td>
                              <td style="text-align: right;"><?php echo $book['valuta'].number_format(($book['pack_travelling'] + $book['pack_books']), 2, ',', '');?></td>
                              <td style="text-align: right;">Total</td>
                              <td style="text-align: right;"><?php echo $book['valuta'].number_format(($book['pack_printing_stationary'] + $book['pack_expenses']), 2, ',', '');?></td>
                            </tr>
                            <tr>
                              <td colspan="3" style="text-align: right;">Total</td>
                              <td style="text-align: right;"><?php 
                              $otherCharges = $book['pack_travelling'] + $book['pack_books'] + $book['pack_printing_stationary'] + $book['pack_expenses'];
                              echo $book['valuta'].number_format($otherCharges, 2, ',', '');?></td>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                        <p>
                          <strong>Total invoice cost:</strong>
                        </p>
                        <table>
                          <tbody>
                             <tr style="background-color: silver;">
                              <th colspan="3" style="text-align: right;">Total cost</th>
                              <th style="text-align: right;"><?php echo $book['valuta'].number_format(($totalInvoiceCost), 2, ',', '');?></th>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      <?php 
        // store invoice data into database....
        $updateAdd = array(
            'inv_number_of_pax' => $totalPax,
            'inv_number_of_gl' => $totalGL,
            'inv_total_cost' => $totalInvoiceCost
        );
        $this->packagesmodel->saveInvoiceData($updateAdd,"update",$invoiceId);
      ?>
    </body>
</html>