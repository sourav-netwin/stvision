<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<?php $pageType = $this->uri->segment(2);
    if($pageType == 'profilereview'){
        // this is profile review 
    }
    else{
        $pageType = 'cvreview';
    }
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
        <div class="box">
            <div class="box-header col-sm-12">
                <div class="row">
                    <?php showSessionMessageIfAny($this);?>
                </div>
            </div>
            <div class="box-body">
                <div class="mr-bot-10">
                    <form action="<?php echo base_url().'index.php/teachers/exportreview';?>" method="post">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <label for="selNationality">Nationality:</label>
                        <select class="form-control" id="selNationality" name="selNationality"  >
                            <option value="">All</option>
                            <option value="afghan">Afghan</option>
                            <option value="albanian">Albanian</option>
                            <option value="algerian">Algerian</option>
                            <option value="american">American</option>
                            <option value="andorran">Andorran</option>
                            <option value="angolan">Angolan</option>
                            <option value="antiguans">Antiguans</option>
                            <option value="argentinean">Argentinean</option>
                            <option value="armenian">Armenian</option>
                            <option value="australian">Australian</option>
                            <option value="austrian">Austrian</option>
                            <option value="azerbaijani">Azerbaijani</option>
                            <option value="bahamian">Bahamian</option>
                            <option value="bahraini">Bahraini</option>
                            <option value="bangladeshi">Bangladeshi</option>
                            <option value="barbadian">Barbadian</option>
                            <option value="barbudans">Barbudans</option>
                            <option value="batswana">Batswana</option>
                            <option value="belarusian">Belarusian</option>
                            <option value="belgian">Belgian</option>
                            <option value="belizean">Belizean</option>
                            <option value="beninese">Beninese</option>
                            <option value="bhutanese">Bhutanese</option>
                            <option value="bolivian">Bolivian</option>
                            <option value="bosnian">Bosnian</option>
                            <option value="brazilian">Brazilian</option>
                            <option value="british">British</option>
                            <option value="bruneian">Bruneian</option>
                            <option value="bulgarian">Bulgarian</option>
                            <option value="burkinabe">Burkinabe</option>
                            <option value="burmese">Burmese</option>
                            <option value="burundian">Burundian</option>
                            <option value="cambodian">Cambodian</option>
                            <option value="cameroonian">Cameroonian</option>
                            <option value="canadian">Canadian</option>
                            <option value="cape verdean">Cape Verdean</option>
                            <option value="central african">Central African</option>
                            <option value="chadian">Chadian</option>
                            <option value="chilean">Chilean</option>
                            <option value="chinese">Chinese</option>
                            <option value="colombian">Colombian</option>
                            <option value="comoran">Comoran</option>
                            <option value="congolese">Congolese</option>
                            <option value="costa rican">Costa Rican</option>
                            <option value="croatian">Croatian</option>
                            <option value="cuban">Cuban</option>
                            <option value="cypriot">Cypriot</option>
                            <option value="czech">Czech</option>
                            <option value="danish">Danish</option>
                            <option value="djibouti">Djibouti</option>
                            <option value="dominican">Dominican</option>
                            <option value="dutch">Dutch</option>
                            <option value="east timorese">East Timorese</option>
                            <option value="ecuadorean">Ecuadorean</option>
                            <option value="egyptian">Egyptian</option>
                            <option value="emirian">Emirian</option>
                            <option value="equatorial guinean">Equatorial Guinean</option>
                            <option value="eritrean">Eritrean</option>
                            <option value="estonian">Estonian</option>
                            <option value="ethiopian">Ethiopian</option>
                            <option value="fijian">Fijian</option>
                            <option value="filipino">Filipino</option>
                            <option value="finnish">Finnish</option>
                            <option value="french">French</option>
                            <option value="gabonese">Gabonese</option>
                            <option value="gambian">Gambian</option>
                            <option value="georgian">Georgian</option>
                            <option value="german">German</option>
                            <option value="ghanaian">Ghanaian</option>
                            <option value="greek">Greek</option>
                            <option value="grenadian">Grenadian</option>
                            <option value="guatemalan">Guatemalan</option>
                            <option value="guinea-bissauan">Guinea-Bissauan</option>
                            <option value="guinean">Guinean</option>
                            <option value="guyanese">Guyanese</option>
                            <option value="haitian">Haitian</option>
                            <option value="herzegovinian">Herzegovinian</option>
                            <option value="honduran">Honduran</option>
                            <option value="hungarian">Hungarian</option>
                            <option value="icelander">Icelander</option>
                            <option value="indian">Indian</option>
                            <option value="indonesian">Indonesian</option>
                            <option value="iranian">Iranian</option>
                            <option value="iraqi">Iraqi</option>
                            <option value="irish">Irish</option>
                            <option value="israeli">Israeli</option>
                            <option value="italian">Italian</option>
                            <option value="ivorian">Ivorian</option>
                            <option value="jamaican">Jamaican</option>
                            <option value="japanese">Japanese</option>
                            <option value="jordanian">Jordanian</option>
                            <option value="kazakhstani">Kazakhstani</option>
                            <option value="kenyan">Kenyan</option>
                            <option value="kittian and nevisian">Kittian and Nevisian</option>
                            <option value="kuwaiti">Kuwaiti</option>
                            <option value="kyrgyz">Kyrgyz</option>
                            <option value="laotian">Laotian</option>
                            <option value="latvian">Latvian</option>
                            <option value="lebanese">Lebanese</option>
                            <option value="liberian">Liberian</option>
                            <option value="libyan">Libyan</option>
                            <option value="liechtensteiner">Liechtensteiner</option>
                            <option value="lithuanian">Lithuanian</option>
                            <option value="luxembourger">Luxembourger</option>
                            <option value="macedonian">Macedonian</option>
                            <option value="malagasy">Malagasy</option>
                            <option value="malawian">Malawian</option>
                            <option value="malaysian">Malaysian</option>
                            <option value="maldivan">Maldivan</option>
                            <option value="malian">Malian</option>
                            <option value="maltese">Maltese</option>
                            <option value="marshallese">Marshallese</option>
                            <option value="mauritanian">Mauritanian</option>
                            <option value="mauritian">Mauritian</option>
                            <option value="mexican">Mexican</option>
                            <option value="micronesian">Micronesian</option>
                            <option value="moldovan">Moldovan</option>
                            <option value="monacan">Monacan</option>
                            <option value="mongolian">Mongolian</option>
                            <option value="moroccan">Moroccan</option>
                            <option value="mosotho">Mosotho</option>
                            <option value="motswana">Motswana</option>
                            <option value="mozambican">Mozambican</option>
                            <option value="namibian">Namibian</option>
                            <option value="nauruan">Nauruan</option>
                            <option value="nepalese">Nepalese</option>
                            <option value="new zealander">New Zealander</option>
                            <option value="ni-vanuatu">Ni-Vanuatu</option>
                            <option value="nicaraguan">Nicaraguan</option>
                            <option value="nigerien">Nigerien</option>
                            <option value="north korean">North Korean</option>
                            <option value="northern irish">Northern Irish</option>
                            <option value="norwegian">Norwegian</option>
                            <option value="omani">Omani</option>
                            <option value="pakistani">Pakistani</option>
                            <option value="palauan">Palauan</option>
                            <option value="panamanian">Panamanian</option>
                            <option value="papua new guinean">Papua New Guinean</option>
                            <option value="paraguayan">Paraguayan</option>
                            <option value="peruvian">Peruvian</option>
                            <option value="polish">Polish</option>
                            <option value="portuguese">Portuguese</option>
                            <option value="qatari">Qatari</option>
                            <option value="romanian">Romanian</option>
                            <option value="russian">Russian</option>
                            <option value="rwandan">Rwandan</option>
                            <option value="saint lucian">Saint Lucian</option>
                            <option value="salvadoran">Salvadoran</option>
                            <option value="samoan">Samoan</option>
                            <option value="san marinese">San Marinese</option>
                            <option value="sao tomean">Sao Tomean</option>
                            <option value="saudi">Saudi</option>
                            <option value="scottish">Scottish</option>
                            <option value="senegalese">Senegalese</option>
                            <option value="serbian">Serbian</option>
                            <option value="seychellois">Seychellois</option>
                            <option value="sierra leonean">Sierra Leonean</option>
                            <option value="singaporean">Singaporean</option>
                            <option value="slovakian">Slovakian</option>
                            <option value="slovenian">Slovenian</option>
                            <option value="solomon islander">Solomon Islander</option>
                            <option value="somali">Somali</option>
                            <option value="south african">South African</option>
                            <option value="south korean">South Korean</option>
                            <option value="spanish">Spanish</option>
                            <option value="sri lankan">Sri Lankan</option>
                            <option value="sudanese">Sudanese</option>
                            <option value="surinamer">Surinamer</option>
                            <option value="swazi">Swazi</option>
                            <option value="swedish">Swedish</option>
                            <option value="swiss">Swiss</option>
                            <option value="syrian">Syrian</option>
                            <option value="taiwanese">Taiwanese</option>
                            <option value="tajik">Tajik</option>
                            <option value="tanzanian">Tanzanian</option>
                            <option value="thai">Thai</option>
                            <option value="togolese">Togolese</option>
                            <option value="tongan">Tongan</option>
                            <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                            <option value="tunisian">Tunisian</option>
                            <option value="turkish">Turkish</option>
                            <option value="tuvaluan">Tuvaluan</option>
                            <option value="ugandan">Ugandan</option>
                            <option value="ukrainian">Ukrainian</option>
                            <option value="uruguayan">Uruguayan</option>
                            <option value="uzbekistani">Uzbekistani</option>
                            <option value="venezuelan">Venezuelan</option>
                            <option value="vietnamese">Vietnamese</option>
                            <option value="welsh">Welsh</option>
                            <option value="yemenite">Yemenite</option>
                            <option value="zambian">Zambian</option>
                            <option value="zimbabwean">Zimbabwean</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <label for="selSex">Gender:</label>
                        <select class="form-control" id="selSex" name="selSex"  >
                            <option value="">All</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <label for="selAgeRangeFrom">Age range from (in Year):</label>
                        <select class="form-control" id="selAgeRangeFrom" name="selAgeRangeFrom"  >
                            <option value="">Select</option>
                            <?php 
                            for($age = 18; $age < 65; $age++){
                                ?><option value="<?php echo $age;?>"><?php echo $age;?></option><?php 
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <label for="selAgeRangeTo">Age range to (in Year):</label>
                        <select class="form-control" id="selAgeRangeTo" name="selAgeRangeTo"  >
                            <option value="">Select</option>
                            <?php 
                            for($age = 19; $age <= 65; $age++){
                                ?><option value="<?php echo $age;?>"><?php echo $age;?></option><?php 
                            }
                            ?>
                        </select>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <label for="selAgeRangeTo">Age range to (in Year):</label>
                        <select class="form-control" id="selAgeRangeTo" name="selAgeRangeTo"  >
                            <option value="">Select</option>
                            <?php 
                            for($age = 19; $age <= 65; $age++){
                                ?><option value="<?php echo $age;?>"><?php echo $age;?></option><?php 
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-9">
                        <label for="selDiplomas">Diplomas:</label>
                        <select class="form-control" multiple id="selDiplomas" name="selDiplomas"  >
                            <option value="celta">CELTA</option>
                            <option value="trinity_tesol">Trinity TESOL</option>
                            <option value="delta">DELTA</option>
                            <option value="dip_tesol">Dip. TESOL</option>
                            <option value="b_ed">B.Ed.</option>
                            <option value="pgce">PGCE (Primary, English or MFL)</option>
                            <option value="ma_elt_tesol">MA in ELT//TESOL</option>
                            <!--<option value="other_diploma">Other</option>-->
                        </select>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <label for="selTeachYears">Teach years:</label>
                        <select class="form-control" id="selTeachYears" name="selTeachYears"  >
                            <option value="">All</option>
                            <option value="1-2 years">1-2 years</option>
                            <option value="3-5 years">3-5 years</option>
                            <option value="6-9 years">6-9 years</option>
                            <option value="more than 10 years">more than 10 years</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <label for="selPostCode">Postcode:</label>
                        <select class="form-control" id="selPostCode" name="selPostCode"  >
                            <option value="">All</option>
                            <?php if($postcodeData){
                                    foreach($postcodeData as $postcode){
                                        ?><option value="<?php echo $postcode['code'];?>"><?php echo $postcode['area'];?></option><?php 
                                    }
                            }?>
                        </select>
                    </div>
                    
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <label for="txtName">Name:</label>
                        <input class="form-control" maxlength="100" type="text" id="txtName" name="txtName" value="" />
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <label for="txtCalFromDate">Available date from:</label>
                        <input class="form-control" type="text" id="txtCalFromDate" name="fd" value="" />
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <label for="txtCalToDate">Available date to:</label>
                        <input class="form-control" type="text" id="txtCalToDate" name="td" value="" /> 
                    </div>
                    <?php if($pageType == 'profilereview'){?>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <label for="selIntLevel">Interview level:</label>
                        <select class="form-control" id="selIntLevel" name="selIntLevel">
                            <option value="">Select level</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <label for="selRegVerified">Reference checked:</label>
                        <select class="form-control" id="selRegVerified" name="selRegVerified">
                            <option value="">All</option>
                            <option value="1">Verified</option>
                            <option value="0">To be verify</option>
                        </select>
                    </div>
                    <?php }?>
                    <div class="col-sm-6 col-md-6 col-lg-3 mr-top-25">
                        <input type="hidden" name="hiddPageType" value="<?php echo $pageType;?>" />
                        <input class="btn btn-primary" id="btnSearchApplication" type="button" value="Search" >
                        <input class="btn btn-danger" id="btnClear" type="reset" value="Clear" >
                        <input class="btn btn-primary pull-right" id="btnExport" type="submit" value="Export" >
                    </div>
                    </div>
            </form>
            </div>
            
            <hr />
            <div class="row">
                <div class="col-sm-12">
                    <table class="datatable table table-bordered table-striped vertical-middle" width="99.9%" >
                        <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Teacher</th>
                                    <th>Gender</th>
                                    <th>Email</th>								
                                    <th>Date of birth</th>
                                    <th>Available from</th>
                                    <th>Available to</th>
                                    <th>Nationality</th>
                                    <?php if($pageType == "profilereview"){
                                        ?>
                                        <th>Offer sent</th>
                                        <?php 
                                    }?>
                                    <th class="no-sort">Action</th>
                                </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($teachers_app)
                        foreach($teachers_app as $teacher){

                            $reviewActions = "";
                            if($pageType == 'profilereview')
                            {
                                $reviewActions = '
                                    <div class="btn-group">
                                        <a title="Interview Info" href="javascript:void(0);" data-toggle="tooltip" data-id="'.$teacher["ta_id"].'" class="dialog-interview btn btn-xs btn-info" ><i class="fa fa-user"> Interview</i></a>    
                                    </div>
                                    <div class="btn-group">
                                        <a title="Send job offer letter" href="javascript:void(0);" data-toggle="tooltip" data-id="'.$teacher["ta_id"].'" data-name="'.$teacher["teacher_full_name"].'" class="sendjoboffer_link btn btn-xs btn-danger" ><i class="fa fa-file"> Send job offer letter</i></a>        
                                    </div>
                                    <div class="btn-group">
                                        <a title="View" data-toggle="tooltip" data-id="'.$teacher["ta_id"].'" data-read="'.$teacher['ta_read_cv'].'" href="javascript:void(0);" class="min-wd-24 dialogbtn btn btn-xs btn-primary read'.$teacher['ta_read_cv'].'" ><i class="fa fa-eye"></i></a>        
                                        <a title="Edit" data-toggle="tooltip" href="'.base_url().'index.php/teachers/editapp/'.$teacher["ta_id"].'" class="min-wd-24 edit-application btn btn-xs btn-warning" ><i class="fa fa-edit"></i></a>        
                                    </div>
                                    <div class="btn-group"> 
                                        <a title="Send available positions" href="javascript:void(0);" data-toggle="tooltip" data-id="'.$teacher["ta_id"].'" data-name="'.$teacher["teacher_full_name"].'" class="btnSendAdvOfferFromInterview btn btn-xs btn-danger" ><i class="fa fa-file"> Send positions</i></a>        
                                    </div>
                                    ';
                            }
                            else
                            {
                                $reviewActions = '
                                <div class="btn-group">
                                    <a title="View" data-toggle="tooltip" data-id="'.$teacher["ta_id"].'" data-read="'.$teacher['ta_read_cv'].'" href="javascript:void(0);" class="min-wd-24 dialogbtn btn btn-xs btn-primary read'.$teacher['ta_read_cv'].'" ><i class="fa fa-eye"></i></a>
                                    <a title="Edit" data-toggle="tooltip" href="'.base_url().'index.php/teachers/editapp/'.$teacher["ta_id"].'" class="min-wd-24 edit-application btn btn-xs btn-warning" ><i class="fa fa-edit"></i></a>    
                                </div>
                                ';
                            }

                        ?>
                                <tr>
                                    <td ><?php echo $teacher["ta_id"];?></td>
                                    <td >
                                        <?php echo html_entity_decode($teacher["teacher_full_name"]);?>
                                    </td>
                                    <td ><?php echo $teacher["ta_sex"];?></td>
                                    <td ><?php echo $teacher["ta_email"];?></td>
                                    <td ><?php echo printDate($teacher["ta_date_of_birth"],"d/m/Y");?></td>
                                    <td ><?php echo date('d/m/Y',strtotime($teacher["ta_ablility_from"]));?></td>
                                    <td ><?php echo date('d/m/Y',strtotime($teacher["ta_ablility_to"]));?></td>
                                    <td ><?php echo ucwords($teacher["ta_nationality"]);?></td>
                                    <?php if($pageType == "profilereview"){
                                        ?>
                                    <td ><?php echo $teacher["offers_sent"];?></td>
                                    <?php }?>
                                    <td class="center operation">
                                        <?php echo $reviewActions;?>
                                    </td>
                                </tr>
                        <?php
                                }
                        ?>
                        </tbody>
                </table>
                </div>
            </div>
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
<style>
            .star-red{
                color:red;
            }
        </style>
<!--Send available positions-->
<!--<div style="display: none;" id="dialog_modal_appdetails" title="" class="windia-teacher">-->
<div id="dialog_modal_appdetails" class="modal">
    <div class="modal-dialog modal-lg-95-per">
        <div class="modal-content">
        <div class="modal-header">
            <button aria-label="Close" onclick="$('#dialog_modal_appdetails').modal('hide');"  class="close" type="button">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Teacher detail</h4>
        </div>
        <div id="teacherDetail" class="modal-body">
            
        </div>
        <div class="modal-footer">
            <button  onclick="$('#dialog_modal_appdetails').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
            <?php if($pageType == 'cvreview'){?>
            <button id="btnSendAdvOffer" class="btn btn-primary pull-right" type="button">Send available positions</button>
            <?php }?>
        </div>
        <!-- /.modal-content -->
        </div>
    <!-- /.modal-dialog -->
    </div>
</div>

<!--<div style="display: none;" id="dialog_modal_interview" title="" class="windia-interview">-->
<div id="dialog_modal_interview" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button aria-label="Close" onclick="$('#dialog_modal_interview').modal('hide');"  class="close" type="button">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Interview information</h4>
        </div>
        <div id="interviewInfoDiv" class="modal-body">
        <form method="post" id="frmTeacher" action="">
        <div class="form-group row">
            <label class="col-sm-3 control-label" for="txtSkypename">Skype name</label>
            <div class="col-sm-9">
                <input type="text" id="" name="txtSkypename" class="form-control required" maxlength="100" value="" >
                <div class="error" for="txtSkypename" generated="true"></div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 control-label" for="txtInterviewNotes">Notes</label>
            <div class="col-sm-9">
                <textarea id="txtInterviewNotes" class="form-control" name="txtInterviewNotes" ></textarea>
                <div class="error" for="txtInterviewNotes" generated="true"></div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 control-label" for="txtStrong">Strong</label>
            <div class="col-sm-9">
                <textarea id="txtStrong" name="txtStrong" class="form-control" ></textarea>
                <div class="error" for="txtStrong" generated="true"></div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 control-label" for="txtWeek">Weak</label>
            <div class="col-sm-9">
                <textarea id="txtWeek" name="txtWeek" class="form-control" ></textarea>
                <div class="error" for="txtWeek" generated="true"></div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 control-label" for="selInterviewLevel">Interview level</label>
            <div class="col-sm-9">
                <select class="form-control" id="selInterviewLevel">
                    <option value="">Select level</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                </select>
                <br />
                <input type="checkbox" value="1" id="chkCheckReferences" />
                <label for="chkCheckReferences">Check references</label>
                &nbsp;&nbsp;
                <input type="checkbox" value="1" id="chkReturnee" />
                <label for="chkReturnee">Returnee</label>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 control-label">&nbsp;</label>
            <div class="col-sm-9">
                <input type="hidden" id="hiddInterviewTeacher" name="hiddInterviewTeacher" value="0" />
                <input class="btn btn-primary" type="button" id="btnUpdateInterview" name="btnUpdateInterview" value="Submit" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-offset-3 col-md-9">
                <div style="margin-top: 4px!important" id="interview-form-message" >
                    &nbsp;
                </div>
            </div>
        </div>
        </form>
        </div><!-- body -->
        <div class="modal-footer">
        </div>
</div>
</div>
</div>


<!--<div style="display: none;" id="sendjoboffer_dialog_popup" title="Send job offer letter" class="sendjoboffer_dialog scrollable-div">-->
    <div id="sendjoboffer_dialog_popup" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button aria-label="Close" onclick="$('#sendjoboffer_dialog_popup').modal('hide');"  class="close" type="button">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Send job offer letter</h4>
        </div>
        <div id="interviewInfoDiv" class="modal-body">
            <form method="post" id="frmJobOffer" action="">
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="applicant">Applicant</label>
                    <div class="col-sm-9">
                        <label id="lblCandidate">-- --</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="selPosition">Position<span class="star-red">*</span></label>
                    <div class="col-sm-9">
                        <select class="form-control" autocomplete="off" id="selPosition" name="selPosition" >
                            <option value="">Select Position</option>
                            <?php 
                                if(isset($positionData))
                                if($positionData)
                                {
                                    foreach($positionData as $position){
                                        ?>
                                        <option value="<?php echo $position['pos_id'];?>"><?php echo $position['pos_position'];?></option>
                                        <?php 
                                    }
                                }
                            ?>
                        </select>
                        <div class="error" for="selPosition" generated="true"></div>
                    </div>
                </div>
                <div style="display:none;" id="rowType" class="form-group row">
                    <label class="col-sm-3 control-label" for="selType">Type<span class="star-red">*</span></label>
                    <div class="col-sm-9">
                        <select class="form-control" autocomplete="off" id="selType" name="selType" >
                                <option value="">Select Type</option>
                                <option value="London">London</option>
                                <option value="Non London">Non London</option>
                                <option value="Academy">Academy</option>
                                <option value="Non-res horizontal zig zag">Non-res horizontal zig zag</option>
                                <option value="Dublin">Dublin</option>
<!--                                <option value="Academy 1">Academy 1</option>
                                <option value="Academy 2">Academy 2</option>-->
                            </select>
                        <div class="error" for="selType" generated="true"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="selCurrency">Currency<span class="star-red">*</span></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="selCurrency" name="selCurrency" >
                                <option value="">Select Currency</option>
                                <option value="GBP">GBP</option>
                                <option value="EUR">EUR</option>
                                <option value="USD">USD</option>
                            </select>
                        <div class="error" for="selCurrency" generated="true"></div>
                    </div>
                </div>
                <div style="display:none;" id="rowWages" class="form-group row">
                    <label class="col-sm-3 control-label" for="selWages">Wage type<span class="star-red">*</span></label>
                    <div class="col-sm-9">
                        <select class="form-control"  id="selWages" name="selWages" >
                                <option value="">Select Wage</option>
                                <option value="Hourly">Hourly</option>
                                <option value="Weekly">Weekly</option>
                        </select>
                        <div class="error" for="selWages" generated="true"></div>
                    </div>
                </div>
                <div style="display:none;" id="rowRate" class="form-group row">
                    <label class="col-sm-3 control-label" for="selRate">Rate<span class="star-red">*</span></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="selRate" name="selRate" >
                            <option value="">Select Rate</option>
                            <?php 
                                for($rateInx = 13;$rateInx <= 28;$rateInx++)
                                {
                                    ?>
                                        <option value="<?php echo $rateInx;?>"><?php echo $rateInx;?></option>
                                    <?php
                                }
                            ?>
                        </select>
                        <div class="error" for="selRate" generated="true"></div>
                    </div>
                </div>
                <div style="display:none;" id="rowResidential" class="form-group row">
                    <label class="col-sm-3 control-label" for="selResOrNon">Res/Non Res<span class="star-red">*</span></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="selResOrNon" name="selResOrNon" >
                                <option value="">Select Res/Non Res</option>
                                <option value="Residential">Residential</option>
                                <option value="Non-residential">Non-residential</option>
                            </select>
                        <div class="error" for="selResOrNon" generated="true"></div>
                    </div>
                </div>
                <div style="display:none;" id="rowDramSession" class="form-group row">
                    <label class="col-sm-3 control-label" for="chkDramaSession">Drama session<span class="star-red"></span></label>
                    <div class="col-sm-9">
                        <input type="checkbox" id="chkDramaSession" name="chkDramaSession" value="1" autocomplete="off" />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-offset-3 col-sm-9">
                        <input type="hidden" id="hiddJobOfferTeacher" name="hiddJobOfferTeacher" value="0" />
                        <input class="btn btn-primary" type="button" id="btnSendJobOffer" name="btnSendJobOffer" value="Send offer" />
                        <input class="btn btn-danger" type="reset" id="btnJobCancel" name="btnJobCancel" value="Cancel" />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-offset-3 col-sm-9">
                        <div id="joboffer-form-message">
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="modal-header col-sm-12 mr-bot-10">
                    <h4 class="modal-title">Job offer sent history</h4>
                </div>
                <div id="jobOfferListingData" class="col-sm-12">
                    <!-- JOB OFFER HISTORY WILL LAND HERE... -->
                </div>
            </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo LTE; ?>plugins/select2/select2.full.min.js"></script>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<script>
    function iCheckInit(){
        $('[type=checkbox]').iCheck('destroy'); 
        $('[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '10%' // optional
        });
    }
    $(document).ready(function() {
        iCheckInit();
        $('#selDiplomas').select2({
            dropdownAutoWidth : true,
            width: '100%'
        });
        /*
         $("#selCompanies").val(valarray).trigger('change');
         $("#selCompanies").val('').trigger('change');
         **/
        
           //$("a.read0").parent().parent().find('td').css('background','#ffe5e5');
           $("a.read0").parent().parent().parent().find('td').css('background','#ffe5e5');
           $( "body" ).on( "click", ".paginate_button", function() {
               $("a.read0").parent().parent().parent().find('td').css('background','#ffe5e5');
           });
           $( "body" ).on( "click", "tr th", function() {
               $("a.read0").parent().parent().parent().find('td').css('background','#ffe5e5');
           });
           
           
            var SITE_PATH = siteUrl;
                
                <?php $pageType = $this->uri->segment(2);
                if($pageType == 'profilereview'){
                    // this is profile review 
                }
                else{
                    $pageType = 'cvreview';
                }
                ?>
                $(".toggleFilter").hide();
                
                $("#btnClear").click(function(){
                    //window.location.href = "<?php //echo base_url().'index.php/teachers/review';?>";
                    setTimeout(function(){$("#btnSearchApplication").trigger('click');},'500');
                });


                $( ".windia-interview" ).dialog({
                    autoOpen: false,
                    modal: true,
                    hide: "",
                    show: "",
                    width : '50%',
                    height : 710,
                    buttons: [{
                            text: "Close",
                            click: function() { $(this).dialog("close"); }
                    }]
                });
                
                $( "body" ).on( "click", ".dialog-interview", function() {
                    $("#interview-form-message").removeClass('tuition_error');
                    $("#interview-form-message").removeClass('tuition_success');
                    $("#interview-form-message").html(' ');
                    
                    var id = $(this).attr('data-id');
                    $("#selInterviewLevel_chzn").width('100px');
                    $("#hiddInterviewTeacher").val(id);
                    $("#dialog_modal_interview").modal("show");
                    $.post( "<?php echo base_url();?>index.php/teachers/getinterviewdetail",{
                            'teach_app_id':id
                        }, function( data ) {
                            if(parseInt(data.result))
                            {
                                var teacher = data.resultSet;
                                $('#txtSkypename').val(teacher.skype);
                                $('#txtInterviewNotes').val(teacher.interview_notes);
                                $('#txtStrong').val(teacher.interview_strong);
                                $('#txtWeek').val(teacher.interview_weak);
                                $('#selInterviewLevel').val(teacher.interview_level);
                                //$("#selInterviewLevel").trigger("liszt:updated");
                                if(parseInt(teacher.check_ref))
                                    $('#chkCheckReferences').prop('checked',true);
                                else
                                    $('#chkCheckReferences').prop('checked',false);
                                if(parseInt(teacher.check_returnee))
                                    $('#chkReturnee').prop('checked',true);
                                else
                                    $('#chkReturnee').prop('checked',false);
                                iCheckInit();
                            }
                            else
                            {
                                //
                            }
                    },'json');
                });
                
                $( "body" ).on( "click", "#btnUpdateInterview", function() {
                    $("#interview-form-message").removeClass('tuition_error');
                    $("#interview-form-message").removeClass('tuition_success');
                    $("#interview-form-message").html(' ');
                    
                    var teach_app_id = $("#hiddInterviewTeacher").val();
                    var txtSkypename = $('#txtSkypename').val();
                    var txtInterviewNotes = $('#txtInterviewNotes').val();
                    var txtStrong = $('#txtStrong').val();
                    var txtWeek = $('#txtWeek').val();
                    var selInterviewLevel = $('#selInterviewLevel').val();
                    var chkCheckReferences = 0; 
                    var chkReturnee = 0; 
                    if ($('#chkCheckReferences').is(":checked"))
                        chkCheckReferences = 1;
                    if ($('#chkReturnee').is(":checked"))
                        chkReturnee = 1;
                    
                    if(txtSkypename == '' && txtInterviewNotes == '' && txtStrong == '' && txtWeek == '' && selInterviewLevel == '')
                    {
                        $("#interview-form-message").addClass('tuition_error');
                        $("#interview-form-message").html('Please enter atleast one input field.');
                    }
                    else
                    {
                        $.post( "<?php echo base_url();?>index.php/teachers/updateinterviewdetail",{
                                'teach_app_id':teach_app_id,
                                'txtSkypename':txtSkypename,
                                'txtInterviewNotes':txtInterviewNotes,
                                'txtStrong':txtStrong,
                                'txtWeek':txtWeek,
                                'selInterviewLevel':selInterviewLevel,
                                'chkCheckReferences':chkCheckReferences,
                                'chkReturnee':chkReturnee
                            }, function( data ) {
                                $("#interview-form-message").html(data.message);
                                if(parseInt(data.result))
                                {
                                    $("#interview-form-message").addClass('tuition_success');
                                }
                                else
                                {
                                    $("#interview-form-message").addClass('tuition_error');
                                }
                        },'json');
                    }
                });
                
                $( "body" ).on( "click", "#btnSearchApplication", function() {
                    var nationality = $('#selNationality').val();
                    var sex = $('#selSex').val();
                    var dbfrom = $('#selAgeRangeFrom').val();
                    var dbto = $('#selAgeRangeTo').val();
                    var diplomas = $('#selDiplomas').val();
                    var txtCalFromDate = $('#txtCalFromDate').val();
                    var txtCalToDate = $('#txtCalToDate').val();
                    var txtName = $('#txtName').val();
                    var selPostcode = $('#selPostCode').val();
                    var selTeachYears = $('#selTeachYears').val();
                    
                    var selRegVerified = $('#selRegVerified').val();
                    var selIntLevel = $('#selIntLevel').val();
                    
                    $.post( "<?php echo base_url();?>index.php/teachers/review_ajax",{
                                'nationality':nationality,
                                'sex':sex,
                                'txtName':txtName,
                                'dbfrom':dbfrom,
                                'dbto':dbto,
                                'diplomas':diplomas,
                                'txtCalFromDate':txtCalFromDate,
                                'txtCalToDate':txtCalToDate,
                                'selPostcode':selPostcode,
                                'selTeachYears':selTeachYears,
                                'selRegVerified':selRegVerified,
                                'selIntLevel':selIntLevel,
                                'pageType':'<?php echo $pageType;?>'
                            }, function( data ) {
                        //var oTable = $('table.dynamic').dataTable();
                        //var ott = TableTools.fnGetInstance('tableSearchResults');
                        //if ( typeof ott != 'undefinded' && ott != null) ott.fnSelectNone();
//                        oTable.fnClearTable();
//                        //oTable.fnDestroy();
//                        oTable.fnAddData(data);
//                        oTable.fnDraw();
                        oTable.clear();
                        oTable.rows.add(data);
                        oTable.draw();
                        //$("#data-grid tr td").addClass('center');
                        //$("#data-grid tr td:last-child").addClass('operation');
                        $("a.read0").parent().parent().parent().find('td').css('background','#ffe5e5');
                    },'json');
                });
                
                $( "body" ).on( "click", ".dialogbtn", function() {
                    var id = $(this).attr('data-id');
                    var isread = $(this).attr('data-read');
                    var theLink = $(this);
                    $.post( "<?php echo base_url();?>index.php/teachers/applicationdetail",{
                            'id':id,
                            'isread':isread,
                            'pageType':'<?php echo $pageType;?>'
                        }, function( data ) {
                        $("#teacherDetail").html('');
                        $("#dialog_modal_appdetails").modal("show");
                        $("#teacherDetail").html(data);
                        //$('#historyTable table.dynamic').table();
                        if(isread == '0')
                        {
                            $(theLink).parent().parent().find('td').css('background','');
                            theLink.removeClass('read0');
                        }
                    });
                });
                
                
                $( ".windia-add-teacher" ).dialog({
                        autoOpen: false,
                        modal: true,
                        hide: "",
                        show: "",
                        width : '50%',
                        height : 680,
                        buttons: [{
                                text: "Close",
                                click: function() { $(this).dialog("close"); }
                        }]
                });
                
                var isBusy = false;
                /*$( ".windia-teacher" ).dialog({
                        autoOpen: false,
                        modal: true,
                        hide: "",
                        show: "",
                        width : '70%',
                        height : 600,
                        buttons: [{
                                text: "Close",
                                click: function() { $(this).dialog("close"); }
                        }<?php //if($pageType == 'cvreview'){?>,
                        {
                            text: "Send available positions",
                            id: "btnSendAdvOffer",
                                click: function() {
                                    if(isBusy)
                                    {
                                        alert("Process to send available position is in progress");
                                    }
                                    else if(confirm("Are you sure to send available positions?")){
                                        var teach_id = $("#hiddTeacherAppId").val();
                                        isBusy = true;
                                        $.post( "<?php //echo base_url();?>index.php/teachers/sendadvjoboffer",{
                                            'teach_id':teach_id
                                        }, function( data ) {
                                            if(parseInt(data.result)){
                                                alert(data.message);
                                                isBusy = false;
                                                $("#dialog_modal_appdetails").modal("hide");
                                                $("#btnSearchApplication").trigger('click');
                                            }
                                            else
                                            {
                                                alert(data.message);
                                            }
                                        },'json');
                                    }
                                }
                                /*
                                * DO NOT REMOVE THIS CODE, IT'S NEEDED IN FUTURE.
                                *text: "Confirm",
                                class: "btn-confirm",
                                click: function() {
                                    $("#form-message").removeClass('tuition_error');
                                    $("#form-message").removeClass('tuition_success');
                                    $("#form-message").html(' ');
                                    
                                    $("#dialog_modal_add_teacher").dialog("open");
                                    $("#txtFirstName").val($("#hiddFirstName").val());
                                    $("#txtLastName").val($("#hiddLastName").val());
                                    $("#txtHoursPerDay").val(0);
                                    $("#hiddEditTeacher").val(0);
                                    $("#txtFromDate").val($("#hiddAbilityFromDate").val());
                                    $("#txtToDate").val($("#hiddAbilityToDate").val());
                                }*//*
                        }<?php //}?>
                        ]
                });
                */
                
                $( "body" ).on( "click", "#btnSendAdvOffer", function() {
                    if(isBusy)
                    {
                        alert("Process to send available position is in progress");
                    }
                    else if(confirm("Are you sure to send available positions?")){
                        var teach_id = $("#hiddTeacherAppId").val();
                        isBusy = true;
                        $.post( "<?php echo base_url();?>index.php/teachers/sendadvjoboffer",{
                            'teach_id':teach_id
                        }, function( data ) {
                            if(parseInt(data.result)){
                                alert(data.message);
                                isBusy = false;
                                $("#dialog_modal_appdetails").modal("hide");
                                $("#btnSearchApplication").trigger('click');
                            }
                            else
                            {
                                alert(data.message);
                            }
                        },'json');
                    }
                });
                
                //btnSendAdvOfferFromInterview
                $( "body" ).on( "click", ".btnSendAdvOfferFromInterview", function() {
                    if(isBusy)
                    {
                        alert("Process to send available position is in progress");
                    }
                    else if(confirm("Are you sure to send available positions?")){
                        var teach_id = $(this).attr('data-id');
                        isBusy = true;
                        $.post( "<?php echo base_url();?>index.php/teachers/sendadvjoboffer",{
                            'teach_id':teach_id
                        }, function( data ) {
                            if(parseInt(data.result)){
                                alert(data.message);
                                isBusy = false;
                            }
                            else
                            {
                                alert(data.message);
                            }
                        },'json');
                    }
                });
                
                
                $( "body" ).on( "click", ".edit-add-teacher", function() {
                    var teach_id = $(this).attr('data-teach-id');
                    $("#form-message").removeClass('tuition_error');
                    $("#form-message").removeClass('tuition_success');
                    $("#form-message").html(' ');
                    $.post( "<?php echo base_url();?>index.php/teachers/getsingelrec",{
                        'teach_id':teach_id
                        }, function( data ) {
                                if(parseInt(data.result)){
                                    var teachObj = data.record[0];
                                    $("#dialog_modal_add_teacher").dialog("open");
                                    $("#txtFirstName").val(teachObj.teach_first_name);
                                    $("#txtLastName").val(teachObj.teach_last_name);
                                    $("#txtHoursPerDay").val(teachObj.teach_hours_per_day);
                                    $("#hiddEditTeacher").val(teach_id);
                                    var fromData = teachObj.teach_from_date.split(" ");
                                        fromData = fromData[0].split("-").reverse().join("/");
                                    
                                    $("#txtFromDate").val(fromData);
                                    var toData = teachObj.teach_to_date.split(" ");
                                        toData = toData[0].split("-").reverse().join("/");
                                    $("#txtToDate").val(toData);
                                    $("#selCampus").val(teachObj.teach_campus_id);
                                    $("#selCampus").trigger("liszt:updated");
                                }
                                else
                                {
                                    alert(data.record);
                                }
                    },'json');
                    
                    
                });
                
                $( "body" ).on( "click", "#btnCancel", function() {
                    $("#hiddEditTeacher").val(0);
                });
                
                $( "body" ).on( "click", "#btnSave", function() {
                    $("#form-message").removeClass('tuition_error');
                    $("#form-message").removeClass('tuition_success');
                    $("#form-message").html('');
                    var tea_id = $("#hiddTeacherAppId").val();
                    var campusId = $("#selCampus").val();
                    var firstname = $("#txtFirstName").val();
                    var lastname = $("#txtLastName").val();
                    var hoursperday = $("#txtHoursPerDay").val();
                    var fromdate = $("#txtFromDate").val();
                    var todate = $("#txtToDate").val();
                    var editTeacher = $("#hiddEditTeacher").val();
                    
                    if(parseInt(campusId) > 0)
                    {
                        if(firstname != "" && 
                            lastname != "" && 
                            hoursperday != 0 && 
                            fromdate != "" && 
                            todate != "")
                        {
                            $.post( "<?php echo base_url();?>index.php/teachers/confirmapplication",{
                                    'tea_id':tea_id,
                                    'campusId':campusId,
                                    'firstname':firstname,
                                    'lastname':lastname,
                                    'hoursperday':hoursperday,
                                    'fromdate':fromdate,
                                    'todate':todate,
                                    'editTeacher':editTeacher
                                }, function( data ) {
                                    $("#form-message").html(data.message);
                                    if(parseInt(data.status)) 
                                    {
                                        $("#form-message").addClass('tuition_success');
                                        $("#btnCancel").trigger('click');
                                        $("#dialog_modal_btn_"+tea_id).trigger('click');
                                        setTimeout(function(){$("#dialog_modal_add_teacher").dialog("close");},'1500');
                                    }
                                    else
                                    {
                                        $("#form-message").addClass('tuition_error');
                                    }
                            },'json');
                        }
                        else
                        {
                            $("#form-message").addClass('tuition_error');
                            if(parseInt(hoursperday) > 0)
                                $("#form-message").html('All fields are mandatory');
                            else
                                $("#form-message").html('All fields are mandatory, hours per day should be non-zero(0)');
                        }
                    }else
                    {
                        $("#form-message").addClass('tuition_error');
                        $("#form-message").html('Please select campus for the teacher');
                    }
                    
                });
                
                $( "#txtCalFromDate" ).datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        changeYear: true,		  
                        dateFormat: "dd/mm/yy",		
                        numberOfMonths: 1,
                        onClose: function( selectedDate ) {
                            $( "#txtCalToDate" ).datepicker( "option", "minDate", selectedDate );
                        }
                });

                $( "#txtCalToDate" ).datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        changeYear: true,		  
                        dateFormat: "dd/mm/yy",		
                        numberOfMonths: 1,
                        onClose: function( selectedDate ) {
                                $( "#txtCalFromDate" ).datepicker( "option", "maxDate", selectedDate );
                        }
                });
                
                $( "#txtFromDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
                                $( "#txtToDate" ).datepicker( "option", "minDate", selectedDate );
			}
                });

                $( "#txtToDate" ).datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            changeYear: true,		  
                            dateFormat: "dd/mm/yy",		
                            numberOfMonths: 1,
                            onClose: function( selectedDate ) {
                                    $( "#txtFromDate" ).datepicker( "option", "maxDate", selectedDate );
                            }
                });
                
                // job offer date range
                 
                $( "#txtJobFrom" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
                                $( "#txtJobTill" ).datepicker( "option", "minDate", selectedDate );
			}
                });

                $( "#txtJobTill" ).datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            changeYear: true,		  
                            dateFormat: "dd/mm/yy",		
                            numberOfMonths: 1,
                            onClose: function( selectedDate ) {
                                    $( "#txtJobFrom" ).datepicker( "option", "maxDate", selectedDate );
                            }
                });
                
               
                /*$( ".sendjoboffer_dialog" ).dialog({
                        autoOpen: false,
                        modal: true,
                        hide: "",
                        show: "",
                        width : 800,
                        height : 850,
                        buttons: [{
                                text: "Close",
                                click: function() { $(this).dialog("close"); }
                        }]
                });*/
                
                $("body").on("click",".sendjoboffer_link",function(){
                    
                    $("#btnJobCancel").trigger('click');
                    $("#rowType").hide();
                    $("#rowWages").hide();
                    $("#rowRate").hide();
                    $("#rowResidential").hide();
                    $("#rowDramSession").hide();
                    
                    
                    var id = $(this).attr('data-id');
                    var teachername = $(this).attr('data-name');
                    $("#hiddJobOfferTeacher").val(id);
                    $("#lblCandidate").html(teachername);
                    
                    $.post( SITE_PATH + "teachers/getSendJobHistory",{'teacher_appid':id}, function( data ) {
                        $("#jobOfferListingData").html(data);
                    });
                    
                    $("#sendjoboffer_dialog_popup").modal('show');
                    //$("#sendjoboffer_dialog_popup").attr('style','max-height:500px;overflow-x: hidden;scroll-behavior: smooth;');
                    
                });
                
                $("body").on("click","#btnSendJobOffer",function(){
                    $("#joboffer-form-message").removeClass('tuition_error');
                    $("#joboffer-form-message").removeClass('tuition_success');
                    $("#joboffer-form-message").html('');
                    var teaId = $("#hiddJobOfferTeacher").val();
                    var position = $("#selPosition option:selected").text();
                    var positionId = $("#selPosition").val();
                    var res_non_res = $("#selResOrNon").val();
                    var currency = $("#selCurrency").val();
                    var selType = $("#selType").val();
                    var selWages = $("#selWages").val();
                    var selRate = $("#selRate").val();
                    var dramaSession = 0;
                    if($("#chkDramaSession").prop("checked") == true)
                        dramaSession = 1;
                    
                    if(positionId != '' && currency != '') //&& res_non_res != '' 
                    {
                        var allowed = 1;
                        if(position == 'Teacher')
                        {
                            $("#rowType").show();
                            if(selType == '')
                            {
                                allowed = 0;
                            }
                            else
                            {
                                if(selType == 'Academy') // 1' || selType == 'Academy 2
                                {
                                    if(selWages == '')
                                    {
                                        $("#rowWages").show();
                                        allowed = 0;
                                    }
                                }
                                if(selType == 'Non London')
                                {
                                    if(res_non_res == '')
                                        allowed = 0;
                                }
                                if(selWages != 'Weekly')
                                {
                                    $("#rowRate").show();
                                    if(selRate == "")
                                        allowed = 0;
                                }
                                
                            }
                        }
                        if(allowed)
                        {
                            loading('Sending...');
                            $.post( "<?php echo base_url();?>index.php/teachers/sendjobofferletter",{
                                    'teaId':teaId,
                                    'position':position,
                                    'positionId':positionId,
                                    'res_non_res':res_non_res,
                                    'currency':currency,
                                    'selType':selType,
                                    'selWages':selWages,
                                    'selRate':selRate,
                                    'dramaSession':dramaSession
                                }, function( data ) {
                                    if(parseInt(data.result)) 
                                    {
                                        $("#btnJobCancel").trigger('click');
                                        $("#joboffer-form-message").addClass('tuition_success');
                                        $("#joboffer-form-message").html(data.message);
                                        unloading();
                                        $.post( SITE_PATH + "teachers/getSendJobHistory",{'teacher_appid':teaId}, function( history ) {
                                            $("#jobOfferListingData").html(history);
                                        });
                                    }
                                    else
                                    {
                                        $("#joboffer-form-message").addClass('tuition_error');
                                        $("#joboffer-form-message").html(data.message);
                                        unloading();
                                    }
                            },'json');
                        }
                        else
                        {
                            $("#joboffer-form-message").addClass('tuition_error');
                            $("#joboffer-form-message").html("All <span class='star-red'>*</span> fields are mandatory.");
                        }
                    }
                    else
                    {
                        $("#joboffer-form-message").addClass('tuition_error');
                        $("#joboffer-form-message").html("All <span class='star-red'>*</span> fields are mandatory.");
                    }
                });
                
                $( "body" ).on( "click", "#btnJobCancel", function() {
                    $("#joboffer-form-message").removeClass('tuition_error');
                    $("#joboffer-form-message").removeClass('tuition_success');
                    $("#joboffer-form-message").html('');
                    setTimeout(function(){iCheckInit();},200);
                });
               
               // $('#helptip').tipsy({gravity: 'se',html: true });
               // $(".btn-confirm").parent().append($("#helptip"));
               
            
            $( "body" ).on( "change", "#selPosition", function() {
                var myVal = $("#selPosition option:selected").text();
                if(myVal == 'Teacher')
                {
                    $("#rowType").show();
                }
                else
                {
                    $("#rowType").hide();
                    $("#rowWages").hide();
                    $("#rowRate").hide();
                    $("#rowResidential").hide();
                    $("#rowDramSession").hide();
                }
            });
            
            $( "body" ).on( "change", "#selType", function() {
                $("#rowResidential").hide();
                $("#rowDramSession").hide();
                var myVal = $("#selType option:selected").text();
                if(myVal == 'Academy') // 1' || myVal == 'Academy 2
                {
                    $("#rowWages").show();
                    if($("#selWages").val() == "Hourly")
                    {
                        $("#rowRate").show();
                    }
                    else
                        $("#rowRate").hide();
                }
                else if(myVal == 'Non London'){
                    $("#rowResidential").show();
                    $("#rowDramSession").show();
                    $("#rowWages").hide();
                    $("#rowRate").show();
                }
                else
                {
                    $("#rowWages").hide();
                    $("#rowRate").show();
                }
            });
            
            $( "body" ).on( "change", "#selWages", function() {
                var myVal = $("#selWages option:selected").text();
                if(myVal == 'Hourly')
                {
                    $("#rowRate").show();
                }
                else
                    $("#rowRate").hide();
            });
                
    });
</script>