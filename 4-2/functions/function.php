<?php

ini_set('log_errors','On');
ini_set('error_log','./logs/debug.log');
$debug_flg=true;
$errMsg=array();

//定型文
define('ERR_DATABASE','データベースエラーです。しばらくしてからやりなおしてください。');
define('ERR_GET_USERNAME','名前情報を取得できませんでした。');
define('ERR_GET_LOGINDATE','最終ログイン日時を取得できませんでした。');
define('ERR_GET_POSTS','記事一覧を取得できませんでした。');

//デバッグ関数
function debug($str){
  global $debug_flg;
  if($debug_flg===true){
    error_log($str);
  }
}

//カテゴリNOをカテゴリ名に変換
function catNoToCatName($str){
  $category_name='';
  $str=(int)$str;
  switch($str){
    case 1:
     $category_name="食事";
     break;
    case 2:
     $category_name="旅行";
     break;
    default:
     $category_name="その他";
     break;
  }
  return $category_name;
}
