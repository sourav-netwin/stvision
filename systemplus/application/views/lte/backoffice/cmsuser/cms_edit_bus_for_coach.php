<link rel="stylesheet" href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css">
<div class="row">
    <?php
	showSessionMessageIfAny($this);
    ?>
</div>
<div class="row">
<form class="validate" name="persoprofile" id="persoprofile" action="<?php echo base_url(); ?>index.php/backoffice/cmsUpdateBusForCoach/<?php echo $idC?>/<?php echo $idB?>" method="POST">
<div class="col-md-12">
    <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Edit bus for <?php echo $company["tra_cp_name"]?></h4>
            <div class="pull-right">
                <a data-toggle="tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsManageBusCoaches/<?php echo $idC?>" title="Back to coach company bus">
                    <small>Back to coach company bus</small>
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="box-title mr-bot-10">
                <strong>Bus details</strong>
            </div>
            <div class="row form-group">
                <div class="col-sm-3 col-md-3 col-lg-2">Bus name (eg. Bus 29 seater):</div>
                <div class="form-data col-sm-9 col-md-9 col-lg-4">
                    <input type="text" name="tra_bus_name" id="tra_bus_name" class="required form-control" value="<?php echo htmlspecialchars($bus["tra_bus_name"])?>">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-3 col-md-3 col-lg-2">Seats:</div>
                <div class="col-sm-9 col-md-9 col-lg-4">
                    <input class="contastudenti form-control" data-type="spinner" name="tra_bus_seat" id="tra_bus_seat" value="<?php echo $bus["tra_bus_seat"]?>" min="0" max="100" />
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-offset-3 col-lg-offset-2 col-sm-9 col-md-9 col-lg-4">
                    <input id="updatebus" class="btn btn-primary" type="submit" value="Update bus" name="updatebus" />
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
</form>
</div>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script type="text/javascript">
    pageHighlightMenu = "backoffice/cmsManageCoaches";
    $(function(){
        $("#persoprofile").validate({
            errorElement:"div",
            ignore: "",
            rules: {
                tra_bus_name: "required",
                tra_bus_seat: "required"
            },
            messages: {
                tra_bus_name: "Please enter bus name",
                tra_bus_seat: "Please enter seat(s)"
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>