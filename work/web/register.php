<?php
  $title = "メール認証 - ";
  require("../app/function.php");
  require("../../sec_info.php");
  include("../app/_parts/_header.php");

  createToken();
?>

<!-- ここからbody -->

<!-- POST送信 -->
<form action="register2.php" method="post">
  メールアドレス：<input type="text" name="mead" placeholder=""><br>
  <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
  <button>送信</button>
</form>



<!-- TOPページへ戻る -->
<a href="index.php">掲示板ページへ戻る</a>

<!-- ここまでbody -->

<?php
  include("../app/_parts/_footer.php");
?>