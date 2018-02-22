<?php $this->load->view('admin_header');?>
<?php $this->load->view('admin_menu_left');?>
<section id="main" class="column">
        <div id="header">
            <h1>Month review :</h1>
        </div>
        <div id="" class="tab_content">
            <table class="tablesorter">
                <tr>

                    <th>DATE IN</th>
                    <th>DATE OUT</th>
                    <th>GL</th>
                    <th>NUM. STUDENTS</th>
                    <th>REQ.  TEACHERS</th>
                    <th>EMPLOYED</th>
                    <th>MISS TEACHERS</th>
                    <th>INFO PAX</th>
                </tr>
                 <?php

                   foreach($passeggeri as $key=>$item):
                        if(count($passeggeri)){
                            

                                    //Formato Data

                            $eur_date_start = $item ['data_inizio'];
                            $eur_time_start = strtotime($eur_date_start);
                            $date_start=date('Y-m-d',$eur_time_start);
                   ?>
                        <tr>
                            <td><?php echo $date_start; ?></td>
                            <td><?php echo $item ['data_fine']; ?></td>
                            <td><?php echo $item ['id_gruppo']; ?></td>
                            <td><?php echo $item['tot_pax']; ?></td>
                            <td><?php echo (round($item['tot_pax']/12 ,2)); ?></td>
                            <td><?php echo $insegnanti; ?></td>
                            <td align="center">
                                <?php
                                    if (($item['tot_pax']/12 - $insegnanti)<0)
                                        echo '--';
                                   else
                                        echo (round($item['tot_pax']/12 - $insegnanti,2));
                                 ?>
                            </td>
                             <td align="center">
                                <?php
                                    if($item['id_centro']!=''){
                                 
                                     echo "<a href=\"". base_url()."index.php/Gestione_centri/info/".$date_start."/".$item['id_centro'] ."\">";
                                     echo "<img src=\"".base_url()."images/info.jpeg\" alt=\"info\"/>";
                                     echo "</a>";
                                 
                                    }
                                 ?>
                            </td>
                        </tr>
                 <?php
                            }
                         endforeach;
                    ?>
             </table>
            </div>
        <div id="cerca">
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/gestione_centri">Booking form</a></li>
                <li><a href="<?php echo base_url(); ?>index.php/gestione_centri/presearch">Booking review</a></li>
            </ul>
        </div>
</section>
<?php $this->load->view('admin_footer');?>