<?php
  $title = "ログアウト - ";
  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");
  $errors = array();
?>

<?php
session_destroy();

$_SESSION['message'] = "ログアウトしました。";
header("Location: https://tb-220261.tech-base.net/TADABON/work/web/index.php");
exit();
?>


<?php
  include("../app/_parts/_footer.php");
?>