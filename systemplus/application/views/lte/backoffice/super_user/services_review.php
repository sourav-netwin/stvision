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
            <form id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/servicesReview" method="POST">
                <div class="row payment_row">
                    <div class="col-sm-4 col-md-3 form-group">
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
                    <div class="col-sm-4 col-md-3 form-group">
                        <label for="tipo">Type:</label>
                        <select class="form-control" id="tipo" name="tipo">
                            <option <?php if($tipo=="planned"){?>selected <?php }?>value="planned">Included</option>
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-2 form-group">
                        <label for="from">From:</label>
                        <input class="form-control" type="text" id="from" name="from" value="<?php echo $from ?>" readonly="readonly" />
                    </div>
                    <div class="col-sm-4 col-md-2 form-group">
                        <label for="to">To:</label> 
                        <input class="form-control" type="text" id="to" name="to" value="<?php echo $to ?>" readonly="readonly"/>
                    </div>
                    <div class="col-sm-4 col-md-2 form-group">
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
                        <th>Coach company</th>                             
                        <th>Bus / Seats</th>
                        <th>Campus</th>
                        <th>Excursion date</th>
                        <th>Excursion</th>
                        <th class="no-sort">View detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (!empty($all_services)) 
                        {
                            foreach($all_services as $exc)
                            {
                                $bPax = $exc["exb_tot_pax"];
                                $bSeats = $exc["exb_tot_pax"];
                                switch ($exc["exb_confirmed"])
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
                                    <td><?php echo $exc["tra_cp_name"]?></td>
                                    <td>
                                        <span class="<?php echo $refCOLOR ?>"><?php echo $exc["pbe_rndcode"]?></span>
                                        <a href="javascript:void(0);" class="service_view_modal" data-toggle="modal" data-target="#serviceViewModal" data-original-title="View detail" data-id="<?php echo $exc["pbe_rndcode"]?>">
                                          <i class="fa fa-info-circle"></i>
                                        </a>
                                    </td>
                                    <td><?php echo $exc["exc_centro"]?></td>
                                    <td><?php echo date("d/m/Y",strtotime($exc["pbe_excdate"]))?></td>
                                    <td>
                                        <strong><?php echo $exc["exc_excursion"]?></strong><br />
                                        <?php echo $bPax ?> pax - <?php if($bPax > $bSeats){ ?><font style="color:#f00;">!! <?php } ?><?php echo $bSeats ?> seats<?php if($bPax > $bSeats){ ?> !!</font><?php } ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-xs btn-primary min-wd-24 service_view_modal" data-toggle="tooltip" data-original-title="View detail" id="code_<?php echo $exc["pbe_rndcode"]?>" href="<?php echo base_url(); ?>index.php/backoffice/busExcDetail/code_<?php echo $exc["pbe_rndcode"]?>/transportation">
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
                        <th>Coach company</th>                             
                        <th>Bus / Seats</th>
                        <th>Campus</th>
                        <th>Excursion date</th>
                        <th>Excursion</th>
                        <th>View detail</th>
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

<div class="modal fade" id="serviceViewModal" tabindex="-1" role="dialog" aria-labelledby="serviceViewModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="serviceViewModalLabel">Bus List | Bus code</h4>
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

    $(".service_view_modal").click(function(){
        var busCode = $(this).attr("data-id");
        $("#serviceViewModal .modal-body").html('');
        $.post( "<?php echo base_url(); ?>index.php/backoffice/busDetailForExcursion/"+busCode, function( data ) {
            $("#serviceViewModal .modal-title").html("Bus List | Bus code "+busCode);           
            $("#serviceViewModal .modal-body").html(data);
            $("#serviceViewModal .modal-body table").css("width", "100%");
        });
    });
});
</script>