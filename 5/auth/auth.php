<?php

if(!empty($_SESSION)){
debug('セッション中身あり');

if(!empty($_SESSION['user_id'])){
  //セッションの中にログイン情報がある場合
  if(!empty($_SESSION['login_date'])&&($_SESSION['login_date']+$_SESSION['login_limit'])>time()){
      debug('ログイン中（ログイン有効期限内）です');
      //セッション情報更新
      session_regenerate_id();
      $_SESSION['login_date']=time();
      $_SESSION['login_limit']=60*60;

      //ログイン中にログインページアクセスした場合は、メインページにリダイレクト
      if(basename($_SERVER['PHP_SELF'])==='login.php'){
        header('Location:main.php');
        exit;
      }

  }else{
      debug('ログイン有効期限がきれています');
      session_destroy();
      header('Location:login.php');
      exit;
  }
}

}else{
  debug('セッションが空です。');
  header('Location:login.php');
  exit;
}
