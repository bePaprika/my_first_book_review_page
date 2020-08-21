<?php
  $title = "Mypage - ";
  $need_login = 1;
  require("../app/function.php");
  require("../../sec_info.php");
  include("../app/_parts/_header.php");

  $errors = array();
?>

<!-- ここからbody -->

<h1>マイページ</h1>

<?php if(isset($_SESSION['message'])): ?>
  <p class="message"><?php print $_SESSION['message']; ?></p>
  <?php $_SESSION['message'] = NULL?>
<?php endif; ?>

<div>
  <div>
    <p>こんにちは<?php print $result["name"]; ?>さん</p>
    <!-- <p>メールアドレス：<?php print $result["mead"]; ?></p> -->
  </div>
</div>

<h2><a href="newpost.php">新しい本を読み始める</a>
<h2>本の続きを記録する</h2>

<main>
<h1>新着レビュー</h1>
<?php
$sql = 'SELECT * FROM Date WHERE publi = 1　ORDER BY post_id DESC LIMIT 4';
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
<ul>
  <li><a href="データベース内の本のタイトル</li>
</ul>

<nav>
  <ul>
    <li><a href="logout.php">ログアウト</a></li>
    <li><a href="index.php">掲示ページへ戻る</a></li>
  </ul>
</nav>


<!-- ここまでbody -->

<?php
  include("../app/_parts/_footer.php");
?>