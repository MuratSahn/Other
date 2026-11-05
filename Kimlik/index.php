<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        html{
            background-color: #212121;
        }
        p{
            margin:0;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 95vh;
            font-family: sans-serif;
        }
        .kart{
            width: 350px;
            height: 200px;
            border-radius: 10px;
            display:grid;
            grid-template-rows: 40px 1fr;
            background-color: white;
            box-shadow:0px 0px 15px lightblue;
        }

        .kart .ust{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .kart .alt{
            display:grid;
            grid-template-columns: 4fr 4fr 5fr;
        }

        .kart .alt .sol{
            display: flex;
            flex-direction: column;
            
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="kart">
        <div class="ust">
            <p style="font-size:18px;">Türkiye Cumhuriyeti Kimlik Kartı</p>
            <p style="font-size:9.7px;">REPUBLİC OF TURKEY IDENTITY CARD</p>
        </div>
        <div class="alt">
            <div class="sol">
                <p style="font-size:7px; margin-top:5spx">T.C. Kimlik No / TR Identity No</p>
                <p style="margin-top:2px; font-size:13px;" id="tc"></p>
                <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center" class="resim" id="resim">
                    
                </div>
            </div>
            <div class="orta">
                <p style="font-size:7px; margin-top:30px;">Soyadı / Surname</p>
                <p id="soyad" style="font-size:11px; padding-bottom:5px;"></p>

                <p style="font-size:7px;">Adı / Given Name(s)</p>
                <p id="ad" style="font-size:11px; padding-bottom:5px;"></p>

                <p style="font-size:7px;">Doğum Tarihi / Date Of Birth</p>
                <p id="dogum" style="font-size:11px; padding-bottom:5px;"></p>

                <p style="font-size:7px;">Seri No / Document No</p>
                <p id="seri" style="font-size:11px; padding-bottom:5px;"></p>

                <p style="font-size:7px;">Son Geçerlilik Tarihi / Valid Until</p>
                <p id="gecerlilik" style="font-size:11px; padding-bottom:5px;"></p>
            </div>
            <div style="display:flex; flex-direction:column;" class="sag">
                <img src="resimler/ayyildiz.png" style="width:80px; height:58px; margin-left:25px;">
                <div style="width:100x%; height:100%; display:flex; flex-direction:row;">
                    <div style="width:50%; height:100%;">
                        <p style="font-size:7px; margin-top:23px;">Cinsiyeti / Gender</p>
                        <p id="cinsiyet" style="font-size:11px; padding-bottom:5px;"></p>

                        <p style="font-size:7px;">Uyruğu / Nationality</p>
                        <p style="font-size:11px; padding-bottom:5px;">T.C./TUR</p>

                        <p style="font-size:7px;">imzası / Signature</p>
                    </div>
                    <div id="s" style="width:50%; height:100%;"></div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        let tcno = document.getElementById('tc');
        let soyad = document.getElementById('soyad');
        let ad = document.getElementById('ad');
        let dogum = document.getElementById('dogum');
        let cinsiyet = document.getElementById('cinsiyet');
        let seri = document.getElementById('seri');
        let gecerlilik = document.getElementById('gecerlilik');

        let Sad = ["Yılmaz","Şahin","Altın","Kırlı","Güçlü","Hazır","Demir","Çoban","Kara","Terzi","Arslan","Yalçın"];
        let isim = [
            ["Ali","İsmet","Mustafa","Mehmet","Ramazan","Yusuf","Mert"],
            ["Ayşe","Merve","Aslı","Feyza","Hatice","Berna","Beril"]
        ];
        let cinsiyetrast = Math.floor(Math.random()*2);
        
        let gun = Math.floor(Math.random() * 31) + 1;
        let ay = Math.floor(Math.random() * 12) + 1;
        let yil = Math.floor(Math.random() * 16) + 1990;

        let tarih = gun + "." + ay + "." + yil;

        let tc = function(no){
            if(no.length != 11 || no[0] == "0") return false;

            let tek = parseInt(no[0]) + parseInt(no[2]) + parseInt(no[4]) + parseInt(no[6]) + parseInt(no[8]);

            let cift = parseInt(no[1]) + parseInt(no[3]) + parseInt(no[5]) + parseInt(no[7]);

            if((tek*7-cift)%10 != no[9]) return false;

            let sonuc = 0;
            for(let i=0; i<10; i++){
                sonuc += parseInt(no[i]);
            }

            if(sonuc%10 != no[10]) return false;

            let hatali = ["11111111110", "22222222220", "33333333330", "44444444440", "55555555550", "66666666660", "7777777770", "88888888880", "99999999990"];

            for(let i=0; i<hatali.length; i++){
                if(no == hatali[i]) return false;
            }

            return true;
        }
        
        let interval = setInterval(function(){
            let rand = Math.floor(Math.random() * 90000000000) + 10000000000;
            if(tc(rand.toString())){
                tcno.innerHTML = rand;
                clearInterval(interval);
            }
        },1);

        soyad.innerHTML = Sad[Math.floor(Math.random()*12)];

        ad.innerHTML = isim[cinsiyetrast][Math.floor(Math.random()*6)];

        dogum.innerHTML = tarih;

        if(cinsiyetrast == 0){
            cinsiyet.innerHTML = "E / M";
        }
        else{
            cinsiyet.innerHTML = "E / F";
        }

        seri.innerHTML = "A"+ (Math.floor(Math.random()*90)+10) + "I" + (Math.floor(Math.random() * 90000) + 10000)

        gecerlilik.innerHTML = (Math.floor(Math.random() * 31) + 1) + "." + (Math.floor(Math.random() * 12) + 1) + "." + (Math.floor(Math.random() * 15) + 2030);
        
        if(cinsiyetrast == 0){
            document.getElementById('resim').innerHTML = '<img style="width:80px; height:100px" src="resimler/pp.jpg">';
            document.getElementById('s').innerHTML = '<img src="resimler/pp.jpg" style="width:55px; height:50px;">';
        }
        else{
            document.getElementById('resim').innerHTML = '<img style="width:80px; height:100px" src="resimler/kadın.jpeg">';
            document.getElementById('s').innerHTML = '<img src="resimler/kadın.jpeg" style="width:55px; height:50px;">';
        }
        document.getElementById('s').innerHTML += '<span style="margin-top:13px; margin-left:13px; display:inline-block;">asd</span>';
    </script>
</body>
</html>