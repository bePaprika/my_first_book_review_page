<?php
  $title = "新規投稿 - ";
  $need_login = 1;
  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");
  $errors = array();

  validateAccount();
  createToken();
?>
<h2>新しい本を読み始めましょう</h2>
<?php
  //GETで本のタイトルが渡された場合、GETデータを変数に入れる
  if (isset($_GET)){
    $booktitle = isset($_GET["booktitle"]) ? $_GET["booktitle"] : NULL;
  }

  //POSTの受信と変数の定義
  if (isset($_POST['post'])) {
    validateToken();
    $name = $_SESSION['name'];
    $title = $_POST["title"];
    $comment = $_POST["comment"];
    $public = $_POST["public"];
    

    //既に登録された本ではないか確認
    $sql = "SELECT post_id FROM Data WHERE title=:title AND name=:name";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':title', $title, PDO::PARAM_STR);
    $stm->bindValue(':name', $_SESSION['name'], PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetch(PDO::FETCH_ASSOC);

    if(isset($result["post_id"])){
      $errors['book_dupli'] = "エラー：同じ本は2回登録できません";
    }
    else{
      //データベースに書き込む
      $sql = $pdo -> prepare("INSERT INTO Data (title,first,comment,id,name,post_at,fin,dis,public)
                              VALUES(:title,1,:comment,:id,:name,now(),0,0,:public)");
      $sql -> bindParam(':title', $title, PDO::PARAM_STR);
      $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
      $sql -> bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
      $sql -> bindParam(':name', $_SESSION['name'], PDO::PARAM_STR);
      $sql -> bindParam(':public', $public, PDO::PARAM_INT);
      $sql -> execute();
      echo "「".$title."」を本棚に登録しました。<br>";
    }
  }
?>


<?php
  //エラーがある場合ここでメッセージを表示する
  foreach($errors as $error){
    print "<p class='error'>";
    print $error."<br>";
    print "</p>";
  }
?>

<div class="box">
<br>
<form action="" method="post">
  <laber>書籍名　　　　　　　：<input type="text" name="title" value="<?=h($booktitle)?>" placeholder="本のタイトルを入力"></label><br>
  <laber>この本に期待する内容：<textarea name="comment" placeholder="期待する内容・抱負などを入力"></textarea></laber><br><br>
  <laber>公開設定<input type="radio" name="public" value="1" checked>公開する</laber>
  <laber><input type="radio" name="public" value="0">公開しない</laber>
  <br><br>
  <input type="submit" name="post" value="読み始める"><br><br>
  <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
</form>
</div>


<?php
  include("../app/_parts/_footer.php");
?>