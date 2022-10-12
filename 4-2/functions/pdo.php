<?php

function connect(){
$pdo=array();

 try{
  $db['host']='localhost';
  $db['dbname']='checktest4';
  $db['user']='root';
  $db['password']='root';
  $options=array(
  PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC);
  $dsn=sprintf('mysql:host=%s;dbname=%s',$db['host'],$db['dbname']);
  $pdo=new PDO($dsn,$db['user'],$db['password'],$options);

}catch(PDOException $e){
  global $errMsg;
  $errMsg['common']=ERR_DATABASE;
}
  return $pdo;
}

?>
