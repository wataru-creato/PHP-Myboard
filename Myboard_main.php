<?php
session_start();
require_once "DBconnect.php";

$user=$_SESSION["login_user"];


if($_SERVER["REQUEST_METHOD"]==="POST"){

    if(isset($_POST["submit_comment"])){
    $comment = isset($_POST["comment"]) ? trim($_POST["comment"]) : "";
    if($comment!==""){
        $sql_main="INSERT INTO posts (`username`,`comment`,`created_at`) VALUES (:username,:comment,NOW())";
        $stmt=$pdo->prepare($sql_main);
        $stmt->execute([
            ':username'=>$user,
            ':comment'=>$comment
        ]);
        
    }
}
    //削除ボタン
    if(isset($_POST["delete"])){
        
        $delete_id=(int)$_POST["delete_id"];
        $sql_delete="DELETE FROM posts WHERE id=:id";
        $stmt=$pdo->prepare($sql_delete);
        $stmt->execute([
            ':id'=>$delete_id
        ]);
    }


    if(isset($_POST["update"])){
        $edit_id=(int)$_POST["edit_id"];
        $edit_text=trim($_POST["edit_text"]);

        $sql_edit="UPDATE posts SET `comment`=:comment WHERE id=:id";
        $stmt=$pdo->prepare($sql_edit);
        $stmt->execute([
            ':comment'=>$edit_text,
            ':id'=>$edit_id
        ]);
    }

    if(isset($_POST["cancel"])){              
    }
    
}
$sql_line="SELECT * FROM posts ORDER BY id DESC";
$stmt=$pdo->query($sql_line);
$row=$stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-md mx-auto">
<h1 class="flex items-center  text-4xl font-bold text-center my-6">
  <span class="flex-grow h-px bg-gray-300"></span>
  <span class="px-4">My掲示板</span>
  <span class="flex-grow h-px bg-gray-300"></span>
</h1>

<div class="bg-gray-50 p-6 rounded-lg shadow-md top-1">
<!--投稿ボタン-->
<form method="POST">
    投稿テキスト<textarea placeholder="投稿したい内容を入力" name="comment" rows="2" cols="30" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-20 text-base outline-none text-gray-700 py-1 px-2 resize-y leading-6 transition-colors duration-200 ease-in-out"></textarea><br>
    <div class="text-center mt-4">
    <button type="submit" name="submit_comment" class="h-12 overflow-hidden rounded bg-blue-500 px-3 py-2 text-white transition-all duration-300 hover:bg-blue-800 hover:ring-2 hover:ring-neutral-800 hover:ring-offset-2">投稿する</button>
    </div>
</form>
</div>
<!--投稿一覧のところ-->
<?php foreach($row as $p):?>
<div class="bg-white-50 p-6 rounded-lg shadow-md top-2">

<form method="POST">
   
    <input type="hidden" name="delete_id" value="<?php echo $p["id"]?>">
    <input type="hidden" name="edit_id" value="<?php echo $p["id"]?>">
    <li style="list-style:none;">
  
        ユーザ名：<?php echo htmlspecialchars($p["username"])?>
        <?php echo htmlspecialchars($p["created_at"])?>
    
    <hr class="my-2 border-gray-300">
        <?php echo $p["id"]?>:
        <?php echo htmlspecialchars($p["comment"])?>
        <?php
            if($p["username"]===$user):?>
            <div class="flex justify-end gap-2">
            <button type="submit" name="edit" value="<?php echo $p["id"]?>" class="h-8 overflow-hidden rounded bg-green-700 px-1 py-1 text-white transition-all duration-300 hover:bg-green-800 hover:ring-2 hover:ring-neutral-800 hover:ring-offset-2 item-right">編集</button> 
            <button type="submit" name="delete" onclick="return confirm('テキストの内容「<?php echo htmlspecialchars($p['comment'])?>」\n\n本当に削除しますか？');" class="h-8 overflow-hidden rounded bg-red-500 px-1 py-1 text-white transition-all duration-300 hover:bg-red-800 hover:ring-2 hover:ring-neutral-800 hover:ring-offset-2 item-right justify-end">削除</button>
        </div>
        <?php endif; ?>
    </li>
    
</form>
    </div>

<!--編集するところ-->
<?php if(isset($_POST["edit"]) && $_POST["edit"]==$p["id"]):?>
<div class="bg-gray-100 p-6 rounded-lg shadow-md top-2">
    <form method="POST">
        <input type="hidden" name="edit_id" value="<?php echo $p["id"]?>" >
            編集中・・・<textarea name="edit_text" rows="3" cols="40" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-20 text-base outline-none text-gray-700 py-1 px-2 resize-y leading-6 transition-colors duration-200 ease-in-out"><?php echo htmlspecialchars($p["comment"])?></textarea><br>
            <div class="text-center mt-4">
                <div class="flex justify-center gap-4">
            <button type="submit" name="update" class="h-8 overflow-hidden rounded bg-green-400 px-1 py-1 text-white transition-all duration-300 hover:bg-green-800 hover:ring-2 hover:ring-neutral-800 hover:ring-offset-2 item-right">更新</button>
            <button type="submit" name="cancel" style="background:none; border:none; padding:0; color:blue; text-decoration:underline; cursor:pointer;">キャンセルする</button>
        </div>
        </div>
            <?php
                
            ?>
    </form>
</div>
    <?php endif;?>
    <hr>
<?php endforeach; ?>
<div class="text-center mt-4">
<u><a href="Myboard_logout.php" class="text-blue-500">ログアウトする</a></u>
</div>
</div>

    