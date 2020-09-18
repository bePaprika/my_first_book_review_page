<?php
  //ok
  require("../app/function.php");
  $tab = "掲示板 ".h($_GET["title"])." - ";
  $intro = "一番下に投稿フォームもあるよ";
  $errors = array();

  require("../../sec_info.php");
  include("../app/_parts/_header.php");
  
  createToken();
?>


<!-- 正しい遷移(title,autherが指定されている)か確認 -->
<?php
  if(empty($_GET)) {
    header("Location: https://tb-220261.tech-base.net/TADABON/work/web/mypage.php");
    exit();
  }
  else{
    //書籍名か著者名がない場合不正な遷移なので
    if ($_GET["title"] === "" || $_GET["auther"] === ""){
      $_SESSION['error'] = "該当する書籍は登録されていません";
      header("Location: https://tb-220261.tech-base.net/TADABON/work/web/index.php");
      exit();
    }
  }

  $title = $_GET["title"];
  $auther = $_GET["auther"];
?>


<!-- POST受信 -->
<?php
  //投稿が押されたか
  if (isset($_POST['post'])) {
    //コメントが入力されているか
    if($_POST["comment"]!=""){
      //トークンが正しいか
      if (empty($_SESSION['token']) || $_SESSION['token'] !== filter_input(INPUT_POST, 'token')) {
        $errors['double_click'] = "更新ボタンを押しても多重投稿しません";
      }
      else{
        $status = $_POST["status"];
        $comment = $_POST["comment"];
        $public = $_POST["public"];
    
        //状態の割り当て
        if    ($status==="0"){$fin=0;$dis=0;}
        elseif($status==="1"){$fin=1;$dis=0;}
        else                 {$fin=0;$dis=1;}
    
        //データベースに書き込む
        $sql = $pdo -> prepare("INSERT INTO Data (title,auther,first,comment,id,name,post_at,fin,dis,public)
                                VALUES(:title,:auther,0,:comment,:id,:name,now(),:fin,:dis,:public)");
        $sql -> bindParam(':title',   $title,            PDO::PARAM_STR);
        $sql -> bindParam(':auther',  $auther,           PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment,          PDO::PARAM_STR);
        $sql -> bindParam(':id',      $_SESSION['id'],   PDO::PARAM_STR);
        $sql -> bindParam(':name',    $_SESSION['name'], PDO::PARAM_STR);
        $sql -> bindParam(':fin',     $fin,              PDO::PARAM_INT);
        $sql -> bindParam(':dis',     $dis,              PDO::PARAM_INT);
        $sql -> bindParam(':public',  $public,           PDO::PARAM_INT);
        $sql -> execute();
    
        $errors['posted'] = "「".h($title)."」にコメントを追加しました。";
        $_SESSION['token']= "";
      }
    }
    else{
      $errors['comment'] = "読書記録を記入してください";
    }
  }
?>

<?php
  //エラーがある場合ここでメッセージを表示する
  if(count($errors) > 0){
    foreach($errors as $error){ echo "<p>$error</p>"; }
  }
?>
<div class="container">
  <div class="index">
    <!-- 本のタイトルを表示 -->
    <h2><?= h($title)." <br>[".h($auther)." 著]"; ?> </h2>

    <!-- この本に対する皆のコメントを表示 -->
    <br>
    <h3>みんなの投稿</h3>
  </div>
  <?php
    $sql = 'SELECT * FROM Data WHERE post_id IN(SELECT MAX(post_id) FROM Data WHERE title = :title AND auther = :auther GROUP BY id)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':auther', $auther, PDO::PARAM_STR);
    $stmt->execute();    
    $results = $stmt->fetchAll();

    //円グラフようの変数を作成
    $n1 = 0;  //継続
    $n2 = 0;  //役に立った！
    $n3 = 0;  //挫折・
    foreach ($results as $row){
      if($row['fin']==1){$n2++;}
      elseif($row['dis']==1){$n3++;}
      else{$n1++;}
    }
    //円グラフを描写
    $all = $n1 + $n2 +$n3;
    if($all != 0){
      $p1 = $n1 / $all * 100;
      $p2 = ($n1+$n2) / $all * 100;
      require("chart.php");
    }
  ?>

  

</div>

<?php
  //この本に対するみんなの投稿を表示
  $sql = "SELECT * FROM Data WHERE title = :title AND auther = :auther AND public = 1 ORDER BY post_id DESC"; 
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':title', $title, PDO::PARAM_STR);
  $stmt->bindParam(':auther', $auther, PDO::PARAM_STR);
  $stmt->execute();    
  $results = $stmt->fetchAll();

  foreach ($results as $row){
    ?>
    <div class="box">
      <?php
      //コメント
      if($row['first']==1){echo '<div class="small">学習目標：<br></div>';}
      echo "<p style='white-space: pre-wrap';>".h($row['comment'])."</p>";
      //投稿者
      echo '<div class="small">投稿者：　'.h($row['name']);
      //時刻
      $date = date_create($row['post_at']);
      echo "　　投稿日時：　".date_format($date, 'Y/m/d H:i:s');
      //読書の状態
      if($row['fin']==1){echo "<div class='fin'>　役に立った！　</div>";}
      elseif($row['dis']==1){echo "<div class='fail'>　挫折・不満..　</div>";}
      echo '</div>';
      ?>
    </div>
    <?php
  }

?>


<!-- ログインしているか -->
<?php 
if (isset($_SESSION["id"])):
  //ログインしているならば この本を読み始めているか確認
    $sql = "SELECT post_id FROM Data WHERE title=:title AND auther=:auther AND id=:id";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':title', $title, PDO::PARAM_STR);
    $stm->bindValue(':auther', $auther, PDO::PARAM_STR);
    $stm->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetch(PDO::FETCH_ASSOC);

    if(isset($result["post_id"])){$started = "1";}
    else{$started = "0";}
?>

    <!-- この本を読み始めているならば POST送信 を表示 -->
    <?php if ($started === "1"):?>
      <h3>投稿フォーム</h3>
      <div class="box_form">
        <form action="" method="post">
          <laber>読書記録：<textarea name="comment" cols="60" rows="5" placeholder="コメントを入力"></textarea></laber>
          <br>
          <laber>読書状態：<input type="radio" name="status" value="0" checked>継続中</laber>
          <laber>          <input type="radio" name="status" value="1">        役に立った！！</laber>
          <laber>          <input type="radio" name="status" value="2">        挫折・不満..</laber>
          <br>
          <laber>公開設定：<input type="radio" name="public" value="1" checked>公開する</laber>
          <laber>          <input type="radio" name="public" value="0">        公開しない</laber>
          <br>
          <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
          <input type="submit" name="post" class="submit" value="投稿"><br> 
        </form>
        
      </div>

    <!-- この本を読み始めていないならば 本棚へ追加 を表示 -->
    <?php elseif ($started === "0"):?>
    <?= '<p>この本を本棚に追加し<a href="newpost.php?title='.h($title).'&auther='.h($auther).'" class="link2" >読み始める</a><br></p>';?>

  <?php endif;?>
<!-- ログインしていないならば -->
<?php 
else:
  echo '<p>書き込みを行うには<a href="login.php" class="link2">ログイン</a>もしくは<a href="register.php" class="link2">アカウント作成</a>を行ってください<br></p>';
?>

<?php endif;?>





<p><a href="#top" class="link2">先頭へ戻る</a></p>

<?php
  include("../app/_parts/_footer.php");
?>