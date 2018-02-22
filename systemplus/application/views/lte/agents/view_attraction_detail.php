<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<style>
    .form-group div:first-of-type{
        font-weight: bold;
        color: #444;
    }
    
    @media only screen and (min-width: 767px) {
        .form-group div:first-of-type{
            text-align: right;
        }
    }
    @media only screen and (max-width: 500px) {
        #headerId h4,#headerId label,#headerId .pull-right {
            text-align: center;
            width: 100%;
        }
    }
    #headerId label{
        font-weight: normal;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <?php showSessionMessageIfAny($this);
            $CC = $attraction[0];
            ?>
    </div>
    <div class="col-sm-12">
      <div class="box">
        <div class="box-header with-border">
            <div id="headerId">
                <h4 class="box-title"><i class="fa fa-globe"></i> 
                    <?php echo $CC['pat_name'] ?>
                </h4>
                <label><small><?php echo $CC['pat_entertainment_group'] ?></small></label>
                <div class="pull-right">
                    <span>
                    <?php echo $CC['patt_name'] ?>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="javascript:window.history.back();" data-toggle="tooltip" href="" title="Back to attractions">
                        <i class="fa fa-back"> Back to attractions</i>
                    </a>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="box-title">Attraction details</h4>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-3 col-md-3 col-lg-3">Description:</div>
                    <div class="col-sm-9 col-md-9 col-lg-9"><?php echo $CC['pat_desc']; ?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-3 col-md-3 col-lg-3">Address:</div>
                    <div class="col-sm-9 col-md-9 col-lg-9"><?php echo $CC['pat_address'] ?> - <?php echo $CC['cit_descrizione'] ?> (<?php echo $CC['cou_descrizione'] ?>)</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-3 col-md-3 col-lg-3">Map:</div>
                    <div class="col-sm-9 col-md-9 col-lg-9">
                        <div id="map-canvas" style="width: 100%; height: 300px;border:1px solid #aaa;"></div>
                        <input type="hidden" id="actualAddress" name="actualAddress" value="<?php echo $CC['pat_address'] ?>">
                        <input type="hidden" id="actualLat" name="actualLat" value="<?php echo $CC['pat_lat'] ?>, <?php echo $CC['pat_lat'] ?>">
                        <input type="hidden" id="actualLon" name="actualLon" value="<?php echo $CC['pat_lon'] ?>, <?php echo $CC['pat_lon'] ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-3 col-md-3 col-lg-3">Opening time:</div>
                    <div class="col-sm-9 col-md-9 col-lg-9"><?php echo $CC['pat_opening_time']; ?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-3 col-md-3 col-lg-3">Adult prices:</div>
                    <div class="col-sm-9 col-md-9 col-lg-9"><?php echo $CC['pat_adult_price'];?> <?php echo $CC['cur_codice'];?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-3 col-md-3 col-lg-3">Student prices:</div>
                    <div class="col-sm-9 col-md-9 col-lg-9"><?php echo $CC['pat_student_price'];?> <?php echo $CC['cur_codice'];?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-3 col-md-3 col-lg-3">Notes:</div>
                    <div class="col-sm-9 col-md-9 col-lg-9"><?php echo $CC['pat_notes_1'];?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-3 col-md-3 col-lg-3">Phone number:</div>
                    <div class="col-sm-9 col-md-9 col-lg-9"><?php echo $CC['pat_phone'];?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-3 col-md-3 col-lg-3">Email:</div>
                    <div class="col-sm-9 col-md-9 col-lg-9"><a href="mailto:<?php echo $CC['pat_email'] ?>" title="Write an email"><?php echo $CC['pat_email'] ?></a></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-3 col-md-3 col-lg-3">Website:</div>
                    <div class="col-sm-9 col-md-9 col-lg-9"><a href="<?php if(!strpos($CC['pat_website'],"http://")){ ?>http://<?php } ?><?php echo $CC['pat_website'] ?>" target="_blank" title="Visit official website"><?php echo $CC['pat_website'] ?></a></div>
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
      <?php if($viewBook==1){ ?>
        <div class="col-sm-12">
            <div class="box">
            <form>
            <div class="box-header with-border" style="overflow-y:auto;">
                    <h4 class="box-title">Book attraction</h4>
                    <?php 
                    if(count($all_books) > 0){
                    ?>
                    <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                    <tr>
                                            <th >Book id</th>
                                            <th >Campus</th>
                                            <th >Students</th>
                                            <?php /* <th >Estimated price</th> */ ?>
                                            <th>Book now</th>
                                    </tr>
                            </thead>
                            <tbody>
                                    <?php
                                            foreach($all_books as $eex){
                                    ?>
                                    <tr>
                                            <td ><?php echo $eex["id_year"]?>_<?php echo $eex["id_book"]?></td>
                                            <td ><?php echo $eex["centro"]?></td>
                                            <td ><?php echo $eex["tot_pax"]?></td>
                                            <?php /*<td ><?php echo number_format(str_replace(",",".",$CC['pat_student_price'])*1 * $eex["tot_pax"]*1,2,",","") ?> <?php echo $CC['cur_codice'] ?></td> */ ?>
                                            <td style="text-align:center;">
                                                    <div class="btn-group">
                                                        <a id="bookA_<?php echo $eex['id_year'];?>_<?php echo $eex['id_book'];?>_<?php echo $eex['id_centro'];?>" href="javascript:void(0);" name="Book attraction now" class="prenAtt min-wd-24 btn btn-xs btn-primary" >
                                                            <span data-original-title="Book attraction now" data-container="body" data-toggle="tooltip">
                                                                <i class="fa fa-edit"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                            </td>
                                    </tr>
                                    <?php
                                            }
                                    ?>
                            </tbody>
                    </table>
                    <?php
                    }else{
                    ?>
                    <table class="table table-bordered table-striped">
                            <tr><td>No confirmed bookings available</td></tr>
                    </table>							
                    <?php
                    }
                    ?>
                </form>	
                <form name="bookThisAtt" id="bookThisAtt" action="<?php echo base_url(); ?>index.php/agents/bookAttractionNow" method="POST">
                        <input type="hidden" name="hidIdAtt" id="hidIdAtt" value="<?php echo $idA?>">
                        <input type="hidden" name="hidIdBook" id="hidIdBook" value="">
                        <input type="hidden" name="hidIdYear" id="hidIdYear" value="">
                        <input type="hidden" name="hidIdCampus" id="hidIdCampus" value="">
                </form>
            </div>	
            </div>	
    </div>	
        <?php } ?>
    </div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSwGdc1633JshX29JtxSZzqt5sbgmUK-M&sensor=false"></script>
<script>
    pageHighlightMenu = "agents/viewAttractions";
    var geocoder;
    var map;

function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(-34.397, 150.644);

  var mapOptions = {
    zoom: 17,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.HYBRID
  }
  map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
}

function codeAddress() {
  var address = document.getElementById('actualAddress').value;
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
	  $("#actualLat").val(results[0].geometry.location.lat());
	  $("#actualLon").val(results[0].geometry.location.lng());
    } else {
      swal("Error",'Geocode was not successful for the following reason: ' + status);
    }
  });
}

function updateHidAddress(){
	$("#actualAddress").val($("#pat_address").val());
	codeAddress();
}
    
    
    $(document).ready(function() {
        initialize();
	codeAddress();
	
	$("#pat_address").blur(function(){
		updateHidAddress();		
	});
	
	$(".prenAtt").click(function(e){
		arrattID = ($(this).attr("id")).split("_");
		$("#hidIdYear").val(arrattID[1]);
		$("#hidIdBook").val(arrattID[2]);
		$("#hidIdCampus").val(arrattID[3]);
		$("#bookThisAtt").submit();
	});
    });
        
</script>