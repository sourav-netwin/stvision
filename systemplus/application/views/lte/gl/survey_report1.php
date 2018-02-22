<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url();?>js/tuition/jquery_validations1.9.0.js"></script>
<section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $breadcrumb2;?></h3>

          <div class="box-tools pull-right">
            <button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
            <form method="post" class="validate" id="frmSurvey" action="">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="txtName" style="width: 115px;">
                                    <strong>Name</strong>
                                </label>
                                    <input type="hidden" id="txtSurveyUserId" name="txtSurveyUserId" value="<?php echo (isset($surveyUserData->su_id) ? $surveyUserData->su_id : '');?>" />
                                    <input type="hidden" id="txtUserId" name="txtUserId" value="<?php echo $userId; ?>" />
                                    <input type="hidden" id="txtReportType" name="txtReportType" value="<?php echo $reportType; ?>" />
                                    <input type="text" readonly id="txtName" name="txtName" class="required form-control" autocomplete="off" maxlength="100" value="<?php echo (isset($surveyUserData->su_name) ? $surveyUserData->su_name : $userData->nome.' '.$userData->cognome);?>" >
                            </div>
                            <div class="col-md-4">
                                <label for="txtEmail" style="width: 115px;">
                                    <strong>Email</strong>
                                </label>
                                <input type="text" id="txtEmail" name="txtEmail" class="required form-control" autocomplete="off" maxlength="100" <?php echo (!empty($report1UserEmail) ? 'readonly' : '');?> value="<?php echo (isset($surveyUserData->su_email) ? $surveyUserData->su_email : $report1UserEmail);?>" >
                            </div>
                            <div class="col-md-4">
                                <label for="txtCentre" style="width: 115px;">
                                    <strong>Centre</strong>
                                </label>
                                    <input type="hidden" id="selCampus" name="selCampus" value="<?php echo $userData->id_centro;?>" />
                                    <input type="text" readonly id="txtCentre" name="txtCentre" autocomplete="off" class="required form-control" maxlength="100" value="<?php echo $userData->nome_centri;?>" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="padding-top: 5px;">
                                <p>
                                <?php if($reportType == 'Report 1'){?>
                                
                                    Client satisfaction is the primary concern of our company. This questionnaire allows us to verify whether our staff have followed the guidelines set by PLUS and operated to the best of their abilities. 
Please complete it and hand it to the Campus Manager, who will forward it to PLUS Head office. Thank you for your kind cooperation.
                                
                                <?php }elseif($reportType="Report 2"){?>
                                    Please complete this questionnaire and hand it to the Campus Manager. It will help us to gain a full picture of our staff’s performance and assess the quality of services provided. 
We hope that your experience with us has been a positive one and we look forward to welcoming you back to our centres next year. We wish you and your students a safe journey home.
                                <?php }?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 survey-start-div">
                                <input type="submit" id="btnStartSurvey" value="Start Survey" style="padding: 5px 6px;" <?php echo (isset($surveyUserData->su_id) ? 'disabled="disabled"' : '');?> class="btn btn-primary btn-survey" />
                            </div>
                        </div>
                <div id="surveyDiv">
                   
                            <?php 
                            $notfirst = 0;
                            $currentQueSection = "";
                            if($report1SurveyQues)
                                foreach($report1SurveyQues as $survey1){
                                $notfirst++;
                                    if($currentQueSection == "" || $currentQueSection != $survey1['que_section'])
                                    {
                                        $currentQueSection = $survey1['que_section'];
                                        if($notfirst != 1){
                                        ?>
                                            </div><!-- /.box-body -->
                                            </div><!-- /.box -->
                                            </div>
                                            </div>
                                            <?php }?>
                                    <div class="row mr-top-10" >
                                    <div class="col-xs-12">
                                    <div class="box box-warning">
                                                <div class="box-header with-border">
                                                <h3 class="box-title"><?php echo $survey1['que_section'];?></h3>
                                                <div class="col-xs-2 pull-right">
                                                    <img src="<?php echo base_url();?>img/icons/packs/fugue/16x16/thumb-up.png">
                                                    <img src="<?php echo base_url();?>img/icons/packs/fugue/16x16/thumb.png" class="pull-right">
                                                </div>
                                                </div><!-- /.box-header -->
                                                <div class="box-body">
                                        <?php 
                                    }
                            ?>
<!--                        </div>
                        <div class="row">-->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="head">
                                    <?php if(empty($survey1['que_parent_que_id'])){?>
                                        <div class="col-xs-1 ques-number"><?php echo $survey1['que_number'];?>.</div>
                                    <?php }else{?>
                                        <div class="col-xs-1 option-space">&nbsp;</div>
                                    <?php }?>
                                        <div class="col-xs-9 <?php echo ($survey1['que_is_header'] || $survey1['que_iscomment'] ? 'ques-head' : 'ques-option')?>"><span class="<?php echo ($survey1['que_parent_que_id'] ? 'display-bullets' : '');?>"><?php echo $survey1['que_question'];?></span></div>
                                    <?php if($survey1['que_isyesno'] == 1){?>
                                        <div class="col-xs-1"><input class="log-answer" autocomplete="off" <?php echo ($survey1['ans_yes_no'] == 1 ? 'checked' : '');?> type="radio" data-id="<?php echo $survey1['que_id'];?>" data-type="yesno" value="1" name="rad<?php echo $survey1['que_id'];?>" /></div>
                                        <div class="col-xs-1"><input class="log-answer pull-right" autocomplete="off" <?php echo ($survey1['ans_yes_no'] == '0' ? 'checked' : '');?> type="radio" data-id="<?php echo $survey1['que_id'];?>" data-type="yesno" value="0" name="rad<?php echo $survey1['que_id'];?>" /></div>
                                    <?php }elseif($survey1['que_iscomment'] == 1){?>
                                        <div class="col-xs-11 col-xs-offset-1" >
                                            <textarea class="form-control log-answer" maxlength="500" autocomplete="off" rows="5" data-id="<?php echo $survey1['que_id'];?>" data-type="comment" style="margin-top: 4px;" id="txtComments_<?php echo $survey1['que_id'];?>"><?php echo $survey1['ans_comment'];?></textarea>
                                        </div>
                                    <?php }elseif($survey1['que_is_header'] != 1){?>
                                        <div class="col-xs-2" >
                                            <input class="log-answer form-control" maxlength="6" onkeypress="return keyRestrict(event,'1234567890');" autocomplete="off" data-id="<?php echo $survey1['que_id'];?>" data-type="text" id="txt_<?php echo $survey1['que_id'];?>" name="txt_<?php echo $survey1['que_id'];?>" type="text" value="<?php echo $survey1['ans_comment'];?>" />
                                        </div>
                                        <?php }?>
                                </div>
                            </div>
                            </div>
                            <?php }?>
                           </div><!-- /.box-body -->
                                            </div><!-- /.box -->
                                            </div>
                                            </div>
                        <div class="row">
                            <div class="col-xs-12">
                            <div class="col-xs-11 mr-top-10 col-xs-offset-1">
                                    <input id="btnSubmitClose" type="button" value="Submit"  class="btn btn-primary btn-survey" />
                            </div>
                            </div>
                        </div>
            </form>
       
        <!-- /.box-body -->
        
        <!-- /.box-footer-->
      </div>
    </section>
<style>
        .ques-number{
            padding-left:35px;
        }
        
        /* SURVEY REPROT */
        .head .ques-head , .ques-number {
            font-style: inherit;
            font-weight: bold;
        }
        .display-bullets {
            display: list-item;
            margin-left: 30px;
        }

        .survey-start-div{
            text-align: center;
        }

        .btn-survey{
            font-size: 16px;
        }

        #btnStartSurvey{
            width:auto!important;
        }
        
        
        
        .survey-start-div{
            text-align:center;
        }
        .box-header .col-xs-2 img{
            margin-bottom: 5px;
        }
        
        @media only screen and (max-width: 500px) {
            .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
                min-height: 1px;
                padding-left: 10px;
                padding-right: 10px;
                position: relative;
            }
            .col-xs-2 {
                width: 25%;
            }
            .col-xs-9 {
                padding-left: 5px;
                padding-right: 5px;    
                width: 66.333%;
            }
            .col-xs-1{
                padding-right: 0px;
                vertical-align: middle;
            }
        }
        
    </style>
<script>
        $(document).ready(function() {
            
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
                        confirmAction("Be sure! Once you marked it as completed you can't edit it again.", function(c){
                            if(c)
                            {
                                $.post( "<?php echo base_url();?>index.php/survey/markascompleted",
                                {
                                    'suId':suId
                                }, function( data ) {
                                    if(data.result == '1')
                                    {
                                        swal('Success', data.message);
                                        $("input").attr('disabled','disabled');
                                        $("textarea").attr('disabled','disabled');
                                        $(".log-answer").removeClass('log-answer');
                                    }
                                    else
                                    {
                                        swal('Error', data.message);
                                    }
                                },'json');
                            }
                        },false,true);
                    }
                    else
                    {
                        swal('Error', 'You will have to fill your information above and click on start survey button.');
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