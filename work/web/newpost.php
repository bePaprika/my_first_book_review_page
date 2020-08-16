<?php
  $title = "新規投稿 - ";
  require("../app/function.php");
  require("../../sec_info.php");
  include("../app/_parts/_header.php")
?>

<p>新しい本を読み始めましょう</p>
<form action="" method="post">
  <laber>書籍名　：<input type="text" name="booktitle" placeholder="">本のタイトルを入力</label><br>
  <laber>この本に期待する内容：<textarea name="comment" placeholder="期待する内容・抱負などを入力"></textarea></laber>
  <button>送信</button>
  <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
</form>

<?php
//POSTの受信と変数の定義
$name = "暫定太郎";
$title = $_POST["booktitle"];
$commeんt = $_POST["comment"];





//データベースに書き込む
$sql = $pdo -> prepare("INSERT INTO DB1 (name,title,content,ongoing,finished,frustrat,good)
                        VALUES (:name, :comm, :date, :edtd, :dltd, :pass)");
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':title', $title, PDO::PARAM_STR);
$sql -> bindParam(':content', $content, PDO::PARAM_STR);

$sql -> bindParam(':date', $date, PDO::PARAM_STR);
$sql -> bindParam(':edtd', $edtd, PDO::PARAM_INT);
$sql -> bindParam(':dltd', $dltd, PDO::PARAM_INT);
$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
$sql -> execute();
echo "コメント「".$comm."」を投稿しました<br>";

// ユーザー名
// 書籍名
// この本に期待する内容
// 書籍へのコメント <- first_commit
// 継続中ダミー <- 1
// 読了ダミー <- 0
// 挫折ダミー <-0
// をデータベースに書き込む
?>


<?php
  include("../app/_parts/_footer.php");
?>