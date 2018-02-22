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
            <span><?php echo $this->session->userdata('businessname'); ?></span>
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/survey/profile">Profile</a></li>
                <li class="line"></li>
                <li><a href="<?php echo base_url(); ?>index.php/survey/logout">Logout</a></li>
            </ul>
        </div>
    </section><!-- End of .toolbar-->
    <?php $this->load->view('plused_sidebar');?>		
    <script>
        $(document).ready(function() {
            $( "li#takethesurvey" ).addClass("current");
            $( "li#takethesurvey a" ).addClass("open");		
            $( "li#takethesurvey ul.sub" ).css('display','block');	
            <?php if($reportType == 'Report 1'){?>
            $( "li#takethesurvey ul.sub li#takethesurvey_1" ).addClass("current");	
            <?php }elseif($reportType == 'Report 2'){?>
            $( "li#takethesurvey ul.sub li#takethesurvey_2" ).addClass("current");	
            <?php }?>
            
            
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
                    <div class="survey-message">
                        <p>
                            <?php echo $surveyMessage;?>
                        </p>
                    </div>
                <div class="alert information sticky bottom no-margin"><!-- span class="icon"></span>If you need any <strong>help</strong> just send us a mail at <a class="hlt-link-a" style="color: white!important;" href="mailto:recruitment@plus-ed.com">recruitment@plus-ed.com</a -->&nbsp;</div>
                </div><!-- End of .content -->

            </div><!-- End of .box -->

        </div>
    </section><!-- End of #content -->

</div><!-- End of #main -->
<?php $this->load->view('plused_footer'); ?>
