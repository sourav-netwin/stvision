<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $title?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 
<style type="text/css">
<!--
form, label {
	padding:0;
	margin:0;
	color: #999;
	clear:both;
	text-align:left;;
}
select{
	display:block;
	clear:both;
}


-->
</style>
</head>
<body>

<img src="<?php echo base_url(); ?>images/agenti_header.png" style="margin:10px 0 0 0">
<div id="container" >
	<div id="bigbox" >	
	<?php $this->load->view('agenti_tab');?>
		<div id="left" >
                    
			<div class="left_menu" >
				<?php $this->load->view('agenti_left_enrol');?>
                            <img src="<?php echo base_url(); ?>images/agent_news_end.png" >
			</div>
                   </div> 
		<div id="middle" >
       <form name="insert_group"  action="<?php echo base_url(); ?>index.php/agenti/add_group"  method="post" >
	<div class="module_content">
           <?php echo $this->validation->error_string; ?> 
           <fieldset><legend>New Group</legend>
		<label>Select Agency</label>
                <?php if($user=='admin'){ ?>
                        <select name="agency">
                            <option selected =" ">None</option>
                             <?php
                                 if (count($agenzie)){
                                    foreach($agenzie as $key=>$item){ ?>
                                     <option value="<?php echo $item['id'];?>"><?php echo $item['login'];?></option>
                                <?php 
                                    }
                                 }
                                ?>
                        </select>                    
                        <label>Group's name</label>
                            <input type="text" name="group" value="" />
                <?php 
                    } 
                        else { 
               ?>
                        <input type="text" name="ag" value="<?php echo $name.'&nbsp;'.$surname; ?>" /> 
                        <input type="hidden" name="agency" value="<?php echo $id; ?>" /> 
                        <label>Group's name</label>
                            <input type="text" name="group" value="" />    
                <?php     
                    } 
                   ?>        
                   <div class="submit_link"><input type="submit" class="alt_btn" name="inserisci" value="insert" /></div>
                   
                   </fieldset>
            </div>
            </form>
                 <ol>     
                    <a class="white" href="<?php echo base_url(); ?>index.php/agenti/enrol"><font color="blue">Booking form</font></a>
                    <a class="white" href="<?php echo base_url(); ?>index.php/agenti/logout"><font color="blue">Log-out</font></a>
                 </ol>
		</div>
		
		
	
		<?php $this->load->view('agenti_footer');?>

</div>

</body>
</html>