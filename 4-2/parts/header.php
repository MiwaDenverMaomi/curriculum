<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./style/css/style.css">
	<title><?php if(!empty($pageTite)) echo $pageTitle;?></title>
</head>
<body>
<header class="header">
	<div class="header__logo-container">
		<img src="./img/logo.png" class="header__logo">
	</div>
	<div class="header__info-container">
		<div class="header__user-info">
			<p class="header__text">ようこそ XXX さん</p>
		</div>
		<div class="header__login-date">
			<p class="header__text">最終ログイン日：YYYYYYYY</p>
			</div>
	</div>
</header>
