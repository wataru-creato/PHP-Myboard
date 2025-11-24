<?php
session_start();
require_once "DBconnect.php";

$input_username = "";
$error="";
$message="";

if(isset($_POST["registar"])){
    $user=trim($_POST["username"]);
    $password=trim($_POST["password"]);

    if($user!=="" && $password!==""){
    $hash=password_hash($password,PASSWORD_DEFAULT);
    $input_username = htmlspecialchars($user, ENT_QUOTES, 'UTF-8');

    try{
        $sql_NewAccount="INSERT INTO users (username,password) VALUES (:username,:password) ";
        $stmt_NewAccount=$pdo->prepare($sql_NewAccount);
        $stmt_NewAccount->execute([
            ':username'=>$user,
            ':password'=>$hash
        ]);
        $message="登録に成功しました．ログインページでログインしてください";
    
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
<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-md mx-auto">
<h1 class="flex items-center  text-4xl font-bold text-center my-6">
  <span class="flex-grow h-px bg-gray-300"></span>
  <span class="px-4">My掲示板</span>
  <span class="flex-grow h-px bg-gray-300"></span>
</h1>
<div class="max-w-md mx-auto mt-10">
<h2 class="text-xl font-bold">新規作成ページ</h2>

<div class="bg-gray-50 p-8 rounded-lg shadow-md top-4">
  <div class="text-center mt-4">  
<?php if($error!=="") echo "<p style='color:red;'> $error</p>" ?>
<?php if($message!=="") echo "<p style='color:green;'> $message</p>" ?>
</div>
<form method="POST">
<li style="list-style:none;">
    新規ユーザ名<input type="text" name="username"  placeholder="例)山田太郎" value="<?= $input_username ?>" class="appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"><br>
    新規パスワード<input type="password" name="password" placeholder="＊＊＊" class="appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
</li>
</div>
<br><button type="submit" name="registar" class="w-full h-12 overflow-hidden rounded bg-green-500 px-5 py-2.5 text-white transition-all duration-300 hover:bg-green-800 hover:ring-2 hover:ring-neutral-800 hover:ring-offset-2">新規作成</button>
</form>
<div class="text-center mt-4">
<u><a href="Myboard_login.php" class="p-2 text-blue-500">キャンセル</a></u>
</div>
</div>
</div>