<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<style>
    /*div.{
        padding-top: 20px;
    }*/
	@media(max-width: 545px){
		.smlImg{
			width: 17px !important;
		}
		.survey-stat-bar span{
			bottom: 11px !important;
			left: -7px !important;
		}
		.reporStdtHead .col-xs-1:nth-of-type(2){
			margin-left: -10px !important;
		}
		.reporStdtHead .col-xs-1:nth-of-type(3){
			margin-left: -6px !important;
		}
		.reporStdtHead .col-xs-1:nth-of-type(4){
			margin-left: -5px !important;
		}
		.reporStdtHead .col-xs-1:nth-of-type(5){
			margin-left: -5px !important;
		}
	}
	.reporStdtHead .col-xs-1:nth-of-type(2){
		margin-left: -5px;
	}
	.reporStdtHead .col-xs-1:nth-of-type(3){
		margin-left: -6px;
	}
	.reporStdtHead .col-xs-1:nth-of-type(4){
		margin-left: -5px;
	}
	.reporStdtHead .col-xs-1:nth-of-type(5){
		margin-left: -4px;
	}
        #btnBack{
            margin-bottom: 10px;
        }
        .gl_header_pdf{
            margin-left: 15px; 
        }
</style>
<style type="text/css">
	@media only screen and (max-width: 545px) {
		.col-xs-10 {
			padding-left: 5px;
			padding-right: 5px;    
			width: 74.333%;
		}
		.col-xs-9 {
			padding-left: 5px;
			padding-right: 5px;    
			width: 66.333%;
		}
		.col-xs-1{
			padding-right: 0px !important;
			padding-left: 0px !important;
			vertical-align: middle;
		}
		.up img{
			float:right;
		}
	}
	@media only screen and (max-width: 991px) {
		.col-xs-9 {
			padding-left: 5px;
			padding-right: 5px;    
			width: 66.333%;
		}
	}
</style>
<!-- Here goes the content. -->
<div class="pull-right">
	<input class="btn btn-primary" type="button" id="btnBack" name="btnBack" value=" << Back" onclick="window.location.href='<?php echo base_url(); ?>index.php/survey/studentsreport'" />
</div>
<div class="row">  
	<div class="col-md-12" style="min-height:250px;">

		<div class="box" style="clear: both">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $breadcrumb2; ?></h3>
                                <?php if(!empty($selGroupLeader) && $selGroupLeader != "all"){
                                    ?>
                                        <div class="pull-right">
                                            <button class="btn btn-primary" id="btnStudentsDetail" name="btnStudentsDetail" type="button">
                                                <i class="fa fa-file-pdf-o"></i> Students detail
                                            </button>
                                        </div>
                                        <?php 
                                    }
                                ?>
			</div>
			<div class="box-body">
				<div class="col-md-12">

					<?php
					$currentQueSection = "";
					$smCount = 1;
					if ($orderedArray && $percentages) {
						foreach ($orderedArray as $title => $questions) {
							?>
							<div class="head">
								<div class="row reporStdtHead">
									<div class="col-xs-8 res-main-head"><span><?php echo $title; ?></span></div>
									<?php
									if ($smCount == 1) {
										?>
										<div class="col-xs-1"><img class="smlImg" width="25" src="<?php echo base_url(); ?>img/icons/packs/fugue/32x32/smiley-sad.png"/></div>
										<div class="col-xs-1"><img class="smlImg" width="25" src="<?php echo base_url(); ?>img/icons/packs/fugue/32x32/smiley-neutral.png"/></div>
										<div class="col-xs-1"><img class="smlImg" width="25" src="<?php echo base_url(); ?>img/icons/packs/fugue/32x32/smiley-n.png"/></div>
										<div class="col-xs-1"><img class="smlImg" width="25" src="<?php echo base_url(); ?>img/icons/packs/fugue/32x32/smiley-yell.png"/></div>
										<?php
										$smCount++;
									}
									?>
								</div>
							</div>

							<?php
							$questionNo = 1;

							foreach ($questions as $no => $question) {
								?>
								<div class="col-md-12">
									<div class="head" >
										<div class="col-xs-1 ques-number "><?php echo $questionNo; ?>.</div>

										<div class="col-xs-7   ques-option"><span id="ques_<?php echo $no; ?>"><?php echo $question; ?></span></div>

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
											<div class="col-xs-1">
												<div class="progress vertical">
													<div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="<?php echo $poorPer; ?>" aria-valuemin="0" aria-valuemax="100" style="height: <?php echo $poorPer . '%'; ?>">

													</div>
													<a class="lnkSurveyUsers" data-type="<?php echo $percentages[$no]['opt_text'] == 2 ? 'Unsatisfactory' : 'Poor'; ?>" data-section="<?php echo $percentages[$no]['opt_text'] ?>" data-id="<?php echo $no; ?>" href="javascript:void(0);"><span><?php echo ($poorNo == 0 ? '' : $poorPer . '%'); ?></span></a>
												</div>
											</div>
											<?php
										}
										if ($percentages[$no]['opt_text'] == 4) {
											?>

											<div class="col-xs-1">
												<div class="progress vertical">
													<div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="<?php echo $satisfactoryPer; ?>" aria-valuemin="0" aria-valuemax="100" style="height: <?php echo $satisfactoryPer . '%'; ?>">

													</div>
													<a class="lnkSurveyUsers" data-type="Satisfactory" data-section="<?php echo $percentages[$no]['opt_text'] ?>" data-id="<?php echo $no; ?>" href="javascript:void(0);"><span><?php echo ($satisfactoryNo == 0 ? '' : $satisfactoryPer . '%'); ?></span></a>
												</div>
											</div>

											<div class="col-xs-1">
												<div class="progress vertical">
													<div class="progress-bar progress-bar-aqua" role="progressbar" aria-valuenow="<?php echo $goodPer; ?>" aria-valuemin="0" aria-valuemax="100" style="height: <?php echo $goodPer . '%'; ?>">

													</div>
													<a class="lnkSurveyUsers" data-type="Good" data-section="<?php echo $percentages[$no]['opt_text'] ?>" data-id="<?php echo $no; ?>" href="javascript:void(0);"><span><?php echo ($goodNo == 0 ? '' : $goodPer . '%'); ?></span></a>
												</div>
											</div>
											<?php
										}

										if (($percentages[$no]['opt_text'] == 4) || ($percentages[$no]['opt_text'] == 2)) {
											?>

											<div class="col-xs-1 <?php echo $percentages[$no]['opt_text'] == 2 ? 'pull-right' : '' ?>">
												<div class="progress vertical">
													<div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="<?php echo $satisfactoryPer; ?>" aria-valuemin="0" aria-valuemax="100" style="height: <?php echo $percentages[$no]['opt_text'] == 2 ? $satisfactoryPer : $excellentPer; ?>%">

													</div>
													<a class="lnkSurveyUsers" data-type="<?php echo $percentages[$no]['opt_text'] == 2 ? 'Satisfactory' : 'Excellent'; ?>" data-section="<?php echo $percentages[$no]['opt_text'] ?>" data-id="<?php echo $no; ?>" href="javascript:void(0);"><span><?php echo $percentages[$no]['opt_text'] == 2 ? ( $satisfactoryNo == 0 ? '' : $satisfactoryPer . '%' ) : ($excellentNo == 0 ? '' : $excellentPer . '%'); ?></span></a>
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
			</div>
			<input type="hidden" id="hidd_campus" value="<?php echo $campusId; ?>" />
			<input type="hidden" id="hidd_survey" value="<?php echo $surveyType; ?>" />
			<input type="hidden" id="hidd_agent" value="<?php echo $agentId; ?>" />
			<input type="hidden" id="hidd_fd" value="<?php echo $fd; ?>" />
			<input type="hidden" id="hidd_td" value="<?php echo $td; ?>" />
			<input type="hidden" id="hidd_selGroupLeader" value="<?php echo $selGroupLeader; ?>" />
			<input type="hidden" id="selGroupLeaderName" value="<?php echo $selGroupLeaderName; ?>" />
		</div>
	</div>
</div>
</div>

</div>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    var pageHighlightMenu = "survey/studentsreport";
    var SITE_PATH = "<?php echo base_url(); ?>index.php/";
    $(document).ready(function() {
        $(".progress-bar").hide();
        setTimeout(function(){ 
            $(".progress-bar").animate({
                height: 'toggle'
            },1000);
        }, 1000);
        
        
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
				var html = '<div id="surveyUsersListDiv" class="box">\n\
        <div class="box-header">\n\
            <h2 class="box-title"><span id="lblSurveyRptTitle"><strong>Student(s) who said: '+data_type+'</strong></span></h2>\n\
        </div>\n\
        <div class="content">\n\
            <div><p><span id="lblQuestion"><strong>'+strQuestion+'</strong></span></p></div>\n\
            <div id="surveyUsersList">'+data+'</div>\n\
        </div>\n\
    </div>';
				createModal('glDetailsTable', 'Survey user list', html, 'large');
				initDataTable('stdSTDUserDataTable');
            }); 
        });
        
        
         $( "body" ).on( "click", "#btnStudentsDetail", function() {
            var hidd_campus = $("#hidd_campus").val();
            var hidd_survey = $("#hidd_survey").val();
            var hidd_agent = $("#hidd_agent").val();
            var hidd_fd = $("#hidd_fd").val();
            var hidd_td = $("#hidd_td").val();
            var hidd_selGroupLeader = $("#hidd_selGroupLeader").val();
            var selGroupLeaderName = $("#selGroupLeaderName").val();
            // load students details for the survey
            $.post( SITE_PATH + "survey/getGLStudentsDetail",{
                'hidd_campus':hidd_campus,
                'hidd_survey':hidd_survey,
                'hidd_agent':hidd_agent,
                'hidd_fd':hidd_fd,
                'hidd_td':hidd_td,
                'hidd_selGroupLeader':hidd_selGroupLeader,
                'selGroupLeaderName':selGroupLeaderName
            }, function( data ) {
                var html = '<div id="surveyStudentDetail" >\n\
                        <div class="gl_header_pdf"><strong>Group Leader: '+selGroupLeaderName+'</strong></div>\n\
                    <div class="content">\n\
                        <div id="surveyStudentDetailList">'+data+'</div>\n\
                    </div>\n\
                </div>';
                createModal('paxDetailsTable', 'Survey students detail list', html, 'large');
                initDataTable('surveyStudentDetailTable');
            }); 
        });
        $( "body" ).on( "click", ".showSurveyDetails", function() {
            var date = $(this).attr("data-date");
            var id = $(this).attr("data-id");
            $.get( SITE_PATH + "student_survey/ajax_view_survey/"+date+"/"+id, function(html) {
                createModal('modalSurveyDetail', 'Survey students detail', html, 'modal-lg');
            });
            
        });
    });
</script>	
