<?php
  $title = "本登録画面 - ";
  require("../app/function.php");
  require("../../sec_info.php");
  include("../app/_parts/_header.php");

  createToken();

  $errors = array();
?>

<?php

  if(empty($_GET)) {
    header("Location: index.php");
    exit();
  }

  else{
    //GETデータを変数に入れる
    $urltoken = isset($_GET["urltoken"]) ? $_GET["urltoken"] : NULL;

    //メール入力判定
    if ($urltoken === ""){
      $errors['urltoken'] = "トークンがありません。";
    }

    else{
      try{
        // DB接続	
        //flagが0の未登録者 or 仮登録日から24時間以内
        $sql = "SELECT mead FROM Pre WHERE urltoken=(:urltoken) AND flag =0 AND register_at > now() - interval 24 hour";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
        $stm->execute();
        //レコード件数取得
        $row_count = $stm->rowCount();
        
        //24時間以内に仮登録され、本登録されていないトークンの場合
        if( $row_count ==1){
          $mail_array = $stm->fetch();
          $mead = $mail_array["mead"];
          $_SESSION['mead'] = $mead;
        }
        else{
          $errors['urltoken_timeover'] = "このURLはご利用できません。有効期限が過ぎたかURLが間違えている可能性がございます。もう一度登録をやりなおして下さい。";
        }
        //データベース接続切断
        $stm = null;
      }
      
      catch (PDOException $e){
        print('Error:'.$e->getMessage());
        die();
      }
    }
  }

  //確認
  if(isset($_POST['btn_confirm'])){
    if(empty($_POST)) {
      header("Location: index.php");
      exit();
    }else{
      //POSTされたデータを各変数に入れる
      $name = isset($_POST['name']) ? $_POST['name'] : NULL;
      $pass = isset($_POST['pass']) ? $_POST['pass'] : NULL;
      
      //セッションに登録
      $_SESSION['name'] = $name;
      $_SESSION['pass'] = $pass;
  
      //アカウント入力判定
      //パスワード入力判定
      if ($pass === ""):
        $errors['pass'] = "パスワードが入力されていません。";
      else:
        $password_hide = str_repeat('*', strlen($pass));
      endif;
  
      if ($name === ""):
        $errors['name'] = "ユーザーネームが入力されていません。";
      endif;
      
    }
    
  }
  // if($_SESSION['pass']==="" || $_SESSION['name']==="" || $_SESSION['mead']===""){
  //   echo "不正な遷移が行われましたタブを終了してやり直してください<br>";
  //   exit();
  // }

  //登録
  if(isset($_POST['btn_submit'])){
    //パスワードのハッシュ化
    $password_hash =  password_hash($_SESSION['pass'], PASSWORD_DEFAULT);
  
    //ここでデータベースに登録する
    try{
      $sql = "INSERT INTO Accounts (name,mead,pass,status,created_at,updated_at) VALUES (:name,:mead,:password_hash,1,now(),now())";
      $stm = $pdo->prepare($sql);
      $stm->bindValue(':name', $_SESSION['name'], PDO::PARAM_STR);
      $stm->bindValue(':mead', $_SESSION['mead'], PDO::PARAM_STR);
      $stm->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
      $stm->execute();
  
      //Preのflagを1にする(トークンの無効化)
      $sql = "UPDATE Pre SET flag=1 WHERE mead=:mead";
      $stm = $pdo->prepare($sql);

      //プレースホルダへ実際の値を設定する
      $stm->bindValue(':mead', $mead, PDO::PARAM_STR);
      $stm->execute();

      //データベース接続切断
		  $stm = null;

		  //セッション変数を全て解除
      $_SESSION = array();

      //セッションクッキーの削除
      if (isset($_COOKIE["PHPSESSID"])) {
          setcookie("PHPSESSID", '', time() - 1800, '/');
      }

      //セッションを破棄する
      //session_destroy();
    }
    
    catch (PDOException $e){
      //トランザクション取り消し（ロールバック）
      $pdo->rollBack();
      $errors['error'] = "もう一度やりなおして下さい。";
		  print('Error:'.$e->getMessage());
    }
  }

?>
<h1>会員登録画面</h1>

<!-- page_3 完了画面-->
<?php if(isset($_POST['btn_submit']) && count($errors) === 0): ?>
header('Location: https://tb-220261.tech-base.net/TADABON/work/web/succeed.php');

<!-- page_2 確認画面-->
<?php elseif (isset($_POST['btn_confirm']) && count($errors) === 0): ?>
	<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $urltoken; ?>" method="post">
		<p>メールアドレス：<?=htmlspecialchars($_SESSION['mead'], ENT_QUOTES)?></p>
		<p>パスワード：<?=$password_hide?></p>
		<p>ユーザーネーム：<?=htmlspecialchars($name, ENT_QUOTES)?></p>
		
		<input type="submit" name="btn_back" value="戻る">
		<input type="hidden" name="token" value="<?=$_POST['token']?>">
		<input type="submit" name="btn_submit" value="登録する">
	</form>

<?php else: ?>
<!-- page_1 登録画面 -->
	<?php if(count($errors) > 0): ?>
       <?php
       foreach($errors as $value){
           echo "<p class='error'>".$value."</p>";
       }
       ?>
   <?php endif; ?>
		<?php if(!isset($errors['urltoken_timeover'])): ?>
			<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $urltoken; ?>" method="post">
				<p>メールアドレス：<?=htmlspecialchars($mead, ENT_QUOTES, 'UTF-8')?></p>
				<p>パスワード：<input type="password" name="pass"></p>
				<p>ユーザーネーム：<input type="text" name="name" value="<?php if( !empty($_SESSION['name']) ){ echo $_SESSION['name']; } ?>"></p>
				<input type="hidden" name="token" value="<?=$token?>">
				<input type="submit" name="btn_confirm" value="確認する">
			</form>
		<?php endif ?>
<?php endif; ?>

<nav>
  <ul>
    <li><a href="register.php">登録画面へ戻る</a></li>
    <li><a href="index.php">掲示ページへ戻る</a></li>
  </ul>
</nav>

<?php
  include("../app/_parts/_footer.php");
?>