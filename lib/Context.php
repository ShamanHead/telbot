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

class Context{
	public static function read($bot, $chatId, $userId){

		if(!($bot->sqlConnectionPosibility)) throw new \Exception('If you want to use Context your bot must be connected to database');

		User::createTable($bot);

		$DBH = $bot->pdoConnection;

		$getContext = $DBH->prepare('SELECT context FROM telbot_users WHERE botToken = :botToken AND userId = :userId');
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

		$writeContext = $DBH->prepare('UPDATE telbot_users SET context = :context WHERE userId = :userId AND botToken = :botToken');

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

		$deleteUser = $DBH->prepare('UPDATE telbot_users SET context = "" WHERE userId = :userId AND botToken = :botToken');

		$token = $bot->getToken();

		$deleteUser->bindParam(':userId', $userId);
		$deleteUser->bindParam(':botToken', $token);

		$deleteUser->execute();

		$DBH = null;
		return true;
	}
}

?>
