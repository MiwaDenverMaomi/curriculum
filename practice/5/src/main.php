<?php
// セッション開始
require_once("./functions/function.php");
require_once("./functions/db_connect.php");

debugLogStart();

require_once("./functions/auth.php");
// if(!empty($_SESSION['updated_post_id'])){
//   unset($_SESSION['updated_post_id']);
// }

// セッションにuser_nameの値がなければlogin.phpにリダイレクト
// if (empty($_SESSION["user_name"])) {
//     header("Location: login.php");
//     exit;
// }->auth.phpに含めました

 $pdo=dbConnect();
 $sql="SELECT * FROM posts";
 $data=null;

  try{
   $stmt=queryPost($pdo,$sql,$data);
  }catch(PODException $e){
   debug('エラー：'.$e->getMessage());
   $errMsg['common']=ERR_DB;
  }

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>メイン</title>
</head>
<body>
    <h1>メインページ</h1>
    <p>ようこそ<?php if(!empty($_SESSION['user_name']))echo $_SESSION["user_name"]; ?>さん</p>
    <table>
    <tr>
      <th>記事ID</th>
      <th>タイトル</th>
      <th>本文</th>
      <th>投稿日</th>
      <th>編集</th>
      <th>削除</th>
      <th></th>

    </tr>
    <?php while($row=$stmt->fetch(PDO::FETCH_ASSOC)){?>
    <tr>
      <td><?php echo $row['id']?></td>
      <td><?php echo $row['title']?></td>
      <td><?php echo $row['content']?></td>
      <td><?php echo $row['time']?></td>
      <td><a href="detail_post.php?id=<?php echo $row['id'];?>">詳細</td>
      <td><a href="edit_post.php?id=<?php echo $row['id'];?>">編集</a></td>
      <td><a href="delete_post.php?id=<?php echo $row['id'];?>">削除</a></td>

    </tr>
    <?php }?>
    </table>
    <a href="logout.php">ログアウト</a>
</body>
</html>
