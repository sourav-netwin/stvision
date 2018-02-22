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
        <h1 class="grid_12 margin-top no-margin-top-phone">Overview teacher work</h1>
         <div class="row">  
                <div class="grid_12 mr-top-10" style="min-height:250px;">
                    <div class="box">
                        <form id="frmTeacherReport" onsubmit="return validate();" action="<?php echo base_url(); ?>index.php/tuitionsreports/teachers" method="post">
                        <div class="header">
                            <h2>Teacher work report</h2>
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
                                    <label for="selTeacher" style="width: 115px;">
                                        <strong>Teacher</strong>
                                    </label>
                                </div>
                                <div id="teachersContent" class="left-class" style="width:100%;">
                                    <select class="required" id="selTeacher" name="selTeacher"  >
                                        <option value="">Select Teacher</option>
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
                                    <input type="text" style="width:100px;" id="txtCalFromDate" name="fd" value="<?php echo date("d/m/Y",strtotime($calFromDate));?>" />
                                    <span style="margin-left:3%;">To</span>
                                    <input  type="text" style="width:100px; float: right" id="txtCalToDate" name="td" value="<?php echo date("d/m/Y",strtotime($calToDate));?>" />
                                </div>
                            </div>
                            <div class="form-data grid_12" >
                                <div style="float:right;padding-top: 15px;">
                                    <input id="btnTeacherReport" type="submit" value="Teacher report" style="margin-left: 10px">
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="box">
                        <form id="frmSummaryReport" onsubmit="return validateSummary();" action="<?php echo base_url(); ?>index.php/tuitionsreports/summary" method="post">
                        <div class="header">
                            <h2>Campus teacher work summary report</h2>
                        </div>
                        <div class="content" style="margin: 10px;">
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
                            <div class="form-data grid_8" >
                                <div class="left-class">
                                    <label for="txtSubFromDate" style="width: 115px;">
                                        <strong>From date - To date</strong>
                                    </label>
                                </div>
                                <div class="left-class" style="width:100%;">
                                    <input type="text" style="width:100px;" id="txtSubFromDate" name="fd" value="<?php echo date("d/m/Y",strtotime($calFromDate));?>" />
                                    <span style="margin-left:3%;">To</span>
                                    <input  type="text" style="width:100px; margin-left:3%;" id="txtSubToDate" name="td" value="<?php echo date("d/m/Y",strtotime($calToDate));?>" />
                                </div>
                            </div>
                            <div class="form-data grid_4" >
                                <div style="float:right;padding-top: 19px;">
                                    <input id="btnSummary" type="submit" value="Summary report" style="margin-left: 10px">
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
    
    function validateSummary(){
        var campusId = $("[name='campuses[]']:checked").length;
        var dateFrom = $("#txtSubFromDate").val();
        var dateTo = $("#txtSubToDate").val();
        if(campusId > 0 && dateFrom != '' && dateTo != ''){
            return true;
        }else{
            alert("Please select campus, from date and to date to search");
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
            alert("Please select campus, teacher, from date and to date to search");
            return false;
        }
    }
    var SITE_PATH = "<?php echo base_url();?>index.php/";
    $(document).ready(function() {
        
        $('form').removeClass('no-box');
        $( "li#mnutuition" ).addClass("current");
        $( "li#mnutuition a" ).addClass("open");		
        $( "li#mnutuition ul.sub" ).css('display','block');	
        $( "li#mnutuition ul.sub li#mnutuition_6" ).addClass("current");	
        
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
        });
    });
</script>	
<?php $this->load->view('plused_footer'); ?>
