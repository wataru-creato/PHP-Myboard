<?php
session_start();
require_once "DBconnect.php";
$input_username = "";
$error="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $user=trim($_POST["username"]);
    $password=trim($_POST["password"]);

    $input_username = htmlspecialchars($user, ENT_QUOTES, 'UTF-8');

    if(isset($_POST["login_users"])){
        
        $sql_login="SELECT * FROM users WHERE username=:username";
        $stmt_login=$pdo->prepare($sql_login);
        $stmt_login->execute([
            ':username'=>$user
        ]);
        $row=$stmt_login->fetch(PDO::FETCH_ASSOC);

        if($row && password_verify($password,$row["password"])){
            $_SESSION["login_user"]=$user;
            header("Location:Myboard_main.php");
            exit;
        }else{
            $error="ユーザ名またはパスワードが違います";
        }
    }
}

?>

<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-md mx-auto">
<h1 class="flex items-center  text-4xl font-bold text-center my-6">
  <span class="flex-grow h-px bg-gray-300"></span>
  <span class="px-4">My掲示板</span>
  <span class="flex-grow h-px bg-gray-300"></span>
</h1>

<div class="max-w-md mx-auto mt-10">
<div class="text-center mt-4">
<?php if($error!=="") echo "<p style='color:red;'> $error</p>" ?>
</div>
<form method="POST">
<h2 class="text-xl font-bold">ログインページ</h2>
<div class="bg-gray-50 p-8 rounded-lg shadow-md top-4">
<li style="list-style:none;">
    ユーザ名<input type="text" name="username"  placeholder="例)山田太郎" class="appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" value="<?= $input_username ?>"></input><br>
    パスワード<input type="password" name="password" placeholder="＊＊＊" class="appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"></input>
</li>
</div>
<br><button type="submit" name="login_users" class="w-full h-12 overflow-hidden rounded bg-blue-500 px-5 py-2.5 text-white transition-all duration-300 hover:bg-blue-800 hover:ring-2 hover:ring-neutral-800 hover:ring-offset-2">ログインする</button>
</form>
<div class="text-center mt-4">
<u><a href="Myboard_NewAccount.php" class="p-2 text-blue-500">新規アカウント作成はこちら</a></u>
</div>
</div>
</div>