<?php $this->load->view('admin_header');?>
	<section id="main" class="column">
	<div id="box_radius">
		<h4 class="alert_info"><?php echo $heading; ?></h4>
		<article class="module width_full">
			<header><h3>Admin Center</h3></header>
				<div class="module_content">

<h1>Teachers</h1>
<ol>
<h2> Please login to Access the Dashboard </h2>
			<?php
			$login_field = array(
					"name"=>"user",
					"id"=>"user",
					"maxlength"=>"64",
					"size"=>"20"
					);

			$pwd_field = array(
					"name"=>"password",
					"id"=>"password",
					"maxlength"=>"64",
					"size"=>"20"
			);
			echo form_open("payroll");
			echo "<p><label for='u'>Username</label><br/>";
			echo form_input($login_field) . "</p>";
			echo "<p><label for='p'>Password</label><br/>";
			echo form_password($pwd_field) . "</p>";
			echo form_submit('submit','login');
			echo form_close();
		?>
<?php $this->load->view('footer_html5');?>