<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>plus-ed.com | Job offer</title>
</head>
<body style="margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;">
<div style="width:100%;max-width:800px;margin:0 auto;position:relative;display:block;" id="warpper">
    <div style="width:100%;margin:0 ;float:left;" id="warpper_in"><!-- border:solid 1px #fab1b3; -->
    	<div class="top_header" style="background-color: #587691;padding: 10px 0 10px 10px;width:98%;max-width:800px;height:100%;float:left;">
            <img style="width:135px;float:left;height:auto;" src="<?php echo base_url(); ?>img/tuition/email_logo.png" alt=""/>
        </div>
     	<div style="width:94%;float:left;padding:3%;" class="mid_content">
            <p>Dear applicant,</p>
            <p>Following your recent interview we are writing to confirm that we are pleased to offer you a position with Plus. Please find attached a job offer letter for further details.
                If you can't see the attachment, please download it <a href="<?php echo base_url().'index.php/positions/jobofferdownload/'.base64_encode($jobOfferId);?>">here.</a>
            </p>
            <p>Please let us know as soon as possible if you would like to accept this offer in order to allow us adequate time to complete all paperwork and mandatory recruitment checks.</p>
            <p>Please note this offer of employment is conditional upon: </p>
            <ul>
                <li>A successful DBS disclosure/Criminal Record Check.</li>
                <li>Proof of eligibility to work in the UK.</li>
                <li>The provision of original copies of relevant qualifications.</li>
            </ul>
          <?php 
            if(isset($specificaitonFile))
                if(file_exists(JOB_OFFER_TERM_SPECIFICATION_PATH . $specificaitonFile))
                {
          ?>
            <p>Please click <a href="<?php echo base_url().'index.php/positions/specification/'.$specificaitonFile;?>">here</a> to download terms and job specification.</p>
          <?php }?>
            <p>We look forward to working with you.</p>
            <p>Plus Staff</p>
        </div>
        <div style="width:100%;max-width:800px;height:100%;float:left;height:70px;" class="fotter">
        <div style="background-color: #587691;min-height: 60px;color: #fff;font-family: Arial,Helvetica,sans-serif;font-size: 14px;font-weight: bold;height: 0;margin: 0;padding: 40px 0 0;text-align: center;" class="txt1">
            &nbsp;
        </div>
      </div>
    </div>
</div>
</body>
</html>