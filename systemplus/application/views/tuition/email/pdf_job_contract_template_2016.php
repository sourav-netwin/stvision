<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>plus-ed.com | job contract</title>
    </head>
    <body style="font-family: arial; background-color:#ffffff; margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;">
        <div style="font-size: 12px;padding: 0px 20px 0px 20px;">
            <div style="float: left;width:210px;" >
                <img src="<?php echo base_url(); ?>img/tuition/logo.png" alt=""/>
            </div>
            <div style="text-align: justify;clear: both; padding-top: 15px;">
                <div style="text-align: center;margin-top: 2px;">
                    <div style="font-size: 16px;font-weight: bold;">Statement of Terms and Conditions of Employment</div>
                    <div>You must read the Employee Handbook for more detailed description of the principle rules, policies and
procedures relating to your employment.</div>
                </div>
                <div style="text-align: left;margin-top: 15px;">
                    <?php echo $recName;?><br/>
                    <?php echo $recAddress;?><br/>
                    <?php echo $recCity;?>,
                    <?php echo $recPostcode;?><br/>
                    <?php echo $recCountry;?><br/>
                </div>
                <div>
                    <p>
                    Your employment with Professional Linguistic & Upper Studies Limited begins on
                    <?php echo date("d/m/Y",  strtotime($recFromDate)); ?> and your period of continuous employment is from the same date.
                    <br />You are employed as a <strong><?php echo $contractPosition;?></strong> for a fixed term which expires on
                    <?php echo date("d/m/Y",  strtotime($recToDate)); ?>.
                    <br />Your normal place of work is <?php echo $contractCampus;?>.
                    <?php if($recWages == 'Hourly'){?>
                    <br />Your pay will be <?php echo $recCurrencySymbol.$recSalary;?> per hour payable weekly by BACS.
                    <?php }else{?>
                    <br />Your pay will be <?php echo $recCurrencySymbol.$recSalary;?> per week payable weekly by BACS.
                    <?php }?>
                    </p>
                </div>
                <div>
                    <p>
                        Your hours of work are variable due to the nature of the business and you agree to work for more than an average of 48 hours a week if required.
                        You have a statutory entitlement to holidays, sick pay and notice.
                        <br/>The employee handbook contains particulars of the terms and conditions relating to
                    <ul>
                        <li>incapacity for work due to sickness or injury, and sick pay</li>
                        <li>pensions and pension schemes</li>
                        <li>notice of termination of your employment that you are entitled to receive and are required to give.</li>
                    </ul>
                        The employee handbook is where you can find the details on
                        <ul>
                            <li>the disciplinary rules which apply to you</li>
                            <li>the disciplinary and dismissal procedure which applies to you</li>
                        </ul>
                        If you are dissatisfied with any disciplinary or dismissal decision that affects you, you should apply in the first instance to the Director of Studies at Head Office. You should make your application by email.
                        <br/>If you have a grievance about your employment you should apply in the first instance to your line manager. You should make your application by email.
                        <br/>Subsequent steps in the company’s disciplinary and grievance procedures are set out in the employee handbook.
                        <br/>You will not be expected to work outside the UK.
                        <br/>There are no collective agreements which directly affect the terms and conditions of your employment.
                        <br/>This statement does not create any right enforceable by any person not a party to it.
                    </p>
                </div>
                <div>
                    <p>
                        <span style="font-weight: bold;">Declaration</span>
                        <br/>I confirm that I am entitled to work in the UK, have read this Statement, Job Offer, Job Description, Person Specification and the Employee Handbook.
                    </p>
                </div>
                <div>
                    <span style="font-weight: bold;">Signed by the Employee</span><br/><br/><br/><hr/>
                    <span style="font-weight: bold;">Name: <?php echo $recName;?></span><br/><br/><hr/>
                    <span style="font-weight: bold;">Date: </span><br/><hr/>
                    <span style="font-weight: bold;">Signed on behalf of the Organisation</span><br/>
                    <div style="float:left;width:210px;" >
                        <img src="<?php echo base_url(); ?>img/tuition/academic_contract_sign.png" alt=""/>
                    </div>
                    <span style="font-weight: bold;">Alison Rew, Director</span><br/>
                </div>
            </div>
        </div>
    </body>
</html>