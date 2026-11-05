//Değişken oluşturma var/let/const(sabit) var global scope let ve const block scope

var a = "asd";
var xx,yy,zz;

//Dizi oluşturma
var b = [1,2,3];

//fonksiyon
function x(c){
    return c;
}

//arrow fonksiyon
const y = (d,e) => d+e;

//obje oluşturma
var araba = {
    marka: "Opel",
    model: "Corsa"
};

//alert() prompt() confirm()

//Dom manipülasyonu
document.getElementById("baslik").innerText = "Yeni";
//document.getElementsByClassName("baslik").innerText = "Yeni"
//document.querySelector("baslik").innerText = "asd";

//Event(Olaylar)
document.getElementById("buton").addEventListener("click", function(){
    alert("Butona bastınız");
});

//Zamanlama
/*setTimeout(function(){
    alert("Bu mesaj 2 saniye sonra gelid");
}, 2000);*/
/*let IntervalId = setInterval(function(){
    alert("Her saniye mesaj");
},1000);*/

//Hata yönetimi
try {
    var x = asd + 5;
} 
catch (error) {
    console.log("Hata: " + error.message);
}

//AJAX ve Fetch API
fetch("https://jsonplaceholder.typicode.com/posts")
.then(response => response.json())
.then(data => alert(data))
.catch(error => console.error("Hata: ",error));


