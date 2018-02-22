<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>plus-ed.com | Booking elapsed</title>
</head>
<body style="margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;">
<div style="width:100%;max-width:800px;margin:0 auto;position:relative;display:block;" id="warpper">
    <div style="width:100%;margin:0 ;float:left;" id="warpper_in"><!-- border:solid 1px #fab1b3; -->
    	<div class="top_header" style="background-color: #587691;padding: 10px 0 10px 10px;width:98%;max-width:800px;height:100%;float:left;">
            <img style="width:135px;float:left;height:auto;" src="<?php echo base_url(); ?>img/tuition/email_logo.png" alt=""/>
        </div>
     	<div style="width:94%;float:left;padding:3%;" class="mid_content">
            <?php //echo (isset($content) ? $content : '');?>
            <p>Dear Agent ,</p>
 
            <p>We are writing to remind you that on the <?php echo $expiryDate;?> your provisional booking <?php echo $bookingId;?> will no longer be valid.</p>

            <p>To renew your booking or if you require any other assistance, please do not hesitate to contact your sales area representative via email or telephone .</p>

            <p>Here at PLUS we thank you for your custom and look forward to hearing from you.</p>

            <p>Kind Regards,</p>

            <p>Plus sales Office</p>
        </div>
        <div class="top_header" style="background-color: #587691;padding: 40px 0 40px 10px;width:98%;max-width:800px;float:left;">
        </div>
    </div>
</div>
</body>
</html>