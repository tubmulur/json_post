<?php
spl_autoload_register
	(
	function($class_name)
		{
		include dirname($_SERVER['SCRIPT_FILENAME']).'/object/'.$class_name.'.php';
		}
	);

include dirname($_SERVER['SCRIPT_FILENAME']).'/config/RCe.php';


$page = Page::obj(
	[
	// 'request'=>'',///
	'head'=>[
		'meta'	=>'<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>',
		'js'	=>'<script type="text/javascript" src="js/main.js"></script>',
		'style'	=>'<link rel="stylesheet" href="css/main.css"/>',
		'title'	=>'<title>Тестовая страница</title>',
		],
	'body'=>Form::obj()->view,
	'footer'=>'<hr/>(c) 2016 tubmulur@yandex.ru'
	]
)->show();

?>