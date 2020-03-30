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
			<li><a href="#utils_context">Context</a></li>
			<li><a href="#utils_keyboard">Creating Keyboard</a></li>
		</ul>
	</li>
	<li>
		<a href = '#mysql_features'><b>Mysql features</b></a>
		<ul>
			<li> <a href="#mysql_users">Users</a>
			<li> <a href="#mysql_chats">Chats</a>
		</ul>
	</li>
	<li><a href="#inquiry"><b>Inquiry</b></a></li>
	<li><a href="#input_handle"><b>InputHandle</b></a></li>
</ul>

<h2 id = 'introducion'>Introducion</h2>

If you want to create your bot, for the first you need to register him.You can do it with @BotFather.
Open the dialog with him and write /newbot , like as in this image:

![Снимок](https://user-images.githubusercontent.com/31220669/77857189-c0e6ac80-7204-11ea-9f7b-a6f204143cac.PNG)

![Снимок6](https://user-images.githubusercontent.com/31220669/77857225-eb386a00-7204-11ea-9a2e-7cd4511719e6.PNG)

After that you need to set webhook on your bot.Webhook its a system, who sending queries to your server, if telegram gets one.

Before start creating a webhook you need bot api token and server.If you dont have a server, you can use <a href="heroku.com">heroku</a> to create one.

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

<b id='utils_context'>Context</b>

Using class Context from Utils namespace you can create context dependence:

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

	if(!Context::read($bot, $InputHandle->getChatId())){ //reading context
		Inquiry::send($bot
				,'sendMessage',
			[
				'chat_id' => $InputHandle->getChatId(),
				'text' => 'Write smth'
			]
		);
		Context::write($bot, $InputHandle->getChatId(), 'smth'); //creating new context
	}else{
		Inquiry::send($bot
			,'sendMessage',
			[
			'chat_id' => $InputHandle->getChatId(),
			'text' => 'Okay, you writed!'
			]
		);
		Context::delete($bot, $InputHandle->getChatId()); //delete context
	}
```

![Снимок2](https://user-images.githubusercontent.com/31220669/77940072-cd303f80-72c0-11ea-837e-903d9c83020e.PNG)

<b id='utils_keyboard'>Creating Keyboard</b>

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

<h2 id = 'mysql_users'>Working with users in database</h2>

To add user to database, you need to use this function:

```php
	User::add($bot, $userId);
```

To delete user:

```php
	User::delete($bot, $userId);
```

To get user:

```php
	User::get($bot, $userId);
```

This function returns array with row information of this user(row id, chat id, bot token)

To get all users:

```php
	User::getAll($bot);
```
You can send message to all active users by using this function:

```php
	User::sendToAll($bot, $method, $data);
```
Data variable contains method parameters(for help see <a href='#sending_queries'>sending methods</a>)

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

This class has only one method - Inquiry::send().With this method you can send quiries who can contain messages, photos, videos etc.

```php
	Inquiry::send($bot, $method, $data);
```

This class, like all library, support all telegram bot api methods.
With this class you can send both simple text messages and complex answers.
Lets see some examples:

<b>Sending simple answer</b>

```php
	Inquiry::send($bot, 'sendMessage', [
		'chat_id' => $InputHandle->getChatId(),
		'text' => 'This is a testing message'
	
	]);
```

<b>Sending callback query answer</b>

```php
	Inquiry::send($bot, 'answerCallbackQuery', [
		'callback_query_id' => $InputHandle->getCallbackQueryId(),
		'text' => 'This is a callback answer, who lool like common notification'
	]);
```

<b>Sending Inline query answer</b>

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

<h2 id='input_handle'>Input Handle</h2>

This class needs for comfortable work with telegram answer query.

<b>Creating a new InputHandle object</b>

```php
	$InputHanle = new InputHandle();
```

<b>Working with data</b>

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

