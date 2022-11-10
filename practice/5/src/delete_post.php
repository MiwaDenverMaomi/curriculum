<?php
// db_connect.phpの読み込み
// function.phpの読み込み
require_once('./functions/function.php');
require_once('./functions/db_connect.php');
debug('================================');
debug('記事削除');
debug('================================');

debugLogStart();
// ログインしていなければ、login.phpにリダイレクト
require_once('./functions/auth.php');

// URLの?以降で渡されるIDをキャッチ
// もし、$idが空であったらmain.phpにリダイレクト
// 不正なアクセス対策
redirect_main_unless_parameter($_GET['id']);

$id = $_GET['id'];


// PDOのインスタンスを取得
$pdo=dbConnect();

try {
    $sql="DELETE FROM posts WHERE id=:id";
    $data=array([':id',$id,PDO::PARAM_STR]);
    $stmt=queryPost($pdo,$sql,$data);

    header("Location: main.php");
    exit;
} catch (PDOException $e) {
    debug('エラー:'.$e->getMessage());
    $errMsg['common']=ERR_DB;
}
