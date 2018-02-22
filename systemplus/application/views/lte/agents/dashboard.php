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
        <div class="box box-default">
                            <div class="box-header with-border">
                            <i class="fa fa-bullhorn"></i>
                            <h3 class="box-title">Reminders</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
		<?php
		$adesso = strtotime("now");
                if($remindme)
                {
		foreach ($remindme as $remino) {
			$datagiro = strtotime($remino["r_data"]);
			$diffgiro = $datagiro - $adesso;
			if ($diffgiro > 0)
				$coloreg = "success";
			if ($diffgiro <= 0 and $diffgiro >= -86400)
				$coloreg = "warning";
			if ($diffgiro < -86400)
				$coloreg = "danger";
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
                                <div id="callout_<?php echo $remino["r_id"] ?>" class="callout callout-<?php echo $coloreg ?>">
                                    <h4>
                                        <i class="fa fa-calendar"></i>
                                        <?php echo $newdt ?> <?php echo $newti ?> - <?php echo $remino["r_agente"] ?>
                                    <div class="box-tools pull-right">
                                        <button id="remi_<?php echo $remino["r_id"] ?>" class="btn btn-block btn-primary btn-xs reminder-close" type="button">
                                        <img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/<?php echo $imgtipo ?>.png" > Mark as complete</button>
                                    </div></h4>
                                    <p><?php echo $remino["r_testo"] ?></p>
                                </div>
                            
			<?php
		}
                }
                else{
                    echo "<p>No reminder.</p>";
                }
		?>
                                </div>
                            <!-- /.box-body -->
                        </div>
		<?php
	}
	?>

	<?php 
	if ($this -> session -> userdata('role') != 100 && $this -> session -> userdata('role') != 200) {
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
				<div class="col-md-6">
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
				<div class="col-md-6">
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
                        </div>
                        <div class="row">
				<div class="col-md-6">
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
                                <div class="col-md-6">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><i class="fa fa-book error"></i>&nbsp; Extra excursions and attractions</h3>
                                            <div class="box-tools pull-right">
                                                    <button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
                                                            <i class="fa fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            Download PLUS Extra Excursion and Attraction booking form instructions and guidelines
                                        </div>
                                        <div class="box-footer text-center">
                                            <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/agents/downloadform">Download form</a>
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
<script>
$(document).ready(function() {
<?php if($this->session->userdata('role')==98){ ?>			
        $(".reminder-close").click(function(){
                var arremi = $(this).attr("id").split("_");
                var chiudo = arremi[1];
                $.ajax({
                        type: "POST",
                        data: "idremi=" + chiudo,
                        url: "<?php echo base_url(); ?>index.php/agents/completeReminder",
                        success:function(){
                            $("#callout_"+chiudo).remove();
                        }
                });
        });
<?php } ?>
});
</script>