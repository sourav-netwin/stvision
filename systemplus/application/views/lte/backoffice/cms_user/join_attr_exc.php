<?php $CC = $excursion; ?>
<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
          <div class="row">
            <div class="col-sm-6 btn-create">
              <a href="javascript:void(0);" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>&nbsp;Add new attraction</a>
            </div>
            <?php showSessionMessageIfAny($this);?>
          </div>
        </div>
        <div class="box-body">
          <div class="mr-bot-10">
            <?php echo $CC['exc_excursion'] ?> from <?php echo $CC['exc_centro'] ?> | <?php echo $CC['exc_type'] ?> | <?php echo $CC['exc_length'] ?>
          </div>
          <table id="dataTableCampusRooms" class="datatable table table-bordered table-striped">
            <thead>
              <tr>
                <th>Attraction</th>
                <th>Type</th>
                <th>Students price</th>
                <th>Adults price</th>
                <th class="no-sort">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              	if( $attrs )
              	{
              		foreach( $attrs as $attr )
              		{
              ?>
          			    <tr>
  								    <td><?php echo $attr["pat_name"]?></td>
                      <td><?php echo $attr["patt_name"]?></td>
                      <td style="text-align:right;"><?php echo $attr["pat_student_price"]?> <?php echo $attr["cur_codice"]?></td>
                      <td style="text-align:right;"><?php echo $attr["pat_adult_price"]?> <?php echo $attr["cur_codice"]?></td>
  								    <td class="text-center">
                        <div class="btn-group custom-btn-group containremover">

                        	<a href="javascript:void(0);" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-danger min-wd-24" data-original-title="Remove attraction <?php echo $attr["pat_name"]?>" id="attra_<?php echo $attr["pjea_id"]?>">
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
                <th>Attraction</th>
                <th>Type</th>
                <th>Students price</th>
                <th>Adults price</th>
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

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add an attraction to <?php echo $CC['exc_excursion'] ?></h4>
      </div>
      <div class="modal-body">
        <form name="addAttE" id="addAttE" action="<?php echo base_url(); ?>index.php/backoffice/cmsAddAttractionToExc/<?php echo $CC['exc_id'] ?>" method="POST">
          <div class="form-group">
            <label for="add_buse">Attraction</label>
            <select class="form-control" name="add_attra" id="add_attra">
              <?php
                foreach( $attractions as $at )
                {
              ?>
                  <option value="<?php echo $at["pat_id"]?>"><?php echo $at["pat_name"]?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addMe">Add attraction</button>
      </div>
    </div>
  </div>
</div>

</section>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  pageHighlightMenu = "backoffice/cmsManageExcursions/planned";

  $(document).ready(function(){
    $( ".containremover a" ).click(function(e){
      e.preventDefault();
      if(confirm("Are you sure you want to remove this attraction from <?php echo $CC['exc_excursion'] ?>?")){
        var myid = $(this).attr("id").split("_");
        window.location.href="<?php echo base_url(); ?>index.php/backoffice/cmsDelAttrExc/"+myid[1]+"/<?php echo $CC['exc_id'] ?>";
      }
    });

    $("#addMe").click(function(){
      $("#addAttE").submit();
    });
  });
</script>