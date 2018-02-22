<!-- Here goes the content. -->
<div class="row">  
	<div class="col-md-12 mr-top-10" style="min-height:250px;">
		<div class="box">
			<form id="frmSurveyReport" onsubmit="return validate();" action="<?php echo base_url(); ?>index.php/survey/questionsreport" method="post">
				<div class="box-header with-border">
					<h3 class="box-title">Survey report</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="form-data col-sm-6 col-md-4" >
							<label for="selCampus" >
								Campus
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
								Survey
							</label>
							<select class="askForAgent form-control" id="selSurvey" name="selSurvey"  >
								<option value="">Select survey</option>
								<option value="Report 1">Survey 1</option>
								<option value="Report 2">Survey 2</option>
							</select>
						</div>
						<div class="form-data col-sm-6 col-md-2" >
							<label for="fromDate">
								From date
							</label>
							<input type="text" class="askForAgent form-control" id="txtCalFromDate" name="fd" value="<?php echo date("d/m/Y", strtotime($calFromDate)); ?>" />
						</div>
						<div class="form-data col-sm-6 col-md-2" >
							<label for="txtCalToDate">
								To date
							</label>
							<input type="text" class="askForAgent form-control" id="txtCalToDate" name="td" value="<?php echo date("d/m/Y", strtotime($calToDate)); ?>" />
						</div>
						<div class="form-data col-sm-6 col-md-4" >
							<label for="selAgent">
								<strong>Agent</strong>
							</label>
							<select class="form-control" id="selAgent" name="selAgent"  >
								<option value="">Select agent</option>
							</select>
						</div>
						<div class="form-data col-sm-6  col-md-4 mr-top-30" >
							<label >
								<strong>Survey compiled: <span id="surveyCompiled">-/-</span></strong>
							</label>
						</div>
						<div class=" col-sm-4 col-md-2 mr-top-25">
							<input id="btnReport" type="submit" value="Submit" class="btn btn-primary">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
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
                $.post( siteUrl + "survey/getagents",{
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
        $("#txtCalToDate").trigger('change');
        
        
        $( "body" ).on( "change", "#selAgent", function() {
            var agentId = $("#selAgent").val();
            var campusId = $("#selCampus").val();
            var survey = $("#selSurvey").val();
            var fd = $("#txtCalFromDate").val();
            var td = $("#txtCalToDate").val();
            $("#surveyCompiled").html('-/-');
            if(agentId != '' && campusId != '' && fd != '' && td != '' && survey != ''){
                $.post( siteUrl + "survey/getagentssurvey",{
                    'agentId':agentId,
                    'campusId':campusId,
                    'survey':survey,
                    'fd':fd,
                    'td':td
                }, function( data ) {
                    $("#surveyCompiled").html(data);
                }); 
            }
        });
        
    });
</script>	
