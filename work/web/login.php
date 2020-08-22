<?php
  $title = "ログイン - ";
  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");
  $errors = array();
?>

<!-- ここからbody -->


<?php
  // ログインされていない場合ログイン画面へ飛ばす
  if (isset($_SESSION["id"])) {
    header("Location: https://tb-220261.tech-base.net/TADABON/work/web/mypage.php");
    exit;
  }


  if (isset($_POST['login'])) {

    //エラー文
    if (empty($_POST['mead'])) {
        $errors['mead'] = 'メールアドレスが未入力です。';
    } 
    if (empty($_POST['pass'])) {
        $errors['pass'] = 'パスワードが未入力です。';
    }
    //メアドもパスもある時
    if (!empty($_POST['mead']) && !empty($_POST['pass'])) {
      $mead = $_POST['mead'];
      
      try {
        //入力されたメアドからアカウントを特定
        $pdo->beginTransaction();
        $sql = "SELECT * FROM Accounts WHERE mead = :mead"; 
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':mead', $mead, PDO::PARAM_STR);
        $stm->execute();

        $pass = $_POST['pass'];
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (password_verify($pass, $result['pass'])) {    
          $_SESSION['id'] = $result["id"];
          $_SESSION['name'] = $result["name"];
          // $_SESSION['mead'] = $mead;
          $_SESSION['message'] = 'ログインしました。';
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

<h1>ログイン画面</h1>

<div class="form">
<form id="loginForm" name="loginForm" action="" method="POST">

<?php
  //エラーがある場合ここでメッセージを表示する
  foreach($errors as $error){
    print "<p class='error'>";
    print $error."<br>";
    print "</p>";
  }
?>

<form action="" method="post">
  <label>メールアドレス：<input type="text" name="mead" placeholder="メールアドレスを入力" 
    value="<?php if (!empty($_POST["mead"])) {echo htmlspecialchars($_POST["mead"], ENT_QUOTES);} ?>"></label><br>
  <label>パスワード　　：<input type="password" id="pass" name="pass" value="" placeholder="パスワードを入力"></label><br>
  <input type="submit" id="login" name="login" value="ログイン"><br><br>
</form>


<!-- 掲示ページへ戻る -->
<a href="index.php">掲示ページへ戻る</a>

<!-- ここまでbody -->

<?php
  include("../app/_parts/_footer.php");
?>