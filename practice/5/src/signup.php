<?php
require "./functions/function.php";
require ("./functions/db_connect.php");
session_start();
debugLogStart();
if(!empty($_POST['signUp'])){
	//変数用意
	$errMsg=array();
	$message=array();
	$name=!empty($_POST['name'])?$_POST['name']:'';
	$password=!empty($_POST['password'])?$_POST['password']:'';

	//バリデーション
 //ユーザーネーム->字数制限、特殊文字、環境依存文字のチェック
	checkMaxLen('name',$name,50);
	checkSpecialChars('name',$name);
	checkEnvDepChars('name',$name);
//パスワード->字数制限、半角英数文字のチェック
	checkMinLen('password',$password);
	checkMaxLen('password',$password,50);
	checkSingleByteChars('password',$password);

	checkRequired('name',$name);
	checkRequired('password',$password);

	//バリデーションOKの場合
	if(empty($errMsg)){
		debug('バリデーションOKです');

		//DBにデータをインサートする
		try{
		//PDO生成
		$pdo=dbConnect();
		 $stmt=new stdClass();
		 $sql="INSERT INTO users (name,password) VALUES (:name,:password)";

		 $data=array([':name',$name,PDO::PARAM_STR],[':password',password_hash($password,PASSWORD_DEFAULT),PDO::PARAM_STR]);
		 $stmt=queryPost($pdo,$sql,$data);

		}catch(PDOException $e){
			debug($e->getMessage());
			$errMsg['common']=ERR_DB;
		}

		 if(!empty($stmt)){
			debug('登録成功/$stmt:'.print_r($stmt,true));
			$message['success']=SUC_SIGNUP;

			//セッション変数にユーザー情報などを格納する
			session_regenerate_id();
			$_SESSION['user_id']=$pdo->lastInsertId();
			$_SESSION['user_name']=$name;
			$_SESSION['login_date']=time();
			$_SESSION['login_limit']=60*60;

			header("Location:main.php");

		 }else{
			debug('登録失敗');
			$errMsg['common']=FAIL_SIGNUP;
		 }
	}
}
?>
<!DOCTYPE html>
<html>
<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
		<h1>新規登録</h1>
		<form method="POST" action="">
			<p><?php if(!empty($errMsg['common'])){
				echo $errMsg['common'];
			}else if(!empty($message['success'])){
				echo $message['success'];
			}?></p>
				user:<?php if(!empty($errMsg['name'])) {?><span><?php echo $errMsg['name'];?></span><?php }?><br>
				<input type="text" name="name" id="name">
				<br>
				password:<?php if(!empty($errMsg['password'])) {?><span><?php echo $errMsg['password'];?></span><?php }?><br>
				<input type="password" name="password" id="password"><br>
				<input type="submit" value="submit" id="signUp" name="signUp">
		</form>
</body>
</html>
