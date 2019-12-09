<?php

namespace Telegram;

class Ben {
	
	function __construct($credentials) {
		private $DBH = new PDO('mysql:host='.$credentials['host'].';dbname='.$credentials['dbname'], $credentials['username'], $credentials['password']);
	}

	function create($act, $param1 = false, $param2 = false, ...$rows, ...$values) {
		$query = $DBH->prepare('INSERT ')
	}

	function count() {

	}

	function update() {

	}

	function read() {

	}

	function delete() {

	}

}

?>