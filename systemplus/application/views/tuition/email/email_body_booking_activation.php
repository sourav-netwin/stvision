<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>plus-ed.com | Booking activation email</title>
</head>
<body style="margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;">
<div style="width:100%;max-width:800px;margin:0 auto;position:relative;display:block;" id="warpper">
    <div style="width:100%;margin:0 ;float:left;" id="warpper_in"><!-- border:solid 1px #fab1b3; -->
    	<div class="top_header" style="background-color: #587691;padding: 10px 0 10px 10px;width:98%;max-width:800px;height:100%;float:left;">
            <img style="width:135px;float:left;height:auto;" src="<?php echo base_url(); ?>img/tuition/email_logo.png" alt=""/>
        </div>
     	<div style="width:94%;float:left;padding:3%;" class="mid_content">
            <?php //echo (isset($content) ? $content : '');?>
            <p>Dear Sir/Madam,</p>

            <p>Your booking <?php echo date('Y') . "_" . $bookId ?> is now active and will expire on <?php echo $datanuova;?></p>
            <?php echo $bookingDetailHtml;?>
            <p>You can now log in your personal page on PLUS Vision system to review your booking and to download your invoice.</p>

            <p>Plus Sales Office<p>
        </div>
        <div style="width:100%;max-width:800px;height:100%;float:left;height:40px;" class="fotter">
        <div style="background-color: #587691;min-height: 60px;color: #fff;font-family: Arial,Helvetica,sans-serif;font-size: 14px;font-weight: bold;height: 0;margin: 0;padding: 40px 0 0;text-align: center;" class="txt1">
        </div>
      </div>
    </div>
</div>
</body>
</html>