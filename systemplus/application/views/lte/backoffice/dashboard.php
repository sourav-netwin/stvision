<link rel="stylesheet" href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css">
	<div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Plus Vision Dashboard</h3>

                <div class="box-tools pull-right">
                        <button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
                                <i class="fa fa-minus"></i></button>
                        <!--            <button title="Remove" data-toggle="tooltip" data-widget="remove" class="btn btn-box-tool" type="button">
                                                <i class="fa fa-times"></i></button>-->
                </div>
            </div>
            <div class="box-body">
                <p>
                        We have developed this website to allow you to interact with US as if you were with us in one of our offices. You will have the opportunity to visit our campus round the world by clicking on the agents video , to download materials, photos, en-roll online, review the status of your bookings and payments, all of this at the touch of a button.
                </p>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <i class="fa fa-info-circle"></i>&nbsp; If you need any <strong>help</strong> just send us a mail at <a href="mailto:agentsupport@plus-ed.com">agentsupport@plus-ed.com</a>
            </div>
            <!-- /.box-footer-->
	</div>

	<?php if ($this -> session -> userdata('role') == 98) { ?>

		<?php
		$adesso = strtotime("now");
		foreach ($remindme as $remino) {
			$datagiro = strtotime($remino["r_data"]);
			$diffgiro = $datagiro - $adesso;
			if ($diffgiro > 0)
				$coloreg = "success";
			if ($diffgiro <= 0 and $diffgiro >= -86400)
				$coloreg = "warning";
			if ($diffgiro < -86400)
				$coloreg = "error";
			//echo $coloreg."--".$diffgiro."<br />";

			$pieces = explode(" ", $remino["r_data"]);
			//print_r($pieces);
			$piecesdata = explode("-", $pieces[0]);
			$newdt = $piecesdata[2] . "/" . $piecesdata[1] . "/" . $piecesdata[0];
			$piecestime = explode(":", $pieces[1]);
			$newti = $piecestime[0] . ":" . $piecestime[1];
			switch ($remino["r_tipo"]) {
				case 0:
					$imgtipo = "mail";
					break;
				case 1:
					$imgtipo = "telephone-handset";
					break;
				case 2:
					$imgtipo = "skype";
					break;
				case 3:
					$imgtipo = "hand-shake";
					break;
				case 4:
					$imgtipo = "present";
					break;
			}
			?>
			<div class="alert <?php echo $coloreg ?>" style="padding-left:5px;">
				<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/calendar.png">
				<strong><?php echo $newdt ?> <?php echo $newti ?> - <?php echo $remino["r_agente"] ?>:</strong> <?php echo $remino["r_testo"] ?>
				<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/<?php echo $imgtipo ?>.png" style="float:right;margin-right:105px;">
				<span class="close" id="remi_<?php echo $remino["r_id"] ?>">Mark as complete</span>
			</div>
			<?php
		}
		?>

		<?php
	}
	?>

	<?php if ($this -> session -> userdata('ruolo') == "superuser") { ?>

		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-exclamation-circle error"></i>&nbsp; Bookings alerts (TO BE CONFIRMED) - All</h3>

				<div class="box-tools pull-right">
					<button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
						<i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php
				$now = time();
				foreach ($tbc_bk as $bk) {
					$your_date = strtotime($bk["data_insert"]);
					$difference = round(($now - $your_date) / 86400 * -1);
					//$your_date2 = strtotime($book[0]["arrival_date"]);
					//$dayToArrive = round(($now - $your_date2)/86400*-1);
					?>
					<div class="col-sm-2 col-md-2"><font <?php if ($difference < -3) { ?>class="error"<?php } ?>><?php echo date("d/m/Y", strtotime($bk["data_insert"])) ?> [<?php echo abs($difference) ?> days]</font></div><div class="col-sm-9 col-md-9"><b><?php echo $bk["id_year"] ?>_<?php echo $bk["id_book"] ?> | <?php echo $bk["centro"] ?></b> - <?php echo $bk["agency"]["businessname"] ?></div><div class="col-sm-1 col-md-1"><a href="javascript:void(0);" title="View detail" class="goToDetail pull-right" id="bkg__<?php echo $bk["id_book"] ?>">View</a></div>
					<?php
				}
				?>
			</div>
			<!-- /.box-body -->
		</div>

		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-exclamation-circle error"></i>&nbsp; Bookings alerts (ELAPSED - PAYMENT CHECKED) - All</h3>

				<div class="box-tools pull-right">
					<button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
						<i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php
				$now = time();
				$elapsed_sorted = array_reverse($elapsed_bk, TRUE);
				foreach ($elapsed_sorted as $bk) {
					$your_date = strtotime($bk["data_insert"]);
					$difference = round(($now - $your_date) / 86400 * -1);
					$your_date2 = strtotime($bk["arrival_date"]);
					$dayToArrive = round(($now - $your_date2) / 86400 * -1);
					$flag_paid = $bk["flag_paid"];
					//spostare a 20 anziche' 80 finiti i test e, nell'if successivo a 5 anziche' 50
					if ($flag_paid == 1) {
						?>
						<div class="row">
							<div class="col-sm-2 col-md-2"><font class="error"><?php echo date("d/m/Y", strtotime($bk["arrival_date"])) ?> [<?php echo abs($dayToArrive) ?> days]</font></div><div class="col-sm-9 col-md-9"><b><?php echo $bk["id_year"] ?>_<?php echo $bk["id_book"] ?> | <?php echo $bk["centro"] ?></b> - <?php echo $bk["agency"]["businessname"] ?></div><div class="col-sm-1 col-md-1"><a href="javascript:void(0);" title="View detail" class="goToDetail pull-right" id="bkg__<?php echo $bk["id_book"] ?>">View</a></div>
						</div>
						<?php
					}
				}
				?>
			</div>

		</div>

		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-exclamation-circle error"></i>&nbsp; Bookings alerts (ELAPSED) - 70 days from departure (50 days in red)</h3>

				<div class="box-tools pull-right">
					<button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
						<i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php
				$now = time();
				$elapsed_sorted = array_reverse($elapsed_bk, TRUE);
				foreach ($elapsed_sorted as $bk) {
					$your_date = strtotime($bk["data_insert"]);
					$difference = round(($now - $your_date) / 86400 * -1);
					$your_date2 = strtotime($bk["arrival_date"]);
					$dayToArrive = round(($now - $your_date2) / 86400 * -1);
					$flag_paid = $bk["flag_paid"];
					//spostare a 20 anziche' 70 finiti i test e, nell'if successivo a 5 anziche' 50
					if ($dayToArrive <= 70 && $flag_paid == 0) {
						?>
						<div class="row">
							<div class="col-sm-2 col-md-2"><font <?php if ($dayToArrive <= 50) { ?>class="error"<?php } ?>><?php echo date("d/m/Y", strtotime($bk["arrival_date"])) ?> [<?php echo abs($dayToArrive) ?> days]</font></div><div class="col-sm-9 col-md-9"><b><?php echo $bk["id_year"] ?>_<?php echo $bk["id_book"] ?> | <?php echo $bk["centro"] ?></b> - <?php echo $bk["agency"]["businessname"] ?></div><div class="col-sm-1 col-md-1"><a href="javascript:void(0);" title="View detail" class="goToDetail pull-right" id="bkg__<?php echo $bk["id_book"] ?>">View</a></div>
						</div>
						<?php
					}
				}
				?>
			</div>

		</div>

		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-exclamation-circle error"></i>&nbsp; Bookings alerts (CONFIRMED - NOT CLEARED FOR DEPARTURE)  - 70 days from departure (40 days in red)</h3>

				<div class="box-tools pull-right">
					<button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
						<i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php
				$now = time();
				$confirmed_sorted = array_reverse($confirmed_bk, TRUE);
				foreach ($confirmed_sorted as $bk) {
					$your_date = strtotime($bk["data_insert"]);
					$difference = round(($now - $your_date) / 86400 * -1);
					$your_date2 = strtotime($bk["arrival_date"]);
					$dayToArrive = round(($now - $your_date2) / 86400 * -1);
					$flag_cfd = $bk["flag_cfd"];
					//spostare a 20 anziche' 70 finiti i test e, nell'if successivo a 5 anziche' 40
					if ($dayToArrive <= 70 && $flag_cfd == 0) {
						?>
						<div class="row">
							<div class="col-sm-2 col-md-2"><font <?php if ($dayToArrive <= 40) { ?>class="error"<?php } ?>><?php echo date("d/m/Y", strtotime($bk["arrival_date"])) ?> [<?php echo abs($dayToArrive) ?> days]</font></div><div class="col-sm-9 col-md-9"><b><?php echo $bk["id_year"] ?>_<?php echo $bk["id_book"] ?> | <?php echo $bk["centro"] ?></b> - <?php echo $bk["agency"]["businessname"] ?></div><div class="col-sm-1 col-md-1"><a href="javascript:void(0);" title="View detail" class="goToDetail pull-right" id="bkg__<?php echo $bk["id_book"] ?>">View</a></div>
						</div>
						<?php
					}
				}
				?>
			</div>

		</div>

		<?php
	}
	if ($this -> session -> userdata('ruolo') == "contabile") {
		?>

		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-exclamation-circle error"></i>&nbsp; Bookings alerts (ELAPSED - CHECK FOR PAYMENT) - All</h3>

				<div class="box-tools pull-right">
					<button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
						<i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php
				$now = time();
				$elapsed_sorted = array_reverse($elapsed_bk, TRUE);
				foreach ($elapsed_sorted as $bk) {
					$your_date = strtotime($bk["data_insert"]);
					$difference = round(($now - $your_date) / 86400 * -1);
					$your_date2 = strtotime($bk["arrival_date"]);
					$dayToArrive = round(($now - $your_date2) / 86400 * -1);
					$flag_checkpay = $bk["flag_checkpay"];
					$flag_paid = $bk["flag_paid"];
					//spostare a 20 anziche' 80 finiti i test e, nell'if successivo a 5 anziche' 50
					if ($flag_checkpay == 1 && $flag_paid == 0) {
						?>
						<div class="row">
							<div class="col-sm-2 col-md-2"><font class="error"><?php echo date("d/m/Y", strtotime($bk["arrival_date"])) ?> [<?php echo abs($dayToArrive) ?> days]</font></div><div class="col-sm-9 col-md-9"><b><?php echo $bk["id_year"] ?>_<?php echo $bk["id_book"] ?> | <?php echo $bk["centro"] ?></b> - <?php echo $bk["agency"]["businessname"] ?></div><div class="col-sm-1 col-md-1"><a href="javascript:void(0);" title="View detail" class="goToDetail pull-right" id="bkg__<?php echo $bk["id_book"] ?>">View</a></div>
						</div>
						<?php
					}
				}
				?>
			</div>

		</div>

		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-exclamation-circle error"></i>&nbsp; Bookings alerts (ACTIVE) - 60 days from departure (45 days in red)</h3>

				<div class="box-tools pull-right">
					<button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
						<i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php
				$now = time();
				$active_sorted = array_reverse($active_bk, TRUE);
				foreach ($active_sorted as $bk) {
					$your_date = strtotime($bk["data_insert"]);
					$difference = round(($now - $your_date) / 86400 * -1);
					$your_date2 = strtotime($bk["arrival_date"]);
					$dayToArrive = round(($now - $your_date2) / 86400 * -1);
					$flag_paid = $bk["flag_paid"];
					//spostare a 20 anziche' 60 finiti i test e, nell'if successivo a 5 anziche' 45
					if ($dayToArrive <= 60) {
						?>
						<div class="row">
							<div class="col-sm-2 col-md-2"><font <?php if ($dayToArrive <= 45) { ?>class="error"<?php } ?>><?php echo date("d/m/Y", strtotime($bk["arrival_date"])) ?> [<?php echo abs($dayToArrive) ?> days]</font></div><div class="col-sm-9 col-md-9"><b><?php echo $bk["id_year"] ?>_<?php echo $bk["id_book"] ?> | <?php echo $bk["centro"] ?></b> - <?php echo $bk["agency"]["businessname"] ?></div><div class="col-sm-1 col-md-1"><a href="javascript:void(0);" title="View detail" class="goToDetail pull-right" id="bkg__<?php echo $bk["id_book"] ?>">View</a></div>
						</div>
						<?php
					}
				}
				?>
			</div>

		</div>

		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-exclamation-circle error"></i>&nbsp; Bookings alerts (CONFIRMED) - 70 days from departure (40 days in red) - <font style="text-decoration:underline;">Green flag</font>: Cleared for Departure / <font style="text-decoration:underline;">White flag</font>: Not yet Cleared</h3>

				<div class="box-tools pull-right">
					<button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
						<i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php
				$now = time();
				$confirmed_sorted = array_reverse($confirmed_bk, TRUE);
				foreach ($confirmed_sorted as $bk) {
					$your_date = strtotime($bk["data_insert"]);
					$difference = round(($now - $your_date) / 86400 * -1);
					$your_date2 = strtotime($bk["arrival_date"]);
					$dayToArrive = round(($now - $your_date2) / 86400 * -1);
					$flag_cfd = $bk["flag_cfd"];
					//spostare a 20 anziche' 70 finiti i test e, nell'if successivo a 5 anziche' 40
					if ($dayToArrive <= 70) {
						?>
						<div class="row">
							<div class="col-sm-2 col-md-2"><font <?php if ($dayToArrive <= 40) { ?>class="error"<?php } ?>><?php echo date("d/m/Y", strtotime($bk["arrival_date"])) ?> [<?php echo abs($dayToArrive) ?> days]</font></div><div class="col-md-7"><img src="http://plus-ed.com/vision_ag/img/icons/packs/fugue/16x16/flag-<?php if ($flag_cfd == 1) { ?>green<?php
			}
			else {
							?>white<?php } ?>.png" class="icon"><b><?php echo $bk["id_year"] ?>_<?php echo $bk["id_book"] ?> | <?php echo $bk["centro"] ?></b> - <?php echo $bk["agency"]["businessname"] ?></div><div class="col-sm-2 col-md-2"><em class="pull-right text-bold"><?php echo $bk["saldoBilancio"] ?></em></div><div class="col-sm-1 col-md-1"><a href="javascript:void(0);" title="View detail" class="goToDetail pull-right" id="bkg__<?php echo $bk["id_book"] ?>">View</a></div>
						</div>
						<?php
					}
				}
				?>
			</div>

		</div>

		<?php
	}
	if ($this -> session -> userdata('role') == 100) {
		?>

		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title width-full"><i class="fa fa-ticket error"></i>&nbsp; Ticket alerts  - Newest 20 numbers <span style="color: #FF0000">[<?php echo $openCount ?> Open Tickets]</span> <a class="pull-right" href="<?php echo site_url() . '/ticketmanagement' ?>" >View all tickets</a></h3>

				<div class="box-tools pull-right">
					<button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
						<i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php
				$now = time();
				$confirmed_sorted = array_reverse($confirmed_bk, TRUE);
				if (!empty($open_tickets)) {
					foreach ($open_tickets as $ticket) {
						$openDate = date('d/m/Y', strtotime($ticket['ptc_created_time'])) . '[' . ($ticket['dateDf'] == 0 ? 'Today' : $ticket['dateDf'] . ' Day(s)' ) . ']';
						$message = strlen($ticket['ptc_content']) > 100 ? substr($ticket['ptc_content'], 0, 100) . '...' : $ticket['ptc_content'];
						?>
						<div class="row">
							<div class="col-sm-2 col-md-2"><font class="error"><?php echo $openDate ?></font></div><div class="col-sm-10 col-md-10"><b><?php echo $ticket['nome_centri'] ? $ticket['nome_centri'] . ' | ' . $ticket['ptc_sender_type'] . ' | ' . $ticket['ptc_title'] : 'ALL | ' . $ticket['ptc_title'] ?></b> - <?php echo $message ?></div>
						</div>
						<?php
					}
				}
				?>
			</div>

		</div>

		<?php
	}
	if ($this -> session -> userdata('role') != 100 && $this -> session -> userdata('role') != 200  && $this -> session -> userdata('role') != 553) {
		if ($this -> session -> userdata('role') != 97) {
			?>

			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-flag error"></i>&nbsp; How to upload your pax lists</h3>

					<div class="box-tools pull-right">
						<button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
							<i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<a href="<?php echo base_url(); ?>index.php/agents/insertedBookings" title="Review your bookings"><strong>In the "Booking review" section</strong></a>, you'll find the excel sheet which we ask you to fill for each Group booking with all the details for students and group leaders who will attend our programmes this summer.<br />The information provided is very important to secure all services and well being for all our students. <br /><a href="<?php echo base_url(); ?>downloads/extras/guide_for_upload_list_vision.pdf" target="_blank" title="Guide for upload list"><strong>Download here the brief description</strong></a> of the fields you are asked to fill in and why we need them, we also ask you to follow the instructions on how to fill in the information required.<br />Once you have filled in all the relevant details please forward to <a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a> using the book id as subject.
				</div>
				<div class="box-footer">
					<i class="fa fa-info-circle"></i>&nbsp; If you need any <strong>help</strong> just send us a mail at <a href="mailto:agentsupport@plus-ed.com">agentsupport@plus-ed.com</a>
				</div>

			</div>

			<div class="row">
				<div class="col-md-4">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title"><i class="fa fa-book error"></i>&nbsp; Enrol</h3>

							<div class="box-tools pull-right">
								<button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
									<i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body">
							Check the availability and make your own booking at any of our destination.
						</div>
						<div class="box-footer text-center">
							<a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/agents/enrol">Enter</a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title"><i class="fa fa-object-ungroup error"></i>&nbsp; Download marketing materials</h3>

							<div class="box-tools pull-right">
								<button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
									<i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body">
							Download brochures, agents manual, price list accommodation factsheet and more.
						</div>
						<div class="box-footer text-center">
							<a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/agents/mkt_material_pj">Enter</a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title"><i class="fa fa-book error"></i>&nbsp; Review your bookings</h3>

							<div class="box-tools pull-right">
								<button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
									<i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body">
							Review the status of each reservation for all our brands.
						</div>
						<div class="box-footer text-center">
							<a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/agents/insertedBookings">Enter</a>
						</div>
					</div>
				</div>
			</div>

			<?php
		}
	}
	?>


<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo LTE; ?>custom/backoffice.js"></script>
<script type="text/javascript">
<?php if ($this -> session -> userdata('ruolo') == "contabile") { ?>

		//document.getElementById('addPaymentFinCon').reset();

		$('body').on('click',".pDeleteMe",function(){
			var bookId = $('#bkDetBookId').val();
			var elm = $(this);
			confirmAction("Are you sure you want to remove this line?", function(s){
				if(s){
					var DatKo = elm.attr("id").split("_");
					var idToDel = DatKo[1];
					request = $.ajax({
						url: siteUrl + "backoffice/deleteSinglePayment/"+idToDel
					});
					request.done(function (response, textStatus, jqXHR){
						loadBookingDetail(bookId,'f');
					});
				}
			},true,true);
		});




		$('body').on('change',"#P_typePay",function(){
			if($(this).val()=="acq"){
				$("#P_curDate").attr("disabled",true);
				$("#P_method").attr("disabled",true);
			}else{
				$("#P_curDate").prop("disabled",false);
				$("#P_method").prop("disabled",false);
			}
		});



		$('body').on('click','#P_add',function(){
			if($("#P_amount").val()==""){
				swal("Error","Please insert the amount!");
				return false;
			}
			if($("#P_typePay").val()!="acq"){
				if($("#P_curDate").val()==""){
					swal("Error","Please insert the currency date!");
					return false;
				}
			}
			var bookId = $('#bkDetBookId').val();
			confirmAction("Are you sure you want to add this payment?", function(s){
				if(s){
					var passingData = $('#addPaymentFinCon').serialize();
					var $inputs = $('#addPaymentFinCon').find("input, select, button, textarea");
					$inputs.prop("disabled", true);
					$.ajax({
						url: siteUrl + "backoffice/insertSinglePayment",
						type: "post",
						data: passingData,
						success: function(){
							$inputs.prop("disabled", false);
							swal('Success', 'Payment added successfully');
							loadBookingDetail(bookId,'f');
						},
						error:function(){
							swal('Error','Failed to add payment');
						}
					});
				}
			},true,true);
		});

		$('body').on('click',"#B_notificaPayment",function(){
			if($("#statusPaymentFinCon").val()=="B_paid"){
				bPaid();
			}
		});

		$('body').on('click',"#B_notificaCleared",function(){
			if($("#statusClearedFinCon").val()=="B_cleared"){
				bCleared();
			}
		});

<?php } ?>
</script>