<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
        body{
            margin: 0;
            padding: 10px;
            font-family: sans-serif;
        }
    </style>
</head>
<body>
    <form action="a.php" method="POST" enctype="multipart/form-data">
        <input type="file" name = "file">
        <input type="submit">
    </form>
    <?php
    session_start();
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK){
                $mime_type=mime_content_type($_FILES['file']['tmp_name']);
                if($mime_type == "image/jpeg"){
                    if($_FILES['file']['size'] <= 1024*1024){
                        $name = $_FILES['file']['name'];
                        $ad = ["ar","xt","kt","ze"];
                        $sayi = rand(0,10000);
                        $uzanti = pathinfo($name, PATHINFO_EXTENSION);
                        $newname = __DIR__ . '/'.$ad[rand(0,3)].$sayi.'.'.$uzanti;

                        if(move_uploaded_file($_FILES['file']['tmp_name'], $newname)){
                            $_SESSION['message'] = "Başarılı";
                            header("location:a.php");
                            exit;
                        }
                        else{
                            $_SESSION['message'] = "Başarısız";
                            header("location:a.php");
                            exit;
                        }
                    }
                    else{
                        $_SESSION['message'] = "Dosya boyutu en çok 1 MB olmalı";
                        header("location:a.php");
                        exit;
                    }
                }
                else{
                    $_SESSION['message'] = "Dosya uzantısı jpeg olmalı";
                    header("location:a.php");
                    exit;
                }
            }
            else{
                $_SESSION['message'] = "Dosya seç";
                header("location:a.php");
                exit;
            }
        }
        if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
            session_destroy();
        }
    ?>
</body>
</html>