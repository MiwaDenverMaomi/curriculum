<?php $title='メッセージ';
require_once('./functions/functions.php');
require_once('./parts/header.php');
debug('XXXXXXXXXXXXXXXXXXXXXXXXXXx');
debug('完了メッセージ');
debug('XXXXXXXXXXXXXXXXXXXXXXXXXXx');

require_once('./auth/auth.php');

$complete_msg='';

if(!empty($_SESSION['success'])){
  $complete_msg=$_SESSION['success'];
  unset($_SESSION['success']);
}
?>
	<div class="container col-md-4 col-xs-10 mx-auto py-4">
		 <h2 class="h3 mb-4"><?php if(!empty($complete_msg))echo $complete_msg;?></h2>
			<div>
        <?php if(!empty($_SESSION['user_id'])){?>
   			  <a class="btn btn-primary col-md-5" type="button" href="./main.php">本 在庫一覧へ</a>
        <?php }else{?>
          <a class="btn btn-primary col-md-5" type="button" href="./login.php">ログインページへ</a>
        <?php }?>
			</div>
		</form>
	</div>>
<?php
require_once('./parts/footer.php');
?>
