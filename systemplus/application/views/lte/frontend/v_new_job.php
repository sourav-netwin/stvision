<?php
	$this->load->view("st_boots_header");

?>
	
	<div class="container">
	<!-- Menu Up -->
			<?php
				$this->load->view("st_boots_menu_up");
			?>
			<img style="margin-bottom:4px;twxt-align:center;" class="img-responsive" src="/apps/img/about_us.jpg"/>
			
			<div class="row">
				<div class="col-xs-12">
					<h1 class="velina">Work With Us</h1>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12">
					 <h3>Plus Educational</h3>Thank you for your interest in working with Plus. We run junior summer courses at various locations in the UK and Ireland. If you are looking for summer school work and are passionate about working with children, please take a few minutes to complete this application and we will then contact you shortly with further details. 
				</div>
			</div>
			<?php 
		$message = "";
		$classet = "";
		switch($stato){
			case "ok":
				$classet="text-success";
				$message = "<br />Thank you for your interest.<br />We will contact you shortly with further details.<br /><br /><br />";
				break;
			case "ko1":
				$classet="text-danger";
				$message = "<br />An error has occurred in your application.<br />Please contact <a href='recruitment@plus-ed.com'>recruitment@plus-ed.com</a> for further details.<br /><br /><br />";
				break;
			case "ko2":
				$classet="text-warning";
				$message = "<br />An error has occurred in your application. Some reuired fileds are missing.<br />Please try again or contact <a href='recruitment@plus-ed.com'>recruitment@plus-ed.com</a> for further details.";
				break;				
			
		}
		?><div class="<?php echo $classet; ?>"><?php echo $message;?></div>
	<?php if($stato=="" or $stato=="ko2"){ ?>
	<div class="row">
		<form enctype="multipart/form-data" action="http://plus-ed.com/vision_ag/index.php/positions/apply" method="POST" class="form-horizontal" id="formMyApp">
			<div class="form-group col-lg-12">
				<hr>
				<h4>Personal info</h4>
			</div>								
			<div class="form-group col-lg-6">
				<label class="col-lg-4 control-label" for="txtFirstName">Name *</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" placeholder="Name" id="txtFirstName" name="txtFirstName" required value="<?php echo set_value('txtFirstName',$formData['ta_firstname']);?>">
				</div>
			</div>	
			<div class="form-group col-lg-6">
				<label class="col-lg-4 control-label" for="txtLastName">Surname *</label>
				<div class="col-lg-8">
					<input type="text" placeholder="Surname" id="txtLastName" name="txtLastName" required  value="<?php echo set_value('txtLastName',$formData['ta_lastname']);?>" class="form-control">
				</div>
			</div>
			<div class="form-group col-lg-6">
				<label class="col-lg-4 control-label" for="Birthdate">Birthdate *</label>
				<div class="col-lg-8">
					<input type="text" readonly placeholder="Birthdate" id="txtDateofBirth" name="txtDateofBirth" required  value="" class="form-control">
				</div>
			</div>
			<div class="form-group col-lg-6">
				<label class="col-lg-4 control-label" for="selNationality">Nationality *</label>
				<div class="col-lg-8">
					<select id="selNationality" class="form-control" required name="selNationality">
							<option value="">Please select...</option>
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
			</div>							  
			<div class="form-group col-lg-6">
				<label class="col-lg-4 control-label" for="selSex">Sex *</label>
				<div class="col-lg-8">
						<select id="selSex" class="form-control" name="selSex">
								<option value="male">Male</option>
								<option value="female">Female</option>
						</select>
				</div>
			</div>
			<div class="form-group col-lg-6">
				<label class="col-lg-4 control-label" for="txtYoT">Years of teaching *</label>
				<div class="col-lg-8">
					<select id="txtYoT" class="form-control" required name="txtYoT">
						<option value="">Please select...</option>
						<option value="1-2 years">1-2 years</option>
						<option value="3-5 years">3-5 years</option>
						<option value="6-9 years">6-9 years</option>
						<option value="more than 10 years">more than 10 years</option>
					</select>
				</div>
			</div>				
			<div class="form-group col-lg-12">
				<hr>
				<h4>Contact</h4>
			</div>							  
			<div class="form-group col-lg-6">
				<label class="col-lg-4 control-label" for="txtEmail">E-mail *</label>
				<div class="col-lg-8">
					<input type="text" placeholder="E-mail address" name="txtEmail" required  id="txtEmail" value="<?php echo set_value('txtEmail',$formData['ta_email']);?>" class="form-control">
				</div>
			</div>	
			<div class="form-group col-lg-6">
				<label class="col-lg-4 control-label" for="txtTelephone">Telephone *</label>
				<div class="col-lg-8">
					<input type="text" placeholder="Telephone" id="txtTelephone" required  name="txtTelephone" value="<?php echo set_value('txtTelephone',$formData['ta_telephone']);?>" class="form-control">
				</div>
			</div>	
			<div class="form-group col-lg-12">
				<hr>
				<h4>Address</h4>
			</div>									  
			<div class="form-group col-lg-6">
				<label class="col-lg-4 control-label" for="txtAddress">Address</label>
				<div class="col-lg-8">
					<input type="text" placeholder="Address" id="txtAddress" name="txtAddress" value="<?php echo set_value('txtAddress',$formData['ta_address']);?>" class="form-control">
				</div>
			</div>	
			<div class="form-group col-lg-6">
				<label class="col-lg-4 control-label" for="txtCity">City</label>
				<div class="col-lg-8">
					<input type="text" placeholder="City" id="txtCity" name="txtCity" value="<?php echo set_value('txtCity',$formData['ta_city']);?>" class="form-control">
				</div>
			</div>
			<div class="form-group col-lg-6">
				<label class="col-lg-4 control-label" for="txtPostCode">UK Postcode Area</label>
				<div class="col-lg-8">
					<select id="txtPostCode" class="form-control" name="txtPostCode">
						<option value="--">No UK resident</option>
						<option value="AB">Aberdeen</option>
						<option value="AL">St Albans</option>
						<option value="B">Birmingham</option>
						<option value="BA">Bath</option>
						<option value="BB">Blackburn</option>
						<option value="BD">Bradford</option>
						<option value="BH">Bournemouth</option>
						<option value="BL">Bolton</option>
						<option value="BN">Brighton</option>
						<option value="BR">Bromley</option>
						<option value="BS">Bristol</option>
						<option value="BT">Northern Ireland</option>
						<option value="CA">Carlisle</option>
						<option value="CB">Cambridge</option>
						<option value="CF">Cardiff</option>
						<option value="CH">Chester</option>
						<option value="CM">Chelmsford</option>
						<option value="CO">Colchester</option>
						<option value="CR">Croydon</option>
						<option value="CT">Canterbury</option>
						<option value="CV">Coventry</option>
						<option value="CW">Crewe</option>
						<option value="DA">Dartford</option>
						<option value="DD">Dundee</option>
						<option value="DE">Derby</option>
						<option value="DG">Dumfries and Galloway</option>
						<option value="DH">Durham</option>
						<option value="DL">Darlington</option>
						<option value="DN">Doncaster</option>
						<option value="DT">Dorchester</option>
						<option value="DY">Dudley</option>
						<option value="E">East London</option>
						<option value="EC">Central London</option>
						<option value="EH">Edinburgh</option>
						<option value="EN">Enfield</option>
						<option value="EX">Exeter</option>
						<option value="FK">Falkirk and Stirling</option>
						<option value="FY">Blackpool</option>
						<option value="G">Glasgow</option>
						<option value="GL">Gloucester</option>
						<option value="GU">Guildford</option>
						<option value="HA">Harrow</option>
						<option value="HD">Huddersfield</option>
						<option value="HG">Harrogate</option>
						<option value="HP">Hemel Hempstead</option>
						<option value="HR">Hereford</option>
						<option value="HS">Outer Hebrides</option>
						<option value="HU">Hull</option>
						<option value="HX">Halifax</option>
						<option value="IG">Ilford</option>
						<option value="IP">Ipswich</option>
						<option value="IV">Inverness</option>
						<option value="KA">Kilmarnock</option>
						<option value="KT">Kingston upon Thames</option>
						<option value="KW">Kirkwall</option>
						<option value="KY">Kirkcaldy</option>
						<option value="L">Liverpool</option>
						<option value="LA">Lancaster</option>
						<option value="LD">Llandrindod Wells</option>
						<option value="LE">Leicester</option>
						<option value="LL">Llandudno</option>
						<option value="LN">Lincoln</option>
						<option value="LS">Leeds</option>
						<option value="LU">Luton</option>
						<option value="M">Manchester</option>
						<option value="ME">Rochester</option>
						<option value="MK">Milton Keynes</option>
						<option value="ML">Motherwell</option>
						<option value="N">North London</option>
						<option value="NE">Newcastle upon Tyne</option>
						<option value="NG">Nottingham</option>
						<option value="NN">Northampton</option>
						<option value="NP">Newport</option>
						<option value="NR">Norwich</option>
						<option value="NW">North West London</option>
						<option value="OL">Oldham</option>
						<option value="OX">Oxford</option>
						<option value="PA">Paisley</option>
						<option value="PE">Peterborough</option>
						<option value="PH">Perth</option>
						<option value="PL">Plymouth</option>
						<option value="PO">Portsmouth</option>
						<option value="PR">Preston</option>
						<option value="RG">Reading</option>
						<option value="RH">Redhill</option>
						<option value="RM">Romford</option>
						<option value="S">Sheffield</option>
						<option value="SA">Swansea</option>
						<option value="SE">South East London</option>
						<option value="SG">Stevenage</option>
						<option value="SK">Stockport</option>
						<option value="SL">Slough</option>
						<option value="SM">Sutton</option>
						<option value="SN">Swindon</option>
						<option value="SO">Southampton</option>
						<option value="SP">Salisbury</option>
						<option value="SR">Sunderland</option>
						<option value="SS">Southend-on-Sea</option>
						<option value="ST">Stoke-on-Trent</option>
						<option value="SW">South West London</option>
						<option value="SY">Shrewsbury</option>
						<option value="TA">Taunton</option>
						<option value="TD">Galashiels</option>
						<option value="TF">Telford</option>
						<option value="TN">Tonbridge</option>
						<option value="TQ">Torquay</option>
						<option value="TR">Truro</option>
						<option value="TS">Cleveland</option>
						<option value="TW">Twickenham</option>
						<option value="UB">Southall</option>
						<option value="W">West London</option>
						<option value="WA">Warrington</option>
						<option value="WC">Central London</option>
						<option value="WD">Watford</option>
						<option value="WF">Wakefield</option>
						<option value="WN">Wigan</option>
						<option value="WR">Worcester</option>
						<option value="WS">Walsall</option>
						<option value="WV">Wolverhampton</option>
						<option value="YO">York</option>
						<option value="ZE">Lerwick</option>
					</select>
				</div>
			</div>								  							  
			<div class="form-group col-lg-6">
				<label class="col-lg-4 control-label" for="selCountry">Country</label>
				<div class="col-lg-8">
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
				<label class="col-lg-4 control-label" for="availFrom">From *</label>
				<div class="col-lg-8">
					<input type="text" placeholder="Available to work from" name="txtAblilityFrom" id="availFrom" value=""  class="form-control">
				</div>
			</div>
			<div class="form-group col-lg-6">
				<label class="col-lg-4 control-label" for="availTo">To *</label>
				<div class="col-lg-8">
					<input type="text" placeholder="Available to work to" name="txtAblilityTo" value="" id="availTo" class="form-control">
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
				</div>
			</div>
			<div class="form-group col-lg-6">
				<label class="col-lg-4 control-label" for="otherFile">Other file</label>
				<div class="col-lg-8">
					<input type="file" placeholder="Attach another file (if any)" name="otherFile" id="otherFile" class="form-control">
				</div>
			</div>							  
			<div class="form-group col-lg-12">
				<div class="col-lg-offset-8 col-lg-4">
					<button class="btn btn-default btn-info" type="button" id="applyBut">Apply</button>
				</div>
			</div>
		</form>
	</div>
	<?php } ?>
						
		</div>

<!-- Footer e mappa-->
<?php
	$this->load->view("st_boots_footer");

?>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    $("#applyBut").click(function(e){
        e.preventDefault();
        if($("#availFrom").val()=="" || $("#availTo").val()=="" || $("#txtFirstName").val()=="" || $("#txtLastName").val()=="" || $("#txtDateofBirth").val()=="" || $("#selNationality").val()=="" || $("#selSex").val()=="" || $("#txtYoT").val()=="" || $("#txtEmail").val()=="" || $("#txtTelephone").val()==""){
            alert("Please fill in all mandatory fields!");
            return false;
        }else{
            if($("#txtDateofBirth").validDate() && $("#availFrom").validDate() && $("#availTo").validDate())
            {
                $("#formMyApp").submit();
            }
            else{
                alert("Please select valid dates for Birthdate and Availability from, to!");
                return false;
            }
        }
    });
    $( "#txtDateofBirth" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "1950:1998",
        dateFormat: "dd/mm/yy"
    });
    $( "#availFrom" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        dateFormat: "dd/mm/yy",
        onClose: function( selectedDate ) {
            $( "#availTo" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    $( "#availTo" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        dateFormat: "dd/mm/yy",
        onClose: function( selectedDate ) {
            $( "#availFrom" ).datepicker( "option", "maxDate", selectedDate );
        }
    });	
    
    $.fn.validDate = function() {
        var value = $(this[0]).val(); // It's your element
        var check = false,
                re = /^\d{1,2}\/\d{1,2}\/\d{4}$/,
                adata, gg, mm, aaaa, xdata;
        if ( re.test( value ) ) {
                adata = value.split( "/" );
                gg = parseInt( adata[ 0 ], 10 );
                mm = parseInt( adata[ 1 ], 10 );
                aaaa = parseInt( adata[ 2 ], 10 );
                xdata = new Date( Date.UTC( aaaa, mm - 1, gg, 12, 0, 0, 0 ) );
                if ( ( xdata.getUTCFullYear() === aaaa ) && ( xdata.getUTCMonth() === mm - 1 ) && ( xdata.getUTCDate() === gg ) ) {
                        check = true;
                } else {
                        check = false;
                }
        } else {
                check = false;
        }
        return check;
    };
    
});
</script>
</body>
</html>