<?php
  $title = "Mypage - ";
  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");
  
  validateAccount();
?>

<h1>本のタイトル</h1>


<?php
  include("../app/_parts/_footer.php");
?>