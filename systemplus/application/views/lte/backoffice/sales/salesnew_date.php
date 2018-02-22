<section class="content">
    <div class="row">
       <div class="col-md-12">
        <form id="box_campus" name="box_campus" action="<?php echo base_url(); ?>index.php/backoffice/salesNew" method="post">  
            
          <div class="box box-primary">
<!--            <div class="box-header with-border">
              <h3 class="box-title">Sales</h3>
            </div>-->
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
                            $contaCentri=0;
                            $differenceFormat = "%d";
                            foreach($centri as $key=>$item){
                                    $datetime1 = date_create($byDate);
                                    $datetime2 = date_create($item['openingDate']);
                                    $diff = date_diff( $datetime1, $datetime2, false);
                                    $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
                                    $addDay = " days";
                                    if($total==0){
                                            $mycolor = "green";
                                            $interval = "";
                                            $addDay = "";
                                    }else{
                                            if($total==1)
                                                    $mycolor = "orange";
                                                    $addDay = " day";
                                            if($total==2)
                                                    $mycolor = "red";
                                            if($total >= 3)
                                                    $mycolor = "gray";
                                            if( $diff->invert)
                                                    $interval = "-".$total;
                                            else
                                                    $interval = "+".$total;
                                    }
                                    //$interval = date_diff($datetime1, $datetime2)->format($differenceFormat);
                            ?>
                                <input type="checkbox" autocomplete="off" class="chCentri sel_<?php echo $item['valuta_fattura']?>" name="centri[]" id="c_<?php echo $item['id']?>" value="<?php echo $item['id'];?>"> <label class="normal" style="color:<?php echo $mycolor ?>"><?php echo $item['nome_centri']?>  <?php echo $interval.$addDay; ?></label><br />
                            <?php
                                $contaCentri++;
                                if($contaCentri%5==0){
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
                        <label for="dateStart">From date:</label>
                        <input class="form-control" type="text" id="dateStart" name="dateStart" value="<?php //echo date("d/m/Y",strtotime($calFromDate));?>" />
                    </div>
                    <div class="col-sm-3">
                        <label for="dateEnd">To date:</label>
                        <input class="form-control" type="text" id="dateEnd" name="dateEnd" value="<?php //echo date("d/m/Y",strtotime($calToDate));?>" />
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <input id="inviaO" name="inviaO" type="button" value="Retrieve data" class="btn btn-primary">
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </form>
    </div>
    </div>
</section>

<div id="dialog_modal_retrive_data" data-backdrop="static" class="modal">
    <div class="modal-dialog modal-lg-95-per">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sales detail
                    <button aria-label="Close" onclick="$('#dialog_modal_retrive_data').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div id="retriveDataDiv" style="height: 652px;" class="modal-body">
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_retrive_data').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
    
    var SITE_PATH = "<?php echo base_url();?>";
    var pageHighlightMenu = "backoffice/salesNew";
    $(document).ready(function() {
        iCheckInit();
        
        $( "#dateStart" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,		  
                dateFormat: "dd/mm/yy",		
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                        $(".dateStart").val(selectedDate);
                        $( "#dateEnd" ).datepicker( "option", "minDate", selectedDate );
                }
        });
        $( "#dateStart" ).datepicker( "setDate", "<?php echo date("d/m/Y",strtotime($byDate)) ?>" );
        $( "#dateEnd" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,		  
                dateFormat: "dd/mm/yy",		
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                        $(".dateEnd").val(selectedDate);
                        $( "#dateStart" ).datepicker( "option", "maxDate", selectedDate );
                }
        });
        $( "#dateEnd" ).datepicker( "setDate", "<?php echo date("d/m/Y",strtotime($byDate . "+15 days")) ?>" );
        
        
        $.fn.myFunction = function(){
            var centri = [];
            $("input.chCentri:checked").each(function(){
                centri.push($(this).val());
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
        
        
        // REPORTS
        $('#inviaO').on('click', function(e){
            var centriChecked = $('input.chCentri:checked').length;
            var accomoChecked = $('input.chAcco:checked').length;
            if(centriChecked==0){
                swal("Error","Please, select one or more campus!");
                return false;
            }else{
                if($("#dateStart").val()==""){
                    swal("Error","Please, select a start date");
                    return false;
                }else{
                    if($("#dateEnd").val()==""){
                        swal("Error","Please, select an end date");
                        return false;
                    }
                }		
            }
            var diaH = $(window).height()* 0.9;
            e.preventDefault();
            loading();
            passingData = $('#box_campus').serialize();
            $('#retriveDataDiv').html('');
            $('<iframe/>', {
                'src' : siteUrl + "backoffice/salesDetailNew/?"+passingData,
                'style' :'width:100%; height:100%;border:none;'
            }).appendTo('#retriveDataDiv');
            $("#dialog_modal_retrive_data").modal('show');;
            setTimeout(function(){
                unloading();
            },3000);
        });
    });
</script>