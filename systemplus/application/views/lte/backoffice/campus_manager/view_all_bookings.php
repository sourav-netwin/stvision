<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        <div class="box-body">
          <table id="dataTableCampusRooms" class="campus_table datatable table table-bordered table-striped">
            <thead>
              <tr>
                <th>Agency nationality</th>
                <th>Booking id</th>
                <th>Date in</th>
                <th>Date out</th>
                <th>Pax number</th>
                <th class="no-sort">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              	if( $all_books )
              	{
              		foreach( $all_books as $bk )
              		{
              ?>
          			    <tr>
  								    <td>
                        <img original-title="<?php echo @$bk["agency"][0]["businesscountry"]?>" src="<?php echo base_url() ?>img/flags/16/<?php echo @$bk["agency"][0]["businesscountry"] ?>.png" tooltip="">
                      </td>
  								    <td><?php echo $bk["id_year"]?>_<?php echo $bk["id_book"]?></td>
  								    <td><?php echo date("d/m/Y",strtotime($bk["arrival_date"]))?></td>
  								    <td><?php echo date("d/m/Y",strtotime($bk["departure_date"]))?></td>
                      <td><?php echo $bk["tot_pax"]?></td>
  								    <td class="text-center">
                        <div class="btn-group custom-btn-group">

                        	<a id="code__<?php echo $bk["id_year"]?>__<?php echo $bk["id_book"]?>" href="javascript:void(0);" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-info min-wd-24 dialognote" data-original-title="View notes for booking Id <?php echo $bk["id_year"]?>_<?php echo $bk["id_book"]?>">
                            <i class="fa fa-bars"></i>
                          </a>

                          <?php if(isset($bk["agency"][0]) && $bk["agency"][0]["id"] != 795) { ?>
                          <?php $labelExcursion = ($this->session->userdata('role') == 200)?'View/Book extra excursions for booking Id':'View extra excursions for booking Id'; ?>
                          <?php $labelAttraction = ($this->session->userdata('role') == 200)?'View/Book attractions for booking Id':'View attractions for booking Id'; ?>
                            <a id="code__<?php echo $bk["id_year"]?>__<?php echo $bk["id_book"]?>" href="<?php echo base_url(); ?>index.php/backoffice/ca_viewBookXx/<?php echo $bk["id_year"]?>/<?php echo $bk["id_book"]?>/<?php echo $bk["agency"][0]["id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-success min-wd-24" data-original-title="<?php echo $labelExcursion.' '. $bk["id_year"]?>_<?php echo $bk["id_book"]?>">
                              <i class="fa fa-picture-o"></i>
                            </a>

                            <a id="codeatt__<?php echo $bk["id_year"]?>__<?php echo $bk["id_book"]?>" href="<?php echo base_url(); ?>index.php/backoffice/ca_viewBookAtt/<?php echo $bk["id_year"]?>/<?php echo $bk["id_book"]?>/<?php echo $bk["agency"][0]["id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-primary min-wd-24" data-original-title="<?php echo $labelAttraction.' '. $bk["id_year"]?>_<?php echo $bk["id_book"]?>">
                              <i class="fa fa-camera"></i>
                            </a>

                          <?php } ?>

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
                <th>Agency nationality</th>
                <th>Booking id</th>
                <th>Date in</th>
                <th>Date out</th>
                <th>Pax number</th>
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

<div class="modal fade" id="note_modal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="pdfModalLabel">Insert note for Booking</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="pdf_file_title_1">Old notes</label>
          <textarea class="form-control" name="oldNotes" disabled id="oldNotes" rows="16"></textarea>
        </div>
      </div>
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
  $(function(){
    $( ".dialognote" ).click(function() {
      $("#oldNotes").val("");
      var idnota = $(this).attr("id").split("code__");
      var justid = idnota[1].split("__");
      $.ajax({
        url: "<?php echo base_url(); ?>index.php/backoffice/readBookingNotes/"+justid[1]+"/1",
        success: function(html){
          $("#oldNotes").val(html);
        }
      });
      $("#note_modal .modal-title").html("View notes for Booking "+idnota[1]);
      $("#thisBk").val(justid[1]);
      $("#note_modal").modal("show");
      return false;
    });
  });
</script>