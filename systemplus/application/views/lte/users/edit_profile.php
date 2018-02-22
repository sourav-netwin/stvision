<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header with-border">
				<h2 class="box-title"><?php echo $breadcrumb2; ?></h2>
			</div>
			<div class="box-body">
				<form enctype="multipart/form-data" method="post" class="no_validate" id="frmTeacher" action="">
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtFirstName" >
								<strong>First name</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<input  type="text" id="txtFirstName" name="txtFirstName" class="required form-control"   maxlength="100" value="<?php echo set_value('txtFirstName', $formData['ta_firstname']); ?>" >
							<div class="error"><?php echo form_error('txtFirstName'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtLastName" >
								<strong>Last name</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<input type="text" id="txtLastName" name="txtLastName" class="required form-control"   maxlength="100" value="<?php echo set_value('txtLastName', $formData['ta_lastname']); ?>" >
							<div class="error"><?php echo form_error('txtLastName'); ?></div>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtDateofBirth" >
								<strong>Birth date</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<input type="text" placeholder="dd/mm/yyyy" id="txtDateofBirth" name="txtDateofBirth" class="required form-control"   maxlength="100" value="<?php echo set_value('txtDateofBirth', $formData['ta_date_of_birth']); ?>" >
							<div class="error"><?php echo form_error('txtDateofBirth'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="selNationality" >
								<strong>Nationality</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<select id="selNationality" class="form-control" name="selNationality">
								<option <?php echo ($formData['ta_nationality'] == 'afghan' ? "selected='selected'" : ''); ?> value='afghan'>Afghan</option>
								<option <?php echo ($formData['ta_nationality'] == 'albanian' ? "selected='selected'" : ''); ?> value='albanian'>Albanian</option>
								<option <?php echo ($formData['ta_nationality'] == 'algerian' ? "selected='selected'" : ''); ?> value='algerian'>Algerian</option>
								<option <?php echo ($formData['ta_nationality'] == 'american' ? "selected='selected'" : ''); ?> value='american'>American</option>
								<option <?php echo ($formData['ta_nationality'] == 'andorran' ? "selected='selected'" : ''); ?> value='andorran'>Andorran</option>
								<option <?php echo ($formData['ta_nationality'] == 'angolan' ? "selected='selected'" : ''); ?> value='angolan'>Angolan</option>
								<option <?php echo ($formData['ta_nationality'] == 'antiguans' ? "selected='selected'" : ''); ?> value='antiguans'>Antiguans</option>
								<option <?php echo ($formData['ta_nationality'] == 'argentinean' ? "selected='selected'" : ''); ?> value='argentinean'>Argentinean</option>
								<option <?php echo ($formData['ta_nationality'] == 'armenian' ? "selected='selected'" : ''); ?> value='armenian'>Armenian</option>
								<option <?php echo ($formData['ta_nationality'] == 'australian' ? "selected='selected'" : ''); ?> value='australian'>Australian</option>
								<option <?php echo ($formData['ta_nationality'] == 'austrian' ? "selected='selected'" : ''); ?> value='austrian'>Austrian</option>
								<option <?php echo ($formData['ta_nationality'] == 'azerbaijani' ? "selected='selected'" : ''); ?> value='azerbaijani'>Azerbaijani</option>
								<option <?php echo ($formData['ta_nationality'] == 'bahamian' ? "selected='selected'" : ''); ?> value='bahamian'>Bahamian</option>
								<option <?php echo ($formData['ta_nationality'] == 'bahraini' ? "selected='selected'" : ''); ?> value='bahraini'>Bahraini</option>
								<option <?php echo ($formData['ta_nationality'] == 'bangladeshi' ? "selected='selected'" : ''); ?> value='bangladeshi'>Bangladeshi</option>
								<option <?php echo ($formData['ta_nationality'] == 'barbadian' ? "selected='selected'" : ''); ?> value='barbadian'>Barbadian</option>
								<option <?php echo ($formData['ta_nationality'] == 'barbudans' ? "selected='selected'" : ''); ?> value='barbudans'>Barbudans</option>
								<option <?php echo ($formData['ta_nationality'] == 'batswana' ? "selected='selected'" : ''); ?> value='batswana'>Batswana</option>
								<option <?php echo ($formData['ta_nationality'] == 'belarusian' ? "selected='selected'" : ''); ?> value='belarusian'>Belarusian</option>
								<option <?php echo ($formData['ta_nationality'] == 'belgian' ? "selected='selected'" : ''); ?> value='belgian'>Belgian</option>
								<option <?php echo ($formData['ta_nationality'] == 'belizean' ? "selected='selected'" : ''); ?> value='belizean'>Belizean</option>
								<option <?php echo ($formData['ta_nationality'] == 'beninese' ? "selected='selected'" : ''); ?> value='beninese'>Beninese</option>
								<option <?php echo ($formData['ta_nationality'] == 'bhutanese' ? "selected='selected'" : ''); ?> value='bhutanese'>Bhutanese</option>
								<option <?php echo ($formData['ta_nationality'] == 'bolivian' ? "selected='selected'" : ''); ?> value='bolivian'>Bolivian</option>
								<option <?php echo ($formData['ta_nationality'] == 'bosnian' ? "selected='selected'" : ''); ?> value='bosnian'>Bosnian</option>
								<option <?php echo ($formData['ta_nationality'] == 'brazilian' ? "selected='selected'" : ''); ?> value='brazilian'>Brazilian</option>
								<option <?php echo ($formData['ta_nationality'] == 'british' ? "selected='selected'" : ''); ?> value='british'>British</option>
								<option <?php echo ($formData['ta_nationality'] == 'bruneian' ? "selected='selected'" : ''); ?> value='bruneian'>Bruneian</option>
								<option <?php echo ($formData['ta_nationality'] == 'bulgarian' ? "selected='selected'" : ''); ?> value='bulgarian'>Bulgarian</option>
								<option <?php echo ($formData['ta_nationality'] == 'burkinabe' ? "selected='selected'" : ''); ?> value='burkinabe'>Burkinabe</option>
								<option <?php echo ($formData['ta_nationality'] == 'burmese' ? "selected='selected'" : ''); ?> value='burmese'>Burmese</option>
								<option <?php echo ($formData['ta_nationality'] == 'burundian' ? "selected='selected'" : ''); ?> value='burundian'>Burundian</option>
								<option <?php echo ($formData['ta_nationality'] == 'cambodian' ? "selected='selected'" : ''); ?> value='cambodian'>Cambodian</option>
								<option <?php echo ($formData['ta_nationality'] == 'cameroonian' ? "selected='selected'" : ''); ?> value='cameroonian'>Cameroonian</option>
								<option <?php echo ($formData['ta_nationality'] == 'canadian' ? "selected='selected'" : ''); ?> value='canadian'>Canadian</option>
								<option <?php echo ($formData['ta_nationality'] == 'cape verdean' ? "selected='selected'" : ''); ?> value='cape verdean'>Cape Verdean</option>
								<option <?php echo ($formData['ta_nationality'] == 'central african' ? "selected='selected'" : ''); ?> value='central african'>Central African</option>
								<option <?php echo ($formData['ta_nationality'] == 'chadian' ? "selected='selected'" : ''); ?> value='chadian'>Chadian</option>
								<option <?php echo ($formData['ta_nationality'] == 'chilean' ? "selected='selected'" : ''); ?> value='chilean'>Chilean</option>
								<option <?php echo ($formData['ta_nationality'] == 'chinese' ? "selected='selected'" : ''); ?> value='chinese'>Chinese</option>
								<option <?php echo ($formData['ta_nationality'] == 'colombian' ? "selected='selected'" : ''); ?> value='colombian'>Colombian</option>
								<option <?php echo ($formData['ta_nationality'] == 'comoran' ? "selected='selected'" : ''); ?> value='comoran'>Comoran</option>
								<option <?php echo ($formData['ta_nationality'] == 'congolese' ? "selected='selected'" : ''); ?> value='congolese'>Congolese</option>
								<option <?php echo ($formData['ta_nationality'] == 'costa rican' ? "selected='selected'" : ''); ?> value='costa rican'>Costa Rican</option>
								<option <?php echo ($formData['ta_nationality'] == 'croatian' ? "selected='selected'" : ''); ?> value='croatian'>Croatian</option>
								<option <?php echo ($formData['ta_nationality'] == 'cuban' ? "selected='selected'" : ''); ?> value='cuban'>Cuban</option>
								<option <?php echo ($formData['ta_nationality'] == 'cypriot' ? "selected='selected'" : ''); ?> value='cypriot'>Cypriot</option>
								<option <?php echo ($formData['ta_nationality'] == 'czech' ? "selected='selected'" : ''); ?> value='czech'>Czech</option>
								<option <?php echo ($formData['ta_nationality'] == 'danish' ? "selected='selected'" : ''); ?> value='danish'>Danish</option>
								<option <?php echo ($formData['ta_nationality'] == 'djibouti' ? "selected='selected'" : ''); ?> value='djibouti'>Djibouti</option>
								<option <?php echo ($formData['ta_nationality'] == 'dominican' ? "selected='selected'" : ''); ?> value='dominican'>Dominican</option>
								<option <?php echo ($formData['ta_nationality'] == 'dutch' ? "selected='selected'" : ''); ?> value='dutch'>Dutch</option>
								<option <?php echo ($formData['ta_nationality'] == 'east timorese' ? "selected='selected'" : ''); ?> value='east timorese'>East Timorese</option>
								<option <?php echo ($formData['ta_nationality'] == 'ecuadorean' ? "selected='selected'" : ''); ?> value='ecuadorean'>Ecuadorean</option>
								<option <?php echo ($formData['ta_nationality'] == 'egyptian' ? "selected='selected'" : ''); ?> value='egyptian'>Egyptian</option>
								<option <?php echo ($formData['ta_nationality'] == 'emirian' ? "selected='selected'" : ''); ?> value='emirian'>Emirian</option>
								<option <?php echo ($formData['ta_nationality'] == 'equatorial guinean' ? "selected='selected'" : ''); ?> value='equatorial guinean'>Equatorial Guinean</option>
								<option <?php echo ($formData['ta_nationality'] == 'eritrean' ? "selected='selected'" : ''); ?> value='eritrean'>Eritrean</option>
								<option <?php echo ($formData['ta_nationality'] == 'estonian' ? "selected='selected'" : ''); ?> value='estonian'>Estonian</option>
								<option <?php echo ($formData['ta_nationality'] == 'ethiopian' ? "selected='selected'" : ''); ?> value='ethiopian'>Ethiopian</option>
								<option <?php echo ($formData['ta_nationality'] == 'fijian' ? "selected='selected'" : ''); ?> value='fijian'>Fijian</option>
								<option <?php echo ($formData['ta_nationality'] == 'filipino' ? "selected='selected'" : ''); ?> value='filipino'>Filipino</option>
								<option <?php echo ($formData['ta_nationality'] == 'finnish' ? "selected='selected'" : ''); ?> value='finnish'>Finnish</option>
								<option <?php echo ($formData['ta_nationality'] == 'french' ? "selected='selected'" : ''); ?> value='french'>French</option>
								<option <?php echo ($formData['ta_nationality'] == 'gabonese' ? "selected='selected'" : ''); ?> value='gabonese'>Gabonese</option>
								<option <?php echo ($formData['ta_nationality'] == 'gambian' ? "selected='selected'" : ''); ?> value='gambian'>Gambian</option>
								<option <?php echo ($formData['ta_nationality'] == 'georgian' ? "selected='selected'" : ''); ?> value='georgian'>Georgian</option>
								<option <?php echo ($formData['ta_nationality'] == 'german' ? "selected='selected'" : ''); ?> value='german'>German</option>
								<option <?php echo ($formData['ta_nationality'] == 'ghanaian' ? "selected='selected'" : ''); ?> value='ghanaian'>Ghanaian</option>
								<option <?php echo ($formData['ta_nationality'] == 'greek' ? "selected='selected'" : ''); ?> value='greek'>Greek</option>
								<option <?php echo ($formData['ta_nationality'] == 'grenadian' ? "selected='selected'" : ''); ?> value='grenadian'>Grenadian</option>
								<option <?php echo ($formData['ta_nationality'] == 'guatemalan' ? "selected='selected'" : ''); ?> value='guatemalan'>Guatemalan</option>
								<option <?php echo ($formData['ta_nationality'] == 'guinea-bissauan' ? "selected='selected'" : ''); ?> value='guinea-bissauan'>Guinea-Bissauan</option>
								<option <?php echo ($formData['ta_nationality'] == 'guinean' ? "selected='selected'" : ''); ?> value='guinean'>Guinean</option>
								<option <?php echo ($formData['ta_nationality'] == 'guyanese' ? "selected='selected'" : ''); ?> value='guyanese'>Guyanese</option>
								<option <?php echo ($formData['ta_nationality'] == 'haitian' ? "selected='selected'" : ''); ?> value='haitian'>Haitian</option>
								<option <?php echo ($formData['ta_nationality'] == 'herzegovinian' ? "selected='selected'" : ''); ?> value='herzegovinian'>Herzegovinian</option>
								<option <?php echo ($formData['ta_nationality'] == 'honduran' ? "selected='selected'" : ''); ?> value='honduran'>Honduran</option>
								<option <?php echo ($formData['ta_nationality'] == 'hungarian' ? "selected='selected'" : ''); ?> value='hungarian'>Hungarian</option>
								<option <?php echo ($formData['ta_nationality'] == 'icelander' ? "selected='selected'" : ''); ?> value='icelander'>Icelander</option>
								<option <?php echo ($formData['ta_nationality'] == 'indian' ? "selected='selected'" : ''); ?> value='indian'>Indian</option>
								<option <?php echo ($formData['ta_nationality'] == 'indonesian' ? "selected='selected'" : ''); ?> value='indonesian'>Indonesian</option>
								<option <?php echo ($formData['ta_nationality'] == 'iranian' ? "selected='selected'" : ''); ?> value='iranian'>Iranian</option>
								<option <?php echo ($formData['ta_nationality'] == 'iraqi' ? "selected='selected'" : ''); ?> value='iraqi'>Iraqi</option>
								<option <?php echo ($formData['ta_nationality'] == 'irish' ? "selected='selected'" : ''); ?> value='irish'>Irish</option>
								<option <?php echo ($formData['ta_nationality'] == 'israeli' ? "selected='selected'" : ''); ?> value='israeli'>Israeli</option>
								<option <?php echo ($formData['ta_nationality'] == 'italian' ? "selected='selected'" : ''); ?> value='italian'>Italian</option>
								<option <?php echo ($formData['ta_nationality'] == 'ivorian' ? "selected='selected'" : ''); ?> value='ivorian'>Ivorian</option>
								<option <?php echo ($formData['ta_nationality'] == 'jamaican' ? "selected='selected'" : ''); ?> value='jamaican'>Jamaican</option>
								<option <?php echo ($formData['ta_nationality'] == 'japanese' ? "selected='selected'" : ''); ?> value='japanese'>Japanese</option>
								<option <?php echo ($formData['ta_nationality'] == 'jordanian' ? "selected='selected'" : ''); ?> value='jordanian'>Jordanian</option>
								<option <?php echo ($formData['ta_nationality'] == 'kazakhstani' ? "selected='selected'" : ''); ?> value='kazakhstani'>Kazakhstani</option>
								<option <?php echo ($formData['ta_nationality'] == 'kenyan' ? "selected='selected'" : ''); ?> value='kenyan'>Kenyan</option>
								<option <?php echo ($formData['ta_nationality'] == 'kittian and nevisian' ? "selected='selected'" : ''); ?> value='kittian and nevisian'>Kittian and Nevisian</option>
								<option <?php echo ($formData['ta_nationality'] == 'kuwaiti' ? "selected='selected'" : ''); ?> value='kuwaiti'>Kuwaiti</option>
								<option <?php echo ($formData['ta_nationality'] == 'kyrgyz' ? "selected='selected'" : ''); ?> value='kyrgyz'>Kyrgyz</option>
								<option <?php echo ($formData['ta_nationality'] == 'laotian' ? "selected='selected'" : ''); ?> value='laotian'>Laotian</option>
								<option <?php echo ($formData['ta_nationality'] == 'latvian' ? "selected='selected'" : ''); ?> value='latvian'>Latvian</option>
								<option <?php echo ($formData['ta_nationality'] == 'lebanese' ? "selected='selected'" : ''); ?> value='lebanese'>Lebanese</option>
								<option <?php echo ($formData['ta_nationality'] == 'liberian' ? "selected='selected'" : ''); ?> value='liberian'>Liberian</option>
								<option <?php echo ($formData['ta_nationality'] == 'libyan' ? "selected='selected'" : ''); ?> value='libyan'>Libyan</option>
								<option <?php echo ($formData['ta_nationality'] == 'liechtensteiner' ? "selected='selected'" : ''); ?> value='liechtensteiner'>Liechtensteiner</option>
								<option <?php echo ($formData['ta_nationality'] == 'lithuanian' ? "selected='selected'" : ''); ?> value='lithuanian'>Lithuanian</option>
								<option <?php echo ($formData['ta_nationality'] == 'luxembourger' ? "selected='selected'" : ''); ?> value='luxembourger'>Luxembourger</option>
								<option <?php echo ($formData['ta_nationality'] == 'macedonian' ? "selected='selected'" : ''); ?> value='macedonian'>Macedonian</option>
								<option <?php echo ($formData['ta_nationality'] == 'malagasy' ? "selected='selected'" : ''); ?> value='malagasy'>Malagasy</option>
								<option <?php echo ($formData['ta_nationality'] == 'malawian' ? "selected='selected'" : ''); ?> value='malawian'>Malawian</option>
								<option <?php echo ($formData['ta_nationality'] == 'malaysian' ? "selected='selected'" : ''); ?> value='malaysian'>Malaysian</option>
								<option <?php echo ($formData['ta_nationality'] == 'maldivan' ? "selected='selected'" : ''); ?> value='maldivan'>Maldivan</option>
								<option <?php echo ($formData['ta_nationality'] == 'malian' ? "selected='selected'" : ''); ?> value='malian'>Malian</option>
								<option <?php echo ($formData['ta_nationality'] == 'maltese' ? "selected='selected'" : ''); ?> value='maltese'>Maltese</option>
								<option <?php echo ($formData['ta_nationality'] == 'marshallese' ? "selected='selected'" : ''); ?> value='marshallese'>Marshallese</option>
								<option <?php echo ($formData['ta_nationality'] == 'mauritanian' ? "selected='selected'" : ''); ?> value='mauritanian'>Mauritanian</option>
								<option <?php echo ($formData['ta_nationality'] == 'mauritian' ? "selected='selected'" : ''); ?> value='mauritian'>Mauritian</option>
								<option <?php echo ($formData['ta_nationality'] == 'mexican' ? "selected='selected'" : ''); ?> value='mexican'>Mexican</option>
								<option <?php echo ($formData['ta_nationality'] == 'micronesian' ? "selected='selected'" : ''); ?> value='micronesian'>Micronesian</option>
								<option <?php echo ($formData['ta_nationality'] == 'moldovan' ? "selected='selected'" : ''); ?> value='moldovan'>Moldovan</option>
								<option <?php echo ($formData['ta_nationality'] == 'monacan' ? "selected='selected'" : ''); ?> value='monacan'>Monacan</option>
								<option <?php echo ($formData['ta_nationality'] == 'mongolian' ? "selected='selected'" : ''); ?> value='mongolian'>Mongolian</option>
								<option <?php echo ($formData['ta_nationality'] == 'moroccan' ? "selected='selected'" : ''); ?> value='moroccan'>Moroccan</option>
								<option <?php echo ($formData['ta_nationality'] == 'mosotho' ? "selected='selected'" : ''); ?> value='mosotho'>Mosotho</option>
								<option <?php echo ($formData['ta_nationality'] == 'motswana' ? "selected='selected'" : ''); ?> value='motswana'>Motswana</option>
								<option <?php echo ($formData['ta_nationality'] == 'mozambican' ? "selected='selected'" : ''); ?> value='mozambican'>Mozambican</option>
								<option <?php echo ($formData['ta_nationality'] == 'namibian' ? "selected='selected'" : ''); ?> value='namibian'>Namibian</option>
								<option <?php echo ($formData['ta_nationality'] == 'nauruan' ? "selected='selected'" : ''); ?> value='nauruan'>Nauruan</option>
								<option <?php echo ($formData['ta_nationality'] == 'nepalese' ? "selected='selected'" : ''); ?> value='nepalese'>Nepalese</option>
								<option <?php echo ($formData['ta_nationality'] == 'new zealander' ? "selected='selected'" : ''); ?> value='new zealander'>New Zealander</option>
								<option <?php echo ($formData['ta_nationality'] == 'ni-vanuatu' ? "selected='selected'" : ''); ?> value='ni-vanuatu'>Ni-Vanuatu</option>
								<option <?php echo ($formData['ta_nationality'] == 'nicaraguan' ? "selected='selected'" : ''); ?> value='nicaraguan'>Nicaraguan</option>
								<option <?php echo ($formData['ta_nationality'] == 'nigerien' ? "selected='selected'" : ''); ?> value='nigerien'>Nigerien</option>
								<option <?php echo ($formData['ta_nationality'] == 'north korean' ? "selected='selected'" : ''); ?> value='north korean'>North Korean</option>
								<option <?php echo ($formData['ta_nationality'] == 'northern irish' ? "selected='selected'" : ''); ?> value='northern irish'>Northern Irish</option>
								<option <?php echo ($formData['ta_nationality'] == 'norwegian' ? "selected='selected'" : ''); ?> value='norwegian'>Norwegian</option>
								<option <?php echo ($formData['ta_nationality'] == 'omani' ? "selected='selected'" : ''); ?> value='omani'>Omani</option>
								<option <?php echo ($formData['ta_nationality'] == 'pakistani' ? "selected='selected'" : ''); ?> value='pakistani'>Pakistani</option>
								<option <?php echo ($formData['ta_nationality'] == 'palauan' ? "selected='selected'" : ''); ?> value='palauan'>Palauan</option>
								<option <?php echo ($formData['ta_nationality'] == 'panamanian' ? "selected='selected'" : ''); ?> value='panamanian'>Panamanian</option>
								<option <?php echo ($formData['ta_nationality'] == 'papua new guinean' ? "selected='selected'" : ''); ?> value='papua new guinean'>Papua New Guinean</option>
								<option <?php echo ($formData['ta_nationality'] == 'paraguayan' ? "selected='selected'" : ''); ?> value='paraguayan'>Paraguayan</option>
								<option <?php echo ($formData['ta_nationality'] == 'peruvian' ? "selected='selected'" : ''); ?> value='peruvian'>Peruvian</option>
								<option <?php echo ($formData['ta_nationality'] == 'polish' ? "selected='selected'" : ''); ?> value='polish'>Polish</option>
								<option <?php echo ($formData['ta_nationality'] == 'portuguese' ? "selected='selected'" : ''); ?> value='portuguese'>Portuguese</option>
								<option <?php echo ($formData['ta_nationality'] == 'qatari' ? "selected='selected'" : ''); ?> value='qatari'>Qatari</option>
								<option <?php echo ($formData['ta_nationality'] == 'romanian' ? "selected='selected'" : ''); ?> value='romanian'>Romanian</option>
								<option <?php echo ($formData['ta_nationality'] == 'russian' ? "selected='selected'" : ''); ?> value='russian'>Russian</option>
								<option <?php echo ($formData['ta_nationality'] == 'rwandan' ? "selected='selected'" : ''); ?> value='rwandan'>Rwandan</option>
								<option <?php echo ($formData['ta_nationality'] == 'saint lucian' ? "selected='selected'" : ''); ?> value='saint lucian'>Saint Lucian</option>
								<option <?php echo ($formData['ta_nationality'] == 'salvadoran' ? "selected='selected'" : ''); ?> value='salvadoran'>Salvadoran</option>
								<option <?php echo ($formData['ta_nationality'] == 'samoan' ? "selected='selected'" : ''); ?> value='samoan'>Samoan</option>
								<option <?php echo ($formData['ta_nationality'] == 'san marinese' ? "selected='selected'" : ''); ?> value='san marinese'>San Marinese</option>
								<option <?php echo ($formData['ta_nationality'] == 'sao tomean' ? "selected='selected'" : ''); ?> value='sao tomean'>Sao Tomean</option>
								<option <?php echo ($formData['ta_nationality'] == 'saudi' ? "selected='selected'" : ''); ?> value='saudi'>Saudi</option>
								<option <?php echo ($formData['ta_nationality'] == 'scottish' ? "selected='selected'" : ''); ?> value='scottish'>Scottish</option>
								<option <?php echo ($formData['ta_nationality'] == 'senegalese' ? "selected='selected'" : ''); ?> value='senegalese'>Senegalese</option>
								<option <?php echo ($formData['ta_nationality'] == 'serbian' ? "selected='selected'" : ''); ?> value='serbian'>Serbian</option>
								<option <?php echo ($formData['ta_nationality'] == 'seychellois' ? "selected='selected'" : ''); ?> value='seychellois'>Seychellois</option>
								<option <?php echo ($formData['ta_nationality'] == 'sierra leonean' ? "selected='selected'" : ''); ?> value='sierra leonean'>Sierra Leonean</option>
								<option <?php echo ($formData['ta_nationality'] == 'singaporean' ? "selected='selected'" : ''); ?> value='singaporean'>Singaporean</option>
								<option <?php echo ($formData['ta_nationality'] == 'slovakian' ? "selected='selected'" : ''); ?> value='slovakian'>Slovakian</option>
								<option <?php echo ($formData['ta_nationality'] == 'slovenian' ? "selected='selected'" : ''); ?> value='slovenian'>Slovenian</option>
								<option <?php echo ($formData['ta_nationality'] == 'solomon islander' ? "selected='selected'" : ''); ?> value='solomon islander'>Solomon Islander</option>
								<option <?php echo ($formData['ta_nationality'] == 'somali' ? "selected='selected'" : ''); ?> value='somali'>Somali</option>
								<option <?php echo ($formData['ta_nationality'] == 'south african' ? "selected='selected'" : ''); ?> value='south african'>South African</option>
								<option <?php echo ($formData['ta_nationality'] == 'south korean' ? "selected='selected'" : ''); ?> value='south korean'>South Korean</option>
								<option <?php echo ($formData['ta_nationality'] == 'spanish' ? "selected='selected'" : ''); ?> value='spanish'>Spanish</option>
								<option <?php echo ($formData['ta_nationality'] == 'sri lankan' ? "selected='selected'" : ''); ?> value='sri lankan'>Sri Lankan</option>
								<option <?php echo ($formData['ta_nationality'] == 'sudanese' ? "selected='selected'" : ''); ?> value='sudanese'>Sudanese</option>
								<option <?php echo ($formData['ta_nationality'] == 'surinamer' ? "selected='selected'" : ''); ?> value='surinamer'>Surinamer</option>
								<option <?php echo ($formData['ta_nationality'] == 'swazi' ? "selected='selected'" : ''); ?> value='swazi'>Swazi</option>
								<option <?php echo ($formData['ta_nationality'] == 'swedish' ? "selected='selected'" : ''); ?> value='swedish'>Swedish</option>
								<option <?php echo ($formData['ta_nationality'] == 'swiss' ? "selected='selected'" : ''); ?> value='swiss'>Swiss</option>
								<option <?php echo ($formData['ta_nationality'] == 'syrian' ? "selected='selected'" : ''); ?> value='syrian'>Syrian</option>
								<option <?php echo ($formData['ta_nationality'] == 'taiwanese' ? "selected='selected'" : ''); ?> value='taiwanese'>Taiwanese</option>
								<option <?php echo ($formData['ta_nationality'] == 'tajik' ? "selected='selected'" : ''); ?> value='tajik'>Tajik</option>
								<option <?php echo ($formData['ta_nationality'] == 'tanzanian' ? "selected='selected'" : ''); ?> value='tanzanian'>Tanzanian</option>
								<option <?php echo ($formData['ta_nationality'] == 'thai' ? "selected='selected'" : ''); ?> value='thai'>Thai</option>
								<option <?php echo ($formData['ta_nationality'] == 'togolese' ? "selected='selected'" : ''); ?> value='togolese'>Togolese</option>
								<option <?php echo ($formData['ta_nationality'] == 'tongan' ? "selected='selected'" : ''); ?> value='tongan'>Tongan</option>
								<option <?php echo ($formData['ta_nationality'] == 'trinidadian or tobagonian' ? "selected='selected'" : ''); ?> value='trinidadian or tobagonian'>Trinidadian or Tobagonian</option>
								<option <?php echo ($formData['ta_nationality'] == 'tunisian' ? "selected='selected'" : ''); ?> value='tunisian'>Tunisian</option>
								<option <?php echo ($formData['ta_nationality'] == 'turkish' ? "selected='selected'" : ''); ?> value='turkish'>Turkish</option>
								<option <?php echo ($formData['ta_nationality'] == 'tuvaluan' ? "selected='selected'" : ''); ?> value='tuvaluan'>Tuvaluan</option>
								<option <?php echo ($formData['ta_nationality'] == 'ugandan' ? "selected='selected'" : ''); ?> value='ugandan'>Ugandan</option>
								<option <?php echo ($formData['ta_nationality'] == 'ukrainian' ? "selected='selected'" : ''); ?> value='ukrainian'>Ukrainian</option>
								<option <?php echo ($formData['ta_nationality'] == 'uruguayan' ? "selected='selected'" : ''); ?> value='uruguayan'>Uruguayan</option>
								<option <?php echo ($formData['ta_nationality'] == 'uzbekistani' ? "selected='selected'" : ''); ?> value='uzbekistani'>Uzbekistani</option>
								<option <?php echo ($formData['ta_nationality'] == 'venezuelan' ? "selected='selected'" : ''); ?> value='venezuelan'>Venezuelan</option>
								<option <?php echo ($formData['ta_nationality'] == 'vietnamese' ? "selected='selected'" : ''); ?> value='vietnamese'>Vietnamese</option>
								<option <?php echo ($formData['ta_nationality'] == 'welsh' ? "selected='selected'" : ''); ?> value='welsh'>Welsh</option>
								<option <?php echo ($formData['ta_nationality'] == 'yemenite' ? "selected='selected'" : ''); ?> value='yemenite'>Yemenite</option>
								<option <?php echo ($formData['ta_nationality'] == 'zambian' ? "selected='selected'" : ''); ?> value='zambian'>Zambian</option>
								<option <?php echo ($formData['ta_nationality'] == 'zimbabwean' ? "selected='selected'" : ''); ?> value='zimbabwean'>Zimbabwean</option>
							</select>
							<div class="error"><?php echo form_error('selNationality'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="selSex" >
								<strong>Gender</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<select id="selSex" class="form-control" name="selSex">
								<option <?php echo ($formData['ta_sex'] == 'Male' ? "selected='selected'" : ''); ?> value="male">Male</option>
								<option <?php echo ($formData['ta_sex'] == 'Female' ? "selected='selected'" : ''); ?> value="female">Female</option>
							</select>
							<div class="error"><?php echo form_error('selSex'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<h4>Contact</h4>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtEmail" >
								<strong>Email</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<input type="text" placeholder="E-mail address" name="txtEmail" id="txtEmail" class="required form-control"   maxlength="100" value="<?php echo set_value('txtEmail', $formData['ta_email']); ?>" >
							<div class="error"><?php echo form_error('txtEmail'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtTelephone" >
								<strong>Telephone</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<input type="text" class="required form-control" placeholder="Telephone" id="txtTelephone" name="txtTelephone" value="<?php echo set_value('txtTelephone', $formData['ta_telephone']); ?>" >
							<div class="error"><?php echo form_error('txtTelephone'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="selTeachYears" >
								<strong>Teach years</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<select class="required form-control" id="selTeachYears" name="selTeachYears"  >
								<option value=""> - Select - </option>
								<option <?php echo ($formData['ta_teach_years'] == '1-3' ? 'selected="selected"' : ''); ?> value="1-3">1-3 years</option>
								<option <?php echo ($formData['ta_teach_years'] == '4-7' ? 'selected="selected"' : ''); ?> value="4-7">4-7 years</option>
								<option <?php echo ($formData['ta_teach_years'] == '8' ? 'selected="selected"' : ''); ?> value="8">8 years or more</option>
							</select>
							<div class="error"><?php echo form_error('selTeachYears'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<h4>Address</h4>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtAddress" >
								<strong>Address</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<textarea rows="3" class="required form-control" placeholder="Address" id="txtAddress" name="txtAddress"><?php echo set_value('txtAddress', $formData['ta_address']); ?></textarea>
							<div class="error"><?php echo form_error('txtAddress'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtCity" >
								<strong>City</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<input type="text" class="required form-control" placeholder="City" id="txtCity" name="txtCity" value="<?php echo set_value('txtCity', $formData['ta_city']); ?>" >
							<div class="error"><?php echo form_error('txtCity'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="selPostCode" >
								<strong>Postcode</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<select class="required form-control" id="selPostCode" name="selPostCode"  >
								<?php
								if ($postcodeData) {
									foreach ($postcodeData as $postcode) {
										?><option <?php echo ($formData['ta_postcode'] == $postcode['code'] ? "selected='selected'" : ""); ?> value="<?php echo $postcode['code']; ?>"><?php echo $postcode['area']; ?></option><?php
							}
						}
								?>
							</select>
							<div class="error"><?php echo form_error('selPostCode'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="selCountry" >
								<strong>Country</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<select id="selCountry" class="form-control form-control" name="selCountry">
								<option <?php echo ($formData['ta_country'] == 'Afganistan' ? "selected='selected'" : ''); ?> value='Afganistan'>Afganistan</option>
								<option <?php echo ($formData['ta_country'] == 'Albania' ? "selected='selected'" : ''); ?> value='Albania'>Albania</option>
								<option <?php echo ($formData['ta_country'] == 'Algeria' ? "selected='selected'" : ''); ?> value='Algeria'>Algeria</option>
								<option <?php echo ($formData['ta_country'] == 'American Samoa' ? "selected='selected'" : ''); ?> value='American Samoa'>American Samoa</option>
								<option <?php echo ($formData['ta_country'] == 'Andorra' ? "selected='selected'" : ''); ?> value='Andorra'>Andorra</option>
								<option <?php echo ($formData['ta_country'] == 'Angola' ? "selected='selected'" : ''); ?> value='Angola'>Angola</option>
								<option <?php echo ($formData['ta_country'] == 'Anguilla' ? "selected='selected'" : ''); ?> value='Anguilla'>Anguilla</option>
								<option <?php echo ($formData['ta_country'] == 'Antigua &amp; Barbuda' ? "selected='selected'" : ''); ?> value='Antigua &amp; Barbuda'>Antigua &amp; Barbuda</option>
								<option <?php echo ($formData['ta_country'] == 'Argentina' ? "selected='selected'" : ''); ?> value='Argentina'>Argentina</option>
								<option <?php echo ($formData['ta_country'] == 'Armenia' ? "selected='selected'" : ''); ?> value='Armenia'>Armenia</option>
								<option <?php echo ($formData['ta_country'] == 'Aruba' ? "selected='selected'" : ''); ?> value='Aruba'>Aruba</option>
								<option <?php echo ($formData['ta_country'] == 'Australia' ? "selected='selected'" : ''); ?> value='Australia'>Australia</option>
								<option <?php echo ($formData['ta_country'] == 'Austria' ? "selected='selected'" : ''); ?> value='Austria'>Austria</option>
								<option <?php echo ($formData['ta_country'] == 'Azerbaijan' ? "selected='selected'" : ''); ?> value='Azerbaijan'>Azerbaijan</option>
								<option <?php echo ($formData['ta_country'] == 'Bahamas' ? "selected='selected'" : ''); ?> value='Bahamas'>Bahamas</option>
								<option <?php echo ($formData['ta_country'] == 'Bahrain' ? "selected='selected'" : ''); ?> value='Bahrain'>Bahrain</option>
								<option <?php echo ($formData['ta_country'] == 'Bangladesh' ? "selected='selected'" : ''); ?> value='Bangladesh'>Bangladesh</option>
								<option <?php echo ($formData['ta_country'] == 'Barbados' ? "selected='selected'" : ''); ?> value='Barbados'>Barbados</option>
								<option <?php echo ($formData['ta_country'] == 'Belarus' ? "selected='selected'" : ''); ?> value='Belarus'>Belarus</option>
								<option <?php echo ($formData['ta_country'] == 'Belgium' ? "selected='selected'" : ''); ?> value='Belgium'>Belgium</option>
								<option <?php echo ($formData['ta_country'] == 'Belize' ? "selected='selected'" : ''); ?> value='Belize'>Belize</option>
								<option <?php echo ($formData['ta_country'] == 'Benin' ? "selected='selected'" : ''); ?> value='Benin'>Benin</option>
								<option <?php echo ($formData['ta_country'] == 'Bermuda' ? "selected='selected'" : ''); ?> value='Bermuda'>Bermuda</option>
								<option <?php echo ($formData['ta_country'] == 'Bhutan' ? "selected='selected'" : ''); ?> value='Bhutan'>Bhutan</option>
								<option <?php echo ($formData['ta_country'] == 'Bolivia' ? "selected='selected'" : ''); ?> value='Bolivia'>Bolivia</option>
								<option <?php echo ($formData['ta_country'] == 'Bonaire' ? "selected='selected'" : ''); ?> value='Bonaire'>Bonaire</option>
								<option <?php echo ($formData['ta_country'] == 'Bosnia &amp; Herzegovina' ? "selected='selected'" : ''); ?> value='Bosnia &amp; Herzegovina'>Bosnia &amp; Herzegovina</option>
								<option <?php echo ($formData['ta_country'] == 'Botswana' ? "selected='selected'" : ''); ?> value='Botswana'>Botswana</option>
								<option <?php echo ($formData['ta_country'] == 'Brazil' ? "selected='selected'" : ''); ?> value='Brazil'>Brazil</option>
								<option <?php echo ($formData['ta_country'] == 'British Indian Ocean Ter' ? "selected='selected'" : ''); ?> value='British Indian Ocean Ter'>British Indian Ocean Ter</option>
								<option <?php echo ($formData['ta_country'] == 'Brunei' ? "selected='selected'" : ''); ?> value='Brunei'>Brunei</option>
								<option <?php echo ($formData['ta_country'] == 'Bulgaria' ? "selected='selected'" : ''); ?> value='Bulgaria'>Bulgaria</option>
								<option <?php echo ($formData['ta_country'] == 'Burkina Faso' ? "selected='selected'" : ''); ?> value='Burkina Faso'>Burkina Faso</option>
								<option <?php echo ($formData['ta_country'] == 'Burundi' ? "selected='selected'" : ''); ?> value='Burundi'>Burundi</option>
								<option <?php echo ($formData['ta_country'] == 'Cambodia' ? "selected='selected'" : ''); ?> value='Cambodia'>Cambodia</option>
								<option <?php echo ($formData['ta_country'] == 'Cameroon' ? "selected='selected'" : ''); ?> value='Cameroon'>Cameroon</option>
								<option <?php echo ($formData['ta_country'] == 'Canada' ? "selected='selected'" : ''); ?> value='Canada'>Canada</option>
								<option <?php echo ($formData['ta_country'] == 'Canary Islands' ? "selected='selected'" : ''); ?> value='Canary Islands'>Canary Islands</option>
								<option <?php echo ($formData['ta_country'] == 'Cape Verde' ? "selected='selected'" : ''); ?> value='Cape Verde'>Cape Verde</option>
								<option <?php echo ($formData['ta_country'] == 'Cayman Islands' ? "selected='selected'" : ''); ?> value='Cayman Islands'>Cayman Islands</option>
								<option <?php echo ($formData['ta_country'] == 'Central African Republic' ? "selected='selected'" : ''); ?> value='Central African Republic'>Central African Republic</option>
								<option <?php echo ($formData['ta_country'] == 'Chad' ? "selected='selected'" : ''); ?> value='Chad'>Chad</option>
								<option <?php echo ($formData['ta_country'] == 'Channel Islands' ? "selected='selected'" : ''); ?> value='Channel Islands'>Channel Islands</option>
								<option <?php echo ($formData['ta_country'] == 'Chile' ? "selected='selected'" : ''); ?> value='Chile'>Chile</option>
								<option <?php echo ($formData['ta_country'] == 'China' ? "selected='selected'" : ''); ?> value='China'>China</option>
								<option <?php echo ($formData['ta_country'] == 'Christmas Island' ? "selected='selected'" : ''); ?> value='Christmas Island'>Christmas Island</option>
								<option <?php echo ($formData['ta_country'] == 'Cocos Island' ? "selected='selected'" : ''); ?> value='Cocos Island'>Cocos Island</option>
								<option <?php echo ($formData['ta_country'] == 'Colombia' ? "selected='selected'" : ''); ?> value='Colombia'>Colombia</option>
								<option <?php echo ($formData['ta_country'] == 'Comoros' ? "selected='selected'" : ''); ?> value='Comoros'>Comoros</option>
								<option <?php echo ($formData['ta_country'] == 'Congo' ? "selected='selected'" : ''); ?> value='Congo'>Congo</option>
								<option <?php echo ($formData['ta_country'] == 'Cook Islands' ? "selected='selected'" : ''); ?> value='Cook Islands'>Cook Islands</option>
								<option <?php echo ($formData['ta_country'] == 'Costa Rica' ? "selected='selected'" : ''); ?> value='Costa Rica'>Costa Rica</option>
								<option <?php echo ($formData['ta_country'] == 'Cote DIvoire' ? "selected='selected'" : ''); ?> value='Cote DIvoire'>Cote DIvoire</option>
								<option <?php echo ($formData['ta_country'] == 'Croatia' ? "selected='selected'" : ''); ?> value='Croatia'>Croatia</option>
								<option <?php echo ($formData['ta_country'] == 'Cuba' ? "selected='selected'" : ''); ?> value='Cuba'>Cuba</option>
								<option <?php echo ($formData['ta_country'] == 'Curaco' ? "selected='selected'" : ''); ?> value='Curaco'>Curaco</option>
								<option <?php echo ($formData['ta_country'] == 'Cyprus' ? "selected='selected'" : ''); ?> value='Cyprus'>Cyprus</option>
								<option <?php echo ($formData['ta_country'] == 'Czech Republic' ? "selected='selected'" : ''); ?> value='Czech Republic'>Czech Republic</option>
								<option <?php echo ($formData['ta_country'] == 'Denmark' ? "selected='selected'" : ''); ?> value='Denmark'>Denmark</option>
								<option <?php echo ($formData['ta_country'] == 'Djibouti' ? "selected='selected'" : ''); ?> value='Djibouti'>Djibouti</option>
								<option <?php echo ($formData['ta_country'] == 'Dominica' ? "selected='selected'" : ''); ?> value='Dominica'>Dominica</option>
								<option <?php echo ($formData['ta_country'] == 'Dominican Republic' ? "selected='selected'" : ''); ?> value='Dominican Republic'>Dominican Republic</option>
								<option <?php echo ($formData['ta_country'] == 'East Timor' ? "selected='selected'" : ''); ?> value='East Timor'>East Timor</option>
								<option <?php echo ($formData['ta_country'] == 'Ecuador' ? "selected='selected'" : ''); ?> value='Ecuador'>Ecuador</option>
								<option <?php echo ($formData['ta_country'] == 'Egypt' ? "selected='selected'" : ''); ?> value='Egypt'>Egypt</option>
								<option <?php echo ($formData['ta_country'] == 'El Salvador' ? "selected='selected'" : ''); ?> value='El Salvador'>El Salvador</option>
								<option <?php echo ($formData['ta_country'] == 'Equatorial Guinea' ? "selected='selected'" : ''); ?> value='Equatorial Guinea'>Equatorial Guinea</option>
								<option <?php echo ($formData['ta_country'] == 'Eritrea' ? "selected='selected'" : ''); ?> value='Eritrea'>Eritrea</option>
								<option <?php echo ($formData['ta_country'] == 'Estonia' ? "selected='selected'" : ''); ?> value='Estonia'>Estonia</option>
								<option <?php echo ($formData['ta_country'] == 'Ethiopia' ? "selected='selected'" : ''); ?> value='Ethiopia'>Ethiopia</option>
								<option <?php echo ($formData['ta_country'] == 'Falkland Islands' ? "selected='selected'" : ''); ?> value='Falkland Islands'>Falkland Islands</option>
								<option <?php echo ($formData['ta_country'] == 'Faroe Islands' ? "selected='selected'" : ''); ?> value='Faroe Islands'>Faroe Islands</option>
								<option <?php echo ($formData['ta_country'] == 'Fiji' ? "selected='selected'" : ''); ?> value='Fiji'>Fiji</option>
								<option <?php echo ($formData['ta_country'] == 'Finland' ? "selected='selected'" : ''); ?> value='Finland'>Finland</option>
								<option <?php echo ($formData['ta_country'] == 'France' ? "selected='selected'" : ''); ?> value='France'>France</option>
								<option <?php echo ($formData['ta_country'] == 'French Guiana' ? "selected='selected'" : ''); ?> value='French Guiana'>French Guiana</option>
								<option <?php echo ($formData['ta_country'] == 'French Polynesia' ? "selected='selected'" : ''); ?> value='French Polynesia'>French Polynesia</option>
								<option <?php echo ($formData['ta_country'] == 'French Southern Ter' ? "selected='selected'" : ''); ?> value='French Southern Ter'>French Southern Ter</option>
								<option <?php echo ($formData['ta_country'] == 'Gabon' ? "selected='selected'" : ''); ?> value='Gabon'>Gabon</option>
								<option <?php echo ($formData['ta_country'] == 'Gambia' ? "selected='selected'" : ''); ?> value='Gambia'>Gambia</option>
								<option <?php echo ($formData['ta_country'] == 'Georgia' ? "selected='selected'" : ''); ?> value='Georgia'>Georgia</option>
								<option <?php echo ($formData['ta_country'] == 'Germany' ? "selected='selected'" : ''); ?> value='Germany'>Germany</option>
								<option <?php echo ($formData['ta_country'] == 'Ghana' ? "selected='selected'" : ''); ?> value='Ghana'>Ghana</option>
								<option <?php echo ($formData['ta_country'] == 'Gibraltar' ? "selected='selected'" : ''); ?> value='Gibraltar'>Gibraltar</option>
								<option <?php echo ($formData['ta_country'] == 'Great Britain' ? "selected='selected'" : ''); ?> value='Great Britain'>Great Britain</option>
								<option <?php echo ($formData['ta_country'] == 'Greece' ? "selected='selected'" : ''); ?> value='Greece'>Greece</option>
								<option <?php echo ($formData['ta_country'] == 'Greenland' ? "selected='selected'" : ''); ?> value='Greenland'>Greenland</option>
								<option <?php echo ($formData['ta_country'] == 'Grenada' ? "selected='selected'" : ''); ?> value='Grenada'>Grenada</option>
								<option <?php echo ($formData['ta_country'] == 'Guadeloupe' ? "selected='selected'" : ''); ?> value='Guadeloupe'>Guadeloupe</option>
								<option <?php echo ($formData['ta_country'] == 'Guam' ? "selected='selected'" : ''); ?> value='Guam'>Guam</option>
								<option <?php echo ($formData['ta_country'] == 'Guatemala' ? "selected='selected'" : ''); ?> value='Guatemala'>Guatemala</option>
								<option <?php echo ($formData['ta_country'] == 'Guinea' ? "selected='selected'" : ''); ?> value='Guinea'>Guinea</option>
								<option <?php echo ($formData['ta_country'] == 'Guyana' ? "selected='selected'" : ''); ?> value='Guyana'>Guyana</option>
								<option <?php echo ($formData['ta_country'] == 'Haiti' ? "selected='selected'" : ''); ?> value='Haiti'>Haiti</option>
								<option <?php echo ($formData['ta_country'] == 'Hawaii' ? "selected='selected'" : ''); ?> value='Hawaii'>Hawaii</option>
								<option <?php echo ($formData['ta_country'] == 'Honduras' ? "selected='selected'" : ''); ?> value='Honduras'>Honduras</option>
								<option <?php echo ($formData['ta_country'] == 'Hong Kong' ? "selected='selected'" : ''); ?> value='Hong Kong'>Hong Kong</option>
								<option <?php echo ($formData['ta_country'] == 'Hungary' ? "selected='selected'" : ''); ?> value='Hungary'>Hungary</option>
								<option <?php echo ($formData['ta_country'] == 'Iceland' ? "selected='selected'" : ''); ?> value='Iceland'>Iceland</option>
								<option <?php echo ($formData['ta_country'] == 'India' ? "selected='selected'" : ''); ?> value='India'>India</option>
								<option <?php echo ($formData['ta_country'] == 'Indonesia' ? "selected='selected'" : ''); ?> value='Indonesia'>Indonesia</option>
								<option <?php echo ($formData['ta_country'] == 'Iran' ? "selected='selected'" : ''); ?> value='Iran'>Iran</option>
								<option <?php echo ($formData['ta_country'] == 'Iraq' ? "selected='selected'" : ''); ?> value='Iraq'>Iraq</option>
								<option <?php echo ($formData['ta_country'] == 'Ireland' ? "selected='selected'" : ''); ?> value='Ireland'>Ireland</option>
								<option <?php echo ($formData['ta_country'] == 'Isle of Man' ? "selected='selected'" : ''); ?> value='Isle of Man'>Isle of Man</option>
								<option <?php echo ($formData['ta_country'] == 'Israel' ? "selected='selected'" : ''); ?> value='Israel'>Israel</option>
								<option <?php echo ($formData['ta_country'] == 'Italy' ? "selected='selected'" : ''); ?> value='Italy'>Italy</option>
								<option <?php echo ($formData['ta_country'] == 'Jamaica' ? "selected='selected'" : ''); ?> value='Jamaica'>Jamaica</option>
								<option <?php echo ($formData['ta_country'] == 'Japan' ? "selected='selected'" : ''); ?> value='Japan'>Japan</option>
								<option <?php echo ($formData['ta_country'] == 'Jordan' ? "selected='selected'" : ''); ?> value='Jordan'>Jordan</option>
								<option <?php echo ($formData['ta_country'] == 'Kazakhstan' ? "selected='selected'" : ''); ?> value='Kazakhstan'>Kazakhstan</option>
								<option <?php echo ($formData['ta_country'] == 'Kenya' ? "selected='selected'" : ''); ?> value='Kenya'>Kenya</option>
								<option <?php echo ($formData['ta_country'] == 'Kiribati' ? "selected='selected'" : ''); ?> value='Kiribati'>Kiribati</option>
								<option <?php echo ($formData['ta_country'] == 'Korea North' ? "selected='selected'" : ''); ?> value='Korea North'>Korea North</option>
								<option <?php echo ($formData['ta_country'] == 'Korea Sout' ? "selected='selected'" : ''); ?> value='Korea Sout'>Korea Sout</option>
								<option <?php echo ($formData['ta_country'] == 'Kuwait' ? "selected='selected'" : ''); ?> value='Kuwait'>Kuwait</option>
								<option <?php echo ($formData['ta_country'] == 'Kyrgyzstan' ? "selected='selected'" : ''); ?> value='Kyrgyzstan'>Kyrgyzstan</option>
								<option <?php echo ($formData['ta_country'] == 'Laos' ? "selected='selected'" : ''); ?> value='Laos'>Laos</option>
								<option <?php echo ($formData['ta_country'] == 'Latvia' ? "selected='selected'" : ''); ?> value='Latvia'>Latvia</option>
								<option <?php echo ($formData['ta_country'] == 'Lebanon' ? "selected='selected'" : ''); ?> value='Lebanon'>Lebanon</option>
								<option <?php echo ($formData['ta_country'] == 'Lesotho' ? "selected='selected'" : ''); ?> value='Lesotho'>Lesotho</option>
								<option <?php echo ($formData['ta_country'] == 'Liberia' ? "selected='selected'" : ''); ?> value='Liberia'>Liberia</option>
								<option <?php echo ($formData['ta_country'] == 'Libya' ? "selected='selected'" : ''); ?> value='Libya'>Libya</option>
								<option <?php echo ($formData['ta_country'] == 'Liechtenstein' ? "selected='selected'" : ''); ?> value='Liechtenstein'>Liechtenstein</option>
								<option <?php echo ($formData['ta_country'] == 'Lithuania' ? "selected='selected'" : ''); ?> value='Lithuania'>Lithuania</option>
								<option <?php echo ($formData['ta_country'] == 'Luxembourg' ? "selected='selected'" : ''); ?> value='Luxembourg'>Luxembourg</option>
								<option <?php echo ($formData['ta_country'] == 'Macau' ? "selected='selected'" : ''); ?> value='Macau'>Macau</option>
								<option <?php echo ($formData['ta_country'] == 'Macedonia' ? "selected='selected'" : ''); ?> value='Macedonia'>Macedonia</option>
								<option <?php echo ($formData['ta_country'] == 'Madagascar' ? "selected='selected'" : ''); ?> value='Madagascar'>Madagascar</option>
								<option <?php echo ($formData['ta_country'] == 'Malaysia' ? "selected='selected'" : ''); ?> value='Malaysia'>Malaysia</option>
								<option <?php echo ($formData['ta_country'] == 'Malawi' ? "selected='selected'" : ''); ?> value='Malawi'>Malawi</option>
								<option <?php echo ($formData['ta_country'] == 'Maldives' ? "selected='selected'" : ''); ?> value='Maldives'>Maldives</option>
								<option <?php echo ($formData['ta_country'] == 'Mali' ? "selected='selected'" : ''); ?> value='Mali'>Mali</option>
								<option <?php echo ($formData['ta_country'] == 'Malta' ? "selected='selected'" : ''); ?> value='Malta'>Malta</option>
								<option <?php echo ($formData['ta_country'] == 'Marshall Islands' ? "selected='selected'" : ''); ?> value='Marshall Islands'>Marshall Islands</option>
								<option <?php echo ($formData['ta_country'] == 'Martinique' ? "selected='selected'" : ''); ?> value='Martinique'>Martinique</option>
								<option <?php echo ($formData['ta_country'] == 'Mauritania' ? "selected='selected'" : ''); ?> value='Mauritania'>Mauritania</option>
								<option <?php echo ($formData['ta_country'] == 'Mauritius' ? "selected='selected'" : ''); ?> value='Mauritius'>Mauritius</option>
								<option <?php echo ($formData['ta_country'] == 'Mayotte' ? "selected='selected'" : ''); ?> value='Mayotte'>Mayotte</option>
								<option <?php echo ($formData['ta_country'] == 'Mexico' ? "selected='selected'" : ''); ?> value='Mexico'>Mexico</option>
								<option <?php echo ($formData['ta_country'] == 'Midway Islands' ? "selected='selected'" : ''); ?> value='Midway Islands'>Midway Islands</option>
								<option <?php echo ($formData['ta_country'] == 'Moldova' ? "selected='selected'" : ''); ?> value='Moldova'>Moldova</option>
								<option <?php echo ($formData['ta_country'] == 'Monaco' ? "selected='selected'" : ''); ?> value='Monaco'>Monaco</option>
								<option <?php echo ($formData['ta_country'] == 'Mongolia' ? "selected='selected'" : ''); ?> value='Mongolia'>Mongolia</option>
								<option <?php echo ($formData['ta_country'] == 'Montserrat' ? "selected='selected'" : ''); ?> value='Montserrat'>Montserrat</option>
								<option <?php echo ($formData['ta_country'] == 'Morocco' ? "selected='selected'" : ''); ?> value='Morocco'>Morocco</option>
								<option <?php echo ($formData['ta_country'] == 'Mozambique' ? "selected='selected'" : ''); ?> value='Mozambique'>Mozambique</option>
								<option <?php echo ($formData['ta_country'] == 'Myanmar' ? "selected='selected'" : ''); ?> value='Myanmar'>Myanmar</option>
								<option <?php echo ($formData['ta_country'] == 'Nambia' ? "selected='selected'" : ''); ?> value='Nambia'>Nambia</option>
								<option <?php echo ($formData['ta_country'] == 'Nauru' ? "selected='selected'" : ''); ?> value='Nauru'>Nauru</option>
								<option <?php echo ($formData['ta_country'] == 'Nepal' ? "selected='selected'" : ''); ?> value='Nepal'>Nepal</option>
								<option <?php echo ($formData['ta_country'] == 'Netherland Antilles' ? "selected='selected'" : ''); ?> value='Netherland Antilles'>Netherland Antilles</option>
								<option <?php echo ($formData['ta_country'] == 'Netherlands' ? "selected='selected'" : ''); ?> value='Netherlands'>Netherlands</option>
								<option <?php echo ($formData['ta_country'] == 'Nevis' ? "selected='selected'" : ''); ?> value='Nevis'>Nevis</option>
								<option <?php echo ($formData['ta_country'] == 'New Caledonia' ? "selected='selected'" : ''); ?> value='New Caledonia'>New Caledonia</option>
								<option <?php echo ($formData['ta_country'] == 'New Zealand' ? "selected='selected'" : ''); ?> value='New Zealand'>New Zealand</option>
								<option <?php echo ($formData['ta_country'] == 'Nicaragua' ? "selected='selected'" : ''); ?> value='Nicaragua'>Nicaragua</option>
								<option <?php echo ($formData['ta_country'] == 'Niger' ? "selected='selected'" : ''); ?> value='Niger'>Niger</option>
								<option <?php echo ($formData['ta_country'] == 'Nigeria' ? "selected='selected'" : ''); ?> value='Nigeria'>Nigeria</option>
								<option <?php echo ($formData['ta_country'] == 'Niue' ? "selected='selected'" : ''); ?> value='Niue'>Niue</option>
								<option <?php echo ($formData['ta_country'] == 'Norfolk Island' ? "selected='selected'" : ''); ?> value='Norfolk Island'>Norfolk Island</option>
								<option <?php echo ($formData['ta_country'] == 'Norway' ? "selected='selected'" : ''); ?> value='Norway'>Norway</option>
								<option <?php echo ($formData['ta_country'] == 'Oman' ? "selected='selected'" : ''); ?> value='Oman'>Oman</option>
								<option <?php echo ($formData['ta_country'] == 'Pakistan' ? "selected='selected'" : ''); ?> value='Pakistan'>Pakistan</option>
								<option <?php echo ($formData['ta_country'] == 'Palau Island' ? "selected='selected'" : ''); ?> value='Palau Island'>Palau Island</option>
								<option <?php echo ($formData['ta_country'] == 'Palestine' ? "selected='selected'" : ''); ?> value='Palestine'>Palestine</option>
								<option <?php echo ($formData['ta_country'] == 'Panama' ? "selected='selected'" : ''); ?> value='Panama'>Panama</option>
								<option <?php echo ($formData['ta_country'] == 'Papua New Guinea' ? "selected='selected'" : ''); ?> value='Papua New Guinea'>Papua New Guinea</option>
								<option <?php echo ($formData['ta_country'] == 'Paraguay' ? "selected='selected'" : ''); ?> value='Paraguay'>Paraguay</option>
								<option <?php echo ($formData['ta_country'] == 'Peru' ? "selected='selected'" : ''); ?> value='Peru'>Peru</option>
								<option <?php echo ($formData['ta_country'] == 'Phillipines' ? "selected='selected'" : ''); ?> value='Phillipines'>Phillipines</option>
								<option <?php echo ($formData['ta_country'] == 'Pitcairn Island' ? "selected='selected'" : ''); ?> value='Pitcairn Island'>Pitcairn Island</option>
								<option <?php echo ($formData['ta_country'] == 'Poland' ? "selected='selected'" : ''); ?> value='Poland'>Poland</option>
								<option <?php echo ($formData['ta_country'] == 'Portugal' ? "selected='selected'" : ''); ?> value='Portugal'>Portugal</option>
								<option <?php echo ($formData['ta_country'] == 'Puerto Rico' ? "selected='selected'" : ''); ?> value='Puerto Rico'>Puerto Rico</option>
								<option <?php echo ($formData['ta_country'] == 'Qatar' ? "selected='selected'" : ''); ?> value='Qatar'>Qatar</option>
								<option <?php echo ($formData['ta_country'] == 'Republic of Montenegro' ? "selected='selected'" : ''); ?> value='Republic of Montenegro'>Republic of Montenegro</option>
								<option <?php echo ($formData['ta_country'] == 'Republic of Serbia' ? "selected='selected'" : ''); ?> value='Republic of Serbia'>Republic of Serbia</option>
								<option <?php echo ($formData['ta_country'] == 'Reunion' ? "selected='selected'" : ''); ?> value='Reunion'>Reunion</option>
								<option <?php echo ($formData['ta_country'] == 'Romania' ? "selected='selected'" : ''); ?> value='Romania'>Romania</option>
								<option <?php echo ($formData['ta_country'] == 'Russia' ? "selected='selected'" : ''); ?> value='Russia'>Russia</option>
								<option <?php echo ($formData['ta_country'] == 'Rwanda' ? "selected='selected'" : ''); ?> value='Rwanda'>Rwanda</option>
								<option <?php echo ($formData['ta_country'] == 'St Barthelemy' ? "selected='selected'" : ''); ?> value='St Barthelemy'>St Barthelemy</option>
								<option <?php echo ($formData['ta_country'] == 'St Eustatius' ? "selected='selected'" : ''); ?> value='St Eustatius'>St Eustatius</option>
								<option <?php echo ($formData['ta_country'] == 'St Helena' ? "selected='selected'" : ''); ?> value='St Helena'>St Helena</option>
								<option <?php echo ($formData['ta_country'] == 'St Kitts-Nevis' ? "selected='selected'" : ''); ?> value='St Kitts-Nevis'>St Kitts-Nevis</option>
								<option <?php echo ($formData['ta_country'] == 'St Lucia' ? "selected='selected'" : ''); ?> value='St Lucia'>St Lucia</option>
								<option <?php echo ($formData['ta_country'] == 'St Maarten' ? "selected='selected'" : ''); ?> value='St Maarten'>St Maarten</option>
								<option <?php echo ($formData['ta_country'] == 'St Pierre &amp; Miquelon' ? "selected='selected'" : ''); ?> value='St Pierre &amp; Miquelon'>St Pierre &amp; Miquelon</option>
								<option <?php echo ($formData['ta_country'] == 'St Vincent &amp; Grenadines' ? "selected='selected'" : ''); ?> value='St Vincent &amp; Grenadines'>St Vincent &amp; Grenadines</option>
								<option <?php echo ($formData['ta_country'] == 'Saipan' ? "selected='selected'" : ''); ?> value='Saipan'>Saipan</option>
								<option <?php echo ($formData['ta_country'] == 'Samoa' ? "selected='selected'" : ''); ?> value='Samoa'>Samoa</option>
								<option <?php echo ($formData['ta_country'] == 'Samoa American' ? "selected='selected'" : ''); ?> value='Samoa American'>Samoa American</option>
								<option <?php echo ($formData['ta_country'] == 'San Marino' ? "selected='selected'" : ''); ?> value='San Marino'>San Marino</option>
								<option <?php echo ($formData['ta_country'] == 'Sao Tome &amp; Principe' ? "selected='selected'" : ''); ?> value='Sao Tome &amp; Principe'>Sao Tome &amp; Principe</option>
								<option <?php echo ($formData['ta_country'] == 'Saudi Arabia' ? "selected='selected'" : ''); ?> value='Saudi Arabia'>Saudi Arabia</option>
								<option <?php echo ($formData['ta_country'] == 'Senegal' ? "selected='selected'" : ''); ?> value='Senegal'>Senegal</option>
								<option <?php echo ($formData['ta_country'] == 'Seychelles' ? "selected='selected'" : ''); ?> value='Seychelles'>Seychelles</option>
								<option <?php echo ($formData['ta_country'] == 'Sierra Leone' ? "selected='selected'" : ''); ?> value='Sierra Leone'>Sierra Leone</option>
								<option <?php echo ($formData['ta_country'] == 'Singapore' ? "selected='selected'" : ''); ?> value='Singapore'>Singapore</option>
								<option <?php echo ($formData['ta_country'] == 'Slovakia' ? "selected='selected'" : ''); ?> value='Slovakia'>Slovakia</option>
								<option <?php echo ($formData['ta_country'] == 'Slovenia' ? "selected='selected'" : ''); ?> value='Slovenia'>Slovenia</option>
								<option <?php echo ($formData['ta_country'] == 'Solomon Islands' ? "selected='selected'" : ''); ?> value='Solomon Islands'>Solomon Islands</option>
								<option <?php echo ($formData['ta_country'] == 'Somalia' ? "selected='selected'" : ''); ?> value='Somalia'>Somalia</option>
								<option <?php echo ($formData['ta_country'] == 'South Africa' ? "selected='selected'" : ''); ?> value='South Africa'>South Africa</option>
								<option <?php echo ($formData['ta_country'] == 'Spain' ? "selected='selected'" : ''); ?> value='Spain'>Spain</option>
								<option <?php echo ($formData['ta_country'] == 'Sri Lanka' ? "selected='selected'" : ''); ?> value='Sri Lanka'>Sri Lanka</option>
								<option <?php echo ($formData['ta_country'] == 'Sudan' ? "selected='selected'" : ''); ?> value='Sudan'>Sudan</option>
								<option <?php echo ($formData['ta_country'] == 'Suriname' ? "selected='selected'" : ''); ?> value='Suriname'>Suriname</option>
								<option <?php echo ($formData['ta_country'] == 'Swaziland' ? "selected='selected'" : ''); ?> value='Swaziland'>Swaziland</option>
								<option <?php echo ($formData['ta_country'] == 'Sweden' ? "selected='selected'" : ''); ?> value='Sweden'>Sweden</option>
								<option <?php echo ($formData['ta_country'] == 'Switzerland' ? "selected='selected'" : ''); ?> value='Switzerland'>Switzerland</option>
								<option <?php echo ($formData['ta_country'] == 'Syria' ? "selected='selected'" : ''); ?> value='Syria'>Syria</option>
								<option <?php echo ($formData['ta_country'] == 'Tahiti' ? "selected='selected'" : ''); ?> value='Tahiti'>Tahiti</option>
								<option <?php echo ($formData['ta_country'] == 'Taiwan' ? "selected='selected'" : ''); ?> value='Taiwan'>Taiwan</option>
								<option <?php echo ($formData['ta_country'] == 'Tajikistan' ? "selected='selected'" : ''); ?> value='Tajikistan'>Tajikistan</option>
								<option <?php echo ($formData['ta_country'] == 'Tanzania' ? "selected='selected'" : ''); ?> value='Tanzania'>Tanzania</option>
								<option <?php echo ($formData['ta_country'] == 'Thailand' ? "selected='selected'" : ''); ?> value='Thailand'>Thailand</option>
								<option <?php echo ($formData['ta_country'] == 'Togo' ? "selected='selected'" : ''); ?> value='Togo'>Togo</option>
								<option <?php echo ($formData['ta_country'] == 'Tokelau' ? "selected='selected'" : ''); ?> value='Tokelau'>Tokelau</option>
								<option <?php echo ($formData['ta_country'] == 'Tonga' ? "selected='selected'" : ''); ?> value='Tonga'>Tonga</option>
								<option <?php echo ($formData['ta_country'] == 'Trinidad &amp; Tobago' ? "selected='selected'" : ''); ?> value='Trinidad &amp; Tobago'>Trinidad &amp; Tobago</option>
								<option <?php echo ($formData['ta_country'] == 'Tunisia' ? "selected='selected'" : ''); ?> value='Tunisia'>Tunisia</option>
								<option <?php echo ($formData['ta_country'] == 'Turkey' ? "selected='selected'" : ''); ?> value='Turkey'>Turkey</option>
								<option <?php echo ($formData['ta_country'] == 'Turkmenistan' ? "selected='selected'" : ''); ?> value='Turkmenistan'>Turkmenistan</option>
								<option <?php echo ($formData['ta_country'] == 'Turks &amp; Caicos Is' ? "selected='selected'" : ''); ?> value='Turks &amp; Caicos Is'>Turks &amp; Caicos Is</option>
								<option <?php echo ($formData['ta_country'] == 'Tuvalu' ? "selected='selected'" : ''); ?> value='Tuvalu'>Tuvalu</option>
								<option <?php echo ($formData['ta_country'] == 'Uganda' ? "selected='selected'" : ''); ?> value='Uganda'>Uganda</option>
								<option <?php echo ($formData['ta_country'] == 'Ukraine' ? "selected='selected'" : ''); ?> value='Ukraine'>Ukraine</option>
								<option <?php echo ($formData['ta_country'] == 'United Arab Erimates' ? "selected='selected'" : ''); ?> value='United Arab Erimates'>United Arab Erimates</option>
								<option <?php echo ($formData['ta_country'] == 'United Kingdom' ? "selected='selected'" : ''); ?> value='United Kingdom'>United Kingdom</option>
								<option <?php echo ($formData['ta_country'] == 'United States of America' ? "selected='selected'" : ''); ?> value='United States of America'>United States of America</option>
								<option <?php echo ($formData['ta_country'] == 'Uraguay' ? "selected='selected'" : ''); ?> value='Uraguay'>Uraguay</option>
								<option <?php echo ($formData['ta_country'] == 'Uzbekistan' ? "selected='selected'" : ''); ?> value='Uzbekistan'>Uzbekistan</option>
								<option <?php echo ($formData['ta_country'] == 'Vanuatu' ? "selected='selected'" : ''); ?> value='Vanuatu'>Vanuatu</option>
								<option <?php echo ($formData['ta_country'] == 'Vatican City State' ? "selected='selected'" : ''); ?> value='Vatican City State'>Vatican City State</option>
								<option <?php echo ($formData['ta_country'] == 'Venezuela' ? "selected='selected'" : ''); ?> value='Venezuela'>Venezuela</option>
								<option <?php echo ($formData['ta_country'] == 'Vietnam' ? "selected='selected'" : ''); ?> value='Vietnam'>Vietnam</option>
								<option <?php echo ($formData['ta_country'] == 'Virgin Islands (Brit)' ? "selected='selected'" : ''); ?> value='Virgin Islands (Brit)'>Virgin Islands (Brit)</option>
								<option <?php echo ($formData['ta_country'] == 'Virgin Islands (USA)' ? "selected='selected'" : ''); ?> value='Virgin Islands (USA)'>Virgin Islands (USA)</option>
								<option <?php echo ($formData['ta_country'] == 'Wake Island' ? "selected='selected'" : ''); ?> value='Wake Island'>Wake Island</option>
								<option <?php echo ($formData['ta_country'] == 'Wallis &amp; Futana Is' ? "selected='selected'" : ''); ?> value='Wallis &amp; Futana Is'>Wallis &amp; Futana Is</option>
								<option <?php echo ($formData['ta_country'] == 'Yemen' ? "selected='selected'" : ''); ?> value='Yemen'>Yemen</option>
								<option <?php echo ($formData['ta_country'] == 'Zaire' ? "selected='selected'" : ''); ?> value='Zaire'>Zaire</option>
								<option <?php echo ($formData['ta_country'] == 'Zambia' ? "selected='selected'" : ''); ?> value='Zambia'>Zambia</option>
								<option <?php echo ($formData['ta_country'] == 'Zimbabwe' ? "selected='selected'" : ''); ?> value='Zimbabwe'>Zimbabwe</option>
							</select>
							<div class="error"><?php echo form_error('selCountry'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<h4>Additional information</h4>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtNiNumber" >
								<strong>NI Number</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<input type="text" placeholder="NI number" name="txtNiNumber" id="txtNiNumber" class="required form-control"   maxlength="100" value="<?php echo set_value('txtNiNumber', $formData['ta_ni_number']); ?>" >
							<div class="error"><?php echo form_error('txtNiNumber'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label >
								<strong>Right to work in UK</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<label for="radRtwinukYes">
								<input <?php echo ($formData['ta_right_to_work_uk'] == '1' ? 'checked="checked"' : ''); ?> type="radio" id="radRtwinukYes" name="radRtwinuk" value="1" class=" form-control" />
								Yes
							</label>&nbsp;&nbsp;
							<label for="radRtwinukNo">
								<input <?php echo ($formData['ta_right_to_work_uk'] == '0' ? 'checked="checked"' : ''); ?> type="radio" id="radRtwinukNo" name="radRtwinuk" value="0" class=" form-control" />
								No
							</label>
							<div class="error"><?php echo form_error('radRtwinuk'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtNiCategory" >
								<strong>NI category</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<input type="text" placeholder="NI category" name="txtNiCategory" id="txtNiCategory" class="required form-control" maxlength="100" value="<?php echo set_value('txtNiCategory', $formData['ta_ni_category']); ?>" />
							<div class="error"><?php echo form_error('txtNiCategory'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label >
								<strong>SLR</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<strong>Are you making Student Loan Repayments?</strong><br/>
							<label for="radSLRYes" >
								<input autocomplete="off" <?php echo ($formData['ta_making_slr'] == '1' ? 'checked="checked"' : ''); ?> type="radio" id="radSLRYes" name="radSLR" value="1" /> Yes
							</label>&nbsp;&nbsp;
							<label for="radSLRNo">
								<input autocomplete="off" <?php echo ($formData['ta_making_slr'] == '0' ? 'checked="checked"' : ''); ?> type="radio" id="radSLRNo" name="radSLR" value="0" /> No
							</label>
							<div class="error"><?php echo form_error('radSLR'); ?></div>
						</div>
					</div>
					<div id="slrPlanDiv" class="row form-group">
						<div class="col-md-2">
							<label >
								<strong>SLR plan</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<strong>If yes please advise if plan 1 or 2</strong><br/>
							<label for="radSLRPlan1" >
								<input autocomplete="off" <?php echo ($formData['ta_slr_plan'] == 'Plan 1' ? 'checked="checked"' : ''); ?> type="radio" id="radSLRPlan1" name="radSLRPlan" value="Plan 1" /> Plan 1
							</label>&nbsp;&nbsp;
							<label for="radSLRPlan2">
								<input autocomplete="off" <?php echo ($formData['ta_slr_plan'] == 'Plan 2' ? 'checked="checked"' : ''); ?> type="radio" id="radSLRPlan2" name="radSLRPlan" value="Plan 2" /> Plan 2
							</label>
							<div class="error"><?php echo form_error('radSLRNo'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label >
								<strong>P45</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<strong>Will you provide a P45 when you start?</strong><br/>
							<label for="radP45Yes" >
								<input autocomplete="off" <?php echo ($formData['ta_p45_status'] == '1' ? 'checked="checked"' : ''); ?> type="radio" id="radP45Yes" name="radP45" value="1" /> Yes
							</label>&nbsp;&nbsp;
							<label for="radP45No">
								<input autocomplete="off" <?php echo ($formData['ta_p45_status'] == '0' ? 'checked="checked"' : ''); ?> type="radio" id="radP45No" name="radP45" value="0" /> No
							</label>
							<div class="error"><?php echo form_error('radP45'); ?></div>
						</div>
					</div>
					<div id="strDeclDiv" class="row form-group">
						<div class="col-md-2">
							<label >
								<strong>Starter declaration</strong>
							</label>
						</div>
						<div class="form-data starterDecRad col-md-10" >
                                                    
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <strong>If no(P45) please select 1 starter declaration A/B/C</strong><br/>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label>
								<input autocomplete="off" <?php echo ($formData['ta_p45_starter_declaration'] == 'A' ? 'checked="checked"' : ''); ?> type="radio" id="radStarterDeclarationA" name="radStarterDeclaration" value="A" />
								<label data-toggle="tooltip" title="Starter declaration A: This is my first job since last 6 April and I have not been receiving taxable Jobseeker's Allowance, Employment and Support Allowance, taxable Incapacity Benefit, State or Occupational Pension." for="radStarterDeclarationA" > Starter declaration A</label>
                                                            </label>&nbsp;&nbsp;
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label>
								<input autocomplete="off" <?php echo ($formData['ta_p45_starter_declaration'] == 'B' ? 'checked="checked"' : ''); ?> type="radio" id="radStarterDeclarationB" name="radStarterDeclaration" value="B" />
                                                            </label> <label data-toggle="tooltip" title="Starter declaration B: This is now my only job but since last 6 April I have had another job, or received taxable Jobseeker's Allowance, Employment and Support Allowance or taxable Incapacity Benefit. I do not receive a State or Occupational Pension.
								   " for="radStarterDeclarationB" >Starter declaration B</label>&nbsp;&nbsp;
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label>
								<input autocomplete="off" <?php echo ($formData['ta_p45_starter_declaration'] == 'C' ? 'checked="checked"' : ''); ?> type="radio" id="radStarterDeclarationC" name="radStarterDeclaration" value="C" />
								<label data-toggle="tooltip" title="Starter declaration C: As well as my new job, I have another job or receive a State or Occupational Pension.
								   " for="radStarterDeclarationC">Starter declaration C</label>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="error"><?php echo form_error('radStarterDeclaration'); ?></div>
                                                        </div>
                                                    </row>
                                                </div>
                                            </div>
					</div>

					<div class="row form-group">
						<div class="col-md-12">
							<h4>Availability</h4>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtAblilityFrom" >
								<strong>Availability from</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<input type="text" placeholder="dd/mm/yyyy" name="txtAblilityFrom" id="txtAblilityFrom" class="required form-control"   maxlength="100" value="<?php echo set_value('txtAblilityFrom', $formData['ta_ablility_from']); ?>" >
							<div class="error"><?php echo form_error('txtAblilityFrom'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="txtAblilityTo" >
								<strong>Availability to</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<input type="text" placeholder="dd/mm/yyyy" name="txtAblilityTo" id="txtAblilityTo" class="required form-control"   maxlength="100" value="<?php echo set_value('txtAblilityTo', $formData['ta_ablility_to']); ?>" >
							<div class="error"><?php echo form_error('txtAblilityTo'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<h4>Diplomas</h4>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="selDiplomas" >
								<strong>Diplomas</strong>
							</label>
						</div>
						<div class="form-data col-md-10">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <input type="checkbox" <?php echo ($formData['ta_celta'] == 1 ? 'checked' : ''); ?> name="chkCelta" value="1" id="chkCelta">&nbsp;<label for="chkCelta">CELTA</label>
                                                        </div>
                                                        <div class="col-sm-6">
							<input type="checkbox" <?php echo ($formData['ta_trinity_tesol'] == 1 ? 'checked' : ''); ?> name="chkTrinityTesol" value="1" id="chkTrinityTesol">&nbsp;<label for="chkTrinityTesol">Trinity TESOL</label>
                                                        </div>
                                                        <div class="col-sm-6">
							<input type="checkbox" <?php echo ($formData['ta_delta'] == 1 ? 'checked' : ''); ?> name="chkDelta" value="1" id="chkDelta">&nbsp;<label for="chkDelta">DELTA</label>
                                                        </div>
                                                        <div class="col-sm-6">
							<input type="checkbox" <?php echo ($formData['ta_dip_tesol'] == 1 ? 'checked' : ''); ?> name="chkDipTesol" value="1" id="chkDipTesol">&nbsp;<label for="chkDipTesol">Dip. TESOL</label>
                                                        </div>
                                                        <div class="col-sm-6">
							<input type="checkbox" <?php echo ($formData['ta_b_ed'] == 1 ? 'checked' : ''); ?> name="chkBEd" value="1" id="chkBEd">&nbsp;<label for="chkBEd">B.Ed.</label>
                                                        </div>
                                                        <div class="col-sm-6">
							<input type="checkbox" <?php echo ($formData['ta_pgce'] == 1 ? 'checked' : ''); ?> name="chkPgce" value="1" id="chkPgce">&nbsp;<label for="chkPgce">PGCE (Primary, English or MFL)</label>
                                                        </div>
                                                        <div class="col-sm-6">
							<input type="checkbox" <?php echo ($formData['ta_ma_elt_tesol'] == 1 ? 'checked' : ''); ?> name="chkMaEltTesol" value="1" id="chkMaEltTesol">&nbsp;<label for="chkMaEltTesol">MA in ELT//TESOL</label>
                                                        </div>
                                                        <div class="col-sm-12">
							<div class="error"><?php echo form_error('selDiplomas'); ?></div>
                                                    </div>
						</div>
                                            </div>
					</div>
					<div class="row form-group">
						<div class="form-data col-md-6 col-sm-6" >
							<input <?php echo (empty($formData['ta_other_diploma']) ? '' : 'checked'); ?> type="checkbox" name="chkOther" id="chkOther">&nbsp;<label for="chkOther">Other diplomas</label>

						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2"></div>
						<div class="col-md-6">
							<input type="text" class="form-control" placeholder="If other, please specify" id="txtOtherDiploma" name="txtOtherDiploma" value="<?php echo set_value('txtOtherDiploma', $formData['ta_other_diploma']); ?>">
							<div class="error"><?php echo form_error('txtOtherDiploma'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="cvFile" >
								<strong>CV (doc, pdf)</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<input type="file" autocomplete="off" placeholder="Attach your CV" name="cvFile" id="cvFile" >
							<div class="error"><?php echo $formData['cv_file_error']; ?></div>
							<a target='_blank' href='<?php echo base_url() . CV_FILE_PATH . $formData['ta_cv']; ?>'><?php echo $formData['ta_cv']; ?></a>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="otherFile" >
								<strong>Other file</strong>
							</label>
						</div>
						<div class="form-data col-md-6" >
							<input type="file" placeholder="Attach another file (if any)" name="otherFile" id="otherFile" >
							<div class="error"><?php echo $formData['other_file_error']; ?></div>
							<a target='_blank' href='<?php echo base_url() . OTHER_FILE_PATH . $formData['ta_other_document']; ?>'><?php echo $formData['ta_other_document']; ?></a>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label for="passportOrIdCard" >
								<strong>Passport or ID card</strong>
							</label>
						</div>
						<div class="form-data col-md-6">
							<input type="file" placeholder="Attach passport or id card" name="passportOrIdCard" id="passportOrIdCard" >
							<div class="error"><?php echo $formData['passport_or_idcard_error']; ?></div>
							<a target='_blank' href='<?php echo base_url() . PASSPORT_ID_CARD_FILE . $formData['ta_passport_or_id_card']; ?>'><?php echo $formData['ta_passport_or_id_card']; ?></a>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 col-md-offset-3" >
							<input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id; ?>" />
							<input class="btn btn-primary btn-sm" type="submit" id="btnSave" name="btnSave" value="Submit" />
							<input class="btn btn-danger btn-sm" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url(); ?>index.php/users/documents'" />
						</div>
					</div>
				</form>
			</div><!-- End of .content -->
		</div><!-- End of .box -->
	</div><!-- End of .col-md-12 -->
</div>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script>
	var pageHighlightMenu = "users/documents";
	$(document).ready(function() {
		initFileInput();
		$('input[type="checkbox"], input[type="radio"]').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue'
		});
		$( "#txtAblilityFrom" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$( "#txtAblilityTo" ).datepicker( "option", "minDate", selectedDate );
			}
		});
            
		$( "#txtAblilityTo" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$( "#txtAblilityFrom" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
            
		$( "#txtDateofBirth" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				//
			}
		});
            
            
		//$( "body" ).on( "change", "input[name='radSLR']",function(){
		$( "body" ).on( "change", "input[type=radio][name=radSLR]",function(){
			var myVal = $(this).val();
			if(myVal == '1')
			{
				$("#slrPlanDiv").show();
				$("#slrPlanDiv .form-data").css('height','40px');
			}
			else
				$("#slrPlanDiv").hide();
		});
            
           
            
            
		//$( "body" ).on( "change", "input[name='radP45']",function(){
		$( "body" ).on( "change", "input[type=radio][name=radP45]",function(){
			var myVal = $(this).val();
			if(myVal == '1')
				$("#strDeclDiv").hide();
			else
				$("#strDeclDiv").show();
		});
            
		setTimeout(function(){ 
<?php if ($formData['ta_p45_status'] == '1') { ?>
				$("#strDeclDiv").hide();
	<?php
}
else {
	?>
					$("#strDeclDiv").show();
<?php } ?>
                   
<?php if ($formData['ta_making_slr'] == '1') { ?>
				$("#slrPlanDiv").show();
				$("#slrPlanDiv .form-data").css('height','40px');
	<?php
}
else {
	?>
					$("#slrPlanDiv").hide();
<?php } ?>
		}, 1000);
            
            
           
	});
</script>	