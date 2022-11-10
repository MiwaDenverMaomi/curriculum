<?php
require_once('./functions/functions.php');

debug('XXXXXXXXXXXXXXXXXXXXXXXXXXx');
debug('ログアウト画面');
debug('XXXXXXXXXXXXXXXXXXXXXXXXXXx');
debugLogStart();

session_destroy();
$_SESSION=array();
session_regenerate_id();

debug('ログアウトしました。');
header('Location:message.php');
exit;
