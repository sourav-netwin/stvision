<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div id="testCompletedBox" style="display:none;" class="box box-primary">                
                <div class="box-header with-border text-center">
                    <h3 class="box-title">PLACEMENT TEST <?php echo date('Y'); ?> </h3>
                </div>
                <div class="box-body text-center">
                    <img src="<?php echo base_url()?>/img/tuition/hp_summer.jpg" />
                    <br />Congratulations, you have completed the test.
                    <br />We look forward to seeing you at PLUS this Summer!
                    <br /><br /><p>Click here to go back <a href="<?php echo base_url();?>index.php/students/dashboard" >dashboard</a></p>
                </div>
            </div>
            <!-- About Me Box -->
            <?php if ($checkCDUserMarks) { ?>
                <div class="alert alert-danger">
                    Current test is disabled, may be you have opted for offline test.
                </div>
            <?php }else if ($currentTestAttempt > 2) { ?>
            <div class="box box-primary">                
                    <div class="box-header with-border text-center">
                        <h3 class="box-title">PLACEMENT TEST <?php echo date('Y'); ?> </h3>
                    </div>
                <div class="box-body">
                    <div class="alert alert-danger">
                        You have exceeded the number of possible tests. Please contact your agent.
                    </div>
                    <p>Click here to go back <a href="<?php echo base_url();?>index.php/students/dashboard" >dashboard</a></p>
                </div>
            </div>
            <?php } else { ?>
                <div id="divClickToStart" class="box box-primary">                
                    <div class="box-header with-border">
                        <h3 class="box-title">PLACEMENT TEST <?php echo date('Y'); ?> </h3>
                    </div>
                    <!-- /.box-header -->                
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <p>Hi PLUS student!</p>
                                <p>Thank you for taking the PLUS placement test. This will help PLUS find the best class for you.</p>
                                <ul>
                                    <li>The test will be 30 minutes. After 30 minutes, the test will close.</li>
                                    <li>There are 50 questions. </li>
                                    <li>You must select ONE answer for each question. When you have finished the question, press ‘Next Question’</li>
                                    <li>You can only do the test once. </li>
                                    <li>Do not exit the test before completing all questions.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="test-example col-sm-12 mr-top-25">
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-info"></i> Warning!</h4>
                                    Do not close full screen mode or use other windows during the test. This can cause the test to submit automatically.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center mr-top-25">
                                <input class="btn btn-primary" <?php echo ($testAlreadySubmitted == 1 ? "disabled='disabled'" : ''); ?> type="button" id="btnClickToStart" name="btnClickToStart" value="Click to start test" />
                            </div>
                            <div class="col-sm-12 mr-top-25">
                                <p>Click here to go back <a href="<?php echo base_url();?>index.php/students/dashboard" >dashboard</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="divContinueTest" style="display:none;">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title">PLACEMENT TEST <?php echo date('Y'); ?> </h3>
                    </div>
                    <!-- /.box-header -->                
                    <div class="box-body test-head">
                        <div class="row">
                            <div class="test-example col-sm-12">
                                <span>EXAMPLE:</span><br />
                                <div class="text-center">
                                    <img style="width:75%" src="<?php echo base_url();?>img/tuition/test_example.png?v=1" /> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center mr-top-25">
                                <input class="btn btn-primary" <?php echo ($testAlreadySubmitted == 1 ? "disabled='disabled'" : ''); ?> type="button" id="btnContinue" name="btnContinue" value="Continue" />
                            </div>
                            <div class="col-sm-12 mr-top-25">
                                <p>Click here to go back <a href="<?php echo base_url();?>index.php/students/dashboard" >dashboard</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="divTestD" style="display:none;" class="box box-primary">                
                    <div class="box-header with-border text-center">
                        <h3 class="box-title">PLACEMENT TEST <?php echo date('Y'); ?> </h3>
                    </div>
                    <!-- /.box-header -->                
                    <div class="box-body test-head">
                        <p ><strong>Question paper</strong></p>
                        <p class="test-note"><span>Do as many questions as you can, beginning with question 1. Only ONE answer is correct in each question. Choose A,
                                B, C or D from available options.</span></p>
                        <p><span class="test-title"><?php echo $testName; ?></span></p>
                        <!-- div class="row">
                            <div class="test-example col-sm-12">
                                <span>EXAMPLE: I _______________ a student.</span>
                                <div class="mr-top-10">
                                    <span class="mr-left-25">a) am</span>
                                    <span class="mr-left-25">b) are</span>
                                    <span class="mr-left-25">c) is</span>
                                    <span class="mr-left-25">d) be</span>
                                </div>
                            </div>
                        </div -->
                    </div>
                    <div class="box-body" style="padding-left:25px;padding-right: 25px;">
                        <?php
                        if ($testQuestionData) {
                            $sr = 0;
                            $firstUnmarkedQuestion = 0;
                            foreach ($testQuestionData as $test) {
                                $sr++;
                                if(empty($test['std_marked_option']))
                                { 
                                    $firstUnmarkedQuestion++;
                                }
                                ?>
                                <div class="question-cell qcell-<?php echo $sr;?> <?php echo ($firstUnmarkedQuestion == 1 ? 'active' : '');?>">
                                    <div class="row">
                                        <div class="col-md-12 test-ques">
                                            <span class="test-ques-sr"><?php echo $sr; ?>. </span><span><?php echo $test['tque_question']; ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php
                                        $options = $test['que_options'];
                                        $std_marked_option = $test['std_marked_option'];
                                        if (!empty($options)) {
                                            $optionsArr = explode('||', $options);
                                            $a = "a";
                                            if (count($optionsArr)) {
                                                foreach ($optionsArr as $option) {
                                                    if (!empty($option)) {
                                                        $optionEle = explode('#', $option);
                                                        $optId = $optionEle[0];
                                                        $optText = $optionEle[1];
                                                        $marked = "";
                                                        if ($std_marked_option == $optId)
                                                            $marked = "checked='checked'";
                                                        ?>
                                                        <div class="test-opt col-sm-3">
                                                            <label><input <?php echo ($testAlreadySubmitted == 1 ? "disabled='disabled'" : ''); ?> class="log_answer" <?php echo $marked; ?> name="opt_<?php echo $test['tque_id']; ?>" data-ques="<?php echo $test['tque_id']; ?>" type="radio" value="<?php echo $optId; ?>" /><?php echo $a . ') ' . $optText; ?></label>
                                                        </div>
                                                        <?php
                                                    }
                                                    $a++;
                                                }
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 test-error"></div>
                                    </div>
                                </div>
                                <?php
                                    }
                                }
                                ?>
                            <div class="row" style="padding: 15px;display: none;">
                                <div class="col-sm-12 alert text-center">
                                    <div id="qtest-message"></div>
                                </div>
                            </div>
                        <div class="test-option-cell">
                            <div class="row">
                                <div class="col-sm-9 mr-top-10 mr-bot-10">
                                    <input class="btn btn-primary btn-block" type="button" id="btnNextQuestion" name="btnNextQuestion" value="Next question >>" />
                                </div>
                                <div class="col-sm-3 mr-top-10 mr-bot-10">
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <h3 id="timerClock"><?php echo $remainingTime;?></h3>
                                            <input type="hidden" id="remainingTime" name="remainingTime" value="<?php echo $remainingTime;?>" />
                                            <input type="hidden" id="runningTestId" name="runningTestId" value="<?php echo $runningTestId;?>" />
                                            <p>Time remaining</p>
                                        </div>
                                        <div class="icon">
<!--                                            <i class="ion ion-android-stopwatch"></i>-->
                                            <i class="ion ion-android-alarm-clock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-cell">
                            <div class="row">
                                <div class="col-sm-12 mr-top-10 mr-bot-10 submit-test">
                                    <input type="hidden" id="hidd_test_id" value="<?php echo $testId; ?>" />
                                    <input class="btn btn-primary" <?php echo ($testAlreadySubmitted == 1 ? "disabled='disabled'" : ''); ?> type="button" id="btnSubmitTest" name="btnSubmitTest" value="Submit test" />
                                </div>
                                <div class="col-sm-12 alert text-center">
                                    <div id="test-message"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</section>
<style>
    .question-cell{
        display: none;
        padding: 30px;
        border: 2px solid silver;
        border-radius: 10px;
    }
    .submit-cell{
        display: none;
    }
    .question-cell.active{
        display:block;
    }
    .test-opt label{
        font-weight: normal;
        cursor: pointer;
    }
    .error, .markedRed{
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
    .submit-test{
        text-align: center;
    }
    .test-ques{
        margin-bottom: 10px;
        padding-bottom: 10px;
    }
    input[type="checkbox"], input[type="radio"]{
        line-height: normal;
        margin-bottom: 6px;
        margin-right: 2px;
        vertical-align: middle;
        cursor: pointer;
    }
</style>
<script>
    var timeoutHandle;
    function countdown(timerTime) {
        var minutes = timerTime.split(":");
        var maxMinutes = parseInt(minutes[0]);
        var maxSeconds = parseInt(minutes[1]);
        function tick() {
            if(maxSeconds == 0)
            {
                maxMinutes = maxMinutes - 1;
                maxSeconds = 60;
            }   
            maxSeconds--;
            var counter = document.getElementById("timerClock");
            counter.innerHTML = (maxMinutes < 10 ? "0" : "") + String(maxMinutes)
                            + ":" + (maxSeconds < 10 ? "0" : "") + String(maxSeconds);
            $("#remainingTime").val(counter.innerHTML);
            if( maxSeconds > 0 ) {
                timeoutHandle = setTimeout(tick, 1000);
                if(maxSeconds % 10 == 0)
                    updateTimer();
            } else {
                if(maxMinutes > 0){
                // countdown(mins-1);   //never reach “00″ issue solved
                setTimeout(function (){ 
                        var cTime = maxMinutes - 1;
                        cTime = (cTime < 10 ? "0" : "")+ String(cTime) + ":60";
                        countdown(cTime); 
                    }, 1000);
                }
                else{
                    swal("Test allowed time is over, test is submitted!");
                    submitTest();
                }
            }
        }
        tick();
    }
    
    function updateTimer(){
        var runningTestId = $("#runningTestId").val();
        var remainingTime = $("#remainingTime").val();
        $.post("<?php echo base_url(); ?>index.php/students/upatetimer",
        {
            'runningTestId': runningTestId,
            'remainingTime': remainingTime
        }, function (data) {
            
        }, 'json');
    }
    
    function toggleFullScreen(elem) {
            // ## The below if statement seems to work better ## if ((document.fullScreenElement && document.fullScreenElement !== null) || (document.msfullscreenElement && document.msfullscreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
            if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
                if (elem.requestFullScreen) {
                    elem.requestFullScreen();
                } else if (elem.mozRequestFullScreen) {
                    elem.mozRequestFullScreen();
                } else if (elem.webkitRequestFullScreen) {
                    elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen();
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            }
        }
    
    $(document).ready(function () {
        $(document).on("keydown",function(ev){
//                console.log(ev.keyCode);
                if(ev.keyCode===27||ev.keyCode===122||ev.keyCode===116) return false
        });
//        window.onbeforeunload = function() {
//            return 'Are you sure you want to leave test?';
//        };
        $("li#students").addClass("current");
        $("li#students a").addClass("open");
        $("li#students ul.sub").css('display', 'block');
        $("li#students ul.sub li#students_1").addClass("current");
        $("body").on("change", ".log_answer", function () {
            var quesId = $(this).attr('data-ques');
            var myVal = $(this).val();
            $.post("<?php echo base_url(); ?>index.php/students/logquesanswer",
                    {
                        'quesId': quesId,
                        'myVal': myVal
                    }, function (data) {
                // notify user
                if (data.result == '0')
                {
                    //alert(data.message);
                    swal('Error', data.message);
                }
            }, 'json');
        });

        $("body").on("click", "#btnClickToStart", function () {
            confirmAction("Are you sure you want to start the test? \nPlease read all instructions carefully before starting the test.", function(s){
            if(s){
                $("#divContinueTest").show();
                $("#divClickToStart").hide();
                toggleFullScreen(document.body);
            }
            },true,true);
        });
        $("body").on("click", "#btnContinue", function () {
            $("#divTestD").show();
            $("#divContinueTest").hide();
            countdown("<?php echo $remainingTime;?>");
            // INSERT TEST IS STARTED LOG
            var testId = $("#hidd_test_id").val();
            var remainingTime = $("#remainingTime").val();
            $.post("<?php echo base_url(); ?>index.php/students/teststarted",
                    {
                        'testId': testId,
                        'remainingTime': remainingTime
                    }, function (data) {
                        $("#runningTestId").val(data.testSubmitId);
                }, 'json');
        });
        
        $("body").on("click", "#btnNextQuestion", function () {
            var group = {};
            var allowSubmit = 1;
            $("#qtest-message").parent().parent().hide();
            $('.question-cell.active input[name^="opt_"]').each(function (index) {
                var name = this.name;
                if (!group[name]) {
                    group[name] = true;
                    var myval = $("input[name=" + name + "]:checked").val();
                    if (typeof myval == "undefined")
                    {
                        allowSubmit = 0;
                        $("input[name=" + name + "]").parent().parent().parent().prev().find('.test-ques-sr').addClass('markedRed');
                    }
                }
            });

            if (!allowSubmit)
            {
                $("#qtest-message").parent().parent().show();
                $("#qtest-message").html("All questions are mandatory, please select at least one option.");
                $("#qtest-message").parent().removeClass('alert-success');
                $("#qtest-message").parent().addClass('alert-danger');
            }
            else
            {
                $(".question-cell.active").removeClass('active').next().addClass('active');
            }
            if($(".question-cell.active").hasClass('qcell-50')){
                $("#btnNextQuestion").hide();
                $(".submit-cell").show();
            }
        });
        // BELOW CODE IS FOR PAGE ONLOAD WHEN LAST QUESTION WAS REMAINING
        if($(".question-cell.active").hasClass('qcell-50')){
            $("#btnNextQuestion").hide();
            $(".submit-cell").show();
        }

        $("body").on("click", "#btnSubmitTest", function () {
            var group = {};
            var allowSubmit = 1;
            $("#qtest-message").parent().parent().hide();
            $('.question-cell.active input[name^="opt_"]').each(function (index) {
                var name = this.name;
                if (!group[name]) {
                    group[name] = true;
                    var myval = $("input[name=" + name + "]:checked").val();
                    if (typeof myval == "undefined")
                    {
                        allowSubmit = 0;
                        $("input[name=" + name + "]").parent().parent().parent().prev().find('.test-ques-sr').addClass('markedRed');
                    }
                }
            });

            if (!allowSubmit)
            {
                $("#qtest-message").parent().parent().show();
                $("#qtest-message").html("All questions are mandatory, please select at least one option.");
                $("#qtest-message").parent().removeClass('alert-success');
                $("#qtest-message").parent().addClass('alert-danger');
            }
            else
            {
                confirmAction("Are you sure you want to submit this test? \nOnce it is submitted, you will not be allowed to edit it again!", function(s)
                {
                    if(s){
                        submitTest();
                    }
                },true,true);
            }
        });
        
        // REMOVE OTHER OPTIONS 
        // DISABLE BACK OPTION.
        $(".sidebar-toggle").trigger('click');
        $(".sidebar").hide();
        $(".main-header").hide();
        $(".content-header").hide();
        // for mobiles 
         setTimeout(function(){$('.content').trigger('click');},1000);
        //$(".main-sidebar").hide();
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    });
    function submitTest(){
        var testId = $("#hidd_test_id").val();
        $.post("<?php echo base_url(); ?>index.php/students/submittest",
            {
                'testId': testId
            }, function (data) {
            // notify user
            $("#test-message").html(data.message);
            if (data.result == '0')
            {
                $("#test-message").parent().addClass('alert-danger');
                $("#test-message").parent().removeClass('alert-success');
            } else {
                $("input[type=radio]").attr('disabled', 'disabled');
                $("#btnSubmitTest").attr('disabled', 'disabled');
                $("#test-message").parent().removeClass('alert-danger');
                $("#test-message").parent().addClass('alert-success');
                setTimeout(function(){
                    $("#testCompletedBox").show();
                    $("#divTestD").hide();
                },1000);
            }
        }, 'json');
    }
</script>