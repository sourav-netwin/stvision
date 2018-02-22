<script>
    $(document).ready(function() {
        $( ".dialogjobofferbtnview" ).click(function() {
                var iddia = $(this).attr("id").replace('_btn','');
                $("#jobTeacherHistory").html($( "#"+iddia ).html());
                $("#modal_teacher_job_history").modal('show');
                return false;
        });

      /*  $( ".jobofferdetailview" ).dialog({
                autoOpen: false,
                modal: true,
                buttons: [{
                        text: "Close",
                        click: function() { $(this).dialog("close"); }
                }]
        });
        
        $( ".windia-presence" ).dialog({
                autoOpen: false,
                modal: true,
                hide: "",
                show: "",
                width : 500,
                height : 635,
                buttons: [{
                        text: "Close",
                        click: function() { $(this).dialog("close"); }
                }]
        });
        // ! Table
        // Initialize DataTables for dynamic tables
        //$('table.dynamicJoboffer').table();
        */
       initDataTable("dynamicJoboffer");
    });
</script>

<!--<table class="dynamicJoboffer styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'>  OPTIONAL: with-prev-next -->
    <table id="dynamicJoboffer" class="dynamicJoboffer datatable table table-bordered table-striped vertical-middle" width="99.9%" >
    <thead>
        <tr>
            <th>Applicant name</th>
            <th>Position</th>
            <th>Type</th>
            <th>Offer document</th>
            <th class="no-sort">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($jobOfferHistory)
            foreach ($jobOfferHistory as $joboffer) {
            
            $currency_code = $joboffer['jof_currency'];
            $currency = "";
            if($currency_code == "EUR")
                $currency = "&euro;";
            else if($currency_code == "GBP")
                $currency = "&pound;";
            else if($currency_code == "USD")
                $currency = "$";
            
            //jof_id,class_campus_course_id,class_date,joboffer_name,class_name,cc_campus_id,cc_course_type,nome_centri
                ?>
                <tr>
                    <td class="center">
                        <?php echo html_entity_decode($joboffer["applicant_name"]); ?>
                        <div style="display: none;" id="dialog_modal_tech_<?php echo $joboffer['jof_id'] ?>">
                            <p><strong>Applicant name: </strong><?php echo html_entity_decode($joboffer["applicant_name"]); ?></p>
                            <p><strong>Position: </strong><?php echo $joboffer["pos_position"]; ?></p>
                            <p><strong>Currency: </strong><?php echo $joboffer["jof_currency"]; ?></p>
                            <p><strong>Type: </strong><?php echo $joboffer["jof_teacher_type"]; ?></p>
                            <p><strong>Wages: </strong><?php echo $joboffer["jof_wages"]; ?></p>
                            <p><strong>Rate: </strong><?php echo $currency.$joboffer["jof_rates"]; ?></p>
                            <p><strong>Residential: </strong><?php echo $joboffer["jof_residential"]; ?></p>
                            <p><strong>Offer date: </strong><?php echo date('d/m/Y', strtotime($joboffer["jof_created_on"])); ?></p>
                            <p class="hlt-link"><strong>Offer document: </strong><a target="_blank" href="<?php echo base_url().SENT_JOB_OFFER_PATH . $joboffer['job_offer_file']; ?>"><?php echo $joboffer['job_offer_file'];?></a></p>
                        </div>
                    </td>
                    <td class="center"><?php echo $joboffer["pos_position"]; ?></td>
                    <td class="center"><?php echo $joboffer["jof_teacher_type"]; ?></td>
                    <td class="center hlt-link"><a target="_blank" href="<?php echo base_url().SENT_JOB_OFFER_PATH . $joboffer['job_offer_file']; ?>"><?php echo $joboffer['job_offer_file'];?></a></td>
                    <td class="center operation">
                        <a title="View" href="javascript:void(0);" data-toggle="tooltip"  id="dialog_modal_tech_btn_<?php echo $joboffer["jof_id"]; ?>" class="min-wd-24 dialogjobofferbtnview btn btn-xs btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a title="Add to contract" data-toggle="tooltip"  href="<?php echo base_url();?>index.php/contract/addedit/contract/<?php echo $joboffer['jof_teacher_app_id'] ?>" class="min-wd-24 btn btn-xs btn-warning">
                            <i class="fa fa-copy"> Contract</i>
                        </a>
                    </td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>
<div id="modal_teacher_job_history" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button aria-label="Close" onclick="$('#modal_teacher_job_history').modal('hide');$('body').addClass('modal-open');"  class="close" type="button">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Job offer detail</h4>
        </div>
        <div id="jobTeacherHistory" class="modal-body">
            
        </div>
        <div class="modal-footer">
        </div>
        <!-- /.modal-content -->
        </div>
    <!-- /.modal-dialog -->
    </div>
</div>