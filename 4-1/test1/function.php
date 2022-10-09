<?php
ini_set('log_errors','On');
ini_set('error_log','./logs/debug.log');

function debug($str){
	error_log($str);
}

// 取得したクラス名簿を表示するための処理
function getName($list) {
		debug('getName');
		echo "【Aクラスの名簿】" . '<br>';
//配列の中の名前を出す。
		foreach ($list as $key => $member) {
				echo $key.'<br/>';
		}
		echo '<br>';
}

// 大阪出身の方を抽出
function getPeople($list) {
		debug('getPeople');
		foreach ($list as $key => $member) {
				if (isset($member['出身']) && $member['出身'] === '大阪') {
						echo "☆クラスで大阪出身の子は" .$key. PHP_EOL . "さんです。";
				}
		}
}
?>
