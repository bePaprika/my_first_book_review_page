<?php
  $title = "遷移画面 - ";
  require("../app/function.php");
  require("../../sec_info.php");
  include("../app/_parts/_header.php")
?>

<?php

if ($_SERVER['REQUEST_METHOD']==='POST'){
  validateToken();
  // POST受信
  // $name = $_POST["name"];
  $mead = $_POST["mead"];
  // $pass = $_POST["pass"];
  
  if($mead === ""){header('Location: https://tb-220261.tech-base.net/TADABON/work/web/register.php');}

  //エラーメッセージの合成
  $error_message = "";
  
  //メアドの形式チェック
  if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mead)){
    $error_message = $error_message."メールアドレスの形式が正しくありません。<br>";
    $mead = "";
  }
  
  //メアドの重複確認
  $sql = "SELECT id FROM Accounts WHERE mead=:mead";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':mead', $mead, PDO::PARAM_STR);
  $stm->execute();
  $result = $stm->fetch(PDO::FETCH_ASSOC);
  
  if(isset($result["id"])){
    $error_message = $error_message. "このメールアドレスはすでに利用されております。<br>";
  }
  
  if($error_message===""){
    require("../../phpmailer/send.php");
  }
  else{
    echo $error_message;
    //header('Location: register.php');
  }

}
else{
  echo "不正な画面遷移が行われました";
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