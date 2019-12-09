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

use CURLFile;

class Query {

	private static $can_query = [
		/*'send' => [*/'sendmessage',
				   'sendaudio',
				   'sendphoto',
				   'senddocument',
				   'sendanimation',
				   'sendpoll',
				   'sendvenue'/*]*/,
		/*'edit' => [*/'editmessagetext',
				   'editmessagecaption',
				   'editmessagemedia',
				   'editmessagereplymarkup'/*]*/,
		/*'get' => [*/'getuserprofilephotos', 
		          'getfile',
		          'getchat',
		          'getchatmember',
		          'getchatmemberscount',
		          'getme'/*]*/
	];

	static function send($bot , $method, $data) {
		for($i = 0;$i < count(self::$can_query);$i++) {
			if(strcasecmp(self::$can_query[$i], $method) == false) break;
			if($i == count(self::$can_query) - 1 && strcasecmp(self::$can_query[$i], $method) == false) return false;
		}

		$url = 'https://api.telegram.org/bot'.$bot->getToken().'/'.$method.'?';
		
		$chat_id_existed = false;
		foreach($data as $key=>$value) {
			switch($key) {
				case 'reply_markup':
					$data['reply_markup'] = json_encode($value, JSON_UNESCAPED_UNICODE);
					break;
				case 'chat_id':
					$chat_id_existed = true;
					break;
			}
		}
		if($chat_id_existed == false){
			$data['chat_id'] = $bot->standartChatId('get');
		}
		self::query($url, $data);
	}

	static function encodeFile($file){
		$fb = new CURLFile(realpath($file));
		return $fb;
	}

	private static function query($url, $post_fields, $mode = false) {
		$ch = curl_init();

	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));

	    $data = curl_exec($ch);
	    curl_close($ch);

	    switch ($mode) {
	    	case 'get':
	    		return $data;
	    		break;
	    	
	    	default:
	    		return true;
	    		break;
	    }
	}
}

?>
