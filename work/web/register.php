<?php
  $title = "アカウント登録 - ";
  require("../app/function.php");
  include("../app/_parts/_header.php")
?>

<!-- ここからbody -->

<!-- POST送信 -->
<form action="" method="post">
  メールアドレス：<input type="text" name="mail" placeholder=""><br>
  ユーザーネーム：<input type="text" name="name" placeholder=""><br>
  パスワード　　：<input type="text" name="pass" placeholder="">
  <button>送信</button>
  <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
</form>

<?php
// POST受信

// メールとパスワードが一致しているか確認

// 一致の場合MyPageへ遷移
// 不一致の場合ログイン画面へ

?>

<!-- TOPへ戻る -->
<a href="index.php">戻る</a>



<!-- ここまでbody -->

<?php
  include("../app/_parts/_footer.php");
?>