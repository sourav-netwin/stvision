<?php $this->load->view('plused_header');?>
<style>
#loading {
    z-index: 99999;
}
#loading-overlay {
    z-index: 99999;
}
</style>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
    <!-- The container of the sidebar and content box -->
    <div role="main" id="main" class="container_12 clearfix">
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
        </section>
        <!-- End of .toolbar-->
<?php $this->load->view('plused_sidebar');?>		
	<script>
            function loading(action,text){
                
                if(action == 'show')
                {
                    $("#loading-overlay").show();
                    $("#loading").show();
                    if(text != '')
                        $("#loading span").html(text);
                }
                else
                {
                    $("#loading-overlay").hide();
                    $("#loading").hide();
                    $("#loading span").html('Loading...');
                }
                    
            }
	$(document).ready(function() {
           
           $("a.read0").parent().parent().find('td').css('background','#ffe5e5');
           $( "body" ).on( "click", ".paginate_button", function() {
               $("a.read0").parent().parent().find('td').css('background','#ffe5e5');
           });
           $( "body" ).on( "click", "tr th", function() {
               $("a.read0").parent().parent().find('td').css('background','#ffe5e5');
           });
           
           
            var SITE_PATH = "<?php echo base_url();?>index.php/";
                $( "li#mnujobcontract" ).addClass("current");
		$( "li#mnujobcontract a" ).addClass("open");		
		$( "li#mnujobcontract ul.sub" ).css('display','block');	
                
                <?php $pageType = $this->uri->segment(2);
                    if($pageType == 'profilereview'){
                ?>
                    $( "li#mnujobcontract ul.sub li#mnujobcontract_2" ).addClass("current");	
                <?php }else{
                        $pageType = 'cvreview';
                    ?>
                    $( "li#mnujobcontract ul.sub li#mnujobcontract_1" ).addClass("current");	
                <?php }?>
                $(".toggleFilter").hide();
                
                $("#btnClear").click(function(){
                    //window.location.href = "<?php //echo base_url().'index.php/teachers/review';?>";
                    setTimeout(function(){$("#btnSearchApplication").trigger('click');},'500');
                });


                $( ".windia-interview" ).dialog({
                    autoOpen: false,
                    modal: true,
                    hide: "",
                    show: "",
                    width : '50%',
                    height : 710,
                    buttons: [{
                            text: "Close",
                            click: function() { $(this).dialog("close"); }
                    }]
                });
                
                $( "body" ).on( "click", ".dialog-interview", function() {
                    $("#interview-form-message").removeClass('tuition_error');
                    $("#interview-form-message").removeClass('tuition_success');
                    $("#interview-form-message").html(' ');
                    
                    var id = $(this).attr('data-id');
                    $("#selInterviewLevel_chzn").width('100px');
                    $("#hiddInterviewTeacher").val(id);
                    $("#dialog_modal_interview").dialog("open");
                    $.post( "<?php echo base_url();?>index.php/teachers/getinterviewdetail",{
                            'teach_app_id':id
                        }, function( data ) {
                            if(parseInt(data.result))
                            {
                                var teacher = data.resultSet;
                                $('#txtSkypename').val(teacher.skype);
                                $('#txtInterviewNotes').val(teacher.interview_notes);
                                $('#txtStrong').val(teacher.interview_strong);
                                $('#txtWeek').val(teacher.interview_weak);
                                $('#selInterviewLevel').val(teacher.interview_level);
                                $("#selInterviewLevel").trigger("liszt:updated");
                                if(parseInt(teacher.check_ref))
                                    $('#chkCheckReferences').prop('checked',true);
                                else
                                    $('#chkCheckReferences').prop('checked',false);
                                if(parseInt(teacher.check_returnee))
                                    $('#chkReturnee').prop('checked',true);
                                else
                                    $('#chkReturnee').prop('checked',false);
                            }
                            else
                            {
                                //
                            }
                    },'json');
                });
                
                $( "body" ).on( "click", "#btnUpdateInterview", function() {
                    $("#interview-form-message").removeClass('tuition_error');
                    $("#interview-form-message").removeClass('tuition_success');
                    $("#interview-form-message").html(' ');
                    
                    var teach_app_id = $("#hiddInterviewTeacher").val();
                    var txtSkypename = $('#txtSkypename').val();
                    var txtInterviewNotes = $('#txtInterviewNotes').val();
                    var txtStrong = $('#txtStrong').val();
                    var txtWeek = $('#txtWeek').val();
                    var selInterviewLevel = $('#selInterviewLevel').val();
                    var chkCheckReferences = 0; 
                    var chkReturnee = 0; 
                    if ($('#chkCheckReferences').is(":checked"))
                        chkCheckReferences = 1;
                    if ($('#chkReturnee').is(":checked"))
                        chkReturnee = 1;
                    
                    if(txtSkypename == '' && txtInterviewNotes == '' && txtStrong == '' && txtWeek == '' && selInterviewLevel == '')
                    {
                        $("#interview-form-message").addClass('tuition_error');
                        $("#interview-form-message").html('Please enter atleast one input field.');
                    }
                    else
                    {
                        $.post( "<?php echo base_url();?>index.php/teachers/updateinterviewdetail",{
                                'teach_app_id':teach_app_id,
                                'txtSkypename':txtSkypename,
                                'txtInterviewNotes':txtInterviewNotes,
                                'txtStrong':txtStrong,
                                'txtWeek':txtWeek,
                                'selInterviewLevel':selInterviewLevel,
                                'chkCheckReferences':chkCheckReferences,
                                'chkReturnee':chkReturnee
                            }, function( data ) {
                                $("#interview-form-message").html(data.message);
                                if(parseInt(data.result))
                                {
                                    $("#interview-form-message").addClass('tuition_success');
                                }
                                else
                                {
                                    $("#interview-form-message").addClass('tuition_error');
                                }
                        },'json');
                    }
                });
                
                $( "body" ).on( "click", "#btnSearchApplication", function() {
                    var nationality = $('#selNationality').val();
                    var sex = $('#selSex').val();
                    var dbfrom = $('#selAgeRangeFrom').val();
                    var dbto = $('#selAgeRangeTo').val();
                    var diplomas = $('#selDiplomas').val();
                    var txtCalFromDate = $('#txtCalFromDate').val();
                    var txtCalToDate = $('#txtCalToDate').val();
                    var txtName = $('#txtName').val();
                    var selPostcode = $('#selPostCode').val();
                    var selTeachYears = $('#selTeachYears').val();
                    
                    var selRegVerified = $('#selRegVerified').val();
                    var selIntLevel = $('#selIntLevel').val();
                    
                    $.post( "<?php echo base_url();?>index.php/teachers/review_ajax",{
                                'nationality':nationality,
                                'sex':sex,
                                'txtName':txtName,
                                'dbfrom':dbfrom,
                                'dbto':dbto,
                                'diplomas':diplomas,
                                'txtCalFromDate':txtCalFromDate,
                                'txtCalToDate':txtCalToDate,
                                'selPostcode':selPostcode,
                                'selTeachYears':selTeachYears,
                                'selRegVerified':selRegVerified,
                                'selIntLevel':selIntLevel,
                                'pageType':'<?php echo $pageType;?>'
                            }, function( data ) {
                        var oTable = $('table.dynamic').dataTable();
                        //var ott = TableTools.fnGetInstance('tableSearchResults');
                        //if ( typeof ott != 'undefinded' && ott != null) ott.fnSelectNone();
                        oTable.fnClearTable();
                        //oTable.fnDestroy();
                        oTable.fnAddData(data);
                        oTable.fnDraw();
                        $("#data-grid tr td").addClass('center');
                        $("#data-grid tr td:last-child").addClass('operation');
                        $("a.read0").parent().parent().find('td').css('background','#ffe5e5');
                    },'json');
                });
                
                $( "body" ).on( "click", ".dialogbtn", function() {
                    var id = $(this).attr('data-id');
                    var isread = $(this).attr('data-read');
                    var theLink = $(this);
                    $.post( "<?php echo base_url();?>index.php/teachers/applicationdetail",{
                            'id':id,
                            'isread':isread,
                            'pageType':'<?php echo $pageType;?>'
                        }, function( data ) {
                        $("#teacherDetail").html('');
                        $("#dialog_modal_appdetails").dialog("open");
                        $("#teacherDetail").html(data);
                        $('#historyTable table.dynamic').table();
                        if(isread == '0')
                        {
                            $(theLink).parent().parent().find('td').css('background','');
                            theLink.removeClass('read0');
                        }
                    });
                });
                
                
                $( ".windia-add-teacher" ).dialog({
                        autoOpen: false,
                        modal: true,
                        hide: "",
                        show: "",
                        width : '50%',
                        height : 680,
                        buttons: [{
                                text: "Close",
                                click: function() { $(this).dialog("close"); }
                        }]
                });
                
                var isBusy = false;
                $( ".windia-teacher" ).dialog({
                        autoOpen: false,
                        modal: true,
                        hide: "",
                        show: "",
                        width : '70%',
                        height : 600,
                        buttons: [{
                                text: "Close",
                                click: function() { $(this).dialog("close"); }
                        }<?php if($pageType == 'cvreview'){?>,
                        {
                            text: "Send available positions",
                            id: "btnSendAdvOffer",
                                click: function() {
                                    if(isBusy)
                                    {
                                        alert("Process to send available position is in progress");
                                    }
                                    else if(confirm("Are you sure to send available positions?")){
                                        var teach_id = $("#hiddTeacherAppId").val();
                                        isBusy = true;
                                        $.post( "<?php echo base_url();?>index.php/teachers/sendadvjoboffer",{
                                            'teach_id':teach_id
                                        }, function( data ) {
                                            if(parseInt(data.result)){
                                                alert(data.message);
                                                isBusy = false;
                                                $("#dialog_modal_appdetails").dialog("close");
                                                $("#btnSearchApplication").trigger('click');
                                            }
                                            else
                                            {
                                                alert(data.message);
                                            }
                                        },'json');
                                    }
                                }
                                /*
                                * DO NOT REMOVE THIS CODE, IT'S NEEDED IN FUTURE.
                                *text: "Confirm",
                                class: "btn-confirm",
                                click: function() {
                                    $("#form-message").removeClass('tuition_error');
                                    $("#form-message").removeClass('tuition_success');
                                    $("#form-message").html(' ');
                                    
                                    $("#dialog_modal_add_teacher").dialog("open");
                                    $("#txtFirstName").val($("#hiddFirstName").val());
                                    $("#txtLastName").val($("#hiddLastName").val());
                                    $("#txtHoursPerDay").val(0);
                                    $("#hiddEditTeacher").val(0);
                                    $("#txtFromDate").val($("#hiddAbilityFromDate").val());
                                    $("#txtToDate").val($("#hiddAbilityToDate").val());
                                }*/
                        }<?php }?>
                        ]
                });
                
                
                $( "body" ).on( "click", ".edit-add-teacher", function() {
                    var teach_id = $(this).attr('data-teach-id');
                    $("#form-message").removeClass('tuition_error');
                    $("#form-message").removeClass('tuition_success');
                    $("#form-message").html(' ');
                    $.post( "<?php echo base_url();?>index.php/teachers/getsingelrec",{
                        'teach_id':teach_id
                        }, function( data ) {
                                if(parseInt(data.result)){
                                    var teachObj = data.record[0];
                                    $("#dialog_modal_add_teacher").dialog("open");
                                    $("#txtFirstName").val(teachObj.teach_first_name);
                                    $("#txtLastName").val(teachObj.teach_last_name);
                                    $("#txtHoursPerDay").val(teachObj.teach_hours_per_day);
                                    $("#hiddEditTeacher").val(teach_id);
                                    var fromData = teachObj.teach_from_date.split(" ");
                                        fromData = fromData[0].split("-").reverse().join("/");
                                    
                                    $("#txtFromDate").val(fromData);
                                    var toData = teachObj.teach_to_date.split(" ");
                                        toData = toData[0].split("-").reverse().join("/");
                                    $("#txtToDate").val(toData);
                                    $("#selCampus").val(teachObj.teach_campus_id);
                                    $("#selCampus").trigger("liszt:updated");
                                }
                                else
                                {
                                    alert(data.record);
                                }
                    },'json');
                    
                    
                });
                
                $( "body" ).on( "click", "#btnCancel", function() {
                    $("#hiddEditTeacher").val(0);
                });
                
                $( "body" ).on( "click", "#btnSave", function() {
                    $("#form-message").removeClass('tuition_error');
                    $("#form-message").removeClass('tuition_success');
                    $("#form-message").html('');
                    var tea_id = $("#hiddTeacherAppId").val();
                    var campusId = $("#selCampus").val();
                    var firstname = $("#txtFirstName").val();
                    var lastname = $("#txtLastName").val();
                    var hoursperday = $("#txtHoursPerDay").val();
                    var fromdate = $("#txtFromDate").val();
                    var todate = $("#txtToDate").val();
                    var editTeacher = $("#hiddEditTeacher").val();
                    
                    if(parseInt(campusId) > 0)
                    {
                        if(firstname != "" && 
                            lastname != "" && 
                            hoursperday != 0 && 
                            fromdate != "" && 
                            todate != "")
                        {
                            $.post( "<?php echo base_url();?>index.php/teachers/confirmapplication",{
                                    'tea_id':tea_id,
                                    'campusId':campusId,
                                    'firstname':firstname,
                                    'lastname':lastname,
                                    'hoursperday':hoursperday,
                                    'fromdate':fromdate,
                                    'todate':todate,
                                    'editTeacher':editTeacher
                                }, function( data ) {
                                    $("#form-message").html(data.message);
                                    if(parseInt(data.status)) 
                                    {
                                        $("#form-message").addClass('tuition_success');
                                        $("#btnCancel").trigger('click');
                                        $("#dialog_modal_btn_"+tea_id).trigger('click');
                                        setTimeout(function(){$("#dialog_modal_add_teacher").dialog("close");},'1500');
                                    }
                                    else
                                    {
                                        $("#form-message").addClass('tuition_error');
                                    }
                            },'json');
                        }
                        else
                        {
                            $("#form-message").addClass('tuition_error');
                            if(parseInt(hoursperday) > 0)
                                $("#form-message").html('All fields are mandatory');
                            else
                                $("#form-message").html('All fields are mandatory, hours per day should be non-zero(0)');
                        }
                    }else
                    {
                        $("#form-message").addClass('tuition_error');
                        $("#form-message").html('Please select campus for the teacher');
                    }
                    
                });
                
                $("#selAgeRangeFrom_chzn").width('35%');
                $("#selAgeRangeTo_chzn").width('35%');
                
                $( "#txtCalFromDate" ).datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        changeYear: true,		  
                        dateFormat: "dd/mm/yy",		
                        numberOfMonths: 1,
                        onClose: function( selectedDate ) {
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
                                $( "#txtCalFromDate" ).datepicker( "option", "maxDate", selectedDate );
                        }
                });
                
                
                
                $( "#txtFromDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
                                $( "#txtToDate" ).datepicker( "option", "minDate", selectedDate );
			}
                });

                $( "#txtToDate" ).datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            changeYear: true,		  
                            dateFormat: "dd/mm/yy",		
                            numberOfMonths: 1,
                            onClose: function( selectedDate ) {
                                    $( "#txtFromDate" ).datepicker( "option", "maxDate", selectedDate );
                            }
                });
                
                
                 // job offer date range
                 
                $( "#txtJobFrom" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
                                $( "#txtJobTill" ).datepicker( "option", "minDate", selectedDate );
			}
                });

                $( "#txtJobTill" ).datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            changeYear: true,		  
                            dateFormat: "dd/mm/yy",		
                            numberOfMonths: 1,
                            onClose: function( selectedDate ) {
                                    $( "#txtJobFrom" ).datepicker( "option", "maxDate", selectedDate );
                            }
                });
                
               
                $( ".sendjoboffer_dialog" ).dialog({
                        autoOpen: false,
                        modal: true,
                        hide: "",
                        show: "",
                        width : 800,
                        height : 850,
                        buttons: [{
                                text: "Close",
                                click: function() { $(this).dialog("close"); }
                        }]
                });
                
                $("body").on("click",".sendjoboffer_link",function(){
                    
                    $("#btnJobCancel").trigger('click');
                    $("#rowType").hide();
                    $("#rowWages").hide();
                    $("#rowRate").hide();
                    
                    var id = $(this).attr('data-id');
                    var teachername = $(this).attr('data-name');
                    $("#hiddJobOfferTeacher").val(id);
                    $("#lblCandidate").html(teachername);
                    
                    $.post( SITE_PATH + "teachers/getSendJobHistory",{'teacher_appid':id}, function( data ) {
                        $("#jobOfferListingData").html(data);
                    });
                    
                    $("#sendjoboffer_dialog_popup").dialog('open');
                    $("#sendjoboffer_dialog_popup").attr('style','max-height:500px;overflow-x: hidden;scroll-behavior: smooth;');
                    
                });
                
                $("body").on("click","#btnSendJobOffer",function(){
                    $("#joboffer-form-message").removeClass('tuition_error');
                    $("#joboffer-form-message").removeClass('tuition_success');
                    $("#joboffer-form-message").html('');
                    var teaId = $("#hiddJobOfferTeacher").val();
                    var position = $("#selPosition option:selected").text();
                    var positionId = $("#selPosition").val();
                    var res_non_res = $("#selResOrNon").val();
                    var currency = $("#selCurrency").val();
                    var selType = $("#selType").val();
                    var selWages = $("#selWages").val();
                    var selRate = $("#selRate").val();
                    
                    if(position != '' && currency != '') //&& res_non_res != '' 
                    {
                        var allowed = 1;
                        if(position == 'Teacher')
                        {
                            $("#rowType").show();
                            if(selType == '')
                            {
                                allowed = 0;
                            }
                            else
                            {
                                if(selType == 'Academy 1' || selType == 'Academy 2')
                                {
                                    if(selWages == '')
                                    {
                                        $("#rowWages").show();
                                        allowed = 0;
                                    }
                                }
                                if(selType == 'Non London')
                                {
                                    if(res_non_res == '')
                                        allowed = 0;
                                }
                                if(selWages != 'Weekly')
                                {
                                    $("#rowRate").show();
                                    if(selRate == "")
                                        allowed = 0;
                                }
                                
                            }
                        }
                        if(allowed)
                        {
                            loading('show','Sending...');
                            $.post( "<?php echo base_url();?>index.php/teachers/sendjobofferletter",{
                                    'teaId':teaId,
                                    'position':position,
                                    'positionId':positionId,
                                    'res_non_res':res_non_res,
                                    'currency':currency,
                                    'selType':selType,
                                    'selWages':selWages,
                                    'selRate':selRate
                                }, function( data ) {
                                    if(parseInt(data.result)) 
                                    {
                                        $("#btnJobCancel").trigger('click');
                                        $("#joboffer-form-message").addClass('tuition_success');
                                        $("#joboffer-form-message").html(data.message);
                                        loading('hide');
                                        $.post( SITE_PATH + "teachers/getSendJobHistory",{'teacher_appid':teaId}, function( history ) {
                                            $("#jobOfferListingData").html(history);
                                        });
                                    }
                                    else
                                    {
                                        $("#joboffer-form-message").addClass('tuition_error');
                                        $("#joboffer-form-message").html(data.message);
                                        loading('hide');
                                    }
                            },'json');
                        }
                        else
                        {
                            $("#joboffer-form-message").addClass('tuition_error');
                            $("#joboffer-form-message").html("All <span class='star-red'>*</span> fields are mandatory.");
                        }
                    }
                    else
                    {
                        $("#joboffer-form-message").addClass('tuition_error');
                        $("#joboffer-form-message").html("All <span class='star-red'>*</span> fields are mandatory.");
                    }
                });
                
                $( "body" ).on( "click", "#btnJobCancel", function() {
                    $("#joboffer-form-message").removeClass('tuition_error');
                    $("#joboffer-form-message").removeClass('tuition_success');
                    $("#joboffer-form-message").html('');
                });
               
               // $('#helptip').tipsy({gravity: 'se',html: true });
               // $(".btn-confirm").parent().append($("#helptip"));
               
            
            $( "body" ).on( "change", "#selPosition", function() {
                var myVal = $("#selPosition option:selected").text();
                if(myVal == 'Teacher')
                {
                    $("#rowType").show();
                }
                else
                {
                    $("#rowType").hide();
                    $("#rowWages").hide();
                    $("#rowRate").hide();
                    $("#rowResidential").hide();
                }
            });
            
            $( "body" ).on( "change", "#selType", function() {
                $("#rowResidential").hide();
                var myVal = $("#selType option:selected").text();
                if(myVal == 'Academy 1' || myVal == 'Academy 2')
                {
                    $("#rowWages").show();
                    if($("#selWages").val() == "Hourly")
                    {
                        $("#rowRate").show();
                    }
                    else
                        $("#rowRate").hide();
                }
                else if(myVal == 'Non London'){
                    $("#rowResidential").show();
                    $("#rowWages").hide();
                    $("#rowRate").show();
                }
                else
                {
                    $("#rowWages").hide();
                    $("#rowRate").show();
                }
            });
            
            $( "body" ).on( "change", "#selWages", function() {
                var myVal = $("#selWages option:selected").text();
                if(myVal == 'Hourly')
                {
                    $("#rowRate").show();
                }
                else
                    $("#rowRate").hide();
            });
            
            $( "body" ).on( "focusout", ".chzn-single", function() {
                /*
                 // WAGES CHENG EVENT
                var myVal = $("#selWages option:selected").text();
                if(myVal == 'Hourly')
                {
                    $("#rowRate").show();
                }
                else
                    $("#rowRate").hide();
                
                // TYPE CHANGE EVENT
                var myVal = $("#selType option:selected").text();
                if(myVal == 'Academy 1' || myVal == 'Academy 2')
                {
                    $("#rowWages").show();
                    if($("#selWages").val() == "Hourly")
                    {
                        $("#rowRate").show();
                    }
                    else
                        $("#rowRate").hide();
                }
                else if(myVal == 'Non London'){
                    $("#rowResidential").show();
                    $("#rowWages").hide();
                    $("#rowRate").show();
                }
                else
                {
                    $("#rowWages").hide();
                    $("#rowRate").show();
                }
                
                // POSITION CHANGE EVENT
                var myVal = $("#selPosition option:selected").text();
                if(myVal == 'Teacher')
                {
                    $("#rowType").show();
                }
                else
                {
                    $("#rowType").hide();
                    $("#rowWages").hide();
                    $("#rowRate").hide();
                    $("#rowResidential").hide();
                }
                 **/
            });
                
	});
	</script>	
<!--                <img id="helptip" rel="tipsy" title="You can click on Confirm button to add teacher in tuition schedule.
                     <br />To edit previous entry please use edit link form above 'action' column of 'Teacher tuition schedule added history'." src="<?php //echo base_url();?>img/tuition/help.png" />-->
		<!-- Here goes the content. -->
        <section id="content" class="container_12 clearfix" data-sort=true>
                <div class="grid_12">
                        <div class="box">
                                <div class="header">
                                        <h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png"><?php echo $breadcrumb2;?></h2>
                                </div>
                                <div class="content" style="margin: 10px;">
                                    <form action="<?php echo base_url().'index.php/teachers/exportreview';?>" method="post">
                                    <div class="form-data grid_4" >
                                        <div class="left-class">
                                            <label for="selNatinality" style="width: 115px;">
                                                <strong>Nationality</strong>
                                            </label>
                                        </div>
                                        <div class="left-class" style="width:100%;">
                                            <select id="selNationality" name="selNationality"  >
                                                <option value="">All</option>
                                                <option value="afghan">Afghan</option>
                                                <option value="albanian">Albanian</option>
                                                <option value="algerian">Algerian</option>
                                                <option value="american">American</option>
                                                <option value="andorran">Andorran</option>
                                                <option value="angolan">Angolan</option>
                                                <option value="antiguans">Antiguans</option>
                                                <option value="argentinean">Argentinean</option>
                                                <option value="armenian">Armenian</option>
                                                <option value="australian">Australian</option>
                                                <option value="austrian">Austrian</option>
                                                <option value="azerbaijani">Azerbaijani</option>
                                                <option value="bahamian">Bahamian</option>
                                                <option value="bahraini">Bahraini</option>
                                                <option value="bangladeshi">Bangladeshi</option>
                                                <option value="barbadian">Barbadian</option>
                                                <option value="barbudans">Barbudans</option>
                                                <option value="batswana">Batswana</option>
                                                <option value="belarusian">Belarusian</option>
                                                <option value="belgian">Belgian</option>
                                                <option value="belizean">Belizean</option>
                                                <option value="beninese">Beninese</option>
                                                <option value="bhutanese">Bhutanese</option>
                                                <option value="bolivian">Bolivian</option>
                                                <option value="bosnian">Bosnian</option>
                                                <option value="brazilian">Brazilian</option>
                                                <option value="british">British</option>
                                                <option value="bruneian">Bruneian</option>
                                                <option value="bulgarian">Bulgarian</option>
                                                <option value="burkinabe">Burkinabe</option>
                                                <option value="burmese">Burmese</option>
                                                <option value="burundian">Burundian</option>
                                                <option value="cambodian">Cambodian</option>
                                                <option value="cameroonian">Cameroonian</option>
                                                <option value="canadian">Canadian</option>
                                                <option value="cape verdean">Cape Verdean</option>
                                                <option value="central african">Central African</option>
                                                <option value="chadian">Chadian</option>
                                                <option value="chilean">Chilean</option>
                                                <option value="chinese">Chinese</option>
                                                <option value="colombian">Colombian</option>
                                                <option value="comoran">Comoran</option>
                                                <option value="congolese">Congolese</option>
                                                <option value="costa rican">Costa Rican</option>
                                                <option value="croatian">Croatian</option>
                                                <option value="cuban">Cuban</option>
                                                <option value="cypriot">Cypriot</option>
                                                <option value="czech">Czech</option>
                                                <option value="danish">Danish</option>
                                                <option value="djibouti">Djibouti</option>
                                                <option value="dominican">Dominican</option>
                                                <option value="dutch">Dutch</option>
                                                <option value="east timorese">East Timorese</option>
                                                <option value="ecuadorean">Ecuadorean</option>
                                                <option value="egyptian">Egyptian</option>
                                                <option value="emirian">Emirian</option>
                                                <option value="equatorial guinean">Equatorial Guinean</option>
                                                <option value="eritrean">Eritrean</option>
                                                <option value="estonian">Estonian</option>
                                                <option value="ethiopian">Ethiopian</option>
                                                <option value="fijian">Fijian</option>
                                                <option value="filipino">Filipino</option>
                                                <option value="finnish">Finnish</option>
                                                <option value="french">French</option>
                                                <option value="gabonese">Gabonese</option>
                                                <option value="gambian">Gambian</option>
                                                <option value="georgian">Georgian</option>
                                                <option value="german">German</option>
                                                <option value="ghanaian">Ghanaian</option>
                                                <option value="greek">Greek</option>
                                                <option value="grenadian">Grenadian</option>
                                                <option value="guatemalan">Guatemalan</option>
                                                <option value="guinea-bissauan">Guinea-Bissauan</option>
                                                <option value="guinean">Guinean</option>
                                                <option value="guyanese">Guyanese</option>
                                                <option value="haitian">Haitian</option>
                                                <option value="herzegovinian">Herzegovinian</option>
                                                <option value="honduran">Honduran</option>
                                                <option value="hungarian">Hungarian</option>
                                                <option value="icelander">Icelander</option>
                                                <option value="indian">Indian</option>
                                                <option value="indonesian">Indonesian</option>
                                                <option value="iranian">Iranian</option>
                                                <option value="iraqi">Iraqi</option>
                                                <option value="irish">Irish</option>
                                                <option value="israeli">Israeli</option>
                                                <option value="italian">Italian</option>
                                                <option value="ivorian">Ivorian</option>
                                                <option value="jamaican">Jamaican</option>
                                                <option value="japanese">Japanese</option>
                                                <option value="jordanian">Jordanian</option>
                                                <option value="kazakhstani">Kazakhstani</option>
                                                <option value="kenyan">Kenyan</option>
                                                <option value="kittian and nevisian">Kittian and Nevisian</option>
                                                <option value="kuwaiti">Kuwaiti</option>
                                                <option value="kyrgyz">Kyrgyz</option>
                                                <option value="laotian">Laotian</option>
                                                <option value="latvian">Latvian</option>
                                                <option value="lebanese">Lebanese</option>
                                                <option value="liberian">Liberian</option>
                                                <option value="libyan">Libyan</option>
                                                <option value="liechtensteiner">Liechtensteiner</option>
                                                <option value="lithuanian">Lithuanian</option>
                                                <option value="luxembourger">Luxembourger</option>
                                                <option value="macedonian">Macedonian</option>
                                                <option value="malagasy">Malagasy</option>
                                                <option value="malawian">Malawian</option>
                                                <option value="malaysian">Malaysian</option>
                                                <option value="maldivan">Maldivan</option>
                                                <option value="malian">Malian</option>
                                                <option value="maltese">Maltese</option>
                                                <option value="marshallese">Marshallese</option>
                                                <option value="mauritanian">Mauritanian</option>
                                                <option value="mauritian">Mauritian</option>
                                                <option value="mexican">Mexican</option>
                                                <option value="micronesian">Micronesian</option>
                                                <option value="moldovan">Moldovan</option>
                                                <option value="monacan">Monacan</option>
                                                <option value="mongolian">Mongolian</option>
                                                <option value="moroccan">Moroccan</option>
                                                <option value="mosotho">Mosotho</option>
                                                <option value="motswana">Motswana</option>
                                                <option value="mozambican">Mozambican</option>
                                                <option value="namibian">Namibian</option>
                                                <option value="nauruan">Nauruan</option>
                                                <option value="nepalese">Nepalese</option>
                                                <option value="new zealander">New Zealander</option>
                                                <option value="ni-vanuatu">Ni-Vanuatu</option>
                                                <option value="nicaraguan">Nicaraguan</option>
                                                <option value="nigerien">Nigerien</option>
                                                <option value="north korean">North Korean</option>
                                                <option value="northern irish">Northern Irish</option>
                                                <option value="norwegian">Norwegian</option>
                                                <option value="omani">Omani</option>
                                                <option value="pakistani">Pakistani</option>
                                                <option value="palauan">Palauan</option>
                                                <option value="panamanian">Panamanian</option>
                                                <option value="papua new guinean">Papua New Guinean</option>
                                                <option value="paraguayan">Paraguayan</option>
                                                <option value="peruvian">Peruvian</option>
                                                <option value="polish">Polish</option>
                                                <option value="portuguese">Portuguese</option>
                                                <option value="qatari">Qatari</option>
                                                <option value="romanian">Romanian</option>
                                                <option value="russian">Russian</option>
                                                <option value="rwandan">Rwandan</option>
                                                <option value="saint lucian">Saint Lucian</option>
                                                <option value="salvadoran">Salvadoran</option>
                                                <option value="samoan">Samoan</option>
                                                <option value="san marinese">San Marinese</option>
                                                <option value="sao tomean">Sao Tomean</option>
                                                <option value="saudi">Saudi</option>
                                                <option value="scottish">Scottish</option>
                                                <option value="senegalese">Senegalese</option>
                                                <option value="serbian">Serbian</option>
                                                <option value="seychellois">Seychellois</option>
                                                <option value="sierra leonean">Sierra Leonean</option>
                                                <option value="singaporean">Singaporean</option>
                                                <option value="slovakian">Slovakian</option>
                                                <option value="slovenian">Slovenian</option>
                                                <option value="solomon islander">Solomon Islander</option>
                                                <option value="somali">Somali</option>
                                                <option value="south african">South African</option>
                                                <option value="south korean">South Korean</option>
                                                <option value="spanish">Spanish</option>
                                                <option value="sri lankan">Sri Lankan</option>
                                                <option value="sudanese">Sudanese</option>
                                                <option value="surinamer">Surinamer</option>
                                                <option value="swazi">Swazi</option>
                                                <option value="swedish">Swedish</option>
                                                <option value="swiss">Swiss</option>
                                                <option value="syrian">Syrian</option>
                                                <option value="taiwanese">Taiwanese</option>
                                                <option value="tajik">Tajik</option>
                                                <option value="tanzanian">Tanzanian</option>
                                                <option value="thai">Thai</option>
                                                <option value="togolese">Togolese</option>
                                                <option value="tongan">Tongan</option>
                                                <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                                                <option value="tunisian">Tunisian</option>
                                                <option value="turkish">Turkish</option>
                                                <option value="tuvaluan">Tuvaluan</option>
                                                <option value="ugandan">Ugandan</option>
                                                <option value="ukrainian">Ukrainian</option>
                                                <option value="uruguayan">Uruguayan</option>
                                                <option value="uzbekistani">Uzbekistani</option>
                                                <option value="venezuelan">Venezuelan</option>
                                                <option value="vietnamese">Vietnamese</option>
                                                <option value="welsh">Welsh</option>
                                                <option value="yemenite">Yemenite</option>
                                                <option value="zambian">Zambian</option>
                                                <option value="zimbabwean">Zimbabwean</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-data grid_4" >
                                        <div class="left-class">
                                            <label for="selSex" style="width: 115px;">
                                                <strong>Gender</strong>
                                            </label>
                                        </div>
                                        <div class="left-class" style="width:100%;">
                                            <select id="selSex" name="selSex"  >
                                                <option value="">All</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-data grid_4" >
                                        <div class="left-class">
                                            <label for="selAgeRangeFrom" style="width: 115px;">
                                                <strong>Age range (in Year)</strong>
                                            </label>
                                        </div>
                                        <div class="left-class" style="width:100%;">
                                            <select id="selAgeRangeFrom" name="selAgeRangeFrom"  >
                                                <option value="">Select</option>
                                                <?php 
                                                for($age = 18; $age < 65; $age++){
                                                    ?><option value="<?php echo $age;?>"><?php echo $age;?></option><?php 
                                                }
                                                ?>
                                            </select>
                                            &nbsp;
                                            <select id="selAgeRangeTo" name="selAgeRangeTo"  >
                                                <option value="">Select</option>
                                                <?php 
                                                for($age = 19; $age <= 65; $age++){
                                                    ?><option value="<?php echo $age;?>"><?php echo $age;?></option><?php 
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-data grid_12" >
                                        <div class="left-class">
                                            <label for="selDiplomas" style="width: 115px;">
                                                <strong>Diplomas</strong>
                                            </label>
                                        </div>
                                        <div class="left-class" style="width:100%;">
                                            <select multiple id="selDiplomas" name="selDiplomas"  >
                                                <option value="celta">CELTA</option>
                                                <option value="trinity_tesol">Trinity TESOL</option>
                                                <option value="delta">DELTA</option>
                                                <option value="dip_tesol">Dip. TESOL</option>
                                                <option value="b_ed">B.Ed.</option>
                                                <option value="pgce">PGCE (Primary, English or MFL)</option>
                                                <option value="ma_elt_tesol">MA in ELT//TESOL</option>
                                                <!--<option value="other_diploma">Other</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-data grid_4" >
                                        <div class="left-class">
                                            <label for="selTeachYears" style="width: 115px;">
                                                <strong>Teach years</strong>
                                            </label>
                                        </div>
                                        <div class="left-class" style="width:100%;">
                                            <select id="selTeachYears" name="selTeachYears"  >
                                                <option value="">All</option>
						<option value="1-2 years">1-2 years</option>
						<option value="3-5 years">3-5 years</option>
						<option value="6-9 years">6-9 years</option>
						<option value="more than 10 years">more than 10 years</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-data grid_4" >
                                        <div class="left-class">
                                            <label for="selPostCode" style="width: 115px;">
                                                <strong>Postcode</strong>
                                            </label>
                                        </div>
                                        <div class="left-class" style="width:100%;">
                                            <select id="selPostCode" name="selPostCode"  >
                                                <option value="">All</option>
                                                <?php if($postcodeData){
                                                        foreach($postcodeData as $postcode){
                                                            ?><option value="<?php echo $postcode['code'];?>"><?php echo $postcode['area'];?></option><?php 
                                                        }
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-data grid_4" >
                                        <div class="left-class">
                                            <label for="name" style="width: 115px;">
                                                <strong>Name</strong>
                                            </label>
                                        </div>
                                        <div class="left-class" style="width:100%;">
                                            <input maxlength="100" style="width: 97%;" type="text" id="txtName" name="txtName" value="" />
                                        </div>
                                    </div>
                                    <div class="form-data grid_12" >
                                        <div class="left-class">
                                            <label for="txtCalFromDate" style="width: 115px;">
                                                <strong>Available date range</strong>
                                            </label>
                                        </div>
                                        <div class="left-class" style="width:100%;">
                                            <span class="text">From Date: </span>
                                            <input type="text" style="width:23.3%;" id="txtCalFromDate" name="fd" value="" />
                                            <span style="margin-left:1.2%;" class="text">To Date: </span>
                                            <input style="width:25.9%;" type="text" id="txtCalToDate" name="td" value="" /> 
                                        </div>
                                    </div>
                                    <?php if($pageType == 'profilereview'){?>
                                    <div class="form-data grid_4" >
                                        <div class="left-class">
                                            <label for="selIntLevel" style="width: 115px;">
                                                <strong>Interview level</strong>
                                            </label>
                                        </div>
                                        <div class="left-class" style="width:100%;">
                                            <select id="selIntLevel" name="selIntLevel">
                                                <option value="">Select level</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-data grid_4" >
                                        <div class="left-class">
                                            <label for="selRegVerified" style="width: 115px;">
                                                <strong>Reference checked</strong>
                                            </label>
                                        </div>
                                        <div class="left-class" style="width:100%;">
                                            <select id="selRegVerified" name="selRegVerified">
                                                <option value="">All</option>
                                                <option value="1">Verified</option>
                                                <option value="0">To be verify</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <div class="form-data grid_12 mr-top-10">
                                        <input type="hidden" name="hiddPageType" value="<?php echo $pageType;?>" />
                                        <input id="btnSearchApplication" type="button" value="Search" >
                                        <input id="btnClear" type="reset" value="Clear" >
                                        <input style="float:right;" id="btnExport" type="submit" value="Export" >
                                    </div>
                                    </form>
                                </div>
                                <div class="content">
                                        <div class="tabletools">
                                                <div class="left">
<!--                                                            <a class="open-add-client-dialog" href="<?php //echo base_url(); ?>index.php/teachers/addedit"><i class="icon-plus"></i>Create new teacher</a>-->
                                                </div>
                                                <div class="right">	
                                                    <?php 
                                                        $success_message = $this->session->flashdata('success_message');
                                                        if(!empty($success_message))
                                                        {
                                                            ?><div class="tuition_success"><?php echo $success_message;?></div><?php 
                                                        }
                                                        $error_message = $this->session->flashdata('error_message');
                                                        if(!empty($error_message))
                                                        {
                                                            ?><div class="tuition_error"><?php echo $error_message;?></div><?php 
                                                        }
                                                    ?>
                                                </div>
                                        </div>
                                    <!-- data-filter-bar='always' -->
                                        <table id="data-grid" class="dynamic styled"  data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting": [[ 0, "desc" ]],"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
                                                <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Teacher</th>
                                                            <th>Gender</th>
                                                            <th>Email</th>								
                                                            <th>Date of birth</th>
                                                            <th>Available from</th>
                                                            <th>Available to</th>
                                                            <th>Nationality</th>
                                                            <th>Action</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                if($teachers_app)
                                                foreach($teachers_app as $teacher){
                                                    
                                                    $reviewActions = "";
                                                    if($pageType == 'profilereview')
                                                    {
                                                        $reviewActions = '
                                                            <a title="Interview Info" href="javascript:void(0);" data-id="'.$teacher["ta_id"].'" class="dialog-interview" >
                                                                <span class="icon-user"> Interview</span>
                                                                </a> |
                                                            <a title="Send job offer letter" href="javascript:void(0);" data-id="'.$teacher["ta_id"].'" data-name="'.$teacher["teacher_full_name"].'" class="sendjoboffer_link" >
                                                                <span class="icon-file" > Send job offer letter</span>
                                                                </a> |
                                                            <a title="View" data-read="'.$teacher['ta_read_cv'].'" href="javascript:void(0);" data-id="'.$teacher["ta_id"].'" class="dialogbtn read'.$teacher['ta_read_cv'].'" >
                                                                <span class="icon-eye-open"></span>
                                                                </a>
                                                            <a title="Edit" href="'.base_url().'index.php/teachers/editapp/'.$teacher["ta_id"].'" class="edit-application" >
                                                                <span class="icon-edit"></span>
                                                                </a>  
                                                            ';
                                                    }
                                                    else
                                                    {
                                                        $reviewActions = '<a title="View" data-read="'.$teacher['ta_read_cv'].'" href="javascript:void(0);" data-id="'.$teacher["ta_id"].'" class="dialogbtn  read'.$teacher['ta_read_cv'].'" >
                                                            <span class="icon-eye-open"></span>
                                                            </a>
                                                        <a title="Edit" href="'.base_url().'index.php/teachers/editapp/'.$teacher["ta_id"].'" class="edit-application" >
                                                            <span class="icon-edit"></span>
                                                            </a>    
                                                        ';
                                                    }
                                                    
                                                ?>
                                                        <tr>
                                                            <td class="center"><?php echo $teacher["ta_id"];?></td>
                                                            <td class="center">
                                                                <?php echo html_entity_decode($teacher["teacher_full_name"]);?>
                                                            </td>
                                                            <td class="center"><?php echo $teacher["ta_sex"];?></td>
                                                            <td class="center"><?php echo $teacher["ta_email"];?></td>
                                                            <td class="center"><?php echo printDate($teacher["ta_date_of_birth"],"d/m/Y");?></td>
                                                            <td class="center"><?php echo date('d/m/Y',strtotime($teacher["ta_ablility_from"]));?></td>
                                                            <td class="center"><?php echo date('d/m/Y',strtotime($teacher["ta_ablility_to"]));?></td>
                                                            <td class="center"><?php echo ucwords($teacher["ta_nationality"]);?></td>
                                                            <td class="center operation">
                                                                <?php echo $reviewActions;?>
<!--                                                                <a title="View" href="javascript:void(0);" data-id="<?php //echo $teacher["ta_id"];?>" id="dialog_modal_btn_<?php //echo $teacher["ta_id"];?>" class="dialogbtn">
                                                                    <span class="icon-eye-open"></span>
                                                                </a>
                                                                <a title="Edit" href="<?php //echo base_url().'index.php/teachers/editapp/'.$teacher["ta_id"];?>" >
                                                                    <span class="icon-edit"></span>
                                                                </a>-->
                                                            </td>
                                                        </tr>
                                                <?php
                                                        }
                                                ?>
                                                </tbody>
                                        </table>
                                </div><!-- End of .content -->
                        </div><!-- End of .box -->
                </div><!-- End of .grid_12 -->

        </section><!-- End of #content -->
		
	</div><!-- End of #main -->
        <div style="display: none;" id="dialog_modal_appdetails" title="Teacher detail" class="windia-teacher">
            <div id="studentsDiv" class="box">
                <div class="header">
                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Teachers detail</span></h2>
                </div>
                <div class="content">
                    <div id="teacherDetail"></div>
                </div>
            </div>
        </div>
        
        <div style="display: none;" id="dialog_modal_interview" title="Add/Edit teacher interview detail" class="windia-interview">
            <div id="interviewInfoDiv" class="box">
                <div class="header">
                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Interview information</span></h2>
                </div>
                <div class="content">
                    <form method="post" id="frmTeacher" action="">
                    <div class="row">
                            <label for="txtSkypename" style="width: 115px;">
                                    <strong>Skype name</strong>
                            </label>
                            <div class="form-data" style="margin-left: 130px;">
                                    <input type="text" id="txtSkypename" name="txtSkypename" class="required" style="max-width:255px;"  maxlength="100" value="" >
                                    <div class="error" for="txtSkypename" generated="true"></div>
                            </div>
                    </div>
                        
                    <div class="row">
                            <label for="txtInterviewNotes" style="width: 115px;">
                                    <strong>Notes</strong>
                            </label>
                            <div class="form-data" style="margin-left: 130px;">
                                <textarea id="txtInterviewNotes" name="txtInterviewNotes" style="resize: horizontal;min-height: 65px;max-height: 65px;"></textarea>
                                <div class="error" for="txtInterviewNotes" generated="true"></div>
                            </div>
                    </div>
                    <div class="row">
                            <label for="txtStrong" style="width: 115px;">
                                    <strong>Strong</strong>
                            </label>
                            <div class="form-data" style="margin-left: 130px;">
                                <textarea id="txtStrong" name="txtStrong" style="resize: horizontal;min-height: 65px;max-height: 65px;"></textarea>
                                <div class="error" for="txtStrong" generated="true"></div>
                            </div>
                    </div>
                    <div class="row">
                            <label for="txtWeek" style="width: 115px;">
                                    <strong>Weak</strong>
                            </label>
                            <div class="form-data" style="margin-left: 130px;">
                                <textarea id="txtWeek" name="txtWeek" style="resize: horizontal;min-height: 65px;max-height: 65px;"></textarea>
                                <div class="error" for="txtWeek" generated="true"></div>
                            </div>
                    </div>
                    
                    <div class="row">
                            <label style="width: 115px;">
                                <strong>Interview level</strong>
                            </label>
                            <div class="form-data" style="margin-left: 130px;padding-bottom: 5px;">
                                <select id="selInterviewLevel">
                                    <option value="">Select level</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                                <br />
                                <input type="checkbox" value="1" id="chkCheckReferences" />
                                <label for="chkCheckReferences">Check references</label>
                                &nbsp;&nbsp;
                                <input type="checkbox" value="1" id="chkReturnee" />
                                <label for="chkReturnee">Returnee</label>
                            </div>
                    </div>
                    <div class="row">
                            <div class="form-data" style="margin-left: 130px;">
                                <input type="hidden" id="hiddInterviewTeacher" name="hiddInterviewTeacher" value="0" />
                                <input class="btn btn-tuition" type="button" id="btnUpdateInterview" name="btnUpdateInterview" value="Submit" />
                            </div>
                    </div>
                    <div class="row">
                            <div style="margin-left: 130px;">
                                <div style="margin-top: 4px!important" id="interview-form-message" >
                                    &nbsp;
                                </div>
                            </div>
                    </div> 
                    </form>
                </div>
            </div>
        </div>
        
        <style>
            .star-red{
                color:red;
            }
        </style>
        
        <div style="display: none;" id="sendjoboffer_dialog_popup" title="Send job offer letter" class="sendjoboffer_dialog scrollable-div">
            <div class="box">
                <div class="header">
                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Fill up required fields and submit to send offer letter</span></h2>
                </div>
                <div class="content">
                    <form method="post" id="frmJobOffer" action="">
                            <div class="row">
                                    <label for="applicant" style="width: 115px;">
                                            <strong>Applicant<span class="star-red"></span></strong>
                                    </label>
                                    <div class="form-data" style="margin-left: 130px;">
                                        <label id="lblCandidate">-- --</label>
                                    </div>
                            </div>
                            <div class="row">
                                    <label for="selPosition" style="width: 115px;">
                                            <strong>Position<span class="star-red">*</span></strong>
                                    </label>
                                    <div class="form-data" style="margin-left: 130px;">
                                        <select autocomplete="off" id="selPosition" name="selPosition" >
                                            <option value="">Select Position</option>
                                            <?php 
                                                if($positionData)
                                                {
                                                    foreach($positionData as $position){
                                                        ?>
                                                        <option value="<?php echo $position['pos_id'];?>"><?php echo $position['pos_position'];?></option>
                                                        <?php 
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <div class="error" for="selPosition" generated="true"></div>
                                    </div>
                            </div>
                            <div style="display:none;" id="rowType" class="row">
                                    <label for="selType" style="width: 115px;">
                                            <strong>Type<span class="star-red">*</span></strong>
                                    </label>
                                    <div class="form-data" style="margin-left: 130px;">
                                        <select autocomplete="off" id="selType" name="selType" >
                                            <option value="">Select Type</option>
                                            <option value="London">London</option>
                                            <option value="Non London">Non London</option>
                                            <option value="Academy 1">Academy 1</option>
                                            <option value="Academy 2">Academy 2</option>
                                        </select>
                                        <div class="error" for="selType" generated="true"></div>
                                    </div>
                            </div>
                            <div class="row">
                                    <label for="selCurrency" style="width: 115px;">
                                            <strong>Currency<span class="star-red">*</span></strong>
                                    </label>
                                    <div class="form-data" style="margin-left: 130px;">
                                        <select id="selCurrency" name="selCurrency" >
                                            <option value="">Select Currency</option>
                                            <option value="GBP">GBP</option>
                                            <option value="EUR">EUR</option>
                                            <option value="USD">USD</option>
                                        </select>
                                        <div class="error" for="selCurrency" generated="true"></div>
                                    </div>
                            </div>
                            <div style="display:none;" id="rowWages" class="row">
                                    <label for="selWages" style="width: 115px;">
                                            <strong>Wage Type<span class="star-red">*</span></strong>
                                    </label>
                                    <div class="form-data" style="margin-left: 130px;">
                                        <select id="selWages" name="selWages" >
                                            <option value="">Select Wage</option>
                                            <option value="Hourly">Hourly</option>
                                            <option value="Weekly">Weekly</option>
                                        </select>
                                        <div class="error" for="selWages" generated="true"></div>
                                    </div>
                            </div>
                            <div style="display:none;" id="rowRate" class="row">
                                    <label for="selRate" style="width: 115px;">
                                            <strong>Rate<span class="star-red">*</span></strong>
                                    </label>
                                    <div class="form-data" style="margin-left: 130px;">
                                        <select id="selRate" name="selRate" >
                                            <option value="">Select Rate</option>
                                            <?php 
                                                for($rateInx = 13;$rateInx <= 28;$rateInx++)
                                                {
                                                    ?>
                                                        <option value="<?php echo $rateInx;?>"><?php echo $rateInx;?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        <div class="error" for="selRate" generated="true"></div>
                                    </div>
                            </div>
                            <div style="display:none;" id="rowResidential" class="row">
                                    <label for="selResOrNon" style="width: 115px;">
                                            <strong>Res/Non Res<span class="star-red">*</span></strong>
                                    </label>
                                    <div class="form-data" style="margin-left: 130px;">
                                        <select id="selResOrNon" name="selResOrNon" >
                                            <option value="">Select Res/Non Res</option>
                                            <option value="Residential">Residential</option>
                                            <option value="Non-residential">Non-residential</option>
                                        </select>
                                        <div class="error" for="selResOrNon" generated="true"></div>
                                    </div>
                            </div>
                            <div class="row">
                                    <div class="form-data" style="margin-left: 130px;">
                                        <input type="hidden" id="hiddJobOfferTeacher" name="hiddJobOfferTeacher" value="0" />
                                        <input class="btn btn-tuition" type="button" id="btnSendJobOffer" name="btnSendJobOffer" value="Send offer" />
                                        <input class="btn btn-tuition" type="reset" id="btnJobCancel" name="btnJobCancel" value="Cancel" />
                                    </div>
                            </div>
                            <div class="row">
                                    <div style="margin-left: 130px;">
                                        <div style="min-height: 25px;margin-top: 4px!important" id="joboffer-form-message" >
                                            &nbsp;
                                        </div>
                                    </div>
                            </div>
                        </form>
                </div>
            </div>
            <div class="box">
                <div class="header">
                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon">Job offer sent history</span></h2>
                </div>
                <div id="jobOfferListingData" class="content">
                    <!-- JOB OFFER HISTORY WILL LAND HERE... -->
                </div>
            </div>
        </div>
        
        <div style="display: none;" id="dialog_modal_add_teacher" title="Add teacher in tuition schedule" class="windia-add-teacher">
            <div id="addTeacherDiv" class="box">
                <div class="header">
                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Fill up teacher's required fields and submit</span></h2>
                </div>
                <div class="content">
                    <form method="post" id="frmTeacher" action="">
                        <div class="row">
                                <label  for="selCampus" style="width: 115px;">
                                    <strong>Campus</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                    <select class="required" id="selCampus" name="selCampus"  >
                                        <option value="">Select Campus</option>
                                        <?php if($campusList){
                                                foreach ($campusList as $campus){
                                                    ?><option value="<?php echo $campus['id'];?>"><?php echo $campus['nome_centri'];?></option><?php 
                                                }
                                        }
                                        ?>
                                    </select>
                                    <div class="error"><?php echo form_error('selCampus');?></div>
                                </div>
                        </div>
                        <div class="row">
                                <label for="txtFirstName" style="width: 115px;">
                                        <strong>First name</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input type="text" id="txtFirstName" name="txtFirstName" class="required" style="max-width:255px;"  maxlength="100" value="" >
                                        <div class="error" for="txtFirstName" generated="true"></div>
                                </div>
                        </div>
                        <div class="row">
                                <label for="txtLastName" style="width: 115px;">
                                        <strong>Last name</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input type="text" id="txtLastName" name="txtLastName" class="required" style="max-width:255px;"  maxlength="100" value="" >
                                        <div class="error" for="txtLastName" generated="true"></div>
                                </div>
                        </div>
                        
                        <div class="row">
                                <label for="txtHoursPerDay" style="width: 115px;">
                                        <strong>Hours per day</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input type="text" id="txtHoursPerDay" name="txtHoursPerDay" class="required" onkeypress="return keyRestrict(event,'1234567890.');"  style="width:75px;"  maxlength="5" value="" >
                                        <div class="error"></div>
                                </div>
                        </div>
                        <div class="row">
                                <label for="txtFromDate" style="width: 115px;">
                                        <strong>From date</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input value="" onkeypress="return keyRestrict(event,'1234567890/');"  style="width:100px;" type="text" id="txtFromDate" name="txtFromDate" class="required">
                                        <div class="error"></div>
                                </div>
                        </div>
                        
                        <div class="row">
                                <label for="txtToDate" style="width: 115px;">
                                        <strong>To date</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input value=""  style="width:100px;" onkeypress="return keyRestrict(event,'1234567890/');" type="text" id="txtToDate" name="txtToDate" class="required">
                                        <div class="error"></div>
                                </div>
                        </div>
                        <div class="row">
                                <div class="form-data" style="margin-left: 130px;">
                                    <input type="hidden" id="hiddEditTeacher" name="hiddEditTeacher" value="0" />
                                    <input class="btn btn-tuition" type="button" id="btnSave" name="btnSave" value="Submit" />
                                    <input class="btn btn-tuition" type="reset" id="btnCancel" name="btnCancel" value="Cancel" />
                                </div>
                        </div>
                        <div class="row">
                                <div style="margin-left: 130px;">
                                    <div style="margin-top: 4px!important" id="form-message" >
                                        &nbsp;
                                    </div>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	
<?php $this->load->view('plused_footer');?>