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
            $( "li#mnutuition ul.sub li#mnutuition_2" ).addClass("current");	
            
            $( "#txtAllotmentFromDate" ).datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,		  
                    dateFormat: "dd/mm/yy",		
                    numberOfMonths: 1,
                    onClose: function( selectedDate ) {
                        $( "#txtAllotmentToDate" ).datepicker( "option", "minDate", selectedDate );
                    }
            });
            
            $( "#txtAllotmentToDate" ).datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "dd/mm/yy",		
                    numberOfMonths: 1,
                    onClose: function( selectedDate ) {
                        $( "#txtAllotmentFromDate" ).datepicker( "option", "maxDate", selectedDate );
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
                    <form method="post" class="validate" id="frmRooms" action="">
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
                                <label for="txtNumberOfRooms" style="width: 115px;">
                                        <strong>Number of rooms</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input type="text" id="txtNumberOfRooms" name="txtNumberOfRooms" class="required" onkeypress="return keyRestrict(event,'1234567890');"  style="width:75px;"  maxlength="5" value="<?php echo set_value('txtNumberOfRooms',  $formData['txtNumberOfRooms']);?>" >
                                        <div class="error"><?php echo form_error('txtNumberOfRooms');?></div>
                                </div>
                        </div>
                        <div class="row">
                                <label for="txtNumberOfStudents" style="width: 115px;">
                                        <strong>Number of students / room</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input value="<?php echo set_value('txtNumberOfStudents',$formData['txtNumberOfStudents']);?>" onkeypress="return keyRestrict(event,'1234567890');"  style="width:75px;" type="text" id="txtNumberOfStudents" name="txtNumberOfStudents" maxlength="5" class="required">
                                        <div class="error"><?php echo form_error('txtNumberOfStudents');?></div>
                                </div>
                        </div>
                        <div class="row">
                                <label for="txtAllotmentFromDate" style="width: 115px;">
                                        <strong>Allotment from date</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input value="<?php echo set_value('txtAllotmentFromDate',date('d/m/Y',strtotime($formData['txtAllotmentFromDate'])));?>"  style="width:100px;" onkeypress="return keyRestrict(event,'1234567890/');"  type="text" id="txtAllotmentFromDate" name="txtAllotmentFromDate" class="required">
                                        <div class="error"><?php echo form_error('txtAllotmentFromDate');?></div>
                                </div>
                        </div>
                        <div class="row">
                                <label for="txtAllotmentToDate" style="width: 115px;">
                                        <strong>Allotment to date</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input value="<?php echo set_value('txtAllotmentToDate',date('d/m/Y',strtotime($formData['txtAllotmentToDate'])));?>"  style="width:100px;" onkeypress="return keyRestrict(event,'1234567890/');"  type="text" id="txtAllotmentToDate" name="txtAllotmentToDate" class="required">
                                        <div class="error"><?php echo form_error('txtAllotmentToDate');?></div>
                                </div>
                        </div>
                        <div class="row">
                                <div class="form-data" style="margin-left: 130px;">
                                    <input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id;?>" />
                                    <input class="btn btn-tuition" type="submit" id="btnSave" name="btnSave" value="Submit" />
                                    <input class="btn btn-tuition" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url();?>index.php/campusrooms'" />
                                </div>
                        </div>
                    </form>
                </div><!-- End of .content -->
            </div><!-- End of .box -->
        </div><!-- End of .grid_12 -->

    </section><!-- End of #content -->

</div><!-- End of #main -->

<?php $this->load->view('plused_footer'); ?>