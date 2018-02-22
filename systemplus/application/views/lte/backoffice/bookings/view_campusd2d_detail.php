    <table id="campusd2d" class="table table-bordered table-striped vertical-middle">
        <thead>
            <tr>
                <th>Booking id</th>
                <!--<th>Agent</th>-->
                <th>Date in</th>								
                <th>Date out</th>
                <th>Campus</th>
                <th>Pax</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $actualDate = $this->uri->segment(5);
            foreach ($bkgd2d as $book) {
                $da = explode("-", $book["arrival_date"]);
                $dd = explode("-", $book["departure_date"]);
                ?>
                <tr>
                    <td><?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?></td>
                    <!--<td><img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"] ?>.png" alt="<?php echo $book["businesscountry"] ?>" title="<?php echo $book["businesscountry"] ?>" /><?php echo $book["businessname"] ?></td>-->
                    <td class="center"<?php if ($actualDate == $book["arrival_date"]) { ?> style="background-color:#060;color:#fff;"<?php } ?>><?php echo $da[2] ?>/<?php echo $da[1] ?>/<?php echo $da[0] ?></td>
                    <td class="center"<?php if ($actualDate == $book["departure_date"]) { ?> style="background-color:#600;color:#fff;"<?php } ?>><?php echo $dd[2] ?>/<?php echo $dd[1] ?>/<?php echo $dd[0] ?></td>
                    <td><?php echo $book["centro"] ?></td>
                    <td class="center"><?php echo $book["pax_totali"] ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
<script>
//initDataTable("campusd2d");
</script>