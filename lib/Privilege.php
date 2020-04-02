<?php
/*						  
	Copyright© Arseniy Romanovskiy aka ShamanHead     
	This file is part of Telbot package		  
	Created by ShamanHead				  
	Mail: arsenii.romanovskii85@gmail.com	     	  						  
*/

namespace Telbot;

require_once('User.php');

Use Telbot\User as User;
Use \PDO as PDO;

class Privilege{

	public static function setToChat($bot, $value, $userId, $chatId){
		if(!($bot->sqlConnectionPosibility)) throw new \Exception('If you want to use Charter your bot must be connected to database');

		$DBH = $bot->pdoConnection;

		$setPrivelegeToChat = $DBH->prepare('UPDATE telbot_users SET Privilege  = :privilege WHERE userId = :userId AND chatId = :chatId');
		$setPrivelegeToChat->bindParam(':privilege', $value);
		$setPrivelegeToChat->bindParam(':userId' , $userId);
		$setPrivelegeToChat->bindParam(':chatId', $chatId);

		$setPrivelegeToChat->execute();

		return true;
	}

	public static function setToAllChats($bot, $value, $userId){
		if(!($bot->sqlConnectionPosibility)) throw new \Exception('If you want to use Charter your bot must be connected to database');

		$DBH = $bot->pdoConnection;

		$setPrivelegeToAllChats = $DBH->prepare('UPDATE telbot_users SET privilege  = :privilege WHERE userId = :userId');
		$setPrivelegeToAllChats->bindParam(':privilege', $value);
		$setPrivelegeToAllChats->bindParam(':userId' , $userId);

		$setPrivelegeToAllChats->execute();

		return true;
	}

	public static function get($bot, $userId, $chatId){
		if(!($bot->sqlConnectionPosibility)) throw new \Exception('If you want to use Charter your bot must be connected to database');

		$DBH = $bot->pdoConnection;

		$getPrivilege = $DBH->prepare('SELECT privilege from telbot_users WHERE userId = :userId AND chatId = :chatId');
		$getPrivilege->bindParam(':userId' , $userId);
		$getPrivilege->bindParam(':chatId', $chatId);

		$getPrivilege->execute();

		return $getPrivilege->fetch()[0];
	}

}

?>