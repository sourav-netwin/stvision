<?php $this->load->view('admin_header');?>
<?php $this->load->view('admin_menu_left');?>
<section id="main" class="column">
        <div id="header">
            <h1>Transfer to be confirmed out:</h1>
        </div>
    <div id="" class="tab_content">
            <table class="tablesorter">
                <tr>
                    <th>CENTER</th>
                    <th>AGENCY</th>
                    <th>N GP</th>
                    <th>GP</th>
                    <th>PAX</th>
                    <th>TRANSFER OUT</th> 
                    <th>DATE OUT</th>
                    <th>DEPARTURE TIME</th>
                    <th>DEPARTURE AIRPORT</th>
                    <th>N° FLIGHT</th>
                    <th>DEPARTURE SERVICE</th>
               </tr>

            <?php
          foreach($list_no_checkout as $key=>$item):
             if(count($list_no_checkout)){
?> 
                <tr>
                    <td><?php echo $item ['nome_centri']; ?></td>
                    <td><?php echo $item ['name']; ?></td>
                    <td><?php echo $item ['id_gruppo']; ?></td>
                    <td><?php echo $item ['gruppo']; ?></td>
                    <td><?php echo $item ['tot_pax']; ?></td>
                    <td><?php
                                if($item ['confirm_out']== 'YES'){
                                   echo "<img src=\"".base_url()."images/yes.jpg\" alt=\"info\"/>";
                                }else {
                                   echo "<img src=\"".base_url()."images/no.jpg\" alt=\"info\"/>";
                                }

                        ?>
                    </td>
                    <td><?php echo $item ['data_fine']; ?></td>
                    <td><?php echo $item ['ore_partenza']; ?></td>
                    <td><?php echo $item ['name_airport']; ?></td>
                    <td><?php echo $item ['n_volo_partenza']; ?></td>
                    <td>
                        <?php

                        if (strtotime($item ['ore_partenza']) <= strtotime('11:00:00')&& strtotime($item ['ore_partenza']) > strtotime('08:00:00')) {
                            echo 'BREAKFAST';
                            }elseif(strtotime($item ['ore_partenza']) <= strtotime('16:00:00')&& strtotime($item ['ore_partenza']) > strtotime('11:00:00')){
                                echo 'LUNCH';
                            }elseif(strtotime($item ['ore_partenza']) >= strtotime('19:00:00')&& strtotime($item ['ore_partenza']) <= strtotime('20:00:00')){
                                echo 'DINNER';
                            }elseif(strtotime($item ['ore_partenza']) > strtotime('20:00:00')|| strtotime($item ['ore_partenza']) <= strtotime('08:00:00')){
                                echo 'NONE';
                            }else{
                                echo 'NONE';
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
                <li><a href="<?php echo base_url(); ?>index.php/gestione_centri/list_confirm">Trasfert Status</a></li>
                <li><a href="<?php echo base_url(); ?>index.php/gestione_centri/list_no_checkin">T.B.C. in</a></li>
            </ul>
          <p> * T.B.C. = "To be confirmed" </p>
        </div>
</section>
<?php $this->load->view('admin_footer');?>
