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
            $( "li#mnutuition ul.sub li#mnutuition_1" ).addClass("current");	
            
            
            $.validator.addMethod("alphanumericwithspace", function(value, element) {
                return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
            }, "Only letters, numbers, or dashes are allowed.");
            
            $.validator.addMethod("nonzero", function(value, element) {
                if(value > 0)
                    return true;
                else
                    return false;
            }, "Total hours should not be zero(0)");
            
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
                    <form method="post" class="validate" id="frmCourse" action="">
                        <div class="row">
                                <label for="selCampus" style="width: 115px;">
                                    <strong>Campus</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;width:200px;">
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
                                <label for="txtCourseName" style="width: 115px;">
                                        <strong>Course</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                    <input style="width:200px;" type="text" id="txtCourseName" name="txtCourseName"  class="required alphanumericwithspace" value="<?php echo set_value('txtCourseName',  htmlspecialchars_decode($formData['txtCourseName']));?>" >
                                    <div class="error"><?php echo form_error('txtCourseName');?></div>
                                </div>
                        </div>
                        <div class="row">
                                <label for="radCourseType" style="width: 115px;">
                                <strong>Type</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px; padding-top: 20px;">
                                    <input <?php echo ($formData['radCourseType'] == 'Classic' ? "checked='checked'" : '');?> class="required" type="radio" id="radCourseTypeClassic" value="Classic" name="radCourseType" />
                                    <label for="radCourseTypeClassic" style="width: 115px;margin-right: 10px;">Classic</label>
                                    <input <?php echo ($formData['radCourseType'] == 'Zig-Zag' ? "checked='checked'" : '');?> class="required" type="radio" id="radCourseTypeZigZag" value="Zig-Zag" name="radCourseType" />
                                    <label for="radCourseTypeZigZag" style="width: 115px;">Zig-Zag</label>
                                    <div style="margin-top: 0px!important;" class="error"><?php echo form_error('radCourseType');?></div>
                                </div>
                                
                        </div>
                        <div class="row">
                                <label for="txtTotalHours" style="width: 115px;">
                                        <strong>Total hours</strong>
                                </label>
                                <div class="form-data" style="margin-left: 130px;">
                                        <input value="<?php echo set_value('txtTotalHours',$formData['txtTotalHours']);?>" onkeypress="return keyRestrict(event,'1234567890.');"  style="width:75px;" type="text" id="txtTotalHours" name="txtTotalHours" maxlength="5" class="required nonzero">
                                        <div class="error"><?php echo form_error('txtTotalHours');?></div>
                                </div>
                        </div>
                        <div class="row">
                                <div class="form-data" style="margin-left: 130px;">
                                    <input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id;?>" />
                                    <input class="btn btn-tuition" type="submit" id="btnSave" name="btnSave" value="Submit" />
                                    <input class="btn btn-tuition" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url();?>index.php/backoffice/campusCourses'" />
                                    <div style="margin: none!important;"> 
                                        <?php 
                                        $success_message = $this->session->flashdata('success_message');
                                        if(!empty($success_message))
                                        {
                                            ?><div class="tuition_success"><?php echo $success_message;?></div><?php 
                                        }
                                        $error_message = $this->session->flashdata('error_message');
                                        if(!empty($error_message))
                                        {
                                            ?><div class="tuition_error"><?php echo $error_message;?></div><?php 
                                        }
                                    ?>
                                    </div>
                                </div>
                                
                        </div>
                    </form>
                </div><!-- End of .content -->
            </div><!-- End of .box -->
        </div><!-- End of .grid_12 -->

    </section><!-- End of #content -->

</div><!-- End of #main -->

<?php $this->load->view('plused_footer'); ?>