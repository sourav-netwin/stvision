<?php $this->load->view('plused_header'); ?>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix">
    <!-- The blue toolbar stripe -->
    <section class="toolbar">
        <div class="user">
            <div class="avatar">
                <img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
                <!-- Evidenziare per icone attenzione <span>3</span> -->
            </div>
            <span><?php echo $this->session->userdata('businessname') ?></span>
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
                <li class="line"></li>
                <li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
            </ul>
        </div>
    </section><!-- End of .toolbar-->
    <?php $this->load->view('plused_sidebar'); ?>		
    <script>
        $(document).ready(function() {
            $( "li#mnutuition" ).addClass("current");
            $( "li#mnutuition a" ).addClass("open");		
            $( "li#mnutuition ul.sub" ).css('display','block');	
            $( "li#mnutuition ul.sub li#mnutuition_3" ).addClass("current");	
            
            $( "#txtFromDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$(".txtFromDate").val(selectedDate);
                                $( "#txtToDate" ).datepicker( "option", "minDate", selectedDate );
			}
            });
            
            $( "#txtToDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$(".txtToDate").val(selectedDate);
                                $( "#txtFromDate" ).datepicker( "option", "maxDate", selectedDate );
			}
            });
        });
    </script>	

    <!-- Here goes the content. -->
    <section id="content" class="container_12 clearfix" data-sort=true>
        <div class="grid_12">
            <div class="box">

                <div class="header">
                    <h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png"><?php echo $breadcrumb2;?></h2>
                </div>

                <div class="content">
                    <form method="post" class="validate" id="frmTeacher" action="">
                        <div class="row">
                                <label for="selCampus" style="width: 115px;">
                                    <strong>Campus</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                    <select class="required" id="selCampus" name="selCampus"  >
                                        <option value="">Select Campus</option>
                                        <?php if($campusList){
                                                foreach ($campusList as $campus){
                                                    ?><option <?php echo ($formData['selCampus'] == $campus['id'] ? "selected='selected'" : '');?> value="<?php echo $campus['id'];?>"><?php echo $campus['nome_centri'];?></option><?php 
                                                }
                                        }
                                        ?>
                                    </select>
                                    <div class="error"><?php echo form_error('selCampus');?></div>
                                </div>
                        </div>
                        <div class="row">
                                <label for="txtFirstName" style="width: 115px;">
                                        <strong>First name</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input type="text" id="txtFirstName" name="txtFirstName" class="required" style="max-width:255px;"  maxlength="100" value="<?php echo set_value('txtFirstName',  $formData['txtFirstName']);?>" >
                                        <div class="error"><?php echo form_error('txtFirstName');?></div>
                                </div>
                        </div>
                        <div class="row">
                                <label for="txtLastName" style="width: 115px;">
                                        <strong>Last name</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input type="text" id="txtLastName" name="txtLastName" class="required" style="max-width:255px;"  maxlength="100" value="<?php echo set_value('txtLastName',  $formData['txtLastName']);?>" >
                                        <div class="error"><?php echo form_error('txtLastName');?></div>
                                </div>
                        </div>
                        
                        <div class="row">
                                <label for="txtHoursPerDay" style="width: 115px;">
                                        <strong>Hours per day</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input type="text" id="txtHoursPerDay" name="txtHoursPerDay" class="required" onkeypress="return keyRestrict(event,'1234567890.');"  style="width:75px;"  maxlength="5" value="<?php echo set_value('txtHoursPerDay',  $formData['txtHoursPerDay']);?>" >
                                        <div class="error"><?php echo form_error('txtHoursPerDay');?></div>
                                </div>
                        </div>
                        <div class="row">
                                <label for="txtFromDate" style="width: 115px;">
                                        <strong>From date</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input value="<?php echo set_value('txtFromDate',date('d/m/Y',strtotime($formData['txtFromDate'])));?>" onkeypress="return keyRestrict(event,'1234567890/');"  style="width:100px;" type="text" id="txtFromDate" name="txtFromDate" class="required">
                                        <div class="error"><?php echo form_error('txtFromDate');?></div>
                                </div>
                        </div>
                        
                        <div class="row">
                                <label for="txtToDate" style="width: 115px;">
                                        <strong>To date</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input value="<?php echo set_value('txtToDate',date('d/m/Y',strtotime($formData['txtToDate'])));?>"  style="width:100px;" onkeypress="return keyRestrict(event,'1234567890/');" type="text" id="txtToDate" name="txtToDate" class="required">
                                        <div class="error"><?php echo form_error('txtToDate');?></div>
                                </div>
                        </div>
                        <div class="row">
                                <div class="form-data" style="margin-left: 130px;">
                                    <input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id;?>" />
                                    <input class="btn btn-tuition" type="submit" id="btnSave" name="btnSave" value="Submit" />
                                    <input class="btn btn-tuition" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url();?>index.php/teachers'" />
                                </div>
                        </div>
                    </form>
                </div><!-- End of .content -->
            </div><!-- End of .box -->
        </div><!-- End of .grid_12 -->

    </section><!-- End of #content -->

</div><!-- End of #main -->

<?php $this->load->view('plused_footer'); ?>