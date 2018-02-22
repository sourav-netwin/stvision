<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title><?php echo $title ?></title>
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
<?php 

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
?>                    
	<div id="middle" >                          
           <table cellpadding="10">
               <?php
                echo "<tr>";
                    echo "<th><h5><font color=\"red\">Days</h5></th>";
                    echo "<th><h5><font color=\"red\">Tot. Pax</h5></th>";
                    echo "<th><h5><font color=\"blue\">Request Std</h5></font></th>";
                    echo "<th><h5><font color=\"blue\">Allotment Std</h5></font></th>";
                    echo "<th><h5>Actual Std</th>";
                    echo "<th><h5><font color=\"green\">Request En Suite</h5></font></th>";
                    echo "<th><h5><font color=\"green\">Allotment En Suite</h5></font></th>";
                    echo "<th><h5>Actual En Suite</h5></th>";
                    echo "<th><h5>Hs</h5></th>";
                    echo "<th><h5><font color=\"red\">Info</font></h5></th>";
                echo "</tr>";
                
                for($i=0; $i<count($mydata); $i++){
                    
                    echo "<tr>";
                        //giorni
                            echo "<td>".$mydata[$i]."</td>";
                            
                        //Tot pax
                            echo "<td class=\"red_text\">".($mygroup[$i]+$mypax[$i])."</td>";
                        //request std
                            echo "<td class=\"blue\">".($std[$i]+ $std_gl[$i])."</td>";
                        //disp std
                            echo "<td class=\"blue\">".$disp_standard[$i]."</td>";
                        // delta std
                            $delta_std = $disp_standard[$i]-($std[$i]+ $std_gl[$i]);
                                      if($delta_std < 0){
                                          echo "<td class=\"red_error\">".$delta_std."</td>";
                                      }else{
                                          echo "<td class=\"black\">".$delta_std."</td>";
                                      }
                          
                            
                        // request ensuite
                            echo "<td class=\"green\">".($ensuite[$i]+ $ensuite_gl[$i])."</td>";
                            
                        // disp ensuite
                            echo "<td class=\"green\">".$disp_ensuite[$i]."</td>";
                        // delta ensuite
                            $delta_ens = $disp_ensuite[$i]-($ensuite[$i]+ $ensuite_gl[$i]);
                                          if($delta_ens < 0){
                                              echo "<td class=\"red_error\">".$delta_ens."</td>";
                                          }else{
                                              echo "<td class=\"black\">".$delta_ens."</td>";
                                          }
                        // hs                  
                           echo "<td class=\"yellow\">".($hs[$i]+ $hs_gl[$i])."</td>";
                        //info

                           echo "<td>";
                                    if($valoreflag[$i]){
                                        echo "<a href=\"". base_url()."index.php/gestione_centri/info/".$mydata[$i]."/".$id ."\">";
                                        echo "<img src=\"".base_url()."images/info.jpeg\" alt=\"info\"/>";
                                        echo "</a>";
                                        };
                           echo "<tr>";             
                echo "</tr>";
                        }
                ?>

                          
                    
             </table>
          
                <ol>     
                    <li><a class="white" href="<?php echo base_url(); ?>index.php/agenti/enrol"><font color="blue">Booking form</font></a></li>
                    <li><a class="white" href="<?php echo base_url(); ?>index.php/agenti/logout"><font color="blue">Log-out</font></a></li>
                 </ol>
		</div>
		</div>
		
	
		<?php $this->load->view('agenti_footer');?>

</div>
    <?php   
    }
  ?>
</body>
</html>