<?php $this->load->view('plused_header'); ?>
<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix reportsFilters">

    <!-- The blue toolbar stripe -->
    <section class="toolbar">
        <div class="user">
            <div class="avatar">
                <img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
                <!-- Evidenziare per icone attenzione <span>3</span> -->
            </div>
            <span><?php echo $this->session->userdata('businessname') ?></span>
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
                <li class="line"></li>
                <li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
            </ul>
        </div>
    </section><!-- End of .toolbar-->	

    <?php
    $this->load->view('plused_sidebar');
    ?>		
    <!-- Here goes the content. -->
    <section id="content" class="container_12 clearfix survey-report-content" data-sort=true>
        <h1 class="grid_12 margin-top no-margin-top-phone">Group Leader Survey</h1>
         <div class="row">  
                <div class="grid_12 mr-top-10" style="min-height:250px;">
                    <div class="box">
                        <form id="frmSurveyReport" onsubmit="return validate();" action="<?php echo base_url(); ?>index.php/survey/questionsreport" method="post">
                        <div class="header">
                            <h2>Survey report</h2>
                        </div>
                        <div class="content" style="margin: 10px;">
                            <div class="form-data grid_4" >
                                <div class="left-class">
                                    <label for="selCampus" style="width: 115px;">
                                        <strong>Campus</strong>
                                    </label>
                                </div>
                                <div class="left-class" style="width:100%;">
                                    <select class="askForAgent" id="selCampus" name="selCampus"  >
                                        <option value="">Select campus</option>
                                        <?php 
                                        if($centri){
                                            foreach ($centri as $campus){
                                                ?><option value="<?php echo $campus['id'];?>"><?php echo $campus['nome_centri'];?></option><?php 
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-data grid_4" >
                                <div class="left-class">
                                    <label for="selSurvey" style="width: 115px;">
                                        <strong>Survey</strong>
                                    </label>
                                </div>
                                <div class="left-class" style="width:100%;">
                                    <select class="askForAgent" id="selSurvey" name="selSurvey"  >
                                        <option value="">Select survey</option>
                                        <option value="Report 1">Survey 1</option>
                                        <option value="Report 2">Survey 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-data grid_4" >
                                <div class="left-class">
                                    <label for="fromDate" style="width: 115px;">
                                        <strong>From date - To date</strong>
                                    </label>
                                </div>
                                <div class="left-class" style="width:100%;">
                                    <input type="text" class="askForAgent" style="width:100px;" id="txtCalFromDate" name="fd" value="<?php echo date("d/m/Y",strtotime($calFromDate));?>" />
                                    <span style="margin-left:3%;">To</span>
                                    <input type="text" class="askForAgent" style="width:100px; float: right;" id="txtCalToDate" name="td" value="<?php echo date("d/m/Y",strtotime($calToDate));?>" />
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="form-data grid_4" >
                                <div class="left-class">
                                    <label for="selAgent" style="width: 115px;">
                                        <strong>Agent</strong>
                                    </label>
                                </div>
                                <div class="left-class" style="width:100%;">
                                    <select id="selAgent" name="selAgent"  >
                                        <option value="">Select agent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-data grid_4" >
                                <div style="float:right;padding-top: 15px;">
                                    <label >
                                        <strong>Survey compiled: <span id="surveyCompiled">-/-</span></strong>
                                    </label>
                                    <input id="btnReport" type="submit" value="Submit" style="margin-left: 10px">
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
        </div>
    </section>
    
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
            alert("Please select campus, survey, from date, to date and agent to search");
            return false;
        }
    }
    var SITE_PATH = "<?php echo base_url();?>index.php/";
    $(document).ready(function() {
        $('form').removeClass('no-box');
        $( "li#mnusurvey" ).addClass("current");
        $( "li#mnusurvey a" ).addClass("open");		
        $( "li#mnusurvey ul.sub" ).css('display','block');	
        $( "li#mnusurvey ul.sub li#mnusurvey_1" ).addClass("current");	
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
                $.post( SITE_PATH + "survey/getagents",{
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
                $.post( SITE_PATH + "survey/getagentssurvey",{
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
<?php $this->load->view('plused_footer'); ?>
