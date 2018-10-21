<?php 
session_start();
echo "ログイン中です";
var_dump($_SESSION);
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/pc_style.css" media="screen and (min-width:769px)">
	<link rel="stylesheet" type="text/css" href="css/sp_style.css" media="screen and (max-width:768px)">
	<title>ログアウト</title>
</head>
<body>
	<form action="/action=logout" method="post" accept-charset="utf-8">
		<button type="submit" class="button button-red">ログアウト</button>
	</form>
</body>
</html>