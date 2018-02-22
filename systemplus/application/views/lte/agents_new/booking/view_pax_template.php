<div class="container-fluid">
  <?php
    $lockAll = 0;
    if( $booking_details['enrol_lock_pax'] == '1' )
    {
  ?>
      <div class="row">
        <div class="col-sm-3">
          Initial page template
        </div>
        <div class="col-sm-6 form-group">
          <?php
            if ($booking_details['enrol_template'] != '')
            {
              $tempTitle = '';
              if ($booking_details["enrol_template"] == 'UKIR')
                $tempTitle = 'UK/Ireland';
              if ($booking_details["enrol_template"] == 'USA')
                $tempTitle = 'USA';
              if ($booking_details["enrol_template"] == 'MAL')
                $tempTitle = 'Malta';
              if ($booking_details['enrol_template'] == 'UKIRGLSTD')
                $tempTitle = 'UK/Ireland - GL Standard';
              if ($booking_details['enrol_template'] == 'UKIRSTDSTD')
                $tempTitle = 'UK/Ireland - STD Standard';
              if ($booking_details['enrol_template'] == 'UKIRSTDST')
                $tempTitle = 'UK/Ireland - STD Short Term';

              $lockAll += 1;
          ?>
              <input type="hidden" value="<?php echo $booking_details['enrol_template']; ?>" id="initTmpl" />
              <select disabled="disabled" title="<?php echo $tempTitle; ?>" class="form-control">
                <option selected="selected" value="<?php echo $booking_details['enrol_template']; ?>"><?php echo $tempTitle; ?></option>
              </select>
          <?php
              }
              else
              {
          ?>
                <div class="col-sm-4 form-group">
                  <select id="initTmpl" class="form-control">
                  <?php
                    $selLoc = array();
                    $dspCnt = 1;
                    $marSus = 0;
                    foreach ( $booked_pax as $mypax )
                    {
                      $locAdd = 0;
                      foreach ($templates as $template)
                      {
                      $chk = 0;
                      $location = '';
                      if ($template['template'] == 'USA') {
                        $location = 'USA';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                          $chk += 1;
                        }
                      }
                      if ($template['template'] == 'UKIR') {
                        $location = 'UK/Ireland';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                          $chk += 1;
                        }
                      }
                      if ($template['template'] == 'MAL') {
                        $location = 'Malta';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                          $chk += 1;
                        }
                      }
                      if ($template['template'] == 'UKIRGLSTD') {
                        $location = 'UK/Ireland - GL Standard';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                          $chk += 1;
                        }
                      }
                      if ($template['template'] == 'UKIRSTDSTD') {
                        $location = 'UK/Ireland - STD Standard';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                          $chk += 1;
                        }
                      }
                      if ($template['template'] == 'UKIRSTDST') {
                        $location = 'UK/Ireland - STD Short Term';
                        if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
                          $chk += 1;
                        }
                      }
                      if (($chk > 0) && (!in_array($location, $selLoc))) {
                        $selLoc[] = $location;
                        $marSus += 1;
                        if ($dspCnt == 1) {
                          ?>
                          <option value="">Select</option>
                          <?php
                          $dspCnt += 1;
                        }
                        ?>
                        <option value="<?php echo $template['template'] ?>"><?php echo $location ?></option>
                        <?php
                      }
                      $chk = 0;
                    }
                  }
                  if ($marSus == 0) {
                    ?>
                    <option value="">NA</option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-sm-2">
                <span class="selInitTmplDemo" title="Preview Template" style="display: none; vertical-align: middle; font-size: 30px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i>
                </span>
              </div>

              <?php
            }
            ?>


          </div>
        </div>
  <?php
    }
    if( !empty($booked_pax) )
    {
  ?>
      <table id="NA_Roster" class="table table-bordered table-condensed table-striped">
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th>Name</th>
            <th class="text-center">Template</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $counter = 1;
            foreach ( $booked_pax as $pax )
            {
        	?>
            	<tr>
                <td class="text-center"><?php echo $counter ?></td>
                <td class="infoPax">
                  <span <?php if ($pax["booked_tipo_pax"] == "GL") { ?> class="tdGl infoName" <?php } else { ?> class="infoName" <?php } ?>><?php echo $pax["booked_pax_surname"] ?> <?php echo $pax["booked_pax_name"] ?></span>
                </td>
                <td class="text-center" id="td_<?php echo $pax["booked_pax_id"]; ?>">
                <?php
                  if ( !empty($templates) )
                  {
                    if ( $booking_details["enrol_lock_pax"] == 1 )
                    {
                      $marSus = 0;
                      if ($pax["booked_template"] != '')
                      {
                        if ($pax["booked_template"] == 'UKIR')
                        {
                          $tempTitle = 'UK/Ireland';
                        }
                        if ($pax["booked_template"] == 'USA')
                        {
                          $tempTitle = 'USA';
                        }
                        if ($pax["booked_template"] == 'MAL')
                        {
                          $tempTitle = 'Malta';
                        }
                        if ($pax["booked_template"] == 'UKIRGLSTD')
                        {
                          $tempTitle = 'UK/Ireland - GL Standard';
                        }
                        if ($pax["booked_template"] == 'UKIRSTDSTD')
                        {
                          $tempTitle = 'UK/Ireland - STD Standard';
                        }
                        if ($pax["booked_template"] == 'UKIRSTDST')
                        {
                          $tempTitle = 'UK/Ireland - STD Short Term';
                        }
                      }
                    ?>
                    <select class="chznSelect" id="templSelWhole_<?php echo $pax["booked_pax_id"] ?>" <?php if ($pax["booked_template"] != '') { ?> disabled="disabled" title="<?php echo $tempTitle; ?>" <?php } ?>>
                   	<?php
                     	if ( $pax["booked_template"] == '' )
                     	{
                       	$dspCnt = 1;
                       	foreach ( $templates as $template )
                       	{
                          $chk = 0;
                         	$tempTitle = '';
                         	if ($template['template'] == 'UKIR')
                         	{
                           	$tempTitle = 'UK/Ireland';
                           	if ($template['template'] . $pax["nat_id"] == $template['tempMap'])
                           	{
                             	$chk += 1;
                           	}
                         	}
                         	if ($template['template'] == 'USA')
                         	{
                           	$tempTitle = 'USA';
                           	if ($template['template'] . $pax["nat_id"] == $template['tempMap'])
                           	{
                             	$chk += 1;
                           	}
                         	}
                         	if ($template['template'] == 'MAL')
                         	{
                           	$tempTitle = 'Malta';
                           	if ($template['template'] . $pax["nat_id"] == $template['tempMap'])
                           	{
                             	$chk += 1;
                           	}
                         	}
                         	if ($template['template'] == 'UKIRGLSTD')
                         	{
                           	$tempTitle = 'UK/Ireland - GL Standard';
                           	if ($template['template'] . $pax["nat_id"] == $template['tempMap'])
                           	{
                              $chk += 1;
                           	}
                         	}
                         	if ($template['template'] == 'UKIRSTDSTD')
                         	{
                         		$tempTitle = 'UK/Ireland - STD Standard';
                           	if ($template['template'] . $pax["nat_id"] == $template['tempMap'])
                           	{
                              $chk += 1;
                            }
                         	}
                         	if ($template['template'] == 'UKIRSTDST')
                         	{
                           	$tempTitle = 'UK/Ireland - STD Short Term';
                           	if ($template['template'] . $pax["nat_id"] == $template['tempMap'])
                           	{
                              $chk += 1;
                            }
                         	}

                         	if ($chk > 0)
                         	{
                           	$marSus += 1;
                           	if ($dspCnt == 1)
                           	{
                         	?>
                            	<option value="">Select</option>
                          <?php
                            $dspCnt += 1;
                        	}
                          ?>
                              <option value="<?php echo $template['template'] ?>"><?php echo $tempTitle ?></option>
                        <?php
                          }
                          $chk = 0;
                        }
                        if ($marSus == 0)
                        {
                      ?>
                          <option value="">NA</option>
                      <?php
                        }
                      }
                      else
                      {
                        $tempTitle = '';
                      	if ($pax["booked_template"] == 'UKIR')
                      	{
                          $tempTitle = 'UK/Ireland';
                      	}
                        if ($pax["booked_template"] == 'USA')
                        {
                          $tempTitle = 'USA';
                        }
                        if ($pax["booked_template"] == 'MAL')
                        {
                          $tempTitle = 'Malta';
                        }
                        if ($pax["booked_template"] == 'UKIRGLSTD')
                        {
                          $tempTitle = 'UK/Ireland - GL Standard';
                        }
                        if ($pax["booked_template"] == 'UKIRSTDSTD')
                        {
                          $tempTitle = 'UK/Ireland - STD Standard';
                        }
                        if ($pax["booked_template"] == 'UKIRSTDST')
                        {
                          $tempTitle = 'UK/Ireland - STD Short Term';
                        }
                    ?>
                      	<option selected="selected" value="<?php echo $pax['booked_template'] ?>"><?php echo $tempTitle ?></option>
                    <?php
                      }
                    ?>
                    </select>
                    <span class="tmplDemo" data-id="<?php echo $pax['booked_pax_id'] ?>" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 20px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>
                    <?php
                      }
                      elseif ($pax["booked_lock_pax"] == 1)
                      {
                        $marSus = 0;
                    ?>
                      <select  id="templSelWhole_<?php echo $pax["booked_pax_id"] ?>"  class="chznSelect"
                            <?php
                            if ($pax["booked_template"] != '') {
                                $tempTitle = '';
                                if ($pax["booked_template"] == 'UKIR') {
                                    $tempTitle = 'UK/Ireland';
                                }
                                if ($pax["booked_template"] == 'USA') {
                                    $tempTitle = 'USA';
                                }
                                if ($pax["booked_template"] == 'MAL') {
                                    $tempTitle = 'Malta';
                                }
                                if ($pax["booked_template"] == 'UKIRGLSTD') {
                                    $tempTitle = 'UK/Ireland - GL Standard';
                                }
                                if ($pax["booked_template"] == 'UKIRSTDSTD') {
                                    $tempTitle = 'UK/Ireland - STD Standard';
                                }
                                if ($pax["booked_template"] == 'UKIRSTDST') {
                                    $tempTitle = 'UK/Ireland - STD Short Term';
                                }
                                ?> disabled="disabled" title="<?php echo $tempTitle; ?>"
                                         <?php
                                     } ?> >
                                     <?php
                                     if ($pax["booked_template"] == '') {
                                         $dspCnt = 1;
                                         foreach ($templates as $template) {
                                             $chk = 0;
                                             $tempTitle = '';
                                             if ($template['template'] == 'UKIR') {
                                                 $tempTitle = 'UK/Ireland';
                                                 if ($template['template'] . $pax["nat_id"] == $template['tempMap']) {
                                                     $chk += 1;
                                                 }
                                             }
                                             if ($template['template'] == 'USA') {
                                                 $tempTitle = 'USA';
                                                 if ($template['template'] . $pax["nat_id"] == $template['tempMap']) {
                                                     $chk += 1;
                                                 }
                                             }
                                             if ($template['template'] == 'MAL') {
                                                 $tempTitle = 'Malta';
                                                 if ($template['template'] . $pax["nat_id"] == $template['tempMap']) {
                                                     $chk += 1;
                                                 }
                                             }
                                             if ($template['template'] == 'UKIRGLSTD') {
                                                 $tempTitle = 'UK/Ireland - GL Standard';
                                                 if ($template['template'] . $pax["nat_id"] == $template['tempMap']) {
                                                     $chk += 1;
                                                 }
                                             }
                                             if ($template['template'] == 'UKIRSTDSTD') {
                                                 $tempTitle = 'UK/Ireland - STD Standard';
                                                 if ($template['template'] . $pax["nat_id"] == $template['tempMap']) {
                                                     $chk += 1;
                                                 }
                                             }
                                             if ($template['template'] == 'UKIRSTDST') {
                                                 $tempTitle = 'UK/Ireland - STD Short Term';
                                                 if ($template['template'] . $pax["nat_id"] == $template['tempMap']) {
                                                     $chk += 1;
                                                 }
                                             }
                                             if ($chk > 0) {
                                                 $marSus += 1;
                                                 if ($dspCnt == 1) {
                                                     ?>
                                                <option value="">Select</option>
                                                <?php
                                                $dspCnt += 1;
                                            }
                                            ?>
                                            <option value="<?php echo $template['template'] ?>"><?php echo $tempTitle ?></option>
                                            <?php
                                        }
                                    }
                                    if ($marSus == 0) {
                                        ?>
                                        <option value="">NA</option>
                                        <?php
                                    }
                                } else {
                                    $tempTitle = '';
                                    if ($pax["booked_template"] == 'UKIR') {
                                        $tempTitle = 'UK/Ireland';
                                    }
                                    if ($pax["booked_template"] == 'USA') {
                                        $tempTitle = 'USA';
                                    }
                                    if ($pax["booked_template"] == 'MAL') {
                                        $tempTitle = 'Malta';
                                    }
                                    if ($pax["booked_template"] == 'UKIRGLSTD') {
                                        $tempTitle = 'UK/Ireland - GL Standard';
                                    }
                                    if ($pax["booked_template"] == 'UKIRSTDSTD') {
                                        $tempTitle = 'UK/Ireland - STD Standard';
                                    }
                                    if ($pax["booked_template"] == 'UKIRSTDST') {
                                        $tempTitle = 'UK/Ireland - STD Short Term';
                                    }
                                    ?>
                                    <option selected="selected" value="<?php echo $pax['booked_template'] ?>"><?php echo $tempTitle ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="tmplDemo" data-id="<?php echo $pax['booked_pax_id'] ?>" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 20px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>
                            <?php
                        }
                    } else {
                        if ($booking_details["enrol_lock_pax"] == 1) {
                            ?>
                            <select style="width: 77px"><option value="">NA</option></select>
                            <?php
                        } elseif ($pax["booked_lock_pax"] == 1) {
                            ?>
                            <select style="width: 77px"><option value="">NA</option></select>
                            <?php
                        }
                    }
                    ?>
                </td>
              </tr>
              <?php
              $counter++;
            }
          ?>
        </tbody>
      </table>
  <?php
    }
  ?>
</div>
<script type="text/javascript">
  var enroll_id = "<?php echo $booking_details['enroll_id'] ?>";
  $(document).ready(function(e){

    $(document).on('change','#initTmpl', function(){
      var value = $(this).val();
      if(value != '' && typeof value != 'undefined')
        $('.selInitTmplDemo').css('display', 'block');
      else
        $('.selInitTmplDemo').css('display', 'none');
    });

    $(document).on('click','.selInitTmplDemo', function(){
      var templ = $('#initTmpl').val();
      if( templ != '' && typeof templ != 'undefined' )
      {
        window.open(siteUrl+'agentroster/visaPDFDemo/'+templ);
      }
    });

    $(document).on('click','.tmplDemo', function(){
      var id = $(this).attr('data-id');
      var templ = $('#templSelWhole_'+id).val();
      if(templ != '' && typeof templ != 'undefined')
        window.open(siteUrl+'agentroster/visaPDFDemo/'+templ);
    });

    $(document).on('change','.chznSelect', function(){
      var value = $(this).val();
      var id = $(this).attr('id').replace('templSelWhole_','');
      if(value != '' && typeof value != 'undefined'){
        $('.tmplDemo[data-id='+id+']').css('display', 'inline-block');
      }
      else{
        $('.tmplDemo[data-id='+id+']').css('display', 'none');
      }
    });

    $("#printLockedVisa").click(function(e){
      var template_count = init_temp_cnt = 0;
      var rowArr = [];
      var iniTmpl = $('#initTmpl').val();
      var iniUri = '';
      var c = true;
      if( $("#initTmpl").length )
      {
        if( iniTmpl == '' )
        {
          alert('Please select initial page template');
          return false;
        }
        else
        {
          iniUri = '-'+iniTmpl;
          init_temp_cnt = 1;
        }
      }
      if( $("#dialog_modal_print_visa .chznSelect").length )
      {
        $("#dialog_modal_print_visa .chznSelect").each(function(){
          if ( $(this).val() != '')
          {
            template_count++;
            var idRow = $(this).attr('id').replace('templSelWhole_', '');
            var valSelect = $(this).val();
            rowArr.push(idRow+'-'+valSelect);
          }
        });
        if( template_count != $("#dialog_modal_print_visa .chznSelect").length )
        {
          alert('Please select one template from each row');
          return false;
        }
      }
      template_count = template_count + init_temp_cnt;
      if( template_count > 0 )
      {
        if( $('.chznSelect:disabled').length != $('.chznSelect').length )
          c = confirm('Are you sure to print VISA? The template once selected can not change again.');
        if( c )
        {
          $('#dialog_modal_booking_detail .chznSelect').each(function(){
            var rowId = $(this).attr('id').replace('templSelWhole_', '');
            var selValue = $(this).val();
            rowArr.push(rowId+'-'+selValue);
          });

          $.ajax({
            url: siteUrl+'agentroster/lockAllTmpl',
            type: 'POST',
            data: {
              rowArr: JSON.stringify(rowArr),
              iniTmpl: iniTmpl,
              enroll_id: enroll_id
            },
            success: function(data){
              if( data == 1 )
              {
                if($('input[id=initTmpl]').length == 0)
                {
                  var elm = $('#initTmpl');
                  elm.attr('disabled', 'disabled');
                  elm.removeAttr('id');
                  elm.parent().prepend('<input type="hidden" value="'+iniTmpl+'" id="initTmpl" />');
                }
                window.location.reload();
                window.open(siteUrl+"agentroster/pdfLockedVisas/"+enroll_id+iniUri+"/"+rowArr.join('/'));
              }
              else if(data == 2)
                alert('Missing/Invalid nationalities found');
              else
                alert('Error occured. Can not print VISA.');
            },
            error: function(){
              alert('Error occured. Can not print VISA.');
            }
          });
        }
      }
    });
  });
</script>