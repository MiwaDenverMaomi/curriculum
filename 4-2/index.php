<?php
require "./functions/function.php";
require "./functions/getData.php";
session_start();
$user=new getData();

//PDOがエラーなく生成できた場合
if(empty($errMsg['common'])){
	$userInfo=array();
	$posts=array();

	try{
		debug('ユーザーデータを取得します');
		$userInfo=$user->getUserData();
    debug('ユーザーデータ中身:'.print_r($userInfo,true));

		if(empty($userInfo['last_name'])&&empty($userInfo['first_name'])){
		 debug('氏名取得失敗');
     $errMsg['userinfo']=empty($userInfo)?ERR_GET_USERNAME:'';
		}

		if(empty($userInfo['last_login'])){
			debug('最終ログイン日時取得失敗');
			$errMsg['last_login']=ERR_LOGINDATE;
		}

	}catch(PDOException $e){
     debug('ユーザー氏名／最終ログイン日時取得失敗:'.$e->getMessage());
		 $errMsg['username']=ERR_GET_USERNAME;
		 $errMsg['last_login']=ERR_GET_LOGINDATE;
	}

	try{
		debug('投稿データを取得します');
		$posts=$user->getPostData()->fetchAll();
		debug('投稿データ中身:'.print_r($posts,true));

	}catch(PDOException $e){
     debug('投稿データ取得失敗：.'.$e->getMessage());
		 $errMsg['posts']=ERR_GET_POSTS;
	}

	debug('session中身:.'.print_r($_SESSION,true));
}

$pageTitle="4章チェックテスト";
require_once "./parts/header.php";
?>
<main class="main">
	<?php if(!empty($errMsg['posts'])) {?>
		<p class="err">
			<?php echo $errMsg['posts'];?>
	  </p>
	<?php }else{?>
	<table class="posts">
		<tr>
			<th class="posts__head">記事ID</th>
			<th class="posts__head">タイトル</th>
			<th class="posts__head">カテゴリ</th>
			<th class="posts__head">本文</th>
			<th class="posts__head">投稿日</th>
		</tr>
		<?php if(!empty($posts)&&count($posts)>0){ foreach($posts as $post){?>
		<tr>
			<td class="posts__data">
				<?php echo !empty($post['id'])?$post['id']:'-';?>
			</td>
		  <td class="posts__data">
				<?php echo !empty($post['title'])?$post['title']:'-';?>
			</td>
		  <td class="posts__data">
				<?php echo !empty($post['category_no'])?catNoToCatName($post['category_no']):'-';?>
			</td>
		  <td class="posts__data">
				<?php echo !empty($post['comment'])?$post['comment']:'-';?>
			</td>
		  <td class="posts__data">
				<?php echo !empty($post['created'])?$post['created']:'-';?>
			</td>
			<?php }?>
	  </tr>
		<?php }else{?>
			<tr><td class="posts__data" colspan="5" style="text-align:center;">投稿データはありません</td></tr>
			<?php }?>
	</table>
	<?php }?>
</main>
<?php
require_once "./parts/footer.php";
?>
