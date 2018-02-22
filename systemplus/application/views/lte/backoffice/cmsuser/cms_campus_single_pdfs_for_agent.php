<?php
  if( $campus )
  {
?>
    <table id="dataTableCampusSinglePdfsForAgent" class="campus_table datatable table table-bordered table-striped">
      <thead>
        <tr>
          <th>Campus PDF title</th>
          <th>Campus PDF path</th>
          <th id="seqMe">Sequence</th>
          <th class="no-sort">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach( $campus as $cam )
          {
        ?>
            <tr>
              <td  data-sort="<?php echo $cam["title"];?>">
              <input style="width:210px;" type="text" class="form-control updateFileTitle" data-campus-id="<?php echo $cam['campus_id'];?>" data-id="<?php echo $cam['campus_single_pdf_id'];?>"  id="txtFileTitle<?php echo $cam["campus_single_pdf_id"]; ?>" autocomplete="off" maxlength="250" value="<?php echo $cam["title"];?>" />
              </td>
              <td><a href="<?php echo base_url() . CAMPUS_AGENTS_SINGLE_PDF_PATH. $cam["pdf_path"] ?>" title="<?php echo htmlentities($cam["pdf_path"]);?>" target="_blank"><?php echo (strlen($cam["pdf_path"]) > 25 ? substr($cam["pdf_path"], 0, 25) : $cam["pdf_path"]);?></a></td>
              <td class="text-center" data-sort="<?php echo $cam['sequence'];?>">
                  <input style="width:40px;text-align: center;" type="text" class="form-control updatePdfSequence" data-campus-id="<?php echo $cam['campus_id'];?>" data-id="<?php echo $cam['campus_single_pdf_id'];?>"  id="txtSequence<?php echo $cam["campus_single_pdf_id"]; ?>" autocomplete="off" maxlength="3" onkeypress="return keyRestrict(event, '1234567890');" value="<?php echo $cam['sequence'];?>" />
              </td>
              <td class="text-center">
                <div class="btn-group">

                  <span>
                    <a href="<?php echo base_url(); ?>index.php/backoffice/deleteCampusPdfForAgent/<?php echo $cam["campus_single_pdf_id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-danger min-wd-24" data-original-title="Delete PDF">
                      <i class="fa fa-trash-o"></i>
                    </a>
                  </span>

                </div>
              </td>
            </tr>
        <?php
          }
        ?>
      </tbody>
    <tfoot>
      <tr>
        <th>Campus PDF title</th>
        <th>Campus PDF path</th>
        <th>Action</th>
      </tr>
    </tfoot>
  </table>
<?php } ?>