<?php $this->load->view('admin_header_center');?>
	<section id="main" class="column">
	<div id="box_radius">
		<h4 class="alert_info"><?php echo $heading; ?></h4>
		<article class="module width_full">
			<header><h3>Admin Center</h3></header>
				<div class="module_content">

<h1>Teachers</h1>
<ol>
<?php

			 

		foreach($teachers as $item): 
				
				echo "<h3>Teachers:</h3><strong>" . $item['nome'] . " - " . $item['cognome'] ."</strong><br>";
				echo "from: <strong>" . $item['date_start'] ."</strong> - ";
				echo "to: <strong>" . $item['date_end'] . "</strong><br><br>";
								if($item['checkpay']) {
					echo "<hr>payment authorization:<br><img src=\"" . base_url() ."images/" . $item['checkpay']. ".png\">";
				}else{
					echo "payment authorization:<br><img src=\"" . base_url() ."images/no.png\">";
				}

				echo "<hr><a href=\"".base_url()."index.php/payroll/ad_teacher/".$this->uri->segment(3)."/".$item['id_personal']."\">Check Payroll</a>";
				echo "<hr>";
				
				echo "<br>";

		endforeach;
?>
<?php $this->load->view('footer_html5');?>