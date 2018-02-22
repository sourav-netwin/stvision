<?php $this->load->view('plused_header'); ?>
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
                <?php if($this->session->userdata('role') == 400){?>
                <li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
                <li class="line"></li>
                <li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
                <?php }else{?>
                <li><a href="<?php echo base_url(); ?>index.php/users/profile">Profile</a></li>
                <li class="line"></li>
                <li><a href="<?php echo base_url(); ?>index.php/users/logout">Logout</a></li>
                <?php }?>
            </ul>
        </div>
    </section><!-- End of .toolbar-->
    <?php $this->load->view('plused_sidebar');?>		
    <script>
        $(document).ready(function() {
            $( "li#dashboard" ).addClass("current");
            $( "li#dashboard a" ).addClass("open");		
            $( "li#dashboard ul.sub" ).css('display','block');	
        });
    </script>		
    <!-- Here goes the content. -->
    <section id="content" class="container_12 clearfix" data-sort=true>
        <h1 class="grid_12 margin-top no-margin-top-phone">Plus Vision Dashboard</h1>
        <div class="grid_12">
            <div class="box">

                <div class="header">
                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/monitor.png" class="icon">Welcome to your Dashboard</h2>
                </div>

                <div class="content">
                    <p>
                        Dear Course Director, welcome to your personal dashboard where you can manage your courses, your students and teachers working hours.
                        We’re looking forward to a successful and enjoyable summer with you!
                        Download here the <a href="<?php echo base_url().COURSE_DIRECTOR_HELP_DOCUMENT;?>" target="_blank" class="hlt-link-a">Tuition Guide for Course Director</a>.
                    </p>
                    <p>
                        The Plus Team
                    </p><div class="alert information sticky bottom no-margin"><span class="icon"></span>If you need any <strong>help</strong> just send us a mail at <a class="hlt-link-a" style="color: white!important;" href="mailto:plus@plus-ed.com">plus@plus-ed.com</a></div>
                </div><!-- End of .content -->

            </div><!-- End of .box -->

        </div>
    </section><!-- End of #content -->

</div><!-- End of #main -->
<?php $this->load->view('plused_footer'); ?>
