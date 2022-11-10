<?php $title='在庫一覧画面';
require_once('./functions/functions.php');
require_once('./parts/header.php');

debug('XXXXXXXXXXXXXXXXXXXXXXXXXXx');
debug('在庫一覧画面');
debug('XXXXXXXXXXXXXXXXXXXXXXXXXXx');
debugLogStart();

require_once('./auth/auth.php');


$books=getAllBooks();

?>
	   <div class="container col-md-5 col-xs-10 mx-auto py-4">
				<h2 class="h3 mb-4"><?php echo $title;?></h2>
		<div class="mb-4">
		  <a type="button" class="btn btn-primary text-white mr-3" href="./register.php">新規登録</a>
		  <a type="button" class="btn btn-secondary text-white" href="./logout.php">ログアウト</a>
		</div>
		<table class="table border">
			<thead style="background:lightgray;">
				<tr>
					<th scope="col" class="border">タイトル</th>
					<th scope="col" class="border">発売日</th>
					<th scope="col" class="border">在庫数</th>
					<th scope="col" class="border"></th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($books)) {
					foreach($books as $book) {?>
				<tr>
					<td scope="row" class="border"><?php echo $book['title']?></td>
					<td class="border"><?php echo date('Y/m/d',strtotime($book['date']));?></td>
					<td class="border"><?php echo $book['stock']?></td>
					<td class="border"><a type="button" class="btn btn-danger text-white" href="./delete.php?bookid=<?php echo $book['id'];?>">削除</a></td>
				</tr>
				<?php }}?>
			</tbody>
		</table>
	   </div>>
<?php
require_once('./parts/footer.php');
?>
