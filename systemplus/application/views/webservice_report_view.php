<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>plus-ed.com | Export By GL</title>
  </head>
  <body>
    <?php
      if( !empty( $report_table_data ) )
      {
    ?>
        <table width="100%">
          <tr>
            <td width="50%"><h4>Agent: <?php echo $report_table_data[0]['collaboratore']?></h4></td>
            <td width="50%" align="right"><h4>Year: <?php echo date('Y');?></h4></td>
          </tr>
        </table>

        <table cellspacing="0" border="1">
          <thead>
            <tr>
              <th colspan="9">Agent Statement</th>
            </tr>
            <tr>
              <th>Product Code</th>
              <th>Accomodation</th>
              <th>Type</th>
              <th>Group</th>
              <th>Country</th>
              <th>Level</th>
              <th>Pax</th>
              <th>Amount Per Pax</th>
              <th style="background-color: #ccc !important;">Total Reimbursement</th>
            </tr>
          </thead>
          <tbody>
          <?php
            foreach( $report_table_data as $rdata )
            {
          ?>
              <tr>
                <td style="text-align: center;"><?php echo $rdata['codice_prodotto']; ?></td>
                <td style="text-align: center;"><?php echo $rdata['accomodation']; ?></td>
                <td style="text-align: center;"><?php echo $rdata['type']; ?></td>
                <td style="text-align: center;"><?php echo $rdata['group']; ?></td>
                <td style="text-align: center;"><?php echo $rdata['country']; ?></td>
                <td style="text-align: center;"><?php echo $rdata['level']; ?></td>
                <td style="text-align: center;"><?php echo $rdata['pax']; ?></td>
                <td style="text-align: center;"><?php echo $rdata['amount_per_pax']; ?></td>
                <td style="text-align: right; background-color: #ccc !important;">
				<?php 
					if($rdata['codice_prodotto'] == 'Total')
					{
						echo $rdata['total_reimbursement'] - FEE_ACCOMPAGNAMENTO; 
					}else{
						echo $rdata['total_reimbursement']; 
					}
				?></td>
              </tr>
          <?php
            }
          ?>
          </tbody>
        </table>
    <?php
      }
      else
      {
        echo "Not eligible";
      }
    ?>
  </body>
</html>