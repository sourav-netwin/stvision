<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        <div class="box-body">
          <table id="dataTableCampusRooms" class="campus_table datatable table table-bordered table-striped">
            <thead>
              <tr>
                <th>Bus code</th>               
                <th>Excursion</th>
                <th>Bus involved</th>
                <th class="no-sort">Bus cost</th>
                <th>Excursion date</th>
                <th>Cancelation date</th>
                <th class="no-sort">User</th>
              </tr>
            </thead>
            <tbody>
              <?php
              	if( $all_canceled )
              	{
              		foreach( $all_canceled as $exc )
              		{
              ?>
          			    <tr>
  								    <td><?php echo $exc["pcb_rndcode"]?></td>
                      <td><?php echo $exc["pcb_excursion"]?></td>
                      <td><?php echo $exc["pcb_bus"]?></td>
                      <td><?php echo $exc["pcb_price"] ?></td>
                      <td><?php echo date('d-m-Y', strtotime( $exc["pcb_exc_date"] ) )?></td>
                      <td><?php echo date('d-m-Y', strtotime( $exc["pcb_can_date"] ) )?></td>  
                      <td><?php echo $exc["pcb_can_user"] ?></td>
							      </tr>
              <?php
                  }
                }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Bus code</th>               
                <th>Excursion</th>
                <th>Bus involved</th>
                <th>Bus cost</th>
                <th>Excursion date</th>
                <th>Cancelation date</th>
                <th>User</th>
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