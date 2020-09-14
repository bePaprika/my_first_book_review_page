<?php
  $title = "遷移画面 - ";
  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");

  $errors = array();
?>
<h2>仮登録</h2>
<?php

if ($_SERVER['REQUEST_METHOD']==='POST'){
  validateToken();
  // POST受信
  // $name = $_POST["name"];
  $mead = $_POST["mead"];
  // $pass = $_POST["pass"];
  
  if($mead === ""){header('Location: https://tb-220261.tech-base.net/TADABON/work/web/register.php');}

  

  //メアドの形式チェック
  if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mead)){
    $errors['mail_char'] = "メールアドレスの形式が正しくありません。";
    $mead = "";
  }
  
  //メアドの重複確認
  $sql = "SELECT id FROM Accounts WHERE mead=:mead";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':mead', $mead, PDO::PARAM_STR);
  $stm->execute();
  $result = $stm->fetch(PDO::FETCH_ASSOC);
  
  if(isset($result["id"])){
    $errors['mail_dupli'] = "このメールアドレスはすでにアカウント登録されています。";
    //エラーメール送信
    // require("../../phpmailer/error_mail.php");
  }
  else{
    //既に仮登録メールを送っている
    $sql = "SELECT id FROM Pre WHERE mead=:mead";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':mead', $mead, PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    
    if(isset($result["id"])){
      $errors['click_twice'] = "メールボックスをご確認ください。";
    }
  }

  //エラーがあれば表示し、なければメールを送信
  if(count($errors) === 0){
    require("../../phpmailer/pre_mail.php");
  }
  else{
    foreach($errors as $error){
        echo $error."<br>";
    }
  }

  $_SESSION = array();
}
else{
  //不正な遷移はとりあえずindexに飛ばす
  header("Location: https://tb-220261.tech-base.net/TADABON/work/web/index.php");
}
?>

<?php
  include("../app/_parts/_footer.php");
?>