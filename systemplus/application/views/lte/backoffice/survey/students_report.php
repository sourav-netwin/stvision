<div class="row">  
    <div class="col-md-12 mr-top-10">
        <div class="box">
            <form id="frmSurveyReport" onsubmit="return validate();" action="<?php echo base_url(); ?>index.php/survey/questionsstudentreport" method="post">
                <div class="box-header with-border">
                    <h2 class="box-title">Survey report</h2>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-data col-sm-6 col-md-4" >
                            <label for="selCampus">
                                <strong>Campus</strong>
                            </label>
                            <select class="askForAgent form-control" id="selCampus" name="selCampus"  >
                                <option value="">Select campus</option>
                                <?php
                                if ($centri) {
                                    foreach ($centri as $campus) {
                                        ?><option value="<?php echo $campus['id']; ?>"><?php echo $campus['nome_centri']; ?></option><?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-data col-sm-6 col-md-4" >
                            <label for="selSurvey">
                                <strong>Survey</strong>
                            </label>
                            <select class="askForAgent form-control" id="selSurvey" name="selSurvey"  >
                                <option value="">Select survey</option>
                                <?php
                                if (!empty($surveys)) {
                                    foreach ($surveys as $survey) {
                                        ?>
                                        <option value="<?php echo $survey['test_id'] ?>"><?php echo $survey['test_type'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-data col-sm-6 col-md-2" >
                            <label for="txtCalFromDate">
                                <strong>From date</strong>
                            </label>
                            <input type="text" class="askForAgent  form-control" id="txtCalFromDate" name="fd" value="<?php echo date("d/m/Y", strtotime($calFromDate)); ?>" />
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <label for="txtCalToDate">
                                <strong>To date</strong>
                            </label>
                            <input type="text" class="askForAgent  form-control" id="txtCalToDate" name="td" value="<?php echo date("d/m/Y", strtotime($calToDate)); ?>" />
                        </div>
                        <div class="clear"></div>
                        <div class="form-data col-sm-6 col-md-4" >
                            <label for="selAgent">
                                <strong>Agent</strong>
                            </label>
                            <select id="selAgent" class="form-control askForGL" name="selAgent"  >
                                <option value="">Select agent</option>
                            </select>
                        </div>
                        <div class="form-data col-sm-6 col-md-4" >
                            <label for="selGL">
                                <strong>Group Leader</strong>
                            </label>
                            <select id="selGL" class="form-control" name="selGL"  >
                                <option value="">Select group leader</option>
                            </select>
                        </div>
                        <div class=" col-sm-6 col-md-1" >
                            <div class="mr-top-25">
                                <input type="hidden" id="hidd_GroupLeader" name="hidd_GroupLeader" value="" />
                                <input id="btnReport" type="submit" value="Submit" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    
</div>
<script>
	var pageHighlightMenu = 'survey/studentsreport';
	function validate(){
		var agentId = $("#selAgent").val();
		var campusId = $("#selCampus").val();
		var survey = $("#selSurvey").val();
		var dateFrom = $("#txtCalFromDate").val();
		var dateTo = $("#txtCalToDate").val();
		if(agentId != '' && campusId != '' && dateFrom != '' && dateTo != '' && survey != ''){
			return true;
		}else{
			swal("Error","Please select campus, survey, from date, to date and agent to search");
			return false;
		}
	}
	var SITE_PATH = "<?php echo base_url(); ?>index.php/";
	$(document).ready(function() {
		$( "#txtCalFromDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$("#txtCalFromDate").val(selectedDate);
				$("#txtCalFromDate").trigger('change');
				$( "#txtCalToDate" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#txtCalToDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$("#txtCalToDate").val(selectedDate);
				$("#txtCalToDate").trigger('change');
				$( "#txtCalFromDate" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
        
		$( "body" ).on( "change", ".askForAgent", function() {
			var campusId = $("#selCampus").val();
			var survey = $("#selSurvey").val();
			var fd = $("#txtCalFromDate").val();
			var td = $("#txtCalToDate").val();
			if(campusId != '' && fd != '' && td != '' && survey != ''){
				$.post( SITE_PATH + "survey/getstudentagents",{
					'campusId':campusId,
					'survey':survey,
					'fd':fd,
					'td':td
				}, function( data ) {
					$("#selAgent").html(data);
					$("#selAgent").trigger("liszt:updated");
					$("#selAgent").trigger("change");
				}); 
			}
		});
                $( "body" ).on( "change", ".askForGL", function() {
			var campusId = $("#selCampus").val();
			var survey = $("#selSurvey").val();
                        var agentId = $("#selAgent").val();
			var fd = $("#txtCalFromDate").val();
			var td = $("#txtCalToDate").val();
			if(campusId != '' && fd != '' && td != '' && survey != ''){
				$.post( SITE_PATH + "survey/getgroupleaders",{
					'campusId':campusId,
					'survey':survey,
					'agentId':agentId,
					'fd':fd,
					'td':td
				}, function( data ) {
					$("#selGL").html(data);
					$("#selGL").trigger("liszt:updated");
					$("#selGL").trigger("change");
				}); 
			}
		});
                 
                 $( "body" ).on( "change", "#selGL", function() {
                    var thisvalue = $(this).find("option:selected").text();
                    $("#hidd_GroupLeader").val(thisvalue);
                 });
                
		$("#txtCalToDate").trigger('change');
        
        
		/*$( "body" ).on( "change", "#selAgent", function() {
			var agentId = $("#selAgent").val();
			var campusId = $("#selCampus").val();
			var survey = $("#selSurvey").val();
			var fd = $("#txtCalFromDate").val();
			var td = $("#txtCalToDate").val();
			$("#surveyCompiled").html('-/-');
			if(agentId != '' && campusId != '' && fd != '' && td != '' && survey != ''){
				$.post( SITE_PATH + "survey/getstudentsurvey",{
					'agentId':agentId,
					'campusId':campusId,
					'survey':survey,
					'fd':fd,
					'td':td
				}, function( data ) {
					$("#surveyCompiled").html(data);
				}); 
			}
		});*/
        
	});
        
</script>	
