<div class="row">
    <div class="col-md-12">
        <div class="row form-group">
            <div class="col-md-12">
                <label >Login url: <?php echo base_url();?>index.php/vauth/students</label>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <label >Please add new email address if required(comma `,` separated if multiple).</label>
                <input type="text" class="form-control" maxlength="255" id="txtEmailAddressForStudentsLoginDetail" name="txtEmailAddressForStudentsLoginDetail" value="" />
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <input type="button" id="btnSendEmailToAgents" class="btn btn-primary" value="Send list by email" />
            </div>
        </div>
    </div>
    <div id="tblStdList" class="col-md-12 mr-top-10">
        <table style="width:100%" cellspacing="1" class="datatable table table-bordered table-hover vertical-middle" >
            <thead>
                <tr>
                    <th style="text-align: left;" class="text-center">#</th>
                    <th style="text-align: left;">First name</th>
                    <th style="text-align: left;">Last name</th>
                    <th style="text-align: left;">Date of birth</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $counter = 1;
                    foreach ($detMyPax as $mypax) {
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $counter++ ?></td>
                            <td class="infoPax">
                                <span class="infoName"><?php echo $mypax["nome"];?></span>
                            </td>
                            <td class="infoPax">
                                <span class="infoName"><?php echo $mypax["cognome"];?></span>
                            </td>
                            <td class="infoPax">
                                <span class="infoName"><?php echo date("d/m/Y", strtotime($mypax["pax_dob"]));?></span>
                            </td>
                        </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>