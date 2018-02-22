<?php
  if( $campus )
  {
?>
    <table id="dataTableCampusImage" class="campus_table datatable table table-bordered table-striped">
      <thead>
        <tr>
          <th>Title</th>
          <th>Category</th>
          <th>Image</th>
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
              <td><?php echo ucfirst( $cam["category"] )?></td>
              <td>
                <a href="<?php echo base_url() . CAMPUS_IMAGE_PATH. $cam["image_path"] ?>" target="_blank"><?php echo $cam["image_path"]?></a>
              </td>
              <td class="text-center">
                <div class="btn-group">

                  <span>
                    <a href="<?php echo base_url(); ?>index.php/backoffice/deleteCampusImage/<?php echo $cam["campus_image_id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-danger min-wd-24" data-original-title="Delete image">
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
        <th>Title</th>
        <th>Category</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
    </tfoot>
  </table>
<?php } ?>