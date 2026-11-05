<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Game</title>
	<style type="text/css">
		*{
			margin: 0;
			padding: 0;
			font-family: sans-serif;
		}
		html{
			background: ghostwhite;
		}
		.container {
			width: 100%;
			display: flex;
			align-items: center;
			justify-content: center;
			margin-top: 7%;
		}
		.giris {
			width: 30%;
			height: 450px;
			border-radius: 10px;
			box-shadow: 1px 1px 10px grey;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: white;
		}
		.giris form{
			display: flex;
			flex-direction: column;
			align-items: center;
			width: 100%;
			padding-top: 20px;
			background: white;
			border-radius: 15px;
		}
		.giris form .yaz {
			width: 83%;
			padding: 13px;
			margin-top: 10px;
			border-radius: 10px;
			border: 1px solid gainsboro;
			font-size: 20px;
		}
		.giris form .submit {
			width: 80%;
			padding: 9px;
			border-radius: 10px;
			border: 1px solid blue;
			background: blue;
			margin-top: 25px;
			font-size: 1.75em;
			color: white;
		}
		.giris form .submit:hover{
			cursor: pointer;
		}
		.giris a{
			margin-top: 25px;
			text-decoration: none;
			color: blue;
		}
		.giris form hr{
			width: 85%;
			margin-top: 30px;
		}
		.giris .kayit{
			width: 55%;
			padding: 15px;
			border-radius: 5px;
			background: lime;
			text-align: center;
			text-decoration: none;
			margin-top: 20px;
			font-size: 1.25em;
			color: white;
			border: 0;
		}
		.giris .kayit:hover{
			cursor: pointer;
		}


		@media only screen and (max-width: 1100px){
			html {
				font-size: 0.8em;
			}
			.giris {
				width: 80%;
			}
		}
		@media only screen and (max-width: 550px){
			.container{
				margin-top: 25%;
			}
			.giris .kayit{
				font-size: 0.9em;
			}
		}
	</style>
</head>
<body>
<?php
	session_start();
	require_once("connect.php");
	
	if(isset($_SESSION['message'])){
		$hata = $_SESSION['message'];
		session_destroy();
	}
	else if (isset($_SESSION['ad'])) {
		header('location: game.php');
		exit();
	}
 ?>
<div class="container">
	<div class="giris">
		<form action="index.php" method="post">
			<input class="yaz" type="text" name="ad" placeholder="İsim">
			<input class="yaz" type="password" name="sifre" placeholder="Şifre">
			<input class="submit" type="submit" name="gonder" value="Giriş Yap">
			<a href="">Şifrenizi mi unuttunuz?</a>
			<hr>
			<input type="submit" name="kayit" class="kayit" value="Yeni hesap oluştur">
		</form>
		<?php
			if(isset($hata)){
				echo $hata;
				$hata = "";
			}
		?>
		<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				$ad = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['ad']));
				$sifre = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['sifre']));
				$takim = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['takim']));

				$_SESSION['ad'] = $ad;
				$_SESSION['sifre'] = $sifre;

				$kullanicilar_query = mysqli_query($conn, "SELECT * FROM `gkullanici`");
				$kullanicilar = mysqli_fetch_all($kullanicilar_query, MYSQLI_ASSOC);

				if (isset($_POST['gonder'])) {
					$kontrol = 0;
					if (strlen($ad) >=3 && strlen($sifre)>=8) {
						for ($i=0; $i < count($kullanicilar); $i++) { 
							if ($ad == $kullanicilar[$i]['ad'] && $sifre == $kullanicilar[$i]['sifre']) {
								if($kullanicilar[$i]['giris'] == '1') {
									$_SESSION['message'] = "<span style = 'color:red; margin-top:30px;'>Zaten giriş yapılmış</span>";
									header("location:index.php");
									exit();
								}
								$kontrol = 1;
								break;
							}
						}
						if ($kontrol) {
							mysqli_query($conn, "UPDATE `gkullanici` SET `giris`='1' WHERE ad = '$ad'");
							header("location:game.php");
							
						}

						else{
							$_SESSION['message'] = "<span style = 'color:red; margin-top:30px;'>Kullanıcı adı veya şifre hatalı</span>";
							header("location:index.php");
							exit();
						}
					}
					else {
						$_SESSION['message'] = "<span style = 'color:red; margin-top:30px;'>Lütfen isim ve şifre için geçerli bilgiler girin</span>";
						header("location:index.php");
						exit();
					}
				}
				
				elseif(isset($_POST['kayit'])){
					$kontrol = 0;
					if (strlen($ad)>=3 && strlen($sifre)>=8) {
						for ($i=0; $i < count($kullanicilar); $i++) { 
							if ($kullanicilar[$i]['ad'] == $ad) {
								$kontrol = 1;
								break;
							}		
						}
						if ($kontrol) {
							$_SESSION['message'] = "<span style = 'color:red; margin-top:30px;'>Böyle bir kullanıcı zaten var</span>";
							header("location:index.php");
							exit();
						}
						else {
							mysqli_query($conn, "INSERT INTO `gkullanici`(`ad`, `sifre`,`giris`) VALUES ('$ad','$sifre','0')");
							mysqli_query($conn, "UPDATE `gkullanici` SET `giris`='1' WHERE ad = '$ad'");
							header("location:game.php");
							exit();
						}
					}
					elseif(strlen($_POST['sifre'])<8){
						$_SESSION['message'] = "<span style = 'color:red; margin-top:30px;'>Şifreniz en az 8 haneden oluşmalıdır</span>";
						header("location:index.php");
						exit();
					}
					else{
						$_SESSION['message'] = "<span style = 'color:red; margin-top:30px;'>Lütfen isim ve şifre için geçerli bilgiler girin</span>";
						header("location:index.php");
						exit();
					}
				}
			}
		 ?>
	</div>
</div>
</body>
</html>