# telbot

<b>Contents</b>
<ul>
	<li>Introducion</li>
	<ul>
		<li><a href = '#creating_bot'>Creating you bot</a></li>
		<li><a href = '#sending_queries'>Sending queries to telegram</a></li>
	</ul>
	<li>
		<a href = '#utils'>Utils</a>
		<ul>
			<li><a href="#utils_context">Context</a></li>
			<li><a href="#utils_keyboard">Creating Keyboard</a></li>
		</ul>
	</li>
	<li>
		<a href = '#mysql_features'>Mysql features</a>
		<ul>
			<li> <a href="#mysql_users">Users</a>
			<li> <a href="#mysql_chats">Users</a>
		</ul>
	</li>
	<li>
		<a href="#inquiry">Inquiry</a>
	</li>
</ul>

<h2 id='creating_bot'>Creating you bot</h2>

How to create bot?Very easy!Just create a new bot class:

	use \Telbot\Bot as Bot;

	$bot = new Bot('BOT_API_KEY HERE');
	
Sooo, how to send messages?The Query class will help us with it.Check example:

	use \Telbot\Bot as Bot;
	use \Telbot\Inquiry as Inquiry;
	use \Telbot\InputHandle as InputHandle;

	$bot = new Bot('BOT_API_KEY HERE');
	$InputHandle = new InputHandle();

	Inquiry::send($bot
			,'sendMessage',
		[
			'chat_id' => $ih->getChatId(),
			'text' => 'Testing your bot.'
		]
	);

<h2 id='sending_queries'>Sending Methods</h2>
	
You can send any of telegram method using this pattern:

	Inquiry::send($bot //Our bot class
			,'someMethod', //Telegram bot API method
		[
			'chat_id' => $InputHandle->getChatId(),
			'text' => 'Testing your bot.' //Method parameter
		]
	);

If telegram method that you writed doesn't exits, you will get an error: "Unknown telegram method"

Supported Methods:

	sendmessage
	sendaudio
	sendphoto
	senddocument
	sendanimation
	sendpoll
	sendvenue
	editmessagetext
	editmessagecaption
	editmessagemedia
	editmessagereplymarkup
	getuserprofilephotos
	getfile
	getchat
	getchatmember
	getchatmemberscount
	getme
	sendchataction
	sendInvoice
	answercallbackquery

<h2 id='utils'>Utils</h2>

<h2 id='utils_context'>Context</h2>

Using class Context from Utils namespace you can create context dependence:

	use \Telegram\Utils\Context as Context; //We include new class Context
	use \Telegram\Bot as Bot;
	use \Telegram\Inquiry as Inquiry;
	use \Telbot\InputHandle as InputHandle;
	
	$InputHandle = new InputHandle();
	$data = json_decode(file_get_contents('php://input'));
	$bot = new Bot('927752546:AAGAnR8H_Aly22V-fIJEVE8srmRTzd_piYs', $data->message->chat->id);

	if(!Context::read($bot, $data->message->chat->id)){ //reading context
		Inquiry::send($bot
				,'sendMessage',
			[
				'chat_id' => $InputHandle->getChatId(),
				'text' => 'Write smth'
			]
		);
		Context::write($bot, $data->message->chat->id, 'smth'); //creating new context
	}else{
		Inquiry::send($bot
			,'sendMessage',
			[
			'chat_id' => $ih->getChatId(),
			'text' => 'Okay, you writed!'
			]
		);
		Context::delete($bot, $data->message->chat->id); //delete context
	}
	
<h2 id='utils_keyboard'>Creating Keyboard</h2>

You can create keyboards easy using this way:

	use \Telegram\Utils\ as Utils;
	use \Telegram\Bot as Bot;

	Utils::buildInlineKeyboard('keyboard', [ [ ['Smth'], ['Smth2'] ], [ ['smth3'], ['smth4'] ] ])
	Utils::buildKeyboard('inline_keyboard', [ [ ['Smth'], ['Smth2'] ] ])

<h2 id='mysql_features'>Mysql features</h2>

To start work with mysql, first you need to do is enable sql connection in your bot object:

	$bot->enableSql();

Later you need to specify sql credentials:

	$bot->sqlCredentials(
		[
			'database_server' => '',
			'database_name' => '',
			'username' => '',
			'password' => ''
		]
		);

Or you can indicate your external pdo connection as sql credentials:
	
	$bot->externalPDO($PDO_CONNECTION);

After all this actions, you can start to work with database.

<h3 id = 'mysql_users'>Working with users in database</h3>

To add user to database, you need to use this function:

	User::add($bot, $userId);

To delete user:

	User::delete($bot, $userId);

To get user:

	User::get($bot, $userId);

This function returns array with row information of this user(row id, chat id, bot token)

To get all users:

	User::getAll($bot);

You can send message to all active users by using this function:

	User::sendToAll($bot, $method, $data);

Data variable contains method parameters(for help see <a href='#sending_queries'>sending methods</a>)

<h3 id = 'mysql_chats'>Working with chats in database</h3>

All the same, but a bit different:

To add chats to database, you need to use this function:

	Chat::add($bot, $chatId);

To delete chats:

	Chat::delete($bot, $chatId);

To get chats:

	Chat::get($bot, $chatId);

This function returns array with row information of this user(row id, chat id, bot token)

To get all chats:

	Chat::getAll($bot);

<h3 id='inquiry'>Inquiry</h3>

Its the main class in this library.This paragraph shows all capabilities of this class.

This class has only one method - Inquiry::send().With this method you can send quiries who can contain messages, photos, videos etc.

	Inquiry::send($bot, $method, $data);

This class, like all library, support all telegram bot api methods.
With this class you can send both simple text messages and complex answers.
Lets see some examples:

<b>Sending simple answer</b>

	Inquiry::send($bot, 'sendMessage', [
		'chat_id' => $InputHandle->getChatId(),
		'text' => 'This is a testing message'
	
	]);

<b>Sending callback query answer</b>

	Inquiry::send($bot, 'answerCallbackQuery', [
		'callback_query_id' => $InputHandle->getCallbackQueryId(),
		'text' => 'This is a callback answer, who lool like common notification'
	]);

<b>Sending Inline query answer</b>

	Inquiry::answerInlineQuery($bot, [
		'inline_query_id' => $InputHandle->getInlineQueryId(),
		'results' => [
			[
				'type' => 'article', //creating an array of InlineQueryResultArticle object
				'id' => 123123,
				'title' => 'test',
				'input_message_content' => [
					'message_text' => 'Yes, its just test'
				]
			]
		]
	]);

You can send any of telegram methods with this method send.All of this supported.

<h3>Input Handle</h3>

This class needs for comfortable work with telegram answer query.

<b>Creating a new InputHandle object</b>

	$InputHanle = new InputHandle();

<b>Working with data</b>

