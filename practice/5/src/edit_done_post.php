<?php
require_once('./functions/function.php');
require_once('./functions/db_connect.php');
debug('==========================');
debug('記事編集完了画面');
debug('==========================');
debugLogStart();

require_once('./functions/auth.php');
if(!empty($_SESSION['updated_post_id']!==null)){
  $updated_post_id=$_SESSION['updated_post_id'];
  debug('$updated_post_id:'.$updated_post_id);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>編集完了</title>
</head>
<body>
  <h1>編集完了</h1>
  <p>ID:<?php echo $updated_post_id;?>を編集しました。</p>
  <a href="main.php">ホームページへ戻る</a>
</body>
</html>
