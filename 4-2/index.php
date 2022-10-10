<?php
require "./functions/getData.php";

$pageTitle="4章チェックテスト";
require_once "./parts/header.php";
?>
<main class="main">
	<table class="posts">
		<tr><th class="posts__head">記事ID</th><th class="posts__head">タイトル</th><th class="posts__head">カテゴリ</th><th class="posts__head">本文</th><th class="posts__head">投稿日</th></tr>
		<tr>
			<td class="posts__data">5</td>
		  <td class="posts__data">aaaaa</td>
		  <td class="posts__data">bbbbb</td>
		  <td class="posts__data">cccc</td>
		  <td class="posts__data">dddddd</td>
	  </tr>
	</table>
</main>
<?php
require_once "./parts/footer.php";
?>
