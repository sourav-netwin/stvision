<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<?php
showSessionMessageIfAny($this);
?>
<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        <div class="box-body">

          <div id="content">
            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
              <li class="active"><a href="#received" data-toggle="tab">Received</a></li>
              <li><a href="#sent" data-toggle="tab">Sent</a></li>
            </ul>
            <div id="my-tab-content" class="tab-content ticket-tab-content">

              <div class="tab-pane active" id="received">
                <table class="campus_table datatable table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Priority</th>
                      <th>Category</th>
                      <th>Title</th>
                      <th>Text</th>
                      <th>Reference booking</th>
                      <th>Status</th>
                      <th class="no-sort">From backoffice</th>
                      <th class="no-sort">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if( $rowInboxDetails )
                      {
                        $count = 1;
                        foreach( $rowInboxDetails as $row )
                        {
                          if ($row['ptc_bo_reply']) {
                            ?>
                          <div class="modal fade modalRply" id="dialog_modal_rply_<?php echo $row["ptc_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="myModalLabel">Reply Details - <?php echo htmlspecialchars($row['ptc_title']); ?></h4>
                                </div>
                                <div class="modal-body">
                                  <p><strong>Message: </strong><?php echo $row['ptc_bo_reply']; ?></p>
                                  <?php echo $row['ptc_bo_attachment'] ? '<p><strong>Attachment: </strong><a target="_blank" href="' . TICKET_BO_DWNLD . $row['ptc_bo_attachment'] . '"><i class="glyphicon glyphicon-paperclip"></i></a></p>' : ''; ?>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php
                        }
                        ?>
                          <div class="modal fade" id="dialog_modal_<?php echo $row["ptc_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="pdfModalLabel">Ticket Details - <?php echo htmlspecialchars($row['ptc_title']); ?></h4>
                                </div>
                                <div class="modal-body">
                                  <p><strong>Priority: </strong><?php echo $row['ptc_priority']; ?></p>
                                  <p><strong>Category: </strong><?php echo $row['ptc_category']; ?></p>
                                  <p><strong>Title: </strong><?php echo $row['ptc_title']; ?></p>
                                  <p><strong>Text: </strong><?php echo $row['ptc_content']; ?></p>
                                  <p><strong>Reference booking: </strong><?php echo $row['ptc_ref_booking']; ?></p>
                                  <?php echo $row['ptc_attachment'] ?'<p><strong>Attachment: </strong> <a target="_blank" href="' . TICKET_CM_DWNLD . $row['ptc_attachment'] . '"><i class="glyphicon glyphicon-paperclip"></i></a></p>' : ''; ?>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>

                          <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row['ptc_priority']; ?></td>
                            <td><?php echo $row['ptc_category']; ?></td>
                            <td><?php echo $row['ptc_title']; ?></td>
                            <td><?php echo $row['ptc_content_small']; ?></td>
                            <td><?php echo $row['ptc_ref_booking']; ?></td>
                            <td>
                              <?php echo $row["ptc_closed"] == 0 ? '<span style="color: #107b10">Open</span>' : '<span style="color: #FF0000">Closed</span>' ?>
                            </td>
                            <td>
                              <div class="btn-group">
                                <a href="javascript:void(0);" class="btn btn-xs btn-info tktRplyOpenClass dialogbtn" data-toggle="modal" data-target="#dialog_modal_<?php echo $row["ptc_id"] ?>" data-original-title="View details" id="tktRplyOpn_<?php echo $row["ptc_id"] ?>" data-type="received">
                                  <span class="fa fa-eye" data-toggle="tooltip" title="View details"></span>
                                </a><?php echo $row['ptc_attachment'] ? '&nbsp;&nbsp;<a href="' . TICKET_BO_DWNLD . $row['ptc_attachment'] . '" target="_blank" class="BORplyVw btn btn-xs btn-warning" data-id="BORply_'.$row["ptc_id"].'" data-type="received"><i class="glyphicon glyphicon-paperclip" data-toggle="tooltip" title="Reply attachment"></i></a>' : ''; ?><?php echo $row['ptc_bo_read'] == 0 ? '&nbsp;&nbsp;<span class="text-red font-10 faa-flash animated fa fa-envelope notif-tkt" id="new_'.$row["ptc_id"].'"></span>' : '' ?>
                              </div>
                            </td>
                            <td style="white-space: nowrap;" class="text-center operation">
                              <?php
                              if ($row['ptc_bo_reply']) {
                                ?>
                                <div class="btn-group">
                                  <a href="javascript:void(0)" class="btn btn-xs btn-info" data-toggle="modal" data-target="#dialog_modal_rply_<?php echo $row["ptc_id"] ?>"  id="tktRplyOpn_<?php echo $row["ptc_id"] ?>"><span class="fa fa-eye " data-toggle="tooltip" title="View reply" ></span></a><?php echo $row['ptc_bo_attachment'] ? '<a href="' . TICKET_BO_DWNLD . $row['ptc_bo_attachment'] . '" target="_blank" class="btn btn-xs btn-warning"><i class="fa fa-paperclip"  data-toggle="tooltip" title="Reply attachment"></i></a>' : ''; ?>
                                  <?php
                                }
                                else {
                                  ?>
                                  <div class="btn-group">
                                    <a href="javascript:void(0)" class="tktRplyClass btn btn-xs btn-info" id="tktRply_<?php echo $row["ptc_id"] ?>"><span class="fa fa-mail-reply " data-toggle="tooltip" title="Reply" ></span></a>
                                    <?php
                                  }
                                  ?>
                                  <a href="javascript:void(0)" class="btn btn-xs btn-danger <?php echo $row["ptc_closed"] == 0 ? 'tktCloseClass' : '' ?>" id="tktClose_<?php echo $row["ptc_id"] ?>"><span data-toggle="tooltip" class="fa <?php echo $row["ptc_closed"] == 0 ? 'fa-square-o' : 'fa-check-square-o' ?>" <?php echo $row["ptc_closed"] == 0 ? 'title="Close ticket"' : 'title="Ticket closed"' ?>   ></span></a>
                                </div>
                            </td>
                          </tr>
                        <?php
                          $count += 1;
                        }
                      }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Priority</th>
                      <th>Category</th>
                      <th>Title</th>
                      <th>Text</th>
                      <th>Reference booking</th>
                      <th>Status</th>
                      <th>From backoffice</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                </table>
              </div>

              <div class="tab-pane" id="sent">
                <table class="campus_table datatable table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Priority</th>
                      <th>Category</th>
                      <th>Title</th>
                      <th>Text</th>
                      <th>Reference booking</th>
                      <th>Status</th>
                      <th class="no-sort">Action</th>
                      <th class="no-sort">Operator reply</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if( $rowDetails )
                      {
                        $count = 1;
                        foreach( $rowDetails as $row )
                        {
                          if ($row['ptc_bo_reply'])
                          {
                    ?>
                            <div style="display: none;" id="dialog_modal_rply_<?php echo $row["ptc_id"] ?>" title="Reply Details - <?php echo htmlspecialchars($row['ptc_title']); ?>" class="windia">
                              <p><strong>Message: </strong><?php echo $row['ptc_bo_reply']; ?></p>
                              <?php echo $row['ptc_bo_attachment'] ? '<p><strong>Attachment: </strong><a target="_blank" href="' . TICKET_BO_DWNLD . $row['ptc_bo_attachment'] . '"><i class="glyphicon glyphicon-paperclip"></i></a></p>' : ''; ?>
                            </div>
                    <?php } ?>
                          <div class="modal fade" id="dialog_modal_<?php echo $row["ptc_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="pdfModalLabel">Ticket Details - <?php echo htmlspecialchars($row['ptc_title']); ?></h4>
                                </div>
                                <div class="modal-body">
                                  <p><strong>Priority: </strong><?php echo $row['ptc_priority']; ?></p>
                                  <p><strong>Category: </strong><?php echo $row['ptc_category']; ?></p>
                                  <p><strong>Title: </strong><?php echo $row['ptc_title']; ?></p>
                                  <p><strong>Text: </strong><?php echo $row['ptc_content']; ?></p>
                                  <p><strong>Reference booking: </strong><?php echo $row['ptc_ref_booking']; ?></p>
                                  <?php echo $row['ptc_attachment'] ?'<p><strong>Attachment: </strong> <a target="_blank" href="' . TICKET_CM_DWNLD . $row['ptc_attachment'] . '"><i class="glyphicon glyphicon-paperclip"></i></a></p>' : ''; ?>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>

                          <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row['ptc_priority']; ?></td>
                            <td><?php echo $row['ptc_category']; ?></td>
                            <td><?php echo $row['ptc_title']; ?></td>
                            <td><?php echo $row['ptc_content_small']; ?></td>
                            <td><?php echo $row['ptc_ref_booking']; ?></td>
                            <td>
                              <?php echo $row["ptc_closed"] == 0 ? '<span style="color: #107b10">Open</span>' : '<span style="color: #FF0000">Closed</span>' ?>
                            </td>
                            <td>
                              <div class="btn-group">
                                <a href="javascript:void(0);" class="btn btn-xs btn-info min-wd-24" data-toggle="modal" data-target="#dialog_modal_<?php echo $row["ptc_id"] ?>" data-original-title="View details" id="tktOpn_<?php echo $row["ptc_id"] ?>">
                                  <i class="fa fa-eye" data-toggle="tooltip" title="View details"></i>
                                </a>
                                <?php echo $row['ptc_attachment'] ? '&nbsp;&nbsp;<a href="' . TICKET_CM_DWNLD . $row['ptc_attachment'] . '" target="_blank" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-paperclip" data-toggle="tooltip" title="Attachment"></i></a>' : ''; ?>
                              </div>
                            </td>
                            <td>
                              <?php
                              if ($row['ptc_bo_reply']) {
                                ?>
                                <div class="btn-group">
                                  <a href="javascript:void(0)" class="tktRplyOpenClass dialogbtn btn btn-xs btn-info"  data-id="dialog_modal_rply_btn_<?php echo $row["ptc_id"] ?>" id="tktRplyOpn_<?php echo $row["ptc_id"] ?>" data-type="sent">
                                    <span class="fa fa-eye" data-toggle="tooltip" title="View reply"></span>
                                  </a>
                                  <?php echo $row['ptc_bo_attachment'] ? '&nbsp;&nbsp;<a href="' . TICKET_BO_DWNLD . $row['ptc_bo_attachment'] . '" target="_blank" class="BORplyVw btn btn-xs btn-warning" data-id="BORply_'.$row["ptc_id"].'" data-type="sent"><i class="glyphicon glyphicon-paperclip" data-toggle="tooltip" title="Reply attachment"></i></a>' : ''; ?><?php echo $row['ptc_cm_read'] == 0 ? '&nbsp;&nbsp;<span class="notif_ico_sm blink_me glyphicon glyphicon-envelope" id="new_'.$row["ptc_id"].'"></span>' : '' ?>
                                </div>
                                  <?php
                              }
                              ?>
                            </td>
                          </tr>
                        <?php
                          $count += 1;
                        }
                      }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Priority</th>
                      <th>Category</th>
                      <th>Title</th>
                      <th>Text</th>
                      <th>Reference booking</th>
                      <th>Status</th>
                      <th>Action</th>
                      <th>Operator reply</th>
                    </tr>
                  </tfoot>
                </table>
              </div>

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

</section>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#tabs').tab();

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

    $(document).on('click', ".dialogbtn", function() {
      var iddia = $(this).attr("data-id").replace('_btn','');
      $( "#"+iddia ).dialog("open");
      return false;
    });
    $( ".windia" ).dialog({
      autoOpen: false,
      modal: true,
      width: 'auto',
      buttons: [{
          text: "Close",
          click: function() { $(this).dialog("close"); }
        }]
    });
  });

  function makeReadByCm(selId){
    if(selId != '' && typeof selId != 'undefined'){
      $.ajax({
        url: siteUrl + 'backoffice/readByCm',
        type: 'POST',
        data: {
          selId: selId
        },
        success: function(data){
          if(data == 1){
            $('#new_'+selId).remove();
            checkNewCMAlert();
          }
        }
      });
    }
  }

  function makeReadByBo(selId){
    if(selId != '' && typeof selId != 'undefined'){
      $.ajax({
        url: siteUrl + 'backoffice/readByBo',
        type: 'POST',
        data: {
          selId: selId
        },
        success: function(data){
          if(data == 1){
            $('#new_'+selId).remove();
            checkNewCMAlert();
          }
        }
      });
    }
  }

  $('body').on('click', ".tktEdtClass",function(e){
    e.preventDefault();
    var selId = $(this).attr('id').replace('tktEdt_', '');
    if(selId != '' && typeof selId != 'undefined'){
      $.ajax({
        type: "POST",
        data: {
          selId: selId
        },
        url: siteUrl + "backoffice/checkTicketStatus",
        success: function(response){
          if(response==1){
            var diaH = $(window).height()* 0.9;
            e.preventDefault();
            $('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(' + baseUrl + '/img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
            .html($('<iframe/>', {
              'src' : siteUrl + "backoffice/openTicketEdit/"+selId,
              'style' :'width:100%;height: 100%;border:none;'
            })).appendTo('body')
            .dialog({
              'title' : 'Edit ticket',
              'width' : '50%',
              'height' : diaH,
              modal: true,
              buttons: [ {
                  text: "Close",
                  click: function() { $( this ).dialog( "close" ); }
                } ]
            });
          }else{
            alert("This ticket doesn't exists or it is locked");
          }
        }
      });
    }
  });

  $('body').on('click', '.tktDelClass', function(){
    var selId = $(this).attr('id').replace('tktDel_', '');
    if(selId != '' && typeof selId != 'undefined'){
      var c = confirm('Are you sure to delete this ticket?');
      if(c){
        $.ajax({
          url: siteUrl + 'backoffice/deleteTicket',
          type: 'POST',
          data: {
            selId: selId
          },
          success: function(data){
            if(data == 1){
              alert('Ticket deleted successfully');
              location.reload();
            }
            else{
              alert('Failed to delete ticket');
            }
          },
          error: function(){
            alert('Failed to delete ticket');
          }
        });
      }

    }
  });

  $('body').on('click', '.BORplyVw', function(){
    var selId = $(this).attr('data-id').replace('BORply_','');
    var type = $(this).attr('data-type');
    if( type == 'received' )
      makeReadByBo(selId);
    else
      makeReadByCm(selId);
  });

  $('body').on('click', '.tktRplyOpenClass', function(){
    var selId = $(this).attr('id').replace('tktRplyOpn_','');
    var type = $(this).attr('data-type');
    if( type == 'received' )
        makeReadByBo(selId);
      else
        makeReadByCm(selId);
  });

  $('body').on('click', ".tktRplyClass",function(e){
    e.preventDefault();

    var selId = $(this).attr('id').replace('tktRply_', '');
    if(selId != '' && typeof selId != 'undefined'){
      $.ajax({
        type: "POST",
        data: {
          selId: selId
        },
        url: siteUrl + "ticketmanagement/checkTicketStatus",
        success: function(response){
          if(response==1){
            $.ajax({
              url: siteUrl + "ticketmanagement/openTicketReply/"+selId,
              type: 'POST',
              data:{},
              success: function(data){
                createModal('ticketReplyModal', 'Reply to ticket', data);
                initFileInput();
              },
              error: function(){
                swal('Error','This ticket doesn\'t exists!');
              }
            });

          }else{
            swal('Error','This ticket doesn\'t exists!');
          }
        }
      });
    }

  });

  $('body').on('submit','#replyTicketForm',function(e){
    e.preventDefault();
    var elm = $(this);
    var replyContent = $('#tktMessage').val();
    var ptc_id = $('#ptc_id').val();
    if(replyContent == '' || typeof replyContent == 'undefined'){
      swal('Error','Please enter a message');
    }
    else{
      var data = new FormData($('#replyTicketForm')[0]);
      $.ajax({
        url: siteUrl+'ticketmanagement/replyTicket/'+ptc_id,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
          if(data == 1){
            removeModal('ticketReplyModal');
            window.location.href = "<?php echo site_url() ?>/backoffice/recapTicket";
          }
          else{
            swal('Error',data);
          }
        },
        error: function(){
          swal('Error','Failed to reply ticket');
        }
      });
    }

  });

  $('body').on('click', '.tktCloseClass', function(){
    var elm = $(this);
    var selId = elm.attr('id').replace('tktClose_', '');
    if(selId != '' && typeof selId != 'undefined'){
      confirmAction('Are you sure to close the ticket?', function(s){
        if(s){
          $.ajax({
            url: siteUrl + 'ticketmanagement/changeTicketStatus',
            type: 'POST',
            data: {
              selId: selId
            },
            success: function(data){
              if(data == 1){
                if(elm.find('span').hasClass('fa-square-o')){
                  elm.find('span').removeClass('fa-square-o');
                  elm.find('span').addClass('fa-check-square-o');
                  elm.find('span').attr('data-original-title', 'Ticket closed');
                }
                else if(elm.find('span').hasClass('fa-check-square-o')){
                  elm.find('span').removeClass('fa-check-square-o');
                  elm.find('span').addClass('fa-square-o');
                  elm.find('span').attr('data-original-title', 'Close ticket');
                }
                elm.removeClass('tktCloseClass');
                swal('Success','Ticket closed successfully');
              }
              else{
                swal('Error','Failed to close ticket');
              }
            },
            error: function(){
              swal('Error','Failed to close ticket');
            }
          });
        }
      }, true, true);
    }
  });

</script>