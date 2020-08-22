<?php
  $title = "新規投稿 - ";
  $need_login = 1;
  require("../app/function.php");
  require("../../sec_info.php");
  include("../app/_parts/_header.php");
  
  createToken();
  $errors = array();
?>

<p>新しい本を読み始めましょう</p>
<?php
  //エラーがある場合ここでメッセージを表示する
  foreach($errors as $error){
    print "<p class='error'>";
    print $error."<br>";
    print "</p>";
  }
?>

<form action="" method="post">
  <laber>書籍名　：<input type="text" name="title" placeholder="">本のタイトルを入力</label><br>
  <laber>この本に期待する内容：<textarea name="comment" placeholder="期待する内容・抱負などを入力"></textarea></laber><br>
  <laber>公開設定<input type="radio" name="public" value="1" checked>公開する</laber>
  <laber><input type="radio" name="public" value="0">公開しない</laber>

  <input type="submit" name="post" value="読み始める"><br><br>
  <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
</form>

<?php
  //POSTの受信と変数の定義
  if (isset($_POST['post'])) {
    $name = $_SESSION['name'];
    $title = $_POST["title"];
    $comment = $_POST["comment"];
    $public = $_POST["public"];
    

    //既に登録された本ではないか確認
    $sql = "SELECT post_id FROM Date WHERE title=:title AND name=:name";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':title', $title, PDO::PARAM_STR);
    $stm->bindValue(':name', $name, PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetch(PDO::FETCH_ASSOC);

    if(isset($result["post_id"])){
      $errors['book_dupli'] = "この本はすでに読み始めていますよ。";
    }
    else{
      //データベースに書き込む
      $sql = $pdo -> prepare("INSERT INTO Date (title,first,comment,name,post_at,fin,dis,public)
                              VALUES(:title,1,:comment,:name,now(),0,0,:public)");
      $sql -> bindParam(':title', $title, PDO::PARAM_STR);
      $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
      $sql -> bindParam(':name', $name, PDO::PARAM_STR);
      $sql -> bindParam(':public', $public, PDO::PARAM_INT);
      $sql -> execute();
      echo "「".$title."」を本棚に登録しました。<br>";
    }
  }
?>


<?php
  include("../app/_parts/_footer.php");
?>