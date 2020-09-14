<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title><?= h($title);?>ReadTrough</title>
  <meta name="description" content="勉強のための読書の継続を後押しすることそして、読みやすく身のある良書を共有することを目的としたサービスです">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../css/styles.css">
</head>

<body> 
<!-- <img src="logo.png" width="300 height="50" alt="タダ本のロゴです"> -->
<header>
  <div class="container">

    <div class="logo">
      <h1><a href="index.php" class="link_logo"> ReadThrough</a></h1>
    </div>
    
    <?php
    //ログインしている状態
    if (isset($_SESSION["id"])) {
      $button1 = "<a href=\"mypage.php\" class=\"button1\"> マイページ </a>";
      $button2 = "<a href=\"logout.php\" class=\"button2\"> ログアウト </a>";
    }
    //ログインしていない状態
    else{
      $button1 = "<a href=\"login.php\" class=\"button1\"> ログイン </a>";
      $button2 = "<a href=\"register.php\" class=\"button2\"> アカウントを作る </a>";
    }
    ?>

    <div class="info">
      <ul>
        <li> <?php echo $button1; ?> </li>
        <li> <?php echo $button2; ?> </li>
      </ul>
    </div>

  </div>
</header>
