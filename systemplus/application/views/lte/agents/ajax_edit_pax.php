<style type="text/css">
    .customfile{
        width: 250px !important;
        margin: 20px auto 0px !important;
        margin-top: 0px !important;
    }
    #importPaxFile{
        z-index: 999999;
    }
    @media(max-width: 650px){
        #postaPax table td{
            height: 24px !important;
        }
        #postaPax table th{
            height: 24px !important;
        }
    }
    #postaPax .form-control{
        padding:0px 1px!important;
    }
.chooseDOB {
    z-index: 100000;
}
    
input[type="text"].rosterField{
	padding:2px;
	width:75px;
}

.form-control.w30{
	width:35px;
}

.form-control.w40{
	width:50px;
}

.form-control.w55{
	width:65px;
}

.form-control.w60{
	width:70px;
}

.form-control.w80{
	width:95px;
}
#copyFirst{
    display: none;
}
input[type="text"]
{
    font-size:12px;
}
.hasDatepicker{
	min-width: 70px !important;
}
.chooseTime1, .chooseTime2  {
	min-width: 30px !important;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
	padding: 2px !important;
}
#dialog_modal{
	padding-right: 0 !important;
}
</style>
<?php
$bkg = $booking_detail[0];
?>		
<div class="row">
    <div class="col-sm-12">
        <?php echo showSessionMessageIfAny($this);?>
        <div class="form-group" style="border: none;">
            <form method="post" style="border: none !important;" action="<?php echo base_url(); ?>index.php/agents/importPax" enctype="multipart/form-data" onsubmit="return validateFile()">
                <div class="row">
                    <div class="col-sm-12 text-center mr-bot-5" style="margin:0 auto;text-align: center;" >
                        
						<input type="file" id="importPaxFile" name="importPaxFile" />
						<input class="btn btn-primary" type="submit" value="Upload excel file" />
						
						<a target="_blank" href="<?php echo site_url() ?>/agents/exportPaxForOffline/<?php echo $bkg["id_book"] ?>">
                        <button style="margin-right:15px;" type="button" class="btn btn-primary" id="exportPax" name="exportPax" >Download excel file</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
<div class="col-sm-12" style="overflow: auto; max-height: 350px;">
<form name="postaPax" id="postaPax" method="POST" action="<?php echo base_url(); ?>index.php/agents/postaPax/<?php echo $bkg["id_book"] ?>">
    <a href="javascript:void(0);" id="copyFirst">Copy common data from first line</a>
    <table class="table table-bordered table-hover width-full vertical-middle" style="width:99.98%;">
        <thead>
            <tr>
                <th>Type</th>
                <th>Surname</th>								
                <th>Name</th>
                <th>Sex</th>
                <th>Date of birth</th>									
                <th>Citizenship</th>
                <th>Passport no</th>
                <th>Health info</th>									
                <th>Share room with</th>
                <th>GL ref.</th>
                <th>Type of course</th>
                <th>Campus date in</th>		
                <th>Campus date out</th>									
                <th>Arr flight date</th>
                <th>Arr time</th>
                <th>Arrival airport</th>
                <th>Flight number in</th>
                <th>Dep flight date</th>
                <th>Dep time</th>
                <th>Departure airport</th>
                <th>Flight number out</th>
                <th>Visa</th>									
                <th>Departure airport for the arrival flight</th>									
                <th>Arrival airport for the departure flight</th>									
            </tr>
        </thead>
        <tbody>

            <?php
			if($paxs){
				$idFirstLine = $paxs[0]["id_prenotazione"];
				$idFirstLine1 = $paxs[0]["id_prenotazione"];
			}
            //print_r($paxs);
            $contarighe = 1;
            $noLock = 1;
            foreach ($paxs as $pax) {
                if (is_null($pax["pax_dob"]) or $pax["pax_dob"] == "0000-00-00") {
                    $pax["pax_dob"] = "1970-01-01";
                }
                if ($pax["lockPax"] == 1 && $contarighe == 1) {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $pax["tipo_pax"] ?><br /><?php echo $pax["accomodation"] ?></td>
                        <td class="text-center"><?php echo $pax["cognome"] ?><input class="form-control w80 reqField hidden" id="cognome__<?php echo $pax["id_prenotazione"] ?>" name="cognome__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["cognome"] ?>" /></td>
                        <td class="text-center"><?php echo $pax["nome"] ?><input class="form-control w80 reqField hidden" id="nome__<?php echo $pax["id_prenotazione"] ?>" name="nome__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["nome"] ?>" /></td>
                        <td class="text-center">
                            <?php if ($pax["sesso"] == "M") {
                                echo 'M';
                            } if ($pax["sesso"] == "F") {
                                echo 'F';
                            } ?>
                            <input type="text" class="hidden" id="sesso__<?php echo $pax["id_prenotazione"]; ?>" name="sesso__<?php echo $pax["id_prenotazione"]; ?>" value="<?php if ($pax["sesso"] == "M") { ?>M<?php } if ($pax["sesso"] == "F") { ?>F<?php } ?>">
                        </td>
                        <td class="text-center"><?php echo date("d/m/Y", strtotime($pax["pax_dob"])) ?><input class="form-control w55 chooseDOB reqField hidden" id="pax_dob__<?php echo $pax["id_prenotazione"] ?>"name="pax_dob__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["pax_dob"])) ?>" /></td>
                        <td class="text-center td_nazionalita"><?php echo $pax["nazionalita"] ?><input class="form-control reqField hidden" id="nazionalita__<?php echo $pax["id_prenotazione"] ?>" name="nazionalita__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["nazionalita"] ?>" /></td>
                        <td class="text-center"><?php echo $pax["numero_documento"] ?><input class="form-control reqField hidden" id="numero_documento__<?php echo $pax["id_prenotazione"] ?>" name="numero_documento__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["numero_documento"] ?>" /></td>
                        <td class="text-center"><?php echo $pax["salute"] ?><input class="form-control hidden" id="salute__<?php echo $pax["id_prenotazione"] ?>" name="salute__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["salute"] ?>" /></td>
                        <td class="text-center td_share_room"><?php echo $pax["share_room"] ?><input class="form-control w40 hidden" id="share_room__<?php echo $pax["id_prenotazione"] ?>" name="share_room__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["share_room"] ?>" /></td>
                        <td class="text-center td_gl_rif"><?php echo $pax["gl_rif"] ?><input class="form-control hidden w30" id="gl_rif__<?php echo $pax["id_prenotazione"] ?>" name="gl_rif__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["gl_rif"] ?>" /></td>
                        <td class="text-center "><?php if ($pax["tipo_pax"] == 'GL') {
                                echo '--';
                            } else {
                                echo $pax["description"]; ?><input class="form-control hidden" id="suppl__<?php echo $pax["id_prenotazione"] ?>" name="suppl__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["plr_id"] ?>" /></td> <?php } ?>
                        <td class="text-center td_data_arrivo_campus"><?php echo date("d/m/Y", strtotime($pax["data_arrivo_campus"])) ?><input class="form-control w55 chooseDate1 reqField hidden" id="data_arrivo_campus__<?php echo $pax["id_prenotazione"] ?>"name="data_arrivo_campus__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["data_arrivo_campus"])) ?>" /></td>
                        <td class="text-center td_data_partenza_campus"><?php echo date("d/m/Y", strtotime($pax["data_partenza_campus"])) ?><input class="form-control w55 chooseDate2 reqField hidden" id="data_partenza_campus__<?php echo $pax["id_prenotazione"] ?>" name="data_partenza_campus__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["data_partenza_campus"])) ?>" /></td>									
                        <td class="text-center td_andata_data_arrivo"><?php echo date("d/m/Y", strtotime($pax["andata_data_arrivo"])) ?><input class="form-control w55 chooseDateTime1 reqField hidden" id="andata_data_arrivo__<?php echo $pax["id_prenotazione"] ?>"name="andata_data_arrivo__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["andata_data_arrivo"])) ?>" /></td>
                        <td class="text-center td_ora_arrivo_volo"><?php echo date("H:i", strtotime($pax["andata_data_arrivo"])) ?><input class="form-control w30 chooseTime1 reqField hidden" id="ora_arrivo_volo__<?php echo $pax["id_prenotazione"] ?>"name="ora_arrivo_volo__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo date("H:i", strtotime($pax["andata_data_arrivo"])) ?>" /></td>
                        <td class="text-center td_andata_apt_arrivo"><?php echo $pax["andata_apt_arrivo"] ?><input class="form-control w30 airport_ac reqField hidden" id="andata_apt_arrivo__<?php echo $pax["id_prenotazione"] ?>"name="andata_apt_arrivo__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["andata_apt_arrivo"] ?>" /></td>
                        <td class="text-center td_andata_volo"><?php echo $pax["andata_volo"] ?><input class="form-control w40 reqField hidden" id="andata_volo__<?php echo $pax["id_prenotazione"] ?>" name="andata_volo__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["andata_volo"] ?>" /></td>
                        <td class="text-center td_ritorno_data_partenza"><?php echo date("d/m/Y", strtotime($pax["ritorno_data_partenza"])) ?><input class="form-control w55 chooseDateTime2 reqField hidden" id="ritorno_data_partenza__<?php echo $pax["id_prenotazione"] ?>" name="ritorno_data_partenza__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["ritorno_data_partenza"])) ?>" /></td>
                        <td class="text-center td_ora_partenza_volo"><?php echo date("H:i", strtotime($pax["ritorno_data_partenza"])) ?><input class="form-control w30 chooseTime2 reqField hidden" id="ora_partenza_volo__<?php echo $pax["id_prenotazione"] ?>" name="ora_partenza_volo__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo date("H:i", strtotime($pax["ritorno_data_partenza"])) ?>" /></td>
                        <td class="text-center td_ritorno_apt_partenza"><?php echo $pax["ritorno_apt_partenza"] ?><input class="form-control w30 airport_ac reqField hidden" id="ritorno_apt_partenza__<?php echo $pax["id_prenotazione"] ?>" name="ritorno_apt_partenza__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["ritorno_apt_partenza"] ?>" /></td>
                                <td class="text-center td_ritorno_volo"><?php echo $pax["ritorno_volo"] ?><input class="form-control w40 reqField hidden" id="ritorno_volo__<?php echo $pax["id_prenotazione"] ?>" name="ritorno_volo__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["ritorno_volo"] ?>" /></td>		
                                <td class="text-center td_visa">
                                        <?php if ($pax["visa"] == 1) { ?><span class="glyphicon glyphicon-ok"><?php } else { ?><span class="glyphicon glyphicon-remove"></span> <?php } ?><input class="hidden" type="checkbox" id="visa__<?php echo $pax["id_prenotazione"] ?>" name="visa__<?php echo $pax["id_prenotazione"] ?>" <?php if ($pax["visa"] == 1) { ?>checked="checked"<?php } ?><?php if ($contarighe > 1) { ?> onclick="return false;" <?php } ?>></td>
                                        <td class="text-center td_andata_apt_partenza"><?php echo $pax["andata_apt_partenza"] ?><input class="form-control w40 airport_ac reqField hidden" airport_ac id="andata_apt_partenza__<?php echo $pax["id_prenotazione"] ?>" name="andata_apt_partenza__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["andata_apt_partenza"] ?>" /></td>
                                        <td class="text-center td_ritorno_apt_arrivo"><?php echo $pax["ritorno_apt_arrivo"] ?><input class="form-control w40 airport_ac reqField hidden" id="ritorno_apt_arrivo__<?php echo $pax["id_prenotazione"] ?>" name="ritorno_apt_arrivo__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["ritorno_apt_arrivo"] ?>" /></td>
                                        </tr>
        <?php
    } elseif ($pax["lockPax"] == 1) {
        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $pax["tipo_pax"] ?><br /><?php echo $pax["accomodation"] ?></td>
                                            <td class="text-center"><?php echo $pax["cognome"] ?></td>
                                            <td class="text-center"><?php echo $pax["nome"] ?></td>
                                            <td class="text-center">
        <?php if ($pax["sesso"] == "M") {
            echo 'M';
        } if ($pax["sesso"] == "F") {
            echo 'F';
        } ?>
                                            </td>
                                            <td class="text-center"><?php echo date("d/m/Y", strtotime($pax["pax_dob"])) ?></td>
                                            <td class="text-center td_nazionalita"><?php echo $pax["nazionalita"] ?></td>
                                            <td class="text-center"><?php echo $pax["numero_documento"] ?></td>
                                            <td class="text-center"><?php echo $pax["salute"] ?></td>
                                            <td class="text-center td_share_room"><?php echo $pax["share_room"] ?></td>
                                            <td class="text-center td_gl_rif"><?php echo $pax["gl_rif"] ?></td>
                                            <td class="text-center td_gl_rif"><?php echo $pax["tipo_pax"] == 'GL' ? '--' : $pax["description"] ?></td>
                                            <td class="text-center td_data_arrivo_campus"><?php echo date("d/m/Y", strtotime($pax["data_arrivo_campus"])) ?></td>
                                            <td class="text-center td_data_partenza_campus"><?php echo date("d/m/Y", strtotime($pax["data_partenza_campus"])) ?></td>									
                                            <td class="text-center td_andata_data_arrivo"><?php echo date("d/m/Y", strtotime($pax["andata_data_arrivo"])) ?></td>
                                            <td class="text-center td_ora_arrivo_volo"><?php echo date("H:i", strtotime($pax["andata_data_arrivo"])) ?></td>
                                            <td class="text-center td_andata_apt_arrivo"><?php echo $pax["andata_apt_arrivo"] ?></td>
                                            <td class="text-center td_andata_volo"><?php echo $pax["andata_volo"] ?></td>
                                            <td class="text-center td_ritorno_data_partenza"><?php echo date("d/m/Y", strtotime($pax["ritorno_data_partenza"])) ?></td>
                                            <td class="text-center td_ora_partenza_volo"><?php echo date("H:i", strtotime($pax["ritorno_data_partenza"])) ?></td>
                                            <td class="text-center td_ritorno_apt_partenza"><?php echo $pax["ritorno_apt_partenza"] ?></td>
                                            <td class="text-center td_ritorno_volo"><?php echo $pax["ritorno_volo"] ?></td>		
                                            <td class="text-center td_visa">
                                        <?php if ($pax["visa"] == 1) { ?><span class="glyphicon glyphicon-ok"><?php } else { ?><span class="glyphicon glyphicon-remove"></span> <?php } ?></td>
                                            <td class="text-center td_andata_apt_partenza"><?php echo $pax["andata_apt_partenza"] ?></td>
                                            <td class="text-center td_ritorno_apt_arrivo"><?php echo $pax["ritorno_apt_arrivo"] ?></td>
                                        </tr>
        <?php
    } else {
        if ($noLock == 1) {
            $idFirstLine1 = $pax["id_prenotazione"];
            $noLock += 1;
        }
        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $pax["tipo_pax"] ?><br /><?php echo $pax["accomodation"] ?></td>
                                            <td class="text-center"><input class="form-control w60 reqField" id="cognome__<?php echo $pax["id_prenotazione"] ?>" name="cognome__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["cognome"] ?>" /></td>
                                            <td class="text-center"><input class="form-control w60 reqField" id="nome__<?php echo $pax["id_prenotazione"] ?>" name="nome__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["nome"] ?>" /></td>
                                            <td class="text-center">
                                                <select id="sesso__<?php echo $pax["id_prenotazione"] ?>" name="sesso__<?php echo $pax["id_prenotazione"] ?>" style="font-size:10px;" class="reqField form-control w30">
                                                    <option value="">-</option>
                                                    <option value="M" <?php if ($pax["sesso"] == "M") { ?>selected<?php } ?>>M</option>
                                                    <option value="F" <?php if ($pax["sesso"] == "F") { ?>selected<?php } ?>>F</option>
                                                </select>
                                            </td>
                                            <td class="text-center"><input class="form-control w30 chooseDOB reqField" id="pax_dob__<?php echo $pax["id_prenotazione"] ?>"name="pax_dob__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["pax_dob"])) ?>" /></td>
                                            <td class="text-center td_nazionalita"><input class="form-control nationality_ac reqField" id="nazionalita__<?php echo $pax["id_prenotazione"] ?>" name="nazionalita__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["nazionalita"] ?>" /></td>
                                            <td class="text-center"><input class="form-control reqField" id="numero_documento__<?php echo $pax["id_prenotazione"] ?>" name="numero_documento__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["numero_documento"] ?>" /></td>
                                            <td class="text-center"><input class="form-control" id="salute__<?php echo $pax["id_prenotazione"] ?>" name="salute__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["salute"] ?>" /></td>
                                            <td class="text-center td_share_room"><input class="form-control w40" id="share_room__<?php echo $pax["id_prenotazione"] ?>" name="share_room__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["share_room"] ?>" /></td>
                                            <td class="text-center td_gl_rif"><input class="form-control w30" id="gl_rif__<?php echo $pax["id_prenotazione"] ?>" name="gl_rif__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["gl_rif"] ?>" /></td>
                                            <td class="text-center">
                                                    <?php
                                                    if (!empty($courseDetails) && $pax["tipo_pax"] != 'GL') {
                                                        ?>
                                                    <select id="suppl__<?php echo $pax["id_prenotazione"] ?>" name="suppl__<?php echo $pax["id_prenotazione"] ?>" style="font-size:10px;">
                                                        <option value="">Select</option>
                                                        <?php
                                                        foreach ($courseDetails as $course) {
                                                            if (($course['plr_id'] == $pax['plr_id'])) {
                                                                ?>
                                                                <option selected="selected" value="<?php echo $course['plr_id'] ?>"><?php echo $course['description'] ?></option>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <option value="<?php echo $course['plr_id'] ?>"><?php echo $course['description'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    </select>
            <?php
        } else {
            echo '--';
        }
        ?>
                                            </td>
                                            <td class="text-center td_data_arrivo_campus"><input class="form-control w55 chooseDate1 reqField" id="data_arrivo_campus__<?php echo $pax["id_prenotazione"] ?>"name="data_arrivo_campus__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["data_arrivo_campus"])) ?>" /></td>
                                            <td class="text-center td_data_partenza_campus"><input class="form-control w55 chooseDate2 reqField" id="data_partenza_campus__<?php echo $pax["id_prenotazione"] ?>" name="data_partenza_campus__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["data_partenza_campus"])) ?>" /></td>									
                                            <td class="text-center td_andata_data_arrivo"><input class="form-control w55 chooseDateTime1 reqField" id="andata_data_arrivo__<?php echo $pax["id_prenotazione"] ?>"name="andata_data_arrivo__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["andata_data_arrivo"])) ?>" /></td>
                                            <td class="text-center td_ora_arrivo_volo"><input class="form-control w30 chooseTime1 reqField" id="ora_arrivo_volo__<?php echo $pax["id_prenotazione"] ?>"name="ora_arrivo_volo__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo date("H:i", strtotime($pax["andata_data_arrivo"])) ?>" /></td>
                                            <td class="text-center td_andata_apt_arrivo"><input class="form-control w30 airport_ac reqField" id="andata_apt_arrivo__<?php echo $pax["id_prenotazione"] ?>"name="andata_apt_arrivo__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["andata_apt_arrivo"] ?>" /></td>
                                            <td class="text-center td_andata_volo"><input class="form-control w40 reqField" id="andata_volo__<?php echo $pax["id_prenotazione"] ?>" name="andata_volo__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["andata_volo"] ?>" /></td>
                                            <td class="text-center td_ritorno_data_partenza"><input class="form-control w55 chooseDateTime2 reqField" id="ritorno_data_partenza__<?php echo $pax["id_prenotazione"] ?>" name="ritorno_data_partenza__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["ritorno_data_partenza"])) ?>" /></td>
                                            <td class="text-center td_ora_partenza_volo"><input class="form-control w30 chooseTime2 reqField" id="ora_partenza_volo__<?php echo $pax["id_prenotazione"] ?>" name="ora_partenza_volo__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo date("H:i", strtotime($pax["ritorno_data_partenza"])) ?>" /></td>
                                            <td class="text-center td_ritorno_apt_partenza"><input class="form-control w30 airport_ac reqField" id="ritorno_apt_partenza__<?php echo $pax["id_prenotazione"] ?>" name="ritorno_apt_partenza__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["ritorno_apt_partenza"] ?>" /></td>
                                            <td class="text-center td_ritorno_volo"><input class="form-control w40 reqField" id="ritorno_volo__<?php echo $pax["id_prenotazione"] ?>" name="ritorno_volo__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["ritorno_volo"] ?>" /></td>		
                                            <td class="text-center td_visa"><input class="yesVisa" type="checkbox" id="visa__<?php echo $pax["id_prenotazione"] ?>" name="visa__<?php echo $pax["id_prenotazione"] ?>" <?php if ($pax["visa"] == 1) { ?>checked="checked"<?php } ?><?php if ($contarighe > 1) {
                                    if ($pax["id_prenotazione"] != $idFirstLine1) { ?> onclick="return false;" <?php }
                        } ?>></td>
                                            <td class="text-center td_andata_apt_partenza"><input class="form-control w40 airport_ac reqField" airport_ac id="andata_apt_partenza__<?php echo $pax["id_prenotazione"] ?>" name="andata_apt_partenza__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["andata_apt_partenza"] ?>" /></td>
                                            <td class="text-center td_ritorno_apt_arrivo"><input class="form-control w40 airport_ac reqField" id="ritorno_apt_arrivo__<?php echo $pax["id_prenotazione"] ?>" name="ritorno_apt_arrivo__<?php echo $pax["id_prenotazione"] ?>" type="text" value="<?php echo $pax["ritorno_apt_arrivo"] ?>" /></td>
                                        </tr>
        <?php
    }
    $contarighe++;
}
?>
    </tbody>
    </table>
    <input type="hidden" name="noChanges" id="noChanges" value="NOSEND" />
    </form>
    </div>
    </div>
    <script type="text/javascript">
        function writeValues(valore, cella){
            $(cella+" input").each(function(){
                $(this).val(valore);
            });
        }
        function writeCKValues(valore, cella){
            $(cella+" input").each(function(){
                $(this).prop('checked',valore);
            });
        }	
        
        $(document).ready(function(){
            
            $("#visa__<?php echo $idFirstLine1 ?>").click(function(){
                $(".yesVisa").each(function(){
                    $(this).prop("checked",$("#visa__<?php echo $idFirstLine1 ?>").prop('checked'));
                });
            });
            //$('#importPaxFile').fileInput();
            $( ".chooseDate1" ).datepicker({
                numberOfMonths: 1,
                dateFormat: "dd/mm/yy",
                onClose: function() {
                    var idToChange = $(this).attr("id").split("__");
                    changeIdIs="ritorno_data_partenza__"+idToChange[1];
                    dataGirata = parseDate($(this).val());
                    $( "#"+changeIdIs ).datepicker( "option", "minDate", new Date(dataGirata) );
                }
            });	
            $( ".chooseDate2" ).datepicker({
                numberOfMonths: 1,
                dateFormat: "dd/mm/yy",
                onClose: function() {
                    var idToChange = $(this).attr("id").split("__");
                    changeIdIs="andata_data_arrivo__"+idToChange[1];
                    dataGirata = parseDate($(this).val());
                    $( "#"+changeIdIs ).datepicker( "option", "maxDate", new Date(dataGirata) );
                }
            });			
            
            $( ".chooseDateTime1" ).datepicker({
                numberOfMonths: 1,
                dateFormat: "dd/mm/yy",
                autoSize: false
                //format: "dd/mm/yy HH:ii"
            });	
            $( ".chooseDateTime2" ).datepicker({
                numberOfMonths: 1,
                dateFormat: "dd/mm/yy",
                autoSize: false
                //format: "dd/mm/yy HH:ii"
            });		
            $( ".chooseTime1" ).timepicker({
                autoSize: false,
                format: "HH:ii"
            });	
            $( ".chooseTime2" ).timepicker({
                autoSize: false,
                format: "HH:ii"
            });			
            $(".airport_ac").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/agents/searchAP",
                        dataType: "json",
                        data: {
                            style: "full",
                            term: request.term
                        },
                        success: function( data ) {
                            response( $.map( data.airports, function( item ) {
                                return {
                                    id: item.id,
                                    label: item.value,
                                    value: item.value
                                }
                            }));
                        }
                    });					
                },
                minLength: 3
            });	

            $(".nationality_ac").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/agents/searchNat",
                        dataType: "json",
                        data: {
                            style: "full",
                            term: request.term
                        },
                        success: function( data ) {
                            response( $.map( data.nationalities, function( item ) {
                                return {
                                    id: item.id,
                                    label: item.value,
                                    value: item.value
                                }
                            }));
                        }
                    });					
                },
                minLength: 3
            });	

            $(document).on('blur', '.nationality_ac', function(){
                var elm = $(this);
                var nationality = elm.val();
                if(nationality != '' && typeof nationality != 'undefined'){
                    
                    $.post(siteUrl+'agents/checkTypedNationality',{nationality: nationality},function(data){
                        if(data != 1){
                            elm.val('');
                        }
                    });
                }
            });
            $(document).on('mouseover', 'a.ui-corner-all', function(e){
                e.preventDefault();
                $('.nationality_ac:focus').val($(this).html());
            });

            $("#copyFirst").click(function(){
                campi = new Array("andata_apt_arrivo","ritorno_apt_partenza","andata_data_arrivo","data_partenza_campus","data_arrivo_campus","ritorno_data_partenza","andata_volo","ritorno_volo","gl_rif","ora_arrivo_volo","ora_partenza_volo","andata_apt_partenza", "ritorno_apt_arrivo");
                for(index=0;index<campi.length;index++){
                    nomecampo = campi[index];
                    valorecampo = $("#"+nomecampo+"__<?php echo $idFirstLine ?>").val();
                    writeValues(valorecampo,"td.td_"+campi[index]);
                }
                /*campiCheck = new Array("transfer_in","transfer_out");
                for(index=0;index<campiCheck.length;index++){
                    nomecampo = campiCheck[index];
                    valorecampo = $("#"+nomecampo+"__<?php echo $idFirstLine ?>").prop('checked');
                    writeCKValues(valorecampo,"td.td_"+campiCheck[index]);
                }	*/		
            });
            
            
            $( ".chooseDOB" ).datepicker({
                numberOfMonths: 1,
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                changeYear: true
            });	

        });

        function parseDate(str) {
            var mdy = str.split('/')
            return new Date(mdy[2], mdy[1]-1, mdy[0]);
        }
        $(document).on('keyup keydown blur','input[type=text]', function(){
            if($(this).hasClass('ui-autocomplete-loading')){
                $(this).removeClass('ui-autocomplete-loading');
            }
        });

        function validateFile(){
            var fileInput = $.trim($("#importPaxFile").val());
            if (!fileInput || fileInput == '') {      
                swal("Error",'Please select excel file to upload');
                return false;    
            }
            else{
                return true;
            }
        }
    </script>