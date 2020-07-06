<?php
error_reporting(0);
	$conn = new mysqli('localhost', 'root', '', 'vaja2');
    $conn->set_charset("UTF8");
	session_start();

	function get_oglasi(){
    	global $conn;
    	$iskanid = $_SESSION["USER_ID"];
    	$query = "SELECT * FROM objave WHERE user_id='$iskanid' ORDER BY datum";
    	$res = $conn->query($query);
    	$oglasi = array();
    	while($oglas = $res->fetch_object()){
    		array_push($oglasi, $oglas);
    	}
    	return $oglasi;
    }

    function get_user(){
        global $conn;
        $query = "SELECT * FROM user";
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
                $najden = $user->username;
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
		}
		echo "<div class='naslov'><h1>Moji oglasi</h1> <h4>Pozdravljen " . $_SESSION["USER"] . "! <a id=login href='odjava.php'>Odjavi</a></h4></div>";
	}
	else{
		echo "<div class='naslov'><h1>Moji oglasi</h1> <h4> <a id='login' href='registracija.php'>Registracija</a><a id='login' href='prijava.php'>Prijavi se!</a></h4></div>";
	}

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylexmp4.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
	echo "<div class='dodajOglas'><p><a href='dodajObjavo.php'><button class='dodajObjavo'>Dodaj objavo</button></a> <a href='index.php'><button class='dodajObjavo'>Nazaj</button></a>
	<form action='pregledObjav.php' method='POST' enctype='multipart/form-data'><input type='checkbox' id='sort' name='sort' value='sort'><label for='sort'>Prikaži zapadle oglase</label> <input type='submit' name='potrdi' value='Potrdi'></form></p></div>";
    if(isset($_POST["potrdi"])){
        if($_POST["sort"] == ""){
            $novice = get_oglasi();
            $users = get_user();
            foreach($novice as $novica){
                if(date("Y-m-d h:i:sa") < $novica->datum_zapadlosti){
                	$najdi = najdi_avtorja($users, $novica->user_id);
                    echo "<div class='vsebin'><p><b>" . $novica->naslov. "</b></p><p>" . $novica->opis . "</p><p class='objavil'><p>Kategorija: " . $novica->kategorija . "</p><p class='objavil'>Objavil " . $najdi . ", " . $novica->datum . "</p><p class='objavil'>Datum zapadlosti " . $novica->datum_zapadlosti . "<div id='pregled_gumbi'><a id='gumb' href='zbrisi.php?id=" . $novica->id . "'>Odstrani</a> <a id='gumb' href='novica.php?id=" . $novica->id . "'>Preberi</a> <a id='gumb' href='podaljsaj.php?id=" . $novica->id . "'>Podaljšaj</a><a id='gumb' href='spremeniObjavo.php?id=" . $novica->id . "'>Spremeni</a></div></p></div>";
                }
            }
        }
        else{
            $novice = get_oglasi();
                $users = get_user();
                foreach($novice as $novica){
                $najdi = najdi_avtorja($users, $novica->user_id);
                echo "<div class='vsebin'><p><b>" . $novica->naslov. "</b></p><p>" . $novica->opis . "</p><p class='objavil'><p>Kategorija: " . $novica->kategorija . "</p><p class='objavil'>Objavil " . $najdi . ", " . $novica->datum . "</p><p class='objavil'>Datum zapadlosti " . $novica->datum_zapadlosti . "<div id='pregled_gumbi'><a id='gumb' href='zbrisi.php?id=" . $novica->id . "'>Odstrani</a> <a id='gumb' href='novica.php?id=" . $novica->id . "'>Preberi</a> <a id='gumb' href='podaljsaj.php?id=" . $novica->id . "'>Podaljšaj</a><a id='gumb' href='spremeniObjavo.php?id=" . $novica->id . "'>Spremeni</a></div></p></div>";
            }
        }
    }
?>

</body>
</html>
