# telbot
Easy lib to create your simple message telegram bot!

How to create bot?Very easy!Just create a new bot class:

	use \Telegram\Bot as Bot;

	$bot = new Bot('BOT_API_KEY HERE', $CHAT_ID_HERE);

Okay!It's work(If it's dont work, check your code.If it isn't help, check examples)
Sooo, how to send messages?The Query class will help us with it.Check example:

	use \Telegram\Bot as Bot;
	use \Telegram\Query as Query; //We just include new class named Query
	
	$bot = new Bot('BOT_API_KEY HERE', $CHAT_ID_HERE);
	
	Query::send($bot //Our bot class
			,'sendMessage', //Telegram bot API method
		[
			'text' => 'Hi!How are you?' //Method parameter
		]
	);
	
And it's all!Yes, it's really all, what touch about sending messages.
If you want to send photo, use it:
	
	Query::send($bot
			,'sendPhoto',
		[
			'photo' => 'photo_id or file'
		]
	);
	
Warning: if parameter of the method isn't exitst, his just deleted automatically by telegram server.You can't do so:
(I checked this)

	Query::send($bot
			,'sendMessage',
		[
			'photo' => 'photo_id or file'
		]
	);

And It's working for all Telegram bot API's methods

Okay, but what if I want to send message according to context?
Yes, you can do this with standart addon, named Option.
Let's see how:

	use \Telegram\Addons\Option as Option; //We include new class Option
	use \Telegram\Bot as Bot;
	use \Telegram\Query as Query;
	
	$bot = new Bot('BOT_API_KEY_HERE', $CHAT_ID_HERE);
	
	if(!Option::value($bot, 'read', $chat_id)){
		Query::send($bot
				,'sendMessage',
			[
				'text' => 'Write smth'
			]
		);
		Option::value($bot, 'write', $chat_id, 'smth');
	}else{
		Query::send($bot
				,'sendMessage',
			[
				'text' => 'Okay, you writed!'
			]
		);
		Option::value($bot, 'delete', $data->message->chat->id, 'smth');
	}
	
Okay, it was hard(or not).But how it works?
Static method option::value has 3 parameters: your bot class, action , user chat_id and additional parameter for "write"

About first all clear, but what do second?He has three statements: "read", "write", "delete"
When you choosing read, method reading special file and gives out his value(in example "smth")
You can use it to check, is there a context or not.

If you choose write, in the last argument of method you can write value, to create context.
Please, be careful, when you has more than one context in your script.Always delete context if he is no longer needed!
Okay, last one argument "delete" just delete your context.
	
Full code of this example you can find in telbot/example.php	

It all you need know about basics of this library.If you want to know more, check the code.
Oh, and files ORM.php and Logger.php incompleted, dont use them

Bot.php

	getToken() //return bot token.

	standartChatId($act["get", "set"]) //returns a chat id, or sets new.

create($act["keyboard", "inline_keyboard"], $data) - easy way to create keyboards.
Examples:

	$bot->create('keyboard', [ [ ['Smth'], ['Smth2'] ], [ ['smth3'], ['smth4'] ] ])
	$bot->create('inline_keyboard', [ [ ['Smth'] ], [ ['smth2'] ] ])
	
	Query::send($bot
			,'sendMessage',
		[
			'text' => 'Okay, you writed!',
			'reply_markup' => ['inliner_keyboard' => $bot->create('inline_keyboard', [ [ ['Smth'] ], [ ['smth2'] ] ]),
				 'keyboard' => $bot->create('keyboard', [ [ ['Smth'], ['Smth2'] ], [ ['smth3'], ['smth4'] ] ])]
		]
	);
	
Query.php

	send($bot, $method, $data) //sending request
	
Example:
	
	Query::send($bot
			,'sendMessage',
		[
			'text' => 'Okay, you writed!',
			'reply_markup' => ['inliner_keyboard' => $bot->create('inline_keyboard', [ [ ['Smth'] ], [ ['smth2'] ] ]),
				 'keyboard' => $bot->create('keyboard', [ [ ['Smth'], ['Smth2'] ], [ ['smth3'], ['smth4'] ] ])]
		]
	);
	
Usually method send() gets chat_id specified by Bot's standartChatId() or on creating bot( $bot = new Bot('BOT_API_KEY HERE', $CHAT_ID_HERE) ) but if you want to set specific chat_id, you can use:

	Query::send($bot
			,'sendMessage',
		[
			'text' => 'Text here.',
			'chat_id' => 'Some chat id here'
		]
	);

	encodeFile($file) //Encoded file into CURLFile type
	
Usually used if you want to sent document from your dedicated server.Example, please:
	
	Query::send($bot
			,'sendPhoto',
		[
			'photo' => Query::encodeFile('path')
		]
	);
	
Option.php
