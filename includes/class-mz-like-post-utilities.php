<?php

function in_multiarray( $str, $array ) {

	$exists = false;

	if ( is_array( $array ) ) {
		foreach ( $array as $arr ):
			$exists = in_multiarray( $str, $arr );
		endforeach;
	} else {
		if ( strpos( $array, $str ) !== false ) {
			$exists = true;
		}
	}

	return $exists;
}