<?php
$num=100;
$str="";
$br="<br>";

for($i=1;$i<=$num;$i++){
  if($i%3===0){
    $str= "Fizz!";
  }else if($i%5===0){
    $str=  "Buzz!";
  }else if($i%3===0&&$i%5===0){
    $str=  "FizzBuzz!";
  }else{
    $str=  $i;
  }
  echo $str;
  echo $br;
}

?>
