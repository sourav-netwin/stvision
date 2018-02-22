<script>
    $(document).ready(function() {
        $( ".dialogjobofferbtnview" ).click(function() {
                var iddia = $(this).attr("id").replace('_btn','');
                //alert(iddia.replace('_btn',''));
                $( "#"+iddia ).dialog("open");
                return false;
        });

        $( ".jobofferdetailview" ).dialog({
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
        $('table.dynamicJoboffer').table();
    });
</script>

<table class="dynamicJoboffer styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
    <thead>
        <tr>
            <th style="border-left: 1px solid #ccc;">Applicant name</th>
            <th>Position</th>
            <th>Type</th>
            <th>Offer document</th>
            <th>Action</th>
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
                        <div style="display: none;" id="dialog_modal_tech_<?php echo $joboffer['jof_id'] ?>" title="Job offer detail"  class="jobofferdetailview">
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
                        <a title="View" href="javascript:void(0);" id="dialog_modal_tech_btn_<?php echo $joboffer["jof_id"]; ?>" class="dialogjobofferbtnview">
                            <span class="icon-eye-open"></span>
                        </a>
                        <a title="Add to contract" href="<?php echo base_url();?>index.php/contract/addedit/contract/<?php echo $joboffer['jof_teacher_app_id'] ?>" data-id="<?php echo $joboffer['jof_teacher_app_id'] ?>" >
                                <span class="icon-copy"> Contract</span>
                        </a>
<!--                        <a title="Delete" class="deletejoboffer" data-id="<?php //echo $joboffer['jof_id'];?>" href="javascript:void(0);">
                            <span class="icon-remove"></span>
                        </a>-->
                    </td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>