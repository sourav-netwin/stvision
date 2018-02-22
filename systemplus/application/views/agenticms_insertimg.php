<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 
<title>Cms Inserimento immagini</title>
</head>
<body>

<img src="<?php echo base_url(); ?>images/agenti_header.png" style="margin:10px 0 0 0">
<div id="container">
	<div id="bigbox">
		<div id="left" >
			<div class="left_menu" >
				<ul>
				<li><a class="a" href="<?php echo base_url(); ?>index.php/agenti/gallery">ALL</a></li>
				<li><a class="a" href="<?php echo base_url(); ?>index.php/agenti/gallery/college">COLLEGE</a></li>
				<li><a class="a" href="#">CITIES</a></li>
				<li><a class="a" href="<?php echo base_url(); ?>index.php/agenti/gallery/people">PEOPLE</a></li>
				<li><a class="a" href="#">FROM IBIZA</a></li>
			</ul>
			</div>
			<img src="<?php echo base_url(); ?>images/agent_news_end.png" style="float:left; margin:0 0 0 0">		
		</div>

		<div id="middle_gallery">
			<center>
			<h1>Update Gallery</h1>
				
				<?php 
				echo form_open_multipart('agenticms/do_upload');
				echo form_label('<h3>Upload image Big</h3>','name');
				$ndata = array('name' => 'imgbig', 'id' => 'imgbig', 'size' => '25');
				echo form_upload($ndata);

				echo form_label('<h3>Upload Image Small</h3>','tipo');
				$edata = array('name' => 'imgsmall', 'id' => 'imgsmall', 'size' => '25');
				echo form_upload($edata);

				echo form_label('<h3>Classified</h3>','tipo');
				$edata = array('name' => 'tipo', 'id' => 'tipo', 'size' => '25');
				echo form_input($edata);

				echo form_label('<h3>Description</h3>','notes');
				$cdata = array('name' => 'notes', 'id' => 'notes', 'cols' => '40', 'rows' => '5');
				echo form_textarea($cdata);
				echo "<br/>";
				echo form_submit('submit','Upload');
				echo form_close();

				?>
			</center>
		</div>

		
	</div>
		<?php $this->load->view('agenti_footer');?>
</div>



</body>
</html>
