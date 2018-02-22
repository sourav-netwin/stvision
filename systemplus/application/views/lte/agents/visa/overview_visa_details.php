<link rel="stylesheet" href="<?php echo base_url() ?>css/NA_style.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>css/excursion.css" />
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
    .panel-title{
        font-size:12px;
    }
    .visa-panel-body{
        overflow: auto !important;
    }
    @media(max-width: 650px){
        .visa-panel{
            height: 55px !important;
        }
        #printVisaPax{
            float: left !important;
        }
        #lockWholeRoster{
            float: left !important;
        }

    }
</style>
</head>
<body style="background-color:transparent;" id="newAva2015">
    <div class="container-fluid">
        <ul class="nav nav-pills" role="tablist">
            <li id="pill_a" role="presentation" class="active"><a href="#a" data-toggle="pill"><span class="glyphicon glyphicon-search"></span> Booking details</a></li>
            <li id="pill_b" role="presentation"><a href="#b" data-toggle="pill"><span class="glyphicon glyphicon-user"></span> VISA</a></li>
            <?php
if (isset($_SERVER["HTTP_REFERER"])) {
    if (!strpos($_SERVER["HTTP_REFERER"], "dashboard")) {
        ?>
                    <li role="presentation" class="pull-right"><a id="backToList" data-toggle="pill"><span class="glyphicon glyphicon-chevron-left"></span> Back</a></li>
                    <?php
}
}
?>
        </ul>
        <?php
$isFlocked = 0;
$da = explode("-", $book[0]["arrival_date"]);
$dd = explode("-", $book[0]["departure_date"]);
$maxNoLmDate = date("d/m/Y", strtotime($book[0]["arrival_date"]) - (24 * 3600 * 30));
$maxLmDate = date("d/m/Y", strtotime($book[0]["arrival_date"]) - (24 * 3600 * 1));
//echo $maxNoLmDate;
$storeId = $book[0]["id_book"];
$campusId = $book[0]["id_centro"];
$yearId = $book[0]["id_year"];
$accos = $book[0]["all_acco"];
$now = time();
$your_date = strtotime($book[0]["arrival_date"]);
$dayToArrive = round(($now - $your_date) / 86400 * -1);
$valutaCampo = $book[0]["valuta"];
$valoreAcconto = $book[0]["tot_pax"] * 1 * $book[0]["valore_acconto"] * 1;
?>
        <div class="tab-content" style="margin-top:10px;">
            <div class="tab-pane fade in active" id="a">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Booking details - <strong><?php echo $yearId; ?>_<?php echo $storeId; ?></strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <address>
                                    <strong><?php echo $book[0]["id_year"] ?>_<?php echo $book[0]["id_book"] ?><?php if ($book[0]["id_ref_overnight"]) {?> - <span style="color:#f00;">OVERNIGHT (<?php echo $book[0]["id_ref_overnight"] ?>)</span><?php }?></strong><br>
                                    <?php echo $book[0]["centro"] ?> - [<?php echo $dayToArrive ?> days to arrival]<br>
                                    <strong>Date in: </strong><span id="ok_A_Date"><?php echo $da[2] ?>/<?php echo $da[1] ?>/<?php echo $da[0] ?></span><br>
                                    <strong>Date out: </strong><?php echo $dd[2] ?>/<?php echo $dd[1] ?>/<?php echo $dd[0] ?><br>
                                    <abbr title="Phone">P:</abbr> <?php echo $agente[0]["businesstelephone"] ?>
                                </address>
                            </div>
                            <div class="col-md-3">
                                <address>
                                    <strong><img style="margin-top:-1px;" class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $agente[0]["businesscountry"] ?>.png" alt="<?php echo $agente[0]["businesscountry"] ?>" title="<?php echo $agente[0]["businesscountry"] ?>" /><?php echo $agente[0]["businessname"] ?></strong><br>
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

                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="b">
                <div class="panel panel-primary">
                    <div class="panel-heading visa-panel">
                        <h3 class="panel-title">Booking roster - <strong><?php echo $yearId; ?>_<?php echo $storeId; ?></strong><?php if (1 == $book[0]["lockPax"]) {?><span class="rLocked">LOCKED</span><?php
} else {
    ?> <span id="lockDisp"></span><?php }?>
                            <a id="printVisaPax" data-book="<?php echo $storeId ?>" target="_blank" style="float:right; margin-left: 5px;" href="javascript:void(0)" data-href="<?php echo site_url() ?>/agents/pdfLockedVisas/<?php echo $storeId ?>" ><span class="glyphicon glyphicon-print"></span> Print VISA for locked pax</a>
                            <?php
if (1 != $book[0]["lockPax"]) {
    ?>
                                &nbsp;<a id="lockWholeRoster" data-centro="<?php echo $campusId; ?>" data-id="<?php echo $storeId; ?>"  data-year="<?php echo $yearId; ?>" style="float:right; margin-left: 5px;" href="javascript:void(0)" ><span class="glyphicon glyphicon-lock"></span> Lock whole roster</a>
                                <?php
}
?>
                        </h3>
                    </div>
                    <div class="panel-body visa-panel-body">
                        <div class="row-fluid pull-right" id="transer_status_div">
                            <?php
if (null === $book[0]['flag_transfer'] || (0 != $book[0]['flag_transfer'] && 1 != $book[0]['flag_transfer'])) {$transfer_status = -1;?>
                                    <label class="control-label">Do you want to request transfer for all pax in your booking?</label>
                                    <label><input type="radio" class="changeTransferStatus" name="transer_facility" value='1' data-status='1' data-book='<?php echo $storeId; ?>'>Yes</label>
                                    <label><input type="radio" class="changeTransferStatus" name="transer_facility" value='0' data-status='0' data-book='<?php echo $storeId; ?>'>No</label>
                            <?php } elseif (0 == $book[0]['flag_transfer']) {$transfer_status = 0;?>
                                    <label class="control-label">You have selected "No" to transfer for all pax in your booking.</label>
                            <?php } elseif (1 == $book[0]['flag_transfer']) {$transfer_status = 1;?>
                                    <label class="control-label">You have selected "Yes" to transfer for all pax in your booking.</label>
                            <?php }
?>
                        </div>
                        <input type="hidden" id='transfer_status' value="<?php echo $transfer_status; ?>" />
                        <div class="row-fluid">
                            <div class="col-12">
                                <table id="NA_Roster" class="table table-bordered table-condensed table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Name</th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-center">Accomodation</th>
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
$totalPax = count($detMyPax);
$totalLockedPax = 0;
foreach ($detMyPax as $mypax) {
    if (0 != $mypax['lockPax']) {
        $totalLockedPax = $totalLockedPax + 1;
    }
    ?>
                                        <div style="display: none;" id="dialog_modal_<?php echo $mypax["id_prenotazione"] ?>" title="Roster detail - <?php echo htmlentities($mypax["nome"] . ' ' . $mypax['cognome']); ?>" class="windia">
                                            <div class="row">
                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Name: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $mypax["nome"] ?></div>

                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Surname: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $mypax["cognome"] ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>DOB: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo date("d/m/Y", strtotime($mypax["pax_dob"])); ?></div>

                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>DOC: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $mypax["numero_documento"]; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Type of pax: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $mypax["tipo_pax"]; ?></div>

                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Sex: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $mypax["sesso"]; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Accommodation type: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo ucfirst($mypax["accomodation"]); ?></div>

                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Group leader: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo ($mypax["gl_rif"]); ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Info: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo ($mypax["salute"]); ?></div>

                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Share room: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo ($mypax["share_room"]); ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Campus arrival date: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo date("d/m/Y", strtotime($mypax["data_arrivo_campus"])); ?></div>

                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Campus departure date: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo date("d/m/Y", strtotime($mypax["data_partenza_campus"])); ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Arrival flight number: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $mypax["andata_volo"]; ?></div>

                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Arrival flight date and time: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo date("d/m/Y", strtotime($mypax["andata_data_arrivo"])) . ' ' . date("H:i", strtotime($mypax["andata_data_arrivo"])); ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Arrival airport: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $mypax["andata_apt_arrivo"]; ?></div>

                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Departure airport for the arrival flight: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $mypax["andata_apt_partenza"]; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Departure flight number: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $mypax["ritorno_volo"]; ?></div>

                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Departure flight date and time: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo date("d/m/Y", strtotime($mypax["ritorno_data_partenza"])) . ' ' . date("H:i", strtotime($mypax["ritorno_data_partenza"])); ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Departure airport: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $mypax["ritorno_apt_partenza"]; ?></div>

                                                <div class="col-xs-6 col-md-3 col-lg-3"><strong>Arrival airport for the departure flight: </strong></div>
                                                <div class="col-xs-6 col-md-3 col-lg-3"><?php echo $mypax["ritorno_apt_arrivo"]; ?></div>
                                            </div>
                                        </div>
                                        <tr>
                                            <td class="text-center"><?php echo $counter ?></td>
                                            <td class="infoPax"><span <?php if ("GL" == $mypax["tipo_pax"]) {?> class="tdGl infoName" <?php
} else {
        ?> class="infoName" <?php }?>><?php echo $mypax["cognome"] ?> <?php echo $mypax["nome"] ?></span><br />DOB: <?php echo date("d/m/Y", strtotime($mypax["pax_dob"])) ?> - DOC#: <?php echo $mypax["numero_documento"] ?></td>
                                            <td class="text-center info35"><span class="infoSex infoTipoPax"><?php echo $mypax["tipo_pax"] ?></span></td>
                                            <td class="text-center info20"><span class="infoSex"><?php echo $mypax["sesso"] ?></span></td>
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
                                            <td  class="text-center" id="td_<?php echo $mypax["id_prenotazione"]; ?>">
                                                <?php
if (!empty($templates)) {
        if (1 == $book[0]["lockPax"]) {
            $marSus = 0;
            ?>
                                                        <?php
if ('' != $mypax["template"]) {
                ?>
                                                            <input class="tempSel"  type="hidden" id="selTemp_<?php echo $mypax["id_prenotazione"] ?>" value="<?php echo $mypax["template"] ?>" />
                                                        <?php }?>
                                                        <select  style="width: 77px"
                                                        <?php
if ('' != $mypax["template"]) {
                if ('UKIR' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland';
                }
                if ('USA' == $mypax["template"]) {
                    $tempTitle = 'USA';
                }
                if ('MAL' == $mypax["template"]) {
                    $tempTitle = 'Malta';
                }
                if ('UKIRGLSTD' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland - GL Standard';
                }
                if ('UKIRSTDSTD' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland - STD Standard';
                }
                if ('UKIRSTDST' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland - STD Short Term';
                }
                ?> disabled="disabled" title="<?php echo $tempTitle; ?>"
                                                                     <?php
} else {
                ?>  class="tempSel"  id="selTemp_<?php echo $mypax["id_prenotazione"] ?>" <?php }?> >
                                                                 <?php
if ('' == $mypax["template"]) {
                $dspCnt = 1;
                foreach ($templates as $template) {
                    $chk = 0;
                    $tempTitle = '';
                    if ('UKIR' == $template['template']) {
                        $tempTitle = 'UK/Ireland';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                            $chk += 1;
                        }
                    }
                    if ('USA' == $template['template']) {
                        $tempTitle = 'USA';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                            $chk += 1;
                        }
                    }
                    if ('MAL' == $template['template']) {
                        $tempTitle = 'Malta';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                            $chk += 1;
                        }
                    }
                    if ('UKIRGLSTD' == $template['template']) {
                        $tempTitle = 'UK/Ireland - GL Standard';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                            $chk += 1;
                        }
                    }
                    if ('UKIRSTDSTD' == $template['template']) {
                        $tempTitle = 'UK/Ireland - STD Standard';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                            $chk += 1;
                        }
                    }
                    if ('UKIRSTDST' == $template['template']) {
                        $tempTitle = 'UK/Ireland - STD Short Term';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                            $chk += 1;
                        }
                    }
                    if ($chk > 0) {
                        $marSus += 1;
                        if (1 == $dspCnt) {
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
                if (0 == $marSus) {
                    ?>
                                                                    <option value="">NA</option>
                                                                    <?php
}
            } else {
                $tempTitle = '';
                if ('UKIR' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland';
                }
                if ('USA' == $mypax["template"]) {
                    $tempTitle = 'USA';
                }
                if ('MAL' == $mypax["template"]) {
                    $tempTitle = 'Malta';
                }
                if ('UKIRGLSTD' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland - GL Standard';
                }
                if ('UKIRSTDSTD' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland - STD Standard';
                }
                if ('UKIRSTDST' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland - STD Short Term';
                }
                ?>
                                                                <option selected="selected" value="<?php echo $mypax['template'] ?>"><?php echo $tempTitle ?></option>
                                                                <?php
}
            ?>
                                                        </select>
                                                        <span class="selTmplDemo" data-id="<?php echo $mypax['id_prenotazione'] ?>" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 15px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>
                                                        <?php
} elseif (1 == $mypax["lockPax"]) {
            $marSus = 0;
            ?>
                                                        <?php if ('' != $mypax["template"]) {
                ?>
                                                            <input class="tempSel" type="hidden" id="selTemp_<?php echo $mypax["id_prenotazione"] ?>" value="<?php echo $mypax["template"] ?>" />
                                                        <?php }?>
                                                        <select  style="width: 77px"
                                                        <?php
if ('' != $mypax["template"]) {
                $tempTitle = '';
                if ('UKIR' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland';
                }
                if ('USA' == $mypax["template"]) {
                    $tempTitle = 'USA';
                }
                if ('MAL' == $mypax["template"]) {
                    $tempTitle = 'Malta';
                }
                if ('UKIRGLSTD' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland - GL Standard';
                }
                if ('UKIRSTDSTD' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland - STD Standard';
                }
                if ('UKIRSTDST' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland - STD Short Term';
                }
                ?> disabled="disabled" title="<?php echo $tempTitle; ?>"
                                                                     <?php
} else {
                ?> id="selTemp_<?php echo $mypax["id_prenotazione"] ?>"  class="tempSel" <?php }?> >
                                                                 <?php
if ('' == $mypax["template"]) {
                $dspCnt = 1;
                foreach ($templates as $template) {
                    $chk = 0;
                    $tempTitle = '';
                    if ('UKIR' == $template['template']) {
                        $tempTitle = 'UK/Ireland';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                            $chk += 1;
                        }
                    }
                    if ('USA' == $template['template']) {
                        $tempTitle = 'USA';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                            $chk += 1;
                        }
                    }
                    if ('MAL' == $template['template']) {
                        $tempTitle = 'Malta';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                            $chk += 1;
                        }
                    }
                    if ('UKIRGLSTD' == $template['template']) {
                        $tempTitle = 'UK/Ireland - GL Standard';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                            $chk += 1;
                        }
                    }
                    if ('UKIRSTDSTD' == $template['template']) {
                        $tempTitle = 'UK/Ireland - STD Standard';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                            $chk += 1;
                        }
                    }
                    if ('UKIRSTDST' == $template['template']) {
                        $tempTitle = 'UK/Ireland - STD Short Term';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                            $chk += 1;
                        }
                    }
                    if ($chk > 0) {
                        $marSus += 1;
                        if (1 == $dspCnt) {
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
                if (0 == $marSus) {
                    ?>
                                                                    <option value="">NA</option>
                                                                    <?php
}
            } else {
                $tempTitle = '';
                if ('UKIR' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland';
                }
                if ('USA' == $mypax["template"]) {
                    $tempTitle = 'USA';
                }
                if ('MAL' == $mypax["template"]) {
                    $tempTitle = 'Malta';
                }
                if ('UKIRGLSTD' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland - GL Standard';
                }
                if ('UKIRSTDSTD' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland - STD Standard';
                }
                if ('UKIRSTDST' == $mypax["template"]) {
                    $tempTitle = 'UK/Ireland - STD Short Term';
                }
                ?>
                                                                <option selected="selected" value="<?php echo $mypax['template'] ?>"><?php echo $tempTitle ?></option>
                                                                <?php
}
            ?>
                                                        </select>
                                                        <span class="selTmplDemo" data-id="<?php echo $mypax['id_prenotazione'] ?>" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 15px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>
                                                        <?php
}
    } else {
        if (1 == $book[0]["lockPax"]) {
            ?>
                                                        <select style="width: 77px"><option value="">NA</option></select>
                                                        <?php
} elseif (1 == $mypax["lockPax"]) {
            ?>
                                                        <select style="width: 77px"><option value="">NA</option></select>
                                                        <?php
}
    }
    ?>
                                            </td>
                                            <th class="text-center">
                                                <?php
if (1 == $book[0]["lockPax"]) {
        ?>
                                                    <span class="glyphicon glyphicon-lock locked error" title="Roster Locked."></span>
                                                    <?php
if (!empty($templates)) {
            ?>
                                                        <a id="prntVisa_<?php echo $mypax["id_prenotazione"]; ?>" href="javascript:void(0)" data-href="<?php echo site_url() ?>/agents/pdfSingleVisa/<?php echo $mypax["id_prenotazione"]; ?>/<?php echo $storeId ?>" title="Print VISA" target="_blank" class="prinOpen"><span class="glyphicon glyphicon-print"></span></a>
                                                        <?php
}
    } elseif (1 == $mypax["lockPax"]) {
        ?>
                                                    <span class="glyphicon glyphicon-lock locked error" title="Roster Locked."></span>
                                                    <?php
if (!empty($templates)) {
            ?>
                                                        <a id="prntVisa_<?php echo $mypax["id_prenotazione"]; ?>"  href="javascript:void(0)" data-href="<?php echo site_url() ?>/agents/pdfSingleVisa/<?php echo $mypax["id_prenotazione"]; ?>/<?php echo $storeId ?>" title="Print VISA" target="_blank"  class="prinOpen"><span class="glyphicon glyphicon-print"></span></a>
                                                        <?php
}
    } else {
        ?>
                                                    <a href="javascript:void(0);" class="lockRoster" data-centro="<?php echo $campusId ?>" id="paxLoc_<?php echo $mypax["id_prenotazione"] ?>" data-toggle="tooltip" title="Lock roster" data-id='<?php echo $storeId ?>'><span class="glyphicon glyphicon-lock"></span></a>
                                                    <?php
}
    ?>

                                                <a href="javascript:void(0);" class="paxOpenClass" id="paxOpn_<?php echo $mypax["id_prenotazione"] ?>"><span class="glyphicon glyphicon-eye-open dialogbtn_visa" title="View detais" data-toggle="tooltip" data-id="dialog_modal_btn_<?php echo $mypax["id_prenotazione"]; ?>"></span></a>
                                            </th>
                                        </tr>
                                        <?php
$counter++;
}
?>
                                    <input type="hidden" id='totalPax' value='<?php echo $totalPax ?>' />
                                    <input type="hidden" id='totalLockedPax' value='<?php echo $totalLockedPax ?>' />
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="updatingAll"><img src="<?php echo base_url() ?>img/uploadingData.gif" title="Uploading data..." alt="Uploading data..."></div>
<div id="dialog_modal_print_visa_pax" data-backdrop="static" class="modal">
    <div class="modal-dialog modal-lg-95-per">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sales detail
                    <button aria-label="Close" onclick="$('#dialog_modal_print_visa_pax').modal('hide');$('body').addClass('modal-open');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div id="retriveDataDiv" style="height: 500px;" class="modal-body">
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_print_visa_pax').modal('hide');$('body').addClass('modal-open');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<!--        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script>
        function lockRosterFunction(elm, parent, rowId, centroId, totalLockedPax){
            swal({
              title: "Are you sure to lock roster?",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-success",
              confirmButtonText: 'Ok',
              closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url: siteUrl + 'agents/lockSingleRoster',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        rowId: rowId,
                        centroId: centroId
                    },
                    success: function(data){
                        totalLockedPax = parseInt(totalLockedPax) + 1;
                        if(data.status == 1){
                            elm.remove();
                            $('#td_'+rowId).html(data.result+'<span class="selTmplDemo" data-id="'+rowId+'" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 15px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>');
                            parent.prepend('<span class="glyphicon glyphicon-lock locked" style="color: #FF0000" title="Roster Locked."></span>&nbsp<a id="prntVisa_'+rowId+'" href="javascript:void(0)" data-href="'+siteUrl+'agents/pdfSingleVisa/'+rowId+'/<?php echo $storeId ?>" title="Print VISA"  class="prinOpen"><span class="glyphicon glyphicon-print"></span></a>');

                            $("input[id=totalLockedPax]").val(totalLockedPax);
                            swal("Success",'Roster locked successfully');
                        }
                        else if(data.status == 3){
                            elm.remove();
                            $('#td_'+rowId).html(data.result+'<span class="selTmplDemo" data-id="'+rowId+'" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 15px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>');
                            parent.prepend('<span class="glyphicon glyphicon-lock locked" style="color: #FF0000" title="Roster Locked."></span>');
                            $("input[id=totalLockedPax]").val(totalLockedPax);
                            swal("Success",'Roster locked successfully');
                        }
                        else if(data.status == 2){
                            swal("Error",'Roster details are not complete. Failed to lock');
                        }
                        else{
                            swal("Error",'Failed to lock Roster');
                        }
                    },
                    error: function(){
                        swal("Error",'Failed to lock Roster');
                    }
                });
            });
        }

        $(document).on('click', '.lockRoster', function(e){
            e.preventDefault();
            var elm = $(this);
            var parent = elm.parent();
            var rowId = elm.attr('id').replace('paxLoc_', '');
            var centroId = elm.attr('data-centro');
            var bookId = elm.attr('data-id');

            var totalLockedPax = $("#totalLockedPax").val();
            var totalPax = $("#totalPax").val();
            totalPax = totalPax - 1 ;

            if(totalPax  == totalLockedPax){
                var transfer_status = $("#transfer_status").val();
                if(transfer_status == -1 || (transfer_status != 1 && transfer_status != 0)){
                    swal("Please choose whether you want transfer for the booking or not?");
                    return false;
                }
                else{
                    swal({
                      title: "Do you want to change transfer?",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: "btn-success",
                      confirmButtonText: 'Change',
                      closeOnConfirm: false
                    },
                    function(isConfirm){
                        if(isConfirm){
                            if(transfer_status == 1){
                                transfer_status = 0;
                            }else{
                                transfer_status = 1;
                            }

                            changeTransferStatusFunction(transfer_status, bookId);
                            setTimeout(function(){
                                lockRosterFunction(elm, parent, rowId, centroId, totalLockedPax);
                            },2000);


                        } else{
                            setTimeout(function(){
                                lockRosterFunction(elm, parent, rowId, centroId, totalLockedPax);
                            },200);
                        }
                    });
                }
            }else{
                lockRosterFunction(elm, parent, rowId, centroId, totalLockedPax);
            }
        });

        function lockWholeRosterFunction(bookId, yearId, centroId){
            swal({
              title: "Are you sure to lock whole roster?",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-success",
              confirmButtonText: 'Ok',
              closeOnConfirm: false
            },
            function(){
                    $.ajax({
                        url: siteUrl + 'agents/lockWholeRoster',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            bookId: bookId,
                            yearId: yearId,
                            centroId: centroId
                        },
                        success: function(data){
                            if(data.status == 2){
                                swal("Error",'There are incomplete rosters. Please fill all the details and retry.');
                            }
                            else if(data.status == 1){
                                var winParent = window.parent.$('#compile_'+yearId+'_'+bookId).parent();
                                window.parent.$('#compile_'+yearId+'_'+bookId).remove();
                                winParent.append('<img src="'+baseUrl+'img/icons/packs/fugue/16x16/tick-button.png" class="icon">');
                                window.location.href=siteUrl + 'agents/getVisaPopupDetails/<?php echo $storeId; ?>/b';
                                return false;
                            }
                            else{
                                swal("Error",'Failed to lock Whole Roster');
                            }
                        },
                        error: function(){
                            swal("Error",'Failed to lock Whole Roster');
                        }
                    });

            });
        }
        $(document).on('click', '#lockWholeRoster', function(e){
            e.preventDefault();
            var elm = $(this);
            var bookId = elm.attr('data-id');
            var yearId = elm.attr('data-year');
            var centroId = elm.attr('data-centro');

            var transfer_status = $("#transfer_status").val();
            if(transfer_status == -1 || (transfer_status != 1 && transfer_status != 0)){
                swal("Please choose whether you want transfer for the booking or not?");
                return false;
            }
            else{
                swal({
                  title: "Do you want to change tranfer?",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-success",
                  confirmButtonText: 'Change',
                  closeOnConfirm: false
                },
                function(isConfirm){
                    if(isConfirm){
                        if(transfer_status == 1){
                            transfer_status = 0;
                        }else{
                            transfer_status = 1;
                        }

                        changeTransferStatusFunction(transfer_status, bookId);
                        setTimeout(function(){
                            lockWholeRosterFunction(bookId, yearId, centroId)
                        },2000);


                    } else{
                        setTimeout(function(){
                            lockWholeRosterFunction(bookId, yearId, centroId)
                        },200);
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

        $('#backToList').click(function(){
            parent.history.back();
            return false;
        });

        $(document).on('change', '.tempSel', function(){
            var templ = $(this).val();
            var rowId = $(this).attr('id').replace('selTemp_', '');
            if(templ != '' && typeof templ != 'undefined'){
                $('.selTmplDemo[data-id='+rowId+']').css('display','inline-block');
            }
            else{
                $('.selTmplDemo[data-id='+rowId+']').css('display','none');
            }
        });
        function validateEmpty(rowId){
            var selValue = $('#selTemp_'+rowId).val();
            if(selValue == '' || typeof selValue == 'undefined'){
                swal("Error",'Please select template');
                return false;
            }
        }
        $(document).on('click', '.prinOpen', function(e){
            e.preventDefault();
            var elm = $(this);
            var rowId = $(this).attr('id').replace('prntVisa_','');
            var selValue = $('#selTemp_'+rowId).val();
            var c = true;
            if(selValue == '' || typeof selValue == 'undefined'){
                swal("Error",'Please select template');
                return false;
            }
            else{
                $(this).parents('th').prev().find('.tempSel').attr('disabled', true);
                if(!$('#selTemp_'+rowId).is('input[type=hidden]')){
                    c = confirm('Are you sure to print VISA? The template once selected can not change again.');
                }
                if(c){
                    $.ajax({
                        url: siteUrl+'agents/lockTemplate',
                        type: 'POST',
                        async: false,
                        data: {
                            rowId: rowId,
                            selValue: selValue
                        },
                        success: function(data){
                            if(data == 1){
                                var elm1 = $('#selTemp_'+rowId);
                                /*setTimeout(function(){
                                    window.location.href=siteUrl + 'agents/getVisaPopupDetails/<?php echo $storeId; ?>/b';
                                }, 1000);*/
                                window.open(elm.attr('data-href')+'/'+selValue);
                                return false;
                            }
                            else if(data == 2){
                                swal("Error",'Nationality not found/Invalid nationality');
                            }
                            else{
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
            var bookId = elm.attr('data-book');
            if(bookId !== '' && typeof bookId != 'undefined'){
                $.ajax({
                    url: siteUrl + 'agents/checkAnyPaxLocked',
                    type: 'POST',
                    data: {
                        bookId: bookId
                    },
                    success: function(data){
                        if(data == 1){
                            var SelTmplCount = 0;
                            var rowIds = '';
                            var selCount = 0;
                            var c = true;
                            var totSelTmplCount = $('.tempSel').length;
                            $('.tempSel').each(function(){
                                if($(this).val() != '' && typeof $(this).val() != 'undefined'){
                                    if(!$(this).is('input[type=hidden]')){
                                        selCount += 1;
                                    }
                                    if(SelTmplCount == 0){
                                        rowIds += $(this).attr('id').replace('selTemp_', '')+'-'+$(this).val();
                                    }
                                    else{
                                        rowIds += '/'+$(this).attr('id').replace('selTemp_', '')+'-'+$(this).val();
                                    }
                                    SelTmplCount += 1;
                                }
                            });
                            if(totSelTmplCount == 0 && SelTmplCount == 0){
                                swal("Error",'No mapped templates found. Map some templates and try again!');
                                return false;
                            }
                            if(totSelTmplCount != SelTmplCount){
                                var rowIdsNoSel = '';
                                var noSelTmplCount = 0;
                                $('.tempSel').each(function(){
                                    if($(this).val() == '' || typeof $(this).val() == 'undefined'){
                                        if(noSelTmplCount == 0){
                                            rowIdsNoSel += $(this).attr('id').replace('selTemp_', '');
                                        }
                                        else{
                                            rowIdsNoSel += '/'+$(this).attr('id').replace('selTemp_', '');
                                        }
                                        noSelTmplCount += 1;
                                    }
                                });
                                $.ajax({
                                    url: siteUrl + 'agents/checkMappedTemplate',
                                    type: 'POST',
                                    async: false,
                                    data: {
                                        bookId: bookId,
                                        rowIds: rowIds
                                    },
                                    success: function(data){
                                        if(data == 1){
                                            var diaH = $(window).height()* 0.9;
                                            e.preventDefault();
                                            $('#retriveDataDiv').html('');
                                            loading();
                                            $('<iframe/>', {
                                                'src' : siteUrl + "agents/visaLockedTemplate/"+bookId+"/"+rowIdsNoSel,
                                                'style' :'width:100%; height:100%;border:none;'
                                            }).appendTo('#retriveDataDiv');
                                            $("#dialog_modal_print_visa_pax").modal('show');;
                                            setTimeout(function(){
                                                unloading();
                                            },3000);
                                        }
                                        else if(data == 2){
                                            swal("Error",'Some/All pax\'s nationalities missing or invalid');
                                        }
                                        else{
                                            swal("Error",'No mapped templates found. Map some templates and try again!');
                                        }
                                    },
                                    error: function(){
                                        swal("Error",'Error occured. Could not continue VISA printing!');
                                    }
                                });
                            }
                            else{
                                if(selCount > 0){
                                    c = confirm('Are you sure to print VISA? The template once selected can not change again.');
                                }
                                if(c){
                                    $.ajax({
                                        url: siteUrl + 'agents/checkMappedTemplate',
                                        type: 'POST',
                                        async: false,
                                        data: {
                                            bookId: bookId,
                                            rowIds: rowIds
                                        },
                                        success: function(data){
                                            if(data == 1){
                                                $.ajax({
                                                    url: siteUrl+'agents/checkBookLocked',
                                                    type: 'POST',
                                                    data: {
                                                        bookId: bookId
                                                    },
                                                    success: function(data){
                                                        if(data == 1){
                                                            var diaH = $(window).height()* 0.9;
                                                            $('#retriveDataDiv').html('');
                                                            loading();
                                                            $('<iframe/>', {
                                                                'src' : siteUrl + "agents/visaLockedTemplate/"+bookId,
                                                                'style' :'width:100%; height:100%;border:none;'
                                                            }).appendTo('#retriveDataDiv');
                                                            $("#dialog_modal_print_visa_pax").modal('show');;
                                                            setTimeout(function(){
                                                                unloading();
                                                            },3000);
                                                        }
                                                        else if(data == 2){
                                                            setTimeout(function(){
                                                                window.location.href=siteUrl+"agents/getVisaPopupDetails/"+bookId+"/b";
                                                            }, 1000);

                                                            window.open(siteUrl + "agents/pdfLockedVisas/"+bookId+"/"+rowIds);
                                                            return false;
                                                        }
                                                        else{
                                                            swal("Error",'Error occured. Could not continue VISA printing!');
                                                        }
                                                    },
                                                    error: function(){
                                                        swal("Error",'Error occured. Could not continue VISA printing!');
                                                    }
                                                });
                                            }
                                            else if(data == 2){
                                                swal("Error",'Some/All pax\'s nationalities missing or invalid');
                                            }
                                            else{
                                                swal("Error",'No mapped templates found. Map some templates and try again!');
                                            }
                                        },
                                        error: function(){
                                            swal("Error",'Error occured. Could not continue VISA printing!');
                                        }

                                    });
                                }
                            }

                        }
                        else{
                            swal("Error",'No locked VISA found. Lock some  VISA and try again');
                        }
                    },
                    error: function(){
                        swal("Error",'Error occured. Could not continue VISA printing!');
                    }
                });
            }
        });
        $(function(){
            $(".tab-pane").removeClass("active");
            $(".nav-pills > li").removeClass("active");
            $("#<?php echo $pill; ?>").addClass("active");
            $("#pill_<?php echo $pill; ?>").addClass("active");
        });
        $(document).on('click','.selTmplDemo', function(){
            var id = $(this).attr('data-id');
            var templ = $('#selTemp_'+id).val();
            if(templ != '' && typeof templ != 'undefined'){
                window.open(siteUrl+'agents/visaPDFDemo/'+templ);
            }
        });

        $(document).on('click','.changeTransferStatus', function(){
            var status = $(this).attr('data-status');
            var bookId = $(this).attr('data-book');
            var message = '';
            var btn_title = '';

            if(status == 1){
                message = "You want transfer for pax in your booking";
                btn_title = 'Book';

            }else{
                message = "You don't want transfer for pax in your booking";
                btn_title = 'Not book';
                status = 0;
            }

            swal({
              title: "Are you sure?",
              text: message,
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: btn_title,
              closeOnConfirm: false
            },
            function(){
                changeTransferStatusFunction(status, bookId);
            });
        });

        function changeTransferStatusFunction(status, bookId)
        {
            $.ajax({
                url: siteUrl + 'agents/updateTransferStatus',
                type: 'POST',
                data: {
                    status: status,
                    bookId: bookId
                },
                success: function(data){
                    if(data == '1'){
                        var success_label = '';
                        if(status == 1){
                            //$("#transfer_status").val('1');
                            $("input[id=transfer_status]").val('1');
                            message = "Transfer booked for pax in your booking";
                            success_label = '<label class="control-label">You have selected "Yes" to transfer for all pax in your booking.</label>';
                        }else{
                            //$("#transfer_status").val('0');
                            $("input[id=transfer_status]").val('0');
                            message = "Transfer not booked for pax in your booking";
                            success_label = '<label class="control-label">You have selected "No" to transfer for all pax in your booking.</label>';
                        }
                        $("#transer_status_div").html(success_label);
                        swal("Success!", message, "success");
                        return true;
                    }
                    else{
                        swal("Error",'Error occured. Please try again.');
                    }
                }
            });
        }
    </script>