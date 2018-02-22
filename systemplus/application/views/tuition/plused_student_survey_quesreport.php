<?php $this -> load -> view('plused_header'); ?>
<style>
    div.text-middle{
        padding-top: 20px;
    }
	@media(max-width: 500px){
		.smlImg{
			width: 20px !important;
		}
		.survey-stat-bar span{
			bottom: 11px !important;
			left: -7px !important;
		}
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
				<div style="float:right;">
					<input class="btn btn-tuition" type="button" id="btnBack" name="btnBack" value=" << Back" onclick="window.location.href='<?php echo base_url(); ?>index.php/survey/studentsreport'" />
				</div>
                <div class="box" style="clear: both">
                    <div class="header">
                        <h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png"><?php echo $breadcrumb2; ?></h2>
                    </div>
                    <div class="content" style="margin: 10px;">

                        <div id="surveyDiv">
							<?php
							$currentQueSection = "";
							$smCount = 1;
							if ($orderedArray && $percentages) {
								foreach ($orderedArray as $title => $questions) {
									?>
									<div class="grid_12">
										<div class="head">
											<div class="grid_8"><span style="font-size:18px;font-weight: bold;"><?php echo $title; ?></span></div>
											<?php
											if ($smCount == 1) {
												?>
												<div class="grid_1"><img class="smlImg" width="25" src="<?php echo base_url(); ?>img/icons/packs/fugue/32x32/smiley-sad.png"/></div>
												<div class="grid_1"><img class="smlImg" width="25" src="<?php echo base_url(); ?>img/icons/packs/fugue/32x32/smiley-neutral.png"/></div>
												<div class="grid_1"><img class="smlImg" width="25" src="<?php echo base_url(); ?>img/icons/packs/fugue/32x32/smiley-n.png"/></div>
												<div class="grid_1"><img class="smlImg" width="25" src="<?php echo base_url(); ?>img/icons/packs/fugue/32x32/smiley-yell.png"/></div>
												<?php
												$smCount++;
											}
											?>
										</div>
									</div>

									<?php
									//die;
									/* if($currentQueSection == "" || $currentQueSection != $survey1['que_section'])
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
									  } */
									$questionNo = 1;

									foreach ($questions as $no => $question) {
										?>
										<div class="grid_12 border-bot-5-pad">
											<div class="head" >
												<div class="grid_1 ques-number text-middle"><?php echo $questionNo; ?>.</div>

												<div class="grid_7  text-middle ques-option"><span id="ques_<?php echo $no; ?>"><?php echo $question; ?></span></div>

												<?php
												$poorPer = 0;
												$satisfactoryPer = 0;
												$goodPer = 0;
												$excellentPer = 0;
												$poorNo = 0;
												$satisfactoryNo = 0;
												$goodNo = 0;
												$excellentNo = 0;
												if (isset($percentages[$no])) {
													if ($percentages[$no]['poor'] > 0) {
														$poorPer = round(($percentages[$no]['poor'] / $percentages[$no]['total']) * 100, 1);
													}
													if ($percentages[$no]['satisfactory'] > 0) {
														$satisfactoryPer = round(($percentages[$no]['satisfactory'] / $percentages[$no]['total']) * 100, 1);
													}
													if ($percentages[$no]['good'] > 0) {
														$goodPer = round(($percentages[$no]['good'] / $percentages[$no]['total']) * 100, 1);
													}
													if ($percentages[$no]['excellent'] > 0) {
														$excellentPer = round(($percentages[$no]['excellent'] / $percentages[$no]['total']) * 100, 1);
													}
													$poorNo = $percentages[$no]['poor'];
													$satisfactoryNo = $percentages[$no]['satisfactory'];
													$goodNo = $percentages[$no]['good'];
													$excellentNo = $percentages[$no]['excellent'];
												}
												if (($percentages[$no]['opt_text'] == 4) || ($percentages[$no]['opt_text'] == 2)) {
													?>
													<div class="grid_1">
														<div class="survey-stat-bar-container">
															<div class="survey-stat-bar poor" style="height:<?php echo $poorPer; ?>%;">
																<a class="lnkSurveyUsers" data-type="Poor" data-typeId="<?php echo $percentages[$no]['opt_text']; ?>" data-id="<?php echo $no; ?>" href="javascript:void(0);"><span><?php echo ($poorNo == 0 ? '' : $poorPer . '%'); ?></span></a>
															</div>
														</div>
													</div>
													<?php
												}
												if ($percentages[$no]['opt_text'] == 4) {
													?>

													<div class="grid_1">
														<div class="survey-stat-bar-container">
															<div class="survey-stat-bar satisfactory" style="height:<?php echo $satisfactoryPer; ?>%;">
																<a class="lnkSurveyUsers" data-type="Satisfactory" data-typeId="<?php echo $percentages[$no]['opt_text']; ?>" data-id="<?php echo $no; ?>" href="javascript:void(0);"><span><?php echo ($satisfactoryNo == 0 ? '' : $satisfactoryPer . '%'); ?></span></a>
															</div>
														</div>
													</div>

													<div class="grid_1">
														<div class="survey-stat-bar-container">
															<div class="survey-stat-bar good" style="height:<?php echo $goodPer; ?>%;">
																<a class="lnkSurveyUsers" data-type="Good" data-typeId="<?php echo $percentages[$no]['opt_text']; ?>" data-id="<?php echo $no; ?>" href="javascript:void(0);"><span><?php echo ($goodNo == 0 ? '' : $goodPer . '%'); ?></span></a>
															</div>
														</div>
													</div>
													<?php
												}

												if (($percentages[$no]['opt_text'] == 4) || ($percentages[$no]['opt_text'] == 2)) {
													?>

													<div class="grid_1" <?php echo $percentages[$no]['opt_text'] == 2 ? 'style="float:right;"' : '' ?>>
														<div class="survey-stat-bar-container">
															<div class="survey-stat-bar excellent" style="height:<?php echo $percentages[$no]['opt_text'] == 2 ? $satisfactoryPer : $excellentPer; ?>%;">
																<a class="lnkSurveyUsers" data-type="Excellent" data-typeId="<?php echo $percentages[$no]['opt_text']; ?>" data-id="<?php echo $no; ?>" href="javascript:void(0);"><span><?php echo $percentages[$no]['opt_text'] == 2 ? ( $satisfactoryNo == 0 ? '' : $satisfactoryPer . '%' ) : ($excellentNo == 0 ? '' : $excellentPer . '%') ?></span></a>
															</div>
														</div>
													</div>
													<?php
												}
												?>

											</div>
										</div>

										<?php
										$questionNo++;
									}
									?>

									<?php
								}
							}
							else {
								echo 'No record(s) found';
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
<div style="display: none;" id="dialog_modal_survey_userlist" title="Survey user list" class="windia-students">
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
        $( "li#mnusurvey ul.sub li#mnusurvey_2" ).addClass("current");	
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
                }],
			close: function(){
				$('#lblSurveyRptTitle').html('Survey user list');
				$('#lblQuestion').html('');
				$('#surveyUsersList').html('');
			}
        });
        
        $( "body" ).on( "click", ".lnkSurveyUsers", function() {
            var data_id = $(this).attr('data-id');
            var data_type = $(this).attr('data-type');
            var data_typeId = $(this).attr('data-typeId');
			
			if(data_type == 'Poor' && data_typeId == '2'){
				data_type = 'Unsatisfactory';
			}
			if(data_type == 'Excellent' && data_typeId == '2'){
				data_type = 'Satisfactory';
			}
            
            var hidd_campus = $("#hidd_campus").val();
            var hidd_survey = $("#hidd_survey").val();
            var hidd_agent = $("#hidd_agent").val();
            var hidd_fd = $("#hidd_fd").val();
            var hidd_td = $("#hidd_td").val();
            
            var loadingDiv = "<div class='showloading'></div>";
            var strQuestion = $("#ques_"+data_id).html();
            $("#surveyUsersList").html(loadingDiv);
            // load students for the campus
            $.post( SITE_PATH + "survey/getStudentSurveyUsers",{
                'data_id':data_id,
                'data_type':data_type,
                'data_typeId':data_typeId,
                'hidd_campus':hidd_campus,
                'hidd_survey':hidd_survey,
                'hidd_agent':hidd_agent,
                'hidd_fd':hidd_fd,
                'hidd_td':hidd_td
            }, function( data ) {
                $("#surveyUsersList").html(data);
				//                $("#lblQuestion").html("Question: " + strQuestion);
                $("#lblQuestion").html(strQuestion);
                $("#lblSurveyRptTitle").html('Student(s) who said: ' + data_type);
                // ! Table
                // Initialize DataTables for dynamic tables
                $('table.stdGLUser').table();
            }); 
            $("#dialog_modal_survey_userlist").dialog("open");
        });
    });
</script>	
<?php $this -> load -> view('plused_footer'); ?>
