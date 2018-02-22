<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo $title;?></title>
<style>label { display:block;}</style>
</head>
<body>
<h1><?php echo $headline;?></h1>
<?php $this->load->view($include);?>

<p>This is random text for the CodeIgniter article. 
There's nothing to see here folks, just move along!</p>
<h2>Contact Us</h2>
<?php 
echo form_open('welcome/contactus');
echo form_label('your name','name');
$ndata = array('name' => 'name', 'id' => 'id', 'size' => '25');
echo form_input($ndata);

echo form_label('your email','email');
$edata = array('name' => 'email', 'id' => 'email', 'size' => '25');
echo form_input($edata);

echo form_label('how can you help you?','notes');
$cdata = array('name' => 'notes', 'id' => 'notes', 'cols' => '40', 'rows' => '5');
echo form_textarea($cdata);

echo form_submit('submit','send us a note');
echo form_close();

?>

</body>
</html>
