<?php
/**
* Hooks for CoordinateConversion extension
*
* @file
* @ingroup Extensions
*/

use DataValues\Geo\Values\LatLongValue;
use DataValues\Geo\Parsers\LatLongParser;
use DataValues\Geo\Formatters\LatLongFormatter;
use ValueFormatters\FormatterOptions;

class CoordinateConversionHooks {

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setFunctionHook( 'lat_deg2dms',   [ self::class, 'latDegToDMS'   ] );
		$parser->setFunctionHook( 'lat_dms2deg',   [ self::class, 'latDMSToDeg'   ] );
		$parser->setFunctionHook( 'long_deg2dms',  [ self::class, 'longDegToDMS'  ] );
		$parser->setFunctionHook( 'long_dms2deg',  [ self::class, 'longDMSToDeg'  ] );
		$parser->setFunctionHook( 'deg2dms',       [ self::class, 'DegToDMS'      ] );
		$parser->setFunctionHook( 'wgs84_2rd',     [ self::class, 'WGS84ToRD'     ] );
		$parser->setFunctionHook( 'wgs84_2lb93',   [ self::class, 'WGS84ToLAM93'  ] );
		$parser->setFunctionHook( 'wgs84_2lb08',   [ self::class, 'WGS84ToLAM08'  ] );
		$parser->setFunctionHook( 'wgs84_2ch03',   [ self::class, 'WGS84ToCH1903' ] );
		$parser->setFunctionHook( 'lat_long2utm',  [ self::class, 'WGS84ToUTM'    ] );
		$parser->setFunctionHook( 'wgs84_2utm',    [ self::class, 'WGS84ToUTM'    ] );
		$parser->setFunctionHook( 'wgs84_2itm',    [ self::class, 'WGS84ToITM'    ] );
		$parser->setFunctionHook( 'wgs84_2tm35fin',[ self::class, 'WGS84ToTM35FIN'] );
		$parser->setFunctionHook( 'wgs84_2mtm',    [ self::class, 'WGS84ToMTM'    ] );
		$parser->setFunctionHook( 'wgs84_2osgb',   [ self::class, 'WGS84ToOSGB36' ] );
		$parser->setFunctionHook( 'wgs84_2ig',     [ self::class, 'WGS84ToIG'     ] );
		$parser->setFunctionHook( 'wgs84_2luref',  [ self::class, 'WGS84ToLUREF'  ] );

	}

	static function DMS( $d, $m, $s, $h ) {
		// prime (minutes, feet) = U+2032, &#8242;, &prime;
		// double prime (seconds, inches) = U+2033, &#8243;, &Prime;
		return sprintf( "%d&deg; %02d&#8242; %04.1f&#8243; %s", $d, $m, $s, $h );
	}

	static function TM($phi, $l) {
		// transverse Mercator projection
		// Based on http://www.igorexchange.com/node/927 and http://home.hiwaay.net/~taylorc/toolbox/geography/geoutm.html
		$sm_a = 6378137.0;
		$sm_b = 6356752.314;
		//      $ep2 = ($sm_a * $sm_a - $sm_b * $sm_b) / ($sm_b * $sm_b);
		$ep2 = 0.00673949681993606;
		$nu2 = $ep2 * pow(cos($phi), 2.0);
		$N = pow ($sm_a, 2.0) / ($sm_b * sqrt(1 + $nu2));
		$t = tan ($phi);
		$t2= $t * $t;
		$l3coef = 1.0 - $t2 + $nu2;
		$l4coef = 5.0 - $t2 + 9 * $nu2 + 4.0 * ($nu2 * $nu2);
		$l5coef = 5.0 - 18.0 * $t2 + ($t2 * $t2) + 14.0 * $nu2 - 58.0 * $t2 * $nu2;
		$l6coef = 61.0 - 58.0 * $t2 + ($t2 * $t2) + 270.0 * $nu2 - 330.0 * $t2 * $nu2;
		$l7coef = 61.0 - 479.0 * $t2 + 179.0 * ($t2 * $t2) - ($t2 * $t2 * $t2);
		$l8coef = 1385.0 - 3111.0 * $t2 + 543.0 * ($t2 * $t2) - ($t2 * $t2 * $t2);
		$x      = $N * cos($phi) * $l
		+ ($N / 6.0    * pow(cos($phi), 3.0) * $l3coef * pow($l, 3.0))
		+ ($N / 120.0  * pow(cos($phi), 5.0) * $l5coef * pow($l, 5.0))
		+ ($N / 5040.0 * pow(cos($phi), 7.0) * $l7coef * pow($l, 7.0));

		/*      $nn = ($sm_a - $sm_b) / ($sm_a + $sm_b);
		$alpha = (($sm_a + $sm_b) / 2.0) * (1.0 + (pow($nn, 2.0) / 4.0) + (pow($nn, 4.0) / 64.0));
		$beta = (-3.0 * $nn / 2.0) + (9.0 * pow($nn, 3.0) / 16.0) + (-3.0 * pow($nn, 5.0) / 32.0);
		$gamma = (15.0 * pow($nn, 2.0) / 16.0) + (-15.0 * pow($nn, 4.0) / 32.0);
		$delta = (-35.0 * pow($nn, 3.0) / 48.0) + (105.0 * pow($nn, 5.0) / 256.0);
		$epsilon = (315.0 * pow($nn, 4.0) / 512.0);

		$length = $alpha * ($phi        + ($beta    * sin(2.0 * $phi))
		+ ($gamma   * sin(4.0 * $phi))
		+ ($delta   * sin(6.0 * $phi))
		+ ($epsilon * sin(8.0 * $phi)));
		*/
		$length = 6367449.14570093 * ($phi      - 2.51882794504748e-3  * sin(2.0 * $phi)
		+ 2.64354112052895e-6  * sin(4.0 * $phi)
		- 3.45262354148954e-9  * sin(6.0 * $phi)
		+ 4.89183055303118E-12 * sin(8.0 * $phi));
		$y      = $length
		+ ($t / 2.0     * $N * pow(cos($phi), 2.0) * pow($l, 2.0))
		+ ($t / 24.0    * $N * pow(cos($phi), 4.0) * $l4coef * pow($l, 4.0))
		+ ($t / 720.0   * $N * pow(cos($phi), 6.0) * $l6coef * pow($l, 6.0))
		+ ($t / 40320.0 * $N * pow(cos($phi), 8.0) * $l8coef * pow($l, 8.0));
		$ret = array($x,$y);
		return($ret);
	}

	static function WGS84ToLAM($LAM,$x, $y ) {
		// Lambert projection
		// based on http://www.ngi.be/Common/Lambert2008/Transformation_Geographic_Lambert_NL.pdf
		extract($LAM);
		$m_1            = cos($phi_1) / sqrt(1 - pow($e * sin($phi_1),2));
		$m_2            = cos($phi_2) / sqrt(1 - pow($e * sin($phi_2),2));
		$t_1            = tan(M_PI / 4 - $phi_1 / 2) / pow((1 - $e * sin($phi_1)) / (1 + $e * sin($phi_1)), $e / 2);
		$t_2            = tan(M_PI / 4 - $phi_2 / 2) / pow((1 - $e * sin($phi_2)) / (1 + $e * sin($phi_2)), $e / 2);
		$t_0            = tan(M_PI / 4 - $phi_0 / 2) / pow((1 - $e * sin($phi_0)) / (1 + $e * sin($phi_0)), $e / 2);
		$n              = (log($m_1) - log($m_2)) / (log($t_1) - log($t_2));
		$g              = $m_1 / ($n * pow($t_1, $n));
		$r_0            = $a * $g * pow($t_0, $n);

		$phi            = $x / 180 * M_PI;
		$lambda         = $y / 180 * M_PI;
		$t              = tan(M_PI / 4 - $phi / 2) / pow((1 - $e * sin($phi)) / (1 + $e * sin($phi)), $e / 2);
		$r              = $a * $g * pow($t, $n);
		$theta          = $n * ($lambda - $lambda_0);
		$x_LAM = $x_0 + $r * sin($theta);
		$y_LAM = $y_0 + $r_0 - $r * cos($theta);

		return sprintf("%d/%d", $x_LAM, $y_LAM);
	}

	static function datumtransformation($point, $e1, $t, $e2) {
		// Based on http://www.movable-type.co.uk/scripts/latlong-convert-coords.html
		// -- convert polar to cartesian coordinates (using ellipse 1)
		extract($point);
		$sinPhi = sin($phi);
		$cosPhi = cos($phi);
		$sinLambda = sin($lambda);
		$cosLambda = cos($lambda);
		extract($e1);
		$eSq = ($a*$a - $b*$b) / ($a*$a);
		$nu = $a / sqrt(1 - $eSq*$sinPhi*$sinPhi);
		$x1 = ($nu+$height) * $cosPhi * $cosLambda;
		$y1 = ($nu+$height) * $cosPhi * $sinLambda;
		$z1 = ((1-$eSq)*$nu + $height) * $sinPhi;

		// -- apply helmert transform using appropriate params
		extract($t);
		// normalise seconds to radians
		$rx = deg2rad($rx/3600);
		$ry = deg2rad($ry/3600);
		$rz = deg2rad($rz/3600);
		$s1 = $s/1e6 + 1;              // normalise ppm to (s+1)

		// apply transform
		$x2 = $tx + $x1*$s1 - $y1*$rz + $z1*$ry;
		$y2 = $ty + $x1*$rz + $y1*$s1 - $z1*$rx;
		$z2 = $tz - $x1*$ry + $y1*$rx + $z1*$s1;


		// -- convert cartesian to polar coordinates (using ellipse 2)
		extract($e2);
		$precision = 4 / $a;  // results accurate to around 4 metres
		$eSq = ($a*$a - $b*$b) / ($a*$a);
		$p = sqrt($x2*$x2 + $y2*$y2);
		$phi = atan2($z2, $p*(1-$eSq));
		$phiP = 2*M_PI;
		while (abs($phi-$phiP) > $precision) {
			$nu = $a / sqrt(1 - $eSq*sin($phi)*sin($phi));
			$phiP = $phi;
			$phi = atan2($z2 + $eSq*$nu*sin($phi), $p);
		}
		$point['phi'] = $phi;
		$point['lambda'] = atan2($y2, $x2);
		$point['height'] = $p/cos($phi) - $nu;
		return $point;
	}

	static function latDegToDMS( &$parser, $degrees ) {
		$h = $degrees < 0 ? 'S' : 'N';
		$degrees = round( abs($degrees) * 360000, 0 ) % 32400000;
		$d = $degrees / 360000; $degrees %= 360000;
		$m = $degrees / 6000;   $degrees %= 6000;
		$s = $degrees / 100;
		return self::DMS( $d, $m, $s, $h );
	}

	static function latDMSToDeg( &$parser, $d, $m, $s, $h ) {
		$degrees = ($d * 3600 + $m * 60 + $s) / 3600.0 * ($h == 'N' ? 1 : -1);
		return $degrees;
	}

	static function longDegToDMS( &$parser, $degrees ) {
		$h = $degrees < 0 ? 'W' : 'E';
		$degrees = round( abs($degrees) * 360000, 0 ) % 64800000;
		$d = $degrees / 360000; $degrees %= 360000;
		$m = $degrees / 6000;   $degrees %= 6000;
		$s = $degrees / 100;
		return self::DMS( $d, $m, $s, $h );
	}

	static function longDMSToDeg( &$parser, $d, $m, $s, $h ) {
		$degrees = ($d * 3600 + $m * 60 + $s) / 3600.0 * ($h == 'W' ? -1 : 1);
		return $degrees;
	}

	static function DegToDMS( &$parser,$coord) {
  //             $array = explode(',', $coord);
  //             return self::latDegToDMS( $parser, $array[0]).' , '.self::longDegToDMS( $parser, $array[1]);
   	$llparser = new LatLongParser();
   	$latLongValue = $llparser->parse($coord);
	 	$options = new FormatterOptions();
	 	$options->setOption( LatLongFormatter::OPT_FORMAT, LatLongFormatter::TYPE_DMS );
	 	$options->setOption( LatLongFormatter::OPT_DIRECTIONAL, true );
	 	$options->setOption( LatLongFormatter::OPT_PRECISION, 1 / 36000 );
	 	$formatter = new LatLongFormatter($options);
  	return $formatter->format(new LatLongValue($latLongValue->getLatitude(),$latLongValue->getLongitude()));
	}

	static function WGS84ToRD( &$parser, $x, $y = null  ) {
                if( $y == null) {
                   $array = explode(',', $x);
                   $x = $array[0];
                   $y = $array[1];
                  }
		// WGS84 Latitude/Longitude to RD - the Netherlands
		// based on http://www.dekoepel.nl/pdf/Transformatieformules.pdf
		$phi    = bcmul(0.36, bcsub($x, 52.15517440,32),32);
		$lambda = bcmul(0.36, bcsub($y, 5.38720621,32),32);

		$x_rd   = bcadd(155000,
		bcadd(bcmul(190094.945,            $lambda                  ,32),
		bcadd(bcmul(-11832.228 ,bcmul(      $lambda   ,      $phi   ,32),32),
		bcadd(bcmul(-114.221   ,bcmul(      $lambda   ,bcpow($phi,2,32),32),32),
		bcadd(bcmul(-32.391    ,      bcpow($lambda,3,32)               ,32),
		bcadd(bcmul(-0.705     ,                             $phi    ,32),
		bcadd(bcmul(-2.340     ,bcmul(      $lambda   ,bcpow($phi,3,32),32),32),
		bcadd(bcmul(-0.608     ,bcmul(bcpow($lambda,3,32),      $phi   ,32),32),
		bcadd(bcmul(0.008     ,      bcpow($lambda,2,32)               ,32),
		bcmul(0.148     ,bcmul(bcpow($lambda,3,32),bcpow($phi,2,32),32),32)
		,32),32),32),32),32),32),32),32),32);

		$y_rd   = bcadd(463000,
		bcadd(bcmul(309056.544,            $phi                              ,32),
		bcadd(bcmul(3638.893  ,                       bcpow($lambda,2,32)    ,32),
		bcadd(bcmul(73.077    ,      bcpow($phi,2,32)                        ,32),
		bcadd(bcmul(-157.984  ,bcmul(      $phi,      bcpow($lambda,2,32),32),32),
		bcadd(bcmul(59.788    ,      bcpow($phi,3,32)                        ,32),
		bcadd(bcmul(0.433     ,                             $lambda          ,32),
		bcadd(bcmul(-6.439    ,bcmul(bcpow($phi,2,32),bcpow($lambda,2,32),32),32),
		bcadd(bcmul(-0.032    ,bcmul(      $phi,            $lambda  ,32)    ,32),
		bcadd(bcmul(0.092     ,                       bcpow($lambda,4,32)    ,32),
		bcmul(-0.054    ,bcmul(      $phi   ,   bcpow($lambda,4,32),32),32)
		,32),32),32),32),32),32),32),32),32),32);

		//      return sprintf("%06d%06d",$x_rd, $y_rd);
		return number_format($x_rd, 0, ',', ' ') ."-" .number_format($y_rd, 0, ',', ' ');
	}

	static function WGS84ToUTM( &$parser, $phi_d, $lambda_d, $zone='') {
		// WGS84 Latitude/Longitude to UTM
		// Based on http://www.igorexchange.com/node/927 and http://home.hiwaay.net/~taylorc/toolbox/geography/geoutm.html
		$bandletter = array ("C","D","E","F","G","H","J","K","L","N","P","Q","R","S","T","U","V","W","X","X");
		$TMScaleFactor = 0.9996;
		if ( $phi_d >= 84 || $phi_d <= -80) return "Polar area, use Universal Polar Stereographic (UPS)";
		// Special zone for Norway
		if(!$zone && $phi_d >= 56.0 && $phi_d < 64.0 && $lambda_d >= 3.0 && $lambda_d < 12.0 )
		$zone = 32;
		// Special zones for Svalbard
		if(!$zone && $phi_d >= 72.0 && $phi_d < 84.0)
		if  ( $lambda_d >= 0.0  && $lambda_d <  9.0 )
		$zone = 31;
		elseif( $lambda_d >= 9.0  && $lambda_d < 21.0 )
		$zone = 33;
		elseif($lambda_d >= 21.0 && $lambda_d < 33.0 )
		$zone = 35;
		elseif($lambda_d >= 33.0 && $lambda_d < 42.0 )
		$zone = 37;
		if (!$zone)
		$zone = floor($lambda_d/6) + 31;
		$band = $bandletter[floor(($phi_d+72)/8)];
		$lambda0 = deg2rad(-183.0 + ($zone * 6.0));
		$lambda=deg2rad($lambda_d);
		$l = $lambda - $lambda0;
		$phi=deg2rad($phi_d);
		$xy     = self::TM($phi, $l);
		$x_tm   = $xy[0]*$TMScaleFactor + 500000;
		$y_tm   = $xy[1]*$TMScaleFactor;
		if($phi_d < 0)
		$y_tm += 10000000; //10000000 meter offset for southern hemisphere
		return sprintf("%d%s %dm E %dm N",$zone,$band, $x_tm, $y_tm);
	}

	static function WGS84ToLAM93( &$parser, $x, $y ) {
		// WGS84 Latitude/Longitude to Lambert93  - France
		// based on http://professionnels.ign.fr/DISPLAY/000/526/695/5266956/Geodesie__projections.pdf
		$LB93['a']      = 6378137;              //demi grand axe de l'ellipsoide (m)
		$LB93['e']      = 0.08181919106 ;       //premire excentricit de l'ellipsoide
		$LB93['phi_1']  = deg2rad(44);          //1er parallele automcoque
		$LB93['phi_2']  = deg2rad(49);          //2eme parallele automcoque
		$LB93['phi_0']  = deg2rad(46.5);        //latitude d'origine en radian
		$LB93['lambda_0']= deg2rad(3);          //longitude de rfrence
		$LB93['x_0']    = 700000;               //coordonnes  l'origine
		$LB93['y_0']    = 6600000;              //coordonnes  l'origine
		return self::WGS84ToLAM($LB93, $x, $y );
	}

	static function WGS84ToLAM08( &$parser, $x, $y ) {
		// WGS84 Latitude/Longitude to Lambert2008 - Belgium
		// based on http://www.ngi.be/Common/Lambert2008/Transformation_Geographic_Lambert_NL.pdf
		$LB08['a']      = 6378137;              //demi grand axe de l'ellipsoide (m)
		$LB08['e']      = 0.08181919106 ;       //premire excentricit de l'ellipsoide
		$LB08['phi_1']  = deg2rad(49.833333333);//1er parallele automcoque  (49� 50' N)
		$LB08['phi_2']  = deg2rad(51.166666667);//2eme parallele automcoque ( 51� 10' N)
		$LB08['phi_0']  = deg2rad(50.797815);   //latitude d'origine en radian (50�47�52�134 N)
		$LB08['lambda_0']= deg2rad(4.359215833);//longitude de rfrence (4�21�33�177 E)
		$LB08['x_0']    = 649328;               //coordonnes  l'origine
		$LB08['y_0']    = 665262;               //coordonnes  l'origine
		return self::WGS84ToLAM($LB08, $x, $y );
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

	static function WGS84ToTM35FIN( &$parser, $phi_d, $lambda_d) {
		// WGS84 Latitude/Longitude to TM35FIN = extended UTM zone 35N - Finland
		// Based on http://www.samenland.nl/pdf/the_change_of_coordinate_system_in_finland.pdf
		$TMScaleFactor = 0.9996;
		$lambda0 = deg2rad(27); //UTM 35N
		$lambda=deg2rad($lambda_d);
		$l = $lambda - $lambda0;
		$phi=deg2rad($phi_d);
		$xy     = self::TM($phi, $l);
		$x_tm   = $xy[0]*$TMScaleFactor + 500000;
		$y_tm   = $xy[1]*$TMScaleFactor;
		if ($x_tm < 0)
		return sprintf("&nbsp;&nbsp;%dE, %dN",$x_tm + 8000000, $y_tm);
		else
		return sprintf("(8)%dm E %dm N",$x_tm, $y_tm);
	}

	static function WGS84ToMTM( &$parser, $phi_d, $lambda_d, $zone='') {
		// WGS84 Latitude/Longitude to MTM Canada
		// Based on http://pages.globetrotter.net/roule/utmgoogle.htm
		// MTM zone to reference meridian
		$mtmSmers = array (0, -53, -56, -58.5, -61.5, -64.5, -67.5, -70.5, -73.5, -76.5, -79.5, -82.5, -81, -84, -87, -90, -93, -96, -99, -102, -105, -108, -111, -114, -117, -120, -123, -126, -129, -132, -135, -138, -141);  // last was 142 ?!! I think it should be 141.

		// ? matches http://www.posc.org/Epicentre.2_2/DataModel/LogicalDictionary/StandardValues/coordinate_transformation.html

		if (!$zone)  // determine zone from lat/lon
		{
			if ($lambda_d < -51.5 && $lambda_d >= -54.5)                                    $zone=1;
			if ($lambda_d < -54.5 && $lambda_d >= -57.5)                                    $zone=2;
			if ($lambda_d < -57.5 && $lambda_d >= -59.5  && $phi_d <= 46.5
			||  $lambda_d < -57.5 && $lambda_d >= -60    && $phi_d >  46.5 )                $zone=3;
			if ($lambda_d < -59.5 && $lambda_d >= -63.   && $phi_d <  46.5
			||  $lambda_d < -60   && $lambda_d >= -63    && $phi_d >= 46.5 )                $zone=4;
			if ($lambda_d < -63   && $lambda_d >= -66.5  && $phi_d <= 44.75
			||  $lambda_d < -63   && $lambda_d >= -66    && $phi_d >  44.75 )               $zone=5;
			if ($lambda_d < -66   && $lambda_d >= -69    && $phi_d >  44.75
			||  $lambda_d < -66.5 && $lambda_d >= -69    && $phi_d <= 44.75 )               $zone=6;
			if ($lambda_d < -69   && $lambda_d >= -72)                                      $zone=7;
			if ($lambda_d < -72   && $lambda_d >= -75)                                      $zone=8;
			if ($lambda_d < -75   && $lambda_d >= -78)                                      $zone=9;
			if ($lambda_d < -78   && $lambda_d >= -79.5  && $phi_d >  47
			||  $lambda_d < -78.  && $lambda_d >= -80.25 && $phi_d <= 47 && $phi_d > 46
			||  $lambda_d < -78   && $lambda_d >= -81    && $phi_d <= 46)                   $zone=10;
			if ($lambda_d < -81   && $lambda_d >= -84    && $phi_d <= 46)                   $zone=11;
			if ($lambda_d < -79.5 && $lambda_d >= -82.5  && $phi_d >  47
			||  $lambda_d < -80.25&& $lambda_d >= -82.5  && $phi_d <= 47 && $phi_d > 46)    $zone=12;
			if ($lambda_d < -82.5 && $lambda_d >= -85.5  && $phi_d >  46)                   $zone=13;
			// still not found, try regular Western Canada
			if (!$zone)
			$zone = floor(($lambda_d + 85.5)/-3) + 14;
			}
			if ($zone < 1 || $zone > 32)
			return "Outside Canada";
			else
			$lambda0 = $mtmSmers[$zone];
			$l = deg2rad($lambda_d - $lambda0);
			$phi=deg2rad($phi_d);
			$xy     = self::TM($phi, $l);
			$TMScaleFactor = 0.9999;
			$x_tm   = $xy[0]*$TMScaleFactor + 304800;
			$y_tm   = $xy[1]*$TMScaleFactor;
			return sprintf("%d %dm E %dm N",$zone, $x_tm, $y_tm);

	}

	function WGS84ToOSGB36( &$parser, $phi_d, $lambda_d, $height = 0) {
		// WGS84 Latitude/Longitude to OSGB36 - Great Britain
		// Based on http://www.movable-type.co.uk/scripts/latlong-convert-coords.html
		$WGS84['a']     = 6378137;
		$WGS84['b']     = 6356752.3142;
		//      $WGS84['f']     = 1/298.257223563;
		$Airy1830['a']  = 6377563.396;
		$Airy1830['b']  = 6356256.910;
		//      $Airy1830['f']  = 1/299.3249646;
		$WGS84toOSGB36['tx']= -446.448;
		$WGS84toOSGB36['ty']=  125.157;
		$WGS84toOSGB36['tz']= -542.060;
		$WGS84toOSGB36['rx']=   -0.1502;
		$WGS84toOSGB36['ry']=   -0.2470;
		$WGS84toOSGB36['rz']=   -0.8421;
		$WGS84toOSGB36['s']=    20.4894;
		$originOSGB36['F0'] = 0.9996012717;             // NatGrid scale factor on central meridian
		$originOSGB36['phi0'] = deg2rad(49);
		$originOSGB36['lambda0'] = deg2rad(-2);         // NatGrid true origin
		$originOSGB36['N0'] = -100000;
		$originOSGB36['E0'] = 400000;                   // northing & easting of true origin, metres
		$point['phi'] = deg2rad($phi_d);
		$point['lambda'] = deg2rad($lambda_d);
		$point['height'] = $height;
		$point = self::datumtransformation($point, $WGS84, $WGS84toOSGB36, $Airy1830);
		$grid = self::LatLongToOSGrid($point,$Airy1830,$originOSGB36);
		//      level 1 transformation
		//      $grid = self::LatLongToOSGrid($point,$WGS84,$originOSGB36);
		//      $grid['E'] += 49;
		//      $grid['N'] -= 23.4;
		return self::gridrefNumToLetGB($grid, 8);
		}

		function WGS84ToIG( &$parser, $phi_d, $lambda_d, $height = 0) {
			// WGS84 Latitude/Longitude to Irish Grid - Republic Ireland and North Ireland
			// Based on http://www.movable-type.co.uk/scripts/latlong-convert-coords.html
			// Based on http://www.osni.gov.uk/2.1_the_irish_grid.pdf
			$WGS84['a']     = 6378137;
			$WGS84['b']     = 6356752.3142;
			//      $WGS84['f']     = 1/298.257223563;
			$Airy1830_m['a']= 6377340.189;
			$Airy1830_m['b']= 6356034.447;
			//      $Airy1830_m['f']= ;
			$WGS84toOSI['tx']= -482.53;
			$WGS84toOSI['ty']=  130.596;
			$WGS84toOSI['tz']= -564.557;
			$WGS84toOSI['rx']=   -1.042;
			$WGS84toOSI['ry']=   -0.214;
			$WGS84toOSI['rz']=   -0.631;
			$WGS84toOSI['s']=    -8.15;
			$originOSI['F0'] = 1.000035;            // NatGrid scale factor on central meridian
			$originOSI['phi0'] = deg2rad(53.5);
			$originOSI['lambda0'] = deg2rad(-8);            // NatGrid true origin
			$originOSI['N0'] = 250000;
			$originOSI['E0'] = 200000;                      // northing & easting of true origin, metres

			$point['phi'] = deg2rad($phi_d);
			$point['lambda'] = deg2rad($lambda_d);
			$point['height'] = $height;
			//      $point = self::datumtransformation($point, $WGS84, $WGS84toOSI, $Airy1830_m);
			//      $grid = self::LatLongToOSGrid($point,$Airy1830_m,$originOSI);
			//      level 1 transformation
			$grid = self::LatLongToOSGrid($point,$WGS84,$originOSI);
			$grid['E'] += 49;
			$grid['N'] -= 23.4;
			return self::gridrefNumToLetIG($grid, 8);
		}

		function WGS84ToITM( &$parser, $phi_d, $lambda_d) {
			// WGS84 Latitude/Longitude to ITM Ireland (doesn't work yet !!!!!!!!!!!!!!)
			$WGS84['a']     = 6378137;
			$WGS84['b']     = 6356752.3142;
			$originITM['F0'] = 0.999820;            // NatGrid scale factor on central meridian
			$originITM['phi0'] = deg2rad(53.5);
			$originITM['lambda0'] = deg2rad(-8);            // NatGrid true origin
			$originITM['N0'] = 750000;
			$originITM['E0'] = 600000;                      // northing & easting of true origin, metres
			$point['phi'] = deg2rad($phi_d);
			$point['lambda'] = deg2rad($lambda_d);
			$grid = self::LatLongToOSGrid($point,$WGS84,$originITM);
			return sprintf("%dm E %dm N",$grid['E'], $grid['N']);
			}

			function WGS84ToLUREF( &$parser, $phi_d, $lambda_d) {
				// WGS84 Latitude/Longitude to LUREF - Luxembourg
				// Based on http://www.act.etat.lu/datum.html
				$HAYFORD24['a'] = 6378388;
				$HAYFORD24['b'] = 6356911.946;
				$originLUREF['F0'] = 1;         // scale factor on central meridian
				$originLUREF['phi0'] = deg2rad(49 + 50/60);
				$originLUREF['lambda0'] = deg2rad(6 + 10/60);           // NatGrid true origin
				$originLUREF['N0'] = 100000;
				$originLUREF['E0'] = 80000;                     // northing & easting of true origin, metres
				//      no datumtransformation needed, Luxembourg is small enough
				$point['phi'] = deg2rad($phi_d);
				$point['lambda'] = deg2rad($lambda_d);
				$grid = self::LatLongToOSGrid($point,$HAYFORD24,$originLUREF);
				extract($grid);
				return sprintf("%dm E %dm N",$E, $N);

		}

		/*
		* convert geodesic co-ordinates to OS grid reference (transverse Mercator projection)
		*/
		function LatLongToOSGrid($point,$ellipse,$origin) {
			// Based on http://www.movable-type.co.uk/scripts/latlong-gridref.html
			extract($point);
			extract($ellipse);
			extract($origin);
			$e2 = 1 - ($b*$b)/($a*$a);      // eccentricity squared
			$n = ($a-$b)/($a+$b);
			$n2 = $n*$n;
			$n3 = $n*$n*$n;
			$cosLat = cos($phi);
			$sinLat = sin($phi);
			$nu = $a*$F0/sqrt(1-$e2*$sinLat*$sinLat);              // transverse radius of curvature
			$rho = $a*$F0*(1-$e2)/pow(1-$e2*$sinLat*$sinLat, 1.5);  // meridional radius of curvature
			$eta2 = $nu/$rho-1;

			$Ma = (1 + $n + (5/4)*$n2 + (5/4)*$n3) * ($phi-$phi0);
			$Mb = (3*$n + 3*$n*$n + (21/8)*$n3) * sin($phi-$phi0) * cos($phi+$phi0);
			$Mc = ((15/8)*$n2 + (15/8)*$n3) * sin(2*($phi-$phi0)) * cos(2*($phi+$phi0));
			$Md = (35/24)*$n3 * sin(3*($phi-$phi0)) * cos(3*($phi+$phi0));
			$M = $b * $F0 * ($Ma - $Mb + $Mc - $Md);              // meridional arc

			$cos3lat = $cosLat*$cosLat*$cosLat;
			$cos5lat = $cos3lat*$cosLat*$cosLat;
			$tan2lat = tan($phi)*tan($phi);
			$tan4lat = $tan2lat*$tan2lat;

			$I = $M + $N0;
			$II = ($nu/2)*$sinLat*$cosLat;
			$III = ($nu/24)*$sinLat*$cos3lat*(5-$tan2lat+9*$eta2);
			$IIIA = ($nu/720)*$sinLat*$cos5lat*(61-58*$tan2lat+$tan4lat);
			$IV = $nu*$cosLat;
			$V = ($nu/6)*$cos3lat*($nu/$rho-$tan2lat);
			$VI = ($nu/120) * $cos5lat * (5 - 18*$tan2lat + $tan4lat + 14*$eta2 - 58*$tan2lat*$eta2);

			$dLon = $lambda-$lambda0;
			$dLon2 = $dLon*$dLon;
			$dLon3 = $dLon2*$dLon;
			$dLon4 = $dLon3*$dLon;
			$dLon5 = $dLon4*$dLon;
			$dLon6 = $dLon5*$dLon;

			$Grid['N'] = $I + $II*$dLon2 + $III*$dLon4 + $IIIA*$dLon6;
			$Grid['E'] = $E0 + $IV*$dLon + $V*$dLon3 + $VI*$dLon5;
			return $Grid;
		}

		/*
		* convert numeric grid reference (in metres) to standard-form grid ref
		*/
		function gridrefNumToLetGB($Grid, $digits) {
			// Based on http://www.movable-type.co.uk/scripts/latlong-gridref.html
			extract($Grid);
			// get the 100km-grid indices
			$e100k = floor($E/100000);
			$n100k = floor($N/100000);
			if ($e100k<0 || $e100k>6 || $n100k<0 || $n100k>12) return '';

			// translate those into numeric equivalents of the grid letters
			$l1 = (19-$n100k) - (19-$n100k)%5 + floor(($e100k+10)/5);
			$l2 = (19-$n100k)*5%25 + $e100k%5;

			// compensate for skipped 'I' and build grid letter-pairs
			if ($l1 > 7) $l1++;
			if ($l2 > 7) $l2++;
			$letPair = chr($l1+ord('A')).chr($l2+ord('A'));

			// strip 100km-grid indices from easting & northing, and reduce precision
			$e = floor(($E%100000)/pow(10,5-$digits/2));
			$n = floor(($N%100000)/pow(10,5-$digits/2));
			switch ($digits)
			{
				case 2:
				return sprintf("%s %'01d %'01d",$letPair, $e, $n);
				break;
				case 4:
				return sprintf("%s %'02d %'02d",$letPair, $e, $n);
				break;
				case 6:
				return sprintf("%s %'03d %'03d",$letPair, $e, $n);
				break;
				case 10:
				return sprintf("%s %'05d %'05d",$letPair, $e, $n);
				break;
				default:
				return sprintf("%s %'04d %'04d",$letPair, $e, $n);
				}
			}

			function gridrefNumToLetIG($Grid, $digits) {
				// Based on http://www.movable-type.co.uk/scripts/latlong-gridref.html
				extract($Grid);
				// get the 100km-grid indices
				$e100k = floor($E/100000);
				$n100k = floor($N/100000);
				if ($e100k<0 || $e100k>5 || $n100k<0 || $n100k>5) return '';

				// translate those into numeric equivalents of the grid letter
				$l = (4-$n100k)*5 + $e100k;

				// compensate for skipped 'I'
				if ($l > 7) $l++;
				$let = chr($l+ord('A'));

				// strip 100km-grid indices from easting & northing, and reduce precision
				$e = floor(($E%100000)/pow(10,5-$digits/2));
				$n = floor(($N%100000)/pow(10,5-$digits/2));
				switch ($digits)
				{
					case 2:
					return sprintf("%s %'01d %'01d",$let, $e, $n);
					break;
					case 4:
					return sprintf("%s %'02d %'02d",$let, $e, $n);
					break;
					case 6:
					return sprintf("%s %'03d %'03d",$let, $e, $n);
					break;
					case 10:
					return sprintf("%s %'05d %'05d",$let, $e, $n);
					break;
					default:
					return sprintf("%s %'04d %'04d",$let, $e, $n);
				}
			}
}
