<?php
define('DB_DATABASE','yigroupBlog');
define('DB_USERNAME','root');
define('DB_PASSWORD','root');
define('PDO_DSN','mysql:host=localhost;charaset=utf8;dbname='.DB_DATABASE);

/**
 * DBの接続設定をしたPDOインスタンスを返却する
 * @return object
 */
function db_connect(){
	try{
	// PDOインスタンスの作成
	$dbh=new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
	// エラー処理方法の設定(PDO使用時は必ず書く。MUST)
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	echo 'DBと接続しました';
	return $pdo;

}catch(PDOException $e){
	echo 'Error:'.$e->getMessage();
	die();
}
}

?>
