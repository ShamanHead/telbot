<?php

/*
	Copyright© Arseniy Romanovskiy aka ShamanHead
	This file is part of Telbot package
	Created by ShamanHead
	Mail: arsenii.romanovskii85@gmail.com
*/

namespace Telbot;

class InputHandle{

	private $inputData;
	private $queryType;
	private $updateId;

	function __construct(){
		$inputData = json_decode(file_get_contents('php://input'));
		if(isset($inputData->message)){
			$this->inputData = $inputData->message;
			$this->queryType = 'message';
		}else if(isset($inputData->callback_query)){
			$this->inputData = $inputData->callback_query;
			$this->queryType = 'callback_query';
		}else if(isset($inputData->inline_query)){
			$this->inputData = $inputData->inline_query;
			$this->queryType = 'inline_query';
		}
		//$this->inputData->updateId = $inputData->update_id ?? false;
	}

	function __clone(){}

	public function getUpdateId(){
		return $this->inputData->updateId;
	}

	public function getQueryType(){
		return $this->queryType;
	}

	public function getInstance(){
		return $this->inputData;
	}

	public function getCallbackData(){
		if($this->queryType != 'callback_query') return false;
		return $this->inputData->data;
	}

	public function getCallBackQueryId(){
		if($this->queryType != 'callback_query') return false;
		return $this->inputData->id;
	}

	public function getUserId(){
		return $this->inputData->from->id;
	}

	public function userIsBot(){
		return $this->inputData->from->is_bot;
	}

	public function getUserName(){
		return $this->inputData->from->username;
	}

	public function getMessageId(){
		switch($this->queryType){
			case 'message':
				return $this->inputData->message_id;
			break;
			case 'callback_query':
				return $this->inputData->message->message_id;
			break;
			case 'inline_query':
				return false;
			break;
		}
	}

	public function getUserFirstName(){
		return $this->inputData->from->first_name;
	}

	public function getLanguageCode(){
		return $this->inputData->from->language_code;
	}

	public function getChatType(){
		switch($this->queryType){
			case 'message':
				return $this->inputData->chat->type;
			break;
			case 'callback_query':
				return $this->inputData->message->chat->type;
			break;
			case 'inline_query':
				return false;
			break;
		}
	}

	public function getChat(){
		switch($this->queryType){
			case 'message':
				return $this->inputData->chat;
			break;
			case 'callback_query':
				return $this->inputData->message->chat;
			break;
			case 'inline_query':
				return false;
			break;
		}
	}

	public function newChatMember(){
		if(isset($this->inputData->new_chat_member)){
			return $this->inputData->new_chat_member;
		}else{
			return false;
		}
	}

	public function getMessageText(){
		switch($this->queryType){
			case 'inline_query':
				return false;
				break;
			case 'callback_query':
				return $this->inputData->message->text;
				break;
			case 'message':
				return $this->inputData->text;
				break;
		}
	}

	public function getChatId(){
		switch($this->queryType){
			case 'inline_query':
				return false;
				break;
			case 'callback_query':
				return $this->inputData->message->chat->id;
				break;
			case 'message':
				return $this->inputData->chat->id;
		}
	}

	public function getDate(){
		return $this->inputData->date;
	}

	public function getEntities(){
		return isset($this->inputData->entities) ? $this->inputData->entities : false;
	}

	public function getChatTitle(){
		switch($this->queryType){
			case 'message':
				return $this->inputData->chat->title;
			break;
			case 'callback_query':
				return $this->inputData->message->chat->title;
			break;
			case 'inline_query':
				return false;
			break;
		}
	}

	public function getInlineQueryText(){
		if($this->queryType != 'inline_query') return false;
		return $this->inputData->query;
	}

	public function getInlineQueryOffset(){
		if($this->queryType != 'inline_query') return false;
		return $this->inputData->offset;
	}

	public function getInlineQueryId(){
		if($this->queryType != 'inline_query') return false;
		return $this->inputData->id;
	}

}

?>
