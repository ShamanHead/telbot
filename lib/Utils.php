<?php

namespace Telbot;

class Utils{

	public static function createKeyboard($act, $data) : array {
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