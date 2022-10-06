<?php

	if(!empty($_POST['submit'])){
		$nums=$_POST['numbers'];
		$date=date('Y/m/d');

    if(empty($nums)||!preg_match("/^[0-9]+$/",$nums)){
			$errMsg="0~9の数字(半角)を入力してください。";
		}

		if(empty($errMsg)){
		$result='';
		$rand=mt_rand(0,(mb_strlen($nums)-1));
    $num=$nums[$rand];

		if($num===0){
      $result='凶';
		}else if(1>=$num&&$num<=3){
			$result='小吉';
		}else if(4>=$num&&$num<=6){
			$result='中吉';
		}else if(7>=$num&&$num<=8){
			$result='吉';
		}else{
			$result='大吉';
		}
	}
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Result</title>
</head>
<body>
	<?php if(!empty($errMsg)){ echo $errMsg;}else{?>
	<p><?php if(!empty($date))echo $date;?>の運勢は</p>
	<p>選ばれた数字は<?php if(!empty($num)) echo $num;?>
	<br/><?php if(!empty($result)) echo $result;?></p>
	<?php }?>
</body>
</html>
