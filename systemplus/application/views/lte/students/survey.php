    <?php
        //This will echo session success / failure messages
        showSessionMessageIfAny($this);
    ?>
      <?php 
        if ($selDate) {
        ?>
            <div class="row">
                <div class="col-md-12 row-margin">
                    <a href="<?php echo site_url() ?>/student_survey" style="float: right">
                        <input class="btn btn-primary" type="button" value="< Back" />
                    </a>
                </div>
            </div>
        <?php
        }
        ?>
<?php
                
                $actualActiveDate = '';
                if (!empty($filledWeeks)) {
                        ?>
                        
      <div class="box">
          
        <div class="box-header with-border">
          <h3 class="box-title">Completed surveys</h3>
          <div class="box-tools pull-right">
            <button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
            <div class="grid_12">
                
                                <div class="">
                                        <div class="completed-link">
                                                <p>So far you have completed the below surveys. Click on the link to view the details.</p>
                                                <ul>
                                                        <?php
                                                        $isCurrentActive = FALSE;
                                                        foreach ($weekStart as $wStart) {
                                                                if ((date('Y-m-d') > $wStart) && (date('Y-m-d', strtotime($wStart . ' +5 days')) <= date('Y-m-d'))) {
                                                                        if (!$selDate) {
                                                                                $isCurrentActive = TRUE;
                                                                                $actualActiveDate = date('Y-m-d', strtotime($wStart . ' +5 days'));
                                                                                $toDate = date('Y-m-d', strtotime($wStart . ' +6 days'));
                                                                                $fromDate = $wStart;
                                                                                $week = array_search($wStart, $weekStart);
                                                                        }
                                                                }
                                                                if ((date('Y-m-d') >= $wStart) && (date('Y-m-d', strtotime($wStart . ' +5 days')) > date('Y-m-d'))) {
                                                                        $actualActiveDate = date('Y-m-d', strtotime($wStart . ' +5 days'));
                                                                        break;
                                                                }
                                                        }
                                                        asort($filledWeeks);
                                                        foreach ($filledWeeks as $filled) {
                                                                $weekAr = explode('_', $filled['ts_week']);
                                                                ?>
                                                                <li><a href="<?php echo site_url() ?>/student_survey/view/<?php echo $weekAr[1]; ?>">Week <?php echo array_search($weekAr[1], $weekStart) ?></a></li>
                                                                <?php
                                                        }
                                                        //echo $actualActiveDate;die;
                                                        ?>
                                                </ul>
                                        </div>
                                </div>
                        
                </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
      </div>
<?php
                }
                ?>
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Survey</h3>
          <div class="box-tools pull-right">
            <button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
                <div class="">
                                <?php 
                                $previousFound = 0;
                                $previousDates = array();
                                $arrivalDate = date('Y-m-d', strtotime($fromDate));
                                $currDate = date("Y-m-d");
                                if ($isFilledAll && !$selDate) {
                                        ?>
                                        <div class="survey-message">You have successfully completed all survey(s)</div>
                                        <?php
                                }
                                else {
                                        if ($isDateMatch) {
                                                $previousFound = 0;
                                        }
                                        else if (!empty($surveyStatus)) { 
                                                foreach ($surveyStatus as $key => $val) {
                                                        $startDate = $key;
                                                        $endDate = date('Y-m-d', strtotime($startDate . ' +6 days'));
                                                        $currDate = date('Y-m-d');
                                                        if ((($endDate < $currDate) && (!in_array($startDate, $filledDates)))) {
                                                                $previousFound += 1;
                                                                $previousDates[] = $startDate;
                                                        }
                                                }
                                        }
                                        if ($previousFound == 0) {
                                                $actualActiveDate = $actualActiveDate == '' ? date('Y-m-d', strtotime($fromDate . ' +5 days')) : $actualActiveDate;
                                                if ((($actualActiveDate <= $currDate) && ($currDate <= date('Y-m-d', strtotime($toDate)))) || $isDateMatch) {
                                                        ?>

                                                        <div style="text-align: center; margin-top: 15px">
                                                            <h3><?php echo strtoupper($testTitle) ?> (Week <?php echo $week ?>)</h3>
                                                        </div>

                                                        <!--div class="survey-title-sub">Week <?php //echo $week ?></div-->
                                                        <div class="survey-student">
                                                            <div class="row">
                                                                <div class="row-margin col-md-3">
                                                                        <strong>Campus:</strong> <?php echo $userDetails['nome_centri'] ?>
                                                                </div>
                                                                <div class="row-margin col-md-3">
                                                                        <strong>From:</strong> <?php echo $fromDate ? date('d/m/Y', strtotime($fromDate)) : '' ?>
                                                                </div>
                                                                <div class="row-margin col-md-3">
                                                                        <strong>To:</strong> <?php echo $toDate ? date('d/m/Y', strtotime($toDate)) : '' ?>
                                                                </div>
                                                                <div class="row-margin col-md-3">
                                                                        <strong>Name:</strong> <?php echo $userDetails['nome'] . ' ' . $userDetails['cognome'] ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="row-margin col-md-3">
                                                                        <strong>Group Leader:</strong> <?php echo $GLName ?>
                                                                </div>
                                                                <div class="row-margin col-md-9">
                                                                        <strong>Company travelling with: </strong> <?php echo $userDetails['businessname'] ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="row-margin col-md-12">
                                                                        <?php
                                                                        if (!$isSurveyCompleted) {
                                                                                ?>
                                                                                <div class="col-md-12 row-margin center text-small survey-info">Please tell us what you think of your Junior Summer Course</div>
                                                                                <?php
                                                                        }
                                                                        else {
                                                                                ?>
                                                                                <div class="col-md-12 row-margin center text-small survey-info">You successfully completed this survey</div>
                                                                                <?php
                                                                        }
                                                                        ?>
                                                                        <div>
                                                                                <div class="col-md-3"><img width="25" src="<?php echo base_url() ?>js/raty/img/survey/smiley-sad.png" /> - Poor</div>
                                                                                <div class="col-md-3"><img width="25" src="<?php echo base_url() ?>js/raty/img/survey/smiley-neutral.png" /> - Satisfactory</div>
                                                                                <div class="col-md-3"><img width="25" src="<?php echo base_url() ?>js/raty/img/survey/smiley.png" /> - Good</div>
                                                                                <div class="col-md-3"><img width="25" src="<?php echo base_url() ?>js/raty/img/survey/smiley-yell.png" /> - Excellent</div>
                                                                        </div>

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <form method="POST" id="surveyForm">
                                                                <div class="survey-questions">
                                                                        <?php
                                                                        if ($questionArray) {
                                                                                foreach ($questionArray as $heading => $questions) {
                                                                                        echo '<div class="question-heading">' . $heading . '</div>';

                                                                                        foreach ($questions as $question) {
                                                                                                echo '<div class="col-md-12 qst-div">';
                                                                                                echo '<div class="col-md-6 question-text">' . $question['question'] . '</div>';
                                                                                                echo '<div class="col-md-6 question-rate" data-start="' . $question['filled'] . '" data-rate="' . $question['starNo'] . '" id="survey_' . $question['id'] . '"></div>';
                                                                                                echo '</div>';
                                                                                        }
                                                                                }
                                                                        }
                                                                        ?>
                                                                </div>
                                                                <input type="hidden" id="surveyUuid" value="<?php echo $userDetails['uuid'] ?>" />
                                                                <input type="hidden" id="surveyWeek" value="<?php echo $weekSend ?>" />
                                                                <input type="hidden" id="surveyTest" value="<?php echo $testId ?>" />
                                                                <?php
                                                                if (!$isSurveyCompleted) {
                                                                        ?>
                                                                        <div class="col-md-12 row-margin center">
                                                                                <input class="btn btn-primary" id="btnSave" name="btnSave" value="Submit" type="submit">
                                                                        </div>
                                                                <?php } ?>
                                                        </form>
                                                        <?php
                                                }
                                                else {
                                                        ?>
                                                        <div class="survey-message">You will have access to this survey starting from <?php echo date('d/m/Y', strtotime($actualActiveDate)) ?></div>
                                                        <?php
                                                }
                                        }
                                        else {
                                                ?>
                                                <div class="previous-link">
                                                        <p>You have pending survey(s) which listed below . Click on the link to start survey.</p>
                                                        <ul>
                                                                <?php
                                                                foreach ($previousDates as $previousDate) {
                                                                        ?>
                                                                        <li><a href="<?php echo site_url() ?>/student_survey/view/<?php echo $previousDate; ?>">Survey for Week <?php echo array_search($previousDate, $weekStart) ?></a></li>
                                                                        <?php
                                                                }
                                                                ?>
                                                        </ul>
                                                </div>
                                                <?php
                                        }
                                }
                                ?>

                </div><!-- End of .box -->
        </div>
        </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
<style>
        .survey-title{
			width: 100%;
			text-align: center;
			font-size: 15px;
			font-weight: bold;
			padding: 5px 0px;
		}
		.survey-title-sub{
			width: 100%;
			text-align: center;
			font-size: 13px;
			font-weight: bold;
		}
		.survey-student{
			width: 100%;
			margin-top: 10px;
			font-size: 14px;
		}
		.row-margin{
			margin: 5px 0;
		}
		.center{
			text-align: center;
		}
		.text-small{
			font-size: 11px;
		}
		.survey-questions{
			margin-top: 10px;
		}
		.question-heading{
			font-size: 15px;
			font-weight: bold;
			border-bottom: 1px solid rgb(194, 194, 194);
			margin-top: 5px;
			margin-bottom: 10px;
			width: 100%;
			clear: both;
		}
		.question-text{
			font-size: 14px;
			padding: 5px;
		}
		.question-rate{
			padding: 5px;
			display: inline-block !important;
			width: auto !important;
			min-width: 105px;
                        line-height: 29px;
		}
		.tuition_success{
			width: 97%;
			margin: auto;
		}
		.tuition_error{
			width: 97%;	
			margin: auto;
		}
		.survey-message{
			text-align: center;
			margin: 10px;
		}
		.previous-link{
			margin-top: 10px;
		}
		
		.survey-title::after {
			display: block;
			position: absolute;
			width: 100%;
			height: 1px;
			background: #dddee1;
			left: 0;
			top: 50%;
			content: ' ';
		}
		.survey-info{
			color: rgb(255, 0, 0);
			margin: 15px;
			font-size: 14px;
		}
		
</style>
<script>
    var RATY_BASE_PATH = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url(); ?>js/raty/jquery.raty.alt.js"></script>    
<script>
    var pageHighlightMenu = "student_survey";
	$(document).ready(function() {
                initRaty();
	});
        var surveyIsCompleted = false;
	function initRaty(){
		var emoArray4 = [['survey/smiley-sad.png',1],['survey/smiley-neutral.png',2],['survey/smiley.png', 3],['survey/smiley-yell.png', 4]];
		var emoHint4 = ['Poor', 'Satisfactory', 'Good', 'Excellent'];
		var emoArray2 = [['survey/smiley-sad.png',1],['survey/smiley-yell.png', 2]];
		var emoHint2 = ['Unsatisfactory', 'Satisfactory'];
		var readOnly = false;
                <?php
                if ($isSurveyCompleted) {
                        ?>
                    readOnly = true;
                    surveyIsCompleted = true;
                        <?php
                }
                ?>
		$('.question-rate').each(function(e,ele){
			var stars = $(ele).attr('data-rate');
			var start = $(ele).attr('data-start');
			if(start == '' || typeof start == 'undefined'){
				start = 0;
			}
			var id = $(ele).attr('id');
			var iconArray = [];
			var hintArray = [];
			if(stars == 4){
				iconArray = emoArray4;
				hintArray = emoHint4;
			}
			if(stars == 2){
				iconArray = emoArray2;
				hintArray = emoHint2;
			}
			if(!parseInt(stars))
				stars = 0;
			$("#"+id).raty(
			{
				number: stars,
				iconRange: iconArray,
				starOff:   'survey/face-off.png',
				hintList: hintArray,
				start: start,
				cancel:       true,
				cancelHint:   'Remove my rating!',
				cancelPlace:  'left',
				readOnly: readOnly,
				noRatedMsg: 'Not rated',
				showOne: true,
				starOnWidth: 25,
				starOffWidth: 16
			});
			
		});
	}
	/*$('body').on('click','#btnReset', function(e){
		e.preventDefault();
		$('.question-rate').each(function(ev,ele){
			var id = $(ele).attr('id');
			$.fn.raty.cancel("#"+id);
		});
			
	});*/
		
	$('#surveyForm').submit(function(e){
		e.preventDefault();
		$('#btnSave').attr('disabled', 'disabled');
		var uuid = $('#surveyUuid').val();
		var week = $('#surveyWeek').val();
		var test = $('#surveyTest').val();
                confirmAction("Be sure! Once you marked it as completed you can't edit it again.", function(c){
		if(c){
			$.ajax({
				url: siteUrl + 'student_survey/submitSurvey',
				type: 'POST',
				data: {
					uuid: uuid,
					week: week,
					test: test
				},
				success: function(data){
					if(data == 1){
						$('.survey-info').html('You successfully completed this survey');
						$('#btnSave').parent().remove();
						$.fn.raty.readOnly(true, '.question-rate');
						//alert('Survey details entered successfully');
                                                swal('Success', 'Survey details entered successfully');
					}
					else{
						$('#btnSave').removeAttr('disabled');
                                                swal('Error', 'Failed to insert survey details');
					}	
				},
				error: function(){
					$('#btnSave').removeAttr('disabled');
                                        swal('Error', 'Failed to insert survey details');                                        
				}
			});
		}
		else{
			$('#btnSave').removeAttr('disabled');
		}
            },false,true);
	});
	
	$('body').on('click','.question-rate img', function(){
		var elm = $(this).parent();
		var value = elm.find('input').val();
		var option = elm.attr('id').replace('survey_','');
		var uuid = $('#surveyUuid').val();
		var week = $('#surveyWeek').val();
                if(!surveyIsCompleted)
                {
                    if(value == '' || typeof value == 'undefined'){
                            value = 0;
                    }
                    if(value !== '' && typeof value != 'undefined' && option != '' && typeof option != 'undefined' && uuid != '' && typeof uuid != 'undefined' && week != '' && typeof week != 'undefined'){
                            $.ajax({
                                    url: siteUrl + 'student_survey/store_survey',
                                    type: 'POST',
                                    data: {
                                            value: value,
                                            option: option,
                                            uuid: uuid,
                                            week: week
                                    },
                                    success: function(data){
                                            if(data != 1){
                                                    swal('Error', 'Something went wrong. Please refresh and try again!');  
                                            }
                                    },
                                    error: function(){
                                            swal('Error', 'Something went wrong. Please refresh and try again!');  
                                    }
                            });
                    }
                    else{
                            swal('Error', 'Something went wrong. Please refresh and try again!');  
                    }
                }
	});
		
</script>