<?php $this->load->view('admin_header');?>
	<section id="main" class="column">
	<div id="box_radius">
		<h4 class="alert_info"><?php echo $heading; ?></h4>
		<article class="module width_full">
			<header><h3>Inserimento</h3></header>
				<div class="module_content">
				
				<?php
				$login_field = array(
						"name"=>"user",
						"id"=>"user",
						"maxlength"=>"12",
						"size"=>"20"
						);

				$pwd_field = array(
						"name"=>"password",
						"id"=>"password",
						"maxlength"=>"12",
						"size"=>"20"
				);
				echo form_open("payroll/login_admin_centers");
				echo "Username<br/>";
				echo form_input($login_field) . "</p>";
				echo "Password<br/>";
				echo form_password($pwd_field) . "</p>";
	
				echo form_submit('submit','login');
				echo form_close();
			?>
			</div>
			<footer>
			</footer>
			</article><!-- end of post new article -->
	</div>
</div>
</body>
</html>