<?php

/*						  
	Copyright© Arseniy Romanovskiy aka ShamanHead     
	This file is part of Telbot package		  
	Created by ShamanHead				  
	Mail: arsenii.romanovskii85@gmail.com	     	  						  
*/

namespace Telbot;

use \PDO as PDO;

class Context{
	public static function read($bot, $chatId, $userId){

		if(!($bot->sqlConnectionPosibility)) throw new \Exception('If you want to use Context your bot must be connected to database');

		User::createTable($bot);

		$DBH = $bot->pdoConnection;

		$getContext = $DBH->prepare('SELECT context FROM telbot_context WHERE botToken = :botToken AND userId = :userId');
		$token = $bot->getToken();
		$getContext->bindParam(':botToken', $token);
		$getContext->bindParam(':userId', $userId);
		$getContext->execute();

		$context = $getContext->fetch();

		return $context[0];

		$DBH = null;
	}

	public static function write($bot, $chatId, $userId, $contextValue) : void{
		self::delete($bot, $chatId, $userId);
		if(!($bot->sqlConnectionPosibility)) throw new \Exception('If you want to use Context your bot must be connected to database');

		User::createTable($bot);

		if(!User::get($bot, $chatId, $userId)) User::add($bot, $chatId, $userId);

		$DBH = $bot->pdoConnection;

		$writeContext = $DBH->prepare('UPDATE telbot_context SET context = :context WHERE userId = :userId AND botToken = :botToken');

		$token = $bot->getToken();

		$writeContext->bindParam(':userId', $userId);
		$writeContext->bindParam(':botToken', $token);
		$writeContext->bindParam(':context', $contextValue);

		$writeContext->execute();

		$DBH = null;
	}

	public static function delete($bot, $chatId, $userId) : bool{
		if(!($bot->sqlConnectionPosibility)) throw new \Exception('If you want to use Context your bot must be connected to database');

		$DBH = $bot->pdoConnection;

		User::createTable($bot);

		$deleteUser = $DBH->prepare('UPDATE telbot_context SET context = "" WHERE userId = :userId AND botToken = :botToken');

		$token = $bot->getToken();

		$deleteUser->bindParam(':userId', $userId);
		$deleteUser->bindParam(':botToken', $token);

		$deleteUser->execute();

		$DBH = null;
		return true;
	}
}

class User{
	public static function createTable($bot) {
		try{
		$DBH = $bot->pdoConnection;

		$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		$tableCreator = $DBH->prepare("CREATE TABLE IF NOT EXISTS telbot_context(
						id INT(11) AUTO_INCREMENT Primary Key,
						userId VARCHAR(50) NOT NULL,
						chatId VARCHAR(50) NOT NULL,
						botToken VARCHAR(50) NOT NULL,
						context VARCHAR(100) NOT NULL
						)
						");

		$tableCreator->execute();

		$DBH = null;
		}catch(PDOException $e) {  
		    echo $e->getMessage();  
		}
	}

	public static function add($bot, $chatId, $userId) {
		if(!$bot->sqlConnectionPosibility) return false;

		self::createTable($bot);

		$DBH = $bot->pdoConnection;

		if(!self::get($bot, $chatId, $userId)){
			$addUser = $DBH->prepare("INSERT INTO telbot_context (userId, chatId, botToken) VALUES (:userId, :chatId,:botToken)");

			$token = $bot->getToken();

			$addUser->bindParam(':userId', $userId);
			$addUser->bindParam(':chatId', $chatId);
			$addUser->bindParam(':botToken', $token);

			$addUser->execute();
		}

		$DBH = null;
	}

	public static function get($bot, $chatId, $userId) {
		if(!$bot->sqlConnectionPosibility) return false;

		$DBH = $bot->pdoConnection;

		$searchUser = $DBH->prepare("SELECT * FROM telbot_context WHERE botToken = :botToken AND userId = :userId AND chatId = :chatId");

		$searchUser->bindParam(':userId', $userId);
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

		$getAllUsers = $DBH->prepare("SELECT * FROM telbot_context WHERE botToken = :botToken");

		$getAllUsers->bindParam(':botToken', $token);

		$token = $bot->getToken();

		$getAllUsers->setFetchMode(PDO::FETCH_ASSOC);

		$getAllUsers->execute();

		return $getAllUsers->fetchAll();
	}

	public static function delete($bot, $chatId, $userId) {
		if(!$bot->sqlConnectionPosibility) return false;

		$DBH = $bot->pdoConnection;

		$token = $bot->getToken();

		$deleteUser = $DBH->prepare('DELETE FROM telbot_context WHERE userId = :userId AND chatId = :chatId AND botToken = :botToken');

		$deleteUser->bindParam(':userId', $userId);
		$deleteUser->bindParam(':chatId', $chatId);
		$deleteUser->bindParam(':botToken', $token);

		$deleteUser->execute();

		$DBH = null;
	}

	public static function sendToAll($bot, $method, $data){
		if(!$bot->sqlConnectionPosibility) return false;

		$allUsers = self::getAll($bot);

		for($i = 0;$i < count($allUsers);$i++){
			$data['chat_id'] = $allUsers[$i]['userId'];
			self::send($bot, $method, $data);
		}

		$DBH = null;
	}
}

?>
