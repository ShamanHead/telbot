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

use PDO as PDO;

class ActiveChat{
	private static function createTable($bot) {
		try{
		$DBH = $bot->pdoConnection;

		$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		$tableCreator = $DBH->prepare("CREATE TABLE IF NOT EXISTS bot_users(
						id INT(11) AUTO_INCREMENT Primary Key,
						chatId VARCHAR(50) NOT NULL Unique,
						botToken VARCHAR(50) NOT NULL
						)
						");

		$tableCreator->execute();

		$DBH = null;
		}catch(PDOException $e) {  
		    echo $e->getMessage();  
		}
	}

	public static function add($bot, $chatId) {
		if(!$bot->sqlConnectionPosibility) return false;

		self::createTable($bot);

		$DBH = $bot->pdoConnection;

		if(!self::get($bot, $chatId)){
			$addUser = $DBH->prepare("INSERT INTO bot_users (chatId, botToken) VALUES (:chatId, :botToken)");

			$token = $bot->getToken();

			$addUser->bindParam(':chatId', $chatId);
			$addUser->bindParam(':botToken', $token);

			$addUser->execute();
		}

		$DBH = null;
	}

	public static function get($bot, $chatId) {
		if(!$bot->sqlConnectionPosibility) return false;

		$DBH = $bot->pdoConnection;

		$searchUser = $DBH->prepare("SELECT * FROM bot_users WHERE botToken = :botToken AND chatId = :chatId");

		$searchUser->bindParam(':chatId', $chatId);
		$searchUser->bindParam(':botToken', $token);

		$searchUser->setFetchMode(PDO::FETCH_ASSOC);

		$token = $bot->getToken();

		$searchUser->execute();

		$DBH = null;

		return $searchUser->fetchAll();
	}

	public static function getAll($bot) {
		if(!$bot->sqlConnectionPosibility) return false;

		$DBH = $bot->pdoConnection;

		$getAllUsers = $DBH->prepare("SELECT * FROM bot_users WHERE botToken = :botToken");

		$getAllUsers->bindParam(':botToken', $token);

		$token = $bot->getToken();

		$getAllUsers->setFetchMode(PDO::FETCH_ASSOC);

		$getAllUsers->execute();

		return $getAllUsers->fetchAll();
	}

	public static function delete($bot, $chatId) {
		if(!$bot->sqlConnectionPosibility) return false;

		$DBH = $bot->pdoConnection;

		$token = $bot->getToken();

		$deleteUser = $DBH->prepare('DELETE FROM bot_users WHERE chatId = :chatId AND botToken = :botToken');

		$deleteUser->bindParam(':chatId', $chatId);
		$deleteUser->bindParam(':botToken', $token);

		$deleteUser->execute();

		$DBH = null;
	}

	public static function sendToAll($bot, $method, $data){
		if(!$bot->sqlConnectionPosibility) return false;

		$allUsers = self::getAllActiveChats($bot);

		for($i = 0;$i < count($allUsers);$i++){
			$data['chat_id'] = $allUsers[$i]['userId'];
			self::send($bot, $method, $data);
		}

		$DBH = null;
	}
}

?>