<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
          <div class="row">
            <div class="col-sm-6 btn-create">
              <a href="<?php echo base_url(); ?>index.php/backoffice/cmsAddExcursion" class="btn btn-primary btn-sm" id="createClass" ><i class="fa fa-plus"></i>&nbsp;Add new excursion</a>
            </div>
            <?php showSessionMessageIfAny($this);?>
          </div>
        </div>
        <div class="box-body">
          <table id="dataTableCampusRooms" class="datatable table table-bordered table-striped">
            <thead>
              <tr>
                <th>Excursion</th>
                <th>Campus</th>
                <th>Type</th>
                <th>Weeks</th>
                <th class="no-sort">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              	if( $excursions )
              	{
              		foreach( $excursions as $cam )
              		{
              ?>
          			    <tr>
  								    <td><?php echo $cam["exc_excursion"]?></td>
                      <td><?php echo $cam["exc_centro"]?></td>
                      <td><?php echo $cam["exc_type"]?></td>
                      <td><?php echo $cam["exc_weeks"]?></td>
  								    <td class="text-center">
                        <div class="btn-group custom-btn-group">

                        	<a href="<?php echo base_url(); ?>index.php/backoffice/cmsEditExcursion/<?php echo $cam["exc_id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-info min-wd-20" data-original-title="Edit excursion <?php echo $cam["exc_excursion"]?>">
                            <i class="fa fa-edit"></i>
                          </a>

                          <a href="<?php echo base_url(); ?>index.php/backoffice/cmsJoinAttrExc/<?php echo $cam["exc_id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-success min-wd-20" data-original-title="Edit included attractions in <?php echo $cam["exc_excursion"]?>">
                            <i class="fa fa-map-marker"></i>
                          </a>

                          <a href="<?php echo base_url(); ?>index.php/backoffice/cmsJoinBusExc/<?php echo $cam["exc_id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-primary min-wd-20" data-original-title="Edit bus for <?php echo $cam["exc_excursion"]?>">
                            <i class="fa fa-road"></i>
                          </a>

                          <a href="javascript:deleteExc(<?php echo $cam["exc_id"]?>);" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-danger min-wd-20" data-original-title="Remove excursion <?php echo $cam["exc_excursion"]?>">
                            <i class="fa fa-trash"></i>
                          </a>

                        </div>
                      </td>
							      </tr>
              <?php
                  }
                }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Excursion</th>
                <th>Campus</th>
                <th>Type</th>
                <th>Weeks</th>
                <th>Action</th>
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
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>

  function deleteExc(idEE)
  {
    if(confirm("Are you sure you want to remove this excursion? All bookings and bus prices for this excursion will be removed!"))
    {
      window.location.href = "<?php echo base_url(); ?>index.php/backoffice/cmsRemoveExcursion/"+idEE+"/<?php echo $tipoE ?>";
    }
    else
    {
      return void(0);
    }
  }
</script>