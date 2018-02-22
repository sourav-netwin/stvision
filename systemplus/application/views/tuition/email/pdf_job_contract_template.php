<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>plus-ed.com | job contract</title>
    </head>
    <body style="font-family: arial; background-color:#ffffff; margin-left: 20px;margin-top: 0px;margin-right: 20px;margin-bottom: 0px;">
        <div style="font-size: 12px;padding: 0px 20px 0px 20px;">
<!--            <div style="float: left;width:210px;" >
                <img src="<?php //echo base_url(); ?>img/tuition/logo.png" alt=""/>
            </div>-->
            
            
            
            <div style="text-align: justify;clear: both; margin-left: 20px; margin-right: 20px;">
                <div style="text-align: center;margin-top: 2px;">
                    <div style="font-size: 16px;font-weight: bold;">Statement of Personal Terms</div>
                </div>
                <div>
                    <p>
                        The terms of your employment are set out in the Company’s Contract of Employment and the Key Terms and Job Specification that is applicable to your role.  These are supplemented by the individual terms that are set out in this Statement of Personal Terms.  It is essential that you read each of these documents carefully together with the Company’s policies and procedures that apply to your employment.  It is particularly important that you familiarise yourself with the content of the Company’s Safeguarding and Child Protection Policy which will have contractual effect.
                    </p>
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
                    <br />Your pay will be <?php echo $recCurrencySymbol.$recSalary;?> per hour payable monthly by BACS.
                    <?php }else{?>
                    <br />Your pay will be <?php echo $recCurrencySymbol.$recSalary;?> per week payable monthly by BACS.
                    <?php }?>
<!--                <br />Your anticipated average hours will be <?php //echo $workHours;?> per week.-->
                    <br />Your anticipated average hours will be <?php echo $workHours;?> per week in a teaching capacity. In addition to your teaching responsibilities, you will be also required to assist in duties set out in your job offer letter as per centre in the course of each week.
                    <br />Your position means that you will be employed on a <?php echo $boardAs;?>.
                    
                    </p>
                </div>
                <div>
                    <p>
                        Your employment (and continued employment) by the Company are subject to you satisfying the Company that each of the pre-conditions of your employment as is out in the Contract of Employment and the Key Terms and Job Specification have been met.
                    </p>
                </div>
                <div>
                    <p>
                        <span style="font-weight: bold;">Declaration</span>
                        <br/>
                        I confirm that I have read and understood the terms and conditions of my employment as set out in the Company’s Contract of Employment and the Key Terms and Job Specification as supplemented by this Statement of Personal Terms.  In particular, by signing this letter, I confirm that I am providing my express consent to the Company should the Company be required to carry out the type of monitoring provided for at clauses 18 and 21 of the Contract of Employment.  I am also giving my express consent to the Company to process my personal data (including sensitive personal data) that is held by the Company.  
I also confirm that I have read and understood the Company’s Safeguarding and Child Protection Policy and that I will comply with the terms of both this policy and all additional policies and procedures that are issued to me by the Company.
                    </p>
                </div>
                <div>
                    <span style="font-weight: bold;">Signed by the Employee</span><br/><br/><br/><hr/>
                    <span style="font-weight: bold;">Name: <?php echo $recName;?></span><br/><br/><hr/>
                    <span style="font-weight: bold;">Date: </span><br/><hr/>
                    <span style="font-weight: bold;">Signed on behalf of the Organisation</span><br/>
                    <div style="float:left;width:210px;" >
                        <img src="<?php echo base_url(); ?>img/tuition/james_signature_def_180.png" alt=""/>
                    </div>
                    <span style="font-weight: bold;">James McConville, Director of Studies</span><br/>
                </div>
            </div>
        </div>
    </body>
</html>