<?php
  $title = "Mypage - ";
  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");

  createToken();
?>

<!-- 正しい遷移(booktitleが指定されている)か確認 -->
<?php
  if(empty($_GET)) {
    header("Location: https://tb-220261.tech-base.net/TADABON/work/web/mypage.php");
    exit();
  }

  else{
    //GETデータを変数に入れる
    $booktitle = isset($_GET["booktitle"]) ? $_GET["booktitle"] : NULL;
    if ($booktitle === ""){
      header("Location: https://tb-220261.tech-base.net/TADABON/work/web/mypage.php");
      exit();
    }
  }
?>

<!-- 本のタイトル -->
<h1><?php print h($booktitle); ?>[掲示板]</h1>

<!-- POST受信 -->
<?php
  if (isset($_POST['post'])) {
    validateToken();
    $status = $_POST["status"];
    $comment = $_POST["comment"];
    $public = $_POST["public"];

    //データベースに書き込む
    $sql = $pdo -> prepare("INSERT INTO Data (title,first,comment,id,name,post_at,fin,dis,public)
                            VALUES(:title,0,:comment,:id,:name,now(),:fin,:dis,:public)");
    $sql -> bindParam(':title', $booktitle, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
    $sql -> bindParam(':name', $_SESSION['name'], PDO::PARAM_STR);
    $sql -> bindParam(':fin', $fin, PDO::PARAM_INT);
    $sql -> bindParam(':dis', $dis, PDO::PARAM_INT);
    $sql -> bindParam(':public', $public, PDO::PARAM_INT);
    $sql -> execute();
    echo "「".$booktitle."」にコメントを追加しました。<br>";
    
  }
?>
<!-- ログインしているか -->
<?php if (!isset($_SESSION["id"])):
  //ログインしているならば この本を読み始めているか確認
    $sql = "SELECT post_id FROM Data WHERE title=:title AND name=:name";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':title', $booktitle, PDO::PARAM_STR);
    $stm->bindValue(':name', $_SESSION['name'], PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetch(PDO::FETCH_ASSOC);

    if(isset($result["post_id"])){$started = "1";}
    else{$started = "0";}
?>

  <!-- この本を読み始めているならば POST送信 を表示 -->
  <?php if ($started === "1"):?>
    <form action="" method="post">
      <laber>読書記録：<textarea name="comment" placeholder="コメントを入力"></textarea></laber>
      <br>
      <laber>読書状態：<input type="radio" name="status" value="0" checked>継続中</laber>
      <laber>          <input type="radio" name="status" value="1">読了！</laber>
      <laber>          <input type="radio" name="status" value="2">挫折..</laber>
      <br>
      <laber>公開設定：<input type="radio" name="public" value="1" checked>公開する</laber>
      <laber>          <input type="radio" name="public" value="0">公開しない</laber>
      <br>
      <input type="submit" name="post" value="投稿"><br><br>
      <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
    </form>
    <p>掲示板での投稿は公開されます。非公開で投稿したい場合はマイページで投稿してください。</p>

  <!-- この本を読み始めていないならば 本棚へ追加 を表示 -->
  <?php elseif ($started === "0"):?>
  <?="この本を本棚に追加し<a href=\"newpost.php?booktitle=$booktitle\">読み始める</a><br>";?>

  <?endif;?>
<?endif;?>


<!-- この本に対して自分がしたコメント一覧 -->
<h2>過去ログ</h2>
<?php
  $sql = "SELECT * FROM Data WHERE id = :id AND title = :title ORDER BY post_id DESC"; 
  // $stmt = $pdo->query($sql);
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':title', $booktitle, PDO::PARAM_STR);
  $stmt->bindParam(':id', $_SESSION["id"], PDO::PARAM_INT);
  $stmt->execute();    
  $results = $stmt->fetchAll();
  foreach ($results as $row){
    //コメント
    if($row['first']==1){echo "期待すること：";}
    else{echo "コメント　　：";}
    echo $row['comment']."<br>";
    //時刻
    echo "日時　　　　：".$row['post_at'];
    //読書の状態
    if($row['fin']==1){echo "　読了　";}
    elseif($row['dis']==1){echo "　挫折　";}
    echo "<br><br>";
  }
?>

<nav>
  <ul>
    <li><a href="mypage.php">マイページへ戻る</a></li>
    <li><a href="index.php">掲示ページへ戻る</a></li>
  </ul>
</nav>

<p><a href="#top">先頭へ戻る</a></p>

<?php
  include("../app/_parts/_footer.php");
?>