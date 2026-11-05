<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Mesaj</title>
	<style type="text/css">
html{
	background: ghostwhite;
}

* {
	padding: 0;
	margin: 0;
	font-family: sans-serif;
}
.container {
	width: 90%;
	display: flex;
	justify-content: center;
}

.ben{
	margin-top: 10px;
	width: 100%;
	margin-bottom: 50px;
	font-size: 1.5em;
	color: white;
	border: 1px solid white;
	border-radius: 10px;
	overflow-wrap: break-word;
	padding: 5px;
	text-align: center;
}
.kisiler {
	width: 8%;
	padding: 7px;
	margin-top: 3%;
	box-sizing: border-box;
	display: flex;
	flex-direction: column;
	align-items: center;
	background: #263238;
}
.kisiler h3{
	color: white;
	font-size: 1.5em;
}
.kisiler form {
	display: flex;
	flex-direction: column;
	align-items: flex-start;
	padding-left: 10px;
	width: 80%;
}
.kisiler form .kisi {
	font-size: 1.20em;
	background: white;
	margin-top: 5px;
	border:0;
	color: white;
	background: #263238;
}
.kisiler form .kisi:hover {
	cursor: pointer;
}




.mesaj {
	width: 60%;
	height: 630px;
	margin-top: 3%;
	display: flex;
	flex-direction: column;
	align-items: center;
	background: #37474F;
}
.ad {
	background: #37474F;
	display: flex;
	align-items: center;
	font-size: 1.3em;
	width: 100%;
	height: 80px;
	padding-left: 30px;
	padding-right: 30px;
	box-sizing: border-box;
	color: white;
	font-size: 2em;
}
.mesajlar {
	width: 99.5%;
	height: 375px;
	box-sizing: border-box;
	padding: 30px;
	display: flex;
	flex-direction: column;
	overflow-y: scroll;
	background: white;
}


.ymesaj {
	padding: 5px;
	background: blue;
	border-radius: 10px;
	display: flex;
	flex-direction: column;
	width: 130px;
	overflow-wrap: break-word;
	margin-bottom: 10px;
	color: white;
}
.gmesaj {
	padding: 5px;
	background: #546E7A;
	border-radius: 10px;			
	display: flex;
	flex-direction: column;
	width: 130px;
	overflow-wrap: break-word;
	margin-bottom: 10px;
	color: white;
	margin-left: auto;
}
.zaman {
    font-size: 0.7em; 
    color: gainsboro;
    margin-left: auto;
    margin-top: auto;
}
.gmesaj-form {
	display: flex;
	flex-direction: column;
	width: 80%;
	align-items: center;
}
.gmesaj-form .gonder {
	width: 200px;
	height: 30px;
	border-radius: 30px;
	border: 1px solid blue;
	background: white;
	margin-top: 10px;
	color: black;	
}
.gmesaj-form .gonder:hover {
	cursor: pointer;
	background: gainsboro;
}
.expanding-textarea {
    width: 120%;
    padding: 5px;
    border-radius: 10px;
    border: 2px solid #ccc;
    min-height: 100px;
    max-height: 400px;
    resize: none;
    margin-top: 10px;
}

.cikis{
	margin-left: auto;
}
.cikis input{
	background: white;
	border: 0;
	padding: 10px 25px 10px 25px;
	border-radius: 10px;
	color: black;
}
.cikis input:hover{
	cursor: pointer;
}
@media only screen and (max-width: 950px){
	.container{	
		margin-top: 10px;
		width: 100%;
		justify-content: flex-start;
	}
	.ben{
		font-size: 100%;
		width: 80%;
	}
	.mesaj{
		margin-top: 0;
		width: 80%;
		font-size: 0.75em;
		display: flex;
		flex-direction: column;
		align-items: center;
		height: 700px;
	}
	.kisiler{
		margin-top: 0;
		padding: 0;
	}
	.mesajlar{
		display: flex;
		flex-direction: column;
		align-items: center;
	}
	.gmesaj{
		max-width: 80%;
	}
	.ymesaj{
		margin-right: auto;
		max-width: 80%;
	}
	.kisiler{
		width: 20%;
		font-size: 0.75em;					
	}
	.kisiler form .kisi{
		font-size: 100%;
		padding-left: 10px;
		max-width: 100%;
		margin-bottom: 10px;
		
	}
	.expanding-textarea {
        width: 100%;
    }
    .kisiler form{
    	padding: 0;
    	width: 100%;
    }
}
	</style>
</head>
<body>
<?php
	date_default_timezone_set('Europe/Istanbul');
	session_start();
	include("connect.php");

	// AJAX ile mesajları çekme
	if (isset($_GET['ajax']) && $_GET['ajax'] == '1' && isset($_GET['kisi'])) {
		$mkisi = mysqli_real_escape_string($conn, $_GET['kisi']);
		$query = "SELECT mesaj, kimden, zaman FROM mesajlar 
		          WHERE (ad = '$_SESSION[ad]' AND kimden = '$mkisi') 
		          OR (ad = '$mkisi' AND kimden = '$_SESSION[ad]') 
		          ORDER BY id ASC";
		$result = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_assoc($result)) {
			if ($row['kimden'] == $_SESSION['ad']) {
				echo "<p class='gmesaj'>".$row['mesaj']." <span class='zaman'>" . date('H:i', strtotime($row['zaman'])) . "</span></p>";
			} 
			else {
				echo "<p class='ymesaj'>".$row['mesaj']." <span class='zaman'>" . date('H:i', strtotime($row['zaman'])) . "</span></p>";
			}
		}
		exit(); // Sadece mesajları döndür ve script'i sonlandır
	}

	//ÇIKIŞ İŞLEMİ
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cikis'])) {
	    session_destroy();
	    header('Location: index.php');
	    exit();
	}


	if (!$_SESSION['ad']) {
		session_destroy();
		header("location: index.php");
		exit();
	}
	
	// Mesaj gönderildiğinde veritabanına kaydetme işlemi
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	    if (isset($_POST['gonder']) && isset($_POST['mkisi'])) {
	        $mkisi = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['mkisi']));
			$gmesaj_text = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['gmesaj_text']));
 
	        $zaman = date('Y-m-d H:i:s');

			$a_result = mysqli_query($conn,"SELECT ad FROM kullanici");
			$a = mysqli_fetch_all($a_result, MYSQLI_ASSOC);
			$k = false;
			
			foreach($a as $i){
				if (strlen($gmesaj_text) > 0 && $mkisi == $i['ad']) {
					$k = true;
					break;
				}
			}
			// Mesajı veritabanına kaydet
			if($k){
				$sql = "INSERT INTO mesajlar(ad, mesaj, kimden, zaman) VALUES ('$mkisi', '$gmesaj_text', '{$_SESSION['ad']}', '$zaman')";
	
				if (mysqli_query($conn, $sql)) {
					// PRG (Post/Redirect/Get) yöntemi ile sayfayı yeniden yönlendir
					header("Location: mesaj.php?kisi=" . urlencode($mkisi));
					exit(); // Header yönlendirmesinden sonra exit ile sonlandır.
				} else {
					// Hata durumunda buraya düşer
					echo "Hata: " . mysqli_error($conn);
				}
			}
		}	       
	}

?>


<div class="container">	
	<div class="kisiler">
		<span class="ben"><?php echo $_SESSION['ad']; ?></span>
		<h3>Kişiler</h3>
		<form action="mesaj.php" method="GET">
			<?php 
				$kisiler_result = mysqli_query($conn, "SELECT DISTINCT ad FROM kullanici");
				$kisiler = mysqli_fetch_all($kisiler_result, MYSQLI_ASSOC);
				foreach ($kisiler as $kisi) {
					if (strlen($kisi['ad']) > 0) {
						if ($_SESSION['ad'] == $kisi['ad']) {
							continue;
						}
						echo "<input class='kisi' type='submit' name='kisi' value='$kisi[ad]'>";
					}				
				}
		 	?>
		</form>
	</div>

	<div class="mesaj">
		<div class="ad">
			<?php				
				// URL'den seçilen kişiyi al
				if (isset($_GET['kisi'])) {
					$mkisi = htmlspecialchars($_GET['kisi']);
					$kont = false;
					foreach($kisiler as $kisi){
						if($mkisi == $kisi['ad']){
							$kont = true;
							break;
						}
					}
					if($kont){
						echo ucfirst($mkisi);
					}
					
				}
			?>
			<div class="cikis">
				<form action="mesaj.php" method="POST">
					<input type="submit" name="cikis" value="Çıkış yap">
				</form>
			</div>
		</div>

		<div class="mesajlar">
			<?php 
				if (isset($mkisi)) {
				    $gmesaj_result = mysqli_query($conn, "SELECT mesaj, kimden, ad, zaman FROM mesajlar");
				    $gmesaj = mysqli_fetch_all($gmesaj_result, MYSQLI_ASSOC);

				    foreach ($gmesaj as $mesaj) {
				        if ($_SESSION['ad'] != $mesaj['kimden']) {
				            if ($mkisi == $mesaj['kimden'] && $_SESSION['ad'] == $mesaj['ad']) {
				                echo "<p class='ymesaj'>".$mesaj['mesaj']." <span class='zaman'>" . date('H:i', strtotime($mesaj['zaman'])) . "</span></p>";
				            }
				        } elseif ($_SESSION['ad'] == $mesaj['kimden']) {
				            if ($mkisi == $mesaj['ad']) {
				                echo "<p class='gmesaj'>".$mesaj['mesaj']." <span class='zaman'>" . date('H:i', strtotime($mesaj['zaman'])) . "</span></p>";
				            }
				        }
				    }
				}
			 ?>
		</div>

		<form class="gmesaj-form" action="mesaj.php?kisi=<?php echo isset($mkisi) ? $mkisi : ''; ?>" method="POST">
			<textarea class="expanding-textarea" placeholder="Mesajınızı girin" name="gmesaj_text"></textarea>
			<!-- Seçilen kişi bilgisi gizli alan olarak POST metoduyla iletilecek -->
			<input type="hidden" name="mkisi" value="<?php echo isset($mkisi) ? $mkisi : ''; ?>">
			<input class="gonder" type="submit" name="gonder" value="Gönder">
		</form>
	</div>
</div>

<script>
    function fetchMessages() {
        const mesajlarDiv = document.querySelector('.mesajlar');
        const mkisi = '<?php echo isset($mkisi) ? $mkisi : ''; ?>'; // Seçilen kişiyi al
        const apiUrl = 'mesaj.php?ajax=1&kisi=' + encodeURIComponent(mkisi); // Mesajları çekmek için URL

        // Fetch API ile mesajları çek
        fetch(apiUrl)
            .then(response => response.text()) // Yanıtı text olarak al
            .then(data => {
                mesajlarDiv.innerHTML = data; // Mesajlar divini yeni verilerle güncelle
            })
            .catch(error => console.error('Hata:', error));
    }

    // Her 5 saniyede bir mesajları çek
    setInterval(fetchMessages, 100);
</script>


<script>
    // Sayfa yüklendiğinde en son kaydedilen scroll konumuna git
    window.onload = function() {
        var mesajlar = document.querySelector('.mesajlar');
        mesajlar.scrollTop = mesajlar.scrollHeight; // Aşağıya kaydır
    };
</script>

</body>
</html>