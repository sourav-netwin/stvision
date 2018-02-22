<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
          <div class="row">
            <div class="col-sm-6 btn-create">
              <a href="<?php echo base_url(); ?>index.php/backoffice/cmsAddAttraction" class="btn btn-primary btn-sm" id="createClass" ><i class="fa fa-plus"></i>&nbsp;Add new attraction</a>
            </div>
            <?php showSessionMessageIfAny($this);?>
          </div>
        </div>
        <div class="box-body">
          <table id="dataTableCampusRooms" class="datatable table table-bordered table-striped">
            <thead>
              <tr>
                <th>Attraction</th>
                <th>Group</th>
                <th>Type</th>
                <th>Location</th>
                <th class="no-sort">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              	if( $campus )
              	{
              		foreach( $campus as $cam )
              		{
              ?>
          			    <tr>
  								    <td><?php echo $cam["pat_name"]?></td>
                      <td><?php echo $cam["pat_entertainment_group"]?></td>
                      <td><?php echo $cam["patt_name"]?></td>
                      <td><?php echo $cam["cit_descrizione"]?></td>
  								    <td class="text-center">
                        <div class="btn-group custom-btn-group">

                        	<a href="<?php echo base_url(); ?>index.php/backoffice/cmsEditAttraction/<?php echo $cam["pat_id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-info min-wd-20" data-original-title="Edit attraction <?php echo $cam["pat_name"]?>">
                            <i class="fa fa-edit"></i>
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
                <th>Attraction</th>
                <th>Group</th>
                <th>Type</th>
                <th>Location</th>
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
  pageHighlightMenu = "backoffice/cmsManageAttractions";
</script>
