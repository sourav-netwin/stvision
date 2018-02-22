<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css">
<?php
showSessionMessageIfAny($this);
?>
<form  id="box_tktFltr" name="box_tktFltr" action="<?php echo base_url(); ?>index.php/ticketmanagement" method="post" onsubmit="return checkSubmit()">
    <div class="row">
        <div class="col-md-12">

            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title width-full">Campus
                        <span class="pull-right sort-text">
                            <a href="javascript:void(0);" id="s_USA">USA</a> -
                            <a href="javascript:void(0);" id="s_UK">UK</a> -
                            <a href="javascript:void(0);" id="s_EUR">EUR</a> -
                            <a href="javascript:void(0);" id="s_all">All</a> -
                            <a href="javascript:void(0);" id="s_none">None</a>
                        </span>
                    </h2>
                </div>
                <div class="box-body">
                    <div class="col-sm-4 col-md-3">
                        <?php
                        $contaCentri = 0;
                        foreach ($centri as $key => $item) {
                            ?>
                            <input type="checkbox" autocomplete="off" <?php echo in_array($item['id'], $campuses) ? 'checked' : ''; ?> class="chCentri sel_<?php echo $item['valuta_fattura'] ?>" name="centri[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>">&nbsp;<label class="normal" for="c_<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?></label><br />
                            <?php
                            $contaCentri++;
                            if ($contaCentri % 5 == 0) {
                                ?>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title width-full">Category ( Sent )
                        <span class="pull-right sort-text">
                            <a href="javascript:void(0);" id="sct_all">All</a> -
                            <a href="javascript:void(0);" id="sct_none">None</a>
                        </span></h2>
                </div>
                <div class="box-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <input class="schCategory" <?php echo in_array('TUITION', $sent_categories) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="sent_category[]" id="s_tuition" value="TUITION">&nbsp;<label class="normal" for="s_tuition">TUITION</label><br />

                            <input class="schCategory" <?php echo in_array('TRANSPORTATION', $sent_categories) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="sent_category[]" id="s_transportation" value="TRANSPORTATION">&nbsp;<label class="normal" for="s_transportation">TRANSPORTATION</label><br />

                            <input class="schCategory" <?php echo in_array('ACCOMODATION', $sent_categories) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="sent_category[]" id="s_accomodation" value="ACCOMODATION">&nbsp;<label class="normal" for="s_accomodation">ACCOMODATION</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title width-full">Category ( Received )
                        <span class="pull-right sort-text">
                            <a href="javascript:void(0);" id="ct_all">All</a> -
                            <a href="javascript:void(0);" id="ct_none">None</a>
                        </span></h2>
                </div>
                <div class="box-body">

                    <div class="row">
                        <div class="col-sm-4 col-md-3">
                            <input class="chCategory" <?php echo in_array('HEALTH & SAFETY', $categories) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="category[]" id="s_healthsafety" value="HEALTH & SAFETY">&nbsp;<label class="normal" for="s_healthsafety">HEALTH & SAFETY</label><br />
                            <input class="chCategory" <?php echo in_array('ATTRACTION', $categories) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="category[]" id="s_attraction" value="ATTRACTION">&nbsp;<label class="normal" for="s_attraction">ATTRACTION</label><br />
                            <input class="chCategory" <?php echo in_array('BULLYING', $categories) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="category[]" id="s_bullying" value="BULLYING">&nbsp;<label class="normal" for="s_bullying">BULLYING</label><br />
                            <input class="chCategory" <?php echo in_array('CUSTOMER CARE', $categories) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="category[]" id="s_customercare" value="CUSTOMER CARE">&nbsp;<label class="normal" for="s_customercare">CUSTOMER CARE</label><br />
                            <input class="chCategory" <?php echo in_array('FACILITIES', $categories) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="category[]" id="s_facilities" value="FACILITIES">&nbsp;<label class="normal" for="s_facilities">FACILITIES</label><br />
                        </div>
                        <div class="col-sm-4 col-md-3">

                            <input class="chCategory" <?php echo in_array('TRANSPORTATION', $categories) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="category[]" id="s_transportaion" value="TRANSPORTATION">&nbsp;<label class="normal" for="s_transportaion">TRANSPORTATION</label><br />
                            <input class="chCategory" <?php echo in_array('CATERING', $categories) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="category[]" id="s_catering" value="CATERING">&nbsp;<label class="normal" for="s_catering">CATERING</label><br />
                            <input class="chCategory" <?php echo in_array('HOME STAY', $categories) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="category[]" id="s_homestay" value="HOME STAY">&nbsp;<label class="normal" for="s_homestay">HOME STAY</label><br />
                            <input class="chCategory" <?php echo in_array('ACTIVITY ON CAMPUS', $categories) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="category[]" id="s_avtivityoncampus" value="ACTIVITY ON CAMPUS">&nbsp;<label class="normal" for="s_avtivityoncampus">ACTIVITY ON CAMPUS</label><br />
                            <input class="chCategory" <?php echo in_array('PLUS STAFF', $categories) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="category[]" id="s_plusstaff" value="PLUS STAFF">&nbsp;<label class="normal" for="s_plusstaff">PLUS STAFF</label><br />

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">Others</h2>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-4">
                            <label class="width-175">Priority<span class="pull-right sort-text text-normal">
                                    <a href="javascript:void(0);" id="bk_all">All</a> -
                                    <a href="javascript:void(0);" id="bk_none">None</a>
                                </span></label><br />
                            <input class="chPriority" <?php echo in_array('low', $priorities) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="priority[]" id="s_low" value="low"><label class="normal" for="s_low"><span style="color:#05ca05">&nbsp;Low</span></label>
                            <input class="chPriority" <?php echo in_array('medium', $priorities) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="priority[]" id="s_medium" value="medium"><label class="normal" for="s_medium"><span style="color:#d0c100">&nbsp;Medium</span></label>
                            <input class="chPriority" <?php echo in_array('high', $priorities) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="priority[]" id="s_high" value="high"><label class="normal" for="s_high"><span style="color:#FF0000">&nbsp;High</span></label>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <label>Ticket status</label><br />
                            <input class="chStatus" <?php echo in_array(0, $status) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="status[]" id="s_open" value="0"><label class="normal" for="s_open"><span style="color:#05ca05">&nbsp;Open</span></label>&nbsp;&nbsp;
                            <input class="chStatus" <?php echo in_array(1, $status) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="status[]" id="s_closed" value="1"><label class="normal" for="s_closed"><span style="color:#FF0000">&nbsp;Closed</span></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Ticket type</label><br />
                            <input class="chType" <?php echo in_array('Campus Manager', $type) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="type[]" id="s_cm" value="Campus Manager"><label class="normal" for="s_campus"><span style="color:#05ca05">&nbsp;Campus Manager</span></label>&nbsp;&nbsp;
                            <input class="chType" <?php echo in_array('Course Director', $type) ? 'checked' : ''; ?> type="checkbox" autocomplete="off" name="type[]" id="s_cd" value="Course Director"><label class="normal" for="s_course"><span style="color:#FF0000">&nbsp;Course Director</span></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-4">
                            <label>Hours passed since received</label>
                            <select class="form-control" id="selHours" name="selHours">
                                <option value="">All</option>
                                <option <?php echo $hour == 1 ? 'selected="selected"' : ''; ?> value="1">1 Hour</option>
                                <option <?php echo $hour == 2 ? 'selected="selected"' : ''; ?> value="2">2 Hours</option>
                                <option <?php echo $hour == 3 ? 'selected="selected"' : ''; ?> value="3">3 Hours</option>
                                <option <?php echo $hour == 4 ? 'selected="selected"' : ''; ?> value="4">4 Hours</option>
                                <option <?php echo $hour == 5 ? 'selected="selected"' : ''; ?> value="5">5 Hours</option>
                                <option <?php echo $hour == 6 ? 'selected="selected"' : ''; ?> value="6">6 Hours</option>
                                <option <?php echo $hour == 7 ? 'selected="selected"' : ''; ?> value="7">7 Hours</option>
                                <option <?php echo $hour == 8 ? 'selected="selected"' : ''; ?> value="8">8 Hours</option>
                                <option <?php echo $hour == 9 ? 'selected="selected"' : ''; ?> value="9">9 Hours</option>
                                <option <?php echo $hour == 10 ? 'selected="selected"' : ''; ?> value="10">10 Hours</option>
                                <option <?php echo $hour == 11 ? 'selected="selected"' : ''; ?> value="11">11 Hours</option>
                                <option <?php echo $hour == 12 ? 'selected="selected"' : ''; ?> value="12">12 Hours</option>
                                <option <?php echo $hour == 24 ? 'selected="selected"' : ''; ?> value="24">24 Hours</option>
                                <option <?php echo $hour == 48 ? 'selected="selected"' : ''; ?> value="48">48 Hours</option>
                                <option <?php echo $hour == 49 ? 'selected="selected"' : ''; ?> value="49">More than 48 hours</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <label>Date field</label>
                            <input type="text" class="form-control" readonly id="dateFiled" name="dateFiled" value="<?php echo $dateFiled ? $dateFiled : '' ?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row margin-5">
        <div class="col-md-12 text-right" id="searchTable">
            <input type="submit" name="inTktFltr" id="inTktFltr" value="Retrieve Tickets" class="btn btn-primary" />&nbsp;<input type="reset" id="resetForm" value="Reset" class="btn btn-danger" />
        </div>
    </div>
</form>
<div class="row" id="filterTable">
    <div class="col-md-12">

        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title">Ticket Details</h2>
            </div>
            <div class="box-body">

                <div id="content">
                    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                        <li class="active"><a href="#received" data-toggle="tab">Received</a></li>
                        <li><a href="#sent" data-toggle="tab">Sent</a></li>
                    </ul>
                    <div id="my-tab-content" class="tab-content ticket-tab-content">

                        <div class="tab-pane active" id="received">
                            <table class="datatable table table-bordered table-hover width-full vertical-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Campus</th>
                                        <th>Type</th>
                                        <th>Priority</th>
                                        <th>Category</th>
                                        <th>Title</th>
                                        <th>Date/Time</th>
                                        <th>Reference booking</th>
                                        <th class="no-sort">From CM</th>
                                        <th class="no-sort">BO Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($tickets) {
                                        $count = 1;
                                        foreach ($tickets as $row) {
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
                                        <div class="modal fade" id="dialog_modal_<?php echo $row["ptc_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Ticket Details - <?php echo htmlspecialchars($row['ptc_title']); ?></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Priority: </strong><?php echo $row['ptc_priority']; ?></p>
                                                        <p><strong>Category: </strong><?php echo $row['ptc_category']; ?></p>
                                                        <p><strong>Title: </strong><?php echo $row['ptc_title']; ?></p>
                                                        <p><strong>Text: </strong><?php echo $row['ptc_content']; ?></p>
                                                        <p><strong>Reference booking: </strong><?php echo $row['ptc_ref_booking']; ?></p>
                                                        <?php echo $row['ptc_attachment'] ? '<p><strong>Attachment: </strong><a href="' . TICKET_CM_DWNLD . $row['ptc_attachment'] . '"><i class="glyphicon glyphicon-paperclip"></i></a></p>' : ''; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $row['nome_centri'] ? $row['nome_centri'] : 'ALL'; ?></td>
                                            <td><?php echo $row['ptc_sender_type']; ?></td>
                                            <td><?php echo $row['ptc_priority']; ?></td>
                                            <td><?php echo $row['ptc_category']; ?></td>
                                            <td><?php echo $row['ptc_title']; ?></td>
                                            <td><?php echo date('d M, Y H:i',strtotime($row['ptc_created_time'])); ?></td>
                                            <td class="text-center"><?php echo $row['ptc_ref_booking']; ?></td>
                                            <td style="white-space: nowrap;" class="text-center operation">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" class="tktOpenClass btn btn-info btn-xs" data-toggle="modal" data-target="#dialog_modal_<?php echo $row["ptc_id"] ?>" id="tktOpn_<?php echo $row["ptc_id"] ?>" data-type="received"><span class="fa fa-eye" data-toggle="tooltip" title="View details" ></span></a><?php echo $row['ptc_attachment'] ? '<a href="' . TICKET_CM_DWNLD . $row['ptc_attachment'] . '" target="_blank" class="CMAtch btn btn-xs btn-warning" data-id="CMVw_' . $row["ptc_id"] . '" data-type="received"><i class="fa fa-paperclip"  data-toggle="tooltip" title="Attachment"></i></a>' : ''; ?>
                                                </div>
                                                <?php echo $row['ptc_bo_read'] == 0 ? '<span class="text-red font-10 faa-flash animated fa fa-envelope notif-tkt" id="new_' . $row["ptc_id"] . '"></span>' : '' ?>
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center operation">
                                                <?php
                                                if ($row['ptc_bo_reply']) {
                                                    ?>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-info" data-toggle="modal" data-target="#dialog_modal_rply_<?php echo $row["ptc_id"] ?>"  id="tktRplyOpn_<?php echo $row["ptc_id"] ?>"><span class="fa fa-eye " data-toggle="tooltip" title="View reply" ></span></a><?php echo $row['ptc_bo_attachment'] ? '<a href="' . TICKET_BO_DWNLD . $row['ptc_bo_attachment'] . '" target="_blank" class="btn btn-xs btn-warning"><i class="fa fa-paperclip"  data-toggle="tooltip" title="Reply attachment"></i></a>' : ''; ?>
                                                        <?php
                                                    } else {
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
                            </table>
                        </div>

                        <div class="tab-pane" id="sent">
                            <table class="datatable table table-bordered table-hover width-full vertical-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Campus</th>
                                        <th>Type</th>
                                        <th>Priority</th>
                                        <th>Category</th>
                                        <th>Title</th>
                                        <th>Date/Time</th>
                                        <th>Reference booking</th>
                                        <th class="no-sort">Action</th>
                                        <th class="no-sort">Reply</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($sent_tickets) {
                                        $count = 1;
                                        foreach ($sent_tickets as $row) {
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
                                        <div class="modal fade" id="dialog_modal_<?php echo $row["ptc_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Ticket Details - <?php echo htmlspecialchars($row['ptc_title']); ?></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Priority: </strong><?php echo $row['ptc_priority']; ?></p>
                                                        <p><strong>Category: </strong><?php echo $row['ptc_category']; ?></p>
                                                        <p><strong>Title: </strong><?php echo $row['ptc_title']; ?></p>
                                                        <p><strong>Text: </strong><?php echo $row['ptc_content']; ?></p>
                                                        <p><strong>Reference booking: </strong><?php echo $row['ptc_ref_booking']; ?></p>
                                                        <?php echo $row['ptc_attachment'] ? '<p><strong>Attachment: </strong><a href="' . TICKET_CM_DWNLD . $row['ptc_attachment'] . '"><i class="glyphicon glyphicon-paperclip"></i></a></p>' : ''; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $row['nome_centri'] ? $row['nome_centri'] : 'ALL'; ?></td>
                                            <td><?php echo $row['ptc_receiver_type']; ?></td>
                                            <td><?php echo $row['ptc_priority']; ?></td>
                                            <td><?php echo $row['ptc_category']; ?></td>
                                            <td><?php echo $row['ptc_title']; ?></td>
                                            <td><?php echo date('d M, Y H:i',strtotime($row['ptc_created_time'])); ?></td>
                                            <td class="text-center"><?php echo $row['ptc_ref_booking']; ?></td>
                                            <td style="white-space: nowrap;" class="text-center operation">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" class="btn btn-info btn-xs" data-toggle="modal" data-target="#dialog_modal_<?php echo $row["ptc_id"] ?>" id="tktOpn_<?php echo $row["ptc_id"] ?>"><span class="fa fa-eye" data-toggle="tooltip" title="View details" ></span></a><?php echo $row['ptc_attachment'] ? '<a href="' . TICKET_CM_DWNLD . $row['ptc_attachment'] . '" target="_blank" class="btn btn-xs btn-warning"><i class="fa fa-paperclip"  data-toggle="tooltip" title="Attachment"></i></a>' : ''; ?>
                                                </div>
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center operation">
                                                <?php
                                                if ($row['ptc_bo_reply']) {
                                                    ?>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="tktOpenClass btn btn-xs btn-info" data-toggle="modal" data-target="#dialog_modal_rply_<?php echo $row["ptc_id"] ?>"  id="tktOpn_<?php echo $row["ptc_id"] ?>" data-type="sent"><span class="fa fa-eye " data-toggle="tooltip" title="View reply" ></span></a><?php echo $row['ptc_bo_attachment'] ? '<a href="' . TICKET_BO_DWNLD . $row['ptc_bo_attachment'] . '" target="_blank" class="CMAtch btn btn-xs btn-warning" data-id="CMVw_' . $row["ptc_id"] . '"><i class="fa fa-paperclip"  data-toggle="tooltip" title="Reply attachment"  data-type="sent"></i></a>' : ''; ?>

                                                    </div>
                                                    <?php echo $row['ptc_cm_read'] == 0 ? '<span class="text-red font-10 faa-flash animated fa fa-envelope notif-tkt" id="new_' . $row["ptc_id"] . '"></span>' : '' ?>
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
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<script>
    $(document).ready(function () {
        $('#tabs').tab();

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        $('input[type="checkbox"]').iCheck({checkboxClass: 'icheckbox_square-blue'});
        $("#dateFiled").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            maxDate: "+1Y"
        }).datepicker();

        $("#s_USA").click(function () {
            $("input.chCentri").each(function () {
                $(this).iCheck("uncheck");
            });
            $("input.sel_USD").each(function () {
                $(this).iCheck("check");
            });
        });

        $("#s_UK").click(function () {
            $("input.chCentri").each(function () {
                $(this).iCheck("uncheck");
            });
            $("input.sel_GBP").each(function () {
                $(this).iCheck("check");
            });
        });

        $("#s_EUR").click(function () {
            $("input.chCentri").each(function () {
                $(this).iCheck("uncheck");
            });
            $("input.sel_EUR").each(function () {
                $(this).iCheck("check");
            });
        });
        $("#s_all").click(function () {
            $("input.chCentri").each(function () {
                $(this).iCheck("check");
            });
        });

        $("#s_none").click(function () {
            $("input.chCentri").each(function () {
                $(this).iCheck("uncheck");
            });
        });
        $("#hp_all").click(function () {
            $("input.chHours").each(function () {
                $(this).iCheck("check");
            });
        });

        $("#hp_none").click(function () {
            $("input.chHours").each(function () {
                $(this).iCheck("uncheck");
            });
        });
        $("#bk_all").click(function () {
            $("input.chPriority").each(function () {
                $(this).iCheck("check");
            });
        });

        $("#bk_none").click(function () {
            $("input.chPriority").each(function () {
                $(this).iCheck("uncheck");
            });
        });
        $("#ct_all").click(function () {
            $("input.chCategory").each(function () {
                $(this).iCheck("check");
            });
        });

        $("#ct_none").click(function () {
            $("input.chCategory").each(function () {
                $(this).iCheck("uncheck");
            });
        });

        $("#sct_all").click(function () {
            $("input.schCategory").each(function () {
                $(this).iCheck("check");
            });
        });

        $("#sct_none").click(function () {
            $("input.schCategory").each(function () {
                $(this).iCheck("uncheck");
            });
        });
        window.triggerSubmit = function () {
            $('#inTktFltr').trigger('click');
        }
        $('body').on('click', ".tktRplyClass", function (e) {
            e.preventDefault();

            var selId = $(this).attr('id').replace('tktRply_', '');
            if (selId != '' && typeof selId != 'undefined') {
                $.ajax({
                    type: "POST",
                    data: {
                        selId: selId
                    },
                    url: siteUrl + "ticketmanagement/checkTicketStatus",
                    success: function (response) {
                        if (response == 1) {
                            $.ajax({
                                url: siteUrl + "ticketmanagement/openTicketReply/" + selId,
                                type: 'POST',
                                data: {},
                                success: function (data) {
                                    createModal('ticketReplyModal', 'Reply to ticket', data);
                                    initFileInput();
                                },
                                error: function () {
                                    swal('Error', 'This ticket doesn\'t exists!');
                                }
                            });

                        } else {
                            swal('Error', 'This ticket doesn\'t exists!');
                        }
                    }
                });
            }

        });


        $('body').on('click', '.tktCloseClass', function () {
            var elm = $(this);
            var selId = elm.attr('id').replace('tktClose_', '');
            if (selId != '' && typeof selId != 'undefined') {
                confirmAction('Are you sure to close the ticket?', function (s) {
                    if (s) {
                        $.ajax({
                            url: siteUrl + 'ticketmanagement/changeTicketStatus',
                            type: 'POST',
                            data: {
                                selId: selId
                            },
                            success: function (data) {
                                if (data == 1) {
                                    if (elm.find('span').hasClass('fa-square-o')) {
                                        elm.find('span').removeClass('fa-square-o');
                                        elm.find('span').addClass('fa-check-square-o');
                                        elm.find('span').attr('data-original-title', 'Ticket closed');
                                    } else if (elm.find('span').hasClass('fa-check-square-o')) {
                                        elm.find('span').removeClass('fa-check-square-o');
                                        elm.find('span').addClass('fa-square-o');
                                        elm.find('span').attr('data-original-title', 'Close ticket');
                                    }
                                    elm.removeClass('tktCloseClass');
                                    swal('Success', 'Ticket closed successfully');
                                } else {
                                    swal('Error', 'Failed to close ticket');
                                }
                            },
                            error: function () {
                                swal('Error', 'Failed to close ticket');
                            }
                        });
                    }
                }, true, true);
            }
        });

        function makeReadByBo(selId) {
            if (selId != '' && typeof selId != 'undefined') {
                $.ajax({
                    url: siteUrl + 'ticketmanagement/readByBo',
                    type: 'POST',
                    data: {
                        selId: selId
                    },
                    success: function (data) {
                        if (data == 1) {
                            $('#new_' + selId).remove();
                            checkNewBOAlert();
                        }
                    }
                });
            }
        }

        function makeReadByCm(selId) {
            if (selId != '' && typeof selId != 'undefined') {
                $.ajax({
                    url: siteUrl + 'ticketmanagement/readByCm',
                    type: 'POST',
                    data: {
                        selId: selId
                    },
                    success: function (data) {
                        if (data == 1) {
                            $('#new_' + selId).remove();
                            checkNewBOAlert();
                        }
                    }
                });
            }
        }

        $('body').on('click', '.CMAtch', function () {
            var selId = $(this).attr('data-id').replace('CMVw_', '');
            var type = $(this).attr('data-type');
            if (type == 'received')
                makeReadByBo(selId);
            else
                makeReadByCm(selId);
        });

        $('body').on('click', '.tktOpenClass', function () {
            var selId = $(this).attr('id').replace('tktOpn_', '');
            var type = $(this).attr('data-type');
            if (type == 'received')
                makeReadByBo(selId);
            else
                makeReadByCm(selId);
        });


    });
    $('body').on('click', '#resetForm', function (e) {
        e.preventDefault();
        window.location.href = "<?php echo site_url() ?>/ticketmanagement";
    });
    function checkSubmit() {
        var elm = $('#box_tktFltr');
        var url = elm.attr('action').replace('#filterTable', '');
        elm.attr('action', url + '#filterTable');
        return true;
    }
    $('body').on('submit', '#replyTicketForm', function (e) {
        e.preventDefault();
        var elm = $(this);
        var replyContent = $('#tktMessage').val();
        var ptc_id = $('#ptc_id').val();
        if (replyContent == '' || typeof replyContent == 'undefined') {
            swal('Error', 'Please enter a message');
        } else {
            var data = new FormData($('#replyTicketForm')[0]);
            $.ajax({
                url: siteUrl + 'ticketmanagement/replyTicket/' + ptc_id,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    if (data == 1) {
                        removeModal('ticketReplyModal');
                        window.location.href = "<?php echo site_url() ?>/ticketmanagement";
                    } else {
                        swal('Error', data);
                    }
                },
                error: function () {
                    swal('Error', 'Failed to reply ticket');
                }
            });
        }

    });

    $('.modalRply').on('shown.bs.modal', function () {
        unloading();
    });
    $('body').on('keypress', '.hasDatepicker', function (e)
    {
        var elm = $(this);
        switch (e.keyCode) {
            case 46:  // delete
            case 8:  // backspace
                elm.val('');
                break;
            default:
                e.preventDefault();
                break;
        }
    });

</script>
