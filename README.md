# telbot

<b>Contents</b>
<ul>
	<li><a href = '#introducion'><b>Introducion</b></a></li>
	<ul>
		<li><a href = '#creating_bot'>Creating you bot</a></li>
	</ul>
	<li>
		<a href = '#utils'><b>Utils</b></a>
		<ul>
			<li><a href="#utils_keyboard">Creating keyboard</a></li>
			<li><a href="#utils_encoding">Encoding files</a></li>
			<li><a href="#utils_inline_query_result">Building inline query result</a></li>
		</ul>
	</li>
	<li>
		<a href = '#mysql_features'><b>Mysql features</b></a>
		<ul>
			<li><a href="#context">Context</a></li>
			<li> <a href="#mysql_chats">Chats</a>
		</ul>
	</li>
	<li>
		<a href="#inquiry"><b>Inquiry</b></a>
		<ul>
			<li><a href="#inquiry_support">Supported methods</a></li>
			<li><a href="#inquiry_simple">Sending simple answers</a></li>
			<li><a href="#inquiry_callback">Sending callback answers</a></li>
			<li><a href="#inquiry_inline">Sending inline answers</a></li>
			<li><a href="#inquiry_files">Sending files</a></li>
		</ul>
	</li>
	<li>
		<a href="#input_handle"><b>InputHandle</b></a>
		<ul>
			<li><a href="#input_handle_create">Creating a new InputHandle object</a></li>
			<li><a href="#input_handle_working">Working with data</a></li>
		</ul>
	</li>
	<li>
		<a href="#privilege"><b>Privilege</b></a>
	</li>
	<li><a href="#examples"><b>Examples</b></a></li>
	<li><a href="#credits"><b>Credits</b></a></li>
</ul>

<h2 id = 'introducion'>Introducion</h2>

If you want to create your bot, for the first you need to register him.You can do it with @BotFather.
Open the dialog with him and write /newbot , like as in this image:

![Снимок](https://user-images.githubusercontent.com/31220669/77857189-c0e6ac80-7204-11ea-9f7b-a6f204143cac.PNG)

![Снимок6](https://user-images.githubusercontent.com/31220669/77857225-eb386a00-7204-11ea-9a2e-7cd4511719e6.PNG)

After that you need to set webhook on your bot.Webhook its a system, who sending queries to your server, if telegram gets one.

Before start creating a webhook you need bot api token and server.If you dont have a server, you can use <a href="https://heroku.com">heroku</a> to create one.

You can find your bot api token by writing /mybots, then select your bot, and then select button "API Token".Example:

![Снимок2](https://user-images.githubusercontent.com/31220669/77857239-fe4b3a00-7204-11ea-87b0-7f45defc1170.PNG)

![Снимок 3PNG](https://user-images.githubusercontent.com/31220669/77857243-01dec100-7205-11ea-93fa-50d83bc4670d.PNG)

![Снимок3](https://user-images.githubusercontent.com/31220669/77857248-04411b00-7205-11ea-9e6d-0ae54248e6a3.PNG)

When you finish all this actions, you can set webhook to your bot.For this you need to use bot api method setWebhook:

![Снимок8](https://user-images.githubusercontent.com/31220669/77857325-731e7400-7205-11ea-9130-252cbbb32585.PNG)

Then, if you done all right, you will see this answer:

![Снимок4](https://user-images.githubusercontent.com/31220669/77857285-305c9c00-7205-11ea-9d4e-984c29d116e4.PNG)

After that you can start working with your bot.But how I can work?You can ask me.Lets see, how.

<h2 id='creating_bot'>Creating you bot</h2>

How to create bot?Very easy!Just create a new bot class:

```php
	use \Telbot\Bot as Bot;

	$bot = new Bot('BOT_API_KEY HERE');
```

So, lets create a script, who will send a text message as test.But how?The Inquiry class will help us with it:

```php
	use \Telbot\Bot as Bot;
	use \Telbot\Inquiry as Inquiry;
	use \Telbot\InputHandle as InputHandle;

	$bot = new Bot('API_TOKEN');
	$InputHandle = new InputHandle();

	Inquiry::send($bot
			,'sendMessage',
		[
			'chat_id' => $InputHandle->getChatId(),
			'text' => 'Testing your bot.'
		]
	);
```

![Снимок](https://user-images.githubusercontent.com/31220669/77940068-ca354f00-72c0-11ea-9756-0b0a3b030594.PNG)

<h2 id='utils'>Utils</h2>

Supporting class for ease of work with telegram bot api types.

<h2 id='utils_keyboard'>Creating keyboard</h2>

You can create keyboards easy using this way:

```php
	use \Telbot\Utils\ as Utils;
	use \Telbot\Bot as Bot;

	Utils::buildInlineKeyboard([[['one', 'text']], [['two', 'text']], [['three', 'test']]])

	Utils::buildKeyboard([[['third'], ['second'], ['first']]])
```

Examples:

```php

	use \Telbot\Utils as Utils;
	use \Telbot\Bot as Bot;
	use \Telbot\InputHandle as InputHandle;
	use \Telbot\Inquiry as Inquiry;

	$bot = new Bot('API_TOKEN');
	$InputHandle = new InputHandle();

	Inquiry::send($bot, 'sendMessage', [
		'chat_id' => $InputHandle->getChatId(),
		'text' => 'Simple text.',
		'reply_markup' => Utils::buildInlineKeyboard([[['one', 'callback']], [['two', 'callback']], [['three', 'callback']]])
	]);

```

![Снимок3](https://user-images.githubusercontent.com/31220669/77940081-d02b3000-72c0-11ea-9300-3d035a16625b.PNG)

<h2 id='#utils_encoding'>Encoding files</h2>

If you want to send video or photo to user, you need to encode them to CURl format.For this use this method:
```php

	Utils::encodeFile($filePath) //return encoded CURlfile object.

```

Parameter $filePath need to indicate path to file you want to send.

<h2 id='utils_inline_query_result'>Building inline query result</h2>

If you want to send an answer to inline query, you need to build answer object.For this use this method:

```php

	Utils::buildInlineQueryResult($resultType ,$data) //returns json encoded array of $data with type of result $resultType

```
You can check example <a href="#inquiry_inline">here</a>

<h2 id='mysql_features'>Mysql features</h2>

To start work with mysql, first you need to do is enable sql connection in your bot object:

```php
	$bot->enableSql();
```

You can also disable sql by using similar method:

```php
	
	$bot->disableSql();

```

Warning: if your sql connection doesnt exist, you can not use this modules:User, Chat.
In this case Context instead of writing context values ​​to the database would be create new file with context(one to user).

Later you need to specify sql credentials:

```php
	$bot->sqlCredentials(
		[
			'database_server' => '',
			'database_name' => '',
			'username' => '',
			'password' => ''
		]
		);
```

Or you can indicate your external pdo connection as sql credentials:

```php
	$bot->externalPDO($PDO_CONNECTION);
```

After all this actions, you can start to work with database.

<h2 id='context'>Context</h2>

Using class Context you can create context dependence:

```php
	use \Telbot\Context as Context; //We include new class Context
	use \Telbot\Bot as Bot;
	use \Telbot\Inquiry as Inquiry;
	use \Telbot\InputHandle as InputHandle;
	
	$InputHandle = new InputHandle();
	$bot = new Bot('API_TOKEN');
	$DBH = new PDO();
	$bot->externalPDO($DBH);
	$bot->enableSql();

	if(!Context::read($bot, $InputHandle->getChatId(), $InputHandle->getUserId())){ //reading context
		Inquiry::send($bot
				,'sendMessage',
			[
				'chat_id' => $InputHandle->getChatId(),
				'text' => 'Write smth'
			]
		);
		Context::write($bot, $InputHandle->getChatId(), $InputHandle->getUserId(), 'smth'); //creating new context
	}else{
		Inquiry::send($bot
			,'sendMessage',
			[
			'chat_id' => $InputHandle->getChatId(),
			'text' => 'Okay, you writed!'
			]
		);
		Context::delete($bot, $InputHandle->getChatId(), $InputHandle->getUserId()); //delete context
	}
```

![Снимок2](https://user-images.githubusercontent.com/31220669/77940072-cd303f80-72c0-11ea-837e-903d9c83020e.PNG)


<h2 id = 'mysql_chats'>Working with chats in database</h2>

All the same, but a bit different:

To add chats to database, you need to use this function:

```php
	Chat::add($bot, $chatId);
```

To delete chats:

```php
	Chat::delete($bot, $chatId);
```

To get chats:

```php
	Chat::get($bot, $chatId);
```

This function returns array with row information of this chat(row id, chat id, bot token)

To get all chats:

```php
	Chat::getAll($bot);
```

<h2 id='inquiry'>Inquiry</h2>

Its the main class in this library.This paragraph shows all capabilities of this class.

This class has only one method - Inquiry::send().With this class you can send both simple text messages and complex answers.

```php
	Inquiry::send($bot, $method, $data);
```

<h2 id='inquiry_support'>Supported methods</h2>

All method supported during version of API 4.7

<h2 id='inquiry_simple'>Sending simple answer</h2>

```php
	Inquiry::send($bot, 'sendMessage', [
		'chat_id' => $InputHandle->getChatId(),
		'text' => 'This is a testing message'
	
	]);
```

<h2 id='inquiry_callback'>Sending callback query answer</h2>

```php
	Inquiry::send($bot, 'answerCallbackQuery', [
		'callback_query_id' => $InputHandle->getCallbackQueryId(),
		'text' => 'This is a callback answer, who lool like common notification'
	]);
```

<h2 id='inquiry_inline'>Sending Inline query answer</h2>

```php
	Inquiry::answerInlineQuery($bot, [
		'inline_query_id' => $InputHandle->getInlineQueryId(),
		'results' => Utils::buildInlineQueryResult('article', [
		'title' => 'test',
		'input_message_content' => [
			'message_text' => 'Yes, its just test'
		]])
	]);
```

You can send any of telegram methods with this method send.All of this supported.

<h2 id='inquiry_files'>Sending files</h2>

```php
	//sending photo
	use \Telbot\Bot as Bot;
	use \Telbot\InputHandle as InputHandle;
	use \Telbot\Inquiry as Inquiry;

	$bot = new Bot('927942575:AAHZpZoG2pBRw25Lw-pPaw8FU15t00Lsf3A');
	$InputHandle = new InputHandle();

	Inquiry::send($bot ,'sendPhoto', [
		'chat_id' => $InputHandle->getChatId(),
		'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/83/Telegram_2019_Logo.svg/1200px-Telegram_2019_Logo.svg.png',
		'caption' => 'This is an image!So beautiful'
	]);
```

To send files from your server, you need to encode file to CURl format.For this, you need to use method <a href="#utils_encoding">Utils::encodeFile</a>.

```php

	use \Telbot\Utils as Utils;
	use \Telbot\Bot as Bot;
	use \Telbot\InputHandle as InputHandle;
	use \Telbot\Inquiry as Inquiry;

	$bot = new Bot('927942575:AAHZpZoG2pBRw25Lw-pPaw8FU15t00Lsf3A');
	$InputHandle = new InputHandle();

	Inquiry::send($bot ,'sendPhoto', [
		'chat_id' => $InputHandle->getChatId(),
		'photo' => Utils::encodeFile('app/something/telegram.png'),
		'caption' => 'This is an image!So beautiful'
	]);

```

<h2 id='input_handle'>Input Handle</h2>

This class needs for comfortable work with telegram answer query.

<h2 id='input_handle_create'>Creating a new InputHandle object</h2>

```php
	$InputHanle = new InputHandle();
```

<h2 id='input_handle_working'>Working with data</h2>

```php
	$InputHandle->getUpdateId() // returns an update id of telegram answer query.

	$InputHandle->getQueryType() // returns a query type of telegram answer query(callback_query,inline_query,message).

	$InputHandle->newChatMember() // returns true when new member comes to telegram chat.

	$InputHandle->getMessageText() // returns a text of message.

	$InputHandle->getChatId() // returns a chat id, where the message come.

	$InputHandle->getInstance() // returns an array of telegram answer.

	$InputHandle->getCallbackData() //  returns a callback data from telegram answer query.

	$InputHandle->getCallBackQueryId() // returns a callback query id from telegram answer query.

	$InputHandle->getInlineQueryId() // returns an inline query in from telegram answer query.

	$InputHandle->getUserId() // returns user id.

	$InputHandle->getChatType() // returns chat type.

	$InputHandle->getChat() // returns chat array from telegram answer query.

	$InputHandle->getDate() // returns date when telegram answer query was send.

	$InputHandle->getEntities() // return message entities from telegram answer query.

```

<h2 id='privelege'>Privelege</h2>

You can give a user a specific privilege in the chat(or all chats). This can be used to give access to certain commands to that particular user.

```php

	Privilege::setToChat($bot, $value, $userId, $chatId); //for one chat

```

```php

	Privilege::setToAllChats($bot, $value, $userId); //for all chats

```

```php

	Privilege::get($bot, $userId); //getting a privelege

```

<h2>Examples</h2>

See examples at 'examples' folder.

<h2>License</h2>

Please see the LICENSE included in this repository for a full copy of the MIT license, which this project is licensed under.

