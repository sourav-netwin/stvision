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
                    <form name="step2"  action="<?php echo base_url(); ?>index.php/agenti/scheda_escursione"  method="post" >
                    <div class="intestazione">
                        excursion booking 
                    </div>
                <br>
                                <table id="excursions">
                                    <tr>
                                        <th>Reference number</th>
                                        <th>Centre</th>
                                        <th>Agent</th>
                                        <th>Gl</th>   
                                        <th>Arrival date</th>
                                        <th>Departure date</th>
                                        <th>Tot pax</th>
                                    </tr>
                                   <?php 
                                     foreach($elenco as $key=>$item){
                                         echo "<form name=\"excursions_insert\"  action=\"".base_url()."index.php/agenti/insert_excursions\" method=\"post\">";
                                          
                                         echo "<tr>";
                                            echo "<td>".$item['rand']."</td>";
                                            echo  "<input type=\"hidden\" name=\"rand\" value=\"".$item['rand']."\">";
                                            echo  "<input type=\"hidden\" name=\"id\" value=\"".$item['id']."\">";
                                            echo  "<input type=\"hidden\" name=\"centro\" value=\"".$item['id_centro']."\">";
                                            echo "<td>".$item['id_centro']."</td>";
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
                            <label class="dark_blue">Chosen type of excursion</label>
                                    <p><?php echo $_POST['gender'];?></p>
                                    <input type="hidden" name="gender" value="<?php echo $_POST['gender'];?>">
                          
                           <?php
                           
                            if($lista_destination != null){
                           
                           ?>
                                    
                           <label class="dark_blue">Select destination</label>       
                               <select name="excursion">
                           <?php
                              $index='1';
                                $color='1' ;
                            foreach($lista_destination as $key=>$item){ 
                                 
                               if($color=='1'){             
                                 echo  "<option  value=\"".$item['itinerario']."\" class=\"select_color_disp\">".$index.". ".$item['itinerario']."</option>"; 
                               $color='2';
                               }else{
                                 echo  "<option  value=\"".$item['itinerario']."\" class=\"select_color_pari\">".$index.". ".$item['itinerario']."</option>";   
                                 $color='1';
                                 }
                               $index++;
                             }
                            ?>
                        </select>
                           
                           <label class="dark_blue">Now please click NEXT to see the price for the selected destination</label> 
                           
                    <div class="submit_link"><input id="button" type="submit" class="alt_btn" name="inserisci" value="next" /></div>    
                    
                    <?php 
                            }else{
                                echo "Destination not available";
                            }
                    ?>
                    </form>
        </div>
		<?php $this->load->view('agenti_footer');?>
</div>
    <!--?php   
        }
      ?-->
</body>
</html>