<?php
  $title = "遷移画面 - ";
  require("../app/function.php");
  require("../../sec_info.php");
  include("../app/_parts/_header.php")
?>

<?php
// POST受信
$name = $_POST["name"];
$mead = $_POST["mead"];
$pass = $_POST["pass"];


//エラーメッセージの合成
$error_message = "";
if($name===""){$error_message = $error_message."「ユーザー名」";}
if($mead===""){$error_message = $error_message."「メールアドレス」";}
if($pass===""){$error_message = $error_message."「パスワード」";}
$error_message = $error_message."を入力する必要があります<br>";

if($name!="" && $mead!="" && $pass!=""){
  require("../../phpmailer/send.php");
}
else{
  echo $error_message;
  //header('Location: register.php');
}
?>

<nav>
  <ul>
    <li><a href="register.php">登録画面へ戻る</a></li>
    <li><a href="index.php">掲示ページへ戻る</a></li>
  </ul>
</nav>
<?php
  include("../app/_parts/_footer.php");
?>