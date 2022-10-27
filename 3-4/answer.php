<?php

if(!empty($_POST['submit'])){
//[question.php]から送られてきた名前の変数、選択した回答、問題の答えの変数を作成
$username=!empty($_POST['username'])?$_POST['username']:"名無し";
$selected1=$_POST['q_ports'];
$selected2=$_POST['q_langs'];
$selected3=$_POST['q_cmds'];

$answer1="80";
// $answer2="html";
$answer2="HTML";
$answer3="select";

//選択した回答と正解が一致していれば「正解！」、一致していなければ「残念・・・」と出力される処理を組んだ関数を作成する
function showResult($selected,$answer){
  $result="";
  $result=$selected===$answer?"正解！":"残念・・・";
  return $result;
  }
}

$pageTitle="問題ページ";
require "header.php";
?>
<div class="container">
  <p><?php if(!empty($username)) echo $username;?>さんの結果は・・・？</p>
  <p>①の答え</p>
    <?php if(!empty($selected1)){ echo showResult($selected1,$answer1);}?>
  <p>②の答え</p>
    <?php if(!empty($selected2)){ echo showResult($selected2,$answer2);}?>
  <p>③の答え</p>
    <?php if(!empty($selected3)){ echo showResult($selected3,$answer3);}?>
</div>
</div>
</body>
</html>
