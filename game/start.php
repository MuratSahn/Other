<?php
    ob_start();
    require_once("connect.php");
    $kisiler_result = mysqli_query($conn, "SELECT * FROM `gkullanici`");
    $kisiler = mysqli_fetch_all($kisiler_result, MYSQLI_ASSOC);

    session_start();
    $kont = false;
    foreach ($kisiler as $kisi) {
        if($_SESSION['ad'] == $kisi['ad'] && $kisi['oyun'] == 1){
            $kont = true;
            break;
        }
    }
    if(!$kont){
        header('location:index.php');
        exit();
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!--CSS-->
    <style type="text/css">
        @keyframes hazir-animation {
            0%{font-size: 1em;}
            50%{font-size: 3.5em;}
            100%{font-size: 3em;}
        }
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: sans-serif;
        }
        .container {
            width: 80%;
            height: 90%;
            display: grid;
            grid-template-columns: 1fr;
            padding: 10px;
            grid-column-gap: 20px;
        }
        

        
        .game {
            display: grid;
            grid-template-rows: 70px 1fr;
            grid-row-gap: 20px;
        }
        /*GAME HEADER*/
        .game .header {
            display: grid;
            grid-template-columns: 200px 1fr;
            border: 1px solid black;
        }
        .game .header .ben {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
        }
        .game .header .cikis {
            display: flex;
            justify-content: end;
            align-items: center;
            padding-right: 80px;
        }
        .game .header .cikis form input {
            width: 100px;
            height: 30px;
            border: 1px solid blue;
            border-radius: 10px;
            background-color: white;
        }



        /*GAME CONTENT*/
        .game .gcontent {
            border: 1px solid black;
            display: grid;
        }

        .game .content .main-hazir{
            font-size: 3em;
        }
        .acilirm{
            display: none;
        }


        @media only screen and (max-width:768px){
            body{
                margin: 0;
                padding: 0;
                height: calc(var(--vh) * 98);
            }
            .container{
                width: 100%;
                height: 100%;
                grid-template-columns: 1fr;
                margin-top: 8px;
            }
            .game .header .ben {
                display: flex;
                align-items: center;
                justify-content: start;
                font-size: 1.5em;
                margin-left: 80px;
            }
            .acilirm{
                display: grid;
                grid-template-rows: 50px 30px 1fr;
                grid-row-gap: 20px;
                width: 40px;
                height: 40px;
                border: 1px solid black;
                margin-left: 10px;
                position: absolute;
                margin-top: 20px;
                justify-items: center;
                overflow: hidden;
            }
            .acilir-menu-baslik{
                grid-row: 2;
            }
            .acilir-menu-kisiler{
                border: 1px solid black;
                grid-row: 3;
                width: 95%;
            }
            .kisi-ad{
                display: flex;
            }
            .game .header .cikis {
                padding-right: 10px;
                color: black;
            }
            .game .header .cikis form input {
                color: black;
            }
            .durum-acik{
                background-color: green;
                width: 10px;
                height: 10px;
                border-radius: 10px;
            }
            .durum-kapali{
                background-color: red;
                width: 10px;
                height: 10px;
                border-radius: 10px;
            }
            .durum-hazir{
                background-color: blue;
                width: 10px;
                height: 10px;
                border-radius: 10px;
            }
            .durum-oyun {
                width: 10px;
                height: 10px;
                background-color: rgb(200, 150, 50);
                border-radius: 10px;
            }
        }
    </style>
</head>
<body>



    <!--CONTAİNER-->
    <div class="container">

        <!--GAME-->
        <div class="game">

            <!--GAME HEADER-->
            <div class="header">


                <!--AÇILIR MENÜ-->
                <div class="acilirm">
                    <p class ="acilir-menu-baslik">Kişiler</p>
                    <div class = "acilir-menu-kisiler">
                        <?php
                            $kisiler_result = mysqli_query($conn, "SELECT * FROM `gkullanici`");
                            $kisiler = mysqli_fetch_all($kisiler_result, MYSQLI_ASSOC);
                            $durum = 0;
                            foreach ($kisiler as $kisi) {
                                if ($kisi['ad'] == $_SESSION['ad']) {
                                    continue;
                                }
                                else if ($kisi['giris'] == 0) {
                                    echo "<div class='kisi-ad'>".$kisi['ad']."<div class='durum-kapali'></div></div>";
                                }
                                else if ($kisi['giris'] == 1) {
                                    if($kisi['oyun'] == 1){
                                        echo "<div class='kisi-ad'>".$kisi['ad']."<div class='durum-oyun'></div></div>";
                                        $durum = 1;
                                    }
                                    else if($kisi['durum'] == 1){
                                        echo "<div class='kisi-ad'>".$kisi['ad']."<div class='durum-hazir'></div></div>";
                                        $durum = 1;
                                    }
                                    else{
                                        echo "<div class='kisi-ad'>".$kisi['ad']."<div class='durum-acik'></div></div>";
                                        $durum = 0;
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>


                <!--BEN-->
                <div class="ben"><?php echo $_SESSION['ad'];?></div>


                <!--ÇIKIŞ-->
                <div class="cikis">
                    <form action="game.php" method="POST">
                        <input type="submit" name="cikis" value="Çıkış yap">
                    </form>
                    <?php
                        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                            if (isset($_POST["cikis"])) {
                                mysqli_query($conn, "UPDATE `gkullanici` SET `giris`='0',`durum`='0',`oyun`='0',`katil`='0' WHERE ad = '$_SESSION[ad]'");
                                session_destroy();
                                header("location:index.php");
                                exit();
                            }
                        }
                    ?>
                </div>
            </div>

            <!--GAME CONTENT-->
            <div class="gcontent">
                <?php
                    $kisisay = 0;
                    foreach ($kisiler as $kisi) {
                        if($kisi['oyun'] == '1'){
                            $kisisay +=1;
                        }
                    }
                    if($kisisay < 3){
                        mysqli_query($conn,"UPDATE `gkullanici` SET `durum`='0',`oyun`='0',`katil`='0'");
                        header("location:index.php");
                    }
                ?>
            </div>
        </div>
    </div>




    <script>
        window.addEventListener("load",function(){
            document.documentElement.style.setProperty("--vh", window.innerHeight *0.01 + "px");
        });
    </script>

    <script>
        let acilirm =document.querySelector(".acilirm");
        let aclick = false;

        acilirm.addEventListener("click",function(){
            if(!aclick){
                acilirm.style.width = "150px";
                acilirm.style.height = "500px";
                acilirm.style.border = "0";
            }
            else{
                acilirm.style.width = "";
                acilirm.style.height = "";
                acilirm.style.border = "";
            }
            aclick = !aclick;
        });
    </script>


</body>
</html>
<?php
    ob_end_flush();
?>