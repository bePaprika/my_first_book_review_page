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
                header('Location: https://tb-220261.tech-base.net/TADABON/work/web/index.php');
                // exit('不正な画面遷移が行われました');
            }
    }

    //ログイン
    function validateAccount()
    {
        if(isset($need_login)){
            // ログインされていない場合ログイン画面へ飛ばす
            $id = $_SESSION["id"];
            if (!isset($_SESSION["id"])) {
                header("Location: https://tb-220261.tech-base.net/TADABON/work/web/login.php");
                exit;
            }

            try{
                //トランザクション開始
                $pdo->beginTransaction();
                $sql = "SELECT * FROM Accounts WHERE id=(:id)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id', $id, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            catch (PDOException $e){
                echo $e->getMessage();
            }
        }
    }
?>