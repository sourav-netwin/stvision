<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<div class="row">
    <div class="col-xs-12">
        <form class="webservice-report-form" id="frmWebserviceReport" action="<?php echo base_url(); ?>index.php/webservice/report" method="post">
        <div class="box">
            <div class="box-header col-sm-12">
                <h3 class="box-title">Select options</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <?php showSessionMessageIfAny($this);?>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-4 mr-bot-10">
                        <label class="normal" for="txtAccompagnatore">Accompagnatore</label>
                        <select class="form-control" id="txtAccompagnatore" name="txtAccompagnatore">
                            <option value="">All</option>
                                <?php
                                if( $accompagnatore )
                                {
                                    foreach ( $accompagnatore as $data )
                                    {
                                ?>
                                    <option value="<?php echo $data['accompagnatore'];?>"><?php echo $data['accompagnatore'];?></option>
                                <?php
                                    }
                                }
                                ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-4 mr-bot-10  ">
                        <label class="normal" for="txtCollaboratore">Collaboratore</label>
                        <select class="form-control" id="txtCollaboratore" name="txtCollaboratore">
                            <option value="">All</option>
                            <?php
                            if( $collaboratore )
                            {
                                foreach ( $collaboratore as $data )
                                {
                            ?>
                                <option value="<?php echo $data['collaboratore'];?>"><?php echo $data['collaboratore'];?></option>
                            <?php
                                }
                            }
                            ?>
                    </select>
                    </div>
                    <div class="col-md-3 col-sm-4 mr-bot-10  ">
                        <label class="normal" for="txtProdotto">Prodotto</label>
                        <input class="form-control" type="text" id="txtProdotto" name="txtProdotto" value="">
                    </div>
                    <div class="col-md-3 col-sm-4 mr-bot-10  ">
                        <label class="normal" for="txtCodiceProdotto">Codice prodotto</label>
                        <select class="form-control" id="txtCodiceProdotto" name="txtCodiceProdotto">
                            <option value="">All</option>
                            <?php
                            if( $codice_prodotto )
                            {
                                foreach ( $codice_prodotto as $data )
                                {
                            ?>
                                <option value="<?php echo $data['codice_prodotto'];?>"><?php echo $data['codice_prodotto'];?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-4 mr-bot-10  ">
                        <label class="normal" for="txtPasseggero">Passeggero</label>
                        <input class="form-control" type="text" id="txtPasseggero" name="txtPasseggero" value="">
                    </div>
                    <div class="col-md-3 col-sm-4 mr-bot-10  ">
                        <label class="normal" for="selTipologiaPasseggero">Tipologia passeggero</label>
                        <select class="form-control" id="selTipologiaPasseggero" name="selTipologiaPasseggero">
                        <option value="">All</option>
                        <?php
                        if( $tipologia_passeggero )
                        {
                            foreach ( $tipologia_passeggero as $tp )
                            {
                        ?>
                            <option value="<?php echo $tp['tipologia_passeggero'];?>"><?php echo $tp['tipologia_passeggero'];?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                    </div>
                    <div class="col-md-3 col-sm-4 mr-bot-10  ">
                        <label class="normal" for="selGlf">Glf</label>
                        <select class="form-control" id="selGlf" name="selGlf">
                        <option value="">All</option>
                        <?php
                        if( $glf )
                        {
                            foreach ( $glf as $glf )
                            {
                        ?>
                            <option value="<?php echo $glf['glf'];?>"><?php echo $glf['glf'];?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="pull-right">
                    <input id="btnReport" type="submit" value="Report" class="btn btn-primary">
                </div>
            </div>
            <!-- /.box-footer-->
        </div>
        </form>
      </div>
    </div>
<script>
    var SITE_PATH = "<?php echo base_url(); ?>index.php/";
    $(document).ready(function() {
    });
</script>