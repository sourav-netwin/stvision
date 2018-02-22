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

    <div class="modal-body" style="padding-bottom:50px;padding-top: 0;">
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
                            <strong>Name:</strong> <?php echo $userDetails['cognome'] . ' ' . $userDetails['nome'] ?>
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
                            <div>
                                    <div class="col-md-3"><img width="25" src="<?php echo base_url() ?>js/raty/img/survey/smiley-sad.png" /> - Poor</div>
                                    <div class="col-md-3"><img width="25" src="<?php echo base_url() ?>js/raty/img/survey/smiley-neutral.png" /> - Satisfactory</div>
                                    <div class="col-md-3"><img width="25" src="<?php echo base_url() ?>js/raty/img/survey/smiley.png" /> - Good</div>
                                    <div class="col-md-3"><img width="25" src="<?php echo base_url() ?>js/raty/img/survey/smiley-yell.png" /> - Excellent</div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="survey-questions">
                    <?php
                    if ($questionArray) {
                        foreach ($questionArray as $heading => $questions) {
                            echo '<div class="question-heading">' . $heading . '</div>';
                            foreach ($questions as $question) {
                                    echo '<div class="col-md-12 qst-div">';
                                    echo '<div class="col-md-6 question-text">' . $question['question'] . '</div>';
                                    echo '<div class="col-md-6 question-rate" style="padding: 5px;display: inline-block !important;width: auto !important;min-width: 105px;line-height: 29px;" data-start="' . $question['filled'] . '" data-rate="' . $question['starNo'] . '" id="survey_' . $question['id'] . '"></div>';
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
        }
        ?>

    </div><!-- End of .box -->
    <div class="modal-footer">
    </div>
<script>
    var RATY_BASE_PATH = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url(); ?>js/raty/jquery.raty.alt.js"></script>   
<script>
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
                readOnly = true;
                surveyIsCompleted = true;
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
    </script>