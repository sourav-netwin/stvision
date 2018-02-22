<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<section class="content">
    <div class="row">
    
    <div class="col-xs-12">
      <div class="box">
      <?php if($this->session->userdata('role') == 200){ ?>
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this);?>
            </div>
            <form id="addPaymentFinCM" name="addPaymentFinCM" action="<?php echo site_url() ?>/backoffice/insertCMSinglePayment" method="POST" enctype="multipart/form-data" >
                <div class="row payment_row">
                    <div class="col-sm-4 col-md-3">
                        <label for="P_typePay">Type:</label>
                        <select class="form-control" id="P_typePay" name="P_typePay">
                            <option value="paid">Paid</option>
                            <option value="cashed">Cashed</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <label for="P_curDate">Payment date:</label>
                        <input class="form-control datepicker" type="text" id="P_curDate" name="P_curDate" readonly="readonly" />
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <label for="P_amount">Amount/Due:</label> 
                        <input class="form-control" type="text" id="P_amount" name="P_amount" maxlength="10" onkeypress="return keyRestrict(event,'1234567890');" />
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <label for="P_currency">Currency:</label>
                        <select class="form-control" id="P_currency" name="P_currency">
                            <option value="£">£</option>
                            <option value="$">$</option>
                            <option value="€">€</option>                                            
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <label for="P_operation">Service:</label>
                        <select class="form-control" id="P_operation" name="P_operation">
                            <option value="">Select service</option>
                            <?php foreach ($payServices as $pS) { ?>
                                <option value="<?php echo $pS["pcse_name"] ?>"><?php echo $pS["pcse_name"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <label for="P_method">Method:</label>
                        <select class="form-control" id="P_method" name="P_method">
                            <option value="CASH">CASH</option>
                            <option value="CREDIT CARD">CREDIT CARD</option>
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <label for="P_method">Booking id:</label>
                        <select class="form-control" id="P_bookList" name="P_bookList">
                            <option value="all">All</option>
                            <?php
                            if (!empty($payBookings)) {
                                foreach ($payBookings as $pB) {
                                    ?>
                                    <option value="<?php echo $pB["booking_id"] ?>"><?php echo $pB["booking_id"] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <label for="CmPicFile">Picture/File:</label>
                        <input type="file" name="CmPicFile" id="CmPicFile" style="z-index: 10 !important;" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 mr-top-10">
                        <input class="btn btn-primary" type="submit" value="Add" id="P_add" />
                    </div>
                </div>
            </form>
        </div>
        <?php } ?>
        <div class="box-body table-responsive">
            <table id="dataTableStaffPriority" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Booking id</th>
                        <th>Operation date</th>
                        <th>Paid</th>
                        <th>Type</th>
                        <th>Cashed</th>
                        <th>Operation type</th>
                        <th>Payment method</th>
                        <th>Pictures/ Files</th>
                        <th class="no-sort">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (!empty($payments)) {
                            $totalDueGBP = 0;
                            $totalDueUSD = 0;
                            $totalDueEUR = 0;
                            $totalCashedGBP = 0;
                            $totalCashedUSD = 0;
                            $totalCashedEUR = 0;
                            $totalRefundGBP = 0;
                            $totalRefundUSD = 0;
                            $totalRefundEUR = 0;
                            $totalDue = 0;
                            $totalCashed = 0;
                            $totalBalance = 0;
                            $cnt = 1;
                            $totalPaid = 0;
                            $totalCashed = 0;
                            foreach ($payments as $payment) {
                                $fileExt = '';
                                $iconName = '';
                                if (!empty($payment['pcp_document'])) {
                                    $fileExt = pathinfo($payment['pcp_document'], PATHINFO_EXTENSION);
                                    if (strtolower($fileExt) == 'pdf') {
                                        $iconName = 'document-pdf.png';
                                    }
                                    else {
                                        $iconName = 'image.png';
                                    }
                                }
                                $clr = "#5e6267";
                                if ($payment['pcp_pay_type'] == 'cashed') {
                                    $clr = "#090";
                                }
                                if ($payment['pcp_pay_type'] == 'paid') {
                                    $clr = "#c00";
                                }
                                if ($payment['pcp_pay_type'] == 'refunded') {
                                    $clr = "#FF6C00";
                                }
                                if ($payment['pcp_pay_type'] == 'paid') {
                                    $totalDue += $payment["pcp_amount"] * 1;
                                }
                                elseif ($payment['pcp_pay_type'] == 'cashed') {
                                    $totalCashed += $payment["pcp_amount"] * 1;
                                }

                                switch ($payment['pcp_currency']) {
                                    case "£":
                                        if ($payment['pcp_pay_type'] == 'paid') {
                                            $totalDueGBP += $payment["pcp_amount"] * 1;
                                        }
                                        elseif ($payment['pcp_pay_type'] == 'cashed') {
                                            $totalCashedGBP += $payment["pcp_amount"] * 1;
                                        }
                                        elseif ($payment['pcp_pay_type'] == 'refunded') {
                                            $totalRefundGBP += ($payment["pcp_amount"] * 1);
                                        }
                                        break;
                                    case "$":
                                        if ($payment['pcp_pay_type'] == 'paid') {
                                            $totalDueUSD += $payment["pcp_amount"] * 1;
                                        }
                                        elseif ($payment['pcp_pay_type'] == 'cashed') {
                                            $totalCashedUSD += $payment["pcp_amount"] * 1;
                                        }
                                        elseif ($payment['pcp_pay_type'] == 'refunded') {
                                            $totalRefundUSD += ($payment["pcp_amount"] * 1);
                                        }
                                        break;
                                    case "€":
                                        if ($payment['pcp_pay_type'] == 'paid') {
                                            $totalDueEUR += $payment["pcp_amount"] * 1;
                                        }
                                        elseif ($payment['pcp_pay_type'] == 'cashed') {
                                            $totalCashedEUR += $payment["pcp_amount"] * 1;
                                        }
                                        elseif ($payment['pcp_pay_type'] == 'refunded') {
                                            $totalRefundEUR += ($payment["pcp_amount"] * 1);
                                        }
                                        break;
                                }
                                ?>
                                <tr>
                                    <td><?php echo $cnt ?></td>
                                    <td><?php echo ucfirst($payment['pcp_book_id']) ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($payment['pcp_added_date'])) ?></td>
                                    <td style="text-align: right;">
                                        <div style="display: inline-block; white-space: nowrap;"> 
                                            <?php
                                            if ($payment['pcp_pay_type'] == 'paid') {
                                                echo number_format($payment['pcp_amount'], 2, ",", ".") . ' ' . $payment['pcp_currency'];
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td style="color:<?php echo $clr; ?>"><?php echo ucfirst($payment['pcp_pay_type']) ?></td>
                                    <td style="text-align: right;">
                                        <div style="display: inline-block; white-space: nowrap;">  
                                            <?php
                                            if ($payment['pcp_pay_type'] == 'cashed' || $payment['pcp_pay_type'] == 'refunded') {
                                                echo $payment['pcp_pay_type'] == 'cashed' ? number_format($payment['pcp_amount'], 2, ",", ".") . ' ' . $payment['pcp_currency'] : number_format(($payment['pcp_amount'] * -1), 2, ",", ".") . ' ' . $payment['pcp_currency'];
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td><?php echo $payment['pcp_service'] ?></td>
                                    <td><?php echo $payment['pcp_method'] ?></td>
                                    <td>
                                        <?php if( !empty($payment['pcp_document']) ) { ?>
                                            <a href="<?php echo PAYMENT_CM_DWNLD . $payment['pcp_document'] ?>" class="btn btn-xs btn-info min-wd-24 delPay" target="_blank">
                                                <span data-original-title="View" data-container="body" data-toggle="tooltip">
                                                    <i class="fa fa-file-pdf-o"></i>
                                                </span>
                                            </a>
                                        <?php } ?>
                                    </td>                                    
                                    <td>
                                    <?php if($this->session->userdata('role') == 200){ ?>
                                        <a href="javascript:void(0);" class="btn btn-xs btn-danger min-wd-24 delPay" data-id="delPay_<?php echo $payment['pcp_id'] ?>">
                                            <span data-original-title="Delete" data-container="body" data-toggle="tooltip">
                                                <i class="fa fa-trash"></i>
                                            </span>
                                        </a>
                                        <?php } ?>
                                    </td>                                    
                                </tr>
                                <?php
                                $cnt += 1;
                            }
                            ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td style="text-align: right; font-weight: bold">Total(GBP)</td>
                                <td style="text-align: right; font-weight: bold;">
                                    <div style="display: inline-block; white-space: nowrap;" id="tot1">  <?php echo number_format(($totalDueGBP), 2, ",", ".") . ' £' ?></div>
                                </td>
                                <td>&nbsp;</td>
                                <td style="text-align: right; font-weight: bold;">
                                    <div style="display: inline-block; white-space: nowrap;">  <?php echo number_format(($totalCashedGBP - $totalRefundGBP), 2, ",", ".") . ' £' ?></div>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td style="font-weight: bold;"><div style="display: inline-block; white-space: nowrap;" id="tot2">  <?php echo number_format((($totalCashedGBP - $totalRefundGBP) - $totalDueGBP), 2, ",", ".") . ' £' ?></div></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td style="text-align: right; font-weight: bold">Total(USD)</td>
                                <td style="text-align: right; font-weight: bold;">
                                    <div style="display: inline-block; white-space: nowrap;" id="tot1">  <?php echo number_format(($totalDueUSD), 2, ",", ".") . ' $' ?></div>
                                </td>
                                <td>&nbsp;</td>
                                <td style="text-align: right; font-weight: bold;">
                                    <div style="display: inline-block; white-space: nowrap;">  <?php echo number_format(($totalCashedUSD - $totalRefundUSD), 2, ",", ".") . ' $' ?></div>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td style="font-weight: bold;">
                                    <div style="display: inline-block; white-space: nowrap;" id="tot2">  <?php echo number_format((($totalCashedUSD - $totalRefundUSD) - $totalDueUSD), 2, ",", ".") . ' $' ?></div>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td style="text-align: right; font-weight: bold">Total(EUR)</td>
                                <td style="text-align: right; font-weight: bold;">
                                    <div style="display: inline-block; white-space: nowrap;" id="tot1">  <?php echo number_format(($totalDueEUR), 2, ",", ".") . ' €' ?></div>
                                </td>
                                <td>&nbsp;</td>
                                <td style="text-align: right; font-weight: bold;">
                                    <div style="display: inline-block; white-space: nowrap;">  <?php echo number_format(($totalCashedEUR - $totalRefundEUR), 2, ",", ".") . ' €' ?></div>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td style="font-weight: bold;">
                                    <div style="display: inline-block; white-space: nowrap;" id="tot2">  <?php echo number_format((($totalCashedEUR - $totalRefundEUR) - $totalDueEUR), 2, ",", ".") . ' €' ?>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Booking id</th>
                        <th>Operation date</th>
                        <th>Paid</th>
                        <th>Type</th>
                        <th>Cashed</th>
                        <th>Operation type</th>
                        <th>Payment method</th>
                        <th>Pictures/ Files</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
      </div>
    </div>
</section>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/additional-methods.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $( ".datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,         
        dateFormat: "dd/mm/yy",
        maxDate: "+1Y"
    }).datepicker("setDate", new Date()); 

    $("#addPaymentFinCM").validate({
      errorElement:"div",
      ignore: "",
      rules: {
        P_typePay: {
          required: true
        },
        P_curDate: {
          required: true
        },
        P_amount: {
          required: true,
          min: 1
        },
        P_currency: {
          required: true
        },
        P_operation: {
          required: true
        },
        P_method: {
          required: true
        },
        P_bookList:{
           required: true 
        }
      },
      messages: {
        P_typePay: {
          required: "Please select type"
        },
        P_curDate: {
          required: "Please select payment date"
        },
        P_amount: {
          required: "Please enter the amount/due",
          min: "Amount should be greater than zero"
        },
        P_currency: {
          required: "Please select currency"
        },
        P_operation: {
          required: "Please select service"
        },
        P_method: {
          required: "Please select method"
        },
        P_bookList: {
          required: "Please select booking id"
        }
      },
      submitHandler: function(form) {
        var c = confirm('Are you sure to add this payment?');
        if(c)
        {
            form.submit();            
        }
        else
        {
            return false;
        }
        
      }
    });

    $('body').on('click', '.delPay', function(){
        var selPay = $(this).attr('data-id').replace('delPay_','');
        if(selPay != '' && typeof selPay != 'undefined'){
            var c = confirm('Are you sure to delete this payment?');
            if(c){
                $.ajax({
                    url: siteUrl+'backoffice/deleteCmPayment',
                    type: 'POST',
                    data: {
                        selPay: selPay
                    },
                    success: function(data){
                        location.reload(true);
                    },
                    error: function(){
                        alert('Failed to delete payment');
                    }
                });
            }
        }
    });
});
</script>