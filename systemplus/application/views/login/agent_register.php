<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo LTE; ?>bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo LTE; ?>dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo LTE; ?>plugins/iCheck/square/blue.css">
        <link rel="stylesheet" href="<?php echo LTE; ?>custom/custom.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style>
            .register-box{
                width: 630px;
            }
            .register-box .form-group{
                clear: both;
            }
            .register-box-body .form-group label:not(.error){
                float: left;
                width: 30%
            }
            .register-box-body .form-group div{
                float: left;
                width: 70%;
                margin-bottom: 15px;
            }
            .row-heder{
                padding: 10px;
                border-bottom: 1px solid;
                border-top: 1px solid;
                margin-bottom: 15px;
                margin-top: 35px;
            }
            .btn-group {
                margin-bottom: 2px;
                margin-top: 2px;
            }
        </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="<?php echo base_url(); ?>index.php/agents/register"><img style="margin-left: 68px" src="<?php echo base_url(); ?>img/logo-light.png" alt="plus-ed.com"></a>
  </div>
  <div class="register-box-body">
    
    <p class="login-box-msg">
        <b>Register</b><br/>
        I already have an account? <a href="<?php echo base_url();?>index.php/vauth/agents" class="text-center mr-bot-10">login</a>
    </p>
    
    <form id="frmRegister" action="<?php echo base_url(); ?>index.php/agents/confirm_registration" method="post">
        <div class="form-group">
            <span class="error"> *</span> Indicates the mandatory fields.
        </div>
        <div class="form-group">
            <label for="business_name">
                <strong>Business name<span class="error"> *</span></strong>
            </label>
            <div>
                    <input tabindex=1 type="text" class="form-control" name=business_name id=business_name value="<?php echo set_value('business_name',  '');?>" />
            </div>
            
            </div>
            <div class="form-group">
            <label for="address">
                    <strong>Address<span class="error"> *</span></strong>
            </label>
            <div>
                    <textarea tabindex=2 class="form-control" name=address id=address><?php echo set_value('address',  '');?></textarea>

            </div>
            </div>
            <div class="form-group">
            <label for="postal_code">
                    <strong>Postal code<span class="error"> *</span></strong>
            </label>
            <div>
                    <input tabindex=3 type="text" class="form-control" name=postal_code id=postal_code value="<?php echo set_value('postal_code',  '');?>"/>
            </div>
            </div>
            <div class="form-group">
            <label for="city">
                    <strong>City<span class="error"> *</span></strong>
            </label>
            <div>
                    <input tabindex=4 type="text" class="form-control" name=city id=city  value="<?php echo set_value('city',  '');?>"/>
            </div>
            </div>	
            <div class="form-group">
            <label for="country">
                    <strong>Country<span class="error"> *</span></strong>
            </label>
            <div>
                    <select tabindex=5 name=country id=country class="form-control">
                            <option value="" selected="selected">Select Country</option> 
                            <option value="Afghanistan">Afghanistan</option> 
                            <option value="Albania">Albania</option> 
                            <option value="Algeria">Algeria</option> 
                            <option value="American Samoa">American Samoa</option> 
                            <option value="Andorra">Andorra</option> 
                            <option value="Angola">Angola</option> 
                            <option value="Anguilla">Anguilla</option> 
                            <option value="Antarctica">Antarctica</option> 
                            <option value="Antigua and Barbuda">Antigua and Barbuda</option> 
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
                            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> 
                            <option value="Botswana">Botswana</option> 
                            <option value="Bouvet Island">Bouvet Island</option> 
                            <option value="Brazil">Brazil</option> 
                            <option value="British Indian Ocean Territory">British Indian Ocean Territory</option> 
                            <option value="Brunei Darussalam">Brunei Darussalam</option> 
                            <option value="Bulgaria">Bulgaria</option> 
                            <option value="Burkina Faso">Burkina Faso</option> 
                            <option value="Burundi">Burundi</option> 
                            <option value="Cambodia">Cambodia</option> 
                            <option value="Cameroon">Cameroon</option> 
                            <option value="Canada">Canada</option> 
                            <option value="Cape Verde">Cape Verde</option> 
                            <option value="Cayman Islands">Cayman Islands</option> 
                            <option value="Central African Republic">Central African Republic</option> 
                            <option value="Chad">Chad</option> 
                            <option value="Chile">Chile</option> 
                            <option value="China">China</option> 
                            <option value="Christmas Island">Christmas Island</option> 
                            <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> 
                            <option value="Colombia">Colombia</option> 
                            <option value="Comoros">Comoros</option> 
                            <option value="Congo">Congo</option> 
                            <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option> 
                            <option value="Cook Islands">Cook Islands</option> 
                            <option value="Costa Rica">Costa Rica</option> 
                            <option value="Cote D'ivoire">Cote D'ivoire</option> 
                            <option value="Croatia">Croatia</option> 
                            <option value="Cuba">Cuba</option> 
                            <option value="Cyprus">Cyprus</option> 
                            <option value="Czech Republic">Czech Republic</option> 
                            <option value="Denmark">Denmark</option> 
                            <option value="Djibouti">Djibouti</option> 
                            <option value="Dominica">Dominica</option> 
                            <option value="Dominican Republic">Dominican Republic</option> 
                            <option value="Ecuador">Ecuador</option> 
                            <option value="Egypt">Egypt</option> 
                            <option value="El Salvador">El Salvador</option> 
                            <option value="Equatorial Guinea">Equatorial Guinea</option> 
                            <option value="Eritrea">Eritrea</option> 
                            <option value="Estonia">Estonia</option> 
                            <option value="Ethiopia">Ethiopia</option> 
                            <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> 
                            <option value="Faroe Islands">Faroe Islands</option> 
                            <option value="Fiji">Fiji</option> 
                            <option value="Finland">Finland</option> 
                            <option value="France">France</option> 
                            <option value="French Guiana">French Guiana</option> 
                            <option value="French Polynesia">French Polynesia</option> 
                            <option value="French Southern Territories">French Southern Territories</option> 
                            <option value="Gabon">Gabon</option> 
                            <option value="Gambia">Gambia</option> 
                            <option value="Georgia">Georgia</option> 
                            <option value="Germany">Germany</option> 
                            <option value="Ghana">Ghana</option> 
                            <option value="Gibraltar">Gibraltar</option> 
                            <option value="Greece">Greece</option> 
                            <option value="Greenland">Greenland</option> 
                            <option value="Grenada">Grenada</option> 
                            <option value="Guadeloupe">Guadeloupe</option> 
                            <option value="Guam">Guam</option> 
                            <option value="Guatemala">Guatemala</option> 
                            <option value="Guinea">Guinea</option> 
                            <option value="Guinea-bissau">Guinea-bissau</option> 
                            <option value="Guyana">Guyana</option> 
                            <option value="Haiti">Haiti</option> 
                            <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option> 
                            <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> 
                            <option value="Honduras">Honduras</option> 
                            <option value="Hong Kong">Hong Kong</option> 
                            <option value="Hungary">Hungary</option> 
                            <option value="Iceland">Iceland</option> 
                            <option value="India">India</option> 
                            <option value="Indonesia">Indonesia</option> 
                            <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option> 
                            <option value="Iraq">Iraq</option> 
                            <option value="Ireland">Ireland</option> 
                            <option value="Israel">Israel</option> 
                            <option value="Italy">Italy</option> 
                            <option value="Jamaica">Jamaica</option> 
                            <option value="Japan">Japan</option> 
                            <option value="Jordan">Jordan</option> 
                            <option value="Kazakhstan">Kazakhstan</option> 
                            <option value="Kenya">Kenya</option> 
                            <option value="Kiribati">Kiribati</option> 
                            <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option> 
                            <option value="Korea, Republic of">Korea, Republic of</option> 
                            <option value="Kuwait">Kuwait</option> 
                            <option value="Kyrgyzstan">Kyrgyzstan</option> 
                            <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option> 
                            <option value="Latvia">Latvia</option> 
                            <option value="Lebanon">Lebanon</option> 
                            <option value="Lesotho">Lesotho</option> 
                            <option value="Liberia">Liberia</option> 
                            <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> 
                            <option value="Liechtenstein">Liechtenstein</option> 
                            <option value="Lithuania">Lithuania</option> 
                            <option value="Luxembourg">Luxembourg</option> 
                            <option value="Macao">Macao</option> 
                            <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option> 
                            <option value="Madagascar">Madagascar</option> 
                            <option value="Malawi">Malawi</option> 
                            <option value="Malaysia">Malaysia</option> 
                            <option value="Maldives">Maldives</option> 
                            <option value="Mali">Mali</option> 
                            <option value="Malta">Malta</option> 
                            <option value="Marshall Islands">Marshall Islands</option> 
                            <option value="Martinique">Martinique</option> 
                            <option value="Mauritania">Mauritania</option> 
                            <option value="Mauritius">Mauritius</option> 
                            <option value="Mayotte">Mayotte</option> 
                            <option value="Mexico">Mexico</option> 
                            <option value="Micronesia, Federated States of">Micronesia, Federated States of</option> 
                            <option value="Moldova, Republic of">Moldova, Republic of</option> 
                            <option value="Monaco">Monaco</option> 
                            <option value="Mongolia">Mongolia</option> 
                            <option value="Montserrat">Montserrat</option> 
                            <option value="Morocco">Morocco</option> 
                            <option value="Mozambique">Mozambique</option> 
                            <option value="Myanmar">Myanmar</option> 
                            <option value="Namibia">Namibia</option> 
                            <option value="Nauru">Nauru</option> 
                            <option value="Nepal">Nepal</option> 
                            <option value="Netherlands">Netherlands</option> 
                            <option value="Netherlands Antilles">Netherlands Antilles</option> 
                            <option value="New Caledonia">New Caledonia</option> 
                            <option value="New Zealand">New Zealand</option> 
                            <option value="Nicaragua">Nicaragua</option> 
                            <option value="Niger">Niger</option> 
                            <option value="Nigeria">Nigeria</option> 
                            <option value="Niue">Niue</option> 
                            <option value="Norfolk Island">Norfolk Island</option> 
                            <option value="Northern Mariana Islands">Northern Mariana Islands</option> 
                            <option value="Norway">Norway</option> 
                            <option value="Oman">Oman</option> 
                            <option value="Pakistan">Pakistan</option> 
                            <option value="Palau">Palau</option> 
                            <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> 
                            <option value="Panama">Panama</option> 
                            <option value="Papua New Guinea">Papua New Guinea</option> 
                            <option value="Paraguay">Paraguay</option> 
                            <option value="Peru">Peru</option> 
                            <option value="Philippines">Philippines</option> 
                            <option value="Pitcairn">Pitcairn</option> 
                            <option value="Poland">Poland</option> 
                            <option value="Portugal">Portugal</option> 
                            <option value="Puerto Rico">Puerto Rico</option> 
                            <option value="Qatar">Qatar</option> 
                            <option value="Reunion">Reunion</option> 
                            <option value="Romania">Romania</option> 
                            <option value="Russian Federation">Russian Federation</option> 
                            <option value="Rwanda">Rwanda</option> 
                            <option value="Saint Helena">Saint Helena</option> 
                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
                            <option value="Saint Lucia">Saint Lucia</option> 
                            <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> 
                            <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> 
                            <option value="Samoa">Samoa</option> 
                            <option value="San Marino">San Marino</option> 
                            <option value="Sao Tome and Principe">Sao Tome and Principe</option> 
                            <option value="Saudi Arabia">Saudi Arabia</option> 
                            <option value="Senegal">Senegal</option> 
                            <option value="Serbia and Montenegro">Serbia and Montenegro</option> 
                            <option value="Seychelles">Seychelles</option> 
                            <option value="Sierra Leone">Sierra Leone</option> 
                            <option value="Singapore">Singapore</option> 
                            <option value="Slovakia">Slovakia</option> 
                            <option value="Slovenia">Slovenia</option> 
                            <option value="Solomon Islands">Solomon Islands</option> 
                            <option value="Somalia">Somalia</option> 
                            <option value="South Africa">South Africa</option> 
                            <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option> 
                            <option value="Spain">Spain</option> 
                            <option value="Sri Lanka">Sri Lanka</option> 
                            <option value="Sudan">Sudan</option> 
                            <option value="Suriname">Suriname</option> 
                            <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> 
                            <option value="Swaziland">Swaziland</option> 
                            <option value="Sweden">Sweden</option> 
                            <option value="Switzerland">Switzerland</option> 
                            <option value="Syrian Arab Republic">Syrian Arab Republic</option> 
                            <option value="Taiwan">Taiwan</option> 
                            <option value="Tajikistan">Tajikistan</option> 
                            <option value="Tanzania, United Republic of">Tanzania, United Republic of</option> 
                            <option value="Thailand">Thailand</option> 
                            <option value="Timor-leste">Timor-leste</option> 
                            <option value="Togo">Togo</option> 
                            <option value="Tokelau">Tokelau</option> 
                            <option value="Tonga">Tonga</option> 
                            <option value="Trinidad and Tobago">Trinidad and Tobago</option> 
                            <option value="Tunisia">Tunisia</option> 
                            <option value="Turkey">Turkey</option> 
                            <option value="Turkmenistan">Turkmenistan</option> 
                            <option value="Turks and Caicos Islands">Turks and Caicos Islands</option> 
                            <option value="Tuvalu">Tuvalu</option> 
                            <option value="Uganda">Uganda</option> 
                            <option value="Ukraine">Ukraine</option> 
                            <option value="United Arab Emirates">United Arab Emirates</option> 
                            <option value="United Kingdom">United Kingdom</option> 
                            <option value="United States">United States</option> 
                            <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> 
                            <option value="Uruguay">Uruguay</option> 
                            <option value="Uzbekistan">Uzbekistan</option> 
                            <option value="Vanuatu">Vanuatu</option> 
                            <option value="Venezuela">Venezuela</option> 
                            <option value="Viet Nam">Viet Nam</option> 
                            <option value="Virgin Islands, British">Virgin Islands, British</option> 
                            <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> 
                            <option value="Wallis and Futuna">Wallis and Futuna</option> 
                            <option value="Western Sahara">Western Sahara</option> 
                            <option value="Yemen">Yemen</option> 
                            <option value="Zambia">Zambia</option> 
                            <option value="Zimbabwe">Zimbabwe</option>
                    </select>
            </div>
            </div>	
            <div class="form-group">
            <label for="email">
                    <strong>Email<span class="error"> *</span></strong>
            </label>
            <div>
                    <input tabindex=6 type="text" class="form-control email" name=email id=email  value="<?php echo set_value('email',  '');?>"/>
            </div>
            </div>	
            <div class="form-group">
            <label for="phone">
                    <strong>Telephone<span class="error"> *</span></strong>
            </label>
            <div>
                    <input tabindex=7 type="text" class="form-control" name=phone id=phone value="<?php echo set_value('phone',  '');?>" />
            </div>
            </div>	
            <div class="form-group">
            <label for="firstname">
                    <strong>First name<span class="error"> *</span></strong>
            </label>
            <div>
                    <input tabindex=8 type="text" class="form-control" name=firstname id=firstname value="<?php echo set_value('firstname',  '');?>"/>
            </div>
            </div>	
            <div class="form-group">
            <label for="familyname">
                    <strong>Family name<span class="error"> *</span></strong>
            </label>
            <div>
                    <input tabindex=8 type="text" class="form-control" name=familyname id=familyname value="<?php echo set_value('familyname',  '');?>" />
            </div>
            </div>	
            <div class="form-group" style="margin-bottom: 20px;">
            <label for="hmstudents">
                    <strong>How many students did you<br />send abroad last year?<span class="error"> *</span></strong>
            </label>
            <div>
                    <select tabindex=9 name=hmstudents id=hmstudents class="form-control">
                            <option value="">Please select</option>
                            <option value="1">1-49</option>
                            <option value="200">50-199</option>
                            <option value="200">200-500</option>
                            <option value="501">501-1500</option>
                            <option value="1501">1501 and over</option>
                    </select>
            </div>
            </div>
            <div class="row">
                <div class="row-heder">
                    <b>
                        How were these students apportioned according to the following categories?
                    </b>        
                </div>
            </div>
        
            <div class="form-group">
            <label for="portionjs">
                    <strong>Junior Summer</strong>
            </label>
            <div>
                    <select tabindex=10 name=portionjs id=portionjs class="form-control">
                            <option value="1">1-10 %</option>
                            <option value="11">11-30 %</option>
                            <option value="30">30-60 %</option>
                            <option value="60">+60 %</option>
                    </select>
            </div>
            </div>	
            <div class="form-group">
            <label for="portionll">
                    <strong>Language learning</strong>
            </label>
            <div>
                    <select tabindex=11 name=portionll id=portionll class="form-control">
                            <option value="1">1-10 %</option>
                            <option value="11">11-30 %</option>
                            <option value="30">30-60 %</option>
                            <option value="60">+60 %</option>
                    </select>
            </div>
            </div>	
            <div class="form-group">
            <label for="portionup">
                    <strong>University placement</strong>
            </label>
            <div>
                    <select tabindex=12 name=portionup id=portionup class="form-control">
                            <option value="1">1-10 %</option>
                            <option value="11">11-30 %</option>
                            <option value="30">30-60 %</option>
                            <option value="60">+60 %</option>
                    </select>
            </div>
            </div>	
            <div class="row">
                <div class="col-xs-8">
                <label for="destinations">
                        <strong>Which Countries are the most popular destination?<span class="error"> *</span></strong>
                </label>
                </div>
            </div>
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-xs-12">
                    <select multiple class="dualselects form-control" data-size=small id=destinations name=destinations[] >
                    <?php
                            foreach($pref_dest as $singledest){
                    ?>
                            <option name="<?php echo $singledest['pp_id'] ?>"><?php echo $singledest['pp_dest'] ?></option>
                    <?php
                    }
                    ?>
                    </select>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                        <input id="chkAcceptTerms" name="chkAcceptTerms" type="checkbox"> I agree to the <a href="#">terms</a>
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
                <!-- /.col -->
            </div>
         <?php 
            //$validation_errors = $this->session->flashdata("validation_errors");
            if(isset($validation_errors))
            if($validation_errors)
            {
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert-danger alert_error" style="padding: 10px;">
                            <?php echo $validation_errors;?>
                        </div>
                    </div>
                </div>
        <?php }?>
    </form>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo LTE; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo LTE; ?>bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo LTE; ?>bootstrap/dualselect/bootstrap-duallistbox.css"></script>
<script src="<?php echo LTE; ?>bootstrap/dualselect/jquery.bootstrap-duallistbox.js"></script>
<link rel="stylesheet" href="<?php echo LTE;?>plugins/sweetalert/sweetalert.css">
<script src="<?php echo LTE;?>plugins/sweetalert/sweetalert.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
    
    var demo2 = $('#destinations').bootstrapDualListbox({
        nonSelectedListLabel: 'Non-selected',
        selectedListLabel: 'Selected',
        preserveSelectionOnMove: 'moved',
        moveOnSelect: false
    });
    
    $("#frmRegister").validate({
        //errorElement:"div",
        ignore: "",
        rules: {
                business_name: {
                        required: true
                },
                address: {
                        required: true
                },
                postal_code: {
                        required: true
                },
                city: {
                        required: true
                },
                country: {
                        required: true
                },
                email: {
                        required: true
                },
                phone: {
                        required: true
                },
                firstname: {
                        required: true
                },
                familyname: {
                        required: true
                },
                hmstudents: {
                        required: true
                },
                destinations: {
                        required: true
                }
                
        },
        messages: {
                business_name: "Please enter your business name",
                address: "Please enter your address",
                postal_code: "Please enter your postal code",
                city: "Please enter your city",
                country: "Please enter your country",
                email: "Please enter your email",
                phone: "Please enter your telephone",
                firstname: "Please enter your first name",
                familyname: "Please enter your family name",
                hmstudents: "Please select number of students",
                destinations: "Please select popular destination"
        },
        submitHandler: function(form) {
            var isChecked = $("#chkAcceptTerms").prop('checked');
            if(isChecked)
                form.submit();
            else
                swal('Warning', 'You need to accept terms before registration');
        }
});
  });
</script>
</body>
</html>
