<?php
class RD {
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

}
