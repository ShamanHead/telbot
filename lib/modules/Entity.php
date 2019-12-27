<?php

/**********************************************************
*							  *
*	Copyright© Arseniy Romanovskiy aka ShamanHead     *
*	This file is part of Telbot package		  *
*	Created by ShamanHead				  *
*	Mail: arsenii.romanovskii85@gmail.com	     	  *
*							  *
**********************************************************/

namespace Telbot;

Class Entity{

	public static function inlineQueryResult($resultType ,$data) {
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

	public static function keyboard($data) : array {
		$kbd = [];
		for($i = 0;$i<count($data);$i++){
			array_push($kbd, []);
			for($j = 0;$j<count($data[$i]);$j++){
				array_push($kbd[$i], [ 'text' => $data[$i][$j][0] ]);
			}
		}
		return $kbd;
	}
	public static function inlineKeyboard($data) : array {
		$kbd = [];
		for($i = 0;$i<count($data);$i++){
			array_push($kbd, []);
			for($j = 0;$j<count($data[$i]);$j++){
				array_push($kbd[$i], [ 'text' => $data[$i][$j][0], 'callback_data' =>  $data[$i][$j][1]]);
			}
		}
		return $kbd;
	}
}

?>