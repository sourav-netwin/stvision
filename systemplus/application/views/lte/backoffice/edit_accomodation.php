<div class="row">
    <form id="frmEditAccmodation">
        <input type="hidden" value="0" id="markAll" name="markAll" />
        <input type="hidden" value="0" id="hiddBookId" name="hiddBookId" />
        <div class="col-md-12 row">
            <div class="col-sm-4">
                <label>Select for all</label>
                <select id="selAccAll" name="selAccAll" class="form-control">
                    <option value="">Select accommodation</option>
                    <?php 
                    if($accoS)
                    foreach ($accoS as $acco) { ?>
                            <option value="<?php echo strtolower($acco["sistemazione"]); ?>" ><?php echo $acco["sistemazione"]; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-4 mr-top-25">
                <button id="btnUpdateAccAll" type="button" class="btn btn-primary" >Update</button>
            </div>
        </div>
        <div class="col-md-12 mr-top-10">
            <table class="datatable table table-bordered table-hover vertical-middle" >
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Gender</th>
                        <th class="text-center">Accommodation</th>
                        <th class="text-center">Action</th>
                    </tr>
                    
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" >
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btnUpdateAccMulitiple" >Update selected</button>
                        </td>
                    </tr>
                    <?php 
                    $counter = 1;
                        foreach ($detMyPax as $mypax) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $counter++ ?></td>
                                <td class="infoPax"><span <?php if ($mypax["tipo_pax"] == "GL") { ?> class="tdGl infoName" <?php
                                    } else {
                                        ?> class="infoName" <?php } ?>><?php echo $mypax["cognome"] ?> <?php echo $mypax["nome"] ?></span><?php echo ($mypax["lockPax"] == 1 OR $isFlocked == 1) ? '&nbsp<span title="Roster locked" class="locked fa fa-lock" style="font-size:9px; cursor: default !important;"></span>' : '' ?><br />DOB: <?php echo date("d/m/Y", strtotime($mypax["pax_dob"])) ?> - DOC#: <?php echo $mypax["numero_documento"] ?></td>
                                <td class="text-center info35"><small class="label bg-grey"><?php echo $mypax["tipo_pax"] ?></small></td>
                                <td class="text-center info20"><small class="label bg-grey"><?php echo $mypax["sesso"] ?></small></td>
                                <td class="text-center infoAcco"><?php echo $mypax["accomodation"] ?></td>
                                <td>
                                    <select id="selAcc_<?php echo $mypax['id_prenotazione'];?>" name="selectAcc[<?php echo $mypax['id_prenotazione'];?>]" class="mapValues form-control">
                                        <option value="">Select accommodation</option>
                                        <?php 
                                        if($accoS)
                                        foreach ($accoS as $acco) { ?>
                                                <option value="<?php echo strtolower($acco["sistemazione"]); ?>" <?php if ($mypax["accomodation"] == strtolower($acco["sistemazione"])) { ?>selected<?php } ?>><?php echo $acco["sistemazione"]; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                    <?php }?>
                    <tr>
                        <td colspan="5" >
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btnUpdateAccMulitiple" >Update selected</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>