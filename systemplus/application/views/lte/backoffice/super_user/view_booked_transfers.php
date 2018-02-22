<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<section class="content">
    <div class="row">
    
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this);?>
            </div>
            <form id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/viewBookedTransfers" method="POST">
                <div class="row payment_row">
                    <div class="col-sm-4 col-md-2">
                        <label for="centricampus">Campus:</label>
                        <select class="form-control" id="centricampus" name="centri">
                            <option <?php if($campus==""){?>selected <?php }?> value="">All campus</option>
                            <?php
                                foreach($centri as $key=>$item) 
                                { 
                            ?>
                                    <option <?php if($campus==$item['id']){?>selected <?php }?>value="<?php echo $item['id']?>"><?php echo $item['nome_centri']?></option>
                        <?php   } ?>
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <label for="tipo">Type:</label>
                        <select class="form-control" id="tipo" name="tipo">
                            <option <?php if($tipo=="all"){?>selected <?php }?>value="all">All</option>
                            <option <?php if($tipo=="inbound"){?>selected <?php }?>value="inbound">Inbound</option>
                            <option <?php if($tipo=="outbound"){?>selected <?php }?>value="outbound">Outbound</option>
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <label for="from">From:</label>
                        <input class="form-control" type="text" id="from" name="from" value="<?php echo $from ?>" readonly="readonly" />
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <label for="to">To:</label> 
                        <input class="form-control" type="text" id="to" name="to" value="<?php echo $to ?>" readonly="readonly"/>
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status">
                            <option <?php if($status=="all"){?>selected <?php }?>value="all">All</option>
                            <option <?php if($status=="STANDBY"){?>selected <?php }?>value="STANDBY">Stand by</option>
                            <option <?php if($status=="YES"){?>selected <?php }?>value="YES">Confirmed</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 mr-top-10">
                        <input class="btn btn-primary" type="submit" value="Search" id="transpmi" name="transpmi"/>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-body">
            <table id="dataTableStaffPriority" class="table datatable table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Reference code</th>
                        <th>Transfer date</th>
                        <th>Campus</th>
                        <th>Type</th>
                        <th>Airport</th>
                        <th>Flight(s)<br />N. pax</th>
                        <th class="no-sort">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (!empty($all_transfers)) 
                        {
                            foreach($all_transfers as $exc)
                            {
                                switch ($exc["ptt_confirmed"])
                                {
                                    case "YES":
                                        $refCOLOR = "text-success";
                                        break;
                                    case "STANDBY":
                                        $refCOLOR = "text-danger";
                                    break;                                          
                                }
                    ?>
                                <tr>
                                    <td>
                                        <span class="idofbook <?php echo $refCOLOR ?>"><?php echo $exc["ptt_buscompany_code"]?></span>
                                        <a href="javascript:void(0);" class="view_bus_list" data-toggle="modal" data-target="#busListModal" data-original-title="View detail" data-id="<?php echo $exc["ptt_buscompany_code"]?>">
                                          <i class="fa fa-info-circle"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo date("d/m/Y",strtotime($exc["ptt_excursion_date"]))?>
                                    </td>
                                    <td>
                                        <?php echo $exc["nome_centri"]?>
                                    </td>
                                    <td>
                                        <?php if($exc["ptt_type"]=="inbound") { ?>
                                            <font style="color:#009900;font-weight:bold;">INBOUND</font>
                                        <?php } ?>
                                        <?php if($exc["ptt_type"]=="outbound") { ?>
                                            <font style="color:#990000;font-weight:bold;">OUTBOUND</font>
                                        <?php } ?>  
                                    </td>
                                    <?php  if($exc["ptt_type"]=="inbound") { ?>
                                        <td class="center"><?php echo $exc["ptt_airport_to"]?></td>
                                    <?php } else { ?>
                                        <td class="center"><?php echo $exc["ptt_airport_from"]?></td>
                                    <?php } ?>
                                    <td class="neretto">
                                        <strong><?php echo $exc["tuttivoli"]?></strong>
                                        <br /><?php echo $exc["allpax"]?> pax<?php if($exc["allpax"] != $exc["effettivi"]){ ?> <font style="color:#f00;font-weight:bold;">(<?php echo $exc["effettivi"]?> pax)</font><?php }?>
                                    </td>
                                    <td>
                                        <a class="btn btn-xs btn-primary min-wd-24" data-toggle="tooltip" data-original-title="View detail" id="code_<?php echo $exc["ptt_buscompany_code"]?>" href="<?php echo base_url(); ?>index.php/backoffice/busTraDetail/code_<?php echo $exc["ptt_buscompany_code"]?>">
                                          <i class="fa fa-search-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                    <?php
                            }
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Reference code</th>
                        <th>Transfer date</th>
                        <th>Campus</th>
                        <th>Type</th>
                        <th>Airport</th>
                        <th>Flight(s)<br />N. pax</th>
                        <th>Detail</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
      </div>
    </div>
</section>

<div class="modal fade" id="busListModal" tabindex="-1" role="dialog" aria-labelledby="busListModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="busListModalLabel">Bus List | Bus code</h4>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/additional-methods.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
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

    $(".view_bus_list").click(function(){
        var busCode = $(this).attr("data-id");
        $("#busListModal .modal-body").html('');
        $.post( "<?php echo base_url(); ?>index.php/backoffice/busDetailForExcursion/"+busCode, function( data ) {
            $("#busListModal .modal-title").html("Bus List | Bus code "+busCode);           
            $("#busListModal .modal-body").html(data);
            $("#busListModal .modal-body table").css("width", "100%");
        });
    });
});
</script>