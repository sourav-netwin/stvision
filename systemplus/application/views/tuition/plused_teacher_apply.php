<?php $this->load->view('plused_header'); ?>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix">
    <!-- The blue toolbar stripe -->
    <section class="toolbar">
        <div class="user">
            <div class="avatar">
                <img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
                <!-- Evidenziare per icone attenzione <span>3</span> -->
            </div>
            <span><?php echo $this->session->userdata('businessname') ?></span>
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
                <li class="line"></li>
                <li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
            </ul>
        </div>
    </section><!-- End of .toolbar-->
    <?php $this->load->view('plused_sidebar'); ?>		
    <script>
        $(document).ready(function() {
            $( "li#bocampus" ).addClass("current");
            $( "li#bocampus a" ).addClass("open");		
            $( "li#bocampus ul.sub" ).css('display','block');	
            $( "li#bocampus ul.sub li#bocampus_5" ).addClass("current");	
            
            $( "#txtFromDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$(".txtFromDate").val(selectedDate);
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
				$(".txtToDate").val(selectedDate);
                                $( "#txtFromDate" ).datepicker( "option", "maxDate", selectedDate );
			}
            });
        });
    </script>	

    <!-- Here goes the content. -->
    <section id="content" class="container_12 clearfix" data-sort=true>
        <div class="grid_12">
            <div class="box">
                <div class="header">
                    <h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png"><?php echo $breadcrumb2;?></h2>
                </div>
                <div class="content">
                    <?php 
                        $success_message = $this->session->flashdata('success_message');
                        if(!empty($success_message))
                        {
                            ?><div class="tuition_success"><?php echo $success_message;?></div><?php 
                        }
                        $error_message = $this->session->flashdata('error_message');
                        if(!empty($error_message))
                        {
                            ?><div class="tuition_error"><?php echo $error_message;?></div><?php 
                        }
                    ?>
                    <div class="row">
                        <form enctype="multipart/form-data" action="<?php echo base_url().'index.php/teachers/apply';?>" method="POST" class="form-horizontal">
                            <div class="form-group col-lg-12">
                                <hr>
                                <h4>Personal info</h4>
                            </div>								
                            <div class="form-group col-lg-6">
                                <label class="col-lg-2 control-label" for="txtFirstName">Name</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" placeholder="Name" id="txtFirstName" name="txtFirstName" value="<?php echo set_value('txtFirstName',$formData['ta_firstname']);?>">
                                    <span class="error"><?php echo form_error('txtFirstName');?></span>
                                </div>
                            </div>	
                            <div class="form-group col-lg-6">
                                <label class="col-lg-2 control-label" for="txtLastName">Surname</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="Surname" id="txtLastName" name="txtLastName" value="<?php echo set_value('txtLastName',$formData['ta_lastname']);?>" class="form-control">
                                    <span class="error"><?php echo form_error('txtLastName');?></span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-2 control-label" for="Birthdate">Birthdate</label>
                                <div class="col-lg-10">
                                    <input type="date" placeholder="Birthdate" id="txtDateofBirth" name="txtDateofBirth" value="<?php echo set_value('txtDateofBirth',$formData['ta_date_of_birth']);?>" class="form-control hasDatepicker">
                                    <span class="error"><?php echo form_error('txtDateofBirth');?></span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-2 control-label" for="selNationality">Nationality</label>
                                <div class="col-lg-10">
                                    <select id="selNationality" class="form-control" name="selNationality">
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
                                    <span class="error"><?php echo form_error('selNationality');?></span>
                                </div>
                            </div>							  
                            <div class="form-group col-lg-6">
                                <label class="col-lg-2 control-label" for="selSex">Sex</label>
                                <div class="col-lg-10">
                                        <select id="selSex" class="form-control" name="selSex">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                        </select>
                                        <span class="error"><?php echo form_error('selSex');?></span>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <hr>
                                <h4>Contact</h4>
                            </div>							  
                            <div class="form-group col-lg-6">
                                <label class="col-lg-2 control-label" for="txtEmail">E-mail</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="E-mail address" name="txtEmail" id="txtEmail" value="<?php echo set_value('txtEmail',$formData['ta_email']);?>" class="form-control">
                                    <span class="error"><?php echo form_error('txtEmail');?></span>
                                </div>
                            </div>	
                            <div class="form-group col-lg-6">
                                <label class="col-lg-2 control-label" for="txtTelephone">Telephone</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="Telephone" id="txtTelephone" name="txtTelephone" value="<?php echo set_value('txtTelephone',$formData['ta_telephone']);?>" class="form-control">
                                    <span class="error"><?php echo form_error('txtTelephone');?></span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-2 control-label" for="selTeachYears">Teach years</label>
                                <div class="col-lg-10">
                                    <select class="required" id="selTeachYears" name="selTeachYears"  >
                                        <option value="">All</option>
                                        <option <?php echo ($formData['ta_teach_years'] == '1-3' ? 'selected="selected"' : '');?> value="1-3">1-3 years</option>
                                        <option <?php echo ($formData['ta_teach_years'] == '4-7' ? 'selected="selected"' : '');?> value="4-7">4-7 years</option>
                                        <option <?php echo ($formData['ta_teach_years'] == '8' ? 'selected="selected"' : '');?> value="8">8 years or more</option>
                                    </select>
                                    <span class="error"><?php echo form_error('selTeachYears');?></span>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <hr>
                                <h4>Address</h4>
                            </div>									  
                            <div class="form-group col-lg-6">
                                <label class="col-lg-2 control-label" for="txtAddress">Address</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="Address" id="txtAddress" name="txtAddress" value="<?php echo set_value('txtAddress',$formData['ta_address']);?>" class="form-control">
                                    <span class="error"><?php echo form_error('txtAddress');?></span>
                                </div>
                            </div>	
                            <div class="form-group col-lg-6">
                                <label class="col-lg-2 control-label" for="txtCity">City</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="City" id="txtCity" name="txtCity" value="<?php echo set_value('txtCity',$formData['ta_city']);?>" class="form-control">
                                    <span class="error"><?php echo form_error('txtCity');?></span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-2 control-label" for="selPostCode">Postcode</label>
                                <div class="col-lg-10">
                                    <select class="required" id="selPostCode" name="selPostCode"  >
                                        <?php if($postcodeData){
                                                foreach($postcodeData as $postcode){
                                                    ?><option <?php echo ($formData['ta_postcode'] == $postcode['code'] ? "selected='selected'" : "");?> value="<?php echo $postcode['code'];?>"><?php echo $postcode['area'];?></option><?php 
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span class="error"><?php echo form_error('txtPostCode');?></span>
                                </div>
                            </div>								  
                            <div class="form-group col-lg-6">
                                <label class="col-lg-2 control-label" for="selCountry">Country</label>
                                <div class="col-lg-10">
                                    <select id="selCountry" class="form-control" name="selCountry">
                                        <option value="Afganistan">Afghanistan</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Algeria">Algeria</option>
                                        <option value="American Samoa">American Samoa</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Anguilla">Anguilla</option>
                                        <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Aruba">Aruba</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Azerbaijan">Azerbaijan</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bahrain">Bahrain</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Belize">Belize</option>
                                        <option value="Benin">Benin</option>
                                        <option value="Bermuda">Bermuda</option>
                                        <option value="Bhutan">Bhutan</option>
                                        <option value="Bolivia">Bolivia</option>
                                        <option value="Bonaire">Bonaire</option>
                                        <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                                        <option value="Botswana">Botswana</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                        <option value="Brunei">Brunei</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Cambodia">Cambodia</option>
                                        <option value="Cameroon">Cameroon</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Canary Islands">Canary Islands</option>
                                        <option value="Cape Verde">Cape Verde</option>
                                        <option value="Cayman Islands">Cayman Islands</option>
                                        <option value="Central African Republic">Central African Republic</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Channel Islands">Channel Islands</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Christmas Island">Christmas Island</option>
                                        <option value="Cocos Island">Cocos Island</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Comoros">Comoros</option>
                                        <option value="Congo">Congo</option>
                                        <option value="Cook Islands">Cook Islands</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Cote DIvoire">Cote D'Ivoire</option>
                                        <option value="Croatia">Croatia</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Curaco">Curacao</option>
                                        <option value="Cyprus">Cyprus</option>
                                        <option value="Czech Republic">Czech Republic</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Djibouti">Djibouti</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Dominican Republic">Dominican Republic</option>
                                        <option value="East Timor">East Timor</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                        <option value="Eritrea">Eritrea</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Ethiopia">Ethiopia</option>
                                        <option value="Falkland Islands">Falkland Islands</option>
                                        <option value="Faroe Islands">Faroe Islands</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Finland">Finland</option>
                                        <option value="France">France</option>
                                        <option value="French Guiana">French Guiana</option>
                                        <option value="French Polynesia">French Polynesia</option>
                                        <option value="French Southern Ter">French Southern Ter</option>
                                        <option value="Gabon">Gabon</option>
                                        <option value="Gambia">Gambia</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Gibraltar">Gibraltar</option>
                                        <option value="Great Britain">Great Britain</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Greenland">Greenland</option>
                                        <option value="Grenada">Grenada</option>
                                        <option value="Guadeloupe">Guadeloupe</option>
                                        <option value="Guam">Guam</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Hawaii">Hawaii</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hong Kong">Hong Kong</option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Iran">Iran</option>
                                        <option value="Iraq">Iraq</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Isle of Man">Isle of Man</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Jordan">Jordan</option>
                                        <option value="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Korea North">Korea North</option>
                                        <option value="Korea Sout">Korea South</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Laos">Laos</option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="Lesotho">Lesotho</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libya">Libya</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Macau">Macau</option>
                                        <option value="Macedonia">Macedonia</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Malawi">Malawi</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marshall Islands">Marshall Islands</option>
                                        <option value="Martinique">Martinique</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="Mauritius">Mauritius</option>
                                        <option value="Mayotte">Mayotte</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Midway Islands">Midway Islands</option>
                                        <option value="Moldova">Moldova</option>
                                        <option value="Monaco">Monaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Montserrat">Montserrat</option>
                                        <option value="Morocco">Morocco</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Nambia">Nambia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Netherland Antilles">Netherland Antilles</option>
                                        <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                        <option value="Nevis">Nevis</option>
                                        <option value="New Caledonia">New Caledonia</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Niue">Niue</option>
                                        <option value="Norfolk Island">Norfolk Island</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Palau Island">Palau Island</option>
                                        <option value="Palestine">Palestine</option>
                                        <option value="Panama">Panama</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Phillipines">Philippines</option>
                                        <option value="Pitcairn Island">Pitcairn Island</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Puerto Rico">Puerto Rico</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Republic of Montenegro">Republic of Montenegro</option>
                                        <option value="Republic of Serbia">Republic of Serbia</option>
                                        <option value="Reunion">Reunion</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Russia">Russia</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="St Barthelemy">St Barthelemy</option>
                                        <option value="St Eustatius">St Eustatius</option>
                                        <option value="St Helena">St Helena</option>
                                        <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                        <option value="St Lucia">St Lucia</option>
                                        <option value="St Maarten">St Maarten</option>
                                        <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                                        <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
                                        <option value="Saipan">Saipan</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="Samoa American">Samoa American</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra Leone">Sierra Leone</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Slovakia">Slovakia</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Solomon Islands">Solomon Islands</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="Sudan">Sudan</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Swaziland">Swaziland</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Syria">Syria</option>
                                        <option value="Tahiti">Tahiti</option>
                                        <option value="Taiwan">Taiwan</option>
                                        <option value="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tokelau">Tokelau</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                                        <option value="Tunisia">Tunisia</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Turkmenistan">Turkmenistan</option>
                                        <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Erimates">United Arab Emirates</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States of America">United States of America</option>
                                        <option value="Uraguay">Uruguay</option>
                                        <option value="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Vatican City State">Vatican City State</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietnam">Vietnam</option>
                                        <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                        <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                        <option value="Wake Island">Wake Island</option>
                                        <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Zaire">Zaire</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
                                        </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <hr>
                                <h4>Availability</h4>
                            </div>								  
                            <div class="form-group col-lg-6">
                                <label class="col-lg-2 control-label" for="availFrom">From</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="Available to work from" name="txtAblilityFrom" id="availFrom" value="<?php echo set_value('txtAblilityFrom',$formData['ta_ablility_from']);?>"  class="form-control hasDatepicker">
                                    <span class="error"><?php echo form_error('txtAblilityFrom');?></span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-2 control-label" for="availTo">To</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="Available to work to" name="txtAblilityTo" value="<?php echo set_value('txtAblilityTo',$formData['ta_ablility_to']);?>" id="availTo" class="form-control hasDatepicker">
                                    <span class="error"><?php echo form_error('txtAblilityTo');?></span>
                                </div>
                            </div>							  
                            <div class="form-group col-lg-12">
                                <hr>
                                <h4>Diplomas</h4>
                            </div>							  
                            <div class="form-group col-lg-12">
                                <div class="col-lg-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="chkCelta" value="1" id="celta"> CELTA
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="chkTrinityTesol" value="1"  id="trinity"> Trinity TESOL
                                        </label>
                                    </div>
                                </div>			
                                <div class="col-lg-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="chkDelta" value="1"  id="delta"> DELTA
                                        </label>
                                    </div>
                                </div>	
                                <div class="col-lg-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="chkDipTesol" value="1"  id="tesol"> Dip. TESOL
                                        </label>
                                    </div>
                                </div>									
                            </div>
                            <div class="form-group col-lg-12">
                                <div class="col-lg-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="chkBEd" value="1"  id="bed"> B.Ed.
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="chkPgce" value="1"  id="pgce"> PGCE (Primary, English or MFL)
                                        </label>
                                    </div>
                                </div>			
                                <div class="col-lg-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="chkMaEltTesol" value="1"  id="maelt"> MA in ELT//TESOL
                                        </label>
                                    </div>
                                </div>	
                                <div class="col-lg-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="otherD" id="otherD"> Other diplomas
                                        </label>
                                    </div>
                                </div>									
                            </div>
                            <div class="form-group col-lg-12">
                                <label class="col-lg-2 control-label" for="otherDiplomas">Other diplomas</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="If other, please specify" id="otherDiplomas" name="txtOtherDiploma" class="form-control">
                                    <span class="error"><?php echo form_error('txtOtherDiploma');?></span>
                                </div>
                            </div>	
                            <div class="form-group col-lg-12">
                                <hr>
                                <h4>CV and other documents</h4>
                            </div>								  
                            <div class="form-group col-lg-6">
                                <label class="col-lg-4 control-label" for="cvFile">CV (doc, pdf)</label>
                                <div class="col-lg-8">
                                    <input type="file" placeholder="Attach your CV" name="cvFile" id="cvFile" class="form-control">
                                    <span class="error"><?php echo $formData['cv_file_error'];?></span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-4 control-label" for="otherFile">Other file</label>
                                <div class="col-lg-8">
                                    <input type="file" placeholder="Attach another file (if any)" name="otherFile" id="otherFile" class="form-control">
                                    <span class="error"><?php echo $formData['other_file_error'];?></span>
                                </div>
                            </div>							  
                            <div class="form-group col-lg-12">
                                <div class="col-lg-offset-8 col-lg-4">
                                    <button class="btn btn-default btn-info" type="submit">Apply</button>
                                </div>
                            </div>
                        </form>
                        </div>
                </div><!-- End of .content -->
            </div><!-- End of .box -->
        </div><!-- End of .grid_12 -->

    </section><!-- End of #content -->

</div><!-- End of #main -->

<?php $this->load->view('plused_footer'); ?>