<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header with-border col-sm-12 mr-bot-10">
        <h4 class="box-title">Bookings</h4>
      </div>
      <div class="box-body">
        <div class="row mr-bot-10">
          <div class="col-sm-6">
            <a class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>index.php/specialbooking"><i class="fa fa-plus"> Enrol</i></a>
          </div>
          <?php showSessionMessageIfAny($this);?>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <table class="datatable table table-bordered table-striped enrol_table" style="width: 99.98%;">
              <thead>
                <tr>
                  <th>Booking id</th>
                  <th>Campus</th>
                  <th>Accomodation</th>
                  <th>Week(s)</th>
                  <th>Staff person(s)</th>
                  <th>Date in</th>
                  <th>Date out</th>
                  <th class="no-sort">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if( $all_books )
                {
                  foreach ( $all_books as $book )
                  {
                ?>
                    <tr>
                      <td><?php echo date('Y', strtotime( $book['sb_created_on'] ) ) ?>_<?php echo $book['sb_id'] ?></td>
                      <td><?php echo $book['nome_centri'] ?></td>
                      <td><?php echo $book['accom_name'] ?></td>
                      <td><?php echo $book['sb_number_of_week'] ?></td>
                      <td><?php echo $book['sb_number_of_staff'] ?></td>
                      <td><?php echo date('d/m/Y', strtotime( $book['sb_arrival_date'] ) ) ?></td>
                      <td><?php echo date('d/m/Y', strtotime( $book['sb_departure_date'] ) ) ?></td>
                      <td>
                        <div class="btn-group custom-btn-group">

                          <span data-toggle="tooltip" data-original-title="View booking detail" class="span-action">
                            <a href="javascript:void(0);" class="btn btn-xs btn-info min-wd-20 booking_modal" data-toggle="modal" data-target="#bookingModal-<?php echo $book['sb_id'] ?>" data-id="<?php echo $book['sb_id'] ?>">
                              <i class="fa fa-eye"></i>
                            </a>
                          </span><span data-toggle="tooltip" data-original-title="Edit booking" class="span-action">
                            <a href="<?php echo base_url() ?>index.php/specialbooking/index/<?php echo $book['sb_id'] ?>" class="btn btn-xs btn-success min-wd-20">
                              <i class="fa fa-edit"></i>
                            </a>
                          </span><span data-toggle="tooltip" class="span-action" data-original-title="Insert pax details">
                            <a href="javascript:void(0);" class="btn btn-xs btn-warning min-wd-20 insertPaxList" id="compile_<?php echo date('Y', strtotime( $book['sb_created_on'] ) ) ?>_<?php echo $book['sb_id'] ?>">
                              <i class="fa fa-list"></i>
                            </a>
                          </span>

                          <div class="modal fade" id="bookingModal-<?php echo $book['sb_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="bookingModalLabel">Booking detail - <?php echo date('Y', strtotime( $book['sb_created_on'] ) ) ?>_<?php echo $book['sb_id'] ?> - <?php echo $book['nome_centri'] ?></h4>
                                </div>
                                <div class="modal-body">
                                  <p><strong>Campus: </strong><?php echo $book['nome_centri'] ?></p>
                                  <p><strong>Accomodation: </strong><?php echo $book['accom_name'] ?></p>
                                  <p><strong>Week(s): </strong><?php echo $book['sb_number_of_week'] ?></p>
                                  <p><strong>Staff person(s): </strong><?php echo $book['sb_number_of_staff'] ?></p>
                                  <p>
                                    <strong>Date in: </strong><?php echo date('d/m/Y', strtotime( $book['sb_arrival_date'] ) ) ?>
                                  </p>
                                  <p>
                                    <strong>Date out: </strong><?php echo date('d/m/Y', strtotime( $book['sb_departure_date'] ) ) ?>
                                  </p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                <?php
                  }
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
<div id="dialog_modal" data-backdrop="static" class="modal">
  <div class="modal-dialog modal-lg-95-per">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pax List | Booking detail
          <button aria-label="Close" onclick="$('#dialog_modal').modal('hide');" class="close" type="button">
            <span aria-hidden="true">×</span>
          </button>
        </h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnSave">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('click',".insertPaxList",function(e){
      e.preventDefault();
      var bytd = $(this).attr("id");
      var splitbytd = bytd.split("_");
      var year = splitbytd[1];
      var enroll_id = splitbytd[2];

      $("#dialog_modal .modal-body").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />');
      $("#dialog_modal .modal-body").load('<?php echo base_url(); ?>index.php/specialbooking/editPaxList/'+enroll_id+'/'+year);
      $("#dialog_modal").modal('show');
      return false;
    });

    $(document).on('click',"#btnSave",function(e){
      $("#postPax").submit();
    });
  });
</script>