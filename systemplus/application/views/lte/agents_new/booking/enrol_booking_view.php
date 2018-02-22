<p>
    <strong>Date in: </strong><?php echo date('d/m/Y', strtotime($book['enrol_arrival_date'])) ?>
</p>
<p>
    <strong>Date out: </strong><?php echo date('d/m/Y', strtotime($book['enrol_departure_date'])) ?>
</p>
<p><strong>Week(s): </strong><?php echo $book['enrol_number_of_week'] ?></p>
<p><strong>Enrolment Summary:</strong></p>
<p>
<table class="table table-bordered modal-table">
    <thead>
        <tr>
            <th>Type</th>
            <th>Composition</th>
            <th>Pax</th>
            <th>Free GL(s)</th>
            <th>Cost</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($booking_composition) {
            foreach ($booking_composition as $bc) {
                $package_comp = "";

                if ($bc['pcomp_week'] != "" && $bc['accom_name'] != "" && $bc['courses_type'] != "" && $bc['act_activity_name'] != "")
                    $package_comp = $bc['pcomp_week'] . ' Week - ' . $bc['accom_name'] . ' - ' . $bc['courses_type'] . ' - ' . $bc['act_activity_name'];
                else if ($bc['pcomp_week'] != "" && $bc['accom_name'] != "") {
                    if ($bc['courses_type'] == "" && $bc['act_activity_name'] == "") {
                        $package_comp = $bc['pcomp_week'] . ' Week - ' . $bc['accom_name'];
                    } else if ($bc['courses_type'] == "" && $bc['act_activity_name'] != "") {
                        $package_comp = $bc['pcomp_week'] . ' Week - ' . $bc['accom_name'] . ' - ' . $bc['act_activity_name'];
                    } else if ($bc['courses_type'] != "" && $bc['act_activity_name'] == "") {
                        $package_comp = $bc['pcomp_week'] . ' Week - ' . $bc['accom_name'] . ' - ' . $bc['courses_type'];
                    }
                }
                ?>
                <tr>
                    <td>
                        <?php echo $bc['booked_tipo_pax'] ?>
                    </td>
                    <td>
                        <?php echo $package_comp ?>
                    </td>
                    <td>
                        <?php echo $bc['cnt'] ?>
                    </td>
                    <td>
                        -
                    </td>
                    <td>
                        <?php
                        if ($bc['cnt'] >= 10 && $bc['cnt'] <= 19) {
                            $display_price = $bc['valuta'] . number_format($bc['cnt'] * $bc['pcomp_price_a'], 2, ',', '');
                        } else if ($bc['cnt'] >= 20 && $bc['cnt'] <= 39) {
                            $display_price = $bc['valuta'] . number_format($bc['cnt'] * $bc['pcomp_price_b'], 2, ',', '');
                        } else if ($bc['cnt'] >= 40) {
                            $display_price = $bc['valuta'] . number_format($bc['cnt'] * $bc['pcomp_price_c'], 2, ',', '');
                        } else {
                            $display_price = $bc['valuta'] . number_format($bc['cnt'] * $bc['pcomp_full_price'], 2, ',', '');
                        }
                        echo $display_price;
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
        if ($booking_accomodation) {
            $cnt = 0;
            foreach ($booking_accomodation as $ba) {
                ?>
                <tr>
                    <td>
                        <?php echo $ba['booked_tipo_pax'] ?>
                    </td>
                    <td>
                        <?php echo $book['enrol_number_of_week'] . ' Week - ' . $ba['accom_name'] ?>
                    </td>
                    <td>
                        <?php echo $ba['cnt'] ?>
                    </td>
                    <td>
                        <?php echo $ba['free_gl'] ?>
                    </td>
                    <td>
                        <?php
                        if ($book['free_gl_count'] > 0)
                            echo $ba['valuta'] . number_format(($ba['cnt'] - $ba['free_gl']) * ( $extra_gl_price * ( $book['enrol_number_of_week'] * 7 ) ), 2, ',', '');
                        else if ($free_pax_cnt > 0) {
                            if ($cnt == 0) {
                                $first_gl_price = $remaining_gl_price = 0;
                                $remaining_gl = $ba['cnt'] - 1;

                                if ($ba['cnt'] > 0) {
                                    $first_gl_price = ( ( $book['enrol_booked_students'] * $ba['serv_cost'] ) / $free_pax_cnt) * ( $book['enrol_number_of_week'] * 7 );
                                    $cnt++;
                                }

                                if ($remaining_gl > 0)
                                    $remaining_gl_price = $remaining_gl * ( $ba['serv_cost'] * ( $book['enrol_number_of_week'] * 7 ) );

                                $price = $first_gl_price + $remaining_gl_price;
                            }
                            else {
                                $price = ( ($ba['cnt'] - $ba['free_gl']) * ( $ba['serv_cost'] * ( $book['enrol_number_of_week'] * 7 ) ) );
                            }

                            echo $ba['valuta'] . number_format($price, 2, ',', '');
                        } else {
                            $price = ( ($ba['cnt'] - $ba['free_gl']) * ( $ba['serv_cost'] * ( $book['enrol_number_of_week'] * 7 ) ) );
                            echo $ba['valuta'] . number_format($price, 2, ',', '');
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
</p>