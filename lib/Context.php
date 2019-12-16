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

class Context{
	static function read($bot, $uniqueParameter) : string{
		if ( !file_exists('lib/other/buffer') && !is_dir('lib/other/buffer') ) {
    		mkdir('lib/other/buffer');       
		} 
		
		$url = 'lib/other/buffer/bot'.$bot->getToken().'_'.$uniqueParameter.'.txt';

		return file_get_contents($url);
	}

	static function write($bot, $uniqueParameter, $contextValue) : void{
		if ( !file_exists('lib/other/buffer') && !is_dir('lib/other/buffer') ) {
    		mkdir('lib/other/buffer');
		} 

		$url = 'lib/other/buffer/bot'.$bot->getToken().'_'.$uniqueParameter.'.txt';
		$file = fopen($url, 'c+');

		fwrite($file, $contextValue);

		fclose($file);
	}

	static function delete($bot, $uniqueParameter) : bool{
		if ( !file_exists('lib/other/buffer') && !is_dir('lib/other/buffer') ) {
    		mkdir('lib/other/buffer');       
		} 

		$url = 'lib/other/buffer/bot'.$bot->getToken().'_'.$uniqueParameter.'.txt';

		unlink($url);
		return true;
	}
}

?>
