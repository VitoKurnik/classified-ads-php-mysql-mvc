<?php
error_reporting(0);
$conn = new mysqli('localhost', 'root', '', 'vaja2');
$conn->set_charset("UTF8");
session_start();
update_oglas();
echo "
<head>
<link rel='stylesheet' type='text/css' href='stylexmp4.css'>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
</head>";

function update_oglas(){
    global $conn;
    $id = $_GET["id"];
    $query = "UPDATE objave SET st_ogledov = st_ogledov+1 WHERE id = '$id'";
    $res = $conn->query($query);
}

function get_oglasi(){
    global $conn;
    $query = "SELECT * FROM objave";
    $res = $conn->query($query);
    $oglasi = array();
    while($oglas = $res->fetch_object()){
    	array_push($oglasi, $oglas);
    }
    return $oglasi;
}

function get_user(){
    global $conn;
    $query = "SELECT * FROM user;";
    $res = $conn->query($query);
    $oglasi = array();
    while($oglas = $res->fetch_object()){
        array_push($oglasi, $oglas);
    }
    return $oglasi;
}

function najdi_avtorja($users, $user_id){
    foreach($users as $user){
        if($user->id == $user_id){
            $najden[0] = $user->username;
            $najden[1] = $user->email;
        }
    }
    return $najden;
}

if(isset($_SESSION["USER"])){
	if((time() - $_SESSION['timeout']) > 1800){
		header("location:odjava.php");
	}
	else{
		$_SESSION['timeout'] = time();
        echo "<div class='naslov'><h1>Oglasi</h1> <h4>Pozdravljen " . $_SESSION["USER"] . "! <a id=login href='odjava.php'>Odjavi</a></h4></div>";
	}
}
else{
    echo "<div class='naslov'><h1>Oglasi</h1> <h4> <a id='login' href='registracija.php'>Registracija</a><a id='login' href='prijava.php'>Prijavi se!</a></h4></div>";
}
$novice = get_oglasi();
	$users = get_user();
	$img_data = base64_encode($novice->image);
	for($i=0;$i<count($novice);$i++){
	    if($novice[$i]->id==$_GET["id"]){
	        $najdi = najdi_avtorja($users, $novice[$i]->user_id);
	        echo "<div class='vsebin'><p><b>" . $novice[$i]->naslov. "</b></p><p>" . $novice[$i]->opis . "</p><p>" . "<img src='data:image/jpg;base64," . base64_encode($novice[$i]->slika) ."' width='400'/>" . "</p><p>Kategorija: " . $novice[$i]->kategorija . "</p><p>Mail: " . $najdi[1] . "</p><p class='objavil'>Objavil " . $najdi[0] . ", " . $novice[$i]->datum . "</p><p class='objavil'>Datum zapadlosti " . $novice[$i]->datum_zapadlosti . "</p></div>";
	    }
	}
	echo "<br/><div class='gumbnaz'><a id='gumbn' href='index.php'>Nazaj</a><a id='gumbn' href='pregledObjav.php'>Nazaj na moje oglase</a></div>";
?>
<!DOCTYPE html>
<html>
<body>
</body>
</html>
