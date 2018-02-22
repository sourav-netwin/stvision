    <table id="bus_exc_dt" class="table table-bordered table-striped vertical-middle">
        <thead>
            <tr>
                <th>Bus Code</th>
                <th>Excursion</th>
                <th>Excursion Date</th>
                <th>Pax</th>
                <th>View detail</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($detBusCodes as $bus) {
                ?>
                <tr>
                    <td class="center"<?php if ($bus["exb_confirmed"] == "YES") { ?> style="color:#090;"<?php } else { ?> style="color:#f00;"<?php } ?>><?php echo $bus["exb_buscompany_code"] ?></td>
                    <td class="center"><?php echo $bus["exc_excursion"] ?> | <?php echo $bus["exc_length"] ?></td>
                    <td class="center"><?php echo date("d/m/Y", strtotime($bus["exb_excursion_date"])) ?></td>
                    <td class="center"><?php echo $bus["exb_tot_pax"] ?></td>
                    <td class="center">
                        <a data-gravity="s" class="min-wd-24 btn btn-xs btn-primary dialogbtn" id="code_<?php echo $bus["exb_buscompany_code"] ?>" target="_blank" href="<?php echo base_url(); ?>index.php/backoffice/busExcDetail/code_<?php echo $bus["exb_buscompany_code"] ?>" title="View detail"><i class="fa fa-eye" ></i></a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
<script>
//initDataTable("bus_exc_dt");
</script>