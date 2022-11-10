<?php $title='ログイン画面';
require_once('./functions/functions.php');
require_once('./parts/header.php');

debug('XXXXXXXXXXXXXXXXXXXXXXXXXXx');
debug('ログイン画面');
debug('XXXXXXXXXXXXXXXXXXXXXXXXXXx');
debugLogStart();

if(!empty($_POST['submit'])){
	debug('POST送信ありました');
	$name=!empty($_POST['name'])?$_POST['name']:'';
	$password=!empty($_POST['password'])?$_POST['password']:'';

	//バリデーション
	validMaxLen('name',$name);
	validSpecialChars('name',$name);

	validAlphaNum('password',$password);
	validMaxLen('password',$password);

	validRequired('name',$name);
	validRequired('password',$password);

	if(empty($errMsg)){
		$pdo=db_connect();
		$sql="SELECT * FROM users WHERE name=:name";
		$data=array([':name',$name,PDO::PARAM_STR]);
		$stmt=queryPost($pdo,$sql,$data);
		$result=$stmt->rowCount();
		if(!empty($result)){
			$row=$stmt->fetch();
			$old_password=$row['password'];
			if(password_verify($password,$old_password)){
				debug('パスワードが正しいです');

				//セッションの情報を更新
				session_regenerate_id();
				$_SESSION['login_date']=time();
				$_SESSION['login_limit']=60*60;
				$_SESSION['name']=$name;
				$_SESSION['user_id']=$row['id'];

				header('Location:main.php');
				exit;

			}else{
				debug('パスワードが違います');
				$errMsg['common']=USER_INFO_WRONG;
			}


		}else{
			debug('名前が存在しません');
			$errMsg['common']=USER_INFO_WRONG;
		}
	}


}
?>
	<div class="container col-md-4 col-xs-10 mx-auto py-4">
		<div style="position:relative;">
		 <h2 class="h3 mb-4"><?php echo $title;?></h2>
		 <?php if(!empty($errMsg['common'])){?><p class="text-danger"><?php echo $errMsg['common'];?></p><?php }?>
		 <a type="button" class="btn btn-info text-white mr-3" style="position:absolute;top:0;right:0;" href="./signup.php">新規ユーザー登録</a>
		</div>
		<form class="form-signin" action="" method="post">
			  <?php if(!empty($errMsg['name'])){?><p class="text-danger"><?php echo $errMsg['name'];?></p><?php }?>
				<input type="text" id="inputEmail" class="form-control mb-4" name="name" placeholder="ユーザー名">
				<?php if(!empty($errMsg['password'])){?><p class="text-danger"><?php echo $errMsg['password'];?></p><?php }?>
				<input type="password" id="inputPassword" class="form-control mb-4" name="password" placeholder="パスワード">
			<button class="btn btn-primary" type="submit" name="submit" value="submit">ログイン</button>
		</form>
	</div>>
<?php $title='ログイン画面';
require_once('./parts/footer.php');
?>
