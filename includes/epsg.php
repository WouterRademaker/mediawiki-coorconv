<?php
class EPSG {
	static function epgs( &$parser, $coord, $source = null, $target = null ) {
    $array = explode(',', $coord);
    $x = $array[0];
    $y = $array[1];
    $z = $array[2];
    $url = 'http://epsg.io/trans?s_srs='.$source.'&t_srs='.$target.'&x='.$x.'&y='.$y.'&z='.$z;
    $json = file_get_contents($url);
    $output=json_decode($json, true);
    return $output["x"].', '.$output["y"].', '.$output["z"];
    //return array($output["x"], $output["y"], $output["z"]);

  }
}
