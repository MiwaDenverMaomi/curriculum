<?php
if(!empty($_POST['submit'])){
  //POST送信で送られてきた名前を受け取って変数を作成
  $username=!empty($_POST['username'])?$_POST['username']:"名無し";
  //①画像を参考に問題文の選択肢の配列を作成してください。
  $q_ports=array("80","22","20","21");
  $q_langs=array("PHP","Python","Java","HTML");
  $q_cmds=array("join","select","insert","update");
}

$pageTitle="問題ページ";
require "header.php"
?>
<div class="container">
 <p>お疲れ様です<?php if(!empty($username)) echo $username;?>さん</p>
 <form action="answer.php" method="post">
  <h2>①ネットワークのポート番号は何番？</h2>
  <div>
   <?php foreach($q_ports as $key=>$val){?>
    <input type="radio" name="q_ports" value="<?php echo $val;?>"
    <?php if($key===0) echo 'checked';?>>
   <span class="radio"><?php echo $val?></span>
  <?php }?>
  <h2>②Webページを作成するための言語は？</h2>
  <?php foreach($q_langs as $key=>$val){?>
   <input class="radio" type="radio" name="q_langs" value="<?php echo $val;?>"
   <?php if($key===0) echo 'checked';?>>
   <span class="radio"><?php echo $val?></span>
  <?php }?>
  <h2>③MySQLで情報を取得するためのコマンドは？</h2>
  <?php foreach($q_cmds as $key=>$val){?>
   <input class="radio" class="radio" type="radio" name="q_cmds" value="<?php echo $val;?>"
   <?php if($key===0) echo 'checked';?>>
  <span class="radio"><?php echo $val?></span>
  <?php }?>
   <input type="hidden" name="username" value="<?php if(!empty($username)) echo $username;?>">
  </div>
  <input class="button" type="submit" value="回答する" name="submit">
 </form>
</div>
</div>
</body>
</html>
