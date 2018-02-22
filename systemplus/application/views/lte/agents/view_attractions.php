<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title"><i class="fa fa-globe"> Available attractions</i></h4>
                <a class="pull-right" data-toggle="tooltip" href="<?php echo base_url(); ?>downloads/extras/view_and_book_excursions_and_attractions_guide.pdf" target="_blank" title="Guide for upload list">
                    <i class="fa fa-info-circle"> How to book attractions</i>
                </a>
        </div>
        <div class="box-body">
            <?php showSessionMessageIfAny($this);?>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <th class="text-center">Attraction</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Location</th>								
                        <th class="no-sort">&nbsp;</th>
                    </thead>
                    <tbody>
                    <?php foreach($campus as $cam){
                       ?>
                        <tr>
                            <td><?php echo $cam["pat_name"]?></td>
                            <td><?php echo $cam["patt_name"]?></td>
                            <td><?php echo $cam["cou_descrizione"]?> - <?php echo $cam["cit_descrizione"]?></td>
                            <td class="center" style="width:100px;">
                                <div class="btn-group">
                                    <a href="<?php echo base_url(); ?>index.php/agents/viewAttractionDetail/<?php echo $cam["pat_id"]?>" class="min-wd-24 btn btn-xs btn-primary" >
                                        <span data-original-title="View details for attraction <?php echo $cam["pat_name"]?>" data-container="body" data-toggle="tooltip">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
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
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
	$(document).ready(function() {
                
	});
        
</script>