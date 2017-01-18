<?php
class Url extends RCe{
	public $view;
	public function __construct()
		{
		$this->view=$this->method();
		}
	private function method()
		{
		return $url=mb_ereg_replace(RCe::prefix(),'',$_SERVER['REQUEST_URI']);
		}
	static function obj()
		{
		return new Url();
		}
}
?>