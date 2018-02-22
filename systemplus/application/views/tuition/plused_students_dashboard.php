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
                <li><a href="<?php echo base_url(); ?>index.php/students/profile">Profile</a></li>
                <li class="line"></li>
                <li><a href="<?php echo base_url(); ?>index.php/students/logout">Logout</a></li>
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
                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/monitor.png" class="icon">Welcome to PLUS satisfaction survey!</h2>
                </div>

                <div class="content">
                    <p>
                        In order to help us improve PLUS programmes, these questionnaires have been developed to gather feedback on your experiences with us. We value your opinion and input. We would appreciate if you could take 5 minutes to complete theses short questionnaires which you can access by clicking to your left. To process the surveys please insert your email and press the start button.
                    </p>
                    <p>
                        Thank you in advance for taking the time to complete these questionnaires.
                    </p>
                    <p>
                        The PLUS Team.
                    </p>
                    <div class="alert information sticky bottom no-margin"><!-- span class="icon"></span>If you need any <strong>help</strong> just send us a mail at <a class="hlt-link-a" style="color: white!important;" href="mailto:recruitment@plus-ed.com">recruitment@plus-ed.com</a -->&nbsp;</div>
                </div><!-- End of .content -->

            </div><!-- End of .box -->

        </div>
    </section><!-- End of #content -->

</div><!-- End of #main -->
<?php $this->load->view('plused_footer'); ?>
