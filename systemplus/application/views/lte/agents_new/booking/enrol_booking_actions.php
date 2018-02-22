<?php $locked = $this->agent_roster_model->checkAnyPaxLocked($enroll_id); ?>
<div class="btn-group custom-btn-group">

    <span data-toggle="tooltip" data-original-title="View booking detail" class="span-action">
        <a href="javascript:void(0);" class="btn btn-xs btn-info min-wd-20 booking_modal" data-id="<?php echo $enroll_id ?>">
            <i class="fa fa-eye"></i>
        </a>
    </span><span data-toggle="tooltip" data-original-title="Edit booking" class="span-action"><?php if (!$locked) { ?>
            <a href="<?php echo base_url() ?>index.php/agentbooking/enrol/<?php echo $enroll_id ?>" class="btn btn-xs btn-success min-wd-20">
                <i class="fa fa-edit"></i>
            </a>
        <?php } else { ?>
            <a href="javascript:void(0);" class="btn btn-xs btn-success min-wd-20" disabled>
                <i class="fa fa-edit"></i>
            </a>
        <?php } ?>
    </span><span data-toggle="tooltip" class="span-action" data-original-title="View booking invoice">
        <a href="<?php echo base_url() . 'index.php/packages/bookinginvoice/' . $enroll_id; ?>" class="btn btn-xs btn-primary min-wd-20 booking_modal">
            <i class="fa fa-file-pdf-o"></i>
        </a>
    </span><?php
    if ($status == 3) {
        if ($enrol_lock_pax == 0) { 
            ?><span data-toggle="tooltip" class="span-action" data-original-title="Insert pax details">
                <a href="<?php echo base_url() . 'index.php/packages/bookinginvoice/' . $enroll_id; ?>" class="btn btn-xs btn-warning min-wd-20 insertPaxList" id="compile_<?php echo date('Y', strtotime($enrol_created_on)) ?>_<?php echo $enroll_id ?>">
                    <i class="fa fa-list"></i>
                </a>
            </span><?php } else {  ?><span data-toggle="tooltip" class="span-action">
                <a href="javascript:void(0);" class="btn btn-xs btn-warning min-wd-20">
                    <i class="fa fa-check"></i>
                </a>
            </span><?php
        }
    }
    ?><span data-toggle="tooltip" class="span-action" data-original-title="Visa details">
        <a href="javascript:void(0);" class="btn btn-xs btn-default min-wd-20 visaPopup" data-id="<?php echo $enroll_id ?>">
            <i class="glyphicon glyphicon-new-window"></i>
        </a>
    </span>
</div>