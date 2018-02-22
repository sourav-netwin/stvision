<section class="">
    <div class="row">
        <div class="col-md-4">
          <!-- DIRECT SEARCH PRIMARY -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Booking id direct search</h3>
            </div>
            <!-- /.box-header -->
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="input-group">
                  <input id="searchBk" name="searchBk" type="text" class="form-control" >
                      <span class="input-group-btn">
                        <button class="btn btn-primary btn-flat" name="searchBooking" id="searchBooking" >Search booking</button>
                      </span>
                </div>
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
    </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
        <form id="frmSearch" onsubmit="return validateStudents();" action="<?php echo base_url(); ?>index.php/tuitionsreports/view" method="post">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tuition schedule: Campus-wise search</h3>
            </div>
            <!-- /.box-header -->
            <!-- /.box-body -->
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="txtCalFromDate">From date:</label>
                        <input class="form-control" type="text" id="txtCalFromDate" name="fd" value="<?php echo date("d/m/Y",strtotime($calFromDate));?>" />
                    </div>
                    <div class="col-sm-3">
                        <label for="txtCalToDate">To date:</label>
                        <input class="form-control" type="text" id="txtCalToDate" name="td" value="<?php echo date("d/m/Y",strtotime($calToDate));?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mr-bot-10 mr-top-10">
                        <label >Campus:</label>
                        <div class="box-tools pull-right sort-text">
                            <a href="javascript:void(0);" id="s_USA">USA</a> - 
                            <a href="javascript:void(0);" id="s_UK">UK</a> - 
                            <a href="javascript:void(0);" id="s_EUR">EUR</a> - 
                            <a href="javascript:void(0);" id="s_all">All</a> - 
                            <a href="javascript:void(0);" id="s_none">None</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <?php
                        $contaCentri = 0;
                        foreach ($centri as $key => $item) {
                            ?>
                        <input type="checkbox" autocomplete="off" class="chCentri sel_<?php echo $item['valuta_fattura'] ?>" name="campuses[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>"> <label class="normal" for="c_<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?></label><br />
                            <?php
                            $contaCentri++;
                            if ($contaCentri % 5 == 0) {
                                ?>
                            </div>
                            <div class="col-sm-3">
                                <?php
                            }
                        }
                        ?>	
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mr-bot-10 mr-top-10">
                        <label >Courses:</label>
                        <div class="box-tools pull-right sort-text c_options">
                            <a href="javascript:void(0);" id="bk_all">All</a> - 
                            <a href="javascript:void(0);" id="bk_none">None</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="clsContent">
                    </div>	
                </div>
            </div>
            <div class="box-footer">
                <input type="submit" value="Retrieve schedule" class="btn btn-primary" />
                <input type="button" value="Students summary" id="btnStudentsSummary" class="btn btn-primary" />
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </form>
    </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
        <form id="frmClassReport" onsubmit="return validate();" action="<?php echo base_url(); ?>index.php/tuitionsreports/classreport" method="post">
          <!-- DIRECT SEARCH PRIMARY -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tuitions schedule: Class general report</h3>
            </div>
            <!-- /.box-header -->
            <!-- /.box-body -->
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="selCampus">Campus:</label>
                        <select class="required form-control" id="selCampus" name="selCampus"  >
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
                    <div class="col-sm-3">
                        <label for="selCourse">Course:</label>
                        <select class="required form-control" id="selCourse" name="selCourse"  >
                            <option value="">Select course</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="txtClassDate">Class date:</label>
                        <input class="form-control" type="text" id="txtClassDate" name="txtClassDate" value="" />
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <input id="btnClassReport" type="submit" value="Class schedule" class="btn btn-primary" />
            </div>
            <!-- /.box-footer-->
          </div>
        </form>
        <!--/.direct-chat -->
    </div>
    </div>
    
    
    
    
</section>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<script>
    function iCheckInit(){
        $('input.chCentri').iCheck('destroy'); 
        $('input.chCentri').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '10%' // optional
        });
    }
    function iCheckInitCourse(){
        $('input.chCourse').iCheck('destroy'); 
        $('input.chCourse').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '10%' // optional
        });
    }
    
    var SITE_PATH = siteUrl;
    var pageHighlightMenu = "tuitionsreports";
    function validate(){
        var campusId = $("#selCampus").val();
        var courseId = $("#selCourse").val();
        var dateS = $("#txtClassDate").val();
        if(campusId > 0 && courseId > 0 && dateS != ''){
            return true;
        }else{
            swal("Error","Please select campus, course and class date to search");
            return false;
        }
    }
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
                swal("Error","Please select duration from date - to date, campus and course to search record(s)");
                return false;
            }
    }

    $(document).ready(function() {
        
        iCheckInit();
        $(".c_options").hide();
        //$(".chCentri").change(function(){
        $('.chCentri').on('ifChanged', function(event){
            $.fn.myFunction();
        });
        
        
        $("#s_USA").click(function(){
            $("input.chCentri").each(function(){
                $(this).iCheck("uncheck");
            });
            $("input.sel_USD").each(function(){
                $(this).iCheck("check");
            });
            $.fn.myFunction();
        });
                
        $("#s_UK").click(function(){
            $("input.chCentri").each(function(){
                $(this).iCheck("uncheck");
            });
            $("input.sel_GBP").each(function(){
                $(this).iCheck("check");
            });
            $.fn.myFunction();
        });
                
        $("#s_EUR").click(function(){
            $("input.chCentri").each(function(){
                $(this).iCheck("uncheck");
            });
            $("input.sel_EUR").each(function(){
                $(this).iCheck("check");
            });
            $.fn.myFunction();
        });
        $("#s_all").click(function(){
            $("input.chCentri").each(function(){
                $(this).iCheck("check");
            });
            $.fn.myFunction();
        });
                
        $("#s_none").click(function(){
            $("input.chCentri").each(function(){
                $(this).iCheck("uncheck");
            });
            $.fn.myFunction();
        });
        $("#bk_all").click(function(){
            $("input.chCourse").each(function(){
                $(this).iCheck("check");
            });
        });
                
        $("#bk_none").click(function(){
            $("input.chCourse").each(function(){
                $(this).iCheck("uncheck");
            });
        });
        var currentCCRequest = null;    
        $.fn.myFunction = function(){
            var campuses = [];
            $("input.chCentri").each(function(){
                if($(this).prop('checked'))
                    campuses.push($(this).val());
                
            });
            
            if(currentCCRequest != null) {
                currentCCRequest.abort();
            }
            currentCCRequest = $.post( SITE_PATH + "tuitionsreports/getCampusCourses",{'campuses':campuses}, function( data ) {
                $("#clsContent").html(data);
                $(".grid_3").switchClass('grid_3','col-sm-3',0);
                iCheckInitCourse();
                $(".c_options").show();
                if(data == '')
                    $(".c_options").hide();
            });            
        }
        
        $( "body" ).on( "click", "#searchBooking", function() {
            var idSearch = $("#searchBk").val();
            $.post( SITE_PATH + "tuitionsreports/bookingExists",{'idSearch':idSearch}, function( data ) {
                if(!parseInt(data))
                    swal("Error","This booking id doesn't exists!");
                else
                {
                    window.location.href= SITE_PATH + "tuitionsreports/searchbooking/" + idSearch;
                }
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
        
        $( "#txtClassDate" ).datepicker({
                //defaultDate: "-1w",
                changeMonth: true,
                changeYear: true,		  
                dateFormat: "dd/mm/yy",		
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                        $("#txtClassDate").val(selectedDate);
                }
        });
        
        $( "body" ).on( "change", "#selCampus", function() {
            var campusId = $(this).val();
            $.post( SITE_PATH + "tuitions/getCourses",{'campusId':campusId}, function( data ) {
                $("#selCourse").html(data);
            });
        });
        
        $( "body" ).on( "click", "#btnStudentsSummary", function() {
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
                    swal("Error","Please select duration from date - to date, campus and course to search record(s)");
                }
                
        });
    });
</script>