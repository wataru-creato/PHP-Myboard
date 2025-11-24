
<?php
session_start();
require_once "DBconnect.php";

$error="";

if(isset($_POST["login"])){
    $user=trim($_POST["user"]);
    $pass=trim($_POST["pass"]);

    $stmt=$pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([":username"=>$user]);
    $row=$stmt->fetch(PDO::FETCH_ASSOC);

    if($row && password_verify($pass,$row["password"])){
        $_SESSION["login_user"]=$user;
        header("Location:bbs.php");
        exit;
    }else{
        $error="入力情報が違います";
    }
}
?>


<h2>ログインページ</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <input type="text" name="user" placeholder="ユーザ名"><br>
    <input type="password" name="pass" placeholder="パスワード"><br>
    <input type="submit" name="login" value="ログイン">
</form>

<p><a href="creato_account.php">アカウントの新規作成はこちら</a></p>
