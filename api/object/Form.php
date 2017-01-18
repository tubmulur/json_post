<?php
class Form{
	private $d;
	public function __construct($d){
		$this->d['id']	=empty((int)$_GET['id'])?"":(int)$_GET['id'];
		$this->d['sessionId']	=empty((int)$_GET['sessionId'])?"":(int)$_GET['sessionId'];
		if(Url::obj()->view=='Table')
			{
			$this->view	=$this->table();
			}
		elseif(Url::obj()->view=='SessionSubscribe')
			{
			$this->view	=$this->sessionSubscribe();
			}
		elseif(Url::obj()->view=='PostNews')
			{
			$this->view	=$this->postNews();
			}
		else
			{
			$this->view="form not found";
			}
		
	}
	private function table(){
		return '<div class="rce-w-80 block center">
				<form action="'.RCe::prefix().'Table" method="POST">
					<div class="block rce-m-5">
						<span class="rce-w-10 block left text-left">
							Таблица:
						</span>
						<span class="rce-w-20 block text-left">
							<select name="table" id="form-table__input">
								<option value="News">News</option>
								<option value="Session">Session</option>
							</select>
						</span>
					</div>
					<div class="block rce-m-5">
						<span class="rce-w-10 block left text-left">
							Id: 
						</span>
						<span class="rce-w-20 block text-left">
							<input type="text" name="id" id="form-id_input" maxlength="100" pattern="'.RCe::obj()->regex['id'].'" size="6" value="'.$this->d['id'].'"/>
						<span>
					</div>
					<div class="block rce-m-5">
						<button class="rce-w-20 block text-left">Отправить запрос</button>
					</div>
				</form>
			</div>';
	}
	private function sessionSubscribe(){
		return '<div class="rce-w-80 block center">
				<form action="'.RCe::prefix().'SessionSubscribe" method="POST">
					<div class="block rce-m-5">
						<span class="rce-w-10 block left text-left">
							SessionId: 
						</span>
						<span class="rce-w-20 block text-left">
							<select name="sessionId" id="form-sessionId_input">
								<option value="1">1</option>
								<option value="2">2</option>
							</select>
							
						<span>
					</div>

					<div class="block rce-m-5">
						<span class="rce-w-10 block left text-left">
							Email: 
						</span>
						<span class="rce-w-20 block text-left">
							<input type="email" name="userEmail" id="form-userEmail_input" maxlength="100" pattern="'.RCe::obj()->regex['email'].'"  size="15" value="'.$this->d['userEmail'].'"/>
						<span>
					</div>
					<div class="block rce-m-5">
						<button class="rce-w-20 block text-left">Отправить запрос</button>
					</div>
				</form>
			</div>';
	}
	private function postNews(){
		return '<div class="rce-w-80 block center">
				<form action="'.RCe::prefix().'PostNews" method="POST">
					<div class="block rce-m-5">						<span class="rce-w-10 block left text-left">
							UserEmail: 
						</span>
						<span class="rce-w-20 block text-left">
							<input type="email" name="userEmail" id="form-userEmail_input" maxlength="100"  size=15" value="'.$this->d['userEmail'].'"/>
						<span>
					</div>

					<div class="block rce-m-5">
						<span class="rce-w-10 block left text-left">
							NewsTitle: 
						</span>
						<span class="rce-w-20 block text-left">
							<input type="text" name="newsTitle" id="form-newsTitle_input" maxlength="100"   size="15" value="'.$this->d['newsTitle'].'"/>
						<span>
					</div>
					<div class="block rce-m-5">
						<span class="rce-w-10 block left text-left">
							NewsMessage: 
						</span>
						<span class="rce-w-20 block text-left">
							<textarea name="newsMessage" id="form-newsMessage_input" rows="8" cols="13">'.$this->d['newsMessage'].'</textarea>
						<span>
					</div>
					<div class="block rce-m-5">
						<button class="rce-w-20 block text-left">Отправить запрос</button>
					</div>
				</form>
			</div>';
	}
	static function obj($d=array())
		{
		return new Form($d);
		}
}
?>