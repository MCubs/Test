<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
	<title><?=(isset($data['title']) ? $data['title'] : 'Главная')?></title>
	<link href="/template/css/style.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="/template/js/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="/template/js/scripts.js"></script>
</head>

<body>

<div id="header">
</div>

<div id="container">
	<div id="sidebar">
		
	</div>

	<div id="content">
		<?php require VIEW_PATH .'/'. $content; ?>
	</div>
</div>

<div id="footer"></div>


</body></html>