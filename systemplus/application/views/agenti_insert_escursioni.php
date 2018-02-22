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
                    <div class="intestazione">
                        Excursion confirmation 
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
                                <th>Type</th>
                                <th>Excursion</th>
                                <th>Price</th>
                            </tr>
                           <?php 
                              
                            
                               foreach ($confirmed_excursions as $key=>$item){
                                     
                                   echo "<tr>";
                                        echo "<td>".$item['id_pratica']."</td>";
                                        echo "<td>".$item['centro']."</td>";
                                        echo "<td>".$business."</td>";
                                        echo "<td>".$item['gl']."</td>";
                                        echo "<td>".date('d-m-Y',strtotime($item['data_in']))."</td>";
                                        echo "<td>".date('d-m-Y',strtotime($item['data_out']))."</td>";
                                        echo "<td>".$item['tot_pax']."</td>";
                                        echo "<td>".$item['type']."</td>";
                                        echo "<td>".$item['excursion']."</td>";

                                        
                                        if($item['price_14']!= 0){
                                            echo "<td>&pound; ".ceil($item['price_14'])."</td>";
                                        }elseif($item['price_16']!= 0){
                                            echo "<td>&pound; ".ceil($item['price_16'])."</td>";
                                        }elseif($item['price_24']!=0){
                                            echo "<td>&pound; ".ceil($item['price_24'])."</td>";      
                                        }elseif($item['price_25']!=0){
                                            echo "<td>&pound; ".ceil($item['price_25'])."</td>";
                                        }elseif($item['price_28']!=0){
                                            echo "<td>&pound; ".ceil($item['price_28'])."</td>";
                                        }elseif($item['price_29']!=0){
                                            echo "<td>&pound; ".ceil($item['price_29'])."</td>";
                                        }elseif($item['price_33']!=0){
                                            echo "<td>&pound; ".ceil($item['price_33'])."</td>";
                                        }elseif($item['price_35']!=0){
                                            echo "<td>&pound; ".ceil($item['price_35'])."</td>";
                                        }elseif($item['price_38']!=0){
                                            echo "<td>&pound; ".ceil($item['price_38'])."</td>"; 
                                        }elseif($item['price_41']!=0){
                                            echo "<td>&pound; ".ceil($item['price_41'])."</td>";                                            
                                        }elseif($item['price_45']!=0){
                                            echo "<td>&pound; ".ceil($item['price_45'])."</td>";
                                        }elseif($item['price_49']!=0){
                                            echo "<td>&pound; ".ceil($item['price_49'])."</td>";
                                        }elseif($item['price_50']!=0){
                                            echo "<td>&pound; ".ceil($item['price_50'])."</td>";    
                                        }elseif($item['price_51']!=0){
                                            echo "<td>&pound; ".ceil($item['price_51'])."</td>";
                                        }elseif($item['price_53']!=0){
                                            echo "<td>&pound; ".ceil($item['price_53'])."</td>";
                                        }elseif($item['price_55']!=0){
                                            echo "<td>&pound; ".ceil($item['price_55'])."</td>";
                                        }elseif($item['price_57']!=0){
                                            echo "<td>&pound; ".ceil($item['price_57'])."</td>";
                                        }elseif($item['price_70']!=0){
                                            echo "<td>&pound; ".ceil($item['price_70'])."</td>";
                                        }elseif($item['price_75']!=0){
                                            echo "<td>&pound; ".ceil($item['price_75'])."</td>";    
                                        }
                               }
                           ?>
                        </table> 
                    
                    <br>
                        <div class="intestazione">
                            <h3><a href="<?php echo base_url(); ?>index.php/agenti/search_by_agency">Finish your booking</a></h3>
                        </div>
                    
                    <br>
                    <br>    
                   <?php  
                   
                        if($extra_excursion != null){
                   
                   ?>
                        
                    <form name="extra_excursion"  action="<?php echo base_url(); ?>index.php/agenti/extra_excursions"  method="post" >
                        
                           <input type="hidden" name="rand" value="<?php echo $_POST['rand'];?>">
                           <input type="hidden" name="excursion" value="<?php echo $_POST['excursion'];?>">
                     <br>           
                        <label class="dark_blue">would you like add extra excursion  ? </label>
                      
                        <select name="extra_ex">
                           <?php
                                 $index=1;   
                           
                                foreach($extra_excursion as $key=>$item){ 

                               echo  "<option value=\"".$item['nome']."\">".$index.". ".$item['nome']."</option>"; 
                                
                               $index++;
                             }
                            ?>
                        </select>
                      <div class="submit_link"><input id="button" type="submit" class="alt_btn" name="inserisci" value="next" /></div>   
                    </form>
                        
                    <?php 
                        }else{
                            echo "For this DESTINATION no extra excursions are forseen.";
                        }
                     ?>       
              
        </div>
		<?php $this->load->view('agenti_footer');?>
</div>
        <!--?php   
        }
      ?--> 
</body>
</html>