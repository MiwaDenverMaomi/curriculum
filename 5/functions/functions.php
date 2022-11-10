<?php

ini_set('log_errors','On');
ini_set('error_log',__DIR__.'/../log/debug.log');
date_default_timezone_set("Asia/Tokyo");

//セッションスタート
session_start();
//なりすまし防止のためセッション再生成
session_regenerate_id();

//セッションフラッシュメッセージ
function session_flash($name,$str){
  $_SESSION[$name]=$str;
}
//エラーメッセージ用変数用意
$errMsg=array();

//デバッグ
function debug(string $str){
  error_log($str);
}

//各ページでセッションやユーザーIDの確認をする
function debugLogStart(){
  debug('セッション中身');
  debug(print_r($_SESSION,true));
}

//定数
define('DB_ERR','DBエラーです。しばらくしてからやり直してください。');
define('INPUT_REQUIRED','入力してください。');
define('INPUT_VALID_EMAIL','有効なEmailアドレスを入力してください。');
define('INPUT_ALPH_NUM','半角英数で入力してください。');
define('NO_SPECIAL_CHARS','<,>,&,"は使用しないでください。');
define('NO_ENV_DEP_CHARS','環境依存文字は使用しないでください。');
define('INPUT_NUMBER_LESS_THAN_999','999までの数字を入力してください。');
define('INPUT_VALID_DATE','有効な日付(YYYY/MM/DD)を入力してください。');
define('REGISTER_FAILED','本の登録が失敗しました。');
define('NAME_ALREADY_USED','この名前は既に使用されています。');
define('LOGIN_INFO_WRONG','名前またはパスワードが間違っています');
define('SUC_LOGGED_OUT','ログアウトしました。');
define('SUC_REGISTER_USER','会員登録成功しました。');

//DB接続エラーメッセージ表示
function show_err_db($e){
  global $errMsg;
    debug('エラー：'.$e->getMessage());
    global $errMsg;
    $errMsg['common']=$str;
}

//DB接続
function db_connect(){
  $pdo=null;
  $db=[
    'dbname'=>'shelf',
    'host'=>'localhost',
    'user'=>'root',
    'pass'=>'root'
  ];
  $dsn=sprintf('mysql:host=%s;dbname=%s;',$db['host'],$db['dbname']);
  $options=array(
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
  );
  try{
     $pdo=new PDO($dsn,$db['user'],$db['pass'],$options);
  }catch(PDOException $e){
    show_err_db($e);
    die();
  }
  return $pdo;
}

//クエリ実行
function queryPost($pdo,$sql,$data=null){
  debug('queryPost');
  $stmt=$pdo->prepare($sql);
  debug(print_r($stmt,true));

  try{
    if(!empty($data)){
       foreach($data as $item){
       $stmt->bindValue(...$item);
     }
    }
   $stmt->execute();

  }catch(PDOException $e){
    show_err_db($e);
  }
  return $stmt;
}

//GETでのパラメータが空の場合強制的にメインページに飛ばす
function redirect_main_unless_parameter($id){
  if(empty($id)){
  debug('メインページに飛ばす');
  header('Location:main.php');
  exit;
  }
}
//すべての本データ取得
function getAllBooks(){
  debug('getAllBooks');
  $books=null;
  $pdo=db_connect();
  try{
    $sql="SELECT `id`,`title`,`date`,`stock` FROM books ORDER BY id DESC";
    $stmt=queryPost($pdo,$sql);

  }catch(PDOException $e){
    show_err_db($e);
    die();
  }
  $books=$stmt->fetchAll();
  debug(print_r($books,true));
  return $books;
}

//本を新規登録
function registerBook($pdo,$sql,$data){
  $result=null;
    //データ挿入
    $pdo=db_connect();
  try{
    $stmt=queryPost($pdo,$sql,$data);
    $result=$stmt->rowCount();
  }catch(PDOException $e){
    show_err_db($e);
    die();
  }

  return $result;
}

function deleteBook($book_id){
  $result=null;
  try{
    $pdo=db_connect();
    $sql="DELETE FROM books WHERE id=:id";
    $data=array([':id',$book_id,PDO::PARAM_INT]);
    $stmt=queryPost($pdo,$sql,$data);
    $result=$stmt->rowCount();
  }catch(PDOException $e){
    show_err_db($e);
  }
  return $result;
}

//登録された名前が既にあるかチェック
function checkIfNameExists($name,$str){
  $pdo=db_connect();
  try{
    $sql="SELECT * FROM users WHERE name=:name";
    $data=array([':name',$str,PDO::PARAM_STR]);
    $stmt=queryPost($pdo,$sql,$data);
  }catch(PDOException $e){
    show_err_db($e);
  }

  if(!empty($stmt->rowCount())){
    debug('名前重複');
    global $errMsg;
    $errMsg[$name]=NAME_ALREADY_USED;
  }

}

//バリデーション
function validRequired($name,$str){
  if(trim($str)===''){
    global $errMsg;
    $errMsg[$name]=INPUT_REQUIRED;
  }
}
//最大文字数チェック
function validMaxLen($name,$str,$num=255){
  if(mb_strlen($str)>255){
    global $errMsg;
    $errMsg[$name]=sprintif('%n以下の文字数で入力してください。',$num);
  }
}
//最小文字数チェック
function validMinLen($name,$str,$num=8){
  if(mb_strlen($str)>8){
    global $errMsg;
    $errMsg[$name]=sprintif('%n以上の文字数で入力してください。',$num);
  }
}

//半角英数チェック

function validAlphaNum($name,$str){
   if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
  global $errMsg;
  $errMsg[$name]=INPUT_ALPH_NUM;
 }
}
//Emailチェック
function validEmail($name,$str){
  	if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9]\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$str)){
		 global $errMsg;
		 $errMsg[$name]=INPUT_VALID_EMAIL;
	}
}

//日付チェック
function validDate($name,$date){
  if(!preg_match('/^([1-9][0-9]{3})\/(0[1-9]{1}|1[0-2]{1})\/(0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})$/',$date)){
    global $errMsg;
    $errMsg[$name]=INPUT_VALID_DATE;
  }
}

//数字と桁数チェック
function validNum($name,$num,$digit=3){
  $regex='/^([0-9]{'.$digit.'})$/';
  if(preg_match($regex,$num)){
    global $errMsg;
    $errMsg[$name]=INPUT_NUMBER_LESS_THAN_999;
  }
}


//有害文字はじく
function validSpecialChars($name,$str){
  debug('function/checkSpectialChars');

  if(preg_match('/[<>&"]/',$str)){
    global $errMsg;
    $errMsg[$name]=NO_SPECIAL_CHARS;
  }
}

//環境依存文字はじく->機能せず
function validEnvDepChars($name,$str){
  debug('function/checkEnvDepChars');

$envDepChars="/[№㏍℡㊤㊥㊦㊧㊨㈱㈲㈹㍾㍽㍼㍻㍉㎜㎝㎞㎎㎏㏄㍉㌔㌢㍍㌘㌧㌃㌶㍑㍗㌍㌦㌣㌫ ㍊㌻①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳ⅠⅡⅢⅣⅤⅥⅦⅧⅨⅩ①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳ⅠⅡⅢⅣⅤ≡∑∫∮√
⊥∠∟⊿∵∩∪・纊鍈蓜炻棈兊夋奛奣寬﨑嵂]/";

if(preg_match($envDepChars,$str)){
  global $errMsg;
  $errMsg[$name]=NO_ENV_DEP_CHARS;
}
}
