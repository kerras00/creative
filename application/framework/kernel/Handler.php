<?php


abstract class Handler extends ControllerBase {

	public static function get( $handler ){
		$handler = $handler . 'Handler';
		$handler = new $handler;
		return $handler;
	}

}