<style>
    table tbody tr:nth-child(2n+1) td.n_confirmed,
    table tbody tr:nth-child(2n) td.n_confirmed{
            background-color:#9c9;
    }

    table tbody tr:nth-child(2n+1) td.n_active,
    table tbody tr:nth-child(2n) td.n_active{
            background-color:#ff9;
    }

    table tbody tr:nth-child(2n+1) td.n_elapsed,
    table tbody tr:nth-child(2n) td.n_elapsed{
            background-color:#f96;
    }

    table tbody tr:nth-child(2n+1) td.n_tbc,
    table tbody tr:nth-child(2n) td.n_tbc{
            background-color:#69f;
    }

    table tbody tr:nth-child(2n+1) td.n_rejected,
    table tbody tr:nth-child(2n) td.n_rejected{
            background-color:#f99;
    }
    
    
table tbody tr:nth-child(2n) td.pdf-create span,
table tbody tr:nth-child(2n) td.pdf-create-printed span, 
table tbody tr:nth-child(2n) td.pdf-create-payed span,
table tbody tr:nth-child(2n+1) td.pdf-create span,
table tbody tr:nth-child(2n+1) td.pdf-create-printed span, 
table tbody tr:nth-child(2n+1) td.pdf-create-payed span {
margin:0 auto;
display: block;
width: 30px;
height: 30px;
background: transparent url() center center no-repeat;
text-indent: -9999px;
}

table tbody tr:nth-child(2n) td.pdf-create span,
table tbody tr:nth-child(2n+1) td.pdf-create span{
	background-image:url('<?php echo base_url();?>img/added/pdf-create.png');
}

table tbody tr:nth-child(2n) td.pdf-create-printed span,
table tbody tr:nth-child(2n+1) td.pdf-create-printed span{
	background-image:url('<?php echo base_url();?>img/added/pdf-create-printed.png');
}
table tbody tr:nth-child(2n) td.pdf-create-payed span,
table tbody tr:nth-child(2n+1) td.pdf-create-payed span{
        background-image:url('<?php echo base_url();?>img/added/pdf-create-payed.png');
}
.ui-datepicker {
  font-size: smaller;
}
</style>
<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<link href="<?php echo base_url();?>css/added.css" rel="stylesheet">  
    <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border col-sm-12  mr-bot-10">
            <h4 class="box-title">Bookings</h4>
            <div class="box-tools pull-right">
                <!-- top right links -->
            </div>
        </div>
        <div class="box-body">
            <div class="row mr-bot-10">
                <?php showSessionMessageIfAny($this);?>
            </div>
            <div class="row mr-bot-10">
                <label class="col-sm-2 control-label" for="selCampus">Campus</label>
                <div class="col-sm-4">
                    <select class="form-control" autocomplete="off" id="selCampus" name="selCampus"  >
                        <option value="">Select Campus</option>
                        <?php if($campusList){
                                foreach ($campusList as $campus){
                                    ?><option <?php echo ($campusId == $campus['id'] ? "selected='selected'" : '');?> value="<?php echo $campus['id'];?>"><?php echo $campus['nome_centri'] . " - " . $campus['bookings_count']." Bookings";?></option><?php 
                                }
                        }
                        ?>
                    </select>
                    <div class="error"><?php echo form_error('selCampus');?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    
            <table class="datatable table table-bordered table-striped" style="width: 99.98%;"> 
                <thead>
                        <tr>
                                <th>Booking id</th>
                                <th>Date in</th>								
                                <th>Date out</th>
                                <th>Weeks</th>
                                <th>Package</th>
                                <th>Pax</th>
                                <th>Invoice</th>
                                <th>Status</th>
                        </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($all_books as $book) {
                            $da = explode("-", $book["arrival_date"]);
                            $dd = explode("-", $book["departure_date"]);
                            $ds = explode("-", $book["data_scadenza"]);
                            $accos = $book["all_acco"];
                                ?>
                                <tr>
                                    <td class="center">
                                        <input autocomplete="off" type="checkbox" class="chkBookings chkBookingsVal" id="chk_<?php echo $book["id_book"];?>" name="chkBookings" value="<?php echo $book["id_book"];?>" />
                                        <label for="chk_<?php echo $book["id_book"] ?>" style="font-weight: normal;"><?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?></label>
                                        <a title="View booking detail" data-toggle="tooltip" href="javascript:void(0);" id="dialog_modal_btn_<?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?>" class="dialogbtn btn btn-xs btn-info">[View]</a> 
                                            <div style="display: none;" id="dialog_modal_<?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?>" title="Booking detail - <?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?> - <?php echo $book["centro"] ?>">
                                                    <p><strong>Booking: </strong><?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?></p>
                                                    <p><strong>Date in: </strong><?php echo $da[2] ?>/<?php echo $da[1] ?>/<?php echo $da[0] ?><br /><strong>Date out: </strong><?php echo $dd[2] ?>/<?php echo $dd[1] ?>/<?php echo $dd[0] ?></p>
                                                    <p><strong>Weeks: </strong><?php echo $book["weeks"] ?></p>
                                                    <p><strong>Package: </strong><?php echo (empty($book['pack_package']) ? "(Not assigned yet)" : $book['pack_package']);?></p>
                                                    <p><strong>Accommodations</strong></p>
                                                    <p>
                                                    <ul>
                                                            <?php
                                                            if($accos)
                                                            foreach ($accos as $acco) {
                                                                    $tipo = $acco -> tipo_pax;
                                                                    $accom = $acco -> accomodation;
                                                                    $contot = $acco -> contot;
                                                                    //print_r($acco);
                                                                    ?>
                                                                    <li><strong><?php echo $tipo ?>: </strong><?php echo $accom ?>(<?php echo $contot ?>)</li>
                                                                    <?php
                                                            }
                                                            ?>
                                                    </ul>
                                                    </p>
                                            </div>
                                    </td>
                                    <td class="center"><?php echo $da[2]; ?>/<?php echo $da[1]; ?>/<?php echo $da[0]; ?></td>
                                    <td class="center"><?php echo $dd[2]; ?>/<?php echo $dd[1]; ?>/<?php echo $dd[0]; ?></td>
                                    <td class="center"><?php echo $book["weeks"] ?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="viewPackage" data-week="<?php echo $book['weeks'];?>" data-pack-id="<?php echo $book['pbmap_package_id'];?>" data-map-id="<?php echo $book['pbmap_id'];?>" data-book-id="<?php echo $book["id_book"];?>" data-year-book-id="<?php echo $book["id_year"] ."_". $book["id_book"];?>" data-id-centro="<?php echo $book['id_centro'];?>" data-campus="<?php echo $book['centro'];?>" data-ag-id="<?php echo $book['id_agente'];?>" data-toggle="tooltip" title="Select package" ><?php echo (empty($book['pack_package']) ? "Select package" : $book['pack_package']);?></a>
                                    </td>
                                    <td class="center"><?php echo $book["tot_pax"]; ?></td>
                                    <td class="center">
                                        <a id="latest_<?php echo $book['id_book'];?>" <?php echo (empty($book['inv_invoice_file']) ? "disabled='disabled'" : '');?> data-toggle="tooltip" title="Download latest invoice" href="<?php echo (empty($book['inv_invoice_file']) ? "javascript:void(0);" : base_url(). "index.php/bookinginvoice/pdf/". $book['inv_invoice_file']);?>" class="btn btn-xs btn-primary min-wd-20 latestPdf">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </a>
                                        <a data-toggle="tooltip" title="Generate new invoice" href="javascript:void(0);" data-book="<?php echo $book['id_book'];?>" class="btn btn-xs btn-danger min-wd-20 generateNewInv">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </a>
                                    </td>
                                    <?php
                                    switch ($book["status"]) {
                                            case 'tbc':
                                                    $statob = "To be confirmed";
                                                    break;
                                            default:
                                                    $statob = ucfirst($book["status"]);
                                                    break;
                                    }
                                    ?>
                                    <td class="n_<?php echo $book["status"] ?>"><?php echo $statob ?><?php if ($book["status"] == "active") { ?> until <?php echo isset($ds[2]) ? $ds[2] : '' ?>/<?php echo isset($ds[1]) ? $ds[1] : '' ?>/<?php echo isset($ds[0]) ? $ds[0] : '' ?><?php } ?></td>
                                    
                                </tr>
    <?php
    }
    ?>
                </tbody>
        </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input autocomplete="off" type="checkbox" class="chkBookings chkBookingsAll" id="chkBookingsAll" name="chkBookingsAll" value="" /> 
                    <label for="chkBookingsAll" style="font-weight: normal;">Select all</label>
                    <input type="button" value="Set package" name="btnShowPackageModal" id="btnShowPackageModal" class="btn btn-info mr-left-10">
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
      </div>
    </div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <h4 class="box-title"><i class="fa fa-info-circle"> Status label</i></h4>
            </div>
            <div class="box-body">
                <div class="alert note sticky no-margin-bottom">
                        <ul class="legenda">
                                <li><span class="li-tbc">To be confirmed</span>Your booking has been submitted and is waiting for confirmation by Head Office</li>
                                <li><span class="li-active">Active</span>We have reserved spaces for your group and these will be valid until the expiration date shown</li>
                                <li><span class="li-confirmed">Confirmed</span>Your booking is now confirmed and the deposit has being cleared</li>
                                <li><span class="li-elapsed">Elapsed</span>No deposit was received before the expiration date given</li>
                                <li><span class="li-rejected">Rejected</span>Your booking can not be accepted. Please contact a sales representative</li>
                        </ul>
                </div>
            </div>
            <div class="box-footer"></div>
        </div>
    </div>
</div>
<div id="dialog_modal_view" data-backdrop="static" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="modal-title-span"></span>
                    <button aria-label="Close" onclick="$('#dialog_modal_view').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_view').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- MODAL FOR PACKAGE -->
<div id="dialog_modal_package_view" data-backdrop="static" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="modal-title-span">Map package and booking</span>
                    <button aria-label="Close" onclick="$('#dialog_modal_package_view').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="modal-title">
                            <span >Booking details</span>
                        </h4>
                        <div id="bookingDetails" class="box-body">
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <hr />
                    <div class="col-sm-12">
                    <h4 class="modal-title">
                        <span >Add package</span>
                    </h4>
                    </div>
                    <div class="col-sm-12">
                    <form action="" id="frmAddPackage" class="validate" method="post">
                        <div class="box-body">
                            <div class="form-group row">
                                <label class="col-sm-4 "></label>
                                <div class="col-sm-8">
                                    <label class="control-label">All fields are mandatory.</label>
                                </div>
                            </div>
                            <div id="forLoading" class="form-group row">
                                <label class="col-sm-4 control-label" for="lblCampus">Campus</label>
                                <div class="col-sm-8">
                                    <label id="lblCampus"></label>
                                    <hidden id="hiddCampusId" name="hiddCampusId" value="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 control-label" for="lblCampus">Package</label>
                                <div class="col-sm-8">
                                    <select class="form-control" autocomplete="off" id="selPackage" name="selPackage"  >
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <input type="hidden" id="hiddBookId" name="hiddBookId" value="" />
                                    <input type="hidden" id="hiddMapId" name="hiddMapId" value="" />
                                    <input type="hidden" id="hiddPackId" name="hiddPackId" value="" />
                                    <input type="submit" value="Submit" name="btnAddPackage" id="btnAddPackage" class="btn btn-primary">
                                </div>
                                
                            </div>
                            <div class="row">
                                <div id="addPackageMsg" class="col-sm-offset-4 col-sm-8"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_package_view').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</div>

<div id="dialog_modal_multiple_booking_view" data-backdrop="static" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="modal-title-span">Map package and bookings</span>
                    <button aria-label="Close" onclick="$('#dialog_modal_multiple_booking_view').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                    <h4 class="modal-title">
                        <span >Add package</span>
                    </h4>
                    </div>
                    <div class="col-sm-12">
                    <form action="" id="frmAddPackageMultiple" class="validate" method="post">
                        <div class="box-body">
                            <div class="form-group row">
                                <label class="col-sm-4 "></label>
                                <div class="col-sm-8">
                                    <label class="control-label">All fields are mandatory.</label>
                                </div>
                            </div>
                            <div id="forLoading" class="form-group row">
                                <label class="col-sm-4 control-label" for="lblCampus">Campus</label>
                                <div class="col-sm-8">
                                    <label id="lblCampusMultiple"><?php echo $campusName;?></label>
                                    <hidden id="hiddCampusId" name="hiddCampusId" value="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 control-label" for="lblCampus">Package</label>
                                <div class="col-sm-8">
                                    <select class="form-control" autocomplete="off" id="selPackageMultiple" name="selPackageMultiple"  >
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <input type="submit" value="Submit" name="btnAddPackageMultiple" id="btnAddPackageMultiple" class="btn btn-primary">
                                </div>
                                
                            </div>
                            <div class="row">
                                <div id="addPackageMsgMultiple" class="col-sm-offset-4 col-sm-8"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_multiple_booking_view').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</div>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<script>
    var pageHighlightMenu = "mapbookings";
    function iCheckInit(){
        $('input.chkBookings').iCheck('destroy'); 
        $('input.chkBookings').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '10%' // optional
        });
    }
    
    var SITE_PATH = "<?php echo base_url()?>index.php/";
	$(document).ready(function() {
            iCheckInit();
            $("#selCampus").on('change',function(){
                var id = $(this).val();
                window.location.href = SITE_PATH + "mapbookings/index/" + id
            });
            
            $("#chkBookingsAll").on('ifChecked',function(){
                $("input.chkBookings").each(function(){
                    $(this).iCheck("check");
                });
            });
            $("#chkBookingsAll").on('ifUnchecked',function(){
                $("input.chkBookings").each(function(){
                    $(this).iCheck("uncheck");
                });
            });
            
            
             $( "body" ).on( "click", "#btnShowPackageModal", function(){
                var bookIds = [];
                    $("input.chkBookingsVal:checked").each(function(){
                        bookIds.push($(this).val());
                    });
                var campusId = "<?php echo $campusId;?>";
                if(parseInt(campusId) > 0)
                {
                    if(bookIds.length > 0)
                    {
                        var aId = "0";
                        $.post( SITE_PATH + "mapbookings/getPackages",{'idcentro':campusId,'aId':aId}, function( data ) {
                            $("#selPackageMultiple").html(data);
                        }); 
                        $("#dialog_modal_multiple_booking_view").modal('show');
                    }
                    else
                        swal("Alert","Please select at least one booking");
                }
                else
                        swal("Alert","Please select campus to load bookings");
            });
            
             $("#frmAddPackageMultiple").validate({
                    errorElement:"div",
                    ignore: "",
                    rules: {
                        selPackageMultiple: "required"
                    },
                    messages: {
                        selPackageMultiple: "Please select package"
                    },
                    submitHandler: function(form) {
                        $("#addPackageMsgMultiple").html("");
                        $("#addPackageMsgMultiple").removeClass("tuition_success");
                        var packageId = $("#selPackageMultiple").val();
                        var bookIds = [];
                        $("input.chkBookingsVal:checked").each(function(){
                            bookIds.push($(this).val());
                        });
                        $.post( SITE_PATH + "mapbookings/addPackageMultipleBook",{'packageId':packageId,'bookIds':bookIds}, function( data ) {
                            $("#addPackageMsgMultiple").html(data);
                            $("#addPackageMsgMultiple").addClass("tuition_success");
                            setTimeout(function(){
                                window.location.reload();
                            },1000);
                        });
                    }
            });
            
            
            
            
            $(".dialogbtn").on('click',function(){
                var id = $(this).attr('id');
                var modalId = id.replace('_btn', '');
                $("#modal-title-span").html($("#"+modalId).attr('title'));
                $("#dialog_modal_view .modal-body").html($("#"+modalId).html());
                $("#dialog_modal_view").modal('show');
            });
            
            $( "body" ).on( "click", ".viewPackage", function() {
                $("#addPackageMsg").html("");
                $("#addPackageMsg").removeClass("tuition_success");
                var lblCampus = $(this).attr('data-campus');
                var bookId = $(this).attr('data-year-book-id');
                var hiddBookId = $(this).attr('data-book-id');
                var campusId = $(this).attr('data-id-centro');
                var aId = $(this).attr('data-ag-id');
                var mpackId = $(this).attr('data-map-id');
                var packageId = $(this).attr('data-pack-id');
                var week = $(this).attr('data-week');
                $("#lblCampus").html(lblCampus);
                $("#hiddBookId").val(hiddBookId);
                $("#hiddMapId").val(mpackId);
                $("#bookingDetails").html($("#dialog_modal_" + bookId).html());
                $.post( SITE_PATH + "mapbookings/getPackages",{'idcentro':campusId,'aId':aId,'week':week}, function( data ) {
                    $("#selPackage").html(data);
                    $("#selPackage").val(packageId);
                }); 
                $("#dialog_modal_package_view").modal('show');
                $("#selPackage").blur();
                $("#selPackage").focus();
            });
            
            
            //frmAddPackage
            $("#frmAddPackage").validate({
                    errorElement:"div",
                    ignore: "",
                    rules: {
                        selPackage: "required"
                    },
                    messages: {
                        selPackage: "Please select package"
                    },
                    submitHandler: function(form) {
                        $("#addPackageMsg").html("");
                        $("#addPackageMsg").removeClass("tuition_success");
                        var packageId = $("#selPackage").val();
                        var bookId = $("#hiddBookId").val();
                        var mapId = $("#hiddMapId").val();
                        $.post( SITE_PATH + "mapbookings/addPackage",{'packageId':packageId,'bookId':bookId,'mapId':mapId}, function( data ) {
                            $("#addPackageMsg").html(data);
                            $("#addPackageMsg").addClass("tuition_success");
                            setTimeout(function(){
                                window.location.reload();
                            },1000);
                        });
                    }
            });
            
            $( "body" ).on( "click", ".generateNewInv", function() {
                var id_book = $(this).attr('data-book')
                var eleThis = $(this);
                var urlStr = "<?php echo base_url();?>index.php/mapbookings/generateinvoice/"+id_book+'/json';
                $.post( urlStr,{}, function( data ) {
                    if(data.result != 0)
                    {
                        var fileName = data.filname;
                        var urlStr = "<?php echo base_url();?>index.php/bookinginvoice/pdf/"+fileName;
                        eleThis.siblings(".latestPdf").attr('href',urlStr);
                        eleThis.siblings(".latestPdf").removeAttr('disabled');
                        window.location.href = urlStr;
                    }
                    else
                    {
                        swal("Alert",data.message);
                    }
                },'json');
            });
            
            
        });
</script>