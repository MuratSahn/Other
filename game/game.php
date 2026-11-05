<?php
    ob_start();
    require_once("connect.php");
    session_start();

    // Eğer AJAX ile checkReady isteği gönderildiyse (ADIM 2'deki KOD)
    if (isset($_POST['checkReady'])) {
        $kisiler_result = mysqli_query($conn, "SELECT * FROM `gkullanici` WHERE `giris` = '1'");
        $kisiler = mysqli_fetch_all($kisiler_result, MYSQLI_ASSOC);

        $everyoneReady = true;

        foreach ($kisiler as $kisi) {
            if ($kisi['durum'] == '0') {
                $everyoneReady = false;
                break;
            }
        }

        // Sonucu JSON olarak döndür
        echo json_encode(['allReady' => $everyoneReady]);
        exit(); // Diğer sayfa yüklenmesin
    }

    // Kişilerin oturum açıp açmadığını kontrol ediyoruz
    $kisiler_result = mysqli_query($conn, "SELECT * FROM `gkullanici`");
    $kisiler = mysqli_fetch_all($kisiler_result, MYSQLI_ASSOC);

    $kont = false;
    foreach ($kisiler as $kisi) {
        if ($_SESSION['ad'] == $kisi['ad']) {
            $kont = true;
            break;
        }
    }
    if (!$kont) {
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
            grid-template-columns: 130px 7fr;
            padding: 10px;
            grid-column-gap: 20px;
        }
        .kisiler {
            border: 1px solid black;
            display: grid;
            grid-template-rows: 50px 1fr;
            grid-row-gap: 20px;
        }
        .kisiler .kisiler-baslik {
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            font-size: 1.5em;
        }
        .acilir-menu{
            display: none;
        }
        .kisiler .kisi {
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
        }
        .kisiler .kisi-ad {
            display: flex;
            width: 100%;
            margin-bottom: 10px;
            padding-left: 50px;
            height: 15px;
        }
        .kisiler .kisi-ad .durum-kapali {
            width: 10px;
            height: 10px;
            background-color: red;
            border-radius: 10px;
            margin-left: 10px;
        }
        .kisiler .kisi-ad .durum-acik {
            width: 10px;
            height: 10px;
            background-color: green;
            border-radius: 10px;
            margin-left: 10px;
        }
        .kisiler .kisi-ad .durum-hazir {
            width: 10px;
            height: 10px;
            background-color: blue;
            border-radius: 10px;
            margin-left: 10px;
        }
        .kisiler .kisi-ad .durum-oyun {
            width: 10px;
            height: 10px;
            background-color: rgb(200, 150, 50);
            border-radius: 10px;
            margin-left: 10px;
        }
        .game {
            display: grid;
            grid-template-rows: 70px 1fr;
            grid-row-gap: 20px;
        }
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
        .game .content {
            border: 1px solid black;
            display: grid;
            grid-template-rows: 1fr 80px;
        }
        .game .content .main {
            border-bottom: 1px solid black;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .game .content .main .main-hazir{
            font-size: 3em;
        }
        .game .content .content-footer {
            display: flex;
            align-items: center;
            justify-content: center;
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
            .kisiler{
                display: none;
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


        <!--KİSİLER-->
        <div class="kisiler">
            <div class="kisiler-baslik">Kişiler</div>
            <div class="kisi" id="kisi-listesi">
                <?php
                    $kisiler_result = mysqli_query($conn, "SELECT * FROM `gkullanici`");
                    $kisiler = mysqli_fetch_all($kisiler_result, MYSQLI_ASSOC);
                    $durum = 0;
                    foreach ($kisiler as $kisi) {
                        if ($kisi['ad'] == $_SESSION['ad']) {
                            continue;
                        }
                        else if ($kisi['giris'] == '0') {
                            echo "<div class='kisi-ad'>".$kisi['ad']."<div class='durum-kapali'></div></div>";
                        }
                        else if ($kisi['giris'] == '1') {
                            if($kisi['oyun'] == '1'){
                                echo "<div class='kisi-ad'>".$kisi['ad']."<div class='durum-oyun'></div></div>";
                                $durum = 1;
                            }
                            else if($kisi['durum'] == '1'){
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
            <div class="content">


                <!--MAİN-->
                <div class="main" id="main-content">
                    <?php
                        $hkont = false;
                        foreach ($kisiler as $kisi) {
                            if($kisi['ad'] == $_SESSION['ad']){
                                if($kisi['durum'] == '1'){
                                    $hkont=true;
                                }
                            }
                        }
                        $dkont = true;
                        for($i=0;$i<count($kisiler);$i++){
                            if($kisiler[$i]['giris'] == '0'){
                                continue;
                            }
                            else if($kisiler[$i]['durum'] == "0"){
                                $dkont = false;
                                break;
                            }
                        }
                        
                        if($dkont){
                            $okont = false;
                            foreach($kisiler as $kisi){
                                if($kisi['oyun'] == '1'){
                                    $okont = true;
                                    break;
                                }
                            }
                            if($okont == false){
                                mysqli_query($conn,"UPDATE `gkullanici` SET `oyun` = '1' WHERE `giris` = '1'"); 
                            }        
                        }
                        
                        for($i=0;$i<count($kisiler);$i++){
                            if($kisiler[$i]['oyun'] == '1' && $kisiler[$i]['giris'] == '1'){                          
                                header('location:start.php');
                                exit();
                            }
                            else if($kisiler[$i]['durum'] == '1' && $kisiler[$i]['giris'] == '1'){
                                if($kisiler[$i]['ad'] == $_SESSION['ad']){
                                    echo "<div class ='main-hazir'>Hazır</div>";
                                }
                            }                             
                        }
                    ?>
                </div>


                <!--CONTENT FOOTER-->
                <div class="content-footer">
                    <form action="game.php" method="POST">
                        <input type="submit" value="Hazır" name="hazir" id="hazir">
                        <input type="submit" value="İptal" name="iptal" id="iptal">
                    </form>
                    <?php
                        if($_SERVER['REQUEST_METHOD'] == "POST"){
                            if(isset($_POST['hazir'])){
                                mysqli_query($conn,"UPDATE `gkullanici` SET `durum`='1' WHERE ad = '$_SESSION[ad]'");
                            }
                            else if(isset($_POST['iptal'])){
                                mysqli_query($conn,"UPDATE `gkullanici` SET `durum`='0' WHERE ad = '$_SESSION[ad]'");
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>




    <script>
        window.addEventListener("load",function(){
            document.documentElement.style.setProperty("--vh", window.innerHeight *0.01 + "px");
        });
        function fetchContent() {
            $.ajax({
                url: 'game.php',
                method: 'POST',
                data: { refreshContent: true },
                success: function(data) {
                    const kisiler = $(data).find('#kisi-listesi').html();
                    $('#kisi-listesi').html(kisiler);

                    const mainContent = $(data).find('#main-content').html();
                    $('#main-content').html(mainContent);

                    const acilirmkisiler = $(data).find('.acilir-menu-kisiler').html();
                    $('.acilir-menu-kisiler').html(acilirmkisiler);
                },
                error: function(xhr, status, error) {
                    console.error('Hata:', status, error);
                }
            });
        }

        $(document).ready(function() {
            setInterval(fetchContent, 500);
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

    <script>
        function checkIfEveryoneIsReady() {
            $.ajax({
                url: 'game.php', // Aynı sayfada AJAX işlemi
                method: 'POST',
                data: { checkReady: true }, // Hazır olup olmadığını kontrol et
                dataType: 'json', // JSON formatında sonuç bekleniyor
                success: function(response) {
                    if (response.allReady) {
                        // Eğer tüm kullanıcılar hazırsa yönlendirme yapılır
                        window.location.href = "start.php";
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Hata:', status, error);
                }
            });
        }

        $(document).ready(function() {
            setInterval(checkIfEveryoneIsReady, 500); // 500ms'de bir kontrol edilir
        });
    </script>
</body>
</html>
<?php
    ob_end_flush();
?>