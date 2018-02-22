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
            <span><?php echo $this->session->userdata('businessname'); ?></span>
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/survey/profile">Profile</a></li>
                <li class="line"></li>
                <li><a href="<?php echo base_url(); ?>index.php/survey/logout">Logout</a></li>
            </ul>
        </div>
    </section><!-- End of .toolbar-->
    <?php $this->load->view('plused_sidebar');?>		
    <script>
        $(document).ready(function() {
            $( "li#takethesurvey" ).addClass("current");
            $( "li#takethesurvey a" ).addClass("open");		
            $( "li#takethesurvey ul.sub" ).css('display','block');	
            <?php if($reportType == 'Report 1'){?>
            $( "li#takethesurvey ul.sub li#takethesurvey_1" ).addClass("current");	
            <?php }elseif($reportType == 'Report 2'){?>
            $( "li#takethesurvey ul.sub li#takethesurvey_2" ).addClass("current");	
            <?php }?>
            
           
            
            $("#frmSurvey").validate({
                errorElement:"div",
                ignore: "",
                rules: {
                    txtName: "required",
                    txtCentre: "required",
                    txtEmail: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    txtName: "Name field is required",
                    txtCentre: "Centre field is required",
                    txtEmail: "Please enter your email address"
                },
                submitHandler: function(form) {
                    //form.submit();
                    var txtUserId = $('#txtUserId').val();
                    var txtEmail = $('#txtEmail').val();
                    var txtName = $('#txtName').val();
                    var txtReportType = $('#txtReportType').val();
                    var txtCampus = $('#txtCampus').val();
                    var selCampus = $('#selCampus').val();
                    var txtSurveyUserId = $('#txtSurveyUserId').val();
                    if(parseInt(txtSurveyUserId))
                        return false;
                    else
                    $.post( "<?php echo base_url();?>index.php/survey/startsurvey",
                    {
                        'txtUserId':txtUserId,
                        'txtEmail':txtEmail,
                        'txtName':txtName,
                        'txtReportType':txtReportType,
                        'txtCampus':txtCampus,
                        'selCampus':selCampus
                    }, function( data ) {
                        if(data.result == '1')
                        {
                            $("#txtSurveyUserId").val(data.surveyId);
                            $("#btnStartSurvey").attr('disabled','disabled');
                            $("#surveyDiv").show();
                        }
                        else
                        {
                            alert('unable to start survey.');
                        }
                    },'json');
                }
            });
            
             
             $( "body" ).on( "change", ".log-answer", function() {
                var type = $(this).attr('data-type');
                var suId = $("#txtSurveyUserId").val();
                var quesId = $(this).attr('data-id');
                var myVal = $(this).val();
                var ThisEle = $(this);
                $.post( "<?php echo base_url();?>index.php/survey/loganswer",
                    {
                        'type':type,
                        'suId':suId,
                        'quesId':quesId,
                        'myVal':myVal
                    }, function( data ) {
                        // notify user
                        if(data.result == '0')
                        {
                            alert(data.message);
                            if(type == 'yesno')
                                ThisEle.prop('checked',false);
                            if(type == 'text' || type == 'comment')
                                ThisEle.val('');
                        }
                    },'json');
             });
             
             $( "body" ).on( "click", "#btnSubmitClose", function() {
                var suId = $("#txtSurveyUserId").val();
                    if(suId > 0)
                    {
                        if(confirm("Be sure! Once you marked it as completed you can't edit it again."))
                        {
                            $.post( "<?php echo base_url();?>index.php/survey/markascompleted",
                            {
                                'suId':suId
                            }, function( data ) {
                                // notify user
                                alert(data.message);
                                if(data.result == '1')
                                {
                                    $("input").attr('disabled','disabled');
                                    $("textarea").attr('disabled','disabled');
                                    $(".log-answer").removeClass('log-answer');
                                }
                            },'json');
                            
                        }
                    }
                    else
                    {
                        alert('You will have to fill your information above and click on start survey button.');
                    }
             });
             
                <?php if(!isset($surveyUserData->su_survey_status)){
                    ?>
                        $("#surveyDiv").hide();
                <?php }?>
             <?php if(isset($surveyUserData->su_survey_status)){
                    if($surveyUserData->su_survey_status == 'Completed'){
                    ?>
                    $("input").attr('disabled','disabled');
                    $("textarea").attr('disabled','disabled');
                    $(".log-answer").removeClass('log-answer');
             <?php }}?>
        });
    </script>	
    <style>
        form .row > div {
            border-left: none;
            padding-left: 0px;
            position: relative;
        }
        form .row > div > *:not(.icon):not(label) {
            box-sizing: border-box;
            margin: 4px 0;
            width: 100%;
        }
        form .row > div::after, form .row > div::before {
            content: "";
            display: table;
            padding-top: 2px;
        }
        div.error {
             margin: -2px 0 0 !important;
        }
        .btn {
            width: 92px!important;
        }
        
        #frmSurvey .radiobutton-hover img {
            background: transparent url("<?php echo base_url(); ?>img/elements/checkbox/unchecked-hover.png") no-repeat scroll 0 0 !important;
        }
        #frmSurvey .radiobutton img {
            background: transparent url("<?php echo base_url(); ?>img/elements/checkbox/unchecked-normal.png") no-repeat scroll 0 0;
        }
        #frmSurvey .radiobutton-checked img {
            background: transparent url("<?php echo base_url(); ?>img/elements/checkbox/checked-normal.png") no-repeat scroll 0 0;
        }
    </style>
    <!-- Here goes the content. -->
     <section id="content" class="container_12 clearfix" data-sort=true>
        <div class="grid_12">
            <div class="box">
                <div class="header">
                    <h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png"><?php echo $breadcrumb2;?></h2>
                </div>
                <div class="content">
                    <form method="post" class="validate" id="frmSurvey" action="">
                        <div class="row">
                            <div class="grid_4">
                                <label for="txtName" style="width: 115px;">
                                    <strong>Name</strong>
                                </label>
                                    <input type="hidden" id="txtSurveyUserId" name="txtSurveyUserId" value="<?php echo (isset($surveyUserData->su_id) ? $surveyUserData->su_id : '');?>" />
                                    <input type="hidden" id="txtUserId" name="txtUserId" value="<?php echo $userId; ?>" />
                                    <input type="hidden" id="txtReportType" name="txtReportType" value="<?php echo $reportType; ?>" />
                                    <input type="text" readonly id="txtName" name="txtName" class="required" autocomplete="off" maxlength="100" value="<?php echo (isset($surveyUserData->su_name) ? $surveyUserData->su_name : $userData->nome.' '.$userData->cognome);?>" >
                            </div>
                            <div class="grid_4">
                                <label for="txtEmail" style="width: 115px;">
                                    <strong>Email</strong>
                                </label>
                                    <input type="text" id="txtEmail" name="txtEmail" class="required" autocomplete="off" maxlength="100" <?php echo (!empty($report1UserEmail) ? 'readonly' : '');?> value="<?php echo (isset($surveyUserData->su_email) ? $surveyUserData->su_email : $report1UserEmail);?>" >
                            </div>
                            <div class="grid_4">
                                <label for="txtCentre" style="width: 115px;">
                                    <strong>Centre</strong>
                                </label>
                                    <input type="hidden" id="selCampus" name="selCampus" value="<?php echo $userData->id_centro;?>" />
                                    <input type="text" readonly id="txtCentre" name="txtCentre" autocomplete="off" class="required" maxlength="100" value="<?php echo $userData->nome_centri;?>" >
                            </div>
                            <div class="grid_12" style="padding-top: 5px;">
                                <?php if($reportType == 'Report 1'){?>
                                <p>
                                    Client satisfaction is the primary concern of our company. This questionnaire allows us to verify whether our staff have followed the guidelines set by PLUS and operated to the best of their abilities. 
Please complete it and hand it to the Campus Manager, who will forward it to PLUS Head office. Thank you for your kind cooperation.
                                </p>
                                <?php }elseif($reportType="Report 2"){?>
                                    Please complete this questionnaire and hand it to the Campus Manager. It will help us to gain a full picture of our staff’s performance and assess the quality of services provided. 
We hope that your experience with us has been a positive one and we look forward to welcoming you back to our centres next year. We wish you and your students a safe journey home.
                                <?php }?>
                            </div>
                            <div class="grid_12 survey-start-div">
                                <input type="submit" id="btnStartSurvey" value="Start Survey" style="padding: 5px 6px;" <?php echo (isset($surveyUserData->su_id) ? 'disabled="disabled"' : '');?> class="btn btn-tuition btn-survey" />
                            </div>
                            <div id="surveyDiv">
                            <?php 
                            $currentQueSection = "";
                            if($report1SurveyQues)
                                foreach($report1SurveyQues as $survey1){
                                    if($currentQueSection == "" || $currentQueSection != $survey1['que_section'])
                                    {
                                        $currentQueSection = $survey1['que_section'];
                                        ?>
                                        <div class="grid_12">
                                            <div class="head">
                                                <div class="grid_10"><span style="font-size:18px;font-weight: bold;"><?php echo $survey1['que_section'];?></span></div>
                                                <div class="grid_1"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/thumb-up.png"/></div>
                                                <div class="grid_1"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/thumb.png"/></div>
                                            </div>
                                        </div>
                                        <?php 
                                    }
                            ?>
                            <div class="grid_12">
                                <div class="head">
                                    <?php if(empty($survey1['que_parent_que_id'])){?>
                                        <div class="grid_1 ques-number"><?php echo $survey1['que_number'];?>.</div>
                                    <?php }else{?>
                                        <div class="grid_1">&nbsp;</div>
                                    <?php }?>
                                        <div class="grid_9 <?php echo ($survey1['que_is_header'] || $survey1['que_iscomment'] ? 'ques-head' : 'ques-option')?>"><span class="<?php echo ($survey1['que_parent_que_id'] ? 'display-bullets' : '');?>"><?php echo $survey1['que_question'];?></span></div>
                                    <?php if($survey1['que_isyesno'] == 1){?>
                                        <div class="grid_1"><input class="log-answer" autocomplete="off" <?php echo ($survey1['ans_yes_no'] == 1 ? 'checked' : '');?> type="radio" data-id="<?php echo $survey1['que_id'];?>" data-type="yesno" value="1" name="rad<?php echo $survey1['que_id'];?>" /></div>
                                        <div class="grid_1"><input class="log-answer" autocomplete="off" <?php echo ($survey1['ans_yes_no'] == '0' ? 'checked' : '');?> type="radio" data-id="<?php echo $survey1['que_id'];?>" data-type="yesno" value="0" name="rad<?php echo $survey1['que_id'];?>" /></div>
                                    <?php }elseif($survey1['que_iscomment'] == 1){?>
                                        <div class="grid_10" style="margin-left: 9%;">
                                            <textarea class="log-answer" maxlength="500" autocomplete="off" rows="5" data-id="<?php echo $survey1['que_id'];?>" data-type="comment" style="width: 90%;margin-top: 4px;" id="txtComments_<?php echo $survey1['que_id'];?>"><?php echo $survey1['ans_comment'];?></textarea>
                                        </div>
                                    <?php }elseif($survey1['que_is_header'] != 1){?>
                                        <input class="log-answer" maxlength="6" style="margin-left: 7px;width: 9%;" onkeypress="return keyRestrict(event,'1234567890');" autocomplete="off" data-id="<?php echo $survey1['que_id'];?>" data-type="text" id="txt_<?php echo $survey1['que_id'];?>" name="txt_<?php echo $survey1['que_id'];?>" type="text" value="<?php echo $survey1['ans_comment'];?>" />
                                        <?php }?>
                                </div>
                            </div>
                            <?php }?>
                            <div class="grid_4">
                                    <input id="btnSubmitClose" type="button" value="Submit" style="margin-left: 9%;" class="btn btn-tuition btn-survey" />
                            </div>
                            </div>
                        </div>
                    </form>
                    
                <div class="alert information sticky bottom no-margin"><!-- span class="icon"></span>If you need any <strong>help</strong> just send us a mail at <a class="hlt-link-a" style="color: white!important;" href="mailto:recruitment@plus-ed.com">recruitment@plus-ed.com</a -->&nbsp;</div>
                </div><!-- End of .content -->

            </div><!-- End of .box -->

        </div>
    </section><!-- End of #content -->

</div><!-- End of #main -->
<?php $this->load->view('plused_footer'); ?>
