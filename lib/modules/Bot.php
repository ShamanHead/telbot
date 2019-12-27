<?php
/**********************************************************
*							  *
*	Copyright© Arseniy Romanovskiy aka ShamanHead     *
*	This file is part of Telbot package		  *
*	Created by ShamanHead				  *
*	Mail: arsenii.romanovskii85@gmail.com	     	  *
*							  *
**********************************************************/
namespace Telbot;

class Bot {
	private $token = 0;
	private $standartChatId = 0;
	public $sqlConnectionPosibility = false;
	public $pdoConnection;

	function __construct($token) {
		$this->token = $token;
	}

	public function getToken() : string{
		return $this->token;
	}

	public function enableSql() : void{
		$this->sqlConnectionPosibility = true;
	}

	public function disableSql() : void{
		$this->sqlConnectionPosibility = false;
	}

	public function sqlCredentials($credentials) : void{
		try{
		$this->pdoConnection = new \PDO('mysql:host='.$credentials['database_server'].';dbname='.$credentials['database_name'], $credentials['username'], $credentials['password']);
		}catch(PDOException $e){
			$e->getMessage();
		}
	}

	public function externalPDO(\PDO $pdo) : void {
		$this->pdoConnection = $pdo;
	}

}

?>
