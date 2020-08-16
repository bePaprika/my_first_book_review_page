<?php
  $title = "Mypage - ";
  require("../app/function.php");
  require("../../sec_info.php");
  include("../app/_parts/_header.php")
?>

<!-- ここからbody -->

<h1><a href="newpost.php">新しい本を読み始める</a>
<h1>本の続きを記録する<h1>
<ul>
  <li>データベース内の本のタイトル</li>
</ul>


<!-- ここまでbody -->

<?php
  include("../app/_parts/_footer.php");
?>