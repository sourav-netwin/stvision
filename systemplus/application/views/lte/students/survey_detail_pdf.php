<style>
    table td{
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
</style>
<div style="padding-bottom:50px;padding-top: 0;">
    <div style="text-align: center; margin-top: 15px">
        <h3><?php echo strtoupper($testTitle) ?> (Week <?php echo $week ?>)</h3>
    </div>
    <table style="width: 100%;"> 
        <tr>
            <td><strong>Campus:</strong> <?php echo $userDetails['nome_centri'] ?></td>
            <td><strong>From:</strong> <?php echo $fromDate ? date('d/m/Y', strtotime($fromDate)) : '' ?></td>
            <td><strong>To:</strong> <?php echo $toDate ? date('d/m/Y', strtotime($toDate)) : '' ?></td>
            <td><strong>Name:</strong> <?php echo $userDetails['cognome'] . ' ' . $userDetails['nome'] ?></td>
        </tr>
        <tr>
            <td colspan="2"><strong>Group Leader:</strong> <?php echo $GLName ?></td>
            <td colspan="2"><strong>Company travelling with: </strong> <?php echo $userDetails['businessname'] ?></td>
        </tr>
        <tr>
            <td>
                <div class="col-md-3"><img width="25" src="<?php echo base_url() ?>js/raty/img/survey/smiley-sad.png" /> - Poor</div>
            </td>
            <td>
                <div class="col-md-3"><img width="25" src="<?php echo base_url() ?>js/raty/img/survey/smiley-neutral.png" /> - Satisfactory</div>
            </td>
            <td>
                <div class="col-md-3"><img width="25" src="<?php echo base_url() ?>js/raty/img/survey/smiley.png" /> - Good</div>
            </td>
            <td>
                <div class="col-md-3"><img width="25" src="<?php echo base_url() ?>js/raty/img/survey/smiley-yell.png" /> - Excellent</div>
            </td>
        </tr>
        <?php
        if ($questionArray) {
            foreach ($questionArray as $heading => $questions) {
                echo "<tr><td colspan='4'><div style=' border-bottom: 1px solid rgb(194, 194, 194);clear: both;font-size: 15px;font-weight: bold;margin-bottom: 10px;margin-top: 5px;width: 100%;'>" . $heading . "</div></td></tr>";
                foreach ($questions as $question) {
                    
                    echo "<tr><td colspan='2'><div style='font-size: 14px;padding: 5px;'>" . $question['question'] . "</div></td>";
                    //echo '<div class="col-md-6 question-rate" style="padding: 5px;display: inline-block !important;width: auto !important;min-width: 105px;line-height: 29px;" data-start="' . $question['filled'] . '" data-rate="' . $question['starNo'] . '" id="survey_' . $question['id'] . '"></div>';
                    ?>
                        <td colspan='2'>
                            <div class='col-md-6 question-rate' style='padding: 5px; display: inline-block !important; width: auto !important; min-width: 105px; line-height: 29px; cursor: default;' title='Satisfactory'>
                                <?php echo getSurveyStarRating($question['filled'],$question['starNo']);?>
                            </div>
                        </td>
                    <?php
                    echo "</tr>";
            }
        }
    }
    ?>
    </table>
</div>