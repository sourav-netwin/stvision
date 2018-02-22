<html>
<head>
<title>My Form</title>
<style type="text/css">

body {
 background-color: #eceef0;
 margin: 0px;
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
 margin: 4px 0 2px 0;
 padding: 0px 0 6px 0;
}

h3 {
 color: #444;
 font-family: Monaco, Verdana, Sans-serif;
 background-color: transparent;
 font-size: 16px;
 font-weight: bold;
 margin: 4px 0 2px 0;
 padding: 0px 0 6px 0;
}

h5 {
 color: #449;
 font-family: Monaco, Verdana, Sans-serif;
 background-color: transparent;
 font-size: 12px;
 font-weight: bold;
 margin: 4px 0 2px 0;
 padding: 0px 0 6px 0;
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
#container{
	margin:0 10px 0 10px;
}
</style>




</head>
<body>

<?php echo $this->validation->error_string; ?>

<?php echo form_open('booking'); ?>
<img src="/images/header_booking.jpg"/>
<div id="container">
<h3>Booking Form</h3>
<h5><img style="margin-righ:10px" src="/images/ico/agent.png"> Agent</h5>
<input type="text" name="username" value="<?php echo $this->validation->username;?>" size="50" />

<h5><img style="margin-righ:10px" src="/images/ico/mail.png"> Email Address</h5>
<input type="text" name="myemail" value="<?php echo $this->validation->email;?>" size="50" />

<h5><img style="margin-righ:10px" src="/images/ico/phone.png"> Phone</h5>
<input type="text" name="phone" value="<?php echo $this->validation->phone;?>" size="20" />


<h5>Destinations</h5>
<input type="text" name="destination" value="<?php echo $this->validation->destination;?>" size="50" />

<h5>Accomodations</h5>
<select name="accomodation">
<option value="Residential" <?php echo set_select('accomodation', 'Residential', TRUE); ?> >Residential</option>
<option value="Home Stay" <?php echo set_select('accomodation', 'home'); ?> >Home Stay</option>
</select> 

<h5>Arrival Date</h5>
<input type="text" name="arrival" value="<?php echo $this->validation->arrival;?>" size="10" />

<h5>Departure Date</h5>
<input type="text" name="departure" value="<?php echo $this->validation->departure;?>" size="10" />

<h5>Total Number of Students:</h5>
<input type="text" name="students" value="<?php echo $this->validation->students;?>" size="5" />

<h5>Total of Group Leaders:</h5>
<input type="text" name="leaders" value="<?php echo $this->validation->leaders;?>" size="5" />

<h5>Group Nationality</h5>
<input type="text" name="nationality" value="<?php echo $this->validation->nationality;?>" size="20" />

<h5>Inbound Transfer required</h5>
<select name="inbound">
<option value="Yes" <?php echo set_select('inbound', 'Yes', TRUE); ?> >Yes</option>
<option value="No" <?php echo set_select('inbound', 'No'); ?> >No</option>
</select> 

<h5>Outbound Transfer required</h5>
<select name="outbound">
<option value="Yes" <?php echo set_select('outbound', 'Yes', TRUE); ?> >Yes</option>
<option value="No" <?php echo set_select('outbound', 'No'); ?> >No</option>
</select> 


<div><br/><input type="submit" value="Submit" /></div>
</div>
</form>
<h5>By submitting the present Booking Application, the Agent formally agrees to abide by PLUS Terms & Conditions set  within this web-site which the Agent  declares  to have read, and understood</h5><br/>
</body>
</html>
