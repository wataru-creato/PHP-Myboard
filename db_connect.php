<?php

$dsn="mysql:host=localhost;dbname=php_app;charset=utf8";
$host="localhost";
$dbname="php_app";
$user="root";
$pass="83018042wtr&MySQL!";

try{
    $pdo=new PDO($dsn,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $stmt=$pdo->query("SELECT *FROM posts ORDER BY id DESC");
    $posts=$stmt->fetchALL(PDO::FETCH_ASSOC);
    echo"接続成功";

}catch(PDOException $e){
    echo"Database Error:".$e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>投稿一覧</title>
</head>
<body>
    <h1>投稿一覧</h1>

    <?php foreach ($posts as $post): ?>
        <div>
            <p><strong><?php echo htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
            <p><?php echo nl2br(htmlspecialchars($post['comment'], ENT_QUOTES, 'UTF-8')); ?></p>
            <hr>
        </div>
    <?php endforeach; ?>
</body>
</html>