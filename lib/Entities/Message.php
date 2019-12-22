<?php
/**********************************************************
*							  *
*	Copyright© Arseniy Romanovskiy aka ShamanHead     *
*	This file is part of Telbot package		  *
*	Created by ShamanHead				  *
*	Mail: arsenii.romanovskii85@gmail.com	     	  *
*							  *
**********************************************************/

class Message extends Entity{
	
	private $data = []; 

	private function searchInData($whatToSearch){
		for($i = 0;$i < count($data);$i++){
			if($whatToSearch == $data[$i]){
				return true;
			}
		}
		return false;
	}

	public function text($someText) : void{
		$this->data['text'] = $someText;
	}

	public function picture($file) : void {
		
	}

}

?>