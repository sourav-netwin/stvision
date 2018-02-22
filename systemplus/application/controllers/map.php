<?php

class Map extends Controller {

	public function __construct() {
		parent::Controller();
	}

	function loadMap() {
		$address = $this -> input -> post('address');
		$post_code = $this -> input -> post('post_code');
		$city = $this -> input -> post('city');
		$country = $this -> input -> post('located_in');
		 
		if( $country != "" )
			$map_address = $address." ".$city." ".$country." ".$post_code;
		else
			$map_address = $address." ".$city." ".$post_code;

		// We get the JSON results from this request
	    $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($map_address).'&sensor=false');
	    // We convert the JSON to an array
	    $geo = json_decode($geo, true);
	    // If everything is cool
	    if ($geo['status'] == 'OK')
	    {
	      // We set our values
	      $latitude = $geo['results'][0]['geometry']['location']['lat'];
	      $longitude = $geo['results'][0]['geometry']['location']['lng'];
	    }
	    else
	    {
	      $latitude = "";
	      $longitude = "";
	    }
	    echo json_encode(array('latitude' => $latitude, 'longitude' => $longitude));
	}
}
//End : controller by Arunsankar S
/* End of file map.php */
