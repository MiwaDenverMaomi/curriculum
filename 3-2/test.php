<?php

require_once('db_connect.php');//基本的にはrequireよりこちらを使う
$name = 'Jiro Yamada';
$password = 'jiro';

$sql="INSERT INTO users (name,password) VALUES (:name,:password)";
$pdo=db_connect();

//Insert
try{
//これは引数で渡された指示（SQL文）をMySQLに分かる形に変換します。
//これを プリペアドステートメント と呼びます。
//変換した文を一旦変数に格納します。
	$stmt=$pdo->prepare($sql);
	$stmt->bindParam(':name',$name);
	$stmt->bindParam(':password',$password);
	$stmt->execute();
//これでMySQLに対して以下の命令（SQL）を実行したことになります。
//INSERT INTO users (name, password) VALUES ('Taro Yamada', 'taro');
	echo 'インサートしました <br/>';
}catch(PDOException $e){
	echo 'Error:'.$e->getMessage();
	die();
}

//Select
$sql_select="SELECT * FROM users";
try{
	$stmt1=$pdo->prepare($sql_select);
	$stmt1->execute();
	$row=$stmt1->fetch(PDO::FETCH_ASSOC);
	while($row=$stmt1->fetch(PDO::FETCH_ASSOC)){
		echo $row['id'].','.$row['name'].','.$row['password'].'<br/>';
	}
}catch(PDOException $e){

}

$arr=array('tako','ika','surume');
while($row=current($arr)){//現在の内部ポインタ
	echo $row;
	echo '<br/>';
	next($arr);//次の内部ポインタへ※無限ループを避ける
}
?>
