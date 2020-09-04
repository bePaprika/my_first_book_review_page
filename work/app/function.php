<?php
    //sessionを使うための関数
    session_start();

    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');
    
    //変数をhtmlspecialcharsに変換する関数
    function h($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
    }

    //CSRFを防ぐtokenを作る関数
    function createToken()
    {
        if(!isset($_SESSION['token']))
        {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
    }

    //tokenが一致しているか確認する関数
    function validateToken()
    {
        if (empty($_SESSION['token']) || $_SESSION['token'] !== filter_input(INPUT_POST, 'token')) 
            {
                $_SESSION['message'] = "ログインかアカウント登録を行ってください。";
                header('Location: https://tb-220261.tech-base.net/TADABON/work/web/index.php');
                exit;
            }
    }

    //ログイン確認
    function validateAccount()
    {
        // ログインされていない場合ログイン画面へ飛ばす
        if (!isset($_SESSION["id"])) {
            $_SESSION['message'] = "ログインかアカウント登録を行ってください。";
            header("Location: https://tb-220261.tech-base.net/TADABON/work/web/index.php");
            exit;
        }
    }
?>