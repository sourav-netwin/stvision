<?php
	if( $price_result )
	{
?>
		<table class="table table-bordered" id="package_comp_table">
			<thead>
				<th>
					Package composition
				</th>
				<th>
					Full price
				</th>
				<th>
					Price A (10 to 19 pax)
				</th>
				<th>
					Price B (20 to 39 pax)
				</th>
				<th>
					Price C (40 pax and over)
				</th>
			</thead>
			<tbody>
				<?php
					foreach ( $price_result as $pr )
					{
				?>
						<tr id="pack_comp_<?php echo $pr['pcomp_id']; ?>">
							<td>
								<?php
									if( $pr['pcomp_week'] != "" && $pr['accom_name'] != "" && $pr['courses_type'] != "" && $pr['act_activity_name'] != "" )
										echo $pr['pcomp_week'].' Week - '.$pr['accom_name'].' - '.$pr['courses_type'].' - '.$pr['act_activity_name'];
									else if ( $pr['pcomp_week'] != "" && $pr['accom_name'] != "" )
									{
										if( $pr['courses_type'] == "" && $pr['act_activity_name'] == "" )
										{
											echo $pr['pcomp_week'].' Week - '.$pr['accom_name'];
										}
										else if( $pr['courses_type'] == "" && $pr['act_activity_name'] != "" )
										{
											echo $pr['pcomp_week'].' Week - '.$pr['accom_name'].' - '.$pr['act_activity_name'];
										}
										else if( $pr['courses_type'] != "" && $pr['act_activity_name'] == "" )
										{
											echo $pr['pcomp_week'].' Week - '.$pr['accom_name'].' - '.$pr['courses_type'];
										}
									}
								?>
							</td>
							<td><?php echo $pr['valuta'].number_format($pr['pcomp_full_price'], 2, ',', ''); ?></td>
							<td><?php echo $pr['valuta'].number_format($pr['pcomp_price_a'], 2, ',', ''); ?></td>
							<td><?php echo $pr['valuta'].number_format($pr['pcomp_price_b'], 2, ',', ''); ?></td>
							<td><?php echo $pr['valuta'].number_format($pr['pcomp_price_c'], 2, ',', ''); ?></td>
						</tr>
				<?php
					}
				?>
			</tbody>
		</table>
<?php
	}
?>
<script type="text/javascript">
	var myVar;
	$(document).ready( function(){

		$(document).on("input",".st_pack_comp", function(){
			var pax_count = $(this).val();
			var pack_comp_id = $(this).attr('data-id');

			$.ajax({
        type: "POST",
        data: { "pax_count": pax_count, "pack_comp_id" : pack_comp_id },
        url: "<?php echo base_url(); ?>index.php/agentbooking/packageCompositionPrice",
        success: function( data ) {
        	var result = JSON.parse(data);
        	$("#st_price_"+pack_comp_id).val( result.display_price );
        	$("#st_price_"+pack_comp_id).attr( 'data-price', result.price );
        	$("#st_price_"+pack_comp_id).attr( 'data-currency', result.currency );

        	var sum_tot = 0;
        	$(".tot_price").each(function( index ) {
        		if( $( this ).val() != "" )
        			sum_tot = parseInt(sum_tot) + parseInt($( this ).attr('data-price'));
					  $("#total_price").val(result.currency+formatNumber(sum_tot));
				  	$("#total_price").attr('data-value', sum_tot);
					});
        }
      });
		});

		$(document).on("input",".grp_l_pack_comp", function() {
			calculateFreeGl();
		});

	});

	function formatNumber(num)
	{
   	num = "" + Math.floor(num*100.0 + 0.5)/100.0;

		var i=num.indexOf(".");

		if ( i<0 )
			num+=",00";
		else
		{
			num=num.substring(0,i) + "," + num.substring(i + 1);
			i=(num.length - i) - 1;
			if ( i==0 )
				num+="00";
			else if ( i==1 )
				num+="0";
			else if ( i>2 )
				num=num.substring(0,i + 3);
		}

		return num;
	}
</script>