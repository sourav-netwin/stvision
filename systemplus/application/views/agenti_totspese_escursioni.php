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
               <form name="step3"  action="<?php echo base_url(); ?>index.php/agenti/insert_excursions"  method="post" >
                    <div class="intestazione">
                        Check your excursion booking   
                    </div>  
                <br>
                   <table id="excursions">
                            <tr>
                                <th>Reference number</th>
                                <th>Centre</th>
                                <th>Agents</th>
                                <th>Gl</th>   
                                <th>Arrival date</th>
                                <th>Departure date</th>
                                <th>Tot pax</th>
                            </tr>
                           <?php 
                             foreach($elenco as $key=>$item){
                  
                                   echo "<tr>";
                                    echo "<td>".$item['rand']."</td>";
                                    echo  "<input type=\"hidden\" name=\"rand\" value=\"".$item['rand']."\">";
                                    echo  "<input type=\"hidden\" name=\"id\" value=\"".$item['id']."\">";
                                    echo  "<input type=\"hidden\" name=\"centro\" value=\"".$item['id_centro']."\">";
                                    echo "<td>".$item['id_centro']."</td>";
                                    echo "<td>".$business."</td>";
                                    echo  "<input type=\"hidden\" name=\"agent\" value=\"".$business."\">";
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
                    <label class="dark_blue">Chosen type of excursion: </label>
                        <p><?php echo $_POST['gender'];?></p>
                           <input type="hidden" name="gender" value="<?php echo $_POST['gender'];?>">
                   <br>
                    <label class="dark_blue">Selected destination</label>
                        <p><?php echo $_POST['excursion'];?></p>
                        <input type="hidden" name="excursion" value="<?php echo $_POST['excursion'];?>">
                   <br>
                    <label class="dark_blue" style="display:none;">Cost: </label>

                        <?php 
             foreach($prenotazione as $excursion){
                 $check=true;
                        if($excursion['fleet_14']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_14']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_14\" value=\"".number_format($excursion['price_14']*(1+16.5/100),2)."\">";
                                     echo "<br>";                                     
                                     $check;    
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                     } elseif($excursion['fleet_16']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_16']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_16\" value=\"".number_format($excursion['price_16']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check;
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                }elseif($excursion['fleet_24']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_24']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_24\" value=\"".number_format($excursion['price_24']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check; 
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_25']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_25']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_25\" value=\"".number_format($excursion['price_25']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check;
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_28']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_28']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_28\" value=\"".number_format($excursion['price_28']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check; 
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_29']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_29']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_29\" value=\"".number_format($excursion['price_29']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check;
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_33']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_33']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_33\" value=\"".number_format($excursion['price_33']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check;
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_35']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_35']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_35\" value=\"".number_format($excursion['price_35']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check;
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_38']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_38']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_38\" value=\"".number_format($excursion['price_38']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check;  
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_41']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_41']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_41\" value=\"".number_format($excursion['price_41']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check; 
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_45']>=$_POST['tot_pax']){                     
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_45']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_45\" value=\"".number_format($excursion['price_45']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check;
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_49']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_49']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_49\" value=\"".number_format($excursion['price_49']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                      $check;
                                      echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_50']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_50']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_50\" value=\"".number_format($excursion['price_50']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check;  
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_51']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_51']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_51\" value=\"".number_format($excursion['price_51']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check;
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_53']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_53']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_53\" value=\"".number_format($excursion['price_53']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check;
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_55']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_55']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_55\" value=\"".number_format($excursion['price_55']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check;
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_57']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_57']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_57\" value=\"".number_format($excursion['price_57']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check;
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_70']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_70']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_70\" value=\"".number_format($excursion['price_70']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check;
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }elseif($excursion['fleet_75']>=$_POST['tot_pax']){
                                     echo "<p style='display:none;'> &pound; ".ceil($excursion['price_75']*(1+16.5/100))."</p>";
                                     echo  "<input type=\"hidden\" name=\"price_75\" value=\"".number_format($excursion['price_75']*(1+16.5/100),2)."\">";
                                     echo "<br>";
                                     $check;
                                     echo "<div class=\"submit_link\"><input id=\"button\" type=\"submit\" class=\"alt_btn\" name=\"inserisci\" value=\"confirm\" /></div>";
                                 }else{
                                     echo "The number of passengers exceeds the coach availability. Please contact our support team for further assistance.";
                                     echo "<br>";
                                     echo "<br>";
                                     echo "<br>";
                                 }
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