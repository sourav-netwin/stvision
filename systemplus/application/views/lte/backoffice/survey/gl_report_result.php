<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<style type="text/css">
	@media only screen and (max-width: 500px) {
		.col-xs-10 {
			padding-left: 5px;
			padding-right: 5px;    
			width: 74.333% !important;
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
		/*		.up img{
					float:right;
				}*/
	}
	@media only screen and (max-width: 991px) {
		.col-xs-9 {
			padding-left: 5px;
			padding-right: 5px;    
			width: 66.333%;
		}
		.col-xs-10 {
			padding-left: 5px;
			padding-right: 5px;    
			width: 74.333% !important;
		}
	}
        #btnBack{
            margin-bottom: 10px;
        }
</style>
<!-- Here goes the content. -->
	<div class="pull-right">
		<input class="btn btn-primary" type="button" id="btnBack" name="btnBack" value=" << Back" onclick="window.location.href='<?php echo base_url(); ?>index.php/survey/report'" />
	</div>
	<div class="row">  
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title width-full text-center"><?php echo $headingSurvey; ?></h3>
				</div>
				<div class="box-body">

					<div id="surveyDiv">
						<?php
						$currentQueSection = "";
						if ($reportData)
							foreach ($reportData as $survey1) {
								if ($currentQueSection == "" || $currentQueSection != $survey1['que_section']) {
									$currentQueSection = $survey1['que_section'];
									?>
									<div class="col-md-12">
										<div class="head">
											<div class="row">
												<div class="col-xs-10"><div class="res-main-head"><?php echo $survey1['que_section']; ?></div></div>
												<div class="col-xs-1 mr-top-11"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/thumb-up.png"/></div>
												<div class="col-xs-1 mr-top-11"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/thumb.png"/></div>
											</div>
										</div>
									</div>
									<?php
								}

								//if (!$survey1['que_iscomment']) {
								$total = $survey1['yes_count'] + $survey1['no_count'];
								$yesCount = $survey1['yes_count'];
								$noCount = $survey1['no_count'];
								$noCountPer = 0;
								$yesCountPer = 0;
								if ($yesCount)
									$yesCountPer = round(($yesCount / $total) * 100, 1);
								if ($noCount)
									$noCountPer = round(($noCount / $total) * 100, 1);
//										if ($survey1['que_is_header'] == 0 && $survey1['que_isyesno'] == 0 /*&& $survey1['que_iscomment'] == 0*/) {
//											// THIS IS INPUT BOX FILED USED TO TAKE INPUT AS NUMBER....
//											echo $survey1['que_iscomment'];
//										}
//										else {
								?>
								<div class="col-md-12 <?php echo ($survey1['que_is_header'] ? '' : 'border-bot-5-pad') ?>">
									<div class="head" >
										<div class="row">
											<?php if (empty($survey1['que_parent_que_id'])) { ?>
												<div class="col-xs-1 ques-number text-middle"><?php echo $survey1['que_number']; ?>.</div>
												<?php
											}
											else {
												?>
												<div class="col-xs-1 text-middle">&nbsp;</div>
											<?php } ?>
											<div class="col-xs-9  text-middle <?php echo ($survey1['que_is_header'] ? 'ques-head' : 'ques-option') ?>"><span id="ques_<?php echo $survey1['que_id']; ?>" class="<?php echo ($survey1['que_parent_que_id'] ? 'display-bullets' : ''); ?>"><?php echo $survey1['que_question']; ?></span></div>
											<?php if ($survey1['que_isyesno'] == 1) { ?>
												<div class="col-xs-1">
													<div class="progress vertical">
														<div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="<?php echo $yesCountPer; ?>" aria-valuemin="0" aria-valuemax="100" style="height: <?php echo $yesCountPer; ?>%">

														</div>
														<a class="lnkSurveyUsers" data-type="Yes" data-section="<?php echo $survey1['que_section'] ?>" data-id="<?php echo $survey1['que_id']; ?>" href="javascript:void(0);"><span><?php echo (empty($survey1['yes_count']) ? '' : $yesCountPer . '%'); ?></span></a>
													</div>
												</div>
												<div class="col-xs-1">
													<div class="progress vertical">
														<div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="<?php echo $noCountPer; ?>" aria-valuemin="0" aria-valuemax="100" style="height: <?php echo $noCountPer; ?>%">

														</div>
														<a class="lnkSurveyUsers" data-type="No" data-section="<?php echo $survey1['que_section'] ?>" data-id="<?php echo $survey1['que_id']; ?>" href="javascript:void(0);"><span><?php echo (empty($survey1['no_count']) ? '' : $noCountPer . '%'); ?></span></a>
													</div>
												</div>
												<?php
											}
											elseif ($survey1['que_is_header'] != 1 && $survey1['que_iscomment'] == 1) {
												?>
												<div class="col-xs-2 text-middle">
													<?php
													if ($survey1['comment_count'] != 0) {
														?>
														<a class="lnkSurveyUsersComments" data-type="No" data-section="<?php echo $survey1['que_section'] ?>" data-id="<?php echo $survey1['que_id']; ?>" href="javascript:void(0);"><span><?php echo (empty($survey1['comment_count']) ? $survey1['comment_count'] : $survey1['comment_count'] . ' comment(s)'); ?></span></a>
														<?php
													}
													else {
														echo 'No comments added';
													}
													?>
												</div>
												<?php
											}
											elseif ($survey1['que_is_header'] != 1 && $survey1['que_iscomment'] != 1) {
												?>
												<div class="col-xs-2 text-middle">
													<?php
													if ($survey1['comment_count'] != 0) {
														?>
														<a class="lnkSurveyUsersAns" data-type="No" data-section="<?php echo $survey1['que_section'] ?>" data-id="<?php echo $survey1['que_id']; ?>" href="javascript:void(0);"><span><?php echo ($survey1['comment_count'] == 0 ? '' : $survey1['comment_count'] . ' answer(s)'); ?></span></a>
														<?php
													}
													else {
														echo 'No answer(s) added';
													}
													?>
												</div>
												<?php
											}
											?>
										</div>
									</div>
								</div>
								<?php
								//}
								//}
							}
						?>
					</div>
					<input type="hidden" id="hidd_campus" value="<?php echo $campusId; ?>" />
					<input type="hidden" id="hidd_survey" value="<?php echo $surveyType; ?>" />
					<input type="hidden" id="hidd_agent" value="<?php echo $agentId; ?>" />
					<input type="hidden" id="hidd_fd" value="<?php echo $fd; ?>" />
					<input type="hidden" id="hidd_td" value="<?php echo $td; ?>" />

				</div>
			</div>
		</div>
	</div>

</div>

<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
	var pageHighlightMenu = "survey/report";
    $(document).ready(function() {
        $(".progress-bar").hide();
        setTimeout(function(){ 
            $(".progress-bar").animate({
                height: 'toggle'
            },1000);
        }, 1000);
        
        
        $( "body" ).on( "click", ".lnkSurveyUsers", function() {
			$("#surveyUsersList").html('');
			$("#lblQuestion").html('');
			$("#lblSurveyRptTitle").html('Survey user list');
            var data_id = $(this).attr('data-id');
            var data_type = $(this).attr('data-type');
            var data_sect = $(this).attr('data-section');
            
            var hidd_campus = $("#hidd_campus").val();
            var hidd_survey = $("#hidd_survey").val();
            var hidd_agent = $("#hidd_agent").val();
            var hidd_fd = $("#hidd_fd").val();
            var hidd_td = $("#hidd_td").val();
            
            var loadingDiv = "<div class='showloading'></div>";
            var strQuestion = $("#ques_"+data_id).html();
            $("#surveyUsersList").html(loadingDiv);
            // load students for the campus
            $.post( siteUrl + "survey/getSurveyUsers",{
                'data_id':data_id,
                'data_type':data_type,
                'hidd_campus':hidd_campus,
                'hidd_survey':hidd_survey,
                'hidd_agent':hidd_agent,
                'hidd_fd':hidd_fd,
                'data_sect':data_sect,
                'hidd_td':hidd_td
            }, function( data ) {
               
				var html = '<div id="surveyUsersListDiv" class="box">\n\
        <div class="box-header">\n\
            <h2 class="box-title"><span id="lblSurveyRptTitle"><strong>Group leader(s) who said: '+data_type+'</strong></span></h2>\n\
        </div>\n\
        <div class="content">\n\
            <div><p><span id="lblQuestion"><strong>Question: '+strQuestion+'</strong></span></p></div>\n\
            <div id="surveyUsersList">'+data+'</div>\n\
        </div>\n\
    </div>';
				createModal('glDetailsTable', 'Survey user list', html, 'large');
				initDataTable('stdGlUserDataTable');
				
            }); 
        });
        $( "body" ).on( "click", ".lnkSurveyUsersComments", function() {
			$("#surveyUsersList").html('');
			$("#lblQuestion").html('');
			$("#lblSurveyRptTitle").html('Group leader(s) who commented');
            var data_id = $(this).attr('data-id');
            var data_type = $(this).attr('data-type');
            var data_sect = $(this).attr('data-section');
            
            var hidd_campus = $("#hidd_campus").val();
            var hidd_survey = $("#hidd_survey").val();
            var hidd_agent = $("#hidd_agent").val();
            var hidd_fd = $("#hidd_fd").val();
            var hidd_td = $("#hidd_td").val();
            
            var loadingDiv = "<div class='showloading'></div>";
            var strQuestion = $("#ques_"+data_id).html();
            $("#surveyUsersList").html(loadingDiv);
            // load students for the campus
            $.post( siteUrl + "survey/getSurveyUsersComment",{
                'data_id':data_id,
                'data_type':data_type,
                'hidd_campus':hidd_campus,
                'hidd_survey':hidd_survey,
                'hidd_agent':hidd_agent,
                'hidd_fd':hidd_fd,
                'data_sect':data_sect,
                'hidd_td':hidd_td
            }, function( data ) {
				var html = '<div id="surveyUsersListDiv" class="box">\n\
        <div class="box-header">\n\
            <h2 class="box-title"><span id="lblSurveyRptTitle"><strong>Group leader(s) who commented</strong></span></h2>\n\
        </div>\n\
        <div class="content">\n\
            <div><p><span id="lblQuestion"><strong>Comments</strong></span></p></div>\n\
            <div id="surveyUsersList">'+data+'</div>\n\
        </div>\n\
    </div>';
				createModal('glDetailsTable', 'Survey user list', html, 'large');
				initDataTable('stdGlUserCommentsDataTable');
            }); 
        });
        $( "body" ).on( "click", ".lnkSurveyUsersAns", function() {
			$("#surveyUsersList").html('');
			$("#lblQuestion").html('');
			$("#lblSurveyRptTitle").html('Group leader(s) who answered');
            var data_id = $(this).attr('data-id');
            var data_type = $(this).attr('data-type');
            var data_sect = $(this).attr('data-section');
            
            var hidd_campus = $("#hidd_campus").val();
            var hidd_survey = $("#hidd_survey").val();
            var hidd_agent = $("#hidd_agent").val();
            var hidd_fd = $("#hidd_fd").val();
            var hidd_td = $("#hidd_td").val();
            
            var loadingDiv = "<div class='showloading'></div>";
            var strQuestion = $("#ques_"+data_id).html();
            $("#surveyUsersList").html(loadingDiv);
            // load students for the campus
            $.post( siteUrl + "survey/getSurveyUsersAns",{
                'data_id':data_id,
                'data_type':data_type,
                'hidd_campus':hidd_campus,
                'hidd_survey':hidd_survey,
                'hidd_agent':hidd_agent,
                'hidd_fd':hidd_fd,
                'data_sect':data_sect,
                'hidd_td':hidd_td
            }, function( data ) {
				var html = '<div id="surveyUsersListDiv" class="box">\n\
        <div class="box-header">\n\
            <h2 class="box-title"><span id="lblSurveyRptTitle"><strong>Group leader(s) who answered<strong></span></h2>\n\
        </div>\n\
        <div class="content">\n\
            <div><p><span id="lblQuestion"><strong>Question: ' + strQuestion+'</strong></span></p></div>\n\
            <div id="surveyUsersList">'+data+'</div>\n\
        </div>\n\
    </div>';
				createModal('glDetailsTable', 'Survey user list', html, 'large');
				initDataTable('stdGlUserAnswerDataTable');
            }); 
        });
    });
	
</script>	
