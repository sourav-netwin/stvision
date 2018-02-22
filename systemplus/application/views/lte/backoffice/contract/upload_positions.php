<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header with-border">
				<h2 class="box-title"><?php echo $breadcrumb2; ?></h2>
			</div>
			<div class="box-body">
                            <?php showSessionMessageIfAny($this);?>
                            <form method="post" enctype="multipart/form-data" id="frmUploadNewPosition" action="<?php echo base_url().'index.php/teachers/uploadposition';?>">
                                <div class="row form-group">
                                        <div class="col-md-3">
                                                <label >
                                                        <strong>Select file</strong>
                                                </label>
                                        </div>
                                        <div class="form-data col-md-5">
                                            <input type="file" class="" id="fileNewPosition" name="fileNewPosition" />
                                            <?php 
                                                if (file_exists(SENT_JOB_OFFER_PATH . "job_adv_offer.pdf")) {
                                                    echo "<a href='" . base_url().SENT_JOB_OFFER_PATH . "job_adv_offer.pdf' target='_blank' >Click here to see uploaded file</a>";
                                                }
                                                ?>
                                        </div>
                                </div>
                                <div class="row form-group">
                                        <div class="col-md-3 col-md-offset-3" >
                                                <input class="btn btn-sm btn-primary" type="submit" id="btnUpload" name="btnUpload" value="Upload" />
                                        </div>
                                </div>
                                <div class="row">
                                    <div class="form-data col-md-offset-3 col-md-5">
                                        <?php 
                                            if(!empty($fileError)){
                                            ?>
                                                <div class="tuition_error">
                                                    <?php 
                                                        echo $fileError;
                                                    ?>
                                                </div>
                                            <?php 
                                            }
                                        ?>
                                    </div>
                                </div>
                            </form>
			</div><!-- End of .content -->
		</div><!-- End of .box -->
	</div><!-- End of .col-md-12 -->
</div>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script>
	var pageHighlightMenu = "teacher/uploadposition";
	$(document).ready(function() {
            $("#frmUploadNewPosition").validate({
                    errorElement:"div",
                    ignore: "",
                    rules: {
                            fileNewPosition: "required"
                    },
                    messages: {
                            fileNewPosition: "Please select new positions(pdf) file to upload"
                    },
                    submitHandler: function(form) {
                            form.submit();
                    }
            });
        });
</script>	
