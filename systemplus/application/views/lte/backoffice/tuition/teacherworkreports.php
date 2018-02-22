    <div class="row">
        <div class="col-md-12">
        <form id="frmTeacherReport" onsubmit="return validate();" action="<?php echo base_url(); ?>index.php/tuitionsreports/teachers" method="post">
          <!-- DIRECT SEARCH PRIMARY -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Teacher work report</h3>
            </div>
            <!-- /.box-header -->
            <!-- /.box-body -->
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="selCampus">Campus:</label>
                        <select class="form-control required" id="selCampus" name="selCampus"  >
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
                        <label for="selTeacher">Teacher:</label>
                        <div id="teachersContent" >
                            <select class="form-control required" id="selTeacher" name="selTeacher"  >
                                <option value="">Select teacher</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="fromDate">From date:</label>
                        <div id="teachersContent" >
                            <input type="text" class="form-control" id="txtCalFromDate" name="fd" value="<?php echo date("d/m/Y",strtotime($calFromDate));?>" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="fromDate">To date:</label>
                        <div id="teachersContent" >
                            <input type="text" class="form-control col-xs-4" id="txtCalToDate" name="td" value="<?php echo date("d/m/Y",strtotime($calToDate));?>" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <input class="btn btn-primary" id="btnTeacherReport" type="submit" value="Teacher report">
            </div>
            <!-- /.box-footer-->
          </div>
        </form>
        <!--/.direct-chat -->
    </div>
    </div>
    <div class="row">
       <div class="col-md-12">
        <form id="frmSummaryReport" onsubmit="return validateSummary();" action="<?php echo base_url(); ?>index.php/tuitionsreports/summary" method="post">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Campus teacher work summary report</h3>
            </div>
            <!-- /.box-header -->
            <!-- /.box-body -->
            <div class="box-body">
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
                <div class="row mr-bot-10">
                    <div class="col-sm-3">
                        <?php
                        $contaCentri = 0;
                        foreach ($centri as $key => $item) {
                            $contaCentri++;
                            ?>
                                <input type="checkbox" autocomplete="off" class="chCentri sel_<?php echo $item['valuta_fattura'] ?>" id="chk_<?php echo $contaCentri; ?>" name="campuses[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>"> <label class="normal" for="chk_<?php echo $contaCentri; ?>"><?php echo $item['nome_centri'] ?></label><br />
                            <?php
                            
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
                    <div class="col-sm-3">
                        <label for="txtCalFromDate">From date:</label>
                        <input class="form-control" type="text" id="txtSubFromDate" name="fd" value="<?php echo date("d/m/Y",strtotime($calFromDate));?>" />
                    </div>
                    <div class="col-sm-3">
                        <label for="txtCalToDate">To date:</label>
                        <input class="form-control" type="text" id="txtSubToDate" name="td" value="<?php echo date("d/m/Y",strtotime($calToDate));?>" />
                    </div>
                </div>
                <div class="row">
                    <div id="clsContent">
                    </div>	
                </div>
            </div>
            <div class="box-footer">
                <input id="btnSummary" type="submit" value="Summary report" class="btn btn-primary">
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </form>
    </div>
    </div>
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
    
    var SITE_PATH = "<?php echo base_url();?>index.php/";
    
    function validateSummary(){
        var campusId = $("[name='campuses[]']:checked").length;
        var dateFrom = $("#txtSubFromDate").val();
        var dateTo = $("#txtSubToDate").val();
        if(campusId > 0 && dateFrom != '' && dateTo != ''){
            return true;
        }else{
            swal("Error","Please select campus, from date and to date to search");
            return false;
        }
    }
    
    function validate(){
        var campusId = $("#selCampus").val();
        var teacherId = $("#selTeacher").val();
        var dateFrom = $("#txtCalFromDate").val();
        var dateTo = $("#txtCalToDate").val();
        if(campusId > 0 && teacherId > 0 && dateFrom != '' && dateTo != ''){
            return true;
        }else{
            swal("Error","Please select campus, teacher, from date and to date to search");
            return false;
        }
    }
    
    $(document).ready(function() {
        iCheckInit();
        
        $( "body" ).on( "change", "#selCampus", function() {
            var campusId = $(this).val();
            $.post( SITE_PATH + "tuitionsreports/getCampusTeachers",{'campusId':campusId}, function( data ) {
                $("#selTeacher").html(data);
                $("#selTeacher").trigger("liszt:updated");
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
        
        $( "#txtSubFromDate" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,		  
                dateFormat: "dd/mm/yy",		
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                        $(".txtSubFromDate").val(selectedDate);
                        $( "#txtSubToDate" ).datepicker( "option", "minDate", selectedDate );
                }
        });

        $( "#txtSubToDate" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,		  
                dateFormat: "dd/mm/yy",		
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                        $(".txtSubToDate").val(selectedDate);
                        $( "#txtSubFromDate" ).datepicker( "option", "maxDate", selectedDate );
                }
        });
        
        $.fn.myFunction = function(){
            var campuses = [];
            $("input.chCentri:checked").each(function(){
                campuses.push($(this).val());
            });
        }
        
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
        });
    });
</script>