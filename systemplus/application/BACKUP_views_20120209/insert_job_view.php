<html>
<head>
<title><?=$title?></title>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" /> 
</head>
<body>
<center>
<div id="main">
<div id="container">
		<img src="<?php echo base_url(); ?>images/up_job.jpg"/>
		<div id="menu_up">
			<?php	echo anchor("insert","Insert"); echo " | " . anchor("insert","Find"); echo " | " .  anchor("insert","Delete"); echo  " | " . anchor("insert","Modify"); ?>

		</div>

		
		
		<div id="left">
		
		</div>

		<div id="middle">	
			<h1 class="blu"><?=$heading;?></h1>
				<div >
				<table cellspacing="12" cellpadding="12">
				<?php echo $this->validation->error_string; ?>
						<?php echo form_open('cms/insertjob'); 
						$options = array(
						  '1'  => 'Teaching',
						  '3'    => 'Summer Job',
						  '2'   => 'Marketing',
						  '4' => 'Operation',
						  '7' => 'Sales',
						  '5' => 'Finance'
	                );	
					
						echo form_dropdown('categories', $options, '2');
						?>

						<h5>Type of job</h5>
						<input type="text" name="typeofjob" value="<?php echo $this->validation->typeofjob;?>" size="50" />
						<h5>Number Candidate</h5>
						<input type="text" name="ncandidate" value="<?php echo $this->validation->ncandidate;?>" size="50" />
						<h5>Nation</h5>
						<input type="text" name="nation" value="<?php echo $this->validation->nation;?>" size="50" />
						<h5>Job Description</h5>
						<textarea name="jobdescription" cols="40" rows="15">
                        <h1>Duties and Responsibilities of ...</h1>
                        <ul>
                        <li>To organise and manage the academic operations of the centre</li>
                        <li>To liaise with clients to ensure customer satisfaction and effective delivery of the service they have been promised</li>
                        <li>To oversee and manage the administration of placement testing, staff allocation, timetabling, curriculum implementation, examination procedures and classroom allocation</li>
                        <li>To maintain through training and observations, high standards of ELT teaching throughout the centre</li>
                        <li>To liaise with Head Office to ensure staffing levels and resources are adequately maintained</li>
                        <li>To ensure the maintenance of student safety, comfort and happiness at all times</li>
                        <li>To teach when required in cases of staff absences</li>
                        </ul>
                        Further details and more specific duties and responsibilities can be seen in the ‘Terms and Conditions of Course Directors 2009 document available on request during the application process.

                            <h1>Person Specification</h1>
                            Ideal Qualities
                            <ul>
                            <li>Previous knowledge and experience of summer schools, preferably in the ELT market</li>
                            <li>Experience of dealing with continuous enrolment courses and staggered arrivals</li>
                            <li>Minimum 3 years teaching experience</li>
                            <li>Some proven management experience</li>
                            </ul>
                            <h1>Essential Qualities</h1>
                            <ul>
                            <li>Diploma level qualified</li>
                            <li>Experience of working with juniors</li>
                            <li>Ability to lead and inspire fellow teachers</li>
                            <li>Excellent interpersonal and organisational skills</li>
                            <li>Flexibility</li>
                            <li>The ability to react calmly and swiftly and make decisions on the spot</li>
                            </ul>
                            
                            <h1>Hours of Work</h1>
                            The Course Director is expected to work Monday to Friday with weekends off in normal circumstances although differing timetables may be in place at different centres.
                            
                            <h1>Reports to</h1>
                            
                            The Course Director reports directly to the Director of Studies at the London Head Office. He/She must also follow instructions from the centre Welfare Director who has overall responsibility for the centre.
                            
                            Salary is dependent upon the size of the centre and the qualifications and experience of the applicant.
                        </textarea>
						<br/><br/>
						<input type="submit" value="Submit" />	
				</table>
				</div>
				
		</div>

		<div id="right">
				
		</div>
		
	</div>
	<div id="footer">init</div>		
</div>
</center>

</body>