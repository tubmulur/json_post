<?php
class RCe{
	private $db;
	private $prefix;

	public	$page;
	public	$regex;
	public function __construct()
		{
		$this->prefix="/api/";// Папка в которой лежит проект в site_root,  к примеру у меня проект лежал в папке /var/www/test_site/api/
		$this->db=[
			'database'=>'radiorecord',
			'host'=>'localhost',
			'user'=>'radiorecord',
			'password'=>'assminog2008',
			];
		$this->page=[
			"name"=>'test project',
			"title"=>'<title>Тестовая страница</title>',
			"meta"=>[
				'<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>',
				],
			"css"=>[
				'<link rel="stylesheet" href="css/main.css"/>',
				],
			"js"=>	[
				'<script type="text/javascript" src="js/main.js"></script>',
				],
			"title"=>'<title>Тестовая страница</title>',
			];
		$this->regex=[
				'email'=>'^[A-Za-z0-9\._\-\@]+$',
				'action'=>'^[A-Za-z]+$',
				'id'=>'^[0-9]+$'
			];
		}
	static function encode($data)
		{
		return urlencode($data);
		}
	static function decode($data)
		{
		return urldecode($data);
		}
	static function db()
		{
		$obj=new RCe;
		return $obj->db;
		}
	static function page()
		{
		$obj=new RCe;
		return $obj->page;
		}
	static function prefix()
		{
		$obj=new RCe;
		return $obj->prefix;
		}
	static function obj()
		{
		$obj=new RCe;
		return $obj;
		}

}

?>