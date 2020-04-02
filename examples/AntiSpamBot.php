<?php

/*						  
	Copyright© Arseniy Romanovskiy aka ShamanHead     
	This file is part of Telbot package		  
	Created by ShamanHead				  
	Mail: arsenii.romanovskii85@gmail.com	     	  						  
*/

require_once('lib/Bot.php');
require_once('lib/Utils.php');
require_once('lib/Inquiry.php');
require_once('lib/InputHandle.php');
require_once('lib/Context.php');
require_once('lib/Chat.php');

Use Telbot\Bot as Bot;
Use Telbot\Utils as Utils;
Use Telbot\Inquiry as Inquiry;
Use Telbot\InputHandle as InputHandle;
Use Telbot\Context as Context;
Use Telbot\User as User;

$bot = new Bot();
$InputHandle = new InputHandle();
$bot->enableSql();
$DBH = new PDO();
$bot->externalPdo($DBH); //Setting a PDO connection as bot sql connection
$context = Context::read($bot, $InputHandle->getChatId(), $InputHandle->getUserId()); //reading a context from this user
$delay = 2;

if(!$context) Context::write($bot, $InputHandle->getChatId(), $InputHandle->getUserId(), date('U')); //if user has no context, creating him with current time.

if(isset($context) && ((date('U') - $context) < $delay) ){ //if context exists and if the message arrived earlier than 2 seconds after the last message
	Inquiry::send($bot, 'deleteMessage', [ //deleting user message
		'chat_id' => $InputHandle->getChatId(),
		'message_id' => $InputHandle->getInstance()->message_id
	]);
	Inquiry::send($bot, 'sendMessage', [ //displaying an error
		'chat_id' => $InputHandle->getChatId(),
		'text' => "Please, calm down!($delay)"
	]);
	sleep($delay);
	Inquiry::send($bot, 'deleteMessage', [ //and delete error message
		'chat_id' => $InputHandle->getChatId(),
		'message_id' => $InputHandle->getInstance()->message_id + 1
	]);
}else{
	Context::write($bot, $InputHandle->getChatId(), $InputHandle->getUserId(), date('U')); //if the message arrived later than 2 seconds after the last message we sets a new context with current time
}

?>