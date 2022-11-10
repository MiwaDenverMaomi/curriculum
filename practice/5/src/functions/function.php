<?php
//ログ設定----------------------------------------------
ini_set('log_errors','On');
error_reporting(E_ALL & ~E_NOTICE);
ini_set('error_log', __DIR__.'/../logs/debug.log');

//---セッション準備-------------------------------------------
//セッションファイルの置き場所変更（30日間削除されないようにする）
// session_save_path("/var/tmp/");->うまくいかなかったのでphp.iniを修正
//ガーベージコレクションが削除するセッションの有効期限を設定
ini_set('session.gc_maxlifetime', 60*60*24*30);
//クッキー自体の有効期限を延ばす
ini_set('session.cookie_lifetime ', 60*60*24*30);
//セッションを使う
session_start();
//なりすまし防止のためセッションを再度生成
session_regenerate_id();
//-----------------------------------------------------------
$errMsg=array();
$debugFlg=true;

function debug($str){
  global $debugFlg;
  if($debugFlg===true){
    error_log('debug:'.$str);
  }
}

function debugLogStart(){
  debug('>>>>>>>>>>>>>>>>>>>>>>>>');
	debug('セッションID: '.session_id());
	debug('セッション変数中身: '.print_r($_SESSION,true));
	debug('現在のタイムスタンプ: '.time());
  debug('>>>>>>>>>>>>>>>>>>>>>>>>');
}
//defines
define('ERR_DB','データベースエラーです。しばらくしてからやりなおしてください。');
define('ERR_REQUIRED','未入力です。');
define('ERR_SPECIAL_CHARS','特殊文字"<",">","&"は使用しないでください。');
define('ERR_ENV_DEP_CHARS','環境依存文字は使用しないでくさい。');
define('ERR_SINGLE_BYTE','半角英数で入力してください。');
define('SUC_SIGNUP','登録完了しました。');
define('FAIL_SIGNUP','登録失敗しました。しばらくしてからやりなおしてください。');
define('FAIL_NAME_PASS','ユーザー名かパスワードに誤りがあります。');
define('NO_DATA_FETCHED','対象のデータがありません');


// function dbConnect(){
// debug('function/dbConnect()');
//  $db['host']='localhost';
//  $db['dbname']='yigroupblog';
//  $db['user']='root';
//  $db['password']='root';
//  $dsn=sprintf('mysql:host=%s;dbname=%s;',$db['host'],$db['dbname']);

//   $options=array(
//   PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
//   PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
//  );
//   $pdo=null;

//  try{
//   $pdo=new PDO($dsn,$db['user'],$db['password'],$options);

//  }catch(PDOException $e){
//   debug($e->getMessage());
//   global $errMsg;
//   $errMsg['common']=ERR_DB;
//  }
//  debug('$pdo:'.print_r($pdo,true));
//  return $pdo;
// }

function queryPost($pdo,$sql,$data){
  debug('function/queryPost');
  $stmt=$pdo->prepare($sql);
  debug('$sql:'.$sql);
if(!empty($data)){
  foreach($data as $val){
    debug('bindValue');
    $stmt->bindValue($val[0],$val[1],$val[2]);
  }
  debug('$data'.print_r($data,true));
}
  $stmt->execute();

  return $stmt;
}

function find_post_by_id($id){
  debug('find_post_by_id');
  global $errMsg;
  $row=null;
  $pdo=dbConnect();
  if(!empty($id)){
    debug('idは空ではない');
    try{
      $sql="SELECT * FROM posts WHERE id=:id";
      $data=array([':id',$id,PDO::PARAM_INT]);
      $stmt=queryPost($pdo,$sql,$data);
      $row=$stmt->fetch();
    }catch(PDOException $e){
      debug('エラー：'.$e->getMessage());
      $errMsg['common']=ERR_DB;
    }
}
return $row;
}

//validation
function checkRequired($key,$str){
  debug('function/checkRequired');
  if(empty($str)||empty(trim($str))){
    debug("${key}が未入力です");
    global $errMsg;
    $errMsg[$key]=ERR_REQUIRED;
  }
}

function checkMinLen($key,$str,$min=8){
  debug('function/checkMinLen');

  if(mb_strlen(trim($str))<$min){
    global $errMsg;
    $errMsg[$key]="${min}文字以上入力してください。";
  }
}

function checkMaxLen($key,$str,$max=255){
  debug('function/checkMaxLen');

  if(mb_strlen(trim($str))>$max){
    global $errMsg;
    $errMsg[$key]="${max}文字以下を入力してください。";
  }
}

function checkSpecialChars($key,$str){
  debug('function/checkSpectialChars');

  if(preg_match('/[<>&"]/',$str)){
    global $errMsg;
    $errMsg[$key]=ERR_SPECIAL_CHARS;
  }
}

function checkEnvDepChars($key,$str){
  debug('function/checkEnvDepChars');

$envDepChars="/[№㏍℡㊤㊥㊦㊧㊨㈱㈲㈹㍾㍽㍼㍻㍉㎜㎝㎞㎎㎏㏄㍉㌔㌢㍍㌘㌧㌃㌶㍑㍗㌍㌦㌣㌫ ㍊㌻①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳ⅠⅡⅢⅣⅤⅥⅦⅧⅨⅩ①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳ⅠⅡⅢⅣⅤ≡∑∫∮√
⊥∠∟⊿∵∩∪・纊鍈蓜炻棈兊夋奛奣寬﨑嵂]/";

if(preg_match($envDepChars,$str)){
  global $errMsg;
  $errMsg[$key]=ERR_ENV_DEP_CHARS;
}
}

function checkSingleByteChars($key,$str){
  debug('function/checkSingleByteChars');

 if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
  global $errMsg;
  $errMsg[$key]=ERR_SINGLE_BYTE;
 }
}

function checkSame($str1,$str2){
  debug('function/checkSame');

  if($str1===$str2){
    return true;
  }
  return false;
}
function replaceSpacialChars($str){
  if(!empty($str)){
    $result='';
    $result=preg_quote($str,'/');
  }
  return $result;
}
/**
 * 引数の値が空だった場合、main.phpにリダイレクトする
 * @param integer $param
 * @return void
 */
function redirect_main_unless_parameter($param){
if(empty($param)){
  header("Location:main.php");
  exit;
}
}
