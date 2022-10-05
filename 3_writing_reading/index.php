<?php
echo "----Writing text---- <br/>";
$testFile="test.txt";
$contents="こんにちは";

if(is_writable($testFile)){
  echo "Writable! <br/>";
  $fp=fopen($testFile,"a");//w=>完全上書き a=>末尾追加
  //書き込む
  fwrite($fp,$contents);
  fclose($fp);//開きっぱなしだと無駄なメモリを使うので閉じる
  echo "finish writing <br/>";
}else{
  echo "not writable!";
  exit;
}

echo "----Reading text---- <br/>";
$test_file="test2.txt";
if(is_readable($test_file)){
  // 読み込み可能なときの処理
  // 対象のファイルを開く
  $fp=fopen($test_file,"r");

// ここまでは書き込みの場合と同様な流れです。
// 読み込みの場合は、全て一括で内容を取得するわけではなく、1行ずつ読み込むのが通例です。
// fgets関数はファイルを1行ずつ読み込む関数です。
// これは決まった書き方なのですが、読み込めなくなるまでループ処理を実行します。
  while($line=fgets($fp)){
    // 開いたファイルから1行ずつ読み込む
    echo $line.'<br/>';
  }
  fclose($fp);
}else{
  echo "not readable!";
  exit;
}
?>
