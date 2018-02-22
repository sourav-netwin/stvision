<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?=$title?></title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 
<style type="text/css">

a{

	font-family: Monaco, Verdana, Sans-serif;
	font-size: 11px;
	color: #eee;
	text-align:center; 
 
}
.input_form{display:block; margin:10px 0 10px 0;  font-size:12px; }
select{display:block; border:1px solid #9A9A9A; width:130px; clear:both; background-color:#ddf}

</style>
</head>
<body>
<img src="<?php echo base_url(); ?>images/agenti_header.png" style="margin:10px 0 0 0">
<div id="container">
	<div id="login">	
		
		<div style="margin:10px 0 0 52px; text-align:center;"><img src="<?php echo base_url(); ?>images/loginformup.png"></div>
		<div class="login_container">
		
			<h2 style="margin:10px 0 0 0;">Company Overview (Step 3 - 4)</h2>
			<div class="login_container_form">
				<?php echo $this->validation->error_string; ?>
					<?php echo form_open('agenti/registrazioneThird/' . $this->uri->segment(3)); ?>
						<div class="input_form">What year did your business start?</div>
				
						<select style="display:block; float:left; margin:0 0 4px 0" name="companystart">
							<option value="1962" <?php echo set_select('companystart', '1962'); ?> >1962</option>
							<option value="1963" <?php echo set_select('companystart', '1963'); ?> >1963</option>
							<option value="1964" <?php echo set_select('companystart', '1964'); ?> >1964</option>
							<option value="1965" <?php echo set_select('companystart', '1965'); ?> >1965</option>
							<option value="1966" <?php echo set_select('companystart', '1966'); ?> >1966</option>
							<option value="1967" <?php echo set_select('companystart', '1967'); ?> >1967</option>
							<option value="1968" <?php echo set_select('companystart', '1968'); ?> >1968</option>
							<option value="1969" <?php echo set_select('companystart', '1969'); ?> >1969</option>
							<option value="1970" <?php echo set_select('companystart', '1970'); ?> >1970</option>
							<option value="1971" <?php echo set_select('companystart', '1971'); ?> >1971</option>
							<option value="1972" <?php echo set_select('companystart', '1972'); ?> >1972</option>
							<option value="1973" <?php echo set_select('companystart', '1973'); ?> >1973</option>
							<option value="1974" <?php echo set_select('companystart', '1974'); ?> >1974</option>
							<option value="1975" <?php echo set_select('companystart', '1975'); ?> >1975</option>
							<option value="1976" <?php echo set_select('companystart', '1976'); ?> >1976</option>
							<option value="1977" <?php echo set_select('companystart', '1977'); ?> >1977</option>
							<option value="1978" <?php echo set_select('companystart', '1978'); ?> >1978</option>
							<option value="1979" <?php echo set_select('companystart', '1979'); ?> >1979</option>
							<option value="1980" <?php echo set_select('companystart', '1980'); ?> >1980</option>
							<option value="1981" <?php echo set_select('companystart', '1981'); ?> >1981</option>
							<option value="1982" <?php echo set_select('companystart', '1982'); ?> >1982</option>
							<option value="1983" <?php echo set_select('companystart', '1983'); ?> >1983</option>
							<option value="1984" <?php echo set_select('companystart', '1984'); ?> >1984</option>
							<option value="1985" <?php echo set_select('companystart', '1985'); ?> >1985</option>
							<option value="1986" <?php echo set_select('companystart', '1986'); ?> >1986</option>
							<option value="1987" <?php echo set_select('companystart', '1987'); ?> >1987</option>
							<option value="1988" <?php echo set_select('companystart', '1988'); ?> >1988</option>
							<option value="1989" <?php echo set_select('companystart', '1989'); ?> >1989</option>
							<option value="1990" <?php echo set_select('companystart', '1990'); ?> >1990</option>
							<option value="1991" <?php echo set_select('companystart', '1991'); ?> >1991</option>
							<option value="1992" <?php echo set_select('companystart', '1992'); ?> >1992</option>
							<option value="1993" <?php echo set_select('companystart', '1993'); ?> >1993</option>
							<option value="1994" <?php echo set_select('companystart', '1994'); ?> >1994</option>
							<option value="1995" <?php echo set_select('companystart', '1995'); ?> >1995</option>
							<option value="1996" <?php echo set_select('companystart', '1996'); ?> >1996</option>
							<option value="1997" <?php echo set_select('companystart', '1997'); ?> >1997</option>
							<option value="1998" <?php echo set_select('companystart', '1998'); ?> >1998</option>
							<option value="1999" <?php echo set_select('companystart', '1999'); ?> >1999</option>
							<option value="2000" <?php echo set_select('companystart', '2000'); ?> >2000</option>
							<option value="2001" <?php echo set_select('companystart', '2001'); ?> >2001</option>
							<option value="2002" <?php echo set_select('companystart', '2002'); ?> >2002</option>
							<option value="2003" <?php echo set_select('companystart', '2003'); ?> >2003</option>
							<option value="2004" <?php echo set_select('companystart', '2004'); ?> >2004</option>
							<option value="2005" <?php echo set_select('companystart', '2005'); ?> >2005</option>						
							<option value="2006" <?php echo set_select('companystart', '2006'); ?> >2006</option>
							<option value="2007" <?php echo set_select('companystart', '2007'); ?> >2007</option>
							<option value="2008" <?php echo set_select('companystart', '2008'); ?> >2008</option>
							<option value="2009" <?php echo set_select('companystart', '2009'); ?> >2009</option>
							<option value="2010" <?php echo set_select('companystart', '1966'); ?> >2010</option>	
						</select>
						<div class="input_form">How many employee do you employ?</div>
						<div>
						<select name="companyemployed" style="display:block; float:left; margin:0 0 4px 0">
							<option value="1" <?php echo set_select('companyemployed', '1', TRUE); ?> >1</option>
							<option value="2" <?php echo set_select('companyemployed', '2'); ?> >2-5</option>
							<option value="5" <?php echo set_select('companyemployed', '5'); ?> >5+</option>
						</select>
						<div class="input_form">How many students did you send abroad last year?</div>
							<select name="companystudent" style="display:block; float:left; margin:0 0 4px 0">
							<option value="0" <?php echo set_select('companystudent', '1', TRUE); ?> >0</option>
							<option value="100" <?php echo set_select('companystudent', '100'); ?> >1-100</option>
							<option value="200" <?php echo set_select('companystudent', '200'); ?> >100-200</option>
							<option value="201" <?php echo set_select('companystudent', '201'); ?> >200+</option>
						</select>
						<div class="input_form">How where these students apportioned according to the following categories?</div>
						<div class="input_form" style="font-weight:bold">Junior Summer</div>
							<select name="junior" style="display:block; float:left; margin:0 0 4px 0">
								<option value="1" <?php echo set_select('junior', '1', TRUE); ?> >1-10 %</option>
								<option value="11" <?php echo set_select('junior', '11'); ?> >11-30 %</option>
								<option value="30" <?php echo set_select('junior', '30'); ?> >30-60 %</option>
								<option value="60" <?php echo set_select('junior', '60'); ?> >+60 %</option>
							</select>
						<div class="input_form" style="font-weight:bold">Language Learning</div>
							<select name="languagelearning" style="display:block; float:left; margin:0 0 4px 0">
								<option value="1" <?php echo set_select('languagelearning', '1', TRUE); ?> >1-10 %</option>
								<option value="11" <?php echo set_select('languagelearning', '11'); ?> >11-30 %</option>
								<option value="30" <?php echo set_select('languagelearning', '30'); ?> >30-60 %</option>
								<option value="60" <?php echo set_select('languagelearning', '60'); ?> >+60 %</option>
							</select>
						<div class="input_form" style="font-weight:bold">University Placement</div>
							<select name="university" style="display:block; float:left; margin:0 0 4px 0">
								<option value="1" <?php echo set_select('university', '1', TRUE); ?> >1-10 %</option>
								<option value="11" <?php echo set_select('university', '11'); ?> >11-30 %</option>
								<option value="30" <?php echo set_select('university', '30'); ?> >30-60 %</option>
								<option value="60" <?php echo set_select('university', '60'); ?> >+60 %</option>
							</select><br/><br/>
						<div class="input_form">Which Countries are the most popular destination?</div>
							<select name="destination1" style="display:block; float:left; margin:0 0 4px 0">
								<option value="uk" <?php echo set_select('destination1', 'uk', TRUE); ?> >UK</option>
								<option value="ireland" <?php echo set_select('destination1', 'ireland'); ?> >IRELAND</option>
								<option value="malta" <?php echo set_select('destination1', 'malta'); ?> >MALTA</option>
								<option value="canada" <?php echo set_select('destination1', 'canada'); ?> >CANADA</option>
								<option value="australia" <?php echo set_select('destination1', 'australia'); ?> >AUSTRALIA</option>
								<option value="usa" <?php echo set_select('destination1', 'usa'); ?> >USA</option>							
								<option value="italy" <?php echo set_select('destination1', 'italy'); ?> >CANADA</option>
							</select>
							<select name="destination2" style="display:block; float:left; margin:0 0 4px 0">
								<option value="uk" <?php echo set_select('destination2', 'uk', TRUE); ?> >UK</option>
								<option value="ireland" <?php echo set_select('destination2', 'ireland'); ?> >IRELAND</option>
								<option value="malta" <?php echo set_select('destination2', 'malta'); ?> >MALTA</option>
								<option value="canada" <?php echo set_select('destination2', 'canada'); ?> >CANADA</option>
								<option value="australia" <?php echo set_select('destination2', 'australia'); ?> >AUSTRALIA</option>
								<option value="usa" <?php echo set_select('destination2', 'usa'); ?> >USA</option>							
								<option value="italy" <?php echo set_select('destination2', 'italy'); ?> >CANADA</option>
							</select>					
							<select name="destination3" style="display:block; float:left; margin:0 0 4px 0">
								<option value="uk" <?php echo set_select('destination3', 'uk', TRUE); ?> >UK</option>
								<option value="ireland" <?php echo set_select('destination3', 'ireland'); ?> >IRELAND</option>
								<option value="malta" <?php echo set_select('destination3', 'malta'); ?> >MALTA</option>
								<option value="canada" <?php echo set_select('destination3', 'canada'); ?> >CANADA</option>
								<option value="australia" <?php echo set_select('destination3', 'australia'); ?> >AUSTRALIA</option>
								<option value="usa" <?php echo set_select('destination3', 'usa'); ?> >USA</option>							
								<option value="italy" <?php echo set_select('destination3', 'italy'); ?> >CANADA</option>
							</select>					
							<br/><br/><br/>
						<div class="input_form">Is your business licensed by the government of your country?</div>
						<select name="companylicensed" style="display:block; float:left; margin:0 0 4px 0">
							<option value="yes" <?php echo set_select('companylicensed', 'yes', TRUE); ?> >yes</option>
							<option value="no" <?php echo set_select('companylicensed', 'no'); ?> >no</option>
						</select>
						<div class="input_form">Do you produce your own brochures?</div>
						<select name="companybrochure" style="display:block; float:left; margin:0 0 4px 0">
							<option value="yes" <?php echo set_select('companybrochure', 'yes', TRUE); ?> >yes</option>
							<option value="no" <?php echo set_select('companybrochure', 'no'); ?> >no</option>
						</select>
						<div class="input_form">Do you produce your own brochures?</div>
						<select name="companyhear" style="display:block; float:left; margin:0 0 4px 0">
							<option value="magazine" <?php echo set_select('companyhear', 'magazine', TRUE); ?> >Magazine</option>
							<option value="web" <?php echo set_select('companyhear', 'web'); ?> >Web</option>
							<option value="fair" <?php echo set_select('companyhear', 'fair'); ?> >Fair</option>
							<option value="agent" <?php echo set_select('companyhear', 'agent'); ?> >Agent</option>
							<option value="tv" <?php echo set_select('companyhear', 'tv'); ?> >TV</option>
						</select>
						<br/><br/>
						<div ><input type="submit" value="Next" /></div>
					</form>
			</div>
		</div>
		<div style="text-align:center;"><img src="<?php echo base_url(); ?>images/loginformdown.png"></div>
		
	 </div>

</div>

				<?php $this->load->view('agenti_footer');?>			
</body>
</html>
