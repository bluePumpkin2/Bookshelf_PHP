<?php
session_set_cookie_params(0);
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login']) == false){
    print 'ログインされていません。<br>';
    print '<a href="../login/login.html">ログイン画面へ</a>';
    exit();
}else{
    print $_SESSION['user_name'];
    print 'さんログイン中<br>';
    print '<br>';
}
?>

<?php require '../common/header.php'; ?>

<?php
require_once(__DIR__.'/../common/func.php');
$_POST = es($_POST);

$title = $_POST['title'];
$author = $_POST['author'];
$genre = $_POST['genre'];
$date = $_POST['date'];
$rating = $_POST['rating'];
$report = $_POST['report'];
$image_name = $_POST['image_name'];
$image_tmpname = $_POST['image_tmpname'];
$image_size = $_POST['image_size'];
$image_type = $_POST['image_type'];
$url = $_POST['url'];

if($title == ''){
    print 'タイトルが入力されていません。<br>';
    print '<form>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '</form>';
}else{
    if($image_size > 0){
        if($image_size > 10000000){
            print '画像のサイズが大き過ぎます。<br>';
            print '<input type="button" onclick="history.back()" value="戻る">';
            exit();
        }else{
            /*
            if(!file_exists("./{$_SESSION['user_name']}_book_images")){
                mkdir("./{$_SESSION['user_name']}_book_images");
                copy('./noimage.png', "./{$_SESSION['user_name']}_book_images/noimage.png");
            }
            move_uploaded_file($image_tmpname,"./{$_SESSION['user_name']}_book_images/".$image_name);
            */

            ImageResize($image_type, "./{$_SESSION['user_name']}_book_images/".$image_name, 250, 300, 100);
        }
    }

    /*
    else{
        if(!file_exists("./{$_SESSION['user_name']}_book_images")){
            mkdir("./{$_SESSION['user_name']}_book_images");
            copy('./noimage.png', "./{$_SESSION['user_name']}_book_images/noimage.png");
        }
        $image = [];
        $image_name = 'noimage.png';
    }
    */
    print 'この内容でよろしいですか？<br><br>';

    print '<img src="./'.$_SESSION['user_name'].'_book_images/'.$image_name.'"><br>';
    print 'タイトル：' .$title. '<br>';
    print '著者：' .$author. '<br>';
    print 'ジャンル：' .$genre. '<br>';
    print '読んだ日：' .$date. '<br>';
    print '評価：' .$rating. '<br>';
    print '感想：' .$report. '<br>';
    print 'URL：' .$url. '<br>';
    
    print '<form method="post" action="book_add_done.php">';
    print '<input type="hidden" name="title" value="'.$title.'">';
    print '<input type="hidden" name="author" value="'.$author.'">';
    print '<input type="hidden" name="genre" value="'.$genre.'">';
    print '<input type="hidden" name="date" value="'.$date.'">';
    print '<input type="hidden" name="rating" value="'.$rating.'">';
    print '<input type="hidden" name="report" value="'.$report.'">';
    print '<input type="hidden" name="image" value="'.$image_name.'">';
    print '<input type="hidden" name="url" value="'.$url.'">';
    print '<br>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '<input type="submit" value="OK">';
    print '</form>';
}
?>

<?php require '../common/footer.php'; ?>