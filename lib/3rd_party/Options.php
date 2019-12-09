<?php
/**********************************************************
*							  *
*	Copyright© Arseniy Romanovskiy aka ShamanHead     *
*	This file is part of Telbot package		  *
*	Created by ShamanHead				  *
*	Mail: arsenii.romanovskii85@gmail.com	     	  *
*							  *
**********************************************************/
namespace Telegram\Addons;

class Option{
	static function value($bot, $act, $unique, $param1 = false) {
		if ( !file_exists('lib/3rd_party/other/buffer') && !is_dir('lib/3rd_party/other/buffer') ) {
    		mkdir('lib/3rd_party/other/buffer');       
		} 

		$url = 'lib/3rd_party/other/buffer/bot'.$bot->getToken().'_'.$unique.'.txt';
		$file = fopen($url, 'c+');

		switch($act){
		    case 'read':
		      return file_get_contents($url);
		        break;
		    case 'write':
		      fwrite($file, $param1);
		      return true;
		        break;
		    case 'delete':
		      unlink($url);
		        break;
		    default:
		      return false;
		        break;
		}
	}
}

?>
