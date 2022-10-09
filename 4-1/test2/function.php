<?php
ini_set('log_errors','On');
ini_set('error_log','./logs/debug.log');
$debug_flg=true;

function debug($str){
  global $debug_flg;
  if($debug_flg===true){
    error_log($str);
  }
}
