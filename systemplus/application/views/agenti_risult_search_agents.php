<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title><?php echo $title." - ".$name." ".$surname; ?></title>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ts_picker.js"></script>
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

       <script type="text/javascript">
                $(document).ready(function(){
                    $("#lente").hide();
                    $("#box_ins").hide();
                    $("#box_ins_date").hide();
                    
            $("#selection").change( function(){
                    var selected = $("#selection");		
                    if((selected.val() == 'date_in')||(selected.val() == 'date_dep') ){
                            $("#box_ins_date").show();
                            $("#lente").show();
                            $("#box_ins").hide();
                    }if(selected.val() == 'center'){
                        $("#lente").show();
                        $("#box_ins").show();
                        $("#box_ins_date").hide();
                    }
                    
                    });
            });
            
  //funzione calendario//
	$(function() {
	$.datepicker.setDefaults($.datepicker.regional['en']);
          $("input.data").datepicker({minDate:"today"});
            $("input#data_arrivo").change(function()
                    {
                    var valore_data = $(this).val();
                    if(valore_data)$("input#data_partenza").datepicker("option","minDate",valore_data);
                }
            );

	});
            
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
                    <div class="intestazione">
                        Previsional booking : <?php echo $business; ?>   
                    </div>     
                <form name="search_by_center" action="<?php echo base_url(); ?>index.php/agenti/search_center" method="post"> 
                    <div class='box_cerca'>
                        <div class='cerca'>
                            <select  class="select_search" name="select_search" id="selection">
                                <option value selected=" ">- Search by -</option>
                                <option value="center">Center</option>
                                <option value="date_in">Date arrival</option>
                                <option value="date_dep">Date departure</option>
                            </select>
                        </div>
                        <div class='box'>
                            <input type="text" class="input_search" name="search" value="" id="box_ins">
                            <input  type="text" name="search_by_center" class="input_search" onclick="show_calendar('document.search_by_center.search_by_center', document.search_by_center.search_by_center.value);" value="" id="box_ins_date"/>    
                        </div>
                        <div class="button_cerca">
                            <input name="invia il modulo" type="image" src="<?php echo base_url()?>images/search.png" alt="invia il modulo" id="lente">
                        </div>
                    </div> 
                </form>   
           <table id="customers">
                <tr>
                    <th>Reference number</th>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Destination</th>
                    <th>Students</th>
                    <th>Group</th>
                    <th>Info Booking</th>
                    <th>Modify Booking</th>
                    <th>Additional Services</th>
                    <th>Delete</th>
                </tr>
              <?php
                    

                      $color='1' ;
                 
                   foreach($agency as $key=>$item){
                      

                        //Formato Data
                            
                            $eur_date_start = $item ['data_inizio'];
                            $eur_time_start = strtotime($eur_date_start);
                            $date_start=date('Y-m-d',$eur_time_start);
                            
                        
                            
                       if($color=='1'){

               
                          echo  "<tr bgcolor='#FFFFFF'>";

                                 echo  "<td>".$item ['rand']."</td>";
                                 echo  "<td>".date('d-m-Y',strtotime($date_start))."</td>";
                                 echo  "<td>".date('d-m-Y',strtotime($item ['data_fine']))."</td>";
                                 echo  "<td>".$item ['id_centro']."</td>";
                                 echo  "<td>".$item['tot_pax']."</td>";
                          

                                       foreach($gl[$key] as $chiave=>$valore){
                                                $chiave=$chiave+1;

                                         echo "<td>".$valore['name_group']."</td>";

                                        }             
              
                                 echo "<td align=\"center\">";
                                             echo "<a href=\"". base_url()."index.php/agenti/info_agency/".$item ['rand'] ."\" >";
                                             echo "<img class=\"icon\" src=\"".base_url()."images/info.jpeg\" alt=\"info\"/>";
                                             echo "</a>";
                                 echo "<td>";
                                              echo "<a href=\"".base_url()."index.php/agenti/take/". $item ['id']."\" class=\"icon\" >";
                                              echo "<img  class=\"icon\" src= \"".base_url()."images/edit.jpeg\" alt=\"edit\"/>";
                                              echo "</a>";
                                 echo "</td>";
                                 echo "<td>";
                                              echo "<a href=\"".base_url()."index.php/agenti/price_transfer/". $item ['id']."/".$item ['id_centro']."\" class=\"icon\" >";
                                              echo "<img  class=\"icon\" src= \"".base_url()."images/bus.gif\" alt=\"ecursion\"/>";
                                              echo "</a>";
                                 echo "</td>"; 
                                 echo "<td>";
                                              echo "<a href=\"".base_url()."index.php/agenti/delete_check/". $item ['rand']."\" class=\"icon\" >";
                                              echo "<img  class=\"icon\" src= \"".base_url()."images/check_no_excursion.gif\" alt=\"ecursion\"/>";
                                              echo "</a>";                                              
                                 echo "</td>";
                                
                                 echo  "</td>";
                             echo "</tr>";
        
                                $color='2';

                                 }
                                 
                                 else {
                            echo  "<tr bgcolor='#EFEFF4'>";

                                 echo  "<td>".$item ['rand']."</td>";
                                 echo  "<td>".date('d-m-Y',strtotime($date_start))."</td>";
                                 echo  "<td>".date('d-m-Y',strtotime($item ['data_fine']))."</td>";
                                 echo  "<td>".$item ['id_centro']."</td>";
                                 echo  "<td>".$item['tot_pax']."</td>";
                          

                                       foreach($gl[$key] as $chiave=>$valore){
                                                $chiave=$chiave+1;

                                         echo "<td>".$valore['name_group']."</td>";

                                        }             
              
                                 echo "<td align=\"center\">";
                                             echo "<a href=\"". base_url()."index.php/agenti/info_agency/".$item ['rand'] ."\" >";
                                             echo "<img class=\"icon\" src=\"".base_url()."images/info.jpeg\" alt=\"info\"/>";
                                             echo "</a>";
                                 echo "</td>";
				     if($item["status"]!='confirmed' and $item["status"]!='active'){
                                 echo "<td>";
                                              echo "<a href=\"".base_url()."index.php/agenti/take/". $item ['id']."\" class=\"icon\" >";
                                              echo "<img  class=\"icon\" src= \"".base_url()."images/edit.jpeg\" alt=\"edit\"/>";
                                              echo "</a>";
                                 echo "</td>";
				     }else{?>
					<td>-</td>
				     <?php 
				     }
                                 echo "<td>";
                                              echo "<a href=\"".base_url()."index.php/agenti/price_transfer/". $item ['id']."/".$item ['id_centro']."\" class=\"icon\" >";
                                              echo "<img  class=\"icon\" src= \"".base_url()."images/bus.gif\" alt=\"ecursion\"/>";
                                              echo "</a>";
                                 echo "</td>";    
				     if($item["status"]!='confirmed' and $item["status"]!='active'){
                                 echo "<td>";
                                              echo "<a href=\"".base_url()."index.php/agenti/delete_check/". $item ['rand']."\" class=\"icon\" >";
                                              echo "<img  class=\"icon\" src= \"".base_url()."images/check_no_excursion.gif\" alt=\"ecursion\"/>";
                                              echo "</a>";                                              
                                 echo "</td>";  
				     }else{?>
					<td>-</td>
				     <?php 
				     }                              
                                 echo  "</td>";
                             echo "</tr>";
        
                                $color='1';

                                 }    

                                    }
                    ?>
             </table>
                   
                    <br>
        </div>
            <?php $this->load->view('agenti_footer');?>

</div>
<!--?php   
    }
  ?-->
</body>
</html>