<?php
require_once('./functions/db_connect.php');
require_once('./functions/function.php');
debugLogStart();
require_once('./functions/auth.php');
// セッション開始
// session_start();->function.phpにまとめました

// $_POSTが空ではない場合
if (!empty($_POST)) {

  //バリデーション
  //ユーザーネーム->字数制限、特殊文字、環境依存文字のチェック
  checkMaxLen('name',$_POST['name'],50);
	checkSpecialChars('name',$_POST['name']);
	checkEnvDepChars('name',$_POST['name']);
  //パスワード->字数制限、半角英数文字のチェック
	checkMinLen('pass',$_POST['pass']);
	checkMaxLen('pass',$_POST['pass'],50);
  checkSingleByteChars('pass',$_POST['pass']);

  checkRequired('pass',$_POST['name']);
  checkRequired('name',$_POST['pass']);

    // 両方共入力されている場合
    if (empty($errMsg)) {
        //ログイン名とパスワードのエスケープ処理
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
        $pass = htmlspecialchars($_POST['pass'], ENT_QUOTES);
        // ログイン処理開始
        $pdo = dbConnect();
        try {
            //データベースアクセスの処理文章。ログイン名があるか判定
            $sql = "SELECT * FROM users WHERE name = :name";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name,PDO::PARAM_STR);//第三引数入れました
            $stmt->execute();
        } catch (PDOException $e) {
            debug('エラー: ' . $e->getMessage());
            $errMsg['common']=ERR_DB;
            die();
        }

        // 結果が1行取得できたら
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // ハッシュ化されたパスワードを判定する定形関数のpassword_verify
            // 入力された値と引っ張ってきた値が同じか判定しています。
            if (password_verify($pass, $row['password'])) {
                // セッションに値を保存
                session_regenerate_id();
                $_SESSION["user_id"] = $row['id'];
                $_SESSION["user_name"] = $row['name'];
                $_SESSION["login_date"]=time();
                $_SESSION["login_limit"]=60*60;
                // main.phpにリダイレクト
                header("Location: main.php");
                exit;
            } else {
                // パスワードが違ってた時の処理
                debug("パスワードが間違っています");
                $errMsg['common']=FAIL_NAME_PASS;
            }
        } else {
            //ログイン名がなかった時の処理
            debug("ユーザー名が間違っています");
            $errMsg['common']=FAIL_NAME_PASS;
        }
    }
}
?>
<!doctype html>
<html lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ログインページ</title>
    </head>
    <body>
        <h2>ログイン画面</h2>
        <form method="post" action="">
          <p><?php if(!empty($errMsg['common'])) echo $errMsg['common']; ?></p>
            <?php if(!empty($errMsg['name'])){?><p><?php echo $errMsg['name'];?></p><?php }?>
            名前：<input type="text" name="name" size="15"><br><br>
            <?php if(!empty($errMsg['password'])){?><p><?php echo $errMsg['password'];?></p><?php }?>
            パスワード：<input type="text" name="pass" size="15"><br><br>
            <input type="submit" value="ログイン">
        </form>
    </body>
</html>
