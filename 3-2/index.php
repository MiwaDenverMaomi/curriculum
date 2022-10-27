<?php
// $fruits=array("リンゴ"=>300,"みかん"=>150,"桃"=>3000);
$fruits=array("りんご"=>[300,1],"みかん"=>[150,1],"桃"=>[3000,1]);

function calculate($price,$num){
  return $price*$num;
}
foreach($fruits as $key=>$val){
  echo "{$key}は".calculate($val[0],$val[1])."円です。";
  echo "<br/>";
}
?>
