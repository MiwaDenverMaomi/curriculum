<?php
//関数読み込み
require "function.php";

// セッション開始
session_start();
debug('セッションを開始します');
debug('セッションID:'.session_id());

require 'lib/password.php';
include_once("dbInfo.php");

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

// ログインボタンが押された場合
if (isset($_POST["signUp"])) {
    debug('POST送信がありました');

    //1.入力値のバリデーション
    // ユーザIDの入力チェック
    if (empty($_POST["username"])) {  // 値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    // パスワードの入力チェック
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    // パスワード（確認）の入力チェック
    } else if (empty($_POST["password2"])) {
        $errorMessage = 'パスワード（確認用）が未入力です。';
    }

    //同値チェック
    if(empty($errorMessage)){
      debug('ユーザー名、パスワード、パスワード（確認用）すべて入力済');
       if ($_POST["password"] !== $_POST["password2"]) {
        debug('パスワード／パスワード確認用に誤りがあります');
          $errorMessage = 'パスワードに誤りがあります。';
       }
    }

    //バリデーションOKの場合
    if (empty($errorMessage)) {
        debug('すべてバリデーションOKです。');

        // 入力したユーザIDとパスワードを格納
        $username = $_POST["username"];
        $password = $_POST["password"];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare("INSERT INTO users(name, password) VALUES (?, ?)");

            $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT)));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）

            $userid = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる
            debug('ユーザーID：'.$userid);

            //セッションID再発行
            debug('セッションを再発行します');
            session_regenerate_id();
            debug('新しいセッションID:'.session_id());

            //ログイン情報をセッションに格納
            $_SESSION['userid']=$userid;
            debug('ログイン成功');
            debug('$_SESSIONに格納したユーザー情報($_SESSION["userid"])は'.$_SESSION['userid'].'です');

            $signUpMessage = '登録が完了しました。あなたの登録IDは ' . $userid . ' です。パスワードは ' . $password . ' です。';  // ログイン時に使用するIDとパスワード

        } catch (PDOException $e) {
            debug('ログイン失敗');
            $errorMessage = 'データベースエラー';
            // $e->getMessage() でエラー内容を参照可能（デバック時のみ表示）
            // echo $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>新規登録</title>
    </head>
    <body>
        <h1>新規登録画面</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>新規登録フォーム</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
                <label for="username">ユーザー名</label><input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["username"])) {
    echo htmlspecialchars($_POST["username"], ENT_QUOTES);
} ?>">
                <br>
                <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br>
                <label for="password2">パスワード(確認用)</label><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">
                <br>
                <input type="submit" id="signUp" name="signUp" value="登録">
            </fieldset>
        </form>
    </body>
</html>
