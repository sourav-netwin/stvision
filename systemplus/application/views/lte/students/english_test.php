<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- About Me Box -->
            <?php if ($checkCDUserMarks) { ?>
                <div class="alert alert-danger">
                    Current test is disabled, may be you have opted for offline test.
                </div>
            <?php } else { ?>
                <div class="box box-primary">                
                    <div class="box-header with-border text-center">
                        <h3 class="box-title">PLACEMENT TEST <?php echo date('Y'); ?> </h3>
                    </div>
                    <!-- /.box-header -->                
                    <div class="box-body test-head">
                        <p ><strong>Question paper</strong></p>
                        <p class="test-note"><span>Do as many questions as you can, beginning with question 1. Only ONE answer is correct in each question. Choose A,
                                B, C or D from available options.</span></p>
                        <p><span class="test-title"><?php echo $testName; ?></span></p>
                        <div class="row">
                            <div class="test-example col-sm-12">
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
                    <div class="box-body" style="padding-left:25px;padding-right: 25px;">
                        <?php
                        if ($testQuestionData) {
                            $sr = 0;
                            foreach ($testQuestionData as $test) {
                                $sr++;
                                ?>
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

                                <?php
                            }
                        }
                        ?>
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
            <?php } ?>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
</section>
<style>
    .test-opt label{
        font-weight: normal;
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
        border-top: 1px solid silver;
        margin-bottom: 10px;
        margin-top: 10px;
        padding-top: 10px;
    }
    input[type="checkbox"], input[type="radio"]{
        line-height: normal;
        margin-bottom: 6px;
        margin-right: 2px;
        vertical-align: middle;
    }
</style>
<script>
    $(document).ready(function () {
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

        $("body").on("click", "#btnSubmitTest", function () {
            var testId = $("#hidd_test_id").val();
            $(".markedRed").removeClass('markedRed');
            var group = {};
            var allowSubmit = 1;
            $('input[name^="opt_"]').each(function (index) {
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
                $("#test-message").html("All questions are mandatory, please complete all the remaining question(s)(marked in red) and submit the test again.");
                $("#test-message").parent().removeClass('alert-success');
                $("#test-message").parent().addClass('alert-danger');
            } else if (confirm("Are you sure to submit this test? \nOnce it is submitted, you would not allowed to edit it again!"))
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
                    }
                }, 'json');
        });

    });
</script>