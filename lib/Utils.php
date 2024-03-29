<?php

/*						  
	Copyright© Arseniy Romanovskiy aka ShamanHead     
	This file is part of Telbot package		  
	Created by ShamanHead				  
	Mail: arsenii.romanovskii85@gmail.com	     	  						  
*/

namespace Telbot;

use CURLFile;
//
Class Utils{

	public static function buildInlineQueryResult($resultType ,$data) {
		$id = false;
		foreach($data as $key=>$value) {
			switch($key) {
				case 'id':
					$id = true;
					break;
			}
		}

		if(!$id){
			$data['id'] = 1; 
		}

		$data['type'] = $resultType;

		return json_encode([$data]);
	}

	public static function buildKeyboard($data, $resize = false, $oneTime = false, $selective = false) : array {
		$kbd = ['keyboard' => [], 'resize_keyboard' => false, 'one_time_keyboard' => false, 'selective' => false];
		if($resize){
			$kbd['resize_keyboard'] = true;
		}
		if($oneTime){
			$kbd['one_time_keyboard'] = true;
		}
		if($selective){
			$kbd['selective'] = true;
		}
		for($i = 0;$i<count($data);$i++){
			array_push($kbd['keyboard'], []);
			for($j = 0;$j<count($data[$i]);$j++){
				array_push($kbd['keyboard'][$i], [ 'text' => $data[$i][$j][0] ]);
			}
		}
		return $kbd;
	}
	public static function buildInlineKeyboard($data, $resize = false, $oneTime = false, $selective = false) : array {
		$kbd = ['inline_keyboard' => [], 'resize_keyboard' => false, 'one_time_keyboard' => false, 'selective' => false];
		if($resize){
			$kbd['resize_keyboard'] = true;
		}
		if($oneTime){
			$kbd['one_time_keyboard'] = true;
		}
		if($selective){
			$kbd['selective'] = true;
		}
		for($i = 0;$i<count($data);$i++){
			array_push($kbd['inline_keyboard'], []);
			for($j = 0;$j<count($data[$i]);$j++){
				array_push($kbd['inline_keyboard'][$i], [ $data[$i][$j]);
			}
		}
		return $kbd;
	}

	public static function encodeFile($filePath){
		$fb = new CURLFile(realpath($filePath));
		return $fb;
	}
}

?>