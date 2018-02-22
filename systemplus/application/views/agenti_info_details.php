<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title><?php echo $title?></title>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 
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
                    <div class="module_content">
                       <?php
                            foreach($group as $key=>$item){
                        ?>
                        <fieldset>
                            <h1>Booking</h1><br/>
                                <br>
                           <?php  
                                      echo "<div class=\"details\">REF. NUMBER: </div>" ;
                                      echo "<p class=\"info\">".$item['rand']."</p>"; 
                                      echo "<div class=\"details\">CENTER: </div>" ;
                                      echo "<p class=\"info\">".$item['id_centro']."</p>";
                                      echo "<div class=\"details\">AGENT: </div>";
                                      echo "<p class=\"info\">".$business."</p>";
                                     // GL // 
                                            foreach($gl[$key] as $chiave=>$valore){
                                                $chiave=$chiave+1;
                                                
                                                     echo "<div class=\"details\">GL: </div>" ;
                                                     echo "<p class=\"info\">".$valore['name_group']."</p>";
                                            }  
                                            
                                      echo "<div class=\"details\">ACCOMODATON: </div>";
                                      echo "<p class=\"info\">".$item['accomodation']."</p>";  
                                      
               
                                    foreach($excursion_pack as $key=>$pack){
                       
                                      echo "<div class=\"details\">ENGLISH LESSONS : </div>";
                                      echo "<p class=\"info\">".$pack['english_classes']."</p>";
     
                                    }
                                      
                                      echo "<div class=\"details\">NUMBER GL: </div>" ;
                                      echo "<p class=\"info\">".$item['n_gruppo']."</p>";
                                      
                                      echo "<div class=\"details\">PAX: </div>";
                                      echo "<p class=\"info\">".$item['tot_pax']."</p>";

                          ?>
                    <?php
                            }                
                     ?>          
                            <br>
                             <label class="center">Arrival</label>
                             <br>
                       <?php

                            foreach($group as $key=>$item){

                        ?>
                           <?php 
                                      echo "<div class=\"details\">DATE IN:</div>" ;
                                      echo "<p class=\"info\">".date('d-m-Y',strtotime($item['data_inizio']))."</p>";

                                      echo "<div class=\"details\">TRANSFER: </div>";
                                      
                               if($item ['confirm_in']== 'NO'){ 
                                       echo "<p class=\"info\">";
                                       echo "<img src=\"".base_url()."images/not.png\" alt=\"not\"/>";
                                       echo "</p>";  
                                   }  elseif ($item ['confirm_in']== 'STANDBY'){
                                       echo "<p class=\"info\">";
                                       echo "<img src=\"".base_url()."images/check_pending_excursion.gif\" alt=\"stand\"/>";
                                       echo "</p>"; 
                                   }  elseif($item['confirm_in']=='YES'){
                                       echo "<p class=\"info\">";
                                       echo "<img src=\"".base_url()."images/check_yes_excursion.gif\" alt=\"yes\"/>"; 
                                       echo "</p>";
                                   }
                                   
                                      echo "<div class=\"details\">TIME: </div>";
                                      echo "<p class=\"info\">".$item['ore_arrivo']."</p>";
                                      
                                      echo "<div class=\"details\">AIRPORT: </div>" ;
                                      echo "<p class=\"info\">".$item['id_airport_arrivo']."</p>";

                                   if($item['n_volo_arrivo']!=''){
                                      echo "<div class=\"details\">FLIGHT: </div>"; 
                                      echo "<p class=\"info\">".$item['n_volo_arrivo']."</p>";
                                   }else{
                                      echo "<div class=\"details\">FLIGHT: </div>";
                                      echo "<p class=\"info\"> None </p>"; 
                                   }
                            ?>
                                <br>
                                  <label class="center">Departure</label>
                                    <br>
                           <?php 
                                      echo "<div class=\"details\">DATE OUT:</div>" ;
                                      echo "<p class=\"info\">".date('d-m-Y',strtotime($item['data_fine']))."</p>";

                                      echo "<div class=\"details\">TRANSFER: </div>";
                                   if($item ['confirm_out']== 'NO'){ 
                                       echo "<p class=\"info\">";
                                       echo "<img src=\"".base_url()."images/not.png\" alt=\"not\"/>";
                                       echo "</p>";  
                                   }  elseif ($item ['confirm_out']== 'STANDBY'){
                                       echo "<p class=\"info\">";
                                       echo "<img src=\"".base_url()."images/check_pending_excursion.gif\" alt=\"stand\"/>";
                                       echo "</p>"; 
                                   }elseif($item['confirm_out']=='YES'){
                                       echo "<p class=\"info\">";
                                       echo "<img src=\"".base_url()."images/check_yes_excursion.gif\" alt=\"yes\"/>"; 
                                       echo "<p class=\"info\">";
                                   }
                                      echo "<div class=\"details\">TIME: </div>";
                                      echo "<p class=\"info\">".$item['ore_partenza']."</p>";
                                      
                                      echo "<div class=\"details\">AIRPORT: </div>" ;
                                      echo "<p class=\"info\">".$item['id_airport_partenza']."</p>";

                                   if($item['n_volo_arrivo']!=''){
                                      echo "<div class=\"details\">FLIGHT: </div>"; 
                                      echo "<p class=\"info\">".$item['n_volo_partenza']."</p>";
                                   }else{
                                      echo "<div class=\"details\">FLIGHT: </div>";
                                      echo "<p class=\"info\"> None </p>"; 
                                   }   
                            ?>  
                        </fieldset>     
                       <?php
                            }
                        ?> 
                        
                   <?php  
                        echo "<fieldset>";
                        echo  "<div>";
                        echo "<h1>Excursions included</h1><br/>";
                        echo  "</div>";
                        echo "<p align=\"left\"><font size=\"4px\">Half day</font></p>";
                        if($excursion_pack_half != null){
                          foreach($excursion_pack_half as $key=>$item){
                            
                           //Full day
 
                           echo  "<div>";
                                   echo  "<div class=\"details_pack\"> - </div>"; 
                                   echo "<p class=\"info\">".$item['excursion']."</p>";                               
                           echo  "</div>";   
                          }
                        }else{
                             echo  "<div>";
                                   echo  "<div class=\"details_pack\"> - </div>"; 
                                   echo "<p class=\"info\">None</p>";     
                             echo  "</div>";   
                        } 
                           echo "<br>";
                           echo "<br>";
                           echo "<br>";
                           echo "<br>";
                           echo "<br>";
                           echo "<br>";                           
                           
                        echo "<p align=\"left\"><font size=\"4px\">Full day</font></p>";
                        
                        if($excursion_pack_full != null){
                          foreach($excursion_pack_full as $key=>$item){
                            
                           //Full day
 
                           echo  "<div>";
                                   echo  "<div class=\"details_pack\"> - </div>"; 
                                   echo "<p class=\"info\">".$item['excursion']."</p>";                               
                           echo  "</div>";   
                          }
                        }else{
                             echo  "<div>";
                                   echo  "<div class=\"details_pack\"> - </div>"; 
                                   echo "<p class=\"info\">None</p>";   
                             echo  "</div>";   
                        }

                        echo "</fieldset>";   
                    
                  ?>                       
                        <fieldset>
                            <?php

                                if($transfer != null){
                                           echo  "<div>";
                                           echo  "<h1>Airport Transfer (returned): </h1><br/>";
                                           echo  "</div>";
                                        
                                        $index = 1;
                                        foreach ($transfer as $tra){
                                            echo "<p align=\"left\"><font size=\"4px\">Transfer " .$index. "</font></p>";
                                            echo  "<div>";
                                               echo "<div class=\"details\">Type: </div>";
                                               echo "<p class=\"info\">".$tra['type']."</p>";                                            
                                               echo "<div class=\"details\">Way: </div>";
                                               echo "<p class=\"info\">".$tra['centro']." - ".$tra['excursion']."</p>";
                                               
                                               echo "<div class=\"details\">ToT Pax: </div>";
                                               echo "<p class=\"info\">".$tra['tot_pax']."</p>";
                                               
                                               echo "<div class=\"details\">Price: </div>";
                                                        if($tra['price_14']!= 0){
                                                            echo "<p class=\"info\">".ceil($tra['price_14'])." &pound;</p>";
                                                        }elseif($tra['price_16']!= 0){
                                                            echo "<p class=\"info\">".ceil($tra['price_16'])." &pound;</p>";
                                                        }elseif($tra['price_24']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_24'])." &pound;</p>";                                                            
                                                        }elseif($tra['price_25']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_25'])." &pound;</p>";
                                                        }elseif($tra['price_28']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_28'])." &pound;</p>";                                                            
                                                        }elseif($tra['price_29']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_29'])." &pound;</p>";
                                                        }elseif($tra['price_33']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_33'])." &pound;</p>";
                                                        }elseif($tra['price_35']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_35'])." &pound;</p>";
                                                        }elseif($tra['price_38']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_38'])." &pound;</p>";  
                                                        }elseif($tra['price_41']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_41'])." &pound;</p>";                                                            
                                                        }elseif($tra['price_45']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_45'])." &pound;</p>";
                                                        }elseif($tra['price_49']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_49'])." &pound;</p>";
                                                        }elseif($tra['price_50']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_50'])." &pound;</p>";    
                                                        }elseif($tra['price_51']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_51'])." &pound;</p>";
                                                        }elseif($tra['price_53']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_53'])." &pound;</p>";
                                                        }elseif($tra['price_57']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_57'])." &pound;</p>";
                                                        }elseif($tra['price_70']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_70'])." &pound;</p>";
                                                        }elseif($tra['price_75']!=0){
                                                            echo "<p class=\"info\">".ceil($tra['price_75'])." &pound;</p>";  
                                                        }
                                                       
                                                   echo "<div class=\"details\">Delete Services ? </div>"; 
                                                   echo "<p class=\"info\">";
                                                   echo "<a href=\"". base_url()."index.php/agenti/delete_excursion/".$tra['id'] ."\"  onClick=\"return confirm('Do you confim delete?');\">";
                                                   echo "<img src=\"".base_url()."images/ico_cestino.gif\" alt=\"check\"/>";
                                                   echo "</a>";
                                                   echo "</p>";
                                                   echo "</div>"; 
  
                                             
                                           $index++;
                                    }
                                } else{  
                                               echo  "<div>";
                                               echo  "<h1>Airport Transfer not requested</h1><br/>";
                                               echo  "</div>";
                                        }                            
                            ?>
                        </fieldset>
                        
                            <fieldset>
                                    <?php
                                    
                                    if($excursion != null){
                                        
                                           echo  "<div>";
                                           echo  "<h1>Extra full day excursions requested </h1><br/>";
                                           echo  "</div>";
                                        
                                        $index = 1;
                                        foreach($excursion as $ex){

                                               echo "<p align=\"left\"><font size=\"4px\">Excursion " .$index. "</font></p>";
                                               echo  "<div>";
                                               echo "<div class=\"details\">Type: </div>";
                                               echo "<p class=\"info\">".$ex['type']."</p>";
                                               
                                               echo "<div class=\"details\">To: </div>";
                                               echo "<p class=\"info\">".$ex['excursion']."</p>";
                                               
                                               echo "<div class=\"details\">ToT Pax: </div>";
                                               echo "<p class=\"info\">".$ex['tot_pax']."</p>";
                                               
                                               echo "<div class=\"details\">Tot: </div>";
                                                   if($ex['price_16']!= 0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_16'])."</p>";
                                                        }elseif($ex['price_24']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_24'])."</p>";                                                            
                                                        }elseif($ex['price_25']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_25'])."</p>";
                                                        }elseif($ex['price_28']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_28'])."</p>";                                                              
                                                        }elseif($ex['price_29']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_29'])."</p>";
                                                        }elseif($ex['price_33']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_33'])."</p>";
                                                        }elseif($ex['price_35']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_35'])."</p>";
                                                        }elseif($ex['price_38']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_38'])."</p>"; 
                                                        }elseif($ex['price_41']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_41'])."</p>";                                                            
                                                        }elseif($ex['price_45']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_45'])."</p>";
                                                        }elseif($ex['price_49']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_49'])."</p>";
                                                        }elseif($ex['price_51']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_51'])."</p>";
                                                        }elseif($ex['price_53']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_53'])."</p>";
                                                        }elseif($ex['price_57']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_57'])."</p>";
                                                        }elseif($ex['price_70']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_70'])."</p>";
                                                        }
                                                   echo "<div class=\"details\">Delete Services ? </div>"; 
                                                   echo "<p class=\"info\">";     
                                                   echo "<a href=\"". base_url()."index.php/agenti/delete_excursion/".$ex['id'] ."\" onClick=\"return confirm('Do you confim the transfer?');\">";
                                                   echo "<img src=\"".base_url()."images/ico_cestino.gif\" alt=\"check\"/>";
                                                   echo "</a>"; 
                                                   echo "</p>";
 
                                               echo "</div>"; 
                                               
                                               $index++;
                                            }
                                        }  else{  
                                               echo  "<div>";
                                               echo  "<h1>No extra full day excursions requested</h1><br/>";
                                               echo  "</div>";
                                        } 
                                    ?>
          
           </fieldset> 
           <fieldset>
                                    <?php
                                    
                                    if($excursion_half != null){
                                        
                                           echo  "<div>";
                                           echo  "<h1>Extra half day excursions requested</h1><br/>";
                                           echo  "</div>";
                                        
                                        $index = 1;
                                        foreach($excursion_half as $ex){

                                               echo "<p align=\"left\"><font size=\"4px\">Excursion " .$index. "</font></p>";
                                               echo  "<div>";
                                               echo "<div class=\"details\">Type: </div>";
                                               echo "<p class=\"info\">".$ex['type']."</p>";
                                               
                                               echo "<div class=\"details\">To: </div>";
                                               echo "<p class=\"info\">".$ex['excursion']."</p>";
                                               
                                               echo "<div class=\"details\">ToT Pax: </div>";
                                               echo "<p class=\"info\">".$ex['tot_pax']."</p>";
                                               
                                               echo "<div class=\"details\">Tot: </div>";
                                                   if($ex['price_16']!= 0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_16'])."</p>";
                                                        }elseif($ex['price_24']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_24'])."</p>";                                                            
                                                        }elseif($ex['price_25']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_25'])."</p>";
                                                        }elseif($ex['price_28']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_28'])."</p>";                                                              
                                                        }elseif($ex['price_29']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_29'])."</p>";
                                                        }elseif($ex['price_33']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_33'])."</p>";
                                                        }elseif($ex['price_35']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_35'])."</p>";
                                                        }elseif($ex['price_38']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_38'])."</p>"; 
                                                        }elseif($ex['price_41']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_41'])."</p>";                                                            
                                                        }elseif($ex['price_45']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_45'])."</p>";
                                                        }elseif($ex['price_49']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_49'])."</p>";
                                                        }elseif($ex['price_51']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_51'])."</p>";
                                                        }elseif($ex['price_53']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_53'])."</p>";
                                                        }elseif($ex['price_57']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_57'])."</p>";
                                                        }elseif($ex['price_70']!=0){
                                                            echo "<p class=\"info\">&pound; ".ceil($ex['price_70'])."</p>";
                                                        }
                                                   echo "<div class=\"details\">Delete Services ? </div>"; 
                                                   echo "<p class=\"info\">";     
                                                   echo "<a href=\"". base_url()."index.php/agenti/delete_excursion/".$ex['id'] ."\" onClick=\"return confirm('Do you confim the transfer?');\">";
                                                   echo "<img src=\"".base_url()."images/ico_cestino.gif\" alt=\"check\"/>";
                                                   echo "</a>"; 
                                                   echo "</p>";
 
                                               echo "</div>"; 
                                               
                                               $index++;
                                            }
                                        }  else{  
                                               echo  "<div>";
                                               echo  "<h1>No extra half day excursions requested</h1><br/>";
                                               echo  "</div>";
                                        } 
                                    ?>
                            </fieldset>                        
                        <!-- EXTRA EXCURSION -->
                        
                        <fieldset>
                                    <?php
                                    
                                    if($extra_excursion != null){
                                        
                                           echo  "<div>";
                                           echo  "<h1>Attractions: </h1><br/>";
                                           echo  "</div>";
                                        
                                        $i = 1;
                                        
                                        foreach($extra_excursion as $extra){

                                               echo "<p align=\"left\"><font size=\"3px\">Attraction " .$i. "</font></p>";
                                               echo  "<div>";
                                                   echo "<div class=\"details\">To: </div>";
                                                   echo "<p class=\"info\">".$extra['extra_excursion']."</p>";
                                                   
                                                   echo "<div class=\"details\">Address: </div>";
                                                   echo "<p class=\"info\">".$extra['address']."</p>";
                                                   
                                                   echo "<div class=\"details\">Tot: </div>";
                                                   echo "<p class=\"info\">&pound; ".$extra['price']."</p>";                                                   
                                                   
                                                   echo "<div class=\"details\">Type: </div>";
                                                   echo "<p class=\"info\">".$extra['opzione']."</p>";
                                                   
                                                   echo "<div class=\"details\">Delete Services ? </div>"; 
                                                   echo "<p class=\"info\">";                                                                                                      
                                                   echo "<a href=\"". base_url()."index.php/agenti/delete_extra_excursion/".$extra['id'] ."\" onClick=\"return confirm('Do you confim the transfer?');\">";
                                                   echo "<img src=\"".base_url()."images/ico_cestino.gif\" alt=\"check\"/>";
                                                   echo "</a>"; 
                                                   echo "</p>";
                                               echo "</div>"; 
                                               
                                               $i++;
                                            }
                                        }  else{  
                                                echo  "<div>";
                                                echo  "<h1> No attractions requested: </h1><br/>";
                                                echo  "</div>";
                                        }    
                                    ?>
                            </fieldset> 
                    </div>

		</div>
		<?php $this->load->view('agenti_footer');?>
</div>
<!--?php   
    }
  ?-->
</body>
</html>