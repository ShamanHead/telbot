<?php

require_once('lib/Bot.php');
require_once('lib/Query.php');
require_once('lib/Utils/Keyboard.php');
require_once('lib/Utils/Context.php');

use \Telbot\Utils\Context as Context;
use \Telbot\Utils\Keyboard as Keyboard;
use \Telbot\Query as Query;
use \Telbot\Bot as Bot;

$data = json_decode(file_get_contents('php://input'));
$bot = new Bot('927752546:AAGAnR8H_Aly22V-fIJEVE8srmRTzd_piYs', $data->message->chat->id);

if(!Context::read($bot, $data->message->chat->id)){
	Query::send($bot
			,'sendMessage',
		[
			'text' => 'Write smth'
		]
	);
	Context::write($bot, $data->message->chat->id, 'smth');
}else{
	Query::send($bot
		,'sendMessage',
		[
			'text' => 'Okay, you writed!',
			'reply_markup' => ['keyboard' => Keyboard::create('keyboard', [ [ ['Smth'], ['Smth2'] ], [ ['smth3'], ['smth4'] ] ])]
		]
	);
	Context::delete($bot, $data->message->chat->id);
}

?>