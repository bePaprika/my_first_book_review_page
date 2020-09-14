<?php
  $title = "TOP - ";
  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");
?>

<!-- ここからbody -->




<p class="page_intro">勉強のための読書を応援し、読みやすく身になる書籍を共有するサイトです<br></p>

<!-- 遷移メッセージがある場合はここで表示 -->
<?php if(isset($_SESSION['message'])): ?>
  <p style="color: red" class="message"><?php print $_SESSION['message']; ?></p>
  <?php $_SESSION['message'] = NULL ?>
<?php endif; ?>





<h2>新着レビュー</h2>
<?php
  $sql = 'SELECT * FROM Data WHERE public = 1 ORDER BY post_id DESC LIMIT 4';
  $stmt = $pdo->query($sql);
  $results = $stmt->fetchAll();
  foreach ($results as $row){
    ?>
    <div class="box">
      <?php
      //タイトル
      $booktitle = $row['title'];
      echo "書籍名　　　：<a href=\"book.php?booktitle=$booktitle\" class=\"link1\">".$booktitle."</a><br>";
      //コメント
      if($row['first']==1){echo "期待すること：";}
      else{echo "コメント　　：";}
      echo $row['comment'].'<br>';
      echo '<br>';
      //読書の状態
      echo '読書の状態　：';
      if($row['fin']==1){echo "読了";}
      elseif($row['dis']==1){echo "挫折";}
      else{echo "読書中";}
      //補足情報
      echo '<br>';
      echo '投稿者： '.$row['name'].'　時刻： '.$row['post_at'].'<br>';
      ?>
    </div>
    <?php
  }
?>



<h2>本を検索する</h2>



<p><a href="#top">先頭へ戻る</a></p>
<!-- ここまでbody -->

<?php
  include("../app/_parts/_footer.php");
?>