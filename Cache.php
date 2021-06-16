<?php

class Cache {
	
	protected $path = "/home/zkfzs1g2xscu/public_html/b2binpay/";
	protected $duration = 600;
	
	function __construct ( $path="/home/zkfzs1g2xscu/public_html/b2binpay/", $duration = 600) {
		$this->path = $path;
		$this->duration = $duration;
	}
	
	function get( $id ) {
		$file = $this->path . $id . '.cache';
		if (file_exists($file) && time() - filemtime($file) < $this->duration) {
			return unserialize( file_get_contents($file) );			
		} else {
			return null;
		}
	}
	
	function set( $id, $obj) {
		$file = $this->path . $id . '.cache';
		file_put_contents($file, serialize($obj));
	}
}
?>
