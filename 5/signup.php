<?php $title='ユーザー登録画面';

require_once('./functions/functions.php');
require_once('./parts/header.php');

debug('XXXXXXXXXXXXXXXXXXXXXXXXXXx');
debug('ユーザー登録画面');
debug('XXXXXXXXXXXXXXXXXXXXXXXXXXx');

if(!empty($_POST['submit'])){
	debug('POST送信あり');
	$name=!empty($_POST['name'])?$_POST['name']:'';
	$password=!empty($_POST['password'])?$_POST['password']:'';

	//バリデーション
	validMaxLen('name',$name);
	validSpecialChars('name',$name);
	checkIfNameExists('name',$name);

	validAlphaNum('password',$password);
	validMaxLen('password',$password);

	validRequired('name',$name);
	validRequired('password',$password);

	if(empty($errMsg)){
		debug('エラーありません');
		$result=null;
		$pdo=db_connect();
		$sql="INSERT INTO users (name,password) VALUES (:name,:password)";
		$hashed_password=password_hash($password,PASSWORD_DEFAULT);
		$data=array([':name',htmlSpecialChars($name),PDO::PARAM_STR],[':password',$hashed_password,PDO::PARAM_STR]);
    $stmt=queryPost($pdo,$sql,$data);
		if($stmt->rowCount()){
			debug('会員登録成功');
			//セッション再生成
			session_regenerate_id();

			//セッションに情報格納
			$_SESSION['login_date']=time();
			$_SESSION['login_limit']=60*60;
			$_SESSION['user_id']=$pdo->lastInsertId();
			$_SESSION['name']=$name;

      session_flash('success',SUC_REGISTER_USER);
			Header('Location:message.php');
			exit;
		}

	}

}

?>
	<div class="container col-md-4 col-xs-10 mx-auto py-4">
		 <h2 class="h3 mb-4"><?php echo $title;?></h2>
		 <?php if(!empty($errMsg['common'])){?><p class="text-danger"><?php echo $errMsg['common'];?></p><?php }?>
		<form class="form-signin mb-3" method="post" action="">
			  <?php if(!empty($errMsg['name'])){?><p class="text-danger"><?php echo $errMsg['name'];?></p><?php }?>
				<input type="text" id="inputEmail" class="form-control mb-4" name="name"placeholder="ユーザー名">
		  	<?php if(!empty($errMsg['password'])){?><p class="text-danger"><?php echo $errMsg['password'];?></p><?php }?>
				<input type="password" id="inputPassword" class="form-control mb-4" name="password" placeholder="パスワード">
			<button class="btn btn-primary" type="submit" name="submit" value="submit">新規登録</button>
		</form>
		<a href="./login.php">>ログインページへ</a>
	</div>
<?php
require_once('./parts/footer.php');
?>
