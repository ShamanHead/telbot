<?php

namespace Telbot\Utils;

use CURLFile;

class File{

	private $filePath;

	function __construct($filePath){
		$this->filePath = $filePath;
	}

	public function encode(){
		$fb = new CURLFile(realpath($this->filePath));
		return $fb;
	}

}

?>
