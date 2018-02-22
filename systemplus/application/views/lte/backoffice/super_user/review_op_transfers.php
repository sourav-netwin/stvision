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
            <form id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/reviewOpTransfers" method="POST">
                <div class="row payment_row">
                    <div class="col-sm-4 col-md-4 form-group">
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
                    <div class="col-sm-4 col-md-4 form-group">
                        <label for="tipo">Company:</label>
                        <select name="companies" id="centricompanies" class="form-control">
                            <option <?php if($company==""){?>selected <?php }?>value="">All companies</option>
                            <?php
                                 foreach($companies as $key=>$item){?>
                             <option <?php if($company==$item['tra_cp_id']){?>selected <?php }?>value="<?php echo $item['tra_cp_id']?>"><?php echo $item['tra_cp_name']?></option>
                            <?php    }
                            ?>
                        </select> 
                    </div>
                    <div class="col-sm-4 col-md-4 mr-top-25">
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
                        <th>Company</th>
                        <th>Campus</th>
                        <th>Type</th>
                        <th>Airport</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (!empty($all_transfers)) 
                        {
                            $totalefiltro = 0;
                            foreach($all_transfers as $exc)
                            {
                    ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $exc["pbe_rndcode"]?></strong>
                                        <a href="javascript:void(0);" class="view_bus_list" data-toggle="modal" data-target="#busListModal" data-original-title="View detail" data-id="<?php echo $exc["pbe_rndcode"]?>">
                                          <i class="fa fa-info-circle"></i>
                                        </a>
                                    </td>
                                    <td><?php echo date("d/m/Y",strtotime($exc["pbe_excdate"]))?></td>
                                    <td><?php echo $exc["tra_cp_name"]?></td>
                                    <td><?php echo $exc["nome_centri"]?></td>    
                                    <td>
                                        <?php if($exc["ptt_type"]=="inbound") { ?>
                                            <font style="color:#009900;font-weight:bold;">INBOUND</font>
                                        <?php } ?>                                  
                                        <?php if($exc["ptt_type"]=="outbound") { ?>
                                            <font style="color:#990000;font-weight:bold;">OUTBOUND</font>
                                        <?php } ?>  
                                    </td>                                   
                                    <?php if($exc["ptt_type"]=="inbound") { ?>
                                        <td><?php echo $exc["ptt_airport_to"]?></td>
                                    <?php } else { ?>
                                        <td><?php echo $exc["ptt_airport_from"]?></td>
                                    <?php } ?>
                                    <td>
                                        <a class="btn btn-xs btn-primary min-wd-24" data-toggle="tooltip" data-original-title="View detail" id="code_<?php echo $exc["pbe_rndcode"]?>" href="<?php echo base_url(); ?>index.php/backoffice/busTraDetail/code_<?php echo $exc["pbe_rndcode"]?>">
                                          <i class="fa fa-search-plus"></i>
                                        </a>
                                    </td>                                   
                                </tr>
                    <?php
                                $totalefiltro += $exc["totalone"];
                            }
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Reference code</th>
                        <th>Transfer date</th>
                        <th>Company</th>
                        <th>Campus</th>
                        <th>Type</th>
                        <th>Airport</th>
                        <th>Detail</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <?php if (!empty($all_transfers)) {
                echo $totalefiltro;
            } ?>
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