<?php

//もしもユーザーがログインしている場合
if(!empty($_SESSION['login_date'])){
  debug('ユーザー名:'.$_SESSION['user_name']);
  debug('ユーザーID:'.$_SESSION['user_id']);
  debug('ログイン済みです');

 if(($_SESSION['login_date']+$_SESSION['login_limit'])>time()){
  //現在日時がログイン有効期限以内の場合
  debug('ログイン有効期限内です');
  $_SESSION['login_date']=time();

  if(basename($_SERVER['PHP_SELF'])==='login.php'){
    debug('メインページに移動します。');
    header("Location:main.php");
    exit;
  }

 }else{
//ログイン有効期限がオーバーしている場合
    session_destroy();
    debug('ログインページに移動します。');
    header("Location:login.php");
    exit;
 }

}else{
//ログインしていない場合
debug('ログインしていません');
if(basename($_SERVER['PHP_SELF'])!=='login.php'){
//ログインページへ移動
debug('ログインページに移動します');
header("Location:login.php");
exit;
}
}
