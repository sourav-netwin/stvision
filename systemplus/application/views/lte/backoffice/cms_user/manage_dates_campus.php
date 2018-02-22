<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">

<?php $camp=$campus[0]; ?>
<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
          <div class="row">
            <div class="col-sm-6 btn-create">
              <input id="hiddenDate" type="hidden" />
              <a href="#" id="pickDate" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp;Add new arrival date</a>
            </div>
            <?php showSessionMessageIfAny($this);?>
          </div>
        </div>
        <div class="box-body">
          <table id="dataTableCampusRooms" class="datatable table table-bordered table-striped">
            <thead>
              <tr>
                <th>Campus name</th>
                <th>Arrival date</th>
                <th class="no-sort">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              	if( $dates )
              	{
              		foreach( $dates as $date )
              		{
              ?>
          			    <tr>
  								    <td><?php echo $camp["nome_centri"]?></td>
                      <td><?php echo date("d/m/Y",strtotime($date["start_date"]))?></td>
  								    <td class="text-center">
                        <div class="btn-group custom-btn-group containremover">

                          <a href="javascript:void(0);" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-danger min-wd-20" data-original-title="Remove date <?php echo date("d/m/Y",strtotime($date["start_date"]))?> for <?php echo $camp["nome_centri"]?>" id="dataa_<?php echo $date["id"]?>">
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
                <th>Campus name</th>
                <th>Arrival date</th>
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
  $(document).ready(function() {
    $( ".containremover a" ).click(function(e) {
      e.preventDefault();
      if(confirm("Are you sure you want to remove this arrival date for <?php echo $camp["nome_centri"]?>?")){
        var myid = $(this).attr("id").split("_");
        window.location.href="<?php echo base_url(); ?>index.php/backoffice/cmsDelDateCampus/"+myid[1]+"/<?php echo $camp["id"]?>";
      }
    });

    $('#hiddenDate').datepicker({
      changeYear: 'true',
      changeMonth: 'true',
      onSelect: function(dateText, inst) {
        var date = $(this).val().replace("/","__").replace("/","__");
        window.location.href="<?php echo base_url(); ?>index.php/backoffice/cmsAddDateCampus/"+date+"/<?php echo $camp["id"]?>";
      }
    });

    $('#pickDate').click(function (e) {
      $('#hiddenDate').datepicker("show");
      e.preventDefault();
    });

  });
  </script>