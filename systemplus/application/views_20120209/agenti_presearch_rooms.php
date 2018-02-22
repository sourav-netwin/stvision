<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title><?php echo $title?></title>
<head>
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
			</div>
                    
    <div id="middle" >
        
      <!-- Form ricerca per agente -->     
      
       <form action="<?php echo base_url(); ?>index.php/agenti/search_by_agency" method="post" >
            <div class="module_content">
		<fieldset>
                <?php if($user=='admin'){ ?>
                        <label>Search by agents</label>
                        <select name="agency">
                            <?php

                             if (count($agency)){
                                foreach($agency as $key=>$item){ ?>
                                 <option value="<?php echo $item['id'];?>"><?php echo $item['login'];?></option>
                            <?php
                                }
                             }
                            ?>
                    </select>
               <?php } 
                    else 
                        { 
                ?>     
                        <label><legend>Search by agent</legend></label>
                        <input type="text" name="ag" value="<?php echo $user; ?>" /> 
                        <input type="hidden" name="agency" value="<?php echo $id; ?>" /> 
               <?php 
                       } 
                 ?>
                        <div class="submit_link">
                                <input type="submit" class="alt_btn" name="inserisci" value="search" />
                        </div>
                
		</fieldset>
             </div>
	</form>  
      <!-- Form ricerca per centro e mese, situazione di overbooking-->
        <!--form action="<//?php echo base_url(); ?>index.php/agenti/search_by_center" method="post" >
            <div class="module_content">
                <fieldset><legend>Search by center</legend>
                    <br>
                    <label>Select month</label>
                    <select name="mese">
			<option value = 'gen' >January</option>
			<option value = 'feb' >Febraury</option>
			<option value = 'mar' >March</option>
			<option value = 'apr' >April</option>
			<option value = 'mag' >May</option>
			<option value = 'giu' >June</option>
			<option value = 'lug' >July</option>
			<option value = 'ago' >August</option>
			<option value = 'set' >September</option>
			<option value = 'ott' >October</option>
			<option value = 'nov' >November</option>
			<option value = 'dic' >December</option>
                    </select>
                    <br>    
                <label>Select destination</label>
                    <br>
                    <select name="centro">
                        <//?php

                             if (count($centri)){
                                foreach($centri as $key=>$item){ ?>
                                 <option value="<//?php echo $item['nome_centri'];?>"><//?php echo $item['nome_centri'];?></option>
                            </?php 
                                }
                             }
                            ?> 
                    </select>
		<div class="submit_link">
			<input type="submit" class="alt_btn" name="inserisci" value="search" />
		</div>
		</fieldset>
             </div>
	</form -->
                <ol>     
                    <li><a class="white" href="<?php echo base_url(); ?>index.php/agenti/enrol"><font color="blue">Booking form</font></a></li>
                    <li><a class="white" href="<?php echo base_url(); ?>index.php/agenti/logout"><font color="blue">Log-out</font></a></li>
                </ol>
		</div>
		</div>
		
	
		<?php $this->load->view('agenti_footer');?>

</div>

</body>
</html>