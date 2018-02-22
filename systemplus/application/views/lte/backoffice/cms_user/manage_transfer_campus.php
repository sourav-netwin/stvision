<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
          <div class="row">
            <div class="col-sm-6 btn-create">
              <a href="<?php echo base_url(); ?>index.php/backoffice/cmsAddTransferCampus" class="btn btn-primary btn-sm" id="createClass" ><i class="fa fa-plus"></i>&nbsp;Add new transfer campus</a>
            </div>
            <?php showSessionMessageIfAny($this);?>
          </div>
        </div>
        <div class="box-body">
          <table id="dataTableCampusRooms" class="datatable table table-bordered table-striped">
            <thead>
              <tr>
                <th>Transfer</th>
                <th>Airport/Station code</th>
                <th class="no-sort">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              	if( $exctra )
              	{
              		foreach( $exctra as $tra )
              		{
              ?>
          			    <tr>
  								    <td><?php echo $tra["exc_excursion"]?></td>
                      <td><?php echo $tra["exc_airport"]?></td>
  								    <td class="text-center">
                        <div class="btn-group custom-btn-group">

                        	<a href="<?php echo base_url(); ?>index.php/backoffice/cmsEditTransferCampus/<?php echo $tra["exc_id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-info min-wd-20" data-original-title="Edit transfer <?php echo $tra["exc_excursion"]?>">
                            <i class="fa fa-edit"></i>
                          </a>

                          <a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageBusTransferCampus/<?php echo $tra["exc_id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-warning min-wd-20" data-original-title="Manage bus <?php echo $tra["exc_excursion"]?>">
                            <i class="fa fa-plane"></i>
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
                <th>Transfer</th>
                <th>Airport/Station code</th>
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
  pageHighlightMenu = "backoffice/cmsManageCampus";
</script>