<?php $this->load->view('admin_header');?>
	<section id="main" class="column">
	<div id="box_radius">
		<h4 class="alert_info"><?php echo $heading; ?></h4>
		<article class="module width_full">
			<header><h3><?php echo $center; ?></h3></header>
				<div class="module_content">

<h1>Attendants Register & Employee personal details</h1>
<ol>
<?php foreach($teachers as $item): 
		echo $item['nome'] . " - " . $item['cognome'] ."<br>";
		echo "from: <strong>" . $item['date_start'] ."</strong> - ";
		echo "to: <strong>" . $item['date_end'] . "</strong><br><br>";
		echo "<a href=\"".base_url()."index.php/payroll/singlecheck/".$item['id']."\">Attendants Register</a> | <a href=\"".base_url()."index.php/payroll/details/".$item['id']."\">Employee personal details</a>";
		echo "<hr>";
		
		echo "<br>";

		endforeach;
?>
<?php $this->load->view('footer_html5');?>