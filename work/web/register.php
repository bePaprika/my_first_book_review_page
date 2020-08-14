<?php
  $title = "アカウント登録 - ";
  require("../app/function.php");
  include("../app/_parts/_header.php")
?>

<!-- ここからbody -->

<!-- POST送信 -->
<form action="register2.php" method="post">
  ユーザーネーム：<input type="text" name="name" placeholder="全体に公開されます"><br>
  メールアドレス：<input type="text" name="mead" placeholder=""><br>
  パスワード　　：<input type="text" name="pass" placeholder="">
  <button>送信</button>
  <!-- <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>"> -->
</form>



<!-- TOPページへ戻る -->
<a href="index.php">掲示板ページへ戻る</a>



<!-- ここまでbody -->

<?php
  include("../app/_parts/_footer.php");
?>