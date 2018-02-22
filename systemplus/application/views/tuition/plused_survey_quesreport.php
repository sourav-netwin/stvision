<?php $this -> load -> view('plused_header'); ?>
<style>
    div.text-middle{
        padding-top: 20px;
    }
	.ui-dialog .ui-dialog-content {
		overflow: none !important;
	}
	.ui-dialog label span.text{
		top: 0px !important;
	}
</style>
<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix reportsFilters">

    <!-- The blue toolbar stripe -->
    <section class="toolbar">
        <div class="user">
            <div class="avatar">
                <img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
                <!-- Evidenziare per icone attenzione <span>3</span> -->
            </div>
            <span><?php echo $this -> session -> userdata('businessname'); ?></span>
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
                <li class="line"></li>
                <li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
            </ul>
        </div>
    </section><!-- End of .toolbar-->	

	<?php
	$this -> load -> view('plused_sidebar');
	?>		
    <!-- Here goes the content. -->
    <section id="content" class="container_12 clearfix survey-report-content" data-sort=true>
		<div class="row">  
            <div class="grid_12" style="min-height:250px;">
                <div class="box">
                    <div class="header">
                        <h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png"><div style="text-align: center"><?php echo $headingSurvey; ?></div></h2>
                    </div>
                    <div class="content" style="margin: 10px;">
                        <div style="float:right;">
                            <input class="btn btn-tuition" type="button" id="btnBack" name="btnBack" value=" << Back" onclick="window.location.href='<?php echo base_url(); ?>index.php/survey/report'" />
                        </div>
                        <div id="surveyDiv">
							<?php
							$currentQueSection = "";
							if ($reportData)
								foreach ($reportData as $survey1) {
									if ($currentQueSection == "" || $currentQueSection != $survey1['que_section']) {
										$currentQueSection = $survey1['que_section'];
										?>
										<div class="grid_12">
											<div class="head">
												<div class="grid_10"><span style="font-size:18px;font-weight: bold;"><?php echo $survey1['que_section']; ?></span></div>
												<div class="grid_1"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/thumb-up.png"/></div>
												<div class="grid_1"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/thumb.png"/></div>
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
									<div class="grid_12 <?php echo ($survey1['que_is_header'] ? '' : 'border-bot-5-pad') ?>">
										<div class="head" >
											<?php if (empty($survey1['que_parent_que_id'])) { ?>
												<div class="grid_1 ques-number text-middle"><?php echo $survey1['que_number']; ?>.</div>
												<?php
											}
											else {
												?>
												<div class="grid_1 text-middle">&nbsp;</div>
											<?php } ?>
											<div class="grid_9  text-middle <?php echo ($survey1['que_is_header'] ? 'ques-head' : 'ques-option') ?>"><span id="ques_<?php echo $survey1['que_id']; ?>" class="<?php echo ($survey1['que_parent_que_id'] ? 'display-bullets' : ''); ?>"><?php echo $survey1['que_question']; ?></span></div>
											<?php if ($survey1['que_isyesno'] == 1) { ?>
												<div class="grid_1">
													<div class="survey-stat-bar-container">
														<div class="survey-stat-bar yes" style="height:<?php echo $yesCountPer; ?>%;">
															<a class="lnkSurveyUsers" data-type="Yes" data-section="<?php echo $survey1['que_section'] ?>" data-id="<?php echo $survey1['que_id']; ?>" href="javascript:void(0);"><span><?php echo (empty($survey1['yes_count']) ? '' : $yesCountPer . '%'); ?></span></a>
														</div>
													</div>
												</div>
												<div class="grid_1">
													<div class="survey-stat-bar-container">
														<div class="survey-stat-bar no" style="height:<?php echo $noCountPer; ?>%;">
															<a class="lnkSurveyUsers" data-type="No" data-section="<?php echo $survey1['que_section'] ?>" data-id="<?php echo $survey1['que_id']; ?>" href="javascript:void(0);"><span><?php echo (empty($survey1['no_count']) ? '' : $noCountPer . '%'); ?></span></a>
														</div>
													</div>
												</div>
												<?php
											}
											elseif ($survey1['que_is_header'] != 1 && $survey1['que_iscomment'] == 1) {
												?>
												<div class="grid_2 text-middle">
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
												<div class="grid_2 text-middle">
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
    </section>

</div>
<div style="display: none; overflow: auto" id="dialog_modal_survey_userlist" title="Survey user list" class="windia-students">
    <div id="surveyUsersListDiv" class="box">
        <div class="header">
            <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span id="lblSurveyRptTitle">Survey user list</span></h2>
        </div>
        <div class="content">
            <div><p><span id="lblQuestion"></span></p></div>
            <div id="surveyUsersList"></div>
        </div>
    </div>
</div>

<script>
    var SITE_PATH = "<?php echo base_url(); ?>index.php/";
    $(document).ready(function() {
        $('form').removeClass('no-box');
        $( "li#mnusurvey" ).addClass("current");
        $( "li#mnusurvey a" ).addClass("open");		
        $( "li#mnusurvey ul.sub" ).css('display','block');	
        $( "li#mnusurvey ul.sub li#mnusurvey_1" ).addClass("current");	
        $(".survey-stat-bar").hide();
        setTimeout(function(){ 
            $(".survey-stat-bar").animate({
                height: 'toggle'
            },1000);
        }, 1000);
        
        $( ".windia-students" ).dialog({
			autoOpen: false,
			modal: true,
			hide: "",
			show: "",
			width : '70%',
			height : 550,
			buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
                }]
        });
        
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
            $.post( SITE_PATH + "survey/getSurveyUsers",{
                'data_id':data_id,
                'data_type':data_type,
                'hidd_campus':hidd_campus,
                'hidd_survey':hidd_survey,
                'hidd_agent':hidd_agent,
                'hidd_fd':hidd_fd,
                'data_sect':data_sect,
                'hidd_td':hidd_td
            }, function( data ) {
                $("#surveyUsersList").html(data);
                $("#lblQuestion").html("Question: " + strQuestion);
                $("#lblSurveyRptTitle").html('Group leader(s) who said: ' + data_type);
                // ! Table
                // Initialize DataTables for dynamic tables
                $('table.stdGLUser').table();
            }); 
            $("#dialog_modal_survey_userlist").dialog("open");
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
            $.post( SITE_PATH + "survey/getSurveyUsersComment",{
                'data_id':data_id,
                'data_type':data_type,
                'hidd_campus':hidd_campus,
                'hidd_survey':hidd_survey,
                'hidd_agent':hidd_agent,
                'hidd_fd':hidd_fd,
                'data_sect':data_sect,
                'hidd_td':hidd_td
            }, function( data ) {
                $("#surveyUsersList").html(data);
                $("#lblQuestion").html("Comments");
                $("#lblSurveyRptTitle").html('Group leader(s) who commented');
                // ! Table
                // Initialize DataTables for dynamic tables
                $('table.stdGLUser').table();
            }); 
            $("#dialog_modal_survey_userlist").dialog("open");
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
            $.post( SITE_PATH + "survey/getSurveyUsersAns",{
                'data_id':data_id,
                'data_type':data_type,
                'hidd_campus':hidd_campus,
                'hidd_survey':hidd_survey,
                'hidd_agent':hidd_agent,
                'hidd_fd':hidd_fd,
                'data_sect':data_sect,
                'hidd_td':hidd_td
            }, function( data ) {
                $("#surveyUsersList").html(data);
                $("#lblQuestion").html("Question: " + strQuestion);
                $("#lblSurveyRptTitle").html('Group leader(s) who answered');
                // ! Table
                // Initialize DataTables for dynamic tables
                $('table.stdGLUser').table();
            }); 
            $("#dialog_modal_survey_userlist").dialog("open");
        });
    });
	
</script>	
<?php $this -> load -> view('plused_footer'); ?>
