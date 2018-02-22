<style type="text/css">
    #dialog_modal .btn, 
    #dialog_modal_tra .btn {
        margin-bottom: 5px;
        vertical-align: top;
    }
</style>

<div class="container-fluid">			
    <a href="#d" data-toggle="pill" class="btn btn-primary" style="margin-bottom: 10px; white-space: pre-wrap;"><span class="glyphicon glyphicon-calendar"></span> <?php echo $campusname ?>  <?php echo date("d/m/Y", strtotime($datein)) ?> to <?php echo date("d/m/Y", strtotime($dateout)) ?></a>

    <div class="panel panel-primary">				
        <div class="panel-body">
            <div style="width:100%; overflow-x: auto;">
                <div class="row-fluid">
                    <div class="col-12">
                        <?php
                        $dateArr = array();
                        foreach ($dates as $dataArr) {
                            $dateArr[] = strtotime($dataArr["start_date"]);
                        }
                        $contarighe = 1;
                        ?>

                        <div id="tabAvail_" class="collapse in">									
                            <table class="table table-bordered table-condensed table-striped tabAvail" style="font-size:10px;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <?php
                                        $datecycle = $datein;
                                        $cnttd = 0;
                                        while (strtotime($datecycle) <= strtotime($dateout)) {
                                            ?>
                                            <th width="4%"><span <?php if (strtotime($datecycle) == strtotime($datechoose)) { ?>class="text-danger"<?php } ?>><?php echo date("d/m", strtotime($datecycle)) ?></span></th>
                                            <?php
                                            $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                            if (isset($books[$cnttd]['booked'][0])) {
                                                !isset($books[$cnttd]['booked'][1]) ? $books[$cnttd]['booked'][1] = 0 : '';
                                                !isset($books[$cnttd]['booked'][2]) ? $books[$cnttd]['booked'][2] = 0 : '';
                                                !isset($books[$cnttd]['booked'][3]) ? $books[$cnttd]['booked'][3] = 0 : '';
                                            }
                                            $std_val = isset($books[$cnttd]['booked']['standard']) ? $books[$cnttd]['booked']['standard'] : 0;
                                            $ens_val = isset($books[$cnttd]['booked']['ensuite']) ? $books[$cnttd]['booked']['ensuite'] : 0;
                                            $hms_val = isset($books[$cnttd]['booked']['homestay']) ? $books[$cnttd]['booked']['homestay'] : 0;
                                            $twi_val = isset($books[$cnttd]['booked']['twin']) ? $books[$cnttd]['booked']['twin'] : 0;
                                            $octoday[$cnttd] = !empty($books[$cnttd]['booked']) ? $std_val + $ens_val + $hms_val + $twi_val : 0;
                                            $cnttd += 1;
                                        }
                                        ?>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td width="12%">In</td>
                                        <?php
                                        $datecycle = $datein;
                                        $cnttd = 0;
                                        while (strtotime($datecycle) <= strtotime($dateout)) {
                                            ?>
                                            <td width="4%">
                                                <?php if ($books[$cnttd]["num_in"] > 0) { ?><a href="javascript:void(0);" class="openDoorPaxList" id="od_<?php echo $books[$cnttd]["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/door-open-in_green.png"><span style="float:left;width:30px;text-align:center;"><?php echo $books[$cnttd]["num_in"] ?></span></a><?php } else { ?>&nbsp;<?php } ?>
                                            </td>
                                            <?php
                                            $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                            $cnttd += 1;
                                        }
                                        ?>												
                                    </tr>
                                    <tr>
                                        <td width="12%">Out</td>
                                        <?php
                                        $datecycle = $datein;
                                        $cnttd = 0;
                                        while (strtotime($datecycle) <= strtotime($dateout)) {
                                            ?>
                                            <td>
                                                <?php
                                                if ($books[$cnttd]["num_out"] > 0) {
                                                    ?>
                                                    <a href="javascript:void(0);" class="closeDoorPaxList" id="cd_<?php echo $books[$cnttd]["datat"] ?>">
                                                        <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/door-open-out_red.png">
                                                        <span style="float:left;width:30px;text-align:center;"><?php echo $books[$cnttd]["num_out"] ?></span>
                                                    </a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    &nbsp;
                                                <?php } ?>
                                            </td>
                                            <?php
                                            $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                            $cnttd += 1;
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td width="12%">Standard</td>
                                        <?php
                                        $datecycle = $datein;
                                        $cnttd = 0;
                                        while (strtotime($datecycle) <= strtotime($dateout)) {
                                            ?>
                                            <td><?php
                                                if (isset($books[$cnttd]['booked']['standard'])) {
                                                    if ($books[$cnttd]['booked']['standard'] > 0) {
                                                        ?><a title="<?php echo date("d/m/Y", strtotime($books[$cnttd]["datat"])) ?> - Standard" class="openDayDetail" id ="opendetail_<?php echo $books[$cnttd]["datat"] ?>_1" href="javascript:void(0);"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/user-medium.png"><span style="float:left;width:30px;text-align:center;"><?php echo $books[$cnttd]['booked']['standard'] ?></span></a><?php
                                                    } else {
                                                        ?>&nbsp;<?php
                                                        }
                                                    }
                                                    ?></td>
                                            <?php
                                            $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                            $cnttd += 1;
                                        }
                                        ?>										

                                    </tr>
                                    <tr>
                                        <td width="12%">Ensuite</td>
                                        <?php
                                        $datecycle = $datein;
                                        $cnttd = 0;
                                        while (strtotime($datecycle) <= strtotime($dateout)) {
                                            ?>
                                            <td><?php
                                                if (isset($books[$cnttd]['booked']['ensuite'])) {
                                                    if ($books[$cnttd]['booked']['ensuite'] > 0) {
                                                        ?><a title="<?php echo date("d/m/Y", strtotime($books[$cnttd]["datat"])) ?> - Ensuite" class="openDayDetail" id ="opendetail_<?php echo $books[$cnttd]["datat"] ?>_2" href="javascript:void(0);"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/user-share.png"><span style="float:left;width:30px;text-align:center;"><?php echo $books[$cnttd]['booked']['ensuite'] ?></span></a><?php
                                                    } else {
                                                        ?>&nbsp;<?php
                                                        }
                                                    }
                                                    ?></td>
                                            <?php
                                            $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                            $cnttd += 1;
                                        }
                                        ?>											

                                    </tr>
                                    <tr>
                                        <td width="12%">Homestay</td>
                                        <?php
                                        $datecycle = $datein;
                                        $cnttd = 0;
                                        while (strtotime($datecycle) <= strtotime($dateout)) {
                                            ?>
                                            <td><?php
                                                if (isset($books[$cnttd]['booked']['homestay'])) {
                                                    if ($books[$cnttd]['booked']['homestay'] > 0) {
                                                        ?><a title="<?php echo date("d/m/Y", strtotime($books[$cnttd]["datat"])) ?> - Homestay" class="openDayDetail" id ="opendetail_<?php echo $books[$cnttd]["datat"] ?>_3" href="javascript:void(0);"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/home-medium.png"><span style="float:left;width:30px;text-align:center;"><?php echo $books[$cnttd]['booked']['homestay'] ?></span></a><?php
                                                    } else {
                                                        ?>&nbsp;<?php
                                                        }
                                                    }
                                                    ?></td>
                                            <?php
                                            $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                            $cnttd += 1;
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td width="12%">Twin</td>
                                        <?php
                                        $datecycle = $datein;
                                        $cnttd = 0;
                                        while (strtotime($datecycle) <= strtotime($dateout)) {
                                            ?>
                                            <td><?php
                                                if (isset($books[$cnttd]['booked']['twin'])) {
                                                    if ($books[$cnttd]['booked']['twin'] > 0) {
                                                        ?><a title="<?php echo date("d/m/Y", strtotime($books[$cnttd]["datat"])) ?> - Twin" class="openDayDetail" id ="opendetail_<?php echo $books[$cnttd]["datat"] ?>_4" href="javascript:void(0);"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/users.png"><span style="float:left;width:30px;text-align:center;"><?php echo $books[$cnttd]['booked']['twin'] ?></span></a><?php
                                                    } else {
                                                        ?>&nbsp;<?php
                                                        }
                                                    }
                                                    ?></td>
                                            <?php
                                            $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                            $cnttd += 1;
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td width="12%">Transfers</td>
                                        <?php
                                        $datecycle = $datein;
                                        $cnttd = 0;
                                        while (strtotime($datecycle) <= strtotime($dateout)) {
                                            ?>
                                            <td><?php if ($num_transfers[$cnttd] > 0) { ?><a href="javascript:void(0);" class="TransfersPaxList" id="tra_<?php echo $books[$cnttd]["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/transfer_plane.png"><span style="float:left;width:30px;text-align:center;"><?php echo $num_transfers[$cnttd] ?></span></a><?php
                                                } else {
                                                    ?>&nbsp;<?php } ?></td>
                                                <?php
                                                $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                                $cnttd += 1;
                                            }
                                            ?>
                                    </tr>
                                    <tr>
                                        <td width="12%">Planned</td>
                                        <?php
                                        $datecycle = $datein;
                                        $cnttd = 0;
                                        while (strtotime($datecycle) <= strtotime($dateout)) {
                                            ?>
                                            <td><?php if ($num_excursions[$cnttd] > 0) { ?><a href="javascript:void(0);" class="ExcursionsPaxList" id="exc_<?php echo $books[$cnttd]["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/bus_excursion.png"><span style="float:left;width:30px;text-align:center;"><?php echo $num_excursions[$cnttd] ?></span></a><?php
                                                } else {
                                                    ?>&nbsp;<?php } ?></td>
                                                <?php
                                                $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                                $cnttd += 1;
                                            }
                                            ?>
                                    </tr>
                                    <tr>
                                        <td width="12%">Extra</td>
                                        <?php
                                        $datecycle = $datein;
                                        $cnttd = 0;
                                        while (strtotime($datecycle) <= strtotime($dateout)) {
                                            ?>
                                            <td><?php if ($num_extra_excursions[$cnttd] > 0) { ?><a href="javascript:void(0);" class="ExtraExcursionsPaxList" id="excExtra_<?php echo $books[$cnttd]["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/bus_excursion.png"><span style="float:left;width:30px;text-align:center;"><?php echo $num_extra_excursions[$cnttd] ?></span></a><?php
                                                } else {
                                                    ?>&nbsp;<?php } ?></td>
                                                <?php
                                                $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                                $cnttd += 1;
                                            }
                                            ?>
                                    </tr>
                                    <tr>
                                        <td width="12%">On campus today</td>
                                        <?php
                                        $datecycle = $datein;
                                        $cnttd = 0;
                                        while (strtotime($datecycle) <= strtotime($dateout)) {
                                            ?>
                                            <td><?php if ($octoday[$cnttd] > 0) { ?><a style="padding:0 5px;" href="javascript:void(0);" class="allPaxList " title="View students list" id="od_<?php echo $books[$cnttd]["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/edit-list-order.png"></a><a style="padding:0 5px; "href="javascript:void(0);" class="allBookList " title="View bookings list" id="od_<?php echo $books[$cnttd]["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/applications-stack.png"></a><span style="float:left;width:30px;text-align:center;"><?php echo $octoday[$cnttd] ?></span><?php
                                                } else {
                                                    ?>&nbsp;<?php } ?></td>
                                                        <?php
                                                        $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                                        $cnttd += 1;
                                                    }
                                                    ?>

                                    </tr>
                                    <?php if (isset($bursarLogin)) { ?>
                                        <tr>
                                            <td width="12%">Active</td>
                                            <?php
                                            $datecycle = $datein;
                                            $cnt = 0;
                                            while (strtotime($datecycle) <= strtotime($dateout)) {
                                                if (isset($activeBookings[$cnt])) {
                                                    ?>
                                                    <td><?php if ($activeBookings[$cnt] > 0) {
                                                        ?>
                                                            <a title="View Active Booking List" class="getBookingsForActive" href="javascript:void(0);" data-date="<?php echo $datecycle; ?>">
                                                                <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/applications-stack.png"><span style="float:left;width:30px;text-align:center;"><?php echo $activeBookings[$cnt]; ?></span></a>
                                                        <?php } else {
                                                            ?>&nbsp;<?php } ?></td>
                                                        <?php
                                                        $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                                        $cnt += 1;
                                                    }
                                                }
                                                ?>

                                        </tr>
                                        <?php
                                    }
//Review rule by selecting distinct campus id on plused_book_overnight table
                                    if ($campus == 3 or $campus == 54) {
                                        ?>

                                        <tr>
                                            <td colspan="32" style="border: 2px solid #000;background-color: #000;height: auto !important;padding: 4px;color: #fff;">
                                                OVERNIGHTS
                                            </td>
                                        </tr>

                                        <?php
                                        foreach ($simbookingOvernights[0] as $book) {
                                            //echo "<br />->".$book["arrival_date"]."--->".$book["departure_date"];
                                            $da = explode("-", $book["arrival_date"]);
                                            $dd = explode("-", $book["departure_date"]);
                                            switch ($book["status"]) {
                                                case "confirmed":
                                                    $statusBTS = "success";
                                                    break;
                                                case "active":
                                                    $statusBTS = "warning";
                                                    break;
                                                case "tbc":
                                                    $statusBTS = "info";
                                                    break;
                                                case "elapsed":
                                                    $statusBTS = "danger";
                                                    break;
                                            }
                                            ?>
                                            <tr id="riga_<?php echo $contarighe ?>" class="overnight">
                                                <td width="12%" class="n_<?php echo $book["status"] ?> text-center" style="border:1px solid #000;height: auto !important;"><img style="margin-top:-1px;" class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"] ?>.png" alt="<?php echo $book["businesscountry"] ?>" title="<?php echo $book["businesscountry"] ?>" /> <?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?></span></td>
                                                <?php
                                                //echo $datein."-->";
                                                $datecycle = date("Y-m-d", strtotime("+0 day", strtotime($datein)));
                                                //$datecycle = $datein;
                                                while (strtotime($datecycle) <= strtotime($dateout)) {
                                                    $datecycle = $datecycle . " 00:00:00";
                                                    //echo $datecycle."---".$book["arrival_date"]."---".$book["departure_date"];
                                                    //sostituito <= con < nell'if successivo per liberare i posti oncampus il giorno della partenza!
                                                    if ($datecycle >= $book["arrival_date"] and $datecycle < $book["departure_date"]) {
                                                        //echo "-Numero<br>";
                                                        ?>
                                                        <td width="4%" style="height: auto !important;" class="text-center <?php echo $statusBTS ?>" title="<?php echo $book["contaPieni"] ?>"><input class="contapax nobbg" type="text" readonly value="<?php echo $book["num_in"] ?>"></td>
                                                        <?php
                                                    } else {
                                                        //echo "-Zero<br>";
                                                        ?>
                                                        <td width="4%" style="height: auto !important;" class="text-center" title="<?php echo $book["contaPieni"] ?>"><input class="contapax nobbg"  type="text" readonly value="0"></td>
                                                        <?php
                                                    }
                                                    $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                                }
                                                ?>
                                            </tr>
                                            <?php
                                            $contarighe++;
                                        }
                                        ?>

                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="dialog_modal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel">
    <div class="modal-dialog" role="document" style="width:90%;">
        <div class="modal-content" style="padding: 15px;">
            <div class="modal-header">
                <button type="button" class="close close_dialog_modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="pdfModalLabel">Pax List | Booking detail  (Please set orientation to LANDSCAPE before print!)</h4>
            </div>
            <div id="modal_body" class="modal-body" style="overflow: auto;height: 500px;"></div>
            <div class="modal-footer" style="padding: 15px 0;">
                <button type="button" class="btn btn-default close_dialog_modal">Close</button>
                <button type="button" class="btn btn-primary" id="print_dialog_modal">Print</button>
                <button type="button" class="btn btn-primary" id="export_dialog_modal">Export as Excel file</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dialog_modal_tra" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel">
    <div class="modal-dialog" role="document" style="width:90%;">
        <div class="modal-content" style="padding: 15px;">
            <div class="modal-header">
                <button type="button" class="close close_dialog_modal_tra" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="pdfModalLabel">Transfers | Bus codes details</h4>
            </div>
            <div id="modal_tra_body" class="modal-body" style="overflow: auto;height: 500px;"></div>
            <div class="modal-footer" style="padding: 15px 0;">
                <button type="button" class="btn btn-default close_dialog_modal_tra">Close</button>
                <button type="button" class="btn btn-primary" id="print_dialog_modal_tra">Print</button>
                <button type="button" class="btn btn-primary" id="export_dialog_modal_tra">Export as Excel file</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dialog_modal_exc" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel">
    <div class="modal-dialog" role="document" style="width:90%;">
        <div class="modal-content" style="padding: 15px;">
            <div class="modal-header">
                <button type="button" class="close close_dialog_modal_exc" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="pdfModalLabel">Planned Excursions | Bus codes details</h4>
            </div>
            <div id="modal_exc_body" class="modal-body" style="overflow: auto;height: 500px;"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close_dialog_modal_exc">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dialog_modal_exc_extra" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel">
    <div class="modal-dialog" role="document" style="width:90%;">
        <div class="modal-content" style="padding: 15px;">
            <div class="modal-header">
                <button type="button" class="close close_dialog_modal_exc_extra" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="pdfModalLabel">Extra Excursions | Bus codes details</h4>
            </div>
            <div id="modal_exc_extra_body" class="modal-body" style="overflow: auto;height: 500px;"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close_dialog_modal_exc_extra">Close</button>
            </div>
        </div>
    </div>
</div>
<?php if (isset($bursarLogin)) { ?>
    <div class="modal fade" id="booking_modal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel">
        <div class="modal-dialog" role="document" style="width:90%;">
            <div class="modal-content" style="padding: 15px;">
                <div class="modal-header">
                    <button type="button" class="close close_booking_modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="bookingModalLabel"></h4>
                </div>
                <div id="modal_body_booking" class="modal-body" style="overflow: auto;height: 500px;"></div>
                <div class="modal-footer" style="padding: 15px 0;">
                    <button type="button" class="btn btn-default close_booking_modal">Close</button>
                    <button type="button" class="btn btn-primary" id="print_booking_modal">Print</button>
                    <button type="button" class="btn btn-primary" id="export_booking_modal">Export as Excel file</button>
                    <input type="hidden" id="selDate" />
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function () {

        $(".openDoorPaxList").click(function () {
            window.parent.$("#hidDate").val('');
            window.parent.$("#accoForCsv").val('all');
            window.parent.$("#typeForCsv").val('arrival');
            window.parent.$("#accoForChList").val('');
            window.parent.$("#accoForBook").val('');
            window.parent.$("#transDate").val('');
            var bytd = $(this).attr("id");
            var splitbytd = bytd.split("_");
            var bydate = splitbytd[1];
            window.parent.$("#hidDate").val(bydate);

            $.post("<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/all/" + bydate + "/confirmed/arrival", function (data) {
                $("#modal_body").html('');
                $("#dialog_modal").modal("show");
                $("#modal_body").html(data);
            });
        });

        $(".close_dialog_modal").click(function () {
            $('#dialog_modal').modal('toggle');
            $('#dialog_modal').on('hidden.bs.modal', function (e) {
                if ($(".modal.in").length)
                    $("body").addClass("modal-open");
            });
        });

        $("#print_dialog_modal").click(function () {            
            $('#dialog_modal .table').printElement();
        });

        $("#print_booking_modal").click(function () {
            $('#booking_modal .table').printElement();
        });

        $("#export_dialog_modal").click(function () {
            var myHidDate = window.parent.$("#hidDate").val().replace(/\-/g, '');
            var myTypeForCsv = window.parent.$("#typeForCsv").val();
            var myAccoForCsv = window.parent.$("#accoForCsv").val();
            var myAccoForChList = window.parent.$("#accoForChList").val();
            var myAccoForBook = window.parent.$("#accoForBook").val();
            if (myTypeForCsv == '') {
                myTypeForCsv = 'null';
            }
            if (myAccoForChList == '') {
                myAccoForChList = 'null';
            }
            window.location.href = '<?php echo base_url(); ?>index.php/backoffice/csvArrivalPax_pax/<?php echo $campus ?>/' + myAccoForCsv + '/' + myHidDate + '/confirmed/' + myTypeForCsv + '/' + myAccoForChList + '/' + myAccoForBook;
        });

        $("#export_booking_modal").click(function () {
            var date = $('#selDate').val();
            window.open('<?php echo base_url(); ?>index.php/backoffice/csvActiveBookingDate/' + date, '_blank');
        });

        $(".closeDoorPaxList").click(function () {
            window.parent.$("#hidDate").val('');
            window.parent.$("#accoForCsv").val('all');
            window.parent.$("#typeForCsv").val('departure');
            window.parent.$("#accoForChList").val('');
            window.parent.$("#accoForBook").val('');
            window.parent.$("#transDate").val('');
            var bytd = $(this).attr("id");
            var splitbytd = bytd.split("_");
            var bydate = splitbytd[1];
            window.parent.$("#hidDate").val(bydate);

            $.post("<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/all/" + bydate + "/confirmed/departure", function (data) {
                $("#modal_body").html('');
                $("#dialog_modal").modal("show");
                $("#modal_body").html(data);
            });
        });

        $(".openDayDetail").click(function () {
            window.parent.$("#hidDate").val('');
            window.parent.$("#accoForCsv").val('all');
            window.parent.$("#typeForCsv").val('');
            window.parent.$("#accoForChList").val('');
            window.parent.$("#transDate").val('');
            var bytd = $(this).attr("id");
            var splitbytd = bytd.split("_");
            var bydate = splitbytd[1];
            window.parent.$("#hidDate").val(bydate);
            var byacco = splitbytd[2];
            window.parent.$("#accoForCsv").val(byacco);

            $.post("<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/" + splitbytd[2] + "/" + bydate + "/confirmed/", function (data) {
                $("#modal_body").html('');
                $("#dialog_modal").modal("show");
                $("#modal_body").html(data);
            });
        });

        $(".allPaxList").click(function () {
            window.parent.$("#hidDate").val('');
            window.parent.$("#typeForCsv").val('');
            window.parent.$("#accoForCsv").val('');
            window.parent.$("#accoForChList").val('all');
            window.parent.$("#accoForBook").val('');
            window.parent.$("#transDate").val('');
            var bytd = $(this).attr("id");
            var splitbytd = bytd.split("_");
            var bydate = splitbytd[1];
            window.parent.$("#hidDate").val(bydate);
            window.parent.$("#accoForCsv").val('all');

            $.post("<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/all/" + bydate + "/confirmed/null/null/all_list", function (data) {
                $("#modal_body").html('');
                $("#dialog_modal").modal("show");
                $("#modal_body").html(data);
            });
        });

        $(".TransfersPaxList").click(function () {
            window.parent.$("#hidDate").val('');
            window.parent.$("#typeForCsv").val('');
            window.parent.$("#accoForCsv").val('');
            window.parent.$("#accoForChList").val('');
            window.parent.$("#accoForBook").val('');
            var bytd = $(this).attr("id");
            var splitbytd = bytd.split("_");
            var bydate = splitbytd[1];
            window.parent.$("#transDate").val(bydate);

            $.post("<?php echo base_url(); ?>index.php/backoffice/ca_getTransfersBusCodesForDay/" + bydate, function (data) {
                $("#modal_tra_body").html('');
                $("#dialog_modal_tra").modal("show");
                $("#modal_tra_body").html(data);
            });
        });

        $(".close_dialog_modal_tra").click(function () {
            $('#dialog_modal_tra').modal('toggle');
            $('#dialog_modal_tra').on('hidden.bs.modal', function (e) {
                if ($(".modal.in").length)
                    $("body").addClass("modal-open");
            });
        });

        $("#print_dialog_modal_tra").click(function () {
            $('#dialog_modal_tra #printDiv').printElement();
        });

        $("#export_dialog_modal_tra").click(function () {
            var myTransDate = window.parent.$("#transDate").val();
            window.location.href = '<?php echo base_url(); ?>index.php/backoffice/csvTrasferBus_pax/<?php echo $campus ?>/' + myTransDate;
        });

        $(".ExcursionsPaxList").click(function () {
            window.parent.$("#hidDate").val('');
            window.parent.$("#typeForCsv").val('');
            window.parent.$("#accoForCsv").val('');
            window.parent.$("#accoForChList").val('');
            window.parent.$("#accoForBook").val('');
            window.parent.$("#transDate").val('');
            var bytd = $(this).attr("id");
            var splitbytd = bytd.split("_");
            var bydate = splitbytd[1];

            $.post("<?php echo base_url(); ?>index.php/backoffice/ca_getExcursionsBusCodesForDay/" + bydate, function (data) {
                $("#modal_exc_body").html('');
                $("#dialog_modal_exc").modal("show");
                $("#modal_exc_body").html(data);
            });
        });

        $(".close_dialog_modal_exc").click(function () {
            $('#dialog_modal_exc').modal('toggle');
            $('#dialog_modal_exc').on('hidden.bs.modal', function (e) {
                if ($(".modal.in").length)
                    $("body").addClass("modal-open");
            });
        });
        $(".close_booking_modal").click(function () {
            $('#booking_modal').modal('toggle');
            $('#booking_modal').on('hidden.bs.modal', function (e) {
                if ($(".modal.in").length)
                    $("body").addClass("modal-open");
            });
        });

        $(".ExtraExcursionsPaxList").click(function () {
            window.parent.$("#hidDate").val('');
            window.parent.$("#typeForCsv").val('');
            window.parent.$("#accoForCsv").val('');
            window.parent.$("#accoForChList").val('');
            window.parent.$("#accoForBook").val('');
            window.parent.$("#transDate").val('');
            var bytd = $(this).attr("id");
            var splitbytd = bytd.split("_");
            var bydate = splitbytd[1];

            $.post("<?php echo base_url(); ?>index.php/backoffice/ca_getExtraExcursionsBusCodesForDay/" + bydate, function (data) {
                $("#modal_exc_extra_body").html('');
                $("#dialog_modal_exc_extra").modal("show");
                $("#modal_exc_extra_body").html(data);
            });
        });

        $(".close_dialog_modal_exc_extra").click(function () {
            $('#dialog_modal_exc_extra').modal('toggle');
            $('#dialog_modal_exc_extra').on('hidden.bs.modal', function (e) {
                if ($(".modal.in").length)
                    $("body").addClass("modal-open");
            });
        });

        $(".allBookList").click(function () {
            window.parent.$("#hidDate").val('');
            window.parent.$("#typeForCsv").val('');
            window.parent.$("#accoForCsv").val('');
            window.parent.$("#accoForChList").val('all');
            window.parent.$("#accoForBook").val('all');
            window.parent.$("#transDate").val('');
            var bytd = $(this).attr("id");
            var splitbytd = bytd.split("_");
            var bydate = splitbytd[1];
            window.parent.$("#hidDate").val(bydate);
            window.parent.$("#accoForCsv").val('all');

            $.post('<?php echo base_url(); ?>index.php/backoffice/infoday2day/<?php echo $campus ?>/all/' + bydate + '/confirmed', function (data) {
                $("#modal_body").html('');
                $("#dialog_modal").modal("show");
                $("#modal_body").html(data);

                if ($.trim($("#campusd2d tbody").html()) == "")
                {
                    $("#campusd2d tbody").html("No records are available");
                    $("#print_dialog_modal").hide();
                    $("#export_dialog_modal").hide();
                } else
                {
                    $("#print_dialog_modal").show();
                    $("#export_dialog_modal").show();
                }
            });
        });

        $(".getBookingsForActive").click(function () {
            var date = $(this).attr("data-date");
            $('#selDate').val(date);

            $.post('<?php echo base_url(); ?>index.php/backoffice/getActiveBookingForDate', {date: date}, function (data) {
                $("#modal_body_booking").html('');
                $("#booking_modal").modal("show");
                $("#modal_body_booking").html(data);
                $('#bookingModalLabel').html('Booking Information ' + date + ' (Active)');

                if ($.trim($("#campusd2d tbody").html()) == "")
                {
                    $("#campusd2d tbody").html("No records are available");
                    $("#print_booking_modal").hide();
                    $("#export_booking_modal").hide();
                } else
                {
                    $("#print_booking_modal").show();
                    $("#export_booking_modal").show();
                }
            });
        });


    });

</script>