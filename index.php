<?php  

	require_once('LoginController.class.php');
	$controller = new LoginController();
	$controller->init();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/pc_style.css" media="screen and (min-width:769px)">
	<link rel="stylesheet" type="text/css" href="css/sp_style.css" media="screen and (max-width:768px)">
	<title>ログイン | PHPの勉強</title>
</head>
<body>
	<header class="header">
		<div class="container">
			<h1>ログイン</h1>
		</div>
	</header>
	<div class="main">
		<div class="container">
			<div class="panel panel-center panel-green">
				<div class="panel__head panel__head-center">
					ログインしよう
				</div>
				<div class="panel__body">
					<form action="/?action=login" method="post">
						<div class="panel__columns panel__columns-2">
							<div class="panel__column">
								ユーザ名
							</div>
							<div class="panel__column">
								<input class="input <?php if ($controller->isLoginAction()) echo $controller->username->hasError() ? 'input-error' : ''; ?>" type="text" name="username" value="<?php if ($controller->isLoginAction()) echo $controller->username; ?>">
								<?php 
									if ($controller->isLoginAction()) {
										foreach ($controller->username->getErrorMessages() as $errorMessage) {
								?>
								<span class="error_message"><?php echo $errorMessage; ?></span>
								<?php
										}
									}
								?>
							</div>
						</div>
						<div class="panel__columns panel__columns-2">
							<div class="panel__column">
								パスワード
							</div>
							<div class="panel__column">
								<input class="input <?php if ($controller->isLoginAction()) echo $controller->password->hasError() ? 'input-error' : ''; ?>" type="password" name="password" value="<?php echo $controller->password; ?>">
								<?php if ($controller->isLoginAction()) { foreach ($controller->password->getErrorMessages() as $errorMessage) { ?>
								<span class="error_message"><?php echo $errorMessage; ?></span>
								<?php } } ?>
							</div>
						</div>
						<div class="panel__columns panel__columns-1">
							<div class="panel__column panel__column-center">
								<button class="button button-red" type="submit">ログイン</button>
								<button class="button" type="reset">クリア</button>
							</div>
						</div>
					</form>
				</div> 
			</div>
		</div>
	</div>
	<footer class="footer">
		<div class="container">
			
		</div>
	</footer>
</body>

</html>