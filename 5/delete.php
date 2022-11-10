<?php

require_once('./functions/functions.php');

debug('XXXXXXXXXXXXXXXXXXXXXXXXXXx');
debug('本削除');
debug('XXXXXXXXXXXXXXXXXXXXXXXXXXx');
require_once('./auth/auth.php');

$book_id=!empty($_GET['bookid'])?$_GET['bookid']:'';
redirect_main_unless_parameter($book_id);

  $pdo=db_connect();
  $sql="DELETE FROM books WHERE id=:id";
  $data=array([':id',$book_id,PDO::PARAM_INT]);
  $result=deleteBook($book_id);

   if(!empty($result)){
    debug('削除成功');

  }else{
   debug('削除失敗');
  }
     header('Location:main.php');
     exit;
