<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Bookings</h4>
                <a class="pull-right" data-toggle="tooltip" href="<?php echo base_url(); ?>downloads/extras/view_and_book_excursions_and_attractions_guide.pdf" target="_blank" title="Guide for upload list">
                    <i class="fa fa-info-circle"> How to book extra excursions</i>
                </a>
        </div>
        <div class="box-body">
            <?php showSessionMessageIfAny($this);?>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" >Booking id</th>
                            <th class="text-center" >Campus</th>
                            <th class="text-center" >Date in</th>						
                            <th class="text-center" >Date out</th>
                            <th class="text-center" >Weeks</th>
                            <th class="text-center" >Pax</th>
                            <th class="text-center" >Book now</th>
                            <th class="text-center" >Qty. booked</th>									
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($all_books as $book){
                                $da=explode("-",$book["arrival_date"]);
                                $dd=explode("-",$book["departure_date"]);
                                $ds=explode("-",$book["data_scadenza"]);
                                $accos=$book["all_acco"];								
                        ?>
                                <tr>
                                    <td class="text-center"><?php echo $book["id_year"]?>_<?php echo $book["id_book"]?></td>
                                    <td><?php echo $book["centro"]?></td>
                                    <td class="text-center"><?php echo $da[2]?>/<?php echo $da[1]?>/<?php echo $da[0]?></td>
                                    <td class="text-center"><?php echo $dd[2]?>/<?php echo $dd[1]?>/<?php echo $dd[0]?></td>
                                    <td class="text-center"><?php echo $book["weeks"]?></td>
                                    <td class="text-center"><?php echo $book["tot_pax"]?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="<?php echo base_url(); ?>index.php/agents/bookExtraNow/<?php echo $book["id_book"]?>/<?php echo $book["id_centro"]?>/<?php echo $book["id_year"]?>" data-toggle="modal" class="min-wd-24 btn btn-xs btn-primary" >
                                                <span data-original-title="Book extra excursion for booking <?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" data-container="body" data-toggle="tooltip">
                                                    <i class="fa fa-edit"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-center"><?php echo $book["conta_ex"]?></td>
                                </tr>
                        <?php
                                }
                        ?>
                        </tbody>
                </table>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
      </div>
    </div>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    pageHighlightMenu = "agents/bookExtraExcursions/confirmed/id_centro/asc";
	$(document).ready(function() {
                
	});
</script>