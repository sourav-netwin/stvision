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
                <li><a href="<?php echo base_url(); ?>index.php/students/profile">Profile</a></li>
                <li class="line"></li>
                <li><a href="<?php echo base_url(); ?>index.php/students/logout">Logout</a></li>
            </ul>
        </div>
    </section><!-- End of .toolbar-->
    <?php $this->load->view('plused_sidebar');?>		
    <script>
        $(document).ready(function() {
            $( "li#students" ).addClass("current");
            $( "li#students a" ).addClass("open");		
            $( "li#students ul.sub" ).css('display','block');	
            $( "li#students ul.sub li#students_1" ).addClass("current");	
            
            $( "body" ).on( "change", ".log_answer", function() {
                var quesId = $(this).attr('data-ques');
                var myVal = $(this).val();
                $.post( "<?php echo base_url();?>index.php/students/logquesanswer",
                    {
                        'quesId':quesId,
                        'myVal':myVal
                    }, function( data ) {
                        // notify user
                        if(data.result == '0')
                        {
                            alert(data.message);
                        }
                    },'json');
             });
             
             $( "body" ).on( "click", "#btnSubmitTest", function() {
                var testId = $("#hidd_test_id").val();
                $(".markedRed").removeClass('markedRed');
                var group = {};
                var allowSubmit = 1;
                $('input[name^="opt_"]').each(function (index) {
                    var name = this.name;
                    if (!group[name]) {
                        group[name] = true;
                        var myval = $("input[name="+name+"]:checked").val();
                        if(typeof myval == "undefined")
                        {
                            allowSubmit = 0;
                            $("input[name="+name+"]").parent().parent().parent().find('.test-ques-sr').addClass('markedRed');
                        }
                    }
                });
                
                if(!allowSubmit)
                {
                    $("#test-message").html("All questions are mandatory, please complete all the remaining question(s)(marked in red) and submit the test again.");
                    $("#test-message").removeClass('tuition_success');
                    $("#test-message").addClass('tuition_error');
                }
                else if(confirm("Are you sure to submit this test? \nOnce it is submitted, you would not allowed to edit it again!"))
                $.post( "<?php echo base_url();?>index.php/students/submittest",
                {
                    'testId':testId
                }, function( data ) {
                    // notify user
                    $("#test-message").html(data.message);
                    if(data.result == '0')
                    {
                        $("#test-message").addClass('tuition_error');
                        $("#test-message").removeClass('tuition_success');
                    }
                    else{
                        $("input[type=radio]").attr('disabled','disabled');
                        $("#btnSubmitTest").attr('disabled','disabled');
                        $("#test-message").removeClass('tuition_error');
                        $("#test-message").addClass('tuition_success');
                    }
                },'json');
             });
             
        });
    </script>	
    <style>
        .markedRed{
            color:red;
            font-weight:bold;
        }
        .test-head{
            text-align: center;
        }
        .test-title{
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .test-note{
            text-align: left;
        }
        .test-example{
            text-align: left;
            font-weight: bold;
        }
        
        .mr-left-10{
            margin-left: 10px;
        }
        .mr-left-25{
            margin-left: 25px;
        }
        .test-rows li {
            margin-bottom: 10px;
            border-bottom: 1px solid silver;
            padding-bottom: 10px;
        }
        .test-ques{
            margin-bottom: 10px;
        }
        .test-ques-sr {
            margin-right: 5px;
        }
        .test-opt {
            margin-bottom: 10px;
            margin-left: 18px;
        }
        .test-opt label {
            display: block;
            float: left;
            margin-bottom: 2px;
            /*width: 25% !important;*/
        }
        .submit-test{
            text-align: center;
        }
        
        .test-rows .grid_3 {
            word-break: unset !important;
        }
        
        
        @media only screen and (max-width: 500px) {
            .test-rows {
                padding: 0!important;
            }
        }
        
    </style>
    <!-- Here goes the content. -->
     <section id="content" class="container_12 clearfix" data-sort=true>
        <div class="grid_12">
            <div class="box">
                <div class="header">
                    <h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png"><?php echo $breadcrumb2;?></h2>
                </div>
                <div class="content ">
                    <div class="row">
                        <div class="test-head">
                            <p><h1>PLACEMENT TEST 2015</h1></p>
                            <p style="font-size:14px;"><strong>Question paper</strong></p>
                            <p class="test-note"><span>Do as many questions as you can, beginning with question 1. Only ONE answer is correct in each question. Choose A,
B, C or D from available options.</span></p>
                            <p><span class="test-title"><?php echo $testName;?></span></p>
                            <div class="test-example bt-mr-15">
                                <span>EXAMPLE: I _______________ a student.</span>
                            <div class="mr-top-10">
                                <span class="mr-left-25">a) am</span>
                                <span class="mr-left-25">b) are</span>
                                <span class="mr-left-25">c) is</span>
                                <span class="mr-left-25">d) be</span>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <ul class="test-rows">
                        <?php if($testQuestionData){
                            $sr = 0;
                            foreach($testQuestionData as $test){
                                $sr++;
                               ?>
                                <li class="grid_12">
                                    <div class="test-ques"><span class="test-ques-sr"><?php echo $sr;?>. </span><span><?php echo $test['tque_question'];?></span></div>
                                    <div class="test-opt">
                                        <?php 
                                        $options = $test['que_options'];
                                        $std_marked_option = $test['std_marked_option'];
                                        if(!empty($options)){
                                            $optionsArr = explode('||', $options);
                                            $a = "a";
                                            if(count($optionsArr)){
                                                foreach ($optionsArr as $option){
                                                    if(!empty($option)){
                                                    $optionEle = explode('#', $option);
                                                    $optId = $optionEle[0];
                                                    $optText = $optionEle[1];
                                                    $marked = "";
                                                    if($std_marked_option == $optId) 
                                                        $marked = "checked='checked'";
                                                    ?>
                                                    <label class="grid_3"><input <?php echo ($testAlreadySubmitted == 1 ? "disabled='disabled'" : ''); ?> class="log_answer" <?php echo $marked;?> name="opt_<?php echo $test['tque_id'];?>" data-ques="<?php echo $test['tque_id'];?>" type="radio" value="<?php echo $optId;?>" /><?php echo $a.') '.$optText;?></label>
                                                    <?php
                                                    }
                                                    $a++;
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="test-error"></div>
                                </li>
                               <?php 
                            }
                        }?>
                        </ul>
                    </div>
                    <div class="bt-mr-10">&nbsp;</div>
                    <div class="row">
                        <div class="grid_12 submit-test">
                            <input type="hidden" id="hidd_test_id" value="<?php echo $testId;?>" />
                            <input <?php echo ($testAlreadySubmitted == 1 ? "disabled='disabled'" : ''); ?> type="button" id="btnSubmitTest" name="btnSubmitTest" value="Submit test" />
                        </div>
                        <div class="grid_12 mr-top-10" id="test-message"></div>
                    </div>
                    
                    <div class="bt-mr-15">&nbsp;</div>
                <div class="alert information sticky bottom no-margin">&nbsp;</div>
                </div><!-- End of .content -->

            </div><!-- End of .box -->

        </div>
    </section><!-- End of #content -->

</div><!-- End of #main -->
<?php $this->load->view('plused_footer'); ?>
