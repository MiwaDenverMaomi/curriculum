<?php

function dbConnect(){
debug('function/dbConnect()');
 $db['host']='localhost';
 $db['dbname']='yigroupblog';
 $db['user']='root';
 $db['password']='root';
 $dsn=sprintf('mysql:host=%s;dbname=%s;',$db['host'],$db['dbname']);

  $options=array(
  PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
 );
  $pdo=null;

 try{
  $pdo=new PDO($dsn,$db['user'],$db['password'],$options);

 }catch(PDOException $e){
  debug($e->getMessage());
  global $errMsg;
  $errMsg['common']=ERR_DB;
 }
 debug('$pdo:'.print_r($pdo,true));
 return $pdo;
}
