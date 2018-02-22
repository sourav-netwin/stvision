<html>
<head>
<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 11px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

h3 {
 color: #444;
 background-color: transparent;
 /* border-bottom: 1px solid #D0D0D0; */
 font-size: 11px;
 font-weight: bold;
 margin: 2px 0 2px 0;
 padding: 2px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 /* border: 1px solid #D0D0D0; */
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

.mytable{
 margin: 14px 0 14px 0;
}

</style>
<title>Contract</title>
</head>
<body>
<img src="<?php echo base_url(); ?>images/up_contract.jpg"/>

<div style="margin:30px 10px 10px 10px; width:600px">

<h2>Statement of Main Terms of Employment</h2>
<?php 	
		foreach ($getcandidate as $nome){
		
		// Maiuscolo e data europea
		$intro = "For: <br/>" . $nome['title'] ." " . $nome['nome'] . " " . $nome['cognome'] . "<br>"; 
		$intro = strtoupper($intro);
		$originalDateStart = $nome['date_start'];
		$datastart = date("d-m-Y", strtotime($originalDateStart));
		$originalDateEnd = $nome['date_end'];
		$dataend = date("d-m-Y", strtotime($originalDateEnd));
		///
		
		echo "<br/>" . $nome['address'];
		echo "<br/><div style=\"float:right\"> " . date('l jS \of F Y') . "</div>";
		echo "<br/><hr/>";
		/*echo "<br/><br/>I am pleased to confirm your employment as an EFL " . $nome['type_contract'] . " with Professional Linguistic and Upper Studies LTD as follows:";

		echo "<div class=\"mytable\"><strong>Centre</strong> " . $nome['center_def'] . "</div>";
		echo "<div class=\"mytable\"><strong>Start Date:</strong> " . $datastart . "</div>";
		echo "<div class=\"mytable\"><strong>End Date:</strong> " . $dataend . "</div>";
		
		echo "<div class=\"mytable\"><strong>Payable Days:</strong> 5 per week for the course</div>";
		echo "<div class=\"mytable\"><strong>Agreed Salary:</strong> £ " . $nome['salary'] ." per week</div>";
		if($nome['type_contract'] == "RESIDENT TEACHER"){
			echo "<div class=\"mytable\"><strong>Additional Details:</strong> Full Board Accommodation provided / Lunches provided Monday-Friday </div>";
		}else{
			echo "<div class=\"mytable\"><strong>Additional Details:</strong> Accommodation not provided</div>";
		}
		*/
		//$salary = (int)$nome['salary'];
		//$gross_salary=($salary*10.77)/100;
		}
		
									
												//echo "<table><tr><td>Multiple contract</td></tr>";
												foreach($multiplo as $mcontract){

												//	echo "<tr><td><hr></td></tr>";
												//	echo "<tr><td><h5>Center</h5> ".$mcontract['center_def']."</td></tr>";
												//	echo "<tr><td><h5>Start at</h5> ".$mcontract['date_start']."</td></tr>";
												//	echo "<tr><td><h5>End</h5> ".$mcontract['date_end']."</td></tr>";
												//	echo "<tr><td><h5>Salary</h5> ".$mcontract['salary']."</td></tr>";
												//	echo "<tr><td align=\"right\">";
													$salary = (int)$mcontract['salary'];
													$gross_salary=($salary*10.77)/100;
													$startdate=new DateTime($mcontract['date_start']); 
													$endate=new DateTime($mcontract['date_end']); 
													
													echo "<h2>" . $intro . "<br>" .$mcontract['center_def'] ."<br>".$startdate->format('d-m-Y') . " to " . $endate->format('d-m-Y') . "</h2>";
													?>
														
													This Statement dated, <?php echo date('l jS \of F Y') ?> sets out the particulars of main terms of employment under which Professional Linguistic & Upper Studies t/a PLUS LTD, (the employer referred to as 'the Organisation') whose address 8-10 Grosvenor Gardens, Mezzanine Floor, London, SW1W 0DH employs <?php echo $nome['nome'] . " " . $nome['cognome']; ?> (referred to as 'employee', 'you', 'your' etc.).<br><br>
													There are no collective agreements affecting your terms and conditions of employment.
													Any changes or amendments to these terms will be confirmed in writing within one month of them occurring.<br><br>
													<strong>Criminal Record Checks<br><br>
													Your employment with the Organisation will be conditional upon receipt of a satisfactory enhanced Criminal Record Bureau (CRB) disclosure. </strong><br><br>
													It will be essential for you to co-operate fully with the application process to obtain future CRB disclosures, as and when required. In addition, you may, at any time, be required to provide a self-disclosure by making a data subject access request in regard to records held on the Police National Computer.<br><br>
													Your ongoing employment in your current role will be subject to the content of the disclosure, or self-disclosure, when it is received, being satisfactory to the Organisation.<br><br>
													<strong>You will bear the cost of this process but be reimbursed on successful completion of employment.</strong><br><br>
													It is a condition of your employment that you notify your Manager immediately if you are questioned or arrested by the police, or charged, cautioned or convicted in connection with any criminal matter. <br><br>
													It is also a condition of your employment that you notify your Manager immediately if you are suspended from work, by any other employer, under the provisions of any legislation that is aimed at protecting children and vulnerable adults.<br><br>
													<strong>Vetting and Barring Schemes and Initiatives</strong><br><br>
													Your future employment in this role is subject to compliance with any future vetting and barring schemes and/or initiatives. <br><br>
													If the appropriate checks are not in place for any reason you must ensure that when working on any of the Organisation’s sites where you have contact with children (defined as those under 16 years or school leaving age) or vulnerable adults, you are accompanied by another member of staff who is a direct employee of that establishment. If this is not possible you must contact your immediate Manager before commencing work.<br><br>
													You will also be required to comply with any reasonable request made by a client of the Organisation that has the aim and objective of promoting the safety and security of children or vulnerable adults. <br><br>
													Any breach of any of these conditions could result in action being taken under the Disciplinary Procedure, which in turn could lead to the termination of your employment.<br><br>

													<strong>Commencement Date</strong><br><br>
													Your period of continuous employment begins on <?php echo $mcontract['date_start']; ?><br><br>


														<strong>Job Title</strong><br><br>
														You are employed as a <strong><?php echo $mcontract['type_contract']  ?></strong>  for a fixed term at <?php echo $mcontract['center_def']; ?>  which will end on <?php echo $dataend; ?>.  Either party may terminate this employment within this period by giving the notice detailed in the Notice section.<br><br>
														<strong>Place of Work</strong><br/><br/>
														Your normal place of work is <?php echo $mcontract['center_def']; ?> but you may be required to work at any of the Organisation's other locations as the Organisation may from time to time require.<br/><br/>
														<strong>Working Abroad</strong><br/><br/>
														The Organisation does not anticipate a requirement for you to work outside the United Kingdom.<br/><br/>
														<strong>Pay</strong><br/><br/>
														Your salary will be paid at the rate of <?php echo $salary; ?> &pound; per week (including holiday pay of <?php echo $gross_salary; ?>  ) monthly by BACS.<br/><br/>
														The Organisation has the right to deduct from your pay, or otherwise to require repayment by other means, any sum which you owe to the Organisation including, without limitation, any overpayment of pay or expenses, loans made to you by the Organisation, or any other item identified in this Statement and/or the Employee Handbook as being repayable by you to the Organisation.<br/><br/>
														 
														<strong>Accommodation</strong><br/><br/> 
														If you are required, for the better performance of your duties, to reside in accommodation allocated to you by the Organisation, it is on the understanding that this is provided under personal licence and you are bound by the terms of the Accommodation Agreement issued to you separately.  Upon the termination of your employment, you must vacate the accommodation immediately. <font color="green"><br/>The employer may also make deduction in respect of any costs or expenses incurred by the employer and caused by, or arising from, your occupation of the premises.</font>. <br/><br/>
														<strong>Hours of Work</strong><br/><br/>
														Your normal hours of work are detailed in the attached addendum "Terms and Conditions for Teachers". There may be occasions when you are required to work 'make up lessons' this may mean that you will be required to work more hours than you normally work in a day.<br/><br/>
														<strong>Holiday Entitlement</strong><br/><br/>
														In line with the Working Time Regulations, you will receive an additional payment for annual and bank/public holidays in your pay at the agreed rate of 12.07%.<br/><br/>
														The additional holiday pay will clearly show on your payslip and the payment will be shown as follows:<br/><br/>
														Payment for Working Time 	<?php echo $salary-$gross_salary; ?> &pound; per week<br/><br/>
														Additional Holiday Pay	  	<?php echo $gross_salary; ?> &pound; per week<br/><br/>
														Total	                                	<?php echo $nome['salary']; ?> &pound; per week<br/><br/>
														You are advised to set this money aside as you will not receive any other payment during any  requested holiday periods.Given the nature of the business, it will be necessary for you to work on bank/public holidays as required; these are considered to be part of your normal working week and do not attract any additional payment.<br/><br/>
														<strong>Sick Pay</strong><br/><br/>
														The procedure you must follow in the event of periods of absence from work due to sickness is set out in the Employee Handbook and the Terms and Conditions.
														Payments for periods of absence due to sickness will be made in accordance with the current Statutory Sick Pay Scheme where applicable.<br/><br/>
														<strong>Important</strong> If you have been absent due to sickness and are found not to have been genuinely ill, you will be subject to action under the Disciplinary Procedure, which could include dismissal.<br/><br/>
														<strong>Pension</strong><br/><br/>
														There is no Pension Scheme applicable to your employment.<br/><br/>

														<strong>Notice</strong><br/><br/>
														 
														*You are entitled to receive and are required to give the statutory minimum notice period (1 week after 1 month's service) to terminate your employment.<br/><br/>
														 
														By mutual agreement, this notice period may be waived. <br/>
														The Organisation has the right to terminate your employment without notice or payment in lieu of notice in the case of gross misconduct (a non-exhaustive list of examples of gross misconduct can be found in the Employee Handbook)<br/>
														The Organisation reserves the right to require you not to carry out your duties or attend your place of work during the period of notice.<br/>
														At the absolute discretion of the Organisation, payment in lieu of working notice may be made.<br/><br/>
														<strong>Disciplinary Procedure</strong><br/><br/>
														The Organisation's Rules and the Disciplinary Procedure are shown in the Employee Handbook.  It is your responsibility to familiarise yourself with these rules and procedures.<br/><br/>
														<strong>Appeal Procedure</strong><br/><br/>
														If you are dissatisfied with any disciplinary warning or decision to dismiss taken against you, you should raise this with the Director of Studies at Head Office. Further details of the Appeal Procedure are set out in the Employee Handbook.<br/><br/>
														<strong>Grievance Procedure</strong><br/><br/>
														If you wish to raise any grievance relating to your employment, you should do so with your line Manager. Further details of the Grievance Procedure are set out in the Employee Handbook.<br/><br/>
														<strong>Other Employment</strong><br/><br/>
														You are required to devote the whole of your time, attention and abilities during your hours of work to your duties with the Organisation and may not undertake any other work during this time.<br/>
														You may not without the prior consent of the Organisation (which will not be unreasonably withheld) engage in any business or employment which is similar to or competitive with the business of the Organisation, or which could be considered to impair your ability to act at all times in the best interests of the Organisation, outside your hours of work for the Organisation.<br/>
														If you do engage in any other employment, you must notify the Organisation in writing of hours worked elsewhere to enable the Organisation to comply with its statutory obligations.<br/><br/>
														<strong>Confidentiality</strong><br/><br/>
														You must not disclose any secrets or other information of a confidential nature relating to the Organisation or its business, or in respect of any obligation of confidence which the Organisation owes to any third party, during or after your employment except in the proper course of your employment or as required by law.<br/><br/>
														Any documents or tangible items which belong to the Organisation or which contain any confidential information must not be removed from the Organisation's premises at any time without proper authorisation, and must be returned to the Organisation upon request and, in any event, upon the termination of your employment.<br/><br/>
														If requested by the Organisation, all confidential information, other documents and tangible items which contain or refer to any confidential information, and which are in your possession or under your control, must be deleted or destroyed.<br/><br/>
														<strong>Limits of Authority</strong><br/><br/>
														You are not permitted to authorise any variation to the Organisation’s terms of business, agree any discounts on fees or charges or change any individual’s terms or conditions; nor should you incur or authorise any expenditure for any reason without the authority of a Director.  Failure to comply with this instruction will result in a disciplinary warning or dismissal, depending on the circumstances.<br/><br/>
														<strong>Media Statements</strong><br/><br/>
														You must not make any unauthorised statements relating to the affairs of the Organisation or its clients/business partners to the press or other media, orally or in writing at any time.  All co-ordination with either the press or any broadcasting organisations will be via a Director.<br/><br/>
														<strong>Health and Safety </strong><br/><br/>
														The Organisation places paramount importance on health and safety.  You are required to comply with all Health and Safety Rules as notified to you and to take all reasonably practicable steps to protect yourself and your colleagues at work as well as to ensure the safety of those whom the Organisation does not employ but who are affected by its undertaking. A Health and Safety handbook is available in the office and at each campus and it is your responsibility to familiarise yourself with these rules and procedures.<br/><br/>
														<strong>Exclusion of Third Party Rights</strong><br/><br/>
														This Statement does not create any right enforceable by any person not a party to it.<br/><br/>
														<strong>Monitoring of Personal Communications</strong><br/><br/>
														You should be aware that the Organisation may monitor, intercept or record all communications received or made via the Organisation's telephone system or any other system including e-mail and internet usage.  You should not use the Organisation's telephone or e-mail system for personal use without permission; full guidance is given in the Employee Handbook as to what is acceptable.<br/>  If you wish to make a call that cannot be monitored you should discuss this with management.  Monitoring may be conducted by any member of management but will be for work-related purposes only.<br/><br/>
														<strong>Data Protection</strong><br/><br/>
														The Organisation has developed guidelines, which are set out in the Employee Handbook, for the processing of personal data to meet the requirements of current legislation; the Organisation may change these guidelines at any time at its discretion.  The Organisation will keep personal information on you and discuss such information when required in accordance with the Employee Handbook.  In signing this Statement you expressly consent to the processing of information, which is held about yourself, including sensitive data such as sickness and health records, ethnic origin and trade union membership/non membership.<br/><br/>
														<strong>Declaration</strong><br/><br/>
														I acknowledge receipt of this Statement and confirm that I have read the Statement and the Employee Handbook, which set out the principal rules, policies and procedures relating to my employment.<br/><br/>
														For the purpose of the application of statutory holiday entitlement under the Working Time Regulations, I agree that the holiday section of this Statement will be held to be a "relevant agreement".<br/><br/>
														I understand that a printed copy of the Employee Handbook is kept in the Teachers’ Room on campus.<br/><br/>
													<?php
													
												
											}
									  ?>


<h4>Signed by the Employee</h4>
<hr/>
<h4>Name (Print) <?php echo $nome['nome'] . " " . $nome['cognome']; ?>	
<hr/>

<h4>Date 	
<hr/>
<h4>Signed on behalf of the Organisation
<hr/>
Alison Spillett, Director of Studies
<br clear="all">
<img src="http://www.plus-ed.com/apps/images/firma.jpg" style="display:block:float:left;">
<br>
<br>
<br>
<br>

<a href="javascript:window.print()">Print contract</a><br/>
<hr>
<a href="credential">Insert your bank details<br></a>

<br>
<br>
</div>
</body>
</html>