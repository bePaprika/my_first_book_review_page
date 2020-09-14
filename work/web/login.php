<?php
  //ok
  $tab = "ログイン - ";
  $intro = "勉強のための読書を応援し、読みやすく身になる書籍を共有するサイトです";
  $errors = array();

  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");
?>

<h2>ログイン</h2>

<?php
  // ログイン状態ならばマイページへとばす
  if (isset($_SESSION["id"])) {
    header("Location: https://tb-220261.tech-base.net/TADABON/work/web/mypage.php");
    exit;
  }

  // POST受信
  if (isset($_POST['login'])) {

    //メアドが入力されているか確認
    if(isset($_POST['mead'])){
      $mead = $_POST['mead'];
    }else{
      $errors['mead'] = 'メールアドレスが未入力です。';
    } 

    //パスが入力されているか確認
    if(isset($_POST['pass'])){
      $pass = $_POST['pass'];
    }else{
      $errors['pass'] = 'パスワードが未入力です。';
    }

    //エラーがない時、ログインを試行する
    if (count($errors) === 0) {
      try {
        //入力されたメアドからアカウントを特定
        $pdo->beginTransaction();
        $sql = "SELECT * FROM Accounts WHERE mead = :mead"; 
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':mead', $mead, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        //パスが一致すればログイン、不一致ならエラー
        if (password_verify($pass, $result['pass'])) {    
          $_SESSION['id'] = $result["id"];
          $_SESSION['name'] = $result["name"];
          header('Location: https://tb-220261.tech-base.net/TADABON/work/web/mypage.php');
          exit();
        } 
        else {
          $errors['login'] = 'メールアドレスまたはパスワードに誤りがあります。';
        }
      } 
      catch (PDOException $e) {
        echo $e->getMessage();
      }
    }
  }

?>


<?php
  //エラーがある場合ここでメッセージを表示する
  foreach($errors as $error){
    echo '<p class="error">'.$error.'</p>';
  }
?>

<div class="box_form">
  <form action="" method="post">
    <p><label>メールアドレス：<input type="text" name="mead" placeholder="メールアドレスを入力" 
      value="<?php if (!empty($_POST["mead"])){echo h($_POST["mead"]);} ?>"></label></p>
    <p><label>パスワード　　：<input type="password" id="pass" name="pass" value="" placeholder="パスワードを入力"></label></p>
    <input type="submit" id="login" name="login" class="submit" value="ログイン">
  </form>
</div>


<?php
  include("../app/_parts/_footer.php");
?>