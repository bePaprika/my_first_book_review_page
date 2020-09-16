<?php
  //ok
  $tab = "メール認証 - ";
  $intro = "勉強のための読書を応援し、読みやすく身になる書籍を共有するサイト";

  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");

  createToken();
?>


<h2>仮登録</h2>

<div class="box_form">
  <p>登録用のメールアドレスを入力してください</p>

  <!-- POST送信 -->
  <form action="register2.php" method="post">
    <p><label>メールアドレス：<input type="text" name="mead" placeholder=""></label><p>
    <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
    <input type="submit" class="submit" value="送信">
  </form>
</div>


<?php
  include("../app/_parts/_footer.php");
?>