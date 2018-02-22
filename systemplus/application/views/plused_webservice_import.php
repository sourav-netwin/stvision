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

	<script>
		$(document).ready(function() {

			$( "li#mnuwebservice" ).addClass("current");
      $( "li#mnuwebservice a" ).addClass("open");
      $( "li#mnuwebservice ul.sub" ).css('display','block');
      $( "li#mnuwebservice ul.sub li#mnuwebservice_1" ).addClass("current");

			$("#btnSave").click(function(){
				$("#loading-overlay").show();
	    	$("#loading").show();
	    	$("#loading span").html('Importing...');
			});
		});
	</script>

	<!-- Here goes the content. -->
	<section id="content" class="container_12 clearfix" data-sort=true>
		<h1 class="grid_12 margin-top no-margin-top-phone">Plus Vision Webservice Import</h1>
		<div class="grid_12">
			<div class="box">

				<div class="header">
					<h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/monitor.png" class="icon">Import file</h2>
				</div>

				<div class="content">
					<form method="post" action="<?php echo base_url(); ?>index.php/webservice/import">
						<div class="row">
	            <div class="form-data webservice-import" style="margin-left: 130px;">
	              <input class="btn btn-tuition" type="submit" id="btnSave" name="btnSave" value="Import" />
	              <input class="btn btn-tuition" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url();?>index.php/webservice/index'" />
	            </div>
	          </div>
	        </form>
				</div><!-- End of .content -->

			</div><!-- End of .box -->
		</div>
	</section><!-- End of #content -->

</div><!-- End of #main -->

<?php $this->load->view('plused_footer');?>