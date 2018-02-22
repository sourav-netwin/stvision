<?php $this->load->view('plused_header');?>
<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix">

	<!-- The blue toolbar stripe -->
	<section class="toolbar">
		<div class="user">
			<div class="avatar">
				<img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
			</div>
			<span><?php echo $this->session->userdata('businessname') ?></span>
			<ul>
				<?php
        	$bOArray = array(200,300,400,100,550); // BACKOFFICE USERS ROLE IDS
          if($this->session->userdata('username') && in_array($this->session->userdata('role'), $bOArray)){
        ?>
            <li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
            <li class="line"></li>
            <li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
        <?php
        } elseif ($this->session->userdata('role')!=97) { ?>
						<li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential">Profile</a></li>
						<li class="line"></li>
            <li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
				<?php } else { ?>
              <li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
				<?php } ?>

			</ul>
		</div>
	</section><!-- End of .toolbar-->

	<?php $this->load->view('plused_sidebar');?>

	<!-- Here goes the content. -->
	<section id="content" class="container_12 clearfix" data-sort=true>
		<h1 class="grid_12 margin-top no-margin-top-phone">Plus Vision Dashboard</h1>
		<div class="grid_12">
			<div class="box">

				<div class="header">
					<h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/monitor.png" class="icon">Welcome to Plus webservice dashboard</h2>
				</div>

				<?php
					$success_message = $this->session->flashdata('success_message');
					$error_message = $this->session->flashdata('error_message');

					if( !empty($success_message) || !empty($error_message) )
					{
				?>
					<div class="tabletools">
						<div class="right">
						 	<?php
		            if(!empty($success_message))
		            {
	            ?>
	            		<div class="tuition_success"><?php echo $success_message;?></div>
	            <?php
		            }
		            if(!empty($error_message))
		            {
	            ?>
	            		<div class="tuition_error"><?php echo $error_message;?></div>
	            <?php
		            }
		        	?>
	        	</div>
					</div>
				<?php } ?>

				<div class="content">
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
				</div><!-- End of .content -->

			</div><!-- End of .box -->
		</div>
	</section><!-- End of #content -->

</div><!-- End of #main -->

<?php $this->load->view('plused_footer');?>