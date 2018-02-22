<div id="dialog_modal_<?php echo $value['jof_id'] ?>" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button aria-label="Close" onclick="$('#dialog_modal_<?php echo $value['jof_id'] ?>').modal('hide');"  class="close" type="button">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Job History - <?php echo htmlspecialchars($value['ta_firstname'] . ' ' . $value['ta_lastname']) ?></h4>
        </div>
        <div class="modal-body">
            <div class="detailContainer">
                <div class="row">
                    <div class="col-sm-3"><strong>Applicant name:</strong></div>
                    <div class="col-sm-3"><?php echo html_entity_decode($value['ta_firstname'] . ' ' . $value['ta_lastname']); ?></div>

                    <div class="col-sm-3"><strong>Position:</strong></div>
                    <div class="col-sm-3"><?php echo $value['pos_position']; ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><strong>Type:</strong></div>
                    <div class="col-sm-3"><?php echo $value['jof_teacher_type']; ?></div>

                    <div class="col-sm-3"><strong>Currency:</strong></div>
                    <div class="col-sm-3"><?php echo $value['jof_currency']; ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><strong>Rate:</strong></div>
                    <div class="col-sm-3"><?php echo $value['jof_rates']; ?></div>

                    <div class="col-sm-3"><strong>Wage:</strong></div>
                    <div class="col-sm-3"><?php echo $value['jof_wages']; ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><strong>Offer letter:</strong></div>
                    <div class="col-sm-9 hlt-link"><?php echo $value['job_offer_file'] ? '<a class="underline" target="_blank" href="' . base_url() . SENT_JOB_OFFER_PATH . $value['job_offer_file'] . '">' . $value['job_offer_file'] . '</a>' : '' ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><strong>Offer date:</strong></div>
                    <div class="col-sm-9"><?php echo date('d/m/Y', strtotime($value['jof_created_on'])) ?></div>
                </div>
            </div>
        </div>
        <div class="modal-header">
            <h4 class="modal-title">Teachers detail</h4>
        </div>
        <div class="modal-body detailContainer">
            <div id="teacherDetail_<?php echo $value['jof_id'] ?>"></div>
        </div>
        </div>
    </div>
    </div>