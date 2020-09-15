<?php
  //ok 
  $tab = "新規投稿 - ";
  $intro = "読書をする目的を明確にして、読書体験を有意義なものにしましょう。";
  $errors = array();

  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");

  validateAccount();
  createToken();
?>

<h2>新しい本を読み始めましょう</h2>

<!-- POST受信部 -->
<?php
  //GETで本のタイトルと著者が渡された場合、GETデータを変数に入れる
  if (isset($_GET)){
    $title = isset($_GET["title"]) ? $_GET["title"] : NULL;
    $auther = isset($_GET["auther"]) ? $_GET["auther"] : NULL;
    $_SESSION['title'] = isset($_GET["title"]) ? $_GET["title"] : NULL;
    $_SESSION['auther'] = isset($_GET["auther"]) ? $_GET["auther"] : NULL;
  }

  //POSTを受信したとき
  if (isset($_POST['post'])) {
    //正しいPOSTか確認
    validateToken();
    
    //書籍名が入力されているか確認
    if($_POST["title"]!=""){
      $title = $_POST["title"];
      $_SESSION['title'] = $_POST["title"];
    }else{
      $errors['title'] = "書籍名を入力してください";
    }

    //著者が入力されているか確認
    if($_POST["auther"]!=""){
      $auther = $_POST["auther"];
      $_SESSION['auther'] = $_POST["auther"];
    }else{
      $errors['auther'] = "著者を入力してください";
    }
    
    //コメントが入力されているか確認
    if($_POST["comment"]!=""){
      $comment = $_POST["comment"];
      $_SESSION['comment'] = $_POST["comment"];
    }else{
      $errors['comment'] = "習得したいことを入力してください";
    }

    //期日が入力されているか確認
    if($_POST["deadline"]!=""){
      $deadline = $_POST["deadline"];
    }else{
      $errors['deadline'] = "いつまでに読むか決めてください";
    }

    //全て記入されていれば、既に登録された本ではないか確認
    if(count($errors) === 0){

      $sql = "SELECT post_id FROM Data WHERE title=:title AND auther=:auther AND id=:id";
      $stm = $pdo->prepare($sql);
      $stm->bindValue(':title', $title, PDO::PARAM_STR);
      $stm->bindValue(':auther', $auther, PDO::PARAM_STR);
      $stm->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
      $stm->execute();
      $result = $stm->fetch(PDO::FETCH_ASSOC);
      
      if(isset($result["post_id"])){
        $errors['book_dupli'] = "その本は既に本棚に登録されています。同じ本は2回登録できません";
      }
      
      //問題がないので正常に書き込み
      if(count($errors) == 0){
        $sql = $pdo -> prepare("INSERT INTO Data (title,auther,first,comment,deadline,id,name,post_at,fin,dis,public)
                                VALUES(:title,:auther,1,:comment,:deadline,:id,:name,now(),0,0,:public)");
        $sql -> bindParam(':title', $title, PDO::PARAM_STR);
        $sql -> bindParam(':auther', $auther, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':deadline', $deadline, PDO::PARAM_STR);
        $sql -> bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
        $sql -> bindParam(':name', $_SESSION['name'], PDO::PARAM_STR);
        $sql -> bindParam(':public', $_POST['public'], PDO::PARAM_INT);
        $sql -> execute();
        echo "<p>「".$title."」を本棚に登録しました。<br></p>";

        //書き込み情報セッションの削除
        $_SESSION['title'] = "";
        $_SESSION['auther'] = "";
        $_SESSION['comment'] = "";
      }
    } 
  }
?>

<?php
  //エラーがある場合ここでメッセージを表示する
  if(count($errors) > 0){
    foreach($errors as $error){ echo "<p class='error'>$error</p>"; }
  }
?>

<!-- POST送信部 -->
<div class="box_form">
  <form action="" method="post">
    <p><laber>書籍名　　　　：<input type="text" name="title" value="<?=h($_SESSION['title'])?>" placeholder="本のタイトルを入力"></label></p>
    <p><laber>著者　　　　　：<input type="text" name="auther" value="<?=h($_SESSION['auther'])?>" placeholder="第一著者を入力"></label></p>
    <p><laber>学習したいこと：<textarea name="comment" cols="60" rows="5" placeholder="できるだけ具体的に書くと学習に取り組みやすいでしょう"><?= h($_SESSION["comment"]); ?></textarea></laber></p>
    <p><label>いつまでに読む：<input type="date" name="deadline"  value="<?=h($_SESSION['deadline '])?>"></laber></p>
    <p><laber>公開設定　　　　<input type="radio" name="public" value="1" checked>公開する</laber>
       <laber>                <input type="radio" name="public" value="0">        公開しない</laber></p>
    <br>
    <input type="submit" name="post" class="submit" value="読み始める"><br>
    <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
  </form>
</div>


<?php
  include("../app/_parts/_footer.php");
?>