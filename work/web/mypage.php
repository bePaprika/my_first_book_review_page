<?php
  $title = "Mypage - ";
  require("../app/function.php");
  require("../../sec_info.php");
  include("../app/_parts/_header.php");

  $errors = array();
  $id = $_SESSION["id"];
?>

<!-- ここからbody -->
<?php
// ログインされていない場合ログイン画面へ飛ばす
if (!isset($_SESSION["id"])) {
  header("Location: https://tb-220261.tech-base.net/TADABON/work/web/login.php");
  exit;
}

try{
  //トランザクション開始
  $pdo->beginTransaction();
  $sql = "SELECT * FROM Accounts WHERE id=(:id)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':id', $id, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

}
catch (PDOException $e){
 echo $e->getMessage();
}
?>


<h1>マイページ</h1>

<?php if(isset($_SESSION['message'])): ?>
  <p class="message"><?php print $_SESSION['message']; ?></p>
  <?php $_SESSION['message'] = NULL?>
<?php endif; ?>

<div>
  <div>
    <p>こんにちは<?php print $result["name"]; ?>さん</p>
    <!-- <p>メールアドレス：<?php print $result["mail"]; ?></p> -->
  </div>
</div>

<h2><a href="newpost.php">新しい本を読み始める</a>
<h2>本の続きを記録する</h2>


<ul>
  <li>データベース内の本のタイトル</li>
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