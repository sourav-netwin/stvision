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
    <section id="content" class="container_12 clearfix" data-sort=true>
        <h1 class="grid_12 margin-top no-margin-top-phone">Overview tuitions schedule</h1>
        <h2 class="h2-separater grid_12 margin-top no-margin-top-phone"><span>Tuitions schedule: Booking id direct search</span></h2>
        <div class="row" >
            <div class="direct-search">
                <div class="box">
                    <div class="header">
                        <h2>Booking direct search</h2>
                    </div>
                    <div class="content" style="margin:10px;">
                        <div >
                            <input style="width:100px;" type="text" name="searchBk" id="searchBk" />
                            <input type="button" name="searchBooking" id="searchBooking" value="Search Booking" style="margin-left:20px;"/>
                        </div>								
                    </div>
                </div>
            </div>	
        </div>
        <h2 class="h2-separater grid_12 margin-top no-margin-top-phone"><span>Tuitions schedule: Campus-wise search</span></h2>
        <form id="frmSearch" onsubmit="return validateStudents();" action="<?php echo base_url(); ?>index.php/tuitionsreports/view" method="post">
        <div class="row1">
            <div class="grid_8 duration">
                <div class="box">
                    <div class="header">
                        <h2>Duration
                        </h2>
                    </div>
                    <div class="content" style="margin:10px;">
                        <div class="left-class">
                            <span class="text">From Date:</span>
                            <input type="text" id="txtCalFromDate" name="fd" value="<?php echo date("d/m/Y",strtotime($calFromDate));?>" /><br />
                        </div>
                        <div class="left-class">
                            <span class="text">To Date:</span>
                            <input type="text" id="txtCalToDate" name="td" value="<?php echo date("d/m/Y",strtotime($calToDate));?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row1">
                <div class="grid_12">
                    <div class="box">
                        <div class="header">
                            <h2>Campus
                                <span style="float:right;">
                                    <a href="javascript:void(0);" id="s_USA">USA</a> - 
                                    <a href="javascript:void(0);" id="s_UK">UK</a> - 
                                    <a href="javascript:void(0);" id="s_EUR">EUR</a> - 
                                    <a href="javascript:void(0);" id="s_all">All</a> - 
                                    <a href="javascript:void(0);" id="s_none">None</a>
                                </span>
                            </h2>
                        </div>
                        <div class="content" style="margin:10px;">
                            <div class="grid_3">
                                <?php
                                $contaCentri = 0;
                                foreach ($centri as $key => $item) {
                                    ?>
                                    <input type="checkbox" class="chCentri sel_<?php echo $item['valuta_fattura'] ?>" name="campuses[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?><br />
                                    <?php
                                    $contaCentri++;
                                    if ($contaCentri % 5 == 0) {
                                        ?>
                                    </div>
                                    <div class="grid_3">
                                        <?php
                                    }
                                }
                                ?>	
                            </div>
                        </div>
                    </div>
                </div>	
        </div>
            <div class="row1">  
                <div class="grid_12">
                    <div class="box">
                        <div class="header">
                            <h2>Courses
                                <span style="float:right;">
                                    <a href="javascript:void(0);" id="bk_all">All</a> - 
                                    <a href="javascript:void(0);" id="bk_none">None</a>
                                </span>
                            </h2>
                        </div>
                        <div class="content" style="margin:10px;" id="clsContent">
                        </div>
                    </div>
                </div>
                <div style="display:none;" class="grid_4">
                    <div class="box">
                        <div class="header">
                            <h2>Teachers
                                <span style="float:right;">
                                    <a href="javascript:void(0);" id="bk_all">All</a> - 
                                    <a href="javascript:void(0);" id="bk_none">None</a>
                                </span>
                            </h2>
                        </div>
                        <div class="content" style="margin:10px;" id="teachersContent">
                        </div>
                    </div>
                </div>
        </div>
        <div class="row1">
            <div class="grid_12">
                <input style="float:right;" type="submit" value="Retrieve Schedule" />
                <input id="btnStudentsSummary" style="float:right;margin-right:10px;" type="button" value="Students Summary" />
            </div>
        </div>
        </form>
        <h2 class="h2-separater grid_12 margin-top no-margin-top-phone"><span>Tuitions schedule: Class general report</span></h2>
         <div class="row1">  
                <div class="grid_12 mr-top-10" style="min-height:250px;">
                    <div class="box">
                        <form id="frmClassReport" onsubmit="return validate();" action="<?php echo base_url(); ?>index.php/tuitionsreports/classreport" method="post">
                        <div class="header">
                            <h2>Class general report</h2>
                        </div>
                        <div class="content" style="margin: 10px;">
                            <div class="form-data grid_4" >
                                <div class="left-class">
                                    <label for="selCampus" style="width: 115px;">
                                        <strong>Campus</strong>
                                    </label>
                                </div>
                                <div class="left-class" style="width:100%;">
                                    <select class="required" id="selCampus" name="selCampus"  >
                                        <option value="">Select Campus</option>
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
                                    <label for="selCourse" style="width: 115px;">
                                        <strong>Course</strong>
                                    </label>
                                </div>
                                <div class="left-class" style="width:100%;">
                                    <select class="required" id="selCourse" name="selCourse"  >
                                        <option value="">Select Course</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-data grid_4 res_grid_8" >
                                <div class="left-class">
                                    <label for="txtClassDate" style="width: 115px;">
                                        <strong>Class Date</strong>
                                    </label>
                                </div>
                                <div class="left-class" style="width:100%;">
                                    <input type="text" id="txtClassDate" name="txtClassDate" value="" />
                                    <input id="btnClassReport" type="submit" value="Class schedule" style="margin-left: 10px">
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
        var campusId = $("#selCampus").val();
        var courseId = $("#selCourse").val();
        var dateS = $("#txtClassDate").val();
        if(campusId > 0 && courseId > 0 && dateS != ''){
            return true;
        }else{
            alert("Please select campus, course and class date to search");
            return false;
        }
    }
    var SITE_PATH = "<?php echo base_url();?>index.php/";
    $(document).ready(function() {
        
        $('form').removeClass('no-box');
        
        $( "li#mnutuition" ).addClass("current");
        $( "li#mnutuition a" ).addClass("open");		
        $( "li#mnutuition ul.sub" ).css('display','block');	
        $( "li#mnutuition ul.sub li#mnutuition_5" ).addClass("current");	
        
         $( "#txtClassDate" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,		  
                dateFormat: "dd/mm/yy",		
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                        $("#txtClassDate").val(selectedDate);
                }
        });
        
        $(".chCentri").change(function(){
            $.fn.myFunction();
        });
        
        
        $("#s_USA").click(function(){
            $("input.chCentri").each(function(){
                $(this).attr("checked",false);
            });
            $("input.sel_USD").each(function(){
                $(this).attr("checked",true);
            });
            $.fn.myFunction();
        });
                
        $("#s_UK").click(function(){
            $("input.chCentri").each(function(){
                $(this).attr("checked",false);
            });
            $("input.sel_GBP").each(function(){
                $(this).attr("checked",true);
            });
            $.fn.myFunction();
        });
                
        $("#s_EUR").click(function(){
            $("input.chCentri").each(function(){
                $(this).attr("checked",false);
            });
            $("input.sel_EUR").each(function(){
                $(this).attr("checked",true);
            });
            $.fn.myFunction();
        });
        $("#s_all").click(function(){
            $("input.chCentri").each(function(){
                $(this).attr("checked",true);
            });
            $.fn.myFunction();
        });
                
        $("#s_none").click(function(){
            $("input.chCentri").each(function(){
                $(this).attr("checked",false);
            });
            $.fn.myFunction();
        });
        $("#bk_all").click(function(){
            $("input.chCourse").each(function(){
                $(this).attr("checked",true);
            });
        });
                
        $("#bk_none").click(function(){
            $("input.chCourse").each(function(){
                $(this).attr("checked",false);
            });
        });
                
        $.fn.myFunction = function(){
            var campuses = [];
            $("input.chCentri:checked").each(function(){
                campuses.push($(this).val());
            });
            $.post( SITE_PATH + "tuitionsreports/getCampusCourses",{'campuses':campuses}, function( data ) {
                $("#clsContent").html(data);
                // ":not([safari])" is desirable but not necessary selector
                    $.fn.checkbox();
            });
//            $.post( SITE_PATH + "tuitionsreports/getCampusTeachers",{'campuses':campuses}, function( data ) {
//                $("#teachersContent").html(data);
//            });
        }
        
        $( "body" ).on( "click", "#searchBooking", function() {
            var idSearch = $("#searchBk").val();
            $.post( SITE_PATH + "tuitionsreports/bookingExists",{'idSearch':idSearch}, function( data ) {
                if(!parseInt(data))
                    alert("This booking id doesn't exists!");
                else
                    {
                        window.location.href= SITE_PATH + "tuitionsreports/searchbooking/" + idSearch;
                    }
            });
        });
        
        
        $( "body" ).on( "change", "#selCampus", function() {
            var campusId = $(this).val();
            $.post( SITE_PATH + "tuitions/getCourses",{'campusId':campusId}, function( data ) {
                $("#selCourse").html(data);
                $("#selCourse").trigger("liszt:updated");
            });
        });
        
        
        $( "#txtCalFromDate" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,		  
                dateFormat: "dd/mm/yy",		
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                        $(".txtCalFromDate").val(selectedDate);
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
                        $(".txtCalToDate").val(selectedDate);
                        $( "#txtCalFromDate" ).datepicker( "option", "maxDate", selectedDate );
                }
        });
        
        $("#btnStudentsSummary").click(function(){
//                var exportForm = $('<form method="post" action="'+SITE_PATH + "tuitionsreports/students"+'"></form>').appendTo('body');
//                exportForm.append("<input type='hidden' name='campusId' value='<?php //echo $campusId;?>' />");
//                exportForm.submit();

                var fromDate = $("#txtCalFromDate").val();
                var toDate = $("#txtCalToDate").val();
                var campuses = [];
                $("input.chCentri:checked").each(function(){
                    campuses.push($(this).val());
                });
                var courses = [];
                $("input.chCourse:checked").each(function(){
                    courses.push($(this).val());
                });
                
                if(campuses.length > 0 && courses.length > 0 && fromDate != '' && toDate != '')
                {
                    var exportForm = $('<form method="post" action="'+SITE_PATH + "tuitionsreports/students"+'"></form>').appendTo('body');
                    exportForm.append("<input type='hidden' name='campuses' value='"+ campuses +"' />");
                    exportForm.append("<input type='hidden' name='courses' value='"+ courses +"' />");
                    exportForm.append("<input type='hidden' name='fd' value='"+ fromDate +"' />");
                    exportForm.append("<input type='hidden' name='td' value='"+ toDate +"' />");
                    exportForm.submit();
                }
                else{
                    alert("Please select duration from date - to date, campus and course to search record(s)");
                }
        });
        
        
        
    });
    
    function validateStudents(){
        var fromDate = $("#txtCalFromDate").val();
        var toDate = $("#txtCalToDate").val();
        var campuses = [];
        $("input.chCentri:checked").each(function(){
            campuses.push($(this).val());
        });
        var courses = [];
        $("input.chCourse:checked").each(function(){
            courses.push($(this).val());
        });

        if(campuses.length > 0 && courses.length > 0 && fromDate != '' && toDate != '')
        {
            return true;
        }
        else{
            alert("Please select duration from date - to date, campus and course to search record(s)");
            return false;
        }
    }
    
</script>	
<?php $this->load->view('plused_footer'); ?>
