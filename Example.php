<?php

/*
	You can also check how work example at http://t.me/Testing1337002_bot
*/

require_once('lib/src/Bot.php');
require_once('lib/src/Query.php');
require_once('lib/3rd_party/Options.php');

use \Telegram\Addons\Option as Option;
use \Telegram\Query as Query;
use \Telegram\Bot as Bot;

$data = json_decode(file_get_contents('php://input'));
$bot = new Bot('SOME BOT API KEY HERE', $data->message->chat->id);

if(!Option::value($bot, 'read', $data->message->chat->id)){
	Query::send($bot
			,'sendMessage',
		[
			'text' => 'Write smth'
		]
	);
	Option::value($bot, 'write', $data->message->chat->id, 'smth');
}else{
	Query::send($bot
		,'sendMessage',
		[
			'text' => 'Okay, you writed!',
			'reply_markup' => ['keyboard' => $bot->createKeyboard('keyboard', [ [ ['Smth'], ['Smth2'] ], [ ['smth3'], ['smth4'] ] ])]
		]
	);
	Option::value($bot, 'delete', $data->message->chat->id, 'smth');
}

?>
