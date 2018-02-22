<html>
<head>
<title>Form</title>
<style type="text/css">

body {
 background-color: #eceef0;
 margin: 0px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #449;
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


<p><?php 
	
	echo ("<img src=\"/images/header_booking.jpg\"/><br clear=\"all\">");
	echo ("<div id=\"container\">");
	echo ("Dear ");
	echo ($_POST['username'] . "<br/>");
	echo ("<br/>Thank you for choosing to book with Plus Group.<br/>");
	echo ("We are currently processing your request and an email will be sent to the email address provided shortly. <br/><br/>Please note that this message is not a confirmation of your booking.<br/><hr/>");
	echo ("Destination: "  . $_POST['destination'] . "<br/>");
	echo ("Accomodation: "  . $_POST['accomodation'] . "<br/>");
	echo ("Departure: "  . $_POST['departure'] . "<br/>");
	echo ("Arrival: "  . $_POST['arrival'] . "<br/>");
	echo ("Student: "  . $_POST['students'] . "<br/>");
	echo ("Leaders: "  . $_POST['leaders'] . "<br/>");
	echo ("Nationality: "  . $_POST['nationality'] . "<br/>");
	echo ("Inbound Transfer required: "  . $_POST['inbound'] . "<br/>");
	echo ("Outbound Transfer required: "  . $_POST['outbound'] . "<br/>");
	echo ("<hr/>");
	echo ("</div>");
	?></p>

</body>
</html>