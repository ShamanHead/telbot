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

class InlineQuery extends Query{
	public static function answer($bot, $data) {

		$url = 'https://api.telegram.org/bot'.$bot->getToken().'/answerInlineQuery?';

		self::query($url, $data);
	}

	public static function result($resultType ,$data){
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

}

?>