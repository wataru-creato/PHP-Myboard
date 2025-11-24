
<?php
session_start();
require_once "DBconnect.php";

$user=$_SESSION["login_user"];


if($_SERVER["REQUEST_METHOD"]==="POST"){
    $comment=trim($_POST["comment"]);

    if($comment!==""){
        $stmt=$pdo->prepare("INSERT INTO posts (user,content) VALUES(:user,:content)");

        $stmt->execute([":user"=>$user,":content"=>$comment]);
    }
}

$stmt = $pdo->query("SELECT * FROM posts ORDER BY id DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h2>掲示板</h2>

<p>ログイン中ユーザ：<?php echo htmlspecialchars($user,ENT_QUOTES) ?></p>



<form method="POST">
    <textarea name="comment" rows="3" cols="50"></textarea>
    <input type="submit" value="送信">
</form>
<hr>
<ul>

<?php foreach ($posts as $p): ?>
    <li>
        名前：<?php echo htmlspecialchars($p["user"], ENT_QUOTES); ?><br>
        投稿日：<?php echo htmlspecialchars($p["created_at"], ENT_QUOTES); ?><br>
        コメント：<?php echo nl2br(htmlspecialchars($p["content"], ENT_QUOTES)); ?>
        <hr>
    </li>
<?php endforeach; ?>
</ul>

<p><a href="logout.php">ログアウト</a></p>