<?php
session_start();
$_SESSION = array();
if(isset($_COOKIE[session_name()]) == true){
    setcookie(session_name(), '', time()-42000, '/');
}
session_destroy();
?>
<?php require '../common/header.php'; ?>
<?php
try{
    $name = $_POST['name'];
    
    $dsn = 'mysql:dbname=mylibrary;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_delete_sql = "DELETE FROM user WHERE name=?";
    $stmt = $dbh -> prepare($user_delete_sql);
    $data[] = $name;
    $stmt -> execute($data);

    $table_delete_sql = "DROP TABLE {$name}_books";
    $stmt = $dbh -> prepare($table_delete_sql);
    $stmt -> execute();

    $dbh = null;

    function remove_directory($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            // ファイルかディレクトリによって処理を分ける
            if (is_dir("$dir/$file")) {
                // ディレクトリなら再度同じ関数を呼び出す
                remove_directory("$dir/$file");
            } else {
                // ファイルなら削除
                unlink("$dir/$file");
                echo "ファイル:" . $dir . "/" . $file . "を削除";
                echo '<br>';
            }
        }
        // 指定したディレクトリを削除
        echo "ディレクトリ:" . $dir . "を削除";
        echo '<br>';
        return rmdir($dir);
    }

    if(is_dir("../book/{$name}_book_images")){
        remove_directory("../book/{$name}_book_images");
    }
}
catch(Exception $e){
    print 'ただいま障害が発生しております。ご迷惑をお掛けして申し訳ございません。';
    exit();
}
?>

退会が完了しました。<br>
<button onclick="location.href='../login/login.html'">終了</button>
<?php require '../common/footer.php'; ?>