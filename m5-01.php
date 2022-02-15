<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-01</title>
</head>
<body>
    <?php   /*DB接続設定*/
            $dsn = 'mysql:dbname=*****;host=localhost';
            $user = 'tb-*****';
            $user_password = '*****';
            $pdo = new PDO($dsn, $user, $user_password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            /*新規表作成*/
            $sql = "CREATE TABLE IF NOT EXISTS tbboard1"
            ."("
            ."id INT AUTO_INCREMENT PRIMARY KEY,"
            ."name char(32),"
            ."comment TEXT,"
            ."date INT,"
            ."password INT"
            .");";
            $stmt = $pdo->query($sql);
            /*新規入力機能*/
            if (isset($_POST["nm"]) && isset($_POST["co"]) && empty($_POST["num"]) && empty($_POST["ed"]) && empty($_POST["edittt"]) && isset($_POST["pw"])){
                $nm = $_POST["nm"];
                $co = $_POST["co"];
                $pw = $_POST["pw"];
                $sql = $pdo -> prepare("INSERT INTO tbboard1 (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
                $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                $sql -> bindParam(':password', $password, PDO::PARAM_STR);
                $name = $nm; // 名前の保存
                $comment = $co; // コメントの保存
                $date = date("Y-m-d H:i:s"); // 日時の保存
                $password = $pw; // パスワードの保存
                $sql -> execute();
            }
            /*削除機能*/
            elseif (isset($_POST["num"]) && isset($_POST["delete"]) && isset($_POST["pwdel"])){
                $num = $_POST["num"];
                $pwdel = $_POST["pwdel"];
                $sql = 'delete from tbboard1 where id=:id && password=:password' ;
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $num, PDO::PARAM_INT);
                $stmt->bindParam(':password', $pwdel, PDO::PARAM_STR);
                $stmt->execute();
            }
            /*再表示機能*/
            elseif (isset($_POST["ed"]) && isset($_POST["edit"]) && empty($_POST["edittt"]) && isset($_POST["pwedi"])){
                $ed = $_POST["ed"];
                $pwedi = $_POST["pwedi"];
                $sql = 'SELECT * FROM tbboard1 where id=:id && password=:password' ;
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $ed, PDO::PARAM_INT);
                $stmt->bindParam(':password', $pwedi, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                /* $rowの中にはテーブルのカラム名が入る*/
                $newed=$row['id'];
                $newnm=$row['name'];
                $newco=$row['comment'];
                }
            }
            /*編集機能*/
            elseif(isset($_POST["nm"]) && isset($_POST["co"]) && empty($_POST["num"]) && empty($_POST["ed"]) && isset($_POST["edittt"]) && isset($_POST["pw"])){
                $nm = $_POST["nm"];
                $co = $_POST["co"];
                $edittt = $_POST["edittt"];
                $pw = $_POST["pw"];
                $date = date("Y-m-d H:i:s");
                $sql = 'UPDATE tbboard1 SET name=:name,comment=:comment,date=:date,password=:password WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $nm, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $co, PDO::PARAM_STR);
                $stmt->bindParam(':password', $pw, PDO::PARAM_STR);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->bindParam(':id', $edittt, PDO::PARAM_INT);
                $stmt->execute();
            }
    ?>
    <form action="" method="post">
        <input type="text" name="nm" placeholder="名前" value="<?php if(isset($newnm)) {echo $newnm;} ?>"><br>
        <input type="text" name="co" placeholder="コメント" value="<?php if(isset($newco)) {echo $newco;} ?>"><br>
        <input type="text" name="pw" placeholder="パスワード">
        <input type="hidden" name="edittt" value="<?php if(isset($newed)){echo $newed;}?>"><br>
        <input type="submit" name="submit"><br><br>
        <input type="number" name="num" placeholder="削除行番号"><br>
        <input type="text" name="pwdel" placeholder="パスワード"><br>
        <input type="submit" name="delete" value="削除"><br><br>
        <input type="number" name="ed" placeholder="編集行番号"><br>
        <input type="text" name="pwedi" placeholder="パスワード"><br>
        <input type="submit" name="edit" value="編集">
    </form>
    <?php
            /*表示機能*/
            $sql = 'SELECT * FROM tbboard1';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                /* $rowの中にはテーブルのカラム名が入る*/
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['date'].'<br>';
                /*
                echo $row['password'].','.'<br>';
                */
                echo "<hr>";
            }
    ?>
</body>
</html>