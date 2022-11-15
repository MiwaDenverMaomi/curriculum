<?php
//今回の提出回答
$fruits=array("リンゴ"=>300,"みかん"=>150,"桃"=>3000);//フルーツと単価の連想配列
$q=array(1,1,1);//個数の配列
$i=0;

function calculate($price,$num){
  return $price*$num;
}

foreach($fruits as $key=>$val){
    echo "{$key}は".calculate($val,$q[$i])."円です。";
  echo "<br/>";
  $i++;
}

//前回提出回答
// $fruits=array("りんご"=>[300,1],"みかん"=>[150,1],"桃"=>[3000,1]);

// function calculate($price,$num){
//   return $price*$num;
// }
// foreach($fruits as $key=>$val){
//   echo "{$key}は".calculate($val[0],$val[1])."円です。";
//   echo "<br/>";
// }

?>
