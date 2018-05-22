<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Welcome to PLUS</h3>
            <div class="box-tools pull-right">
                <button title="Collapse" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button">
                    <i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <?php if(!$testSubmitedStatus):?>
                <a class="nav-links" href="<?php echo base_url(); ?>index.php/students/englishtest">
                <?php endif;?>
                    <div class="col-sm-4">
                        <!-- small box -->
                        <div class="small-box bg-aqua" style="min-height: 110px;">
                            <div class="inner">
                                <h4>Placement test 2018</h4>
                                <?php if($testSubmitedStatus):?>
                                <p>Test is already submitted</p>
                                <?php else:?>
                                <p>Click here to do the test</p>
                                <?php endif;?>
                            </div>
                            <div class="icon">
                                <i class="fa fa-edit"></i>
                            </div>
    <!--                        <a href="#" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </a>-->
                        </div>
                    </div>
                <?php if(!$testSubmitedStatus):?>
                </a>
                <?php endif;?>
                <!-- ./col -->
                <a class="nav-links" href="<?php echo base_url(); ?>index.php/student_survey">
                    <div class="col-sm-4">
                        <!-- small box -->
                        <div class="small-box bg-green" style="min-height: 110px;">
                            <div class="inner">
                                <h4>End of course student survey</h4>

                                <p>Click here to complete survey</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="box-footer">
            &nbsp;
        </div>
    </div>

</section>
<style>
    .nav-links:hover{
        font-weight: bold;
    }
    @media only screen and (max-width: 600px) {
        .small-box .icon{
            right:28%;
            display:block!important;
        }
    }
</style>
<script>
    $(function () {
        // your code
    });
</script>