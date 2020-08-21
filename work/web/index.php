<?php
  $title = "TOP - ";
  require("../app/function.php");
  require("../../sec_info.php");
  include("../app/_parts/_header.php");
?>

<!-- ここからbody -->



<h1>タダ本</h1>
<p>本は読むと身になるので実質タダ!!<br>
実質タダじゃんと感じる本を共有しよう<br></p>

<?php if(isset($_SESSION['message'])): ?>
  <p class="message"><?php print $_SESSION['message']; ?></p>
  <?php $_SESSION['message'] = NULL ?>
<?php endif; ?>

<?php
  if (isset($_SESSION["id"])) {
    $state = "マイページ";
  }
  else{
    $state = "ログイン";
  }
?>

<nav>
  <ul>
    <li><a href="login.php"><?php h($state) ?></a></li>
    <li><a href="register.php">アカウントを作る</a></li>
  </ul>
</nav>

<main>
<h1>新着レビュー</h1>
<?php
$sql = 'SELECT * FROM Date WHERE publi = 1　ORDER BY id DESC LIMIT 4';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
  //タイトル
  echo '書籍名　　　：'.$row['title'].'<br>';
  //コメント
  if($row['first']==1){echo "期待すること：";}
  else{echo "コメント　　：";}
  echo $row['comment'].'<br>';
  //読書の状態
  echo '読書の状態　：';
  if($row['fin']==1){echo "読了";}
  elseif($row['dis']==1){echo "挫折";}
  else{echo "読書中";}
  //補足情報
  echo '<br>';
  echo '投稿者： '.$row['name'].'　時刻： '.$row['post_at'].'<br>';
  echo '<br>';
}
?>
</main>

<aside>
<h1>本ごとにレビューを見る</h1>
<h1>本を検索する</h1>

</aside>

<p><a href="#top">先頭へ戻る</a></p>
<!-- ここまでbody -->

<?php
  include("../app/_parts/_footer.php");
?>