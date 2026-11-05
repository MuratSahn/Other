<!DOCTYPE html>
<html>
<head>
	<title>VMuratŞahin</title>
	<style type="text/css">
		* {
			padding: 0;
			margin: 0;
			font-family: sans-serif;
		}

		/*Navbar*/
		.head{
			height: 80px;
			width: 100%;
			background: white;
			display: flex;
			flex-direction: row;
			align-items: center;
			justify-content: space-around;
			box-shadow: 2px 2px 10px grey;
			
		}
		.head ul{
			list-style: none;
			display: flex;
		}
		.head ul li{
			padding: 10px;
			border-radius: 50px;
			border:1px solid gainsboro;
			margin: 5px;
		}
		.head ul li:hover{
			cursor: pointer;
			background: gainsboro;
		}


		/*Alt kısım*/
		.container{
			width: 100%;
			display: flex;
			margin-top: 2%;
			justify-content: center;
		}
		.container #a{
			width: 17%;
			height: 500px;
			display: flex;
			flex-direction: column;			
		}

		.container #a ul{
			list-style: none;
			border-radius: 5px;
			background: white;
			border-left: 1px solid gainsboro;
			border-top: 1px solid gainsboro;
			border-right: 1px solid gainsboro;
		}

		.container #a ul li{
			width: 100%;
			height: 30px;
			white-space: nowrap;
			font-size: 0.9em;
			text-indent: 10px;
			padding-top: 5px;
		}
		.container #a ul li:hover{
			background: gainsboro;
			cursor: pointer;
		}


		.container #b{
			width: 50%;
			height: 500px;
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		.container #b .icerik{
			width: 90%;
			height: 130px;
			border:1px solid gainsboro;
			border-radius: 10px;
			display: flex;
			margin-bottom: 20px;			
		}
		.icerik img{
			height: 100%;
			width: 200px;
			border-radius: 9px;
		}
		.ic{
			display: flex;
			flex-direction: column;
			margin-left: 20px;
			font-size: 0.9em;
			overflow: hidden;
		}
	</style>
</head>
<body>
<?php require_once('config.php'); ?>
<?php

$kurslar = [
	[
		"id" => 1,
		"baslik" => "Masaüstü programlama",
		"aciklama" => "Güzel kurs",
		"resim" => "1.jpeg",
		"onay" => true
	],

	[
		"id" => 2,
		"baslik" => "Mobil programlama",
		"aciklama" => "Güzel kurs",
		"resim" => "2.jpeg",
		"onay" => true
	],

	[
		"id" => 3,
		"baslik" => "Web programlama",
		"aciklama" => "Güzel kurs",
		"resim" => "3.jpeg",
		"onay" => true
	],
];	
$anasayfa = ["Anasayfa","Giriş yap", "Kayıt ol"];
?>
<!-- Navbar -->
<div class="head">
	<h1>Logo</h1>
	<ul>
		<?php foreach($anasayfa as $nav):?>
		<li><?php echo $nav;?></li>
		<?php endforeach;?>
	</ul>
</div>


<!--Ana kısım-->
<?php 
	$result_kategoriler = mysqli_query($baglanti, "Select * from kategori");
	$kategoriler = mysqli_fetch_all($result_kategoriler, MYSQLI_ASSOC);
	$result_kurslar = mysqli_query($baglanti, "Select * from kurslar");
 	$kurslar = mysqli_fetch_all($result_kurslar, MYSQLI_ASSOC);
	mysqli_close($baglanti);
 ?>
<div class="container">
	<div id="a">
		<ul>
			<?php for($i=0;$i<count($kategoriler);$i++):?>
			<li style="border-bottom: 1px solid gainsboro;"><?php echo $kategoriler[$i]["ad"]; ?></li>
			<?php endfor; ?>
		</ul>
	</div>
	<div id="b">
		<?php for($i=0;$i<count($kurslar);$i++): ?>
			<?php if($kurslar[$i]["onay"] == 1): ?>		
				<div class="icerik">
					<img src=<?php echo $kurslar[$i]["resim"]; ?>>
					<div class="ic">
						<h3><?php echo $kurslar[$i]["baslik"]; ?></h3>
						<p><?php echo $kurslar[$i]["aciklama"]; ?></p>	
					</div>			
				</div>
				<?php else: ?>
					<div class="icerik" style="align-items: center; justify-content: center;"><h1>Kurs yok</h1></div>
			<?php endif; ?>
		<?php endfor; ?>
	</div>
</div>

</body>
</html>