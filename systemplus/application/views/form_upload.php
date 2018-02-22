

<?php

                         echo form_open_multipart("prova_upload/doUpload");

                         ?>

<h5>Please upload an up-to-date CV (.pdf max or .doc 500Kb)</h5> <input type="file" name="cvfile" size="20" />

<?php
                             echo form_submit('submit',' Invia ');
                             echo form_close();
                         ?>





