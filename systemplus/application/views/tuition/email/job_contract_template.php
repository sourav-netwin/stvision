<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>plus-ed.com | Job contract</title>
</head>
<body style="margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;">
<div style="width:100%;max-width:800px;margin:0 auto;position:relative;display:block;" id="warpper">
    <div style="width:100%;margin:0 ;float:left;" id="warpper_in"><!-- border:solid 1px #fab1b3; -->
    	<div class="top_header" style="background-color: #587691;padding: 10px 0 10px 10px;width:98%;max-width:800px;height:100%;float:left;">
            <img style="width:135px;float:left;height:auto;" src="<?php echo base_url(); ?>img/tuition/email_logo.png" alt=""/>
        </div>
     	<div style="width:94%;float:left;padding:3%;" class="mid_content">
            <?php //echo (isset($content) ? $content : '');?>
            <p>Dear <?php echo $teacherName;?>,</p>

            <p>Please find attached the link to access your personal page where you will find your contract with PLUS.</p>

            <p>Please print off and sign this contract and send a scanned copy to us, the details are all given.</p>

            <p><strong>You must officially sign and accept this contract and return it to us or we will not know you are coming.</strong></p>

            <p>Once you have read and accept the contract, please fill in and complete all the relevant information within your personal page. This information will be needed for our records, to allow us to finalise and process the prompt payment of your salary.</p>

            <p>
                Your user name and password are...
                <ul>
                    <li>Login url: <?php echo $loginUrl;?> Or <a href="<?php echo $loginUrl;?>" >click here</a> to visit url.</li>
                    <li>Username/Email: <?php echo $teacherEmail;?></li>
                    <li>Password: <?php echo $randomPassword;?></li>
                </ul>
            </p>

            <p>We look forward to working with you.</p>

            <p>The PLUS Team<p>
        </div>
        <div style="width:100%;max-width:800px;height:100%;float:left;height:40px;" class="fotter">
        <div style="background-color: #587691;min-height: 60px;color: #fff;font-family: Arial,Helvetica,sans-serif;font-size: 14px;font-weight: bold;height: 0;margin: 0;padding: 40px 0 0;text-align: center;" class="txt1">
        </div>
      </div>
    </div>
</div>
</body>
</html>