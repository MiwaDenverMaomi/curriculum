<?php
require_once("./functions/function.php");
require_once("./functions/db_connect.php");
debugLogStart();
debug("================================");
debug("edit_post.php");
debug("================================");

require_once("./functions/auth.php");

//不正なアクセス対策
redirect_main_unless_parameter($_GET['id']);

  $id=$_GET['id'];
  $pdo=dbConnect();
  $sql="SELECT `id`,`title`,`content`,`time` from posts WHERE id=:id";
  $data=array([':id',$id,PDO::PARAM_INT]);

  try{
    debug('id:'.$id.'の投稿データを取得します。');
    $stmt=queryPost($pdo,$sql,$data);
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    debug('id:'.$id.'の投稿データ：'.print_r($row,true));
  }catch(PDOException $e){
    debug('エラー：'.$e->getMessage());
    $errMsg['common']=ERR_DB;
  }

if(!empty($_POST['post'])){
  debug('POSTが送信ありました。');
  debug('POST中身'.print_r($_POST,true));
  $sql="UPDATE posts SET ";
  $data=array();
  $diffFlg=false;
  if(!checkSame($row['title'],$_POST['title'])){
    debug('titleに変更あり');
    $diffFlg=true;
    $sql.="title = :title";
    checkMaxLen('title',$_POST['title'],50);
    checkSpecialChars('title',$_POST['title']);
	  // checkEnvDepChars('title',$_POST['title']);
    checkRequired('title',$_POST['title'],);
    if(empty($errMsg['title'])){
     array_push($data,[':title',$_POST['title'],PDO::PARAM_STR]);

    }
  }
  if(!checkSame($row['content'],$_POST['content'])){
     debug('contentに変更あり');
     $diffFlg=true;
     if(!checkSame($row['title'],$_POST['title'])&&$diffFlg===true){
       $sql.=", ";
     }

     $sql.="content=:content";

    checkMaxLen('content',$_POST['content'],255);
	  // checkEnvDepChars('content',$_POST['content']);
    checkRequired('content',$_POST['content'],);

  if(empty($errMsg['content'])){
     array_push($data,[':content',$_POST['content'],PDO::PARAM_STR]);
    }
  };
  $sql.=" WHERE id=:id";
  array_push($data,[':id',$_GET['id'],PDO::PARAM_INT]);
  debug('SQL:'.$sql);

  if($diffFlg===true&&empty($errMsg)){
   try{
     debug('postをアップデートします');
     $stmt=queryPost($pdo,$sql,$data);
     $diffFlg=false;
     $_SESSION['updated_post_id']=$_GET['id'];
     debug('セッション中身:'.print_r($_SESSION,true));
     header("Location:edit_done_post.php");
     exit;

   }catch(PDOException $e){
     debug('エラー:'.$e->getMessage());
     $errMsg['common']=ERR_DB;
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
    <h1>記事編集</h1>
    <form method="POST" action="">
      <?php if(!empty($errMsg['common'])) {?><p><?php echo $errMsg['common'];?></p><?php }?>
        title:<?php if(!empty($errMsg['title'])) echo $errMsg['title'];?><br>
        <input type="text" name="title" id="title" value="<?php if(!empty($row['title'])) echo $row['title'];?>" style="width:200px;height:50px;">
        <br>
        content:<?php if(!empty($errMsg['content'])) echo $errMsg['content'];?><br>
        <input type="text" name="content" id="content" value="<?php if(!empty($row['content'])) echo $row['content'];?>" style="width:200px;height:100px;"><br>
        <input type="submit" value="submit" id="post" name="post">
    </form>
</body>
</html>
