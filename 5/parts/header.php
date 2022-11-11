<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <title><?php if(!empty($title)) echo $title;?></title>
</head>
<body class="text-left py-4">
  <header class="col-md-5 mx-auto text-right">
    <?php if(!empty($_SESSION['name'])) {?>
    <p class="text-right">
      <?php echo htmlSpecialChars($_SESSION['name'],ENT_QUOTES).'ログイン中';}else{?>
      <?php echo 'ゲスト様'; }?>
    </p>
  </header>
