<?php
  //ok 
  require("../../sec_info.php");
  require("../app/function.php");

  $_SESSION = array();
  $_SESSION['message'] = "ログアウトしました。";
  header("Location: https://tb-220261.tech-base.net/TADABON/work/web/index.php");
  exit();
?>


