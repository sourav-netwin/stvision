<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title><?php echo $title?></title>    
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui_1.8.16.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui_1.8.css" media="screen" />      
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ts_picker_en.js"></script>

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
                    <img src="<?php echo base_url(); ?>images/agent_news_end.png" >
		</div>
		
                <!--?php 

                    //Controllo limitato all'operatore 

                    if($attivi==false){

                    echo "<div id=\"container\" > ";   
                            echo "<div id=\"middle\" style=\"float:left;\" >";  

                                echo "<a href=\"".base_url()."index.php/agenti/logged\">";
                                    echo "Back at Home";
                                echo "</a>";

                            echo "</div>"; 
                    echo "</div>";        
                    }else{  
                ?-->            

		<div id="middle" >
                      <?php

                            foreach($up as $key=>$item){
                            if(count($up)){

                    ?>
       <form name="update_gl"  action="<?php echo base_url();?>index.php/agenti/update_gl"  method="post" >
	<fieldset>
          <div id="old_gl">
                <label>Group leader</label> 
                        <?php
                            foreach($glss as $chiave=>$valore){
                                        $chiave=$chiave+1;
                                        
                     echo "<div>";
                        echo "<input type=\"text\" name=\"agents\" value=\"".$valore['name_group']."\"/>";
                         echo "<input type=\"hidden\" name=\"agent\" value=\"".$valore['id']."\"/>";
                         
                     echo "</div>";   
                     
                        }
                        echo "<input type=\"hidden\" name=\"doc\" value=\"".$doc."\"/>";
                      ?>
           </div>   

          </fieldset>
             <div class="submit_link"><input type="submit" class="alt_btn" name="up_date" value="update" onclick="show_alert()" /></div>
        </div>  
                 
        </form>
                    
		</div>
	                        <?php
                            }
                    }
                    ?>	

		<?php $this->load->view('agenti_footer');?>

</div>
    <!--?php   
        }
      ?-->
</body>
</html>