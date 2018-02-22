<div class="margin-5">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Campus</th>
				<th>Nationalities</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ($campTemp) {
				$cnt = 0;
				foreach ($campTemp as $camp => $temp) {
					$dataCnt = 0;
					$dataVal = '';
					if (sizeof($temp) == 1) {
						if (isset($tempNoNationality[$temp[0]])) {
							if (!empty($tempNoNationality[$temp[0]])) {
								$dataCnt += 1;
								$dataVal = $tempNoNationality[$temp[0]];
							}
						}
					}
					if (sizeof($temp) == 2) {
						$ary1 = explode(', ', $tempNoNationality[$temp[0]]);
						$ary2 = explode(', ', $tempNoNationality[$temp[1]]);
						$dataVal = implode(', ', array_intersect($ary1, $ary2));
						if (!empty($dataVal)) {
							$dataCnt += 1;
						}
					}
					if (sizeof($temp) == 3) {
						$ary1 = explode(', ', $tempNoNationality[$temp[0]]);
						$ary2 = explode(', ', $tempNoNationality[$temp[1]]);
						$ary3 = explode(', ', $tempNoNationality[$temp[2]]);
						$dataVal = implode(', ', array_intersect($ary1, $ary2, $ary3));
						if (!empty($dataVal)) {
							$dataCnt += 1;
						}
					}
					if ($dataCnt > 0) {
						?>
						<tr>
							<td><?php echo ($cnt += 1); ?></td>
							<td><?php echo $camp ?></td>
							<td>
								<?php
								echo $dataVal;
								?>
							</td>

						</tr>
						<?php
					}
				}
			}
			?>
		</tbody>
	</table>
</div>

