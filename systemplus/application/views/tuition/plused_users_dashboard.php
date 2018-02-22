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
                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/monitor.png" class="icon">Welcome to your Plus account</h2>
                </div>

                <div class="content">
                    <p>
                        Welcome to your Plus account where you can access and edit your personal details. You can access
                        your contract by clicking to your left. Please print off this contract, sign it and email a scanned copy
                        to <a class="hlt-link-a" href="mailto:recruitment@plus-ed.com">recruitment@plus-ed.com</a>. <span class="bold-uline">You must officially sign and accept this contract and return it to us or
                        we will not know you are coming.</span>
                    </p>
                    <p>
                        Please also insert your bank details into the system, which will be used to make payment to you
                        during your contract. Click on personal information section and press the edit button, enter your
                        details and press submit. <span class="bold-uline">Please ensure that you have answered all relevant financial questions
                        and entered all required bank information –</span> we will not be able to process any payments until this
                        is done.
                    </p>
                    <p>
                        When we have received your signed contract we will confirm you on our staff list. We will send you a
                        confirmation email which will have the teacher’s manual and further welcome information – to help
                        you prepare for the summer.
                    </p>
                    <p>
                        We look forward to working with you!
                    </p>
                    <p>
                        The Plus Team
                    </p><div class="alert information sticky bottom no-margin"><span class="icon"></span>If you need any <strong>help</strong> just send us a mail at <a class="hlt-link-a" style="color: white!important;" href="mailto:recruitment@plus-ed.com">recruitment@plus-ed.com</a></div>
                </div><!-- End of .content -->

            </div><!-- End of .box -->

        </div>
    </section><!-- End of #content -->

</div><!-- End of #main -->
<?php $this->load->view('plused_footer'); ?>
