
<?php
session_start();
require_once "DBconnect.php";

$error="";
$message="";


if(isset($_POST["register"])){
    $newUser=trim($_POST["newUser"]);
    $newPass=trim($_POST["newPass"]);
    
    if($newUser!=="" && $newPass!==""){
        $hash=password_hash($newPass,PASSWORD_DEFAULT);

        try{
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->execute([
                    ":username" => $newUser,
                    ":password" => $hash
                ]);
             $message = "登録に成功しました。ログインしてください。";
        
        }catch(PDOException $e){
            if($e->getCode()==23000){
                $error="そのユーザ名は使われています";
            }else{
                $error="登録エラー：".$e->getMessage();
            }

        }


    }else{
        $error="ユーザ名とパスワードを入力してください";
    }
}

?>

<h2>新規作成</h2>
<?php if (!empty($message)) echo "<p style='color:green;'>$message</p>"; ?>
<form method="POST">
    <input type="text" name="newUser" placeholder="ユーザ名"><br>
    <input type="password" name="newPass" placeholder="パスワード"><br>
    <input type="submit" name="register" value="登録">
</form>

<p><a href="login.php">戻る</a></p>