<?php
  //ok
  $tab = "本登録ページ - ";
  $intro = "勉強のための読書を応援し、読みやすく身になる書籍を共有するサイトです";
  $errors = array();

  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");

  createToken();
?>


<?php
  //GETのない不正な繊維 
  if(empty($_GET)) {
    header("Location: https://tb-220261.tech-base.net/TADABON/work/web/index.php");
    exit();
  }
  
  //GETがある遷移
  else{
    //GETデータを変数に入れる
    $urltoken = isset($_GET["urltoken"]) ? $_GET["urltoken"] : NULL;
    
    //会員登録を試行する
    try{
      //未登録者(flagが0) であり 仮登録日から24時間以内 か確認
      $sql = "SELECT mead FROM Pre WHERE urltoken=(:urltoken) AND flag =0 AND register_at > now() - interval 24 hour";
      $stm = $pdo->prepare($sql);
      $stm->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
      $stm->execute();
      //レコード件数取得
      $row_count = $stm->rowCount();
      
      //24時間以内に仮登録され、本登録されていないトークンの場合
      if( $row_count == 1){
        $mail_array = $stm->fetch();
        $mead = $mail_array["mead"];
        $_SESSION['mead'] = $mead;
      }
      else{
        $errors['urltoken_timeover'] = 'このURLはご利用できません。有効期限が過ぎたかURLが間違えている可能性があります。';
      }
      //データベース接続切断
      $stm = null;
    }
    catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
    }  
  }

  //確認が押された時
  if(isset($_POST['btn_confirm'])){
    
    //メアドが入力されているか確認
    if(isset($_POST['mead'])){
      $mead = $_POST['mead'];
    }else{
      $errors['mead'] = 'メールアドレスが未入力です。';
    } 

    //パスが入力されているか確認
    if(isset($_POST['pass'])){
      $pass = $_POST['pass'];
      $password_hide = str_repeat('*', strlen($pass));
    }else{
      $errors['pass'] = 'パスワードが未入力です。';
    }
  }

  //登録が押された時
  if(isset($_POST['btn_submit']) && count($errors) === 0){

    //パスワードをハッシュ化
    $password_hash =  password_hash($_SESSION['pass'], PASSWORD_DEFAULT);
  
    //アカウント登録を試行
    try{
      $sql = "INSERT INTO Accounts (name,mead,pass) VALUES (:name,:mead,:password_hash)";
      $stm = $pdo->prepare($sql);
      $stm->bindValue(':name', $_SESSION['name'], PDO::PARAM_STR);
      $stm->bindValue(':mead', $_SESSION['mead'], PDO::PARAM_STR);
      $stm->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
      $stm->execute();
  
      //Preのflagを1にする(トークンの無効化)
      $sql = "UPDATE Pre SET flag=1 WHERE mead=:mead";
      $stm = $pdo->prepare($sql);
      $stm->bindValue(':mead', $mead, PDO::PARAM_STR);
      $stm->execute();

		  //セッション変数を全て解除
      $_SESSION = array();
    }
    catch (PDOException $e){
      //トランザクション取り消し（ロールバック）
      $pdo->rollBack();
      $errors['error'] = "もう一度やりなおして下さい。";
		  print('Error:'.$e->getMessage());
    }

  }

?>
<h2>会員登録</h2>

<!-- page_3 完了画面-->
<?php if(isset($_POST['btn_submit']) && count($errors) === 0): ?>
  <h2>ReadTrough 登録ありがとうございます!</h2>
  <!-- header('Location: https://tb-220261.tech-base.net/TADABON/work/web/register4.php'."?urltoken=".print $urltoken);  -->

<!-- page_2 確認画面-->
<?php elseif (isset($_POST['btn_confirm']) && count($errors) === 0): ?>
  <div class="box_form">
    <form action="<?= $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?= $urltoken; ?>" method="post">
      <p>メールアドレス：<?= h($_SESSION['mead']); ?></p>
      <p>パスワード　　：<?= $password_hide; ?></p>
      <p>ユーザーネーム：<?= h($name); ?></p>
      
      <input type="submit" name="btn_back" class="btn_back" value="戻る">
      <input type="hidden" name="token" value="<?= $_POST['token'] ?>">
      <input type="submit" name="btn_submit" class="submit" value="登録">
    </form>
  </div>

<?php else: ?>
<!-- page_1 登録画面 -->
	<?php if(count($errors) > 0): ?>
       <?php
       //エラーがあれば表示
       foreach($errors as $error){
           echo "<p class='error'>".$error."</p>";
       }
       ?>
   <?php endif; ?>
    <?php if(!isset($errors['urltoken_timeover'])): ?>
      <div class="box_form">
        <form action="<?= $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?= $urltoken; ?>" method="post">
          <p>メールアドレス：<?= h($mead);?></p>
          <p><label>パスワード　　：<input type="password" name="pass"></label></p>
          <p><label>ユーザーネーム：<input type="text" name="name" value="<?php if( !empty($_SESSION['name']) ){ echo $_SESSION['name']; } ?>"></label></p>
          <input type="hidden" name="token" value="<?=$token?>">
          <input type="submit" name="btn_confirm" class="submit" value="確認">
        </form>
      </div>
		<?php endif ?>
<?php endif; ?>


<?php
  include("../app/_parts/_footer.php");
?>