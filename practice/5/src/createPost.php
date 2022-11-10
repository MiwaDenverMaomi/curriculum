<?php
// function.phpの読み込み
require_once("./functions/function.php");

debugLogStart();
// ログインしていなければ、login.phpにリダイレクト
require_once("./functions/auth.php");

// db_connect.phpの読み込み
require_once("./functions/db_connect.php");

// 提出ボタンが押された場合
if (!empty($_POST['post'])) {
    // titleとcontentの入力チェック
    checkMaxLen('title',$_POST['title'],50);
    checkMaxLen('content',$_POST['content'],255);

    checkSpecialChars('title',$_POST['title']);
	  checkEnvDepChars('content',$_POST['content']);

    checkSpecialChars('title',$_POST['title']);
	  checkEnvDepChars('content',$_POST['content']);

    checkRequired('title',$_POST['title'],);
    checkRequired('content',$_POST['content'],);

    if (empty($errMsg)) {
        // 入力したtitleとcontentを格納
        $title=htmlSpecialChars($_POST['title']);
        $content=htmlSpecialChars($_POST['content']);

        // PDOのインスタンスを取得
        $pdo=dbConnect();

        try {
            // SQL文の準備
            $sql="INSERT INTO posts (title,content)VALUES (:title,:content)";
            // プリペアドステートメントの準備
            $data=array([':title',$title,PDO::PARAM_STR],[':content',$content,PDO::PARAM_STR]);
            // バインド  // 実行
            $stmt=queryPost($pdo,$sql,$data);
            // main.phpにリダイレクト
            header("Location:main.php");
            exit;
        } catch (PDOException $e) {
            // エラーメッセージの出力
            debug('エラー：'.$e->getMessage());
            // 終了
            $errMsg['common']=ERR_DB;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>記事登録</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
    <h1>記事登録</h1>
    <form method="POST" action="">
      <?php if(!empty($errMsg['common'])) {?><p><?php echo $errMsg['common'];?></p><?php }?>
        title:<?php if(!empty($errMsg['title'])) echo $errMsg['title'];?><br>
        <input type="text" name="title" id="title" style="width:200px;height:50px;">
        <br>
        content:<?php if(!empty($errMsg['content'])) echo $errMsg['content'];?><br>
        <input type="text" name="content" id="content" style="width:200px;height:100px;"><br>
        <input type="submit" value="submit" id="post" name="post">
    </form>
</body>
</html>
