<?php
session_set_cookie_params(0);
session_start();
session_regenerate_id(true);
require_once(__DIR__.'/../common/func.php');
$_POST = es($_POST);

if(isset($_POST['back_bookshelf'])){
    print '<body onload="document.FRM.submit()">';
    print '<form name="FRM" method="post" action="bookshelf.php">';
    print '<input type="hidden" name="sort" value="id">';
    print '</form>';
    //header('Location: bookshelf.php');
    exit();
}

if(isset($_POST['to_book_add_check'])){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $date = $_POST['date'];
    $rating = $_POST['rating'];
    $report = $_POST['report'];
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_tmpname = $image['tmp_name'];
    $image_size = $image['size'];
    $image_type = $image['type'];
    $url = $_POST['url'];

    if($image_size > 0){
        if($image_size > 10000000){
            ;
        }else{
            if(!file_exists("./{$_SESSION['user_name']}_book_images")){
                mkdir("./{$_SESSION['user_name']}_book_images");
                copy('./noimage.png', "./{$_SESSION['user_name']}_book_images/noimage.png");
            }
            move_uploaded_file($image_tmpname,"./{$_SESSION['user_name']}_book_images/".$image_name);
        }
    }else{
        if(!file_exists("./{$_SESSION['user_name']}_book_images")){
            mkdir("./{$_SESSION['user_name']}_book_images");
            copy('./noimage.png', "./{$_SESSION['user_name']}_book_images/noimage.png");
        }
        $image = [];
        $image_name = 'noimage.png';
    }
    
    print '<body onload="document.FRM.submit()">';
    print '<form name="FRM" method="post" action="book_add_check.php">';
    print '<input type="hidden" name="title" value="'.$title.'">';
    print '<input type="hidden" name="author" value="'.$author.'">';
    print '<input type="hidden" name="genre" value="'.$genre.'">';
    print '<input type="hidden" name="date" value="'.$date.'">';
    print '<input type="hidden" name="rating" value="'.$rating.'">';
    print '<input type="hidden" name="report" value="'.$report.'">';
    print '<input type="hidden" name="image_name" value="'.$image_name.'">';
    print '<input type="hidden" name="image_tmpname" value="'.$image_tmpname.'">';
    print '<input type="hidden" name="image_size" value="'.$image_size.'">';
    print '<input type="hidden" name="image_type" value="'.$image_type.'">';
    print '<input type="hidden" name="url" value="'.$url.'">';
    print '</form>';
    exit();
}

if(isset($_POST['to_book_delete_done'])){
    $book_id = $_POST['book_id'];
    $image = $_POST['image'];

    print '<body onload="document.FRM.submit()">';
    print '<form name="FRM" method="post" action="book_delete_done.php">';
    print '<input type="hidden" name="image" value="'.$image.'">';
    print '<input type="hidden" name="book_id" value="'.$book_id.'">';
    print '</form>';
    exit();
}

if(isset($_POST['to_book_edit_check'])){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $date = $_POST['date'];
    $rating = $_POST['rating'];
    $report = $_POST['report'];
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_tmpname = $image['tmp_name'];
    $image_size = $image['size'];
    $image_type = $image['type'];
    $url = $_POST['url'];
    $delete = $_POST['delete'];
    $old_image = $_POST['old_image'];

    if($image_size > 0){
        if($image_size > 10000000){
            ;
        }else{
            move_uploaded_file($image_tmpname, "./{$_SESSION['user_name']}_book_images/".$image_name);
        }
    }    

    print '<body onload="document.FRM.submit()">';
    print '<form name="FRM" method="post" action="book_edit_check.php">';
    print '<input type="hidden" name="title" value="'.$title.'">';
    print '<input type="hidden" name="author" value="'.$author.'">';
    print '<input type="hidden" name="genre" value="'.$genre.'">';
    print '<input type="hidden" name="date" value="'.$date.'">';
    print '<input type="hidden" name="rating" value="'.$rating.'">';
    print '<input type="hidden" name="report" value="'.$report.'">';
    print '<input type="hidden" name="image_name" value="'.$image_name.'">';
    print '<input type="hidden" name="image_tmpname" value="'.$image_tmpname.'">';
    print '<input type="hidden" name="image_size" value="'.$image_size.'">';
    print '<input type="hidden" name="image_type" value="'.$image_type.'">';
    print '<input type="hidden" name="url" value="'.$url.'">';
    print '<input type="hidden" name="delete" value="'.$delete.'">';
    print '<input type="hidden" name="old_image" value="'.$old_image.'">';
    print '</form>';
    exit();
}
?>