<?php
  $title = "Mypage - ";
  $intro = "ロゴをクリックするとサイトトップに戻ります";
  $errors = array();

  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");
  

  validateAccount();
?>

<h2>マイページ</h2>

<div>
  <div>
    <p>こんにちは<?= h($_SESSION["name"]) ?>さん</p>
  </div>
</div>


<h2><a href="newpost.php" class="link3">新しい本を読み始める</a>

<h2>本の続きを記録する</h2>
<!-- DBから自分の投稿だけ選択 -->
<?php
  // 重複を許さず最近読んだ本を選択
  $sql = 'SELECT * FROM Data WHERE post_id IN(SELECT MAX(post_id) FROM Data WHERE id = :id GROUP BY title )';
  // $stmt = $pdo->query($sql);
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $_SESSION["id"], PDO::PARAM_INT);
  $stmt->execute();    
  $results = $stmt->fetchAll();
?>
<!-- 表示 -->
<ul>
  <?php
    foreach ($results as $row){
      $title = $row['title'];
      $auther = $row['auther'];
  ?>
  <li> <?= '<a href="mybook.php?title='.h($title).'&auther='.h($auther).'" class="link1">'.h($title).'</a>'; ?> </li>
  <?php
    }
  ?>
</ul>


<h2>あなたの最近の読書</h2>

<?php
  // DBから自分の投稿だけ選択
  $sql = 'SELECT * FROM Data WHERE id = :id ORDER BY post_id DESC LIMIT 4'; 
  // $stmt = $pdo->query($sql);
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $_SESSION["id"], PDO::PARAM_INT);
  $stmt->execute();    
  $results = $stmt->fetchAll();

 

  //表示
  foreach ($results as $row){
    ?>
    <div class="box">
      <?php
      //タイトル
      $title = $row['title'];
      echo '書籍名　　　：<a href="mybook.php?title='.h($title).'&auther='.h($auther).'" class="link1">'.h($title).' ['.h($auther).'</a><br>';
      //コメント
      if($row['first']==1){echo "期待すること：";}
      else{echo "コメント　　：";}
      echo $row['comment']."<br>";
      echo "<br>";
      //読書の状態
      echo "読書の状態　：";
      if($row['fin']==1){echo "読了";}
      elseif($row['dis']==1){echo "挫折";}
      else{echo "読書中";}
      //補足情報
      echo "<br>";
      echo "時刻　　　　：".$row['post_at']."<br>";
      ?>
    </div>
    <?php
  }
?>




<p><a href="#top" class="link2">先頭へ戻る</a></p>

<?php
  include("../app/_parts/_footer.php");
?>