<?php
class Request{
	/*private $result =
		[
		"status"=>"error",
		"payload"=>[],
		"message"=>""
		];*/
	public function __construct()
		{
		$this->url=new Url;
		$this->isGet=$this->isGet();
		$this->isPost=$this->isPost();
		}
	protected function isPost()
		{
		if(!empty($_POST))
			{
			//echo $this->url->view;
			switch($this->url->view)
				{
				case 'Table':
					$_POST['action']='Table';
				break;
				case 'SessionSubscribe':
					$_POST['action']='SessionSubscribe';
				break;
				case 'PostNews':
					$_POST['action']='PostNews';
				break;
				}
			
			return $_POST;
			}
		else
			{
			return false;
			}
		}
	protected function isGet()
		{
		if(isset($_GET))
			{
			return $_GET;
			}
		else
			{
			return false;
			}
		}
	private function table()
		{
		}
}
?>