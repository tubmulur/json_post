<?php
class Page{
	private $d;
	public function __construct($d=
			[
			'head'=>
				[
				'meta'	=>'<meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>',
				'js'	=>'<script type="text/javascript" src="/js/main.js"/></script>',
				'style'	=>'<link rel="stylesheet" href="/css/main.css"/>',
				'title'	=>'<title>Тестовая страница</title>'
				],
			'body'=>'body',
			'footer'=>'footer'
			]
		)
		{
		$this ->d=$d;
		$this->header();
		$this->view = $this->view();
		}
	private function header()
		{
//		header('Content-Type:text/html; charset=UTF-8');
		return $this->isRequest?"":"<!DOCTYPE HTML>";
		}
	private function head($head)
		{
		return empty($head)?"":"<head>".$head['meta']."".$head['js']."".$head['style']."".$head['title']."</head>";
		}
	private function body($body)
		{
		return empty($body)?"":"<body>$body</body>";
		}
		private function footer($footer)
		{
		return empty($footer)?"":"<footer>$footer</footer>";
		}
	private  function view()
		{
		return  $this->head($this->d['head']).$this->body($this->d['body']).$this->footer($this->d['footer']);
		}
	public  function show()
		{
		$Request = new Request;
		if($Request->isPost)
			{
//			$post=$Request->isPost;
//			$post['action']='select';
//			print_r($post);
			$db = new Database($Request->isPost);
			echo json_encode($db->result);
			}
		else
			{
			echo $this->view;
			}
		}
	static function obj($d=array())
		{
		return new Page($d);
		}
}
?>