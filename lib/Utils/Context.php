<?php
/**********************************************************
*							  *
*	Copyright© Arseniy Romanovskiy aka ShamanHead     *
*	This file is part of Telbot package		  *
*	Created by ShamanHead				  *
*	Mail: arsenii.romanovskii85@gmail.com	     	  *
*							  *
**********************************************************/
namespace Telbot\Utils;

class Context{
	public static function read($bot, $chatId){

		if($bot->sqlConnectionPosibility){

			self::createTable($bot);

			$DBH = $bot->pdoConnection;

			$getContext = $DBH->prepare('SELECT context FROM bot_contexts WHERE botToken = :botToken AND chatId = :chatId');
			$token = $bot->getToken();
			$getContext->bindParam(':botToken', $token);
			$getContext->bindParam(':chatId', $chatId);
			$getContext->execute();

			$context = $getContext->fetch();

			return $context[0];

			$DBH = null;
		}else{
			if ( !file_exists('lib/other/buffer') && !is_dir('lib/other/buffer') ) {
    			mkdir('lib/other/buffer');       
			} 
			
			$url = 'lib/other/buffer/bot'.$bot->getToken().'_'.$chatId.'.txt';

			$fp = fopen($url, 'c+'); //If file not exist he will created, else - just opened.
			fclose($fp);

			return file_get_contents($url);
			}
	}

	public static function write($bot, $chatId, $contextValue) : void{
		if($bot->sqlConnectionPosibility){
			$DBH = $bot->pdoConnection;

			$writeContext = $DBH->prepare('INSERT INTO bot_contexts (chatId, botToken, context) VALUES (:chatId, :botToken, :context)');

			$token = $bot->getToken();

			$writeContext->bindParam(':chatId', $chatId);
			$writeContext->bindParam(':botToken', $token);
			$writeContext->bindParam(':context', $contextValue);

			$writeContext->execute();

			$DBH = null;
		}else{
			if ( !file_exists('lib/other/buffer') && !is_dir('lib/other/buffer') ) {
	    		mkdir('lib/other/buffer');
			} 

			$url = 'lib/other/buffer/bot'.$bot->getToken().'_'.$chatId.'.txt';
			$file = fopen($url, 'c+');

			fwrite($file, $contextValue);

			fclose($file);
		}
	}

	public static function delete($bot, $chatId) : bool{
		if($bot->sqlConnectionPosibility){
			$DBH = $bot->pdoConnection;

			$deleteUser = $DBH->prepare('DELETE FROM bot_contexts WHERE chatId = :chatId AND botToken = :botToken');

			$token = $bot->getToken();

			$deleteUser->bindParam(':chatId', $chatId);
			$deleteUser->bindParam(':botToken', $token);

			$deleteUser->execute();

			$DBH = null;
		}else{
			if ( !file_exists('lib/other/buffer') && !is_dir('lib/other/buffer') ) {
	    		mkdir('lib/other/buffer');       
			} 

			$url = 'lib/other/buffer/bot'.$bot->getToken().'_'.$chatId.'.txt';

			unlink($url);
		}
		return true;
	}

	private static function createTable($bot) : void{
		$DBH = $bot->pdoConnection;

		$tableCreator = $DBH->prepare("CREATE TABLE IF NOT EXISTS bot_contexts(
						id INT(11) AUTO_INCREMENT Primary Key,
						chatId VARCHAR(50) NOT NULL Unique,
						botToken VARCHAR(50) NOT NULL,
						context VARCHAR(50) NOT NULL
						)
						");

		$tableCreator->execute();

		$DBH = null;
	}
}

?>
