<?php $this->load->view('admin_header');?>
	<section id="main" class="column">
	<div id="box_radius">
		<h4 class="alert_info"><?php echo $heading; ?></h4>
		<article class="module width_full">
			<header><h3>Inserimento</h3></header>
				<div class="module_content">
		<?php
		echo "<a href=\"".base_url()."index.php/payroll/\">Home</a>";
		// Form
		echo "<form action=\"".base_url()."index.php/payroll/detailsupdate/".$this->uri->segment(3)."\" method=\"post\">";
					foreach($details as $item): 
					?>
                        <h4>PAY SLEEP TYPE</h4>
						
						<select name="p">
								<option value="<?php echo $item['p']; ?>"><?php echo $item['p']; ?></option> 
								<option value="p45">P45</option> 
								<option value="p46">P46</option> 
								<option value="p38">P38</option> 
						</select>
						<h4>WEEK ACT ONE</h4>
						<select name="weekact01">
								<option value="<?php echo $item['activity_one']; ?>"><?php echo $item['activity_one']; ?></option> 
								<option value="0">0</option> 
								<option value="1">1</option> 
								<option value="2">2</option> 
								<option value="3">3</option> 
								<option value="4">4</option> 
								<option value="5">5</option> 
								<option value="6">6</option> 
								<option value="7">7</option> 
								<option value="8">8</option> 
								<option value="9">9</option> 
								<option value="10">10</option> 
						</select>
						<h4>WEEK ACT TWO</h4>
						<select name="weekact02">
								<option value="<?php echo $item['activity_two']; ?>"><?php echo $item['activity_two']; ?></option> 
								<option value="0">0</option> 
								<option value="1">1</option> 
								<option value="2">2</option> 
								<option value="3">3</option> 
								<option value="4">4</option> 
								<option value="5">5</option> 
								<option value="6">6</option> 
								<option value="7">7</option> 
								<option value="8">8</option> 
								<option value="9">9</option> 
								<option value="10">10</option> 
						</select>
						<h4>Residential</h4>
						<select name="residential">
								<option value="<?php echo $item['residential']; ?>"><?php echo $item['residential']; ?></option> 
								<option value="yes">YES</option> 
								<option value="no">NO</option> 
						</select>
						<h4 >Bonus</h4>
						<input type="text" name="bonus" value="<?php echo $item['bonus']; ?>" size="10" />
						<h4>Valuation</h4>
						<select name="evaluation">
								<option value="<?php echo $item['valuation']; ?>"><?php echo $item['valuation']; ?></option> 
								<option value="Unsatisfactory">Unsatisfactory</option> 
								<option value="Satisfactory ">Satisfactory</option> 
								<option value="Good ">Good</option> 
								<option value="Excellent ">Excellent</option> 
						</select>
					
					<div style="display:block; margin:0 40px 0 0px;"><br/><input type="submit" value=" Submit " /></div>
					<?php endforeach; ?>
               
		</form>
		
<?php $this->load->view('footer_html5');?>