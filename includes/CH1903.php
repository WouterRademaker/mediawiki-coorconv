<?php
class CH1903 {
	static function CH03( $x, $y, $z = null ) {
		// WGS84 Latitude/Longitude to CH1903 - Suisse
		// based on https://www.swisstopo.admin.ch/content/swisstopo-internet/en/topics/survey/reference-systems/switzerland/_jcr_content/contentPar/tabs/items/dokumente_publikatio/tabPar/downloadlist/downloadItems/516_1459343097192.download/ch1903wgs84_e.pdf
    // found on https://www.swisstopo.admin.ch/en/knowledge-facts/surveying-geodesy/reference-systems/switzerland.html#dokumente_publikatio
    // https://www.swisstopo.admin.ch/de/karten-daten-online/calculation-services/navref.html

		$phi=(($x*3600)-169028.66)/10000;
		$lambda=(($y*3600)-26782.5)/10000;

		$y_ch03 = 2600072.37
		+ 211455.93 * $lambda
		- 10938.51 * $lambda * $phi
		- 0.36 * $lambda * $phi * $phi
		- 44.54 * $lambda * $lambda * $lambda;
		$x_ch03 = 1200147.07
		+ 308807.95 * $phi
		+ 3745.25 * $lambda * $lambda
		+ 76.63 * $phi * $phi
		- 194.56 * $phi * $lambda * $lambda
		+ 119.79 * $phi * $phi * $phi;

	  if( !empty($z) ) {
		  $z_ch03 = $z – 49.55
		  + 2.73 * $lambda
		  + 6.94 *  $phi;
	  }
		$ret = array($x_ch03, $y_ch03, $z_ch03);
		return($ret);

	}

 static function WGS84ToCH1903p( &$parser, $x, $y )  {
    $xyz_ch03    = self::CH03($x, $y, null);
		if( !empty($z) ) {
			return number_format($xyz_ch03[0], 0, '.', '/') ."//" .number_format($xyz_ch03[1], 0, '.', '/');
		} else {
			return number_format($xyz_ch03[0], 0, '.', '/') ."//" .number_format($xyz_ch03[1], 0, '.', '/') ."//" .number_format($xyz_ch03[2], 0, '.', '/');
		}
	}

	static function WGS84ToCH1903( &$parser, $x, $y ) {
		// WGS84 Latitude/Longitude to CH1903 - Suisse
		// based on http://www.swisstopo.admin.ch/internet/swisstopo/en/home/topics/survey/sys/refsys/switzerland.parsysrelated1.37696.downloadList.12749.DownloadFile.tmp/ch1903wgs84en.pdf
		// http://www.swisstopo.admin.ch/internet/swisstopo/en/home/apps/calc/navref.html
		$phi=(($x*3600)-169028.66)/10000;
		$lambda=(($y*3600)-26782.5)/10000;

		$y_ch03 = 600072.37
		+ 211455.93 * $lambda
		- 10938.51 * $lambda * $phi
		- 0.36 * $lambda * $phi * $phi
		- 44.54 * $lambda * $lambda * $lambda;
		$x_ch03 = 200147.07
		+ 308807.95 * $phi
		+ 3745.25 * $lambda * $lambda
		+ 76.63 * $phi * $phi
		- 194.56 * $phi * $lambda * $lambda
		+ 119.79 * $phi * $phi * $phi;

		return number_format($x_ch03, 0, '.', '/') ."//" .number_format($y_ch03, 0, '.', '/');
	}

}
