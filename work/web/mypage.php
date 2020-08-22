<?php
  $title = "Mypage - ";
  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");
  $errors = array();

  validateAccount();
?>

<!-- ここからbody -->

<h1>マイページ</h1>

<?php if(isset($_SESSION['message'])): ?>
  <p class="message"><?php print $_SESSION['message']; ?></p>
  <?php $_SESSION['message'] = NULL?>
<?php endif; ?>

<div>
  <div>
    <p>こんにちは<?= $_SESSION["name"] ?>さん</p>
  </div>
</div>

<h2><a href="newpost.php">新しい本を読み始める</a>
<h2>本の続きを記録する</h2>


<h2>あなたの最近の読書</h2>
<?php
  $sql = 'SELECT * FROM Data ORDER BY post_id DESC LIMIT 4'; //WHERE name = :name 
  $stmt = $pdo->query($sql);
  // $stmt->bindParam(':name', $_SESSION["name"], PDO::PARAM_STR);
  // $stmt->execute();    
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
    echo '時刻　　　　：'.$row['post_at'].'<br>';
    echo '<br>';
  }
?>

<!-- </main>
<ul>
  <li><a href="データベース内の本のタイトル">データベース内の本のタイトル</li>
</ul> -->

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