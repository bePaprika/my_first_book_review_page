<?php
    //sessionを使うための関数
    session_start();
    
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

    function validateToken()
    {
        if (
            empty($_SESSION['token'])||
            $_SESSION['token'] !== filter_input(INPUT_POST, 'token')
            )
            {
                exit('Invalid post request');
            }
    }

?>