<?php
error_reporting(0);
	$conn = new mysqli('localhost', 'root', '', 'vaja2');
    $conn->set_charset("UTF8");
	session_start();

	function get_oglasi(){
    	global $conn;
    	$query = "SELECT * FROM objave ORDER BY datum_zapadlosti DESC";
    	$res = $conn->query($query);
    	$oglasi = array();
    	while($oglas = $res->fetch_object()){
    		array_push($oglasi, $oglas);
    	}
    	return $oglasi;
    }
    function get_oglasi_isci($niz){
        global $conn;
        $query = "SELECT * FROM objave WHERE naslov LIKE '%$niz%' OR opis LIKE '%$niz%' ORDER BY datum_zapadlosti DESC";
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
        $useri = array();
        while($user = $res->fetch_object()){
            array_push($useri, $user);
        }
        return $useri;
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
		$usr_id=$_SESSION["USER_ID"];
		echo "<div class='naslov'><h1>Oglasi</h1> <h4>Pozdravljen " . $_SESSION["USER"] . "! <a id='login' href='panel.php'>Profil</a><a id=login href='odjava.php'>Odjava</a></h4></div>";
	}
	else{
		echo "<div class='naslov'><h1>Oglasnik</h1> <h4> <a id='login' href='registracija.php'>Registracija</a><a id='login' href='prijava.php'>Prijava</a></h4></div>";
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
    $novice = get_oglasi();
    if(isset($_POST["isci"])){
        $novice = get_oglasi_isci($_POST["searchbar"]);
    }
    $users = get_user();

	echo "<div class='dodajOglas'><p><a href='dodajObjavo.php'><button class='dodajObjavo'>Dodaj objavo</button></a> <a href='pregledObjav.php'><button class='dodajObjavo'>Pregled objav</button></a></p>
	<p>Kategorije: <form action='index.php' method='POST' enctype='multipart/form-data'></p>
	<p><input type='checkbox' id='Računalništvo' name='Računalništvo' value='Računalništvo'><label for='Računalništvo'>Računalništvo</label></p>
    <p><input type='checkbox' id='Fotografija' name='Fotografija' value='Fotografija'><label for='Fotografija'>Fotografija</label></p>
	<p><input type='checkbox' id='Šport' name='Šport' value='Šport'><label for='Šport'>Šport</label></p>
	<p><input type='submit' name='potrdi' value='Potrdi'></p></form>
	<form action='index.php' method='POST' enctype='multipart/form-data'>
	<p><input type='text' id='searchbar' name='searchbar'>
    <input type='submit' name='isci' value='Išči'></p></div>";

	foreach($novice as $novica){
        if(isset($_POST["potrdi"])){
            if($_POST["Šport"] == "" && $_POST["Fotografija"] == "" && $_POST["Računalništvo"] == "")
            {
                $najdi = najdi_avtorja($users, $novica->user_id);
                echo "<div class='vsebin'><p><b>" . $novica->naslov. "</b></p><p>" . $novica->opis . "</p><p class='objavil'><p>Kategorija: " . $novica->kategorija . "</p><p>Objavil " . $najdi . ", " . $novica->datum . "</p><p class='objavil'>Datum zapadlosti " . $novica->datum_zapadlosti . "<div id='gumb'>Število ogledov:" . $novica->st_ogledov . " <a id='gumb' href='novica.php?id=" . $novica->id . "'>Preberi</a></div></p></div>";
            }
            elseif($_POST["Šport"] != "" && $novica->kategorija == $_POST["Šport"]){
                $najdi = najdi_avtorja($users, $novica->user_id);
                echo "<div class='vsebin'><p><b>" . $novica->naslov. "</b></p><p>" . $novica->opis . "</p><p class='objavil'><p>Kategorija: " . $novica->kategorija . "</p><p>Objavil " . $najdi . ", " . $novica->datum . "</p><p class='objavil'>Datum zapadlosti " . $novica->datum_zapadlosti . "<div id='gumb'>Število ogledov:" . $novica->st_ogledov . " <a id='gumb' href='novica.php?id=" . $novica->id . "'>Preberi</a></div></p></div>";
            }
            elseif($_POST["Fotografija"] != "" && $novica->kategorija == $_POST["Fotografija"]){
                $najdi = najdi_avtorja($users, $novica->user_id);
                echo "<div class='vsebin'><p><b>" . $novica->naslov. "</b></p><p>" . $novica->opis . "</p><p class='objavil'><p>Kategorija: " . $novica->kategorija . "</p><p>Objavil " . $najdi . ", " . $novica->datum . "</p><p class='objavil'>Datum zapadlosti " . $novica->datum_zapadlosti . "<div id='gumb'>Število ogledov:" . $novica->st_ogledov . " <a id='gumb' href='novica.php?id=" . $novica->id . "'>Preberi</a></div></p></div>";
            }
            elseif($_POST["Računalništvo"] != "" && $novica->kategorija == $_POST["Računalništvo"]){
                $najdi = najdi_avtorja($users, $novica->user_id);
                echo "<div class='vsebin'><p><b>" . $novica->naslov. "</b></p><p>" . $novica->opis . "</p><p class='objavil'><p>Kategorija: " . $novica->kategorija . "</p><p>Objavil " . $najdi . ", " . $novica->datum . "</p><p class='objavil'>Datum zapadlosti " . $novica->datum_zapadlosti . "<div id='gumb'>Število ogledov:" . $novica->st_ogledov . " <a id='gumb' href='novica.php?id=" . $novica->id . "'>Preberi</a></div></p></div>";
            }
        }
        else{
            if(isset($_POST["isci"])){
                $najdi = najdi_avtorja($users, $novica->user_id);
                echo "<div class='vsebin'><p><b>" . $novica->naslov. "</b></p><p>" . $novica->opis . "</p><p class='objavil'><p>Kategorija: " . $novica->kategorija . "</p><p>Objavil " . $najdi . ", " . $novica->datum . "</p><p class='objavil'>Datum zapadlosti " . $novica->datum_zapadlosti . "<div id='gumb'>Število ogledov:" . $novica->st_ogledov . " <a id='gumb' href='novica.php?id=" . $novica->id . "'>Preberi</a></div></p></div>";
            }
            else{
                $najdi = najdi_avtorja($users, $novica->user_id);
                echo "<div class='vsebin'><p><b>" . $novica->naslov. "</b></p><p>" . $novica->opis . "</p><p class='objavil'><p>Kategorija: " . $novica->kategorija . "</p><p>Objavil " . $najdi . ", " . $novica->datum . "</p><p class='objavil'>Datum zapadlosti " . $novica->datum_zapadlosti . "<div id='gumb'>Število ogledov:" . $novica->st_ogledov . " <a id='gumb' href='novica.php?id=" . $novica->id . "'>Preberi</a></div></p></div>";
            }
        }
	}
?>

</body>
</html>
