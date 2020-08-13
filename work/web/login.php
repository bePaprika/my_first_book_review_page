<?php
  $title = "ログイン - ";
  require("../app/function.php");
  include("../app/_parts/_header.php")
?>

<!-- ここからbody -->

<!-- POST送信 -->
<form action="" method="post">
  <label>メールアドレス：<input type="text" name="mail"></label><br>
  <label>パスワード　　：<input type="password" name="pass"></label>
  <button>送信</button>
  <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
</form>

<?php
// POST受信

// メールとパスワードが一致しているか確認

// 一致の場合MyPageへ遷移
// 不一致の場合ログイン画面へ

?>

<!-- 掲示ページへ戻る -->
<a href="index.php">戻る</a>



<!-- ここまでbody -->

<?php
  include("../app/_parts/_footer.php");
?>