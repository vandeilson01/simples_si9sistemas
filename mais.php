<?php

session_start();

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.si9sistemas.com.br/imobilsi9-api/oauth/token?grant_type=password&username=<name>&password=<password>');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);


$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: basic <token>';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

// $token = '';
// foreach($result as $row){
// $tolken = $access_token['access_token'];
// }

$jsonDecode = json_decode($result, true);

// echo $result;
$inicio = strpos($result,'{"access_token":"'); 
$final = strpos($result,'","refresh_token":"'); 
 
$results = substr($result, $inicio, $final);
$token = str_replace('{"access_token":"', '',$results);

$_SESSION['token'] = $token;

//echo $result;
curl_close($ch);

echo $_SESSION['token'];
$token = $_SESSION['token'];



?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>API</title>
  </head>
  <body>

<div class="container">
    <div class="row">
        <section class="" id="b"></section>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
var token = "<?php echo $token;?>";
$.ajax( {
    url: 'https://api.si9sistemas.com.br/imobilsi9-api/property',
    type: 'GET',
    beforeSend : function( xhr ) {
        xhr.setRequestHeader( "Authorization", "Bearer <?php echo $token;?>" );
    },
    success: function( response ) {
        // console.log(response[0]);
     
        
        var mais;
        $('section').append('<div class="b"><div class="added"></div><div class="local"></div><div class="value"></div></div>');
        for(let index = 0; index < response.length; index++){
            let arr = [response[index].images];
        
            mais += load(response[index]);
        
        }

        $("section").empty();
        $("section").append(mais);
       

    
    },
    error: function( response ) {
        console.log(response[0]);
    }
});


function load(data) {

    var line = '<div class="col" ><div class="card" > <div class="card-body">' +
        '<p class="card-title">' + data.id + '</p>' +
        '<p class="card-title">' + data.location.address + '</p>' +
        '<p class="card-title">' + data.values.saleValue + '</p></div>';


    line += '<div id="carouselExampleControls'+data.id+'" class="carousel slide" data-bs-ride="carousel"><div class="carousel-inner">';

    for(let i = 0; i < data.images.length; i++){
        
        line += '<div style="height: 190px;background-repeat: no-repeat;background-size: cover;background-image: url('+data.images[i].url+')" class="w-100 carousel-item active"></div>';
    
    }  
    
    line +='</div><button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls'+data.id+'" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button><button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls'+data.id+'" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>';

    line +='</div>';

    line += 
    '<p><button id="' + data.id + '" class="btn btn-success btn-atender"><a href="mais2.php?q='+data.id+'">Obter</a></button></p>' +
    '</div></div>';

     return line;

 }


 var myCarousel = document.querySelector('#carouselExampleControls8')
var carousel = new bootstrap.Carousel(myCarousel, {
  interval: 2000,
  wrap: false
})
</script>

  </body>
</html>