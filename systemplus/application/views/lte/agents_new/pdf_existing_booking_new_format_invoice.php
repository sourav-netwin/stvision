<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>plus-ed.com | booking invoice</title>
        <style>
            body{
                background-color: aliceblue;
            }
            table, td, th {
                padding: 5px;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }
            td {
                height: 22px;
                vertical-align: top;
                padding: 5px;
            }
            hr {
                color: #0067A8;
                height: 1px;
                margin: 10px 0px 10px 0px;
            }
        </style>
    </head>
    <body style="font-family: Tahoma;font-size: 12px; background-color:#ffffff; margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;">
      <?php 
        if($book['valuta_fattura'] == "EUR")
            $book['valuta'] = "&euro;";
        else if($book['valuta_fattura'] == "GBP")
            $book['valuta'] = "&pound;";
        else if($book['valuta_fattura'] == "USD")
            $book['valuta'] = "$";
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
            'inv_date' => date("Y-m-d"),
            'inv_invoice_file' => $invoiceFileName
        );
        $invoiceId = $this->packagesmodel->saveInvoiceData($invoiceAdd);
      ?>
        <div style="padding: 10px 20px 10px 20px;">
            <div >
                <table style="border: none;">
                    <tr>
                        <td >
                            <br />
                            <span style="font-size:24px;font-weight: bold;">Agent Net Statement of Account</span>
                            <br/>
                            <span style="font-size:16px;font-weight: bold;"><?php echo date('Y', strtotime( $book['data_insert'] ) ) ?>_<?php echo $book['id_book']; ?></span>
                        </td>
                        <td >
                            <img style="float:right;" style="width:125px;" src="<?php echo base_url(); ?>img/logo_plus.png" alt=""/>
                        </td>
                    </tr>
                </table>
            </div>
            <hr />
        <?php 
        $agentDetails = $this->agent_booking_model->getBookingAgentDetails($book['id_agente']);
            $pricecategory = "No profile";
        ?>
            <div>
                <table>
                    <tr>
                        <td rowspan="4" style="width:15%;font-weight: bold;">Agent</td>
                        <td rowspan="4" style="width:35%">
                            <?php if ($agentDetails > 0) { ?>
                                <?php echo $agentDetails['businessname']; ?><br/>
                                <?php echo $agentDetails['businessaddress']; ?>,<br/>
                                <?php echo $agentDetails['businesscity']; ?>, <br/>
                                <?php echo $agentDetails['businesspostalcode']; ?>,
                                <?php echo $agentDetails['businesscountry']; ?>.<br/>
                                Phone: <?php echo $agentDetails['businesstelephone']; ?>
                            <?php 
                                $pricecategory = $agentDetails['pricecategory'];
                            } ?>
                        </td>
                        <td style="width:15%;font-weight: bold;">Statement Date</td>
                        <td style="width:35%;">
                            <?php echo date("d-M-Y"); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Students No.</td>
                        <td>
                            <?php echo $book['students_count']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Group Leaders No.</td>
                        <td>
                            <?php echo $book['gl_count']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Center</td>
                        <td>
                            <?php echo $book['nome_centri']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                            Arrival Date
                        </td>
                        <td><?php echo date('d-M-Y', strtotime($book['arrival_date'])); ?></td>
                        <td style="font-weight: bold;">
                            Departure Date
                        </td>
                        <td><?php echo date('d-M-Y', strtotime($book['departure_date'])); ?></td>
                    </tr>
                </table>
            </div>
            <hr />
            <div style="margin-top: 10px;">
<!--                <p style="font-weight: bold;">
                    Summer Language course in <?php //echo $book['school_name']; ?> - General English Course 20 Lesson P.w. - <?php //echo ucwords($book['pack_package']);?>
                </p>-->
                <table >
                    <thead style="border: 1px solid black;">
                        <tr>
                            <th style="width:38%;text-align: left;border: 1px solid black;">Description</th>
                            <th style="width:10%;text-align: left;border: 1px solid black;">Quantity</th>
                            <th style="width:10%;text-align: left;border: 1px solid black;">From</th>
                            <th style="width:10%;text-align: left;border: 1px solid black;">To</th>
                            <th style="width:10%;text-align: center;border: 1px solid black;">Duration</th>
                            <th style="width:12%;text-align: right;border: 1px solid black;">Gross price</th>
                            <th style="width:10%;text-align: right;border: 1px solid black;">Net price</th>
                            <th style="width:12%;text-align: right;border: 1px solid black;">Total price</th>
                            
                        </tr>
                    </thead>
                    <tbody style="border: 1px solid black;">
                    <?php
                    $numOfWeeks = $book['weeks'];
                    $totalInvoiceCost = 0;
                    $totalPax = 0;
                    $totalGL = $book['gl_count'];
                    if( $booking_composition )
                    {
                    foreach ( $booking_composition as $bc )
                    {
                        $package_comp = "";
                        if ($bc['pcomp_week'] != "" && $bc['accom_name'] != "" && $bc['courses_type'] != "" && $bc['act_activity_name'] != "")
                            $package_comp = $bc['accom_name'] . ' - ' . $bc['courses_type'] . ' - ' . $bc['act_activity_name'];
                        else if ($bc['pcomp_week'] != "" && $bc['accom_name'] != "") {
                            if ($bc['courses_type'] == "" && $bc['act_activity_name'] == "") {
                                $package_comp = $bc['accom_name'];
                            } else if ($bc['courses_type'] == "" && $bc['act_activity_name'] != "") {
                                $package_comp = $bc['accom_name'] . ' - ' . $bc['act_activity_name'];
                            } else if ($bc['courses_type'] != "" && $bc['act_activity_name'] == "") {
                                $package_comp = $bc['accom_name'] . ' - ' . $bc['courses_type'];
                            }
                        }
                        ?>
                        <tr>
                            <td style="width:40%;border: 1px solid black;">
                        <?php
                            $freeGlPerPax = $bc['pack_free_gl_per_pax'];
                            $extraGLPrice = $bc['pack_extra_gl_price'] * $book['weeks'];
                            $extrGL = 0;
                            $payableGl = 0;
                            $freeGL = 0;
                            $remaingPaxToReachFreeGL = 0;
                            if($freeGlPerPax)
                            {
                                $freeGL = (int)($book['students_count'] / $freeGlPerPax);
                                $remaingPaxToReachFreeGL = $book['students_count'] % $freeGlPerPax;
                            }
                            
                            if ($bc['tipo_pax'] == "GL") {
                                if ($freeGL == $totalGL) {
                                    $payableGl = 0;
                                } elseif ($freeGL > $totalGL) {
                                    $freeGL = $totalGL;
                                    $payableGl = 0;
                                } elseif ($freeGL > 0) {
                                    $extrGL = $totalGL - $freeGL;
                                } else {
                                    $payableGl = $totalGL;
                                }
                            }
                            
                            if($bc['tipo_pax'] == "STD")
                                echo ucwords($book['pack_package']) . " Students - " . $package_comp;
                            if($bc['tipo_pax'] == "GL")
                                echo ucwords($book['pack_package']) . " Group Leader - " . $package_comp;
                                ?>
                            </td>
                            <td style="width:10%;border: 1px solid black;">
                                <?php 
                                if($bc['tipo_pax'] == "STD")
                                {
                                    $totalPax = $totalPax + $bc['cnt'];
                                    echo $bc['cnt'];
                                }
                                if($bc['tipo_pax'] == "GL")
                                {
                                    $totalGL = $totalPax + $bc['cnt'];
                                    echo $bc['cnt'] . " (Free: ".$freeGL.")";
                                }
                                ?>
                            </td>
                            <td style="width:10%;border: 1px solid black;"><?php echo date('d-M-Y', strtotime($book['arrival_date'])); ?></td>
                            <td style="width:10%;border: 1px solid black;"><?php echo date('d-M-Y', strtotime($book['departure_date'])); ?></td>
                            <td style="width:10%;text-align: center;border: 1px solid black;"><?php echo $book['weeks'];?> Week(s)</td>
                            <td style="width:10%;text-align: right;border: 1px solid black;">
                            <?php 
                                $display_price = 0;
                                $comp_full_price = $bc['pcomp_full_price'];
                                if($pricecategory == "No profile" || empty($pricecategory))
                                {
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
                                }
                                else
                                {
                                    if( $pricecategory == "Profile A" )
                                    {
                                        $display_price = $bc['pcomp_price_a'];
                                    }
                                    else if( $pricecategory == "Profile B" )
                                    {
                                        $display_price = $bc['pcomp_price_b'];
                                    }
                                    else if( $pricecategory == "Profile C" )
                                    {
                                        $display_price = $bc['pcomp_price_c'];
                                    }
                                    else
                                    {
                                        $display_price = $bc['pcomp_full_price'];
                                    }
                                }
                                echo $book['valuta'].number_format($comp_full_price / $numOfWeeks, 2, '.', '');?>
                            </td>
                            <td style="width:10%;text-align: right;border: 1px solid black;">
                            <?php
                                // CALCULATIONS-
                                if($bc['tipo_pax'] != "GL") 
                                {
                                    echo $book['valuta'] . number_format(($display_price / $numOfWeeks), 2, '.', '');
                                } else 
                                {
                                    if ($extrGL)  // it means there are some free GLs
                                    {
                                        // calculate the ratio cost.
                                        $ratioCost = ($display_price / $freeGlPerPax) * ($freeGlPerPax - $remaingPaxToReachFreeGL);
                                        if($ratioCost < $extraGLPrice)
                                            $extraGLPrice = $ratioCost;
                                        echo $book['valuta'] . number_format(($extraGLPrice / $numOfWeeks), 2, '.', '');

                                    } else 
                                    {
                                        // IF THERE ARE NO EXTRA GL MEANS NO FREE GL
                                        // THEN USE COMPOSITION PRICE WITH THE FORMULA TO CALCULATE GL COST
                                        $gl_formula_price = 0;
                                        if($freeGlPerPax * ($freeGlPerPax - $remaingPaxToReachFreeGL))
                                            $gl_formula_price = $display_price / $freeGlPerPax * ($freeGlPerPax - $remaingPaxToReachFreeGL);
                                        else
                                            $gl_formula_price = $display_price;
                                        if ($gl_formula_price > 0)
                                        {
                                            echo $book['valuta'] . number_format(($gl_formula_price / $numOfWeeks), 2, '.', '');
                                        }
                                        else
                                        {
                                            echo $book['valuta'] . number_format(0, 2, '.', '');
                                        }
                                    }
                                }
                            ?>
                            </td>
                            <td style="width:10%;text-align: right;border: 1px solid black;">
                                <?php 
                                    if($bc['tipo_pax'] == "GL"){
                                        if($extrGL)
                                        {
                                            $totalInvoiceCost = $totalInvoiceCost + ($extrGL * ($extraGLPrice));
                                            echo $book['valuta'].number_format($extrGL * ($extraGLPrice), 2, '.', '');
                                        }
                                        else{
                                            $gl_formula_price = 0;
                                            if($freeGlPerPax * ($freeGlPerPax - $remaingPaxToReachFreeGL))
                                                $gl_formula_price = $display_price / $freeGlPerPax * ($freeGlPerPax - $remaingPaxToReachFreeGL);
                                            else
                                                $gl_formula_price = $display_price;
                                            if($gl_formula_price > 0)
                                            {
                                                $totalInvoiceCost = $totalInvoiceCost + ($payableGl * $gl_formula_price);
                                                echo $book['valuta'].number_format($payableGl * $gl_formula_price, 2, '.', '');
                                            }else{
                                                echo $book['valuta'].number_format(0, 2, ',', '');
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $totalInvoiceCost = $totalInvoiceCost + ($bc['cnt'] * $display_price);
                                        echo $book['valuta'].number_format($bc['cnt'] * $display_price, 2, '.', '');
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                        <?php if($bookingExtraNight){?>
                        <tr>
                            <td style="width:40%;text-align: left;border: 1px solid black;">Extra Night</td>
                            <td style="width:10%;border: 1px solid black;">
                                <?php echo 1;?>
                            </td>
                            <td style="width:10%;border: 1px solid black;">-</td>
                            <td style="width:10%;border: 1px solid black;">-</td>
                            <td style="width:10%;border: 1px solid black;text-align: center;">
                                <?php echo $bookingExtraNight . " Night(s)";?>
                            </td>
                            <td style="width:10%;text-align: right;border: 1px solid black;">-</td>
                            <td style="width:10%;border: 1px solid black;text-align: right;">
                                <?php 
                                echo $book['valuta'].number_format($perExtraNight, 2, '.', '');
                                ?>
                            </td>
                            <td style="width:10%;text-align: right;border: 1px solid black;">
                            <?php 
                                echo $book['valuta'].number_format($bookingExtraNightCharges, 2, '.', '');
                                $totalInvoiceCost = $totalInvoiceCost + $bookingExtraNightCharges;
                            ?>
                            </td>
                        </tr>
                        <?php }?>
                        <?php if($bookingExtraTuitionDay){?>
                        <tr>
                            <td style="width:40%;text-align: left;border: 1px solid black;">Extra Tuition Day</td>
                            <td style="width:10%;border: 1px solid black;">
                                <?php echo 1;?>
                            </td>
                            <td style="width:10%;border: 1px solid black;">-</td>
                            <td style="width:10%;border: 1px solid black;">-</td>
                            <td style="width:10%;border: 1px solid black;text-align: center;">
                                <?php echo $bookingExtraTuitionDay . " Day(s)";?>
                            </td>
                            <td style="width:10%;text-align: right;border: 1px solid black;">-</td>
                            <td style="width:10%;border: 1px solid black;text-align: right;">
                                <?php 
                                echo $book['valuta'].number_format($perExtraTuitionDay, 2, '.', '');
                                ?>
                            </td>
                            <td style="width:10%;text-align: right;border: 1px solid black;">
                            <?php 
                                echo $book['valuta'].number_format($bookingExtraTuitionCharges, 2, '.', '');
                                $totalInvoiceCost = $totalInvoiceCost + $bookingExtraTuitionCharges;
                            ?>
                            </td>
                        </tr>
                        <?php }?>
                        <tr>
                            <th style="width:40%;text-align: left;border: 1px solid black;">Total</th>
                            <th style="width:10%;border: 1px solid black;"></th>
                            <th style="width:10%;border: 1px solid black;"></th>
                            <th style="width:10%;border: 1px solid black;"></th>
                            <th style="width:10%;border: 1px solid black;"></th>
                            <th style="width:10%;border: 1px solid black;"></th>
                            <th style="width:10%;border: 1px solid black;"></th>
                            <th style="width:10%;text-align: right;border: 1px solid black;"><?php echo $book['valuta'].number_format($totalInvoiceCost, 2, '.', ''); ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 10px;">
                <table style="font-weight: bold;">
                    <thead>
                        <tr>
                            <td style="width:40%">Transfer Fee Balance</td>
                            <td style="width:10%;text-align: right;"><?php echo $book['valuta'].number_format(0, 2, '.', ''); ?></td>
                        </tr>
                        <tr>
                            <td style="width:40%">Attraction</td>
                            <td style="width:10%;text-align: right;"><?php echo $book['valuta'].number_format(0, 2, '.', ''); ?></td>
                        </tr>
                        <tr>
                            <td style="width:40%">Payment Received</td>
                            <td style="width:10%;text-align: right;">
                            <?php echo $book['valuta'].number_format(0, 2, '.', ''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:40%">Discount</td>
                            <td style="width:10%;text-align: right;">
                            <?php echo $book['valuta'].number_format($bookingDiscount, 2, '.', ''); 
                                if($bookingDiscount > 0)
                                    $totalInvoiceCost = $totalInvoiceCost - $bookingDiscount;
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:40%">Balance Due</td>
                            <td style="width:10%;text-align: right;">
                            <?php echo $book['valuta'].number_format($totalInvoiceCost, 2, '.', ''); ?>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <hr />
            <div style="margin-top: 10px;">
                <div>
                    <p><strong>Payment Due Dates</strong></p>
                        <table style="font-weight: bold;width: 50%;">
                            <thead>
                                <tr>
                                    <th style="width:50%;text-align: left;border: 1px solid black;">Due Date</th>
                                    <th style="text-align: right;border: 1px solid black;">Amount</th>
                                </tr>
                                <tr>
                                    <th style="text-align: left;border: 1px solid black;">
                                        <?php echo date('d-M-Y', strtotime($book['arrival_date'] ." -30 days")); ?>
                                    </th>
                                    <th style="text-align: right;border: 1px solid black;">
                                        <?php echo $book['valuta'].number_format($totalInvoiceCost, 2, '.', ''); ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                </div>
            </div>
            <hr />
            <div style="margin-top: 10px;">
                <?php if($book['valuta_fattura'] == "GBP"){?>
                 <div>
                    <strong>All bank charges are to be borne by the payer.</strong>
                    <p><strong>Bank Details</strong></p>
                    <p>
                    <strong>Account Name :</strong>  Professional Linguistic & Upper Studies Ltd<br />
                    <strong>Beneficiary Address :</strong> 8-10 Grosvenor Gardens ,London, SW1 W ODH
                    </p>
                    <p>
                        <strong>Bank Name :</strong>   Coutts and Co Bank <br />
                        <strong>Account No:</strong>  08323534 <br />
                        <strong>Sort Code:</strong>    18-00-02<br />
                        <strong>BIC :</strong> 	    COUTGB22<br />
                        <strong>IBAN No:</strong>      GB63 COUT 1800 0208 3235 34<br />
                        <strong>Bank Address:</strong> 440 Strand, London WC2R 0QS
                    </p>
                </div>
                <?php }
                else if($book['valuta_fattura'] == "USD"){?>
                <div>
                    <strong>All bank charges are to be borne by the payer.</strong>
                    <p><strong>Bank Details</strong></p>
                    <p>
                    <strong>Account Name :</strong>  Professional Linguistic & Upper Studies Ltd<br />
                    <strong>Beneficiary Address :</strong> 8-10 Grosvenor Gardens ,London, SW1 W ODH
                    </p>
                    <p>
                        <strong>Bank Name :</strong>   Coutts and Co Bank <br />
                        <strong>Account No:</strong>  09467971 <br />
                        <strong>Sort Code:</strong>    18-00-91<br />
                        <strong>BIC :</strong> 	    COUTGB22<br />
                        <strong>IBAN No:</strong>      GB38 COUT 1800 9109 4679 71<br />
                        <strong>Bank Address:</strong> 440 Strand, London WC2R 0QS
                    </p>
                </div>
                <?php }
                else if($book['valuta_fattura'] == "EUR"){?>
                <div>
                    <strong>All bank charges are to be borne by the payer.</strong>
                    <p><strong>Bank Details</strong></p>
                    <p>
                    <strong>Account Name :</strong>  Professional Linguistic & Upper Studies Ltd<br />
                    <strong>Beneficiary Address :</strong> 8-10 Grosvenor Gardens ,London, SW1 W ODH
                    </p>
                    <p>
                        <strong>Bank Name :</strong>   Coutts and Co Bank <br />
                        <strong>Account No:</strong>  07467974 <br />
                        <strong>Sort Code:</strong>    18-00-91<br />
                        <strong>BIC :</strong> 	    GBCOUT22<br />
                        <strong>IBAN No:</strong>      GB57 COUT 1800 9107 4679 74<br />
                        <strong>Bank Address:</strong> 440 Strand, London WC2R 0QS
                    </p>
                </div>
                <?php }?>
            </div>
            <hr />
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