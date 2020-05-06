<?php
class CH1903 {
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
