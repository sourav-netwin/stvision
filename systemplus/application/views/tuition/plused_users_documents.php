<?php $this->load->view('plused_header');?>
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
					<li><a href="<?php echo base_url(); ?>index.php/users/profile">Profile</a></li>
					<li class="line"></li>
					<li><a href="<?php echo base_url(); ?>index.php/users/logout">Logout</a></li>
				</ul>
			</div>
		</section><!-- End of .toolbar-->
<?php $this->load->view('plused_sidebar');?>		
	<script>
	$(document).ready(function() {
		$( "li#myaccount" ).addClass("current");
		$( "li#myaccount a" ).addClass("open");		
		$( "li#myaccount ul.sub" ).css('display','block');	
                $( "li#myaccount ul.sub li#myaccount_1" ).addClass("current");
                
	});
	</script>		
		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
                <div class="grid_12">
                    <div class="box">
                        <div class="header">
                            <h2>
                                <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png"><?php echo $breadcrumb2; ?>
                            </h2>
                        </div>
                        <div class="content">
                            <br/>
                            <div class="grid_6 left"><strong>Profile</strong></div>
                            <div class="grid_6 right">
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
                            </div>
                            <br/>
                                <hr />
                            <div class="detailsDiv">
                            <?php 
                                 if($usersData)
                                    {
                                        ?>
                                            <div class="clr">
                                                <div class="grid_3"><strong>Name:</strong></div>
                                                <div class="grid_9">
                                                    <input type="hidden" id="hiddTeacherAppId" value="<?php echo $usersData->ta_id;?>" />
                                                    <input type="hidden" id="hiddFirstName" value="<?php echo $usersData->ta_firstname;?>" />
                                                    <input type="hidden" id="hiddLastName" value="<?php echo $usersData->ta_lastname;?>" />
                                                    <input type="hidden" id="hiddAbilityFromDate" value="<?php echo date('d/m/Y',strtotime($usersData->ta_ablility_from));?>" />
                                                    <input type="hidden" id="hiddAbilityToDate" value="<?php echo date('d/m/Y',strtotime($usersData->ta_ablility_to));?>" />
                                                    <?php echo html_entity_decode($usersData->teacher_full_name);?>
                                                <div class="btn-profile-edit"><input type="button" class="" id="btnEditProfile" value="Edit" /></div>
                                                </div>
                                            </div>
                                            <div class="clr">
                                                <div class="grid_3"><strong>Date of birth:</strong></div>
                                                <div class="grid_3"><?php echo date('d/m/Y',strtotime($usersData->ta_date_of_birth));?></div>

                                                <div class="grid_3"><strong>Nationality:</strong></div>
                                                <div class="grid_3"><?php echo (empty($usersData->ta_nationality) ? '-' : ucfirst($usersData->ta_nationality));?></div>
                                            </div>
                                            <div class="clr">
                                                <div class="grid_3"><strong>Gender:</strong></div>
                                                <div class="grid_3"><?php echo (empty($usersData->ta_sex) ? '-' : $usersData->ta_sex);?></div>

                                                <div class="grid_3"><strong>Email:</strong></div>
                                                <div class="grid_3"><?php echo ($usersData->ta_email == "" ? "-" : $usersData->ta_email);?></div>
                                            </div>
                                            <div class="clr">
                                                <div class="grid_3"><strong>Telephone:</strong></div>
                                                <div class="grid_3"><?php echo ($usersData->ta_telephone == '' ? '-' : $usersData->ta_telephone);?></div>

                                                <div class="grid_3"><strong>Teach years:</strong></div>
                                                <div class="grid_3"><?php echo ($usersData->ta_teach_years == '' ? '-' : $usersData->ta_teach_years);?></div>
                                            </div>
                                            <div class="clr">
                                                <div class="grid_3"><strong>Available from:</strong></div>
                                                <div class="grid_3"><?php echo date('d/m/Y',strtotime($usersData->ta_ablility_from));?></div>

                                                <div class="grid_3"><strong>Available to:</strong></div>
                                                <div class="grid_3"><?php echo date('d/m/Y',strtotime($usersData->ta_ablility_to));?></div>
                                            </div>
                                            <div class="clr">
                                                <div class="grid_3"><strong>Address:</strong></div>
                                                <div class="grid_3"><?php echo ($usersData->ta_address == '' ? '-' : $usersData->ta_address);?></div>

                                                <div class="grid_3"><strong>City:</strong></div>
                                                <div class="grid_3"><?php echo ($usersData->ta_city == '' ? '-' : $usersData->ta_city);?></div>
                                            </div>
                                            <div class="clr">
                                                <div class="grid_3"><strong>Country:</strong></div>
                                                <div class="grid_3"><?php echo ($usersData->ta_country == '' ? '-' : $usersData->ta_country);?></div>

                                                <div class="grid_3"><strong>Postcode:</strong></div>
                                                <div class="grid_3"><?php echo ($usersData->postcode_area == '' ? '-' : $usersData->ta_postcode. ' ' .$usersData->postcode_area);?></div>
                                            </div>
                                            <div class="clr">
                                                <div class="grid_3"><strong>Diplomas:</strong></div>
                                                <div class="grid_9"><?php 
                                                    if($usersData->ta_celta)
                                                        echo "<span>CELTA</span>";
                                                    if($usersData->ta_trinity_tesol)
                                                        echo "<span>Trinity TESOL</span>";
                                                    if($usersData->ta_delta)
                                                        echo "<span>DELTA</span>";
                                                    if($usersData->ta_dip_tesol)
                                                        echo "<span>Dip. TESOL</span>";
                                                    if($usersData->ta_b_ed)
                                                        echo "<span>B.Ed.</span>";
                                                    if($usersData->ta_pgce)
                                                        echo "<span>PGCE (Primary, English or MFL)</span>";
                                                    if($usersData->ta_ma_elt_tesol)
                                                        echo "<span>MA in ELT//TESOL</span>";
                                                    if(!empty($usersData->ta_other_diploma))
                                                        echo "<span>".$usersData->ta_other_diploma."</span>";
                                                ?>
                                                </div>
                                            </div>
                                            <div class="clr">
                                                <div class="grid_3"><strong>CV File:</strong></div>
                                                <div class="grid_6"><a target="_blank" href="<?php echo base_url(). CV_FILE_PATH . $usersData->ta_cv;?>"><?php echo $usersData->ta_cv;?></a></div>
                                            </div>
                                            <div class="clr">
                                                <div class="grid_3"><strong>Other document:</strong></div>
                                                <div class="grid_6"><a target="_blank" href="<?php echo base_url(). OTHER_FILE_PATH . $usersData->ta_other_document;?>"><?php echo $usersData->ta_other_document;?></a></div>
                                            </div>
                                            <div class="clr">
                                                <div class="grid_3"><strong>Passport or id card:</strong></div>
                                                <div class="grid_6"><a target="_blank" href="<?php echo base_url(). PASSPORT_ID_CARD_FILE . $usersData->ta_passport_or_id_card;?>"><?php echo $usersData->ta_passport_or_id_card;?></a></div>
                                            </div>
                            </div>
                            <div class="detailsDiv">
                            <br/>
                                <strong>Additional information</strong>
                                <hr />
                                <div class="clr">
                                    <div class="grid_3"><strong>NI Number:</strong></div>
                                    <div class="grid_3"><?php echo $usersData->ta_ni_number;?></div>

                                    <div class="grid_3"><strong>Right to work in UK:</strong></div>
                                    <div class="grid_3"><?php echo ($usersData->ta_right_to_work_uk == '1' ? 'Yes' : 'No');?></div>
                                </div>
                            
                                <div class="clr">
                                    <div class="grid_3"><strong>NI Category:</strong></div>
                                    <div class="grid_3"><?php echo $usersData->ta_ni_category;?></div>

                                    <div class="grid_3"><strong>Making Student Loan Repayment:</strong></div>
                                    <div class="grid_3"><?php echo ($usersData->ta_making_slr == '1' ? 'Yes' : 'No');?></div>
                                </div>
                                
                                <div class="clr">
                                <?php if($usersData->ta_making_slr == '1'){?>
                                    <div class="grid_3"><strong>Student Loan Repayment Plan:</strong></div>
                                    <div class="grid_3"><?php echo $usersData->ta_slr_plan;?></div>

                                    <div class="grid_3"><strong>Providing P45:</strong></div>
                                    <div class="grid_3"><?php echo ($usersData->ta_p45_status == '1' ? 'Yes' : 'No');?></div>
                                
                                <?php }else{?>
                                    <div class="grid_3"><strong>Providing P45:</strong></div>
                                    <div class="grid_3"><?php echo ($usersData->ta_p45_status == '1' ? 'Yes' : 'No');?></div>
                                <?php }?>
                                </div>
                                
                                <?php if($usersData->ta_p45_status == '0'){?>
                                <div class="clr">
                                    <div class="grid_3"><strong>Starter Declaration:</strong></div>
                                    <div class="grid_9"><?php 
                                    switch($usersData->ta_p45_starter_declaration)
                                    {
                                        case 'A':
                                            echo "Starter Declaration A: This is my first job since last 6 April and I have not been receiving taxable Jobseeker's Allowance, Employment and Support Allowance, taxable Incapacity Benefit, State or Occupational Pension.";
                                        break;
                                        case 'B':
                                            echo "Starter Declaration B: This is now my only job but since last 6 April I have had another job, or received taxable Jobseeker's Allowance, Employment and Support Allowance or taxable Incapacity Benefit. I do not receive a State or Occupational Pension.";
                                        break;
                                        case 'C':
                                            echo "Starter Declaration C: As well as my new job, I have another job or receive a State or Occupational Pension.";
                                        break;
                                        default:
                                            break;
                                    }
                                    ?></div>
                                </div>
                                <?php }?>
                                
                                
                                
                                
                            </div>
                            <div class="detailsDiv">
                            <br/>
                                <strong>Other files uploaded for office use</strong>
                            <hr />
                            <?php if($appOtherFiles){
                                foreach($appOtherFiles as $otherAppFile){
                                    ?>
                                        <div class="clr">
                                            <div class="grid_3"><strong><?php echo $otherAppFile['tof_title'];?>:</strong></div>
                                            <div class="grid_6"><a target="_blank" href="<?php echo base_url(). OFFICE_OTHER_FILE_PATH . $otherAppFile['tof_filename'];?>"><?php echo $otherAppFile['tof_filename'];?></a></div>
                                        </div>
                                    <?php 
                                    }
                                }
                                }
                                else{
                                    echo "<div>Unable to find users profile.</div>";
                                    
                                }
                                ?>
                            </div>
                            <div class="detailsDiv">
                                <br/>
                                    <strong>Bank details</strong>
                                <hr />
                                <div class="clr">
                                    <div class="grid_3"><strong>Currency Type:</strong></div>
                                    <div class="grid_9">
                                        <?php echo $usersData->tbd_currency_type;?>
                                    <div class="btn-profile-edit">
                                        <input type="button" class="" id="btnBankEdit" value="Edit" /></div>
                                    </div>
                                </div>
                                <div class="clr">
                                    <?php if($usersData->tbd_currency_type == 'GBP'){?>
                                        <div class="grid_3"><strong>Account name:</strong></div>
                                        <div class="grid_3"><?php echo $usersData->tbd_account_name;?></div>

                                        <div class="grid_3"><strong>Sort code:</strong></div>
                                        <div class="grid_3"><?php echo ($usersData->tbd_sort_code);?></div>
                                    <?php }else{?>
                                        <div class="grid_3"><strong>Account name:</strong></div>
                                        <div class="grid_3"><?php echo $usersData->tbd_account_name;?></div>

                                        <div class="grid_3"><strong>IBAN:</strong></div>
                                        <div class="grid_3"><?php echo ($usersData->tbd_iban);?></div>
                                    <?php }?>
                                </div>
                                <div class="clr">
                                    <?php if($usersData->tbd_currency_type == 'GBP'){?>
                                        <div class="grid_3"><strong>Account number:</strong></div>
                                        <div class="grid_3"><?php echo $usersData->tbd_account_number;?></div>
                                    <?php }else{?>
                                        <div class="grid_3"><strong>Swift/BIC:</strong></div>
                                        <div class="grid_3"><?php echo ($usersData->tbd_swift_bic);?></div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </section><!-- End of #content -->
	</div><!-- End of #main -->
        
        <!-- #bank-details-dialog -->
        <div style="display: none;" id="bank-detail-dialog" title="Bank detail">
				
            <form id="frmBankDetail" action="">
                <div style="max-height: 55px;" class="row">
                    <label>
                            <strong>Currency type</strong>
                    </label>
                    <div class="form-data" >
                        <select autocomplete="off" id="selCurrencyType" name="selCurrencyType" class="required">
                            <option <?php echo ($usersData->tbd_currency_type == 'GBP' ? 'selected="selected"' : '');?> value="GBP">GBP(&pound;)</option>
                            <option <?php echo ($usersData->tbd_currency_type == 'Overseas' ? 'selected="selected"' : '');?> value="Overseas">Overseas</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                        <label for="txtAccountName" style="width: 115px;">
                                <strong>Account name</strong>
                        </label>
                        <div class="form-data" style="margin-left: 130px;">
                                <input title="If this is not your account we require written authorisation from you
" type="text" placeholder="Account name" name="txtAccountName" id="txtAccountName" class="required"   maxlength="100" value="<?php echo $usersData->tbd_account_name;?>" >
                                <div class="error"></div>
                        </div>
                </div>
                <div class="row grGBP">
                        <label for="txtSortCode" style="width: 115px;">
                                <strong>Sort code</strong>
                        </label>
                        <div class="form-data" style="margin-left: 130px;">
                                <input type="text" placeholder="Sort code" name="txtSortCode" id="txtSortCode" class="required"   maxlength="100" value="<?php echo $usersData->tbd_sort_code;?>" >
                                <div class="error"></div>
                        </div>
                </div>
                <div class="row grGBP">
                        <label for="txtAccountNumber" style="width: 115px;">
                                <strong>Account number</strong>
                        </label>
                        <div class="form-data" style="margin-left: 130px;">
                                <input type="text" placeholder="Account number" name="txtAccountNumber" id="txtAccountNumber" class="required"   maxlength="100" value="<?php echo $usersData->tbd_account_number;?>" >
                                <div class="error"></div>
                        </div>
                </div>
                <div class="row grOverseas">
                        <label for="txtIBAN" style="width: 115px;">
                                <strong>IBAN</strong>
                        </label>
                        <div class="form-data" style="margin-left: 130px;">
                                <input type="text" placeholder="IBAN" name="txtIBAN" id="txtIBAN" class="required"   maxlength="100" value="<?php echo $usersData->tbd_iban;?>" >
                                <div class="error"></div>
                        </div>
                </div>
                <div class="row grOverseas">
                        <label for="txtSwiftBIC" style="width: 115px;">
                                <strong>Swift/BIC</strong>
                        </label>
                        <div class="form-data" style="margin-left: 130px;">
                                <input type="text" placeholder="Swift/BIC" name="txtSwiftBIC" id="txtSwiftBIC" class="required"   maxlength="100" value="<?php echo $usersData->tbd_swift_bic;?>" >
                                <div class="error"></div>
                        </div>
                </div>
            </form>
            <div id="bank-detail-msg"></div>
            <div class="actions">
                    <div class="right" style="margin-left: 5px;">
                            <button class="cancel">Cancel</button>
                    </div>
                    <div class="right">
                            <button class="submit">Submit</button>
                    </div>
            </div>

    </div><!-- End of #profile-dialog -->

    <script type="text/javascript">
        
        var SITE_PATH = "<?php echo base_url();?>index.php/";
        $(document).ready(function() {		
            $( "body" ).on( "click", "#btnEditProfile",function(){
                    window.location.href = SITE_PATH + "users/editprofile";
            });


            
//            $.validator.addMethod( "numeric", function( value, element ) {
//                    return this.optional( element ) || /^\d$/.test( value );
//            }, "Please enter numeric values only" );

            $( "#bank-detail-dialog" ).dialog({
                    autoOpen: false,
                    modal: true,
                    width: 540,
                    open: function(){ 
                        $(this).parent().css('overflow', 'visible'); 
                        $$.utils.forms.resize() 
                        $el = $("button.submit").parents('.ui-dialog-content');
                        $el.validate().form();
                        $("#selCurrencyType").trigger("liszt:updated");
                    },
                    close: function(){
                        $("#frmBankDetail")[0].reset();
                    }
            }).find('button.submit').click(function(){
                
                    $("#bank-detail-msg").removeClass('tuition_success');
                    $("#bank-detail-msg").removeClass('tuition_error');
                    $("#bank-detail-msg").html('');
                    var $el = $(this).parents('.ui-dialog-content');
                    if ($el.validate().form()) {
                        var selCurrencyType = $("#selCurrencyType").val();
                        var txtAccountName = $('#txtAccountName').val();
                        var txtSortCode = $('#txtSortCode').val();
                        var txtAccountNumber = $('#txtAccountNumber').val();
                        var txtIBAN = $('#txtIBAN').val();
                        var txtSwiftBIC = $('#txtSwiftBIC').val();
                        var allowed = true;
                        if(selCurrencyType == "GBP")
                        {
                                $( "#txtSortCode" ).rules( "add", {
                                    maxlength: 6,
                                    minlength: 6,
                                    digits: true,
                                    messages: {
                                        maxlength: jQuery.validator.format("Sort code should be {0} digit in length"),
                                        minlength: jQuery.validator.format("Sort code should be {0} digit in length")
                                    }
                                });
                            
                                $( "#txtAccountNumber" ).rules( "add", {
                                    maxlength: 8,
                                    minlength: 8,
                                    digits: true,
                                    messages: {
                                        maxlength: jQuery.validator.format("Account number should be {0} digit in length"),
                                        minlength: jQuery.validator.format("Account number should be {0} digit in length")
                                    }
                                });
                            
                            $el = $("button.submit").parents('.ui-dialog-content');
                            if(!$el.validate().form())
                                allowed = false;
                            $( "#txtSortCode" ).rules( "remove", "maxlength minlength numeric" );
                            $( "#txtAccountNumber" ).rules( "remove", "maxlength minlength numeric" );
                        }
                        if(allowed)
                        $.post( SITE_PATH + "users/updatebankdetails",{
                            'selCurrencyType':selCurrencyType,
                            'txtAccountName':txtAccountName,
                            'txtSortCode':txtSortCode,
                            'txtAccountNumber':txtAccountNumber,
                            'txtIBAN':txtIBAN,
                            'txtSwiftBIC':txtSwiftBIC
                        }, function( data ) {
                            if(parseInt(data.result))
                            {
                                $("#bank-detail-msg").addClass('tuition_success');
                                //$el.find('form')[0].reset();
                                setTimeout(function(){$el.dialog('close');
                                    window.location.reload();
                                },'1500');
                            }
                            else
                            {
                                $("#bank-detail-msg").addClass('tuition_error');
                            }
                            $("#bank-detail-msg").html(data.message);
                        },'json');
                    }
            }).end().find('button.cancel').click(function(){
                    var $el = $(this).parents('.ui-dialog-content');
                    $el.dialog('close');
            });
            
//            $( "body" ).on( "click", ".ui-icon-closethick",function(){
//                   $("#frmBankDetail")[0].reset();
//            });
            
            $( "#btnBankEdit" ).click(function() {
                $( "#bank-detail-dialog" ).dialog( "open" );
                return false;
            });
            
            $( "body" ).on( "change", "#selCurrencyType",function(){
                var myVal = $(this).val();
                if(myVal == 'GBP')
                {
                    $(".grOverseas").hide();
                    $(".grGBP").show();
                }
                else if(myVal == 'Overseas'){
                    $(".grOverseas").show();
                    $(".grGBP").hide();
                }
                else
                {
                    $(".grOverseas").hide();
                    $(".grGBP").hide();
                }
                $("#frmBankDetail .form-data").css('height','69px');
            });
            
            $("#selCurrencyType").trigger('change');
            $('#txtAccountName').tipsy({gravity: 's'});
        });
    </script>
    
<?php $this->load->view('plused_footer');?>
