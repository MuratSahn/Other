<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<form action="new.php" method="POST" enctype="multipart/form-data">
		<input type="file" name="file">
		<input type="submit">
	</form>
	<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			if(isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK){
				if($_FILES['file']['type'] == 'image/jpeg'){
					if($_FILES['file']['size'] <= 1024*1024){
						$name = $_FILES['file']['name'];

						$ad = ['nl','av','kx','lp'];
						$sayi = rand(0,10000);
						$uzanti = substr($name, -5, 5);

						$newname = __DIR__."/img/".$ad[rand(0,3)].$sayi.$uzanti;

						if(move_uploaded_file($_FILES['file']['tmp_name'], $newname)){
							session_start();
							$_SESSION['message'] = $newname . " Başarılı";
							header("location:new.php");
							exit();
						}
						else{
							session_start();
							$_SESSION['message'] = "Başarısız";
							header("location:new.php");
							exit();
						}
					}
					else{
						session_start();
							$_SESSION['message'] = "Dosya 1 Mb olmalıdır";
							header("location:new.php");
							exit();
					}
				}
				else{
					session_start();
					$_SESSION['message'] = "Dosya jpeg uzantılı olmalıdır";
					header("location:new.php");
					exit();
				}
			}
		}
		session_start();
		if(isset($_SESSION['message'])){
			echo $_SESSION['message'];
			unset($_SESSION['message']);
		}
	?>

	<button onclick="alert('adsd')">Naber</button>
	<p id="a"></p>

	
	<script>
		let araba = {
			isim:"ali",
			soyisim:"şensikiş",

			isimsoyisim:function(){
				alert(isim + " " + soyisim);
			}
		};
		var a,b,c;
		//Yazı yazdırma
		document.getElementById("a").innerHTML = "ASd";
		document.write("asd");
	</script>
</body>
</html>