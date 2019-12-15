<?php
/**********************************************************
*							  *
*	Copyright© Arseniy Romanovskiy aka ShamanHead     *
*	This file is part of Telbot package		  *
*	Created by ShamanHead				  *
*	Mail: arsenii.romanovskii85@gmail.com	     	  *
*							  *
**********************************************************/
namespace Telegram;

class Bot {
	private $token = 0;
	var $version = 'dev';
	private $standartChatId = 0;

	function __construct($token, $standartChatId) {
		$this->token = $token;
		$this->standartChatId = $standartChatId;
	}

	function getToken(){
		return $this->token;
	}

	function standartChatId($act, $id = false) { 
		switch($act){
			case 'get':
				return $this->standartChatId;
				break;
			case 'set':
				$this->standartChatId = $id;
				return true;
				break;
		}
	}

	function createKeyboard($act, $data) {
		switch($act) {
			case 'keyboard':
				$kbd = [];
				for($i = 0;$i<count($data);$i++){
					array_push($kbd, []);
					for($j = 0;$j<count($data[$i]);$j++){
						array_push($kbd[$i], [ 'text' => $data[$i][$j][0] ]);
					}
				}
				return $kbd;
				break;
			case 'inline_keyboard':
				$kbd = [];
				for($i = 0;$i<count($data);$i++){
					array_push($kbd, []);
					for($j = 0;$j<count($data[$i]);$j++){
						array_push($kbd[$i], [ 'text' => $data[$i][$j][0], 'callback_data' =>  $data[$i][$j][1]]);
					}
				}
				return $kbd;
				break;
		}
	}
}

?>
