<?php

namespace Telegram;

class Bot {
	private $token = 0;
	var $version = 'dev';
	private $standart_chat_id = 0;

	function __construct($token, $standart_chat_id) {
		$this->token = $token;
		$this->standart_chat_id = $standart_chat_id;
	}

	function getToken(){
		return $this->token;
	}

	function standartChatId($act, $id = false) { 
		switch($act){
			case 'get':
				return $this->standart_chat_id;
				break;
			case 'set':
				$this->standart_chat_id = $id;
				return true;
				break;
		}
	}

	function create($act, $data) {
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