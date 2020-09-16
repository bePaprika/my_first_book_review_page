<?php
  //ok
  $tab = "TOP - ";
  $intro = "勉強のための読書を応援し、読みやすく身になる書籍を共有するサイトです";

  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");
?>


<!-- 遷移メッセージがある場合はここで表示 -->
<?php 
  if(isset($_SESSION['message'])){
    echo '<p class="message">'.$_SESSION["message"].'</p>';
    $_SESSION['message'] = "";
  }
?>

<h2>新着レビュー</h2>

<?php
  $sql = 'SELECT * FROM Data WHERE public = 1 ORDER BY post_id DESC LIMIT 5';
  $stmt = $pdo->query($sql);
  $results = $stmt->fetchAll();
  foreach ($results as $row){
    ?>
    <div class="box">
      <?php
      //タイトル
      $title = $row['title'];
      $auther = $row['auther'];
      echo '<p>書籍：　<a href="book.php?title='.h($title).'&auther='.h($auther).'" class="link1">'.h($title).'</a></p>';
      //著者
      echo '<p>著者：　'.h($auther).'</p>';
      //コメント
      if($row['first']==1){echo '習得したいこと：<br>';}
      else{echo 'コメント：<br>';}
      echo h($row['comment']).'<br>';
      echo '<br>';
      //投稿者
      echo '投稿者： '.h($row['name']).'<br>';
      //時刻
      $date = date_create($row['post_at']);
      echo "投稿日時：".date_format($date, 'Y/m/d　H:i');
      //読書の状態
      if($row['fin']==1){echo "　読了　";}
      elseif($row['dis']==1){echo "　挫折　";}
      echo '<br>';
      ?>
    </div>
    <?php
  }
?>



<h2>本を検索する</h2>



<p><a href="#top" class="link2">先頭へ戻る</a></p>

<?php
  include("../app/_parts/_footer.php");
?>