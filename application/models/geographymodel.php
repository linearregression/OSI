<?php
class Geographymodel extends FT_Model{
    function Geographymodel(){
		parent::__construct();
    }

	public function getPointGeonames($uri) {
		$this->arc_config['db_name'] = "footprinted";
		$this->arc_config['store_name'] = "geonames";
		// check if this uri is already loaded
		
		if ($this->isLoaded($uri) == false) {
			$q = "LOAD <" . $uri . "> INTO <" . $uri . ">";
			$this->executeQuery($q);
		}

		$q = "select ?lat ?long ?name where { " .
		 	"<" . $uri . "> foaf:primaryTopic ?bnode . " .  
			"?bnode wgs84_pos:lat ?lat . " . 	
			"?bnode wgs84_pos:long ?long . " .
			"?bnode gn:name ?name . " .
			"}";								
		$results = $this->executeQuery($q);
		if (count($results) != 0) {
			return $results[0];
		} else {
			return false;
		}
	}
	
} // End Class