<html>
<head>
<title>My Form</title>
<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

</style>




</head>
<body>

<?php echo $this->validation->error_string; ?>

<?php echo form_open('pannello/putdb'); ?>

<h5>Nome Pratica da annullare</h5>
<input type="text" name="username" value="<?php echo $this->validation->username;?>" size="50" />

<h5>Numero Pratica</h5>
<input type="text" name="npratica" value="<?php echo $this->validation->username;?>" size="50" />

<h5>data_pratica (formato aaaa-mm-gg - es: 2009-10-15)</h5>
<input type="text" name="data_pratica" value="<?php echo $this->validation->password;?>" size="50" />


<div><br/><input type="submit" value="Submit" /></div>

</form>

</body>
</html>