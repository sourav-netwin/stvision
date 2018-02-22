<style type="text/css">
    .ui-widget-content {
        max-height: none !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs booking-details-nav">
                <li class="<?php echo $pill == 'a' ? 'active' : '' ?>"><a href="#a" data-toggle="tab"><i class="fa fa-search"></i>&nbsp;Booking details</a></li>
                <li class="<?php echo $pill == 'b' ? 'active' : '' ?>"><a href="#b" data-toggle="tab"><i class="fa fa-user"></i>&nbsp;Roster</a></li>
                <li class="<?php echo $pill == 'c' ? 'active' : '' ?>"><a href="#c" data-toggle="tab"><i class="fa fa-random"></i>&nbsp;Transfer and excursions</a></li>
                <li class="<?php echo $pill == 'd' ? 'active' : '' ?>"><a href="#d" data-toggle="tab"><i class="fa fa-calendar"></i>&nbsp;Calendar view</a></li>
                <li class="<?php echo $pill == 'e' ? 'active' : '' ?>"><a href="#e" data-toggle="tab"><i class="fa fa-inbox"></i>&nbsp;Documents</a></li>
                <li class="<?php echo $pill == 'f' ? 'active' : '' ?>"><a href="#f" data-toggle="tab"><i class="fa fa-credit-card"></i>&nbsp;Payments</a></li>
            </ul>
            <a id="backToList" class="btn btn-primary booking-details-back">
                <span class="glyphicon glyphicon-chevron-left"></span> Back
            </a>
            <?php
            $isFlocked = 0;
            $date_in = $book[0]["arrival_date"];
            $date_out = $book[0]["departure_date"];
            $da = explode("-", $book[0]["arrival_date"]);
            $dd = explode("-", $book[0]["departure_date"]);
            $maxNoLmDate = date("d/m/Y", strtotime($book[0]["arrival_date"]) - (24 * 3600 * 30));
            $maxLmDate = date("d/m/Y", strtotime($book[0]["arrival_date"]) - (24 * 3600 * 1));
            //echo $maxNoLmDate;
            $storeId = $book[0]["id_book"];
            $yearId = $book[0]["id_year"];
            $accos = $book[0]["all_acco"];
            $now = time();
            $your_date = strtotime($book[0]["arrival_date"]);
            $dayToArrive = round(($now - $your_date) / 86400 * -1);
            $valutaCampo = $book[0]["valuta"];
            $valoreAcconto = $book[0]["tot_pax"] * 1 * $book[0]["valore_acconto"] * 1;
            $week = $book[0]['weeks'];
            ?>
            <input type="hidden" id="bkDetBookId" value="<?php echo $storeId ?>" />
            <input type="hidden" id="maxNoLmDate" value="<?php echo $maxNoLmDate ?>" />
            <input type="hidden" id="maxLmDate" value="<?php echo $maxLmDate ?>" />
            <input type="hidden" id="yearId" value="<?php echo $yearId ?>" />
            <input type="hidden" id="bookingStatus" value="<?php echo $book[0]["status"] ?>" />
            <input type="hidden" id="bookingWeeks" value="<?php echo $book[0]["weeks"] ?>" />
            <input type="hidden" id="mainfamilyname" value="<?php echo $this->session->userdata('mainfamilyname') ?>" />
            <div class="tab-content">
                <div class="tab-pane <?php echo $pill == 'a' ? 'active' : '' ?>" id="a">
                    <div class="box">
                        <div class="box-header with-border box-header-small">
                            <h3 class="box-title">Booking details - <strong><?php echo $yearId; ?>_<?php echo $storeId; ?></strong></h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <address>
                                        <strong><?php echo $book[0]["id_year"] ?>_<?php echo $book[0]["id_book"] ?><?php if ($book[0]["id_ref_overnight"]) { ?> - <span style="color:#f00;">OVERNIGHT (<?php echo $book[0]["id_ref_overnight"] ?>)</span><?php } ?></strong><br>
                                        <?php echo $book[0]["centro"] ?> - [<?php echo $dayToArrive ?> days to arrival]<br>
                                        <strong>Date in: </strong><span id="ok_A_Date"><?php echo $da[2] ?>/<?php echo $da[1] ?>/<?php echo $da[0] ?></span>
                                        <span data-toggle="tooltip" data-original-title="Edit date">
                                            <a href="javascript:void(0);" class="btn btn-xs btn-primary min-wd-20" data-toggle="modal" data-target="#dateEditModal">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </span>
                                        <br>
                                        <strong>Date out: </strong><span id="ok_D_Date"><?php echo $dd[2] ?>/<?php echo $dd[1] ?>/<?php echo $dd[0] ?></span>
                                        <span data-toggle="tooltip" data-original-title="Edit date">
                                            <a href="javascript:void(0);" class="btn btn-xs btn-primary min-wd-20" data-toggle="modal" data-target="#dateEditModal">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </span>
                                        <br>
                                        <strong>Weeks: </strong><span id="week_field" style="padding-right: 2%;"><?php echo $book[0]['weeks']; ?></span>
                                        <span data-toggle="tooltip" data-original-title="Edit week" id="edit_week_tooltip">
                                            <a href="javascript:void(0);" class="btn btn-xs btn-primary min-wd-20" id="open_edit_week" data-toggle="modal" data-target="#weekEditModal">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </span>
                                        <br/>
                                        <?php if(isset($all_glstd_count[0])){?>
                                        <strong>GL: </strong><span style="padding-right: 2%;"><?php echo $all_glstd_count[0]->contoGL; ?></span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>STD: </strong><span style="padding-right: 2%;"><?php echo $all_glstd_count[0]->contoSTD; ?></span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Total pax: </strong><span style="padding-right: 2%;"><?php echo $all_glstd_count[0]->contot; ?></span>
                                        <?php }else{?>
                                        <strong>GL: </strong><span style="padding-right: 2%;"> - </span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>STD: </strong><span  style="padding-right: 2%;"> - </span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Total pax: </strong><span style="padding-right: 2%;"> - </span>
                                        <?php }?>
                                        
                                        <br>
                                        <abbr title="Phone">P:</abbr> <?php echo $agente[0]["businesstelephone"] ?>
                                    </address>
                                </div>
                                <div class="col-md-3">
                                    <address>
                                        <strong><img style="margin-top:-1px;" class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $agente[0]["businesscountry"] ?>.png" alt="<?php echo $agente[0]["businesscountry"] ?>" title="<?php echo $agente[0]["businesscountry"] ?>" />&nbsp;<?php echo $agente[0]["businessname"] ?></strong><br>
                                        <?php echo $agente[0]["businessaddress"] ?><br>
                                        <?php echo $agente[0]["businesscity"] ?>, <?php echo $agente[0]["businesscountry"] ?><br>
                                        <abbr title="Phone">P:</abbr> <?php echo $agente[0]["businesstelephone"] ?>
                                    </address>
                                </div>
                                <div class="col-md-3">
                                    <address>
                                        <strong><?php echo $agente[0]["mainfirstname"] ?> <?php echo $agente[0]["mainfamilyname"] ?></strong><br>
                                        <a href="mailto:<?php echo $agente[0]["email"] ?>"><?php echo $agente[0]["email"] ?></a>
                                    </address>
                                </div>
                                <div class="col-md-3">
                                    <address>
                                        <strong>Rosters and Visas</strong><ul class="listaInBk">
                                            <?php
                                            if ($hasRoster > 0) {
                                                if ($book[0]["lockPax"] == 1) {
                                                    $isFlocked = 1;
                                                    echo "<li>Roster Locked - <a href='javascript:void(0);' class='unlockBookingRoster'>Click here</a> to unlock roster for this booking</li>";
                                                } else {
                                                    echo "<li>Roster in progress</li>";
                                                }
                                            } else {
                                                echo "<li>No roster available</li>";
                                            }

                                            //if($book[0]["lockPax"] == 1){
                                            if ($book[0]["downloadVisa"] == 1) {
                                                echo "<li>Visa available and printable by the agent";
                                            } else {
                                                echo "<li>Visa available and not printable by the agent";
                                            }
                                            ?>
                                            - <a id="printVisaPax" data-book="<?php echo $storeId ?>" target="_blank" href="javascript:void(0)" data-href="<?php echo site_url() ?>/backoffice/pdf_visas/<?php echo $storeId ?>">Click here</a> to print Visas for this booking</li>
                                            <?php
                                            //}else{
                                            //	echo "<li>Visas not available. Need locked roster</li>";
                                            //}
                                            ?>
                                        </ul>
                                    </address>
                                </div>
                                <?php if ($book[0]["id_agente"] == 795) { ?>
                                    <div class="col-md-12" id="overnightBox">
                                        <hr />
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info">Study Tours overnight settings</label>
                                                <select class="form-control" id="periodOvernight" name="periodOvernight">
                                                    <option value="">Select overnight period</option>
                                                    <option value="start">Before campus</option>
                                                    <option value="end">After campus</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info">&nbsp;</label>
                                                <select class="form-control" id="durationOvernight" name="durationOvernight">
                                                    <option value="">Select overnight duration</option>
                                                    <option value="1">One night overnight</option>
                                                    <option value="2">Two nights overnight</option>
                                                    <option value="3">Three nights overnight</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info">&nbsp;</label>
                                                <select class="form-control" id="campusOvernight" name="campusOvernight">
                                                    <option value="">Select overnight campus</option>
                                                    <?php foreach ($centri as $c) { ?>
                                                        <option value="<?php echo $c["id"]; ?>"><?php echo $c["nome_centri"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 text-right">
                                                <button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_setOvernight" >Set overnight</button>
                                            </div>
                                        </div>
                                        <hr />
                                    </div>
                                <?php } ?>
                                <div class="col-md-12">
                                    <div class="row">
                                        <?php if ($book[0]["status"] == "tbc") { ?>
                                            <div class="col-md-4">
                                                <label class="text-info">To be confirmed</label>
                                                <select class="form-control" id="statusBooking">
                                                    <option value="B_activate">Activate booking</option>
                                                    <option value="B_reject">Reject booking</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="lm_flag">Last minute</label><br />
                                                <input type="checkbox" id="lm_flag" style="height:25px;" value="1" />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="B_active">Activate until</label><br />
                                                <input class="form-control datepicker" type="text" id="B_active" value="<?php echo $dayToArrive < 30 ? $maxLmDate : $maxNoLmDate; ?>" />
                                            </div>
                                            <div class="col-md-3 text-right">
                                                <button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_cambiaStato" >Change status</button>
                                            </div>
                                        <?php } ?>
                                        <?php if ($book[0]["status"] == "rejected") { ?>
                                            <div class="col-md-12">
                                                <label style="color:#c00;">Rejected</label>
                                            </div>
                                        <?php } ?>
                                        <?php if ($book[0]["status"] == "active") { ?>
                                            <div class="col-md-4">
                                                <label style="color:#fc0;">Active</label> Until <?php echo date("d/m/Y", strtotime($book[0]["data_scadenza"])); ?>
                                                <select class="form-control" id="statusBookingFinCon">
                                                    <?php if ($this->session->userdata('ruolo') == "contabile") { ?>
                                                        <option value="B_confirm">Confirm booking</option>
                                                    <?php } ?>
                                                    <option value="B_reject">Reject booking</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_confermaBooking" >Change status</button>
                                            </div>
                                        <?php } ?>
                                        <?php if ($book[0]["status"] == "elapsed") { ?>
                                            <?php if ($this->session->userdata('ruolo') == "contabile") { ?>
                                                <?php if ($book[0]["flag_paid"] == 0) { ?>
                                                    <div class="col-md-6">
                                                        <label class="text-danger">Elapsed</label><br />
                                                        <?php if ($book[0]["flag_checkpay"] == 1) { ?>
                                                            A check payment notification is pending for this booking!
                                                        <?php } ?><br />
                                                        <select class="form-control" id="statusPaymentFinCon">
                                                            <option value="B_paid">Booking paid</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <br /><button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_notificaPayment" >Notify payment to backoffice</button>
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="col-md-10">
                                                        <label class="text-danger">Elapsed</label>
                                                        <br />A payment for this booking has already been notified to backoffice!
                                                    </div>
                                                <?php } ?>
                                                <?php
                                            } else {
                                                ?>
                                                <?php if ($book[0]["flag_paid"] == 1) { ?>
                                                    <div class="col-md-4">
                                                        <label class="text-danger">Elapsed</label><br />A payment for this booking has been registered!
                                                        <select class="form-control" id="statusBooking">
                                                            <option value="B_confirm">Confirm booking</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 text-right">
                                                        <br /><button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_cambiaStato" >Change status</button>
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <?php if ($book[0]["flag_checkpay"] == 0) { ?>
                                                        <div class="col-md-4">
                                                            <label class="text-danger">Elapsed</label>
                                                            <select class="form-control" id="statusBooking">
                                                                <option value="B_activate">Activate booking</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="lm_flag">Last minute</label><br />
                                                            <input type="checkbox" id="lm_flag" style="height:25px;" value="1" <?php echo $dayToArrive < 30 ? 'checked="checked"' : '' ?> />
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="B_active">Activate until</label><br />
                                                            <input class="form-control datepicker" type="text" id="B_active" value="<?php echo $maxNoLmDate; ?>" />
                                                        </div>
                                                        <div class="col-md-3 text-right">
                                                            <button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_cambiaStato" >Change status</button>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <hr />
                                                            <p>If the agent assures you that the deposit has been already paid, click the button below to notify this to the accounting!</p>
                                                            <button type="button" class="btn btn-primary" id="B_checkPayment" >Notify check payment to accounting</button>
                                                        </div>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <div class="col-md-10">
                                                            <label class="text-danger">Elapsed</label>
                                                            <br />A check payment for this booking has already been notified to accounting!<br />Please wait for the accounting to confirm the payment.
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($book[0]["status"] == "confirmed") { ?>
                                            <?php if ($this->session->userdata('ruolo') == "contabile") { ?>
                                                <?php if ($book[0]["flag_cfd"] == 0) { ?>
                                                    <div class="col-md-6">
                                                        <label class="text-success">Confirmed</label><br />
                                                        <select class="form-control" id="statusClearedFinCon">
                                                            <option value="B_cleared">Booking cleared for departure</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_notificaCleared" >Clear booking</button>
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="col-md-10">
                                                        <label class="text-success">Confirmed and Cleared for Departure</label>
                                                        <br />This booking has been cleared for departure!
                                                    </div>
                                                <?php } ?>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="col-md-6">
                                                    <label class="text-success">Confirmed<?php if ($book[0]["flag_cfd"] == 1) { ?> and Cleared for Departure<?php } ?></label>
                                                    <select class="form-control" id="statusBooking">
                                                        <option value="B_reject">Reject booking</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 text-right">
                                                    <button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_cambiaStato" >Change status</button>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane <?php echo $pill == 'b' ? 'active' : '' ?>" id="b">
                    <div class="box">
                        <div class="box-header with-border box-header-small">
                            <h3 class="box-title width-full">
                                Booking roster - <strong><?php echo $yearId; ?>_<?php echo $storeId; ?></strong><?php if ($isFlocked == 1) { ?><span class="rLocked">LOCKED</span><?php } ?>
                                <span class="pull-right">
                                    <a id="addRosterPax" href="javascript:void(0);" ><span class="fa fa-plus"></span> Add new pax to this booking</a>

                                    <?php if ($isFlocked == 1) { ?>
                                        <a id="" href="javascript:void(0);" class="unlockBookingRoster"><span class="fa fa-lock"></span> Unlock roster</a>
                                    <?php } ?>
                                    &nbsp;<a id="exportRosterPax" target="_blank" href="<?php echo site_url() ?>/backoffice/exportRoster/<?php echo $storeId; ?>" ><span class="fa fa-download"> Export</span></a></span>
                            </h3>
                        </div>
                        <div class="box-body overflow-auto">
                            <table class="datatable table table-bordered table-hover vertical-middle" id="rostarModalTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Gender</th>
                                        <th class="text-center">Citizenship</th>
                                        <th class="text-center">Accomodation</th>
                                        <th>Group leader</th>
                                        <th>Info</th>
                                        <th>Share room</th>
                                        <th class="text-center">Campus dates</th>
                                        <th class="text-center">Arrival flight Info</th>
                                        <th class="text-center">Departure flight Info</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = 1;
                                    foreach ($detMyPax as $mypax) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $counter ?></td>
                                            <td class="infoPax"><span <?php if ($mypax["tipo_pax"] == "GL") { ?> class="tdGl infoName" <?php
                                                } else {
                                                    ?> class="infoName" <?php } ?>><?php echo $mypax["cognome"] ?> <?php echo $mypax["nome"] ?></span><?php echo ($mypax["lockPax"] == 1 OR $isFlocked == 1) ? '&nbsp<span title="Roster locked" class="locked fa fa-lock" style="font-size:9px; cursor: default !important;"></span>' : '' ?><br />DOB: <?php echo date("d/m/Y", strtotime($mypax["pax_dob"])) ?> - DOC#: <?php echo $mypax["numero_documento"] ?></td>
                                            <td class="text-center info35"><small class="label bg-grey"><?php echo $mypax["tipo_pax"] ?></small></td>
                                            <td class="text-center info20"><small class="label bg-grey"><?php echo $mypax["sesso"] ?></small></td>
                                            <td><?php echo $mypax["nazionalita"] ?></td>
                                            <td class="text-center infoAcco"><?php echo $mypax["accomodation"] ?></td>
                                            <td><?php echo $mypax["gl_rif"] ?></td>
                                            <td><?php
                                                if ($mypax["salute"]) {
                                                    echo $mypax["salute"];
                                                }
                                                ?></td>
                                            <td><?php echo $mypax["share_room"] ?></td>
                                            <td class="text-center"><?php echo date("d/m/Y", strtotime($mypax["data_arrivo_campus"])) ?><br /><?php echo date("d/m/Y", strtotime($mypax["data_partenza_campus"])) ?></td>
                                            <td class="text-center infoFlights">Flight <strong><?php echo $mypax["andata_volo"] ?></strong> - <?php echo date("d/m/Y", strtotime($mypax["andata_data_arrivo"])) ?><br /><?php echo date("H:i", strtotime($mypax["andata_data_arrivo"])) ?> at <strong><?php echo $mypax["andata_apt_arrivo"] ?></strong> from <?php echo $mypax["andata_apt_partenza"] ?></td>
                                            <td class="text-center infoFlights">Flight <strong><?php echo $mypax["ritorno_volo"] ?></strong> - <?php echo date("d/m/Y", strtotime($mypax["ritorno_data_partenza"])) ?><br /><?php echo date("H:i", strtotime($mypax["ritorno_data_partenza"])) ?> from <strong><?php echo $mypax["ritorno_apt_partenza"] ?></strong> at <?php echo $mypax["ritorno_apt_arrivo"] ?></td>
                                            <td class="text-center min-width-85">
                                                <div class="btn-group">
                                                    <?php echo ($mypax["lockPax"] == 1 && $isFlocked != 1) ? '<a href="javascript:void(0);" class="paxUnlClass btn btn-danger btn-xs" id="paxUnl_' . $mypax["id_prenotazione"] . '"><i title="Unlock Roster" class="fa fa-unlock"></i></a>' : '' ?>
                                                    <a href="javascript:void(0);" class="paxModClass btn btn-info btn-xs" id="paxMod_<?php echo $mypax["id_prenotazione"] ?>"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0);" class="paxRemClass btn btn-danger btn-xs" id="paxRem_<?php echo $mypax["id_prenotazione"] ?>"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
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
                <div class="tab-pane <?php echo $pill == 'c' ? 'active' : '' ?>" id="c">
                    <div class="box">
                        <div class="box-header with-border box-header-small">
                            <h3 class="box-title">Transfers and excursions - <strong><?php echo $yearId; ?>_<?php echo $storeId; ?></strong></h3>
                        </div>
                        <div class="box-body">

                        </div>
                    </div>
                </div>
                <div class="tab-pane <?php echo $pill == 'd' ? 'active' : '' ?>" id="d">
                    <div class="box">
                        <div class="box-header with-border box-header-small">
                            <h3 class="box-title">Calendar view - <strong><?php echo $yearId; ?>_<?php echo $storeId; ?></strong></h3>
                        </div>
                        <div class="box-body overflow-auto">
                            <div class="row">
                                <table class="datatable table table-bordered table-hover vertical-middle" id="rostarModalTable">
                                    <thead>
                                        <tr>
                                            <th>Accomodation</th>
                                            <th>Campus date IN</th>
                                            <th>Campus date OUT</th>
                                            <th>GL</th>
                                            <th>STD</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($all_acco as $accom) {
                                            $contoGL = $accom->contoGL;
                                            $contoSTD = $accom->contoSTD
                                            ?>
                                            <tr>
                                                <td><?php echo ucfirst($accom->accomodation); ?></td>
                                                <td><?php echo date("d/m/Y", strtotime($accom->data_arrivo_campus)); ?></td>
                                                <td><?php echo date("d/m/Y", strtotime($accom->data_partenza_campus)); ?></td>
                                                <td><span class="contaTP"><?php
                                                        if ($contoGL > 0) {
                                                            echo $contoGL
                                                            ?></span>&nbsp;<span class="fa <?php echo $contoGL == 1 ? 'fa-user' : 'fa-users' ?>"></span><?php
                                                        } else {
                                                            ?>-<?php } ?></td>
                                                <td><span class="contaTP"><?php
                                                        if ($contoSTD > 0) {
                                                            echo $contoSTD
                                                            ?></span>&nbsp;<span class="fa <?php echo $contoSTD == 1 ? 'fa-user' : 'fa-users' ?>"></span><?php
                                                        } else {
                                                            ?>-<?php } ?></td>
                                                    <?php /* <td class="text-center">
                                                      <a href="#" title="View detail"><span class="glyphicon glyphicon-search"></span></a>
                                                      <a href="#"><span class="glyphicon glyphicon-calendar"></span><a>
                                                      </td> */ ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <?php
                                $contarighe = 0;
                                foreach ($simbooking as $simbookingS) {
                                    /*
                                      echo $contarighe."<pre>";
                                      print_r($arrayAcco);
                                      echo "</pre><br><br>";
                                     */
                                    $contagiorniMese = 0;
                                    $giorniMese = array(0, 0);
                                    $nomeMese = array("", "");
                                    $oldmese = "";
                                    $saved_datein = $datein;
                                    while (strtotime($datein) <= strtotime($dateout)) {
                                        if ($contagiorniMese == 0) {
                                            $indiceMese = 0;
                                            $nomeMese[$indiceMese] = date("F", strtotime($datein));
                                        } else {
                                            if ($oldmese != date("m", strtotime($datein))) {
                                                $indiceMese++;
                                                $nomeMese[$indiceMese] = date("F", strtotime($datein));
                                            }
                                        }
                                        $giorniMese[$indiceMese] = $giorniMese[$indiceMese] + 1;
                                        $oldmese = date("m", strtotime($datein));
                                        $datein = date("Y-m-d", strtotime("+1 day", strtotime($datein)));
                                        $contagiorniMese++;
                                    }
                                    //print_r($giorniMese);
                                    //print_r($nomeMese);
                                    ?>
                                    <table class="table table-bordered table-condensed table-striped" style="font-size:9px;">
                                        <tbody>
                                            <tr>
                                                <td width="7%"><strong><?php echo ucfirst($arrayAcco[$contarighe]) ?></strong></td>
                                                <td class="text-center tdMese0 info-low-cal" colspan="<?php echo $giorniMese[0] ?>"><?php echo $nomeMese[0] ?></td>
                                                <td class="text-center tdMese1 success-low-cal" colspan="<?php echo $giorniMese[1] ?>"><?php echo $nomeMese[1] ?></td>
                                            </tr>
                                            <tr>
                                                <td width="7%">Day</th>
                                                    <?php
                                                    $datein = $saved_datein;
                                                    $contagiorniMese2 = 0;
                                                    while (strtotime($datein) <= strtotime($dateout)) {
                                                        ?>
                                                    <th width="3%" class="text-center<?php if ($contagiorniMese2 < $giorniMese[0]) { ?> tdMese0 info-low-cal<?php
                                                    } else {
                                                        ?> tdMese1 success-low-cal<?php } ?>"><?php echo date("d", strtotime($datein)) ?></td>
                                                        <?php
                                                        $datein = date("Y-m-d", strtotime("+1 day", strtotime($datein)));
                                                        $contagiorniMese2++;
                                                    }
                                                    $datein = $saved_datein;
                                                    ?>
                                            </tr>
                                            <tr id="riga_<?php echo $contarighe ?>">
                                                <td width="7%">Booking</td>
                                                <?php
                                                foreach ($simbookingS as $book) {
                                                    ?>
                                                    <td width="3%" class="text-center <?php if ($book["num_in"] > 0) { ?>info-cal<?php
                                                    } else {
                                                        ?>active<?php } ?>"><?php echo $book["num_in"] ?></td>
                                                        <?php
                                                    }
                                                    $datein = $saved_datein;
                                                    ?>
                                            </tr>
                                            <tr id="riga_ava_<?php echo $contarighe ?>">
                                                <td width="7%">Availability</td>
                                                <?php
                                                foreach ($simcalendar[$contarighe] as $ava) {
                                                    ?>
                                                    <td width="3%" class="text-center <?php if ($ava["n_available"] >= 0) { ?>success-cal<?php
                                                    } else {
                                                        ?>danger<?php } ?>"><?php echo $ava["n_available"] ?></td>
                                                        <?php
                                                    }
                                                    $datein = $saved_datein;
                                                    ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php
                                    $contarighe++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane <?php echo $pill == 'e' ? 'active' : '' ?>" id="e">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box">
                                <div class="box-header with-border box-header-small">
                                    <h3 class="box-title">Documents - <strong><?php echo $yearId; ?>_<?php echo $storeId; ?></strong></h3>
                                </div>
                                <div class="box-body">
                                    <a target="_blank" href="<?php echo site_url(); ?>/backoffice/printPDFAllGlByBkId/<?php echo $storeId; ?>" ><span class="fa fa-download-alt"></span> Download <strong>Group leader background check form</strong></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box">
                                <div class="box-header with-border box-header-small">
                                    <h3 class="box-title width-full">
                                        Notes - <strong><?php echo $yearId; ?>_<?php echo $storeId; ?></strong>
                                        <a id="addBkNotes" class="pull-right" href="javascript:void(0);" ><span class="fa fa-plus"></span> Add new note to this booking</a>
                                    </h3>
                                </div>
                                <div class="box-body">
                                    <?php
                                    foreach ($insertNote as $nota) {
                                        echo date("d/m/Y H:i", strtotime($nota["n_datetime"])) . " - User: " . $nota["n_userid"];
                                        if ($nota["n_public"] == 1) {
                                            echo " | Public note";
                                        }
                                        echo "<br />" . $nota["n_testo"];
                                        echo "<br />----------------------------------------------<br /><br />";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane <?php echo $pill == 'f' ? 'active' : '' ?>" id="f">
                    <div class="box">
                        <div class="box-header with-border box-header-small">
                            <h3 class="box-title width-full">
                                Payments history - <strong><?php echo $yearId; ?>_<?php echo $storeId; ?></strong><?php if ($this->session->userdata('ruolo') == "contabile") { ?><b class="pull-right">Deposit due: <?php echo number_format($valoreAcconto, 2, ",", ".") . " " . $valutaCampo; ?></b><?php } ?>
                            </h3>
                        </div>
                        <div class="box-body">
                            <?php
                            if ($this->session->userdata('ruolo') == "contabile") {
                                ?>
                                <div class="row">
                                    <form id="addPaymentFinCon" name="addPaymentFinCon">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>Type</label>
                                                    <select class="form-control" id="P_typePay" name="P_typePay">
                                                        <option value="avere">Cashed</option>
                                                        <option value="dare">Refounded</option>
                                                        <option value="acq">Due</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="P_curDate">Payment date</label><br />
                                                    <input class="form-control datepicker" type="text" id="P_curDate" name="P_curDate"/>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="P_amount">Amount/Due</label><br />
                                                    <input class="form-control" type="text" id="P_amount" name="P_amount" />
                                                </div>
                                                <div class="col-md-1">
                                                    <label>Currency</label>
                                                    <select class="form-control" id="P_currency" name="P_currency">
                                                        <option value="£">£</option>
                                                        <option value="$">$</option>
                                                        <option value="€">€</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Service</label>
                                                    <select class="form-control" id="P_operation" name="P_operation">
                                                        <?php foreach ($payServices as $pS) { ?>
                                                            <option value="<?php echo $pS["pfcse_name"] ?>"><?php echo $pS["pfcse_name"] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Method</label>
                                                    <select class="form-control" id="P_method" name="P_method">
                                                        <?php foreach ($payTypes as $pT) { ?>
                                                            <option value="<?php echo $pT["pfcpt_name"] ?>"><?php echo $pT["pfcpt_name"] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-1 text-right">
                                                    <button type="button" style="margin-top:25px;" class="btn btn-primary" id="P_add" name="P_add" >Add</button>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="mybkid" id="mybkid" value="<?php echo $storeId ?>" />
                                    </form>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="margin-5"></div>
                            <div class="row">
                                <div class="col-md-12 overflow-auto">
                                    <table id="NA_Payments" class="datatable table table-bordered table-hover vertical-middle">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Operation date</th>
                                                <th class="text-center">Currency date</th>
                                                <th class="text-center">Due</th>
                                                <th class="text-center">Type</th>
                                                <th class="text-center">Amount</th>
                                                <th class="text-center">Operation type</th>
                                                <th>Payment method</th>
                                                <th>Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $contaMoney = 0;
                                            $contaDue = 0;
                                            $lastValuta = "";
                                            foreach ($payments as $pay) {
                                                $dOrA = "Cashed";
                                                $colorDorA = "#090";
                                                $dSign = "+";
                                                if ($pay["pfp_dare_avere"] == "dare") {
                                                    $dOrA = "Refounded";
                                                    $colorDorA = "#c00";
                                                    $dSign = "-";
                                                }
                                                if ($pay["pfp_dare_avere"] == "acq") {
                                                    $dOrA = "Due";
                                                    $colorDorA = "#000";
                                                    $dSign = "+";
                                                }
                                                $giroCifra = str_replace(",", ".", $pay["pfp_importo"]);
                                                if ($dOrA == "Cashed")
                                                    $contaMoney += $giroCifra * 1;
                                                else
                                                if ($dOrA == "Refounded")
                                                    $contaMoney -= $giroCifra * 1;
                                                else
                                                    $contaDue += $giroCifra * 1;
                                                ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?php if ($this->session->userdata('ruolo') == "contabile") { ?>
                                                            <button id="delP_<?php echo $pay["pfp_id"] ?>" type="button" class="pDeleteMe btn btn-danger btn-xs" style="padding-top:2px;margin-right:5px;">Delete</button>
                                                        <?php } ?>
                                                        <?php echo date("d/m/Y H:i", strtotime($pay["pfp_data_operazione"])) ?>
                                                    </td>
                                                    <td class="text-center"><?php
                                                        if (!is_null($pay["pfp_data_valuta"])) {
                                                            echo date("d/m/Y", strtotime($pay["pfp_data_valuta"]));
                                                        }
                                                        ?></td>
                                                    <td class="text-right" style="font-weight:bold;color:#000;"><?php
                                                        if ($pay["pfp_dare_avere"] == "acq") {
                                                            echo /* $dSign." ". */number_format($giroCifra, 2, ",", ".") . " " . $pay["pfp_valuta"];
                                                        }
                                                        ?></td>
                                                    <td class="text-center" style="font-weight:bold;color:<?php echo $colorDorA; ?>"><?php echo $dOrA ?></td>
                                                    <td class="text-right"><?php
                                                        if ($pay["pfp_dare_avere"] != "acq") {
                                                            echo $dSign . " " . number_format($giroCifra, 2, ",", ".") . " " . $pay["pfp_valuta"];
                                                        }
                                                        ?></td>
                                                    <td class="text-center"><?php echo $pay["pfp_tipo_servizio"] ?></td>
                                                    <td><?php echo $pay["pfp_metodo_pagamento"] ?></td>
                                                    <td><?php echo $pay["pfp_note"] ?></td>
                                                </tr>
                                                <?php
                                                $lastValuta = $pay["pfp_valuta"];
                                            }
                                            $formattedMoney = number_format($contaMoney, 2, ",", ".");
                                            $formattedDue = number_format($contaDue, 2, ",", ".");
                                            $contaTotal = $contaMoney - $contaDue;
                                            $totalDue = number_format($contaTotal, 2, ",", ".");
                                            ?>
                                            <tr><td colspan="8">&nbsp;</td></tr>
                                            <tr>
                                                <td colspan="2" class="text-right" style="font-weight:bold;">Total</td>
                                                <td class="text-right" style="font-weight:bold;"><?php echo $formattedDue; ?> <?php echo $lastValuta; ?></td>
                                                <td>&nbsp;</td>
                                                <td class="text-right" style="font-weight:bold;"><?php echo $formattedMoney; ?> <?php echo $lastValuta; ?></td>
                                                <td colspan="3" class="text-right" style="font-weight:bold;"><?php echo $totalDue; ?> <?php echo $lastValuta; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade editmodal" id="dateEditModal" tabindex="-1" role="dialog" aria-labelledby="dateEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="dateEditModalLabel">Edit Date</h4>
            </div>
            <div class="modal-body">
                <form class="validate" name="edit_date_form" id="edit_date_form" method="POST">

                    <div class="form-group">
                        <label for="date_in">Date in:</label>
                        <input type="text" class="form-control" id="date_in" name="date_in" value="<?php echo date("d/m/Y", strtotime($date_in)); ?>" readonly/>
                    </div>
                    <div class="form-group">
                        <label for="date_out">Date out:</label>
                        <input type="text" class="form-control" id="date_out" name="date_out" value="<?php echo date("d/m/Y", strtotime($date_out)); ?>" readonly/>
                    </div>

                    <input type="hidden" id="booking_id" name="booking_id" value="<?php echo $storeId; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="edit_date_close">Close</button>
                <button type="button" class="btn btn-primary" id="edit_date_btn">Edit</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<?php require_once 'edit_week.php'; ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#date_in").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#date_in").val(selectedDate);
                $("#date_in").trigger('change');
                $("#date_out").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#date_out").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#date_out").val(selectedDate);
                $("#date_out").trigger('change');
                $("#date_in").datepicker("option", "maxDate", selectedDate);
            }
        });

        $("#edit_date_close").click(function () {
            $('#dateEditModal').modal('hide');
            $('#dateEditModal #date_in').val($("#ok_A_Date").html());
            $('#dateEditModal #date_out').val($("#ok_D_Date").html());
        });

        $("#edit_date_btn").click(function () {
            if ($("#edit_date_form").valid())
            {
                $.ajax({
                    url: siteUrl + 'backoffice/editBookingDate',
                    type: 'POST',
                    data: {'date_in': $('#date_in').val(), 'date_out': $('#date_out').val(), 'booking_id': $('#booking_id').val()},
                    success: function (data) {
                        if (data == 1)
                        {
                            $("#ok_A_Date").html($('#date_in').val());
                            $("#ok_D_Date").html($('#date_out').val());
                            swal('Success', 'Booking date updated successfully');
                        } else
                        {
                            swal('Error', 'Error while updating booking date');
                        }
                    }
                });
            }
        });

        $("#edit_date_form").validate({
            errorElement: "div",
            ignore: "",
            rules: {
                date_in: {
                    required: true
                },
                date_out:
                        {
                            required: true
                        }
            },
            messages: {
                date_in: {
                    required: "Please select date in"
                },
                date_out: {
                    required: "Please select date out"
                }
            }
        });

        $('.unlockBookingRoster').click(function () {
            confirmAction("Are you sure you want to unlock roster for this payment?", function (s) {
                if (s) {
                    $.ajax({
                        url: siteUrl + "backoffice/unlockRoster/<?php echo $storeId ?>",
                        success: function (result) {
                            $("#viewDashboardDetailModal span.rLocked").hide();
                            $("#viewDashboardDetailModal span.locked").hide();
                            $("#viewDashboardDetailModal .unlockBookingRoster").hide();
                            swal('Success', 'Roster unlock successfully.');
                        }
                    });
                }
            }, true, true);
        });

    });
</script>