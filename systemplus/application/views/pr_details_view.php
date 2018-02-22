<?php $this->load->view('admin_header');?>
	<section id="main" class="column">
	<div id="box_radius">
		<h4 class="alert_info"><?php echo $heading; ?></h4>
		<article class="module width_full">
			<header><h3>Insert</h3></header>
				<div class="module_content">

<?php 
		
		// Form
		echo "<form action=\"".base_url()."/index.php/payroll/details/".$this->uri->segment(3)."\" method=\"post\">";
					
					?>
						<h4>PAY SLIP TYPE</h4>
						<?php echo $this->validation->error_string; ?>
						<select name="p">
								<option value="<?php echo $this->validation->p;?>"></option> 
								<option value="p45">P45</option> 
								<option value="p46">P46</option> 
								<option value="p38">P38</option> 
						</select>
				
						<h4>WEEK ACT ONE</h4>
						<select name="weekact01">
								<option value=""></option> 
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
								<option value=""></option> 
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
								<option value=""></option> 
								<option value="yes">YES</option> 
								<option value="no">NO</option> 
						</select>
						<h4 >Bonus</h4>
						<input type="text" name="bonus" value="" size="10" />
						<h4>Valuation</h4>
						<select name="evaluation">
								<option value=""></option> 
								<option value="Unsatisfactory">Unsatisfactory</option> 
								<option value="Satisfactory ">Satisfactory</option> 
								<option value="Good ">Good</option> 
								<option value="Excellent ">Excellent</option> 
						</select>
					<div style="display:block; margin:0 40px 0 0px;"><br/><input type="submit" value=" Submit " /></div>
					
        </form>
		
<?php $this->load->view('footer_html5');?>