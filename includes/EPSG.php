<?php

use MediaWiki\MediaWikiServices;

class EPSGIO {
	static function EPSG_IO( $coord, $source = null, $target = null ) {
			$config = MediaWikiServices::getInstance()->getConfigFactory()->makeConfig( 'CoordinateConversion' );
			$wgEPSG_URL ??= $config->get( 'CC_EPSG_URL' );
			$wgEPSG_URL ??= $config->get( 'EPSG_URL' );
			$wgEPSG_KEY ??= $config->get( 'EPSG_KEY' );
			$array = explode( ',', preg_replace( '/\s+/', '', $coord ) );
			$x = ( empty( $array[0] ) ) ? 0 : $array[0];
			$y = ( empty( $array[1] ) ) ? 0 : $array[1];
			$z = ( empty( $array[2] ) ) ? 0 : $array[2];
			$url = $wgEPSG_URL . $x . ',' . $y . ',' . $z . '.json?key=' . $wgEPSG_KEY;
		if ( !empty( $source ) ) {
			$url .= '&s_srs=' . $source;
		}
		if ( !empty( $target ) ) {
			$url .= '&t_srs=' . $target;
		}
			$json = file_get_contents( $url );
			$json_array = json_decode( $json, true );
			return $json_array["results"][0];
	}

	static function EPSG( &$parser, $coord, $source = null, $target = null ) {
		$output = self::EPSG_IO( $coord, $source, $target );
		return sprintf( $output["x"] . ', ' . $output["y"] . ', ' . $output["z"] );
	}

	static function EPSGToWGS84( &$parser, $coord, $source ) {
		$output = self::EPSG_IO( $coord, $source, null );
		return sprintf( $output["y"] . ', ' . $output["x"] . ', ' . $output["z"] );
	}

	static function WGS84ToEPSG( &$parser, $coord, $target ) {
		$array = explode( ',', preg_replace( '/\s+/', '', $coord ) );
		[ $array[0], $array[1] ] = [ $array[1], $array[0] ];
		$coord = implode( ',', $array );
			$output = self::EPSG_IO( $coord, null, $target );
		return sprintf( $output["x"] . ', ' . $output["y"] . ', ' . $output["z"] );
	}
}
