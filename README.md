# telbot

<b>Contents</b>
<ul>
	<li><a href = '#creating_bot'>Creating you bot</a></li>
	<li><a href = '#sending_queries'>Sending queries to telegram</a></li>
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
		</ul>
	</li>
</ul>

<b id='creating_bot'>Creating you bot</b>

How to create bot?Very easy!Just create a new bot class:

	use \Telbot\Bot as Bot;

	$bot = new Bot('BOT_API_KEY HERE');
	
Sooo, how to send messages?The Query class will help us with it.Check example:

	use \Telbot\Bot as Bot;
	use \Telbot\Inquiry as Inquiry;
	use \Telbot\InputHandle as InputHandle;

	$bot = new Bot('BOT_API_KEY HERE');
	$ih = new InputHandle();

	Inquiry::send($bot
			,'sendMessage',
		[
			'chat_id' => $ih->getChatId(),
			'text' => 'Testing your bot.'
		]
	);

<b id='sending_queries'>Sending Methods</b>
	
You can send any of telegram method using this pattern:

	Inquiry::send($bot //Our bot class
			,'someMethod', //Telegram bot API method
		[
			'chat_id' => $ih->getChatId(),
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

<b id='utils'>Utils</b>

<b id='utils_context'>Context</b>

Using class Context from Utils namespace you can create context dependence:

	use \Telegram\Utils\Context as Context; //We include new class Context
	use \Telegram\Bot as Bot;
	use \Telegram\Inquiry as Inquiry;
	use \Telbot\InputHandle as InputHandle;
	
	$data = json_decode(file_get_contents('php://input'));
	$bot = new Bot('927752546:AAGAnR8H_Aly22V-fIJEVE8srmRTzd_piYs', $data->message->chat->id);

	if(!Context::read($bot, $data->message->chat->id)){ //reading context
		Inquiry::send($bot
				,'sendMessage',
			[
				'chat_id' => $ih->getChatId(),
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
	
<b id='utils_keyboard'>Creating Keyboard</b>

You can create keyboards easy using this way:

	use \Telegram\Utils\ as Utils;
	use \Telegram\Bot as Bot;

	Utils::buildInlineKeyboard('keyboard', [ [ ['Smth'], ['Smth2'] ], [ ['smth3'], ['smth4'] ] ])
	Utils::buildKeyboard('inline_keyboard', [ [ ['Smth'], ['Smth2'] ] ])

<b id='mysql_features'>Mysql features</b>

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

	User::add($bot, $chatId);

To delete user:

	User::delete($bot, $chatId);

To get user:

	User::get($bot, $chatId);

This function returns array with row information of this user(row id, chat id, bot token)

To get all users:

	User::getAll($bot);

You can send message to all active chats by using this function:

	User::sendToAllActiveChats($bot, $method, $data);

Data variable contains method parameters(for help see <a href='#sending_queries'>sending queries</a>)
