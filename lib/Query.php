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

use CURLFile;
use PDO as PDO;

class Query {

	static function send($bot , $method, $data) {

		$canSended = [
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

		$url = 'https://api.telegram.org/bot'.$bot->getToken().'/'.$method.'?';
		
		$finded = false;

		for($i = 0;$i < count($canSended);$i++){
			if(strcasecmp($method,$canSended[$i]) == 0){
				$finded = true;
			}
		}

		if($finded == false){
			return new \Error('Unknown telegram method');
		}

		$chatIdExisted = false;
		foreach($data as $key=>$value) {
			switch($key) {
				case 'reply_markup':
					$data['reply_markup'] = json_encode($value, JSON_UNESCAPED_UNICODE);
					break;
				case 'chat_id':
					$chatIdExisted = true;
					break;
			}
		}

		if($chatIdExisted == false){
			$data['chat_id'] = $bot->standartChatId('get');
		}

		self::query($url, $data);
	}

	static function encodeFile($file){
		$fb = new CURLFile(realpath($file));
		return $fb;
	}

	private static function query($url, $postFields, $mode = false) {
		$ch = curl_init();

	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
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

	private static function createTable($bot) {
		$DBH = $bot->pdoConnection;

		$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		$tableCreator = $DBH->prepare("CREATE TABLE IF NOT EXISTS bot(
						id INT(11) AUTO_INCREMENT Primary Key,
						userId VARCHAR(50) NOT NULL Unique,
						botToken VARCHAR(50) NOT NULL
						)
						");

		$tableCreator->execute();

		$DBH = null;
	}

	public static function addUser($bot, $userId) {
		if(!$bot->sqlConnectionPosibility) return false;

		$DBH = $bot->pdoConnection;

		if(!self::getUser($bot, $userId)){
			$addUser = $DBH->prepare("INSERT INTO bot (userId, botToken) VALUES (:userId, :botToken)");

			$token = $bot->getToken();

			$addUser->bindParam(':userId', $userId);
			$addUser->bindParam(':botToken', $token);

			$addUser->execute();
		}

		$DBH = null;
	}

	public static function getUser($bot, $userId) {
		if(!$bot->sqlConnectionPosibility) return false;

		$DBH = $bot->pdoConnection;

		$searchUser = $DBH->prepare("SELECT * FROM bot WHERE botToken = :botToken AND userId = :userId");

		$searchUser->bindParam(':userId', $userId);
		$searchUser->bindParam(':botToken', $token);

		$searchUser->setFetchMode(PDO::FETCH_ASSOC);

		$token = $bot->getToken();

		$searchUser->execute();

		$DBH = null;

		return $searchUser->fetchAll();
	}

	public static function getAllUsers($bot) {
		if(!$bot->sqlConnectionPosibility) return false;

		$DBH = $bot->pdoConnection;

		$getAllUsers = $DBH->prepare("SELECT * FROM bot WHERE botToken = :botToken");

		$getAllUsers->bindParam(':botToken', $token);

		$token = $bot->getToken();

		$getAllUsers->setFetchMode(PDO::FETCH_ASSOC);

		$getAllUsers->execute();

		return $getAllUsers->fetchAll();
	}

	public static function deleteUser($bot, $userId) {
		if(!$bot->sqlConnectionPosibility) return false;

		$DBH = $bot->pdoConnection;

		$token = $bot->getToken();

		$deleteUser = $DBH->prepare('DELETE FROM bot WHERE userId = :userId AND botToken = :botToken');

		$deleteUser->bindParam(':userId', $userId);
		$deleteUser->bindParam(':botToken', $token);

		$deleteUser->execute();

		$DBH = null;
	}

	public static function sendToAllActiveChats($bot, $method, $data){
		if(!$bot->sqlConnectionPosibility) return false;

		$allUsers = self::getAllUsers($bot);

		for($i = 0;$i < count($allUsers);$i++){
			$data['chat_id'] = $allUsers[$i]['userId'];
			self::send($bot, $method, $data);
		}

		$DBH = null;
	}


}

?>
