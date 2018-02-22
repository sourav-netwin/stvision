<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>plus-ed.com | Enroll Booking</title>
  </head>
  <body style="margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;">

    <div style="width:100%;max-width:800px;margin:0 auto;position:relative;display:block;" id="warpper">
      <div style="width:100%;margin:0 ;float:left;" id="warpper_in">
	      <div class="top_header" style="background-color: #587691;padding: 10px 0 10px 10px;width:98%;max-width:800px;height:100%;float:left;">
          <img style="width:135px;float:left;height:auto;" src="<?php echo base_url(); ?>img/tuition/email_logo.png" alt=""/>
        </div>
   	    <div style="width:94%;float:left;padding:3%;" class="mid_content">
          <p><?php echo $username; ?>,</p>
          <p>
            <?php echo $message; ?>
          </p>
          <p>
            <strong>Booking id: </strong><?php echo date('Y', strtotime( $booking_details['enrol_created_on'] ) ) ?>_<?php echo $booking_details['enroll_id'] ?>
          </p>
          <p>
            <strong>Date in: </strong><?php echo date('d/m/Y', strtotime( $booking_details['enrol_arrival_date'] ) ) ?>
          </p>
          <p>
            <strong>Date out: </strong><?php echo date('d/m/Y', strtotime( $booking_details['enrol_departure_date'] ) ) ?>
          </p>
          <p><strong>Week(s): </strong><?php echo $booking_details['enrol_number_of_week'] ?></p>
          <p>
            <strong>Campus: </strong><?php echo $booking_details['nome_centri'] ?>
          </p>
          <p>
            <strong>Package: </strong><?php echo $booking_details['pack_package'] ?>
          </p>
          <p>
            <strong>Pax: </strong><?php echo ($booking_details['enrol_booked_students']+$booking_details['enrol_booked_gl']) ?>
          </p>
          <p>
            <strong>Free GL(s): </strong><?php echo $booking_details['free_gl_count'] ?>
          </p>
          <p>
            <strong>Total Price: </strong><?php echo $booking_details['total_price'] ?>
          </p>
          <p><strong>Enrolment Summary:</strong></p>
          <p>
            <table border="1">
              <thead>
                <tr>
                  <th>Type</th>
                  <th>Composition</th>
                  <th>Pax</th>
                  <th>Free GL(s)</th>
                  <th>Cost</th>
                </tr>
              </thead>
              <tbody>
                <?php
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
                          <?php echo $bc['booked_tipo_pax'] ?>
                        </td>
                        <td>
                          <?php echo $package_comp ?>
                        </td>
                        <td>
                          <?php echo $bc['cnt'] ?>
                        </td>
                        <td>
                          -
                        </td>
                        <td>
                          <?php
                            if( $bc['cnt'] >= 10 && $bc['cnt'] <= 19 )
                            {
                              $display_price = $bc['valuta'].number_format($bc['cnt'] * $bc['pcomp_price_a'], 2, ',', '');
                            }
                            else if( $bc['cnt'] >= 20 && $bc['cnt'] <= 39 )
                            {
                              $display_price = $bc['valuta'].number_format($bc['cnt'] * $bc['pcomp_price_b'], 2, ',', '');
                            }
                            else if( $bc['cnt'] >= 40 )
                            {
                              $display_price = $bc['valuta'].number_format($bc['cnt'] * $bc['pcomp_price_c'], 2, ',', '');
                            }
                            else
                            {
                              $display_price = $bc['valuta'].number_format($bc['cnt'] * $bc['pcomp_full_price'], 2, ',', '');
                            }
                            echo $display_price;
                          ?>
                        </td>
                      </tr>
                <?php
                    }
                  }
                  if( $booking_accomodation )
                  {
                    $cnt = 0;
                    foreach ( $booking_accomodation as $ba )
                    {
                ?>
                      <tr>
                        <td>
                          <?php echo $ba['booked_tipo_pax'] ?>
                        </td>
                        <td>
                          <?php echo $booking_details['enrol_number_of_week'].' Week - '.$ba['accom_name'] ?>
                        </td>
                        <td>
                          <?php echo $ba['cnt'] ?>
                        </td>
                        <td>
                          <?php echo $ba['free_gl'] ?>
                        </td>
                        <td>
                          <?php
                            if( $booking_details['free_gl_count'] > 0 )
                              echo $ba['valuta'].number_format(($ba['cnt']-$ba['free_gl']) * ( $extra_gl_price * ( $booking_details['enrol_number_of_week'] * 7 ) ), 2, ',', '');
                            else if( $free_pax_cnt > 0 )
                            {
                              if( $cnt == 0 )
                              {
                                $first_gl_price = $remaining_gl_price = 0;
                                $remaining_gl = $ba['cnt'] - 1;

                                if( $ba['cnt'] > 0 )
                                {
                                  $first_gl_price = ( ( $booking_details['enrol_booked_students']*$ba['serv_cost'] )/$free_pax_cnt) * ( $booking_details['enrol_number_of_week'] * 7 );
                                  $cnt++;
                                }

                                if( $remaining_gl > 0 )
                                  $remaining_gl_price = $remaining_gl * ( $ba['serv_cost'] * ( $booking_details['enrol_number_of_week'] * 7 ) );

                                $price = $first_gl_price+$remaining_gl_price;
                              }
                              else
                              {
                                $price = ( ($ba['cnt']-$ba['free_gl']) * ( $ba['serv_cost'] * ( $booking_details['enrol_number_of_week'] * 7 ) ) );
                              }

                              echo $ba['valuta'].number_format($price, 2, ',', '');
                            }
                            else
                            {
                              $price = ( ($ba['cnt']-$ba['free_gl']) * ( $ba['serv_cost'] * ( $booking_details['enrol_number_of_week'] * 7 ) ) );
                              echo $ba['valuta'].number_format($price, 2, ',', '');
                            }
                          ?>
                        </td>
                      </tr>
              <?php
                    }
                  }
              ?>
              </tbody>
            </table>
          </p>
          <br />
          <br />
          <br />
          <br />
          Plus Staff
        </div>
        <div style="width:100%;max-width:800px;height:100%;float:left;height:40px;" class="fotter">
          <div style="background-color: #587691;min-height: 60px;color: #fff;font-family: Arial,Helvetica,sans-serif;font-size: 14px;font-weight: bold;height: 0;margin: 0;padding: 40px 0 0;text-align: center;" class="txt1">
          </div>
        </div>
      </div>
    </div>
  </body>
</html>