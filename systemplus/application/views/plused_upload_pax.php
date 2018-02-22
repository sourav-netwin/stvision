<div id="preview">
<form action="<?php echo base_url(); ?>index.php/backoffice/uploadFormPax/<?php echo $year ?>/<?php echo $book ?>/<?php echo $idcampus ?>" name="uploadpax" id="uploadpax" method="POST" enctype="multipart/form-data" >
<table style="width:100%;">
	<thead>
		<tr>
			<th><?php echo $error ?></th>
		</tr>
	</thead>
	<tbody>	
		<tr>
			<td>
				<div>
				Select File To Upload:<br />
				<input type="file" name="userfile"  />
				<br /><br />
				<input type="submit" name="submit" value="Upload" class="btn btn-success" />
				</div>
			</td>
		</tr>
	</tbody>
</table>
</form>
<script type="text/javascript">
$(document).ready(function() { 
    $('#uploadpax').ajaxForm({ 
        target: '#preview'
    }); 
});
</script>
</div>
