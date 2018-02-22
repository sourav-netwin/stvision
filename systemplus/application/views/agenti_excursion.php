<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title><?php echo $title?></title>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
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

<!-- Script -->

<script type="text/javascript">

</script>

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
                    <form name="step1"  action="<?php echo base_url()."index.php/agenti/price_transfer/".$this->uri->segment(3)."/".$this->uri->segment(4);?>"  method="post" >
                    <div class="intestazione">
                        Check Excursion   
                    </div>  
                            <?php 
                                foreach($elenco as $key=>$item){
                            
                                    echo "<input type=\"hidden\" name=\"tot_pax\" value=\"".($item['tot_pax'] +$item['n_gruppo'])."\" />";
                                }
                                ?>
                            <br>
                                <table id="excursions">
                                    <tr>
                                        <th>Reference number</th>
                                        <th>Centre</th>
                                        <th>Agent</th>
                                        <th>Gl</th>   
                                        <th>Arrival Date</th>
                                        <th>Departure Date</th>
                                        <th>Tot pax</th>
                                    </tr>
                                   <?php 
                                     foreach($elenco as $key=>$item){
                                         echo "<form name=\"excursions_insert\"  action=\"".base_url()."index.php/agenti/insert_excursions\" method=\"post\">";
                                           echo "<tr>";
                                            echo "<td>".$item['rand']."</td>";
                                            echo  "<input type=\"hidden\" name=\"rand\" value=\"".$item['rand']."\">";
                                            echo  "<input type=\"hidden\" name=\"id\" value=\"".$item['id']."\">";
                                            echo "<td>".$item['id_centro']."</td>";
                                            echo  "<input type=\"hidden\" name=\"centro\" value=\"".$item['id_centro']."\">";
                                            echo "<td>".$business."</td>";
                                            echo  "<input type=\"hidden\" name=\"agent\" value=\"".$name." ".$surname."\">";
                                     }
                                     ?> 
                                     <?php
                                            foreach($gl as $chiave=>$valore){
                                                   echo "<td>".$valore['name_group']."</td>";
                                                   echo  "<input type=\"hidden\" name=\"gl\" value=\"".$valore['name_group']."\">";
                                                            }   
                                       ?>  
                                   <?php
                                            foreach($elenco as $key=>$item){                                               
                                                echo "<td>".date('d-m-Y',strtotime($item['data_inizio']))."</td>";
                                                echo  "<input type=\"hidden\" name=\"data_inizio\" value=\"".$item['data_inizio']."\">";
                                                echo "<td>".date('d-m-Y',strtotime($item['data_fine']))."</td>";
                                                echo  "<input type=\"hidden\" name=\"data_fine\" value=\"".$item['data_fine']."\">";
                                                echo "<td>".($item['tot_pax']+$item['n_gruppo'])."</td>";
                                                echo  "<input type=\"hidden\" name=\"tot_pax\" value=\"".($item['tot_pax']+$item['n_gruppo'])."\">";
                                         }
                                    ?> 
                                </table>     
                            <br>    
                            <label class="dark_blue">Please choose which type of excursion you would like to book: </label>
                            <br>
                                <input type="radio" name="gender" value="Half Day"><p class="option">Half Day Excursion</p>
                                    
                                <input type="radio" name="gender" value="Full Day"><p class="option">Full Day Excursion</p>
                                    
                                <input type="radio" name="gender" value="Transfer"><p class="option">Airport Transfer (return)</p>

                           <label class="dark_blue">Now please click NEXT to see the list of available destinations</label> 
                                
                            
                    <div class="submit_link"><input id="button" type="submit" class="alt_btn" name="inserisci" value="next" /></div>

                    </form>
        </div>
		<?php $this->load->view('agenti_footer');?>
</div>
    <!--?php   
        }
      ?-->
</body>
</html>