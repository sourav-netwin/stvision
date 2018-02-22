<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form id="box_campus" name="box_campus" action="<?php echo base_url(); ?>index.php/backoffice/availabilityNew" method="post">  
                <div class="box box-primary">
                    <!--            <div class="box-header with-border">
                                  <h3 class="box-title">Sales</h3>
                                </div>-->
                    <!-- /.box-header -->
                    <!-- /.box-body -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 mr-bot-10 mr-top-10">
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
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <?php
                                $contaCentri = 0;
                                foreach ($centri as $key => $item) {
                                    $contaCentri++;
                                    ?>
                                    <input type="checkbox" autocomplete="off" class="chCentri sel_<?php echo $item['valuta_fattura'] ?>" name="centri[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>"> <label class="normal" for="c_<?php echo $item['id']; ?>"><?php echo $item['nome_centri'] ?></label><br />
                                    <?php
                                    if ($contaCentri % 5 == 0) {
                                        ?>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <?php
                                    }
                                }
                                ?>	
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="mr-bot-10 mr-top-10">
                                    <label>Bookings Status:</label>
                                    <div class="box-tools pull-right sort-text">
                                        <a href="javascript:void(0);" id="bk_all">All</a> - 
                                        <a href="javascript:void(0);" id="bk_none">None</a>
                                    </div>
                                </div>
                                <div class="mr-bot-10" >
                                    <input class="chStatus" autocomplete="off" type="checkbox" name="status[]" id="s_confirmed" value="confirmed"> <label for="s_confirmed" class="normal" >Confirmed</label><br />
                                    <input class="chStatus" autocomplete="off" type="checkbox" name="status[]" id="s_active" value="active"> <label for="s_active" class="normal" >Active</label><br />
                                    <input class="chStatus" autocomplete="off" type="checkbox" name="status[]" id="s_elapsed" value="elapsed"> <label for="s_elapsed" class="normal" >Elapsed</label><br />
                                    <input class="chStatus" autocomplete="off" type="checkbox" name="status[]" id="s_tbc" value="tbc"> <label for="s_tbc" class="normal" >To Be Confirmed</label><br />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="mr-bot-10 mr-top-10">
                                    <label>Date of interest</label>
                                </div>
                                <div class="mr-bot-10">
                                    <input type="text" class="form-control" readonly id="dateStart" name="dateStart" value="" style="cursor:pointer;" />
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
<!--                            <input class="btn btn-primary mr-bot-5 inviaO" data-type="Book" type="button" name="inviaO" id="inviaO" value="Retrieve Data" />-->
                            <input class="btn btn-primary mr-bot-5 inviaO" data-type="Pax" type="button" value="Retrieve Data" />
                        </div>
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
                <h4 class="modal-title">Tuition detail
                    <button aria-label="Close" onclick="$('#dialog_modal_retrive_data').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div id="retriveDataDiv"  class="modal-body">
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
        $('input.chStatus').iCheck('destroy'); 
        $('input.chCentri').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '10%' // optional
        });
        $('input.chStatus').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '10%' // optional
        });
    }

    var SITE_PATH = "<?php echo base_url(); ?>";
    
    $(document).ready(function() {
	
        iCheckInit();
        
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
        $("#bk_all").click(function(){
            $("input.chStatus").each(function(){
                $(this).iCheck("check");
            });
        });	

        $("#bk_none").click(function(){
            $("input.chStatus").each(function(){
                $(this).iCheck("uncheck");
            });
        });
        
        
        $( "#dateStart" ).datepicker({
            changeMonth: true,
            changeYear: true,		  
            dateFormat: "dd/mm/yy",
            maxDate: "+1Y"
        }).datepicker("setDate", new Date());

        
        
        // REPORTS - BY FILTERS
        $('.inviaO').on('click', function(e){
            var centriChecked = $('input.chCentri:checked').length;
            var statusChecked = $('input.chStatus:checked').length;
            var reportType = $(this).attr('data-type');
            if(centriChecked==0){
                swal("Error","Please, select one or more campus!");
                return false;
            }else{
                if(statusChecked==0){
                    swal("Error","Please, select one or more status!");
                    return false;
                }				
            }
            e.preventDefault();
            passingData = $('#box_campus').serialize();
            $('#retriveDataDiv').html('');
            loading();
            
            $.get( siteUrl + "backoffice/tuitionDetailNew/?"+passingData+"&rt="+reportType, function( data ) {
                $( "#retriveDataDiv" ).html( data );
                unloading();
                $("#dialog_modal_retrive_data").modal('show');
            });
            
        });	
        
    });
</script>