<?php
  if( $campus )
  {
?>
    <table id="dataTableCampusSinglePdf" class="campus_table datatable table table-bordered table-striped">
      <thead>
        <tr>
          <th>Campus PDF title</th>
          <th>Campus PDF path</th>
          <th class="no-sort">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach( $campus as $cam )
          {
        ?>
            <tr>
              <td><?php echo $cam["title"]?></td>
              <td><a href="<?php echo base_url() . CAMPUS_SINGLE_PDF_PATH. $cam["pdf_path"] ?>" target="_blank"><?php echo $cam["pdf_path"]?></a></td>
              <td class="text-center">
                <div class="btn-group">

                  <span>
                    <a href="<?php echo base_url(); ?>index.php/backoffice/deleteCampusPdf/<?php echo $cam["campus_single_pdf_id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-danger min-wd-24" data-original-title="Delete PDF">
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