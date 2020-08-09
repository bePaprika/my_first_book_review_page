<?php
  $title = "Mypage - ";
  require("../app/function.php");
  include("../app/_parts/_header.php")
?>

<!-- ここからbody -->

<!-- POST送信 -->
<form action="" method="post">
  メールアドレス：<input type="text" name="mail" placeholder=""><br>
  パスワード　　：<input type="text" name="pass" placeholder="">
  <button>送信</button>
  <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
</form>


<!-- ここまでbody -->

<?php
  include("../app/_parts/_footer.php");
?>