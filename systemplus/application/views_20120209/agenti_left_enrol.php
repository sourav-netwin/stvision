<div>	
<?php 
  //Controllo limitato all'operatore Ste

    if($attivi==false){

         echo "<li><a class=\"white\" <a href=\"".base_url()."index.php/agenti/logged\">Back Home </a>";
      
    }else{  
?>
    
    <span class="welcome">Welcome <?php echo $business; ?></span>
	<br/>
        
            <ul>
                <li><a class="white" href="<?php echo base_url(); ?>index.php/agenti/enrol">New group booking</a></li>
                <!--li><a class="white" href="<//?php echo base_url(); ?>index.php/agenti/presearch_available_rooms">Reservetion review</a></li-->
                <li><a class="white" href="<?php echo base_url(); ?>index.php/agenti/logout">Log-out</a></li>
            </ul>
        
 <?php 
         }
 ?>
        
</div>
