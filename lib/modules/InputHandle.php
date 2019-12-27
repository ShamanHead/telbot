<?php

/**********************************************************
*							  *
*	Copyright© Arseniy Romanovskiy aka ShamanHead     *
*	This file is part of Telbot package		  *
*	Created by ShamanHead				  *
*	Mail: arsenii.romanovskii85@gmail.com	     	  *
*							  *
**********************************************************/

namespace Telbot

class InputHandle{

	private $inputData;

	function __construct(){
		$this->inputData = json_decode(file_get_contents('php://input'));
	}

	function __clone(){}

	public function getChatId
}

?>