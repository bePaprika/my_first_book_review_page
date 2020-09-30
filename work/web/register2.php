<?php
  //ok
  $tab = "遷移画面 - ";
  $intro = "読書を記録し、読みやすく身になる書籍を共有するサイトです";
  $errors = array();

  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");
?>

<h2>仮登録</h2>
<?php
  //POSTで遷移されたか確認 
  if ($_SERVER['REQUEST_METHOD']==='POST'){
    //正しいPOSTで遷移されたか確認
    validateToken();
    
    //POST受信
    $mead = $_POST["mead"];
    
    //メアドが入力されていなかった場合には元のページへ戻す
    if($mead === ""){header('Location: https://tb-220261.tech-base.net/ReadThrough/work/web/register.php');}

    //メアドの形式をチェック
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
    
    //既に本登録されている場合エラー
    if(isset($result["id"])){
      $errors['mail_dupli'] = "このメールアドレスはすでにアカウント登録されています。";
      //エラーメール送信
      // require("../../phpmailer/error_mail.php");
    }

    //本登録はされていないが、24時間以内に仮登録メールを送っている場合エラー
    else{
      $sql = "SELECT id FROM Pre WHERE mead=:mead AND register_at > now() - interval 24 hour";
      $stm = $pdo->prepare($sql);
      $stm->bindValue(':mead', $mead, PDO::PARAM_STR);
      $stm->execute();
      $result = $stm->fetch(PDO::FETCH_ASSOC);
      
      if(isset($result["id"])){
        $errors['click_twice'] = "既に仮登録用メールを送信しております。メールボックスをご確認ください。";
      }
    }

    //エラーがなければメールを送信、あればエラーを表示
    if(count($errors) === 0){
      require("../../phpmailer/pre_mail.php");
    }
    else{
      foreach($errors as $error){
        echo '<div class="box_form">$error</div>';
      }
    }

    // //SESSIONを初期化
    // $_SESSION = array();
  }

  //POSTで遷移されていないので不正遷移とみなし、indexへ飛ばす
  else{
    $_SESSION['message'] = "不正な遷移が行われました";
    header("Location: https://tb-220261.tech-base.net/ReadThrough/work/web/index.php");
  }
?>

<?php
  include("../app/_parts/_footer.php");
?>