<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12">
        <form id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/viewPlannedAllExcursions" method="post">
            <div class="box box-primary">
                <div class="box-body">
                    <h4 class="box-title" class="col-sm-12">Review extra excursions</h4>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <label >Select campus</label>
                            <div class="form-data">
                                <select class="form-control" name="centri" id="centricampus">
                                    <option <?php if ($campus == "") { ?>selected <?php } ?>value="">All campus</option>
                                    <?php foreach ($centri as $key => $item) { ?>
                                        <option <?php if ($campus == $item['id']) { ?>selected <?php } ?>value="<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <label>Select type</label>
                            <div class="form-data">
                                <select class="form-control" name="tipo" id="tipo">
                                        <option <?php if($tipo=="extra"){?>selected <?php }?>value="extra">Extra</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <label>Select date range (from)</label>
                            <div class="form-data">
                                <input class="form-control pull-left" type="text" id="from" name="from" value="<?php echo $from ?>" readonly/>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="form-data">
                                <label for="to" class="pull-left">(to)</label>
                                <input class="form-control pull-left" type="text" id="to" name="to" value="<?php echo $to ?>"  readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <label>Select status</label>
                            <div class="form-data">
                                <select class="form-control" name="status" id="status">
                                        <option <?php if($status=="all"){?>selected <?php }?>value="all">All</option>
                                        <option <?php if($status=="STANDBY"){?>selected <?php }?>value="STANDBY">Stand by</option>
                                        <option <?php if($status=="YES"){?>selected <?php }?>value="YES">Confirmed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="button" name="transpmi" id="transpmi"  class="btn btn-primary mr-top-10" value="Search" />
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    &nbsp;
                </div>
                <!-- /.box-footer-->
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-body">
                <h4 class="box-title">Review included excursions</h4>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="datatable table table-bordered table-striped" style="width:99.98%;">
                            <thead>
                                <tr>
                                    <th>Reference Code</th>
                                    <?php /* <th>Status</th> */ ?>
                                    <th>Excursion Date</th>
                                    <th>Campus</th>
                                    <th style="text-align:left;">Excursion</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($all_excursions as $exc){
                                                    switch ($exc["pte_confirmed"]){
                                                            case "YES":
                                                                    $refCOLOR = "refconfirmed";
                                                                    break;
                                                            case "STANDBY":
                                                                    $refCOLOR = "refstandby";
                                                            break;
                                                    }
                            ?>
                                    <tr>
                                            <td class="text-center">
                                                    <span class="idofbook <?php echo $refCOLOR ?>"><?php echo $exc["pte_buscompany_code"]?></span>
                                                    <a class="viewBusList" href="javascript:openBusList('<?php echo $exc["pte_buscompany_code"]?>');">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                            </td>
                                            <td class="text-center"><?php echo date("d/m/Y",strtotime($exc["pte_excursion_date"]))?></td>
                                            <td class="text-center"><?php echo $exc["nome_centri"]?></td>
                                            <td class="neretto"><em><?php echo $exc["exc_excursion"]?></em><br /><?php echo ucfirst($exc["exc_length"])?> - <?php echo $exc["allpax"]?> pax<?php if($exc["allpax"] != $exc["effettivi"]){ ?> <font style="color:#f00;font-weight:bold;">(<?php echo $exc["effettivi"]?> pax)</font><?php }?></td>
                                            <td class="text-center">
                                                <div class="btn-group min-wd-95">
                                                    <a class="btn btn-xs btn-info dialogbtn"  id="code_<?php echo $exc["pte_buscompany_code"]?>" href="<?php echo base_url(); ?>index.php/backoffice/busAllExcDetail/code_<?php echo $exc["pte_buscompany_code"]?>" title="View detail">
                                                        <span  title="View detail" data-toggle="tooltip" class="fa fa-search"></span>
                                                    </a>
                                                </div>
                                            </td>
                                    </tr>
                            <?php
                                    }
                            ?>
                            </tbody>
                        </table>
                        <table class="styled" style="border-top:1px solid #ddd;">
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dialog_modal_buslist" data-backdrop="static" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="openBusTitle">Bus list | bus code</span>
                    <button aria-label="Close" onclick="$('#dialog_modal_buslist').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div id="modalBody" class="modal-body">

            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_buslist').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $('#transpmi').click(function(){
          if($( "#from" ).val() == '' || $( "#to" ).val() == '')
          {
            swal("Error","Please select from and to date");
          }
          else{
            $('#loading-data').show();
            $('#box_transport').submit();
          }

        });
        $( "#from" ).datepicker({
            defaultDate: "+1d",
            changeMonth: true,
            numberOfMonths: 1,
                dateFormat: "dd/mm/yy",
            onClose: function( selectedDate ) {
                $( "#to" ).datepicker( "option", "minDate", selectedDate );
            }
            });
            $( "#to" ).datepicker({
            defaultDate: "+1d",
            changeMonth: true,
            numberOfMonths: 1,
                dateFormat: "dd/mm/yy",
            onClose: function( selectedDate ) {
                $( "#from" ).datepicker( "option", "maxDate", selectedDate );
            }
            });

    });
    function openBusList(busCode){
        $("#dialog_modal_buslist").modal('show');
        $("#modalBody").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />');
        $("#openBusTitle").html("Bus List | Bus code " + busCode);
        $.post('<?php echo base_url(); ?>index.php/backoffice/busDetailForExcursion/'+busCode,function(data){
            $("#modalBody").html(data);
            $("#modalBody table").removeAttr('style');
            $("#modalBody table").addClass('table table-bordered table-striped');
        });
    }
</script>