<?php $title='本 登録画面';
require_once('./functions/functions.php');
require_once('./parts/header.php');
debug('XXXXXXXXXXXXXXXXXXXXXXXXXXx');
debug('本登録画面');
debug('XXXXXXXXXXXXXXXXXXXXXXXXXXx');

require_once('./auth/auth.php');

if(!empty($_POST['submit'])){
	debug('POST送信ありました');
  $bookTitle=!empty($_POST['title'])?$_POST['title']:'';
	$date=!empty($_POST['date'])?$_POST['date']:'';
	$stock=!empty($_POST['stock'])?$_POST['stock']:'';

	//バリデーション

  validMaxLen('title',$bookTitle);
	validDate('date',$date);
	validNum('stock',$stock,30);

	validRequired('title',$bookTitle);
	validRequired('date',$date);
	validRequired('stock',$stock);

	if(empty($errMsg)){
    debug('エラーありません');

		$pdo=db_connect();
		$sql="INSERT INTO books (`date`,`title`,`stock`) VALUES(:date,:title,:stock)";
		$data=array([':date',$date,PDO::PARAM_STR],[':title',$bookTitle,PDO::PARAM_STR],[':stock',$stock,PDO::PARAM_INT]);
		$result=registerBook($pdo,$sql,$data);

		if($result===null){
			debug('本登録失敗');
     $errMsg['common']=REGISTER_FAILED;//DB_ERRで登録失敗して登録されたエラーメッセージは結局こちらで上書きされます...
		}else{
			debug('本登録成功');
			header('Location:main.php');
			exit;
		}
	}

}


?>
	<div class="container col-md-4 col-xs-10 mx-auto py-4">
		 <h2 class="h3 mb-4"><?php echo $title;?></h2>
		 <?php if(!empty($errMsg['common'])){?><p class="text-danger"><?php echo $errMsg['common'];?></p><?php }?>
		<form class="form-signin" action="" method="post">
		 <?php if(!empty($errMsg['title'])){?><p class="text-danger"><?php echo $errMsg['title'];?></p><?php }?>
				<input type="text" id="" class="form-control mb-4" placeholder="タイトル" name="title">
		    <?php if(!empty($errMsg['date'])){?><p class="text-danger"><?php echo $errMsg['date'];?></p><?php }?>
				<input type="text" id="" class="form-control mb-4" placeholder="発売日" name="date">
				<h3 class="h5">在庫数</h3>
				<select class="form-select mb-4" aria-label="Default select example" name="stock">
					<option selected>選択してください</option>
					<?php for($i=1;$i<30;$i++ ){?>
						<option value="<?php echo $i;?>"><?php echo $i;?></option>
					<?php }?>
				</select>
			<div>
   			<button class="btn btn-primary col-md-4" type="submit" name="submit" value="submit">登録</button>
			</div>
		</form>
	</div>>
<?php
require_once('./parts/footer.php');
?>
