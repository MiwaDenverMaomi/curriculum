<?php
require_once("./functions/function.php");
require_once("./functions/db_connect.php");
debugLogStart();
debug("================================");
debug("detail_post.php");
debug("================================");

// ログインしていなければ、login.phpにリダイレクト（不正なアクセス対策①）
require_once("./functions/auth.php");

$id=$_GET['id'];
debug('type'.gettype($id));
//記事のidが空の場合、メインページに飛ばす（不正なアクセス対策②）
redirect_main_unless_parameter($id);

$row=find_post_by_id($id);
$id=$row['id'];
$title=$row['title'];
$content=$row['content'];

 $pdo=dbConnect();
try{

  $sql="SELECT * from comments WHERE post_id=:post_id";
  $data=array([':post_id',$id,PDO::PARAM_INT]);
  $stmt_comments=queryPost($pdo,$sql,$data);

}catch(PDOException $e){
	debug('エラー：'.$e->getMessage());
	$errMsg['common']=ERR_DB;
	die();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<table>
		<tr>
			<td>ID</td>
			<td><?php echo $id;?></td>
		</tr>
		<tr>
			<td>タイトル</td>
			<td><?php echo $title;?></td>
		</tr>
		<tr>
			<td>本文</td>
			<td><?php echo $content;?></td>
		</tr>
	</table>
	<a href="create_comment.php?post_id=<?php echo $id;?>">この記事にコメントする</a>
	<a href="main.php">メインページに戻る</a>
	<div>
		<?php while($row=$stmt_comments->fetch()){
			echo '<hr>';
			echo $row['name'];
			echo '<br/>';
			echo $row['content'];
		}?>
	</div>
</body>
</html>
