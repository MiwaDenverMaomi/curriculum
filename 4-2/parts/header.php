<?php

//ユーザー情報を変数に格納
if(!empty($userInfo)){
  $full_name='';
  if(!empty($userInfo['last_name']||!empty($userInfo['first_name']))){
  $full_name=$userInfo['last_name'].$userInfo['first_name'];
 }else{
  $full_name='名無し';
 }

 //最終ログイン日時を変数に格納
 if(!empty($userInfo['last_login'])){
  $last_login=$userInfo['last_login'];
 }else{
  $last_login='???';
 }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./style/css/style.css">
	<title><?php if(!empty($pageTitle)) echo $pageTitle;?></title>
</head>
<body>
<?php if(!empty($errMsg['common'])) {?>
	<p class="err"><?php echo $errMsg['common'];?></p>
<?php }?>
<header class="header">
	<div class="header__logo-container">
		<img src="./img/logo.png" class="header__logo">
	</div>
	<div class="header__info-container">
		<div class="header__user-info">
      <?php if(!empty($errMsg['username'])){?><p class="err"><?php echo $errMsg['username'];?></p><?php }?>
			<p class="header__text">ようこそ <?php if(!empty($full_name)) echo $full_name;?> さん</p>
		</div>
		<div class="header__login-date">
      <?php if(!empty($errMsg['last_login'])){?><p  class="err"><?php echo $errMsg['last_login'];?></p><?php }?>
			<p class="header__text">最終ログイン日：<?php if(!empty($last_login)) echo $last_login;?></p>
			</div>
	</div>
</header>
