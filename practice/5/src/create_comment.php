<?php
require_once('./functions/function.php');
require_once('./functions/db_connect.php');
debug('<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
debug('コメント投稿ページ');
debug('<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
debugLogStart();

//不正アクセス対策①
require_once('./functions/auth.php');
if(!empty($_POST)){
  $post_id=$_POST['post_id'];

  $name=$_POST['name'];
  $content=$_POST['content'];

  //本当はバリデーションがここ必要

if(empty($errMsg)){
  try{
    $pdo=dbConnect();
    $sql="INSERT INTO comments (post_id,name,content) VALUES(:post_id,:name,:content)";
    $data=array([':post_id',$post_id,PDO::PARAM_INT],[':name',$name,PDO::PARAM_STR],[':content',$content,PDO::PARAM_STR]);
    $stmt=queryPost($pdo,$sql,$data);
    header("Location:detail_post.php?id=".$post_id);
    exit;
  }catch(PDOException $e){
    debug('エラー:'.$e->getMessage());
    $errMsg['common']=ERR_DB;
    die();
  }
}

}else{
// POSTで渡されたデータがなかった場合
// GETで渡されたpost_idを受け取る
  $post_id=$_GET['post_id'];
  //③不正アクセス対策：$post_idが空だった場合は不正な遷移なので、main.phpに戻す
  redirect_main_unless_parameter($post_id);
}

$post_id=$_GET['post_id'];
//不正アクセス対策②
redirect_main_unless_parameter($post_id);




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
  <h1>コメント</h1>
  <form method="post" action="">
    <input type="hidden" name="post_id" value="<?php echo $post_id;?>">
    投稿者名：<br/>
    <input type="text" name="name"><br/>
    コメント:<br/>
    <input type="text" name="content" style="width:200px; height:100px;"><br/>
    <input type="hidden" name="post_id" value="<?php echo $post_id;?>">
    <input type="submit" value="submit">
  </form>
  <a href="detail_post.php?id=".<?php echo $post_id?>>記事詳細に戻る</a>
</body>
</html>
