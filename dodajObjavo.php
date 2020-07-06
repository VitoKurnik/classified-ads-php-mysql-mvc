<?php
error_reporting(0);
$conn = new mysqli('localhost', 'root', '', 'vaja2');
$conn->set_charset("UTF8");
session_start();
if(isset($_POST["poslji"])){
            if($_POST["title"] == "" || $_POST["description"] == "" || $_FILES["image"] == "" || $_POST["kategorija"] == ""){
                $error = "Polja ne smejo biti prazna.";
            }
        	else if(publish($_POST["title"], $_POST["description"], $_FILES["image"], $_POST["kategorija"])){
        		header("location:index.php");
        		die();
        	}
        	else{
        		$error = "Prišlo je do našpake pri objavi oglasa.";
        	}
        }
echo "
<head>
<link rel='stylesheet' type='text/css' href='stylexmp4.css'>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
</head>";

function publish($title, $desc, $img, $kategorija){
	global $conn;
	$title = mysqli_real_escape_string($conn, $title);
	$desc = mysqli_real_escape_string($conn, $desc);
	$user_id = $_SESSION["USER_ID"];

    $img_file = file_get_contents($img["tmp_name"]);
    $img_file = mysqli_real_escape_string($conn, $img_file);

	$datum = date("Y/m/d h:i:sa");
	$datum = mysqli_real_escape_string($conn, $datum);
	$kategorija = mysqli_real_escape_string($conn, $kategorija);

    $datum_zap = date('Y-m-d H:i:s', strtotime($datum . ' +30 day'));
	$query = "INSERT INTO objave (naslov, opis, user_id, slika, datum, datum_zapadlosti, kategorija)
				VALUES('$title', '$desc', '$user_id', '$img_file', '$datum', '$datum_zap', '$kategorija')";
	if($conn->query($query)){
		return true;
	}
	else{
		return false;
	}

	/*
	//Pravilneje bi bilo, da sliko shranimo na disk. Poskrbeti moramo, da so imena slik enolična. V bazo shranimo pot do slike.

		$imeSlike=$photo["name"]; //Pazimo, da je enolično!
		//sliko premaknemo iz začasne poti, v neko našo mapo, zaradi preglednosti
		move_uploaded_file($photo["tmp_name"], "slika/".$imeSlike);
		$pot="slika/".$imeSlike;
		//V bazo shranimo $pot
	*/
}

if(isset($_SESSION["USER"])){
	if((time() - $_SESSION['timeout']) > 1800){
		header("location:odjava.php");
	}
	else{
		$_SESSION['timeout'] = time();
	}
	echo "<div class='naslov'><h1>Novice</h1> <h4>Pozdravljen " . $_SESSION["USER"] . "! <a id=login href='odjava.php'>Odjavi</a></h4></div>";

	echo "<form action='dodajObjavo.php' method='POST' enctype='multipart/form-data'>
             		<label>Naslov</label><input type='text' name='title' /> <br/>
             		<label>Vsebina</label><textarea name='description' rows='10' cols='50'></textarea> <br/>
             		<label>Slika</label><input type='file' name='image' accept='.png,.jpg' /> <br/>
             		<label>Kategorija</label>
             		            <input type='radio' id='Računalništvo' name='kategorija' value='Računalništvo'>
                                <label for='Računalništvo'>Računalništvo</label>
                                <input type='radio' id='Fotografija' name='kategorija' value='Fotografija'>
                                <label for='Fotografija'>Fotografija</label>
                                <input type='radio' id='Šport' name='kategorija' value='Šport'>
                                <label for='Šport'>Šport</label><br>
             		<input type='submit' name='poslji' value='Objavi' /> <br/>
             		<label> $error</label>
             	</form>";

    $error = "";


	echo "<br/><div class='gumbnaz'><a id='gumbn' href='index.php'>Nazaj</a></div>";
}
else{
	echo "<div class='naslov'><h2>ČE ŽELITE DODATI OBJAVO, SE <a id='login' href='prijava.php'>PRIJAVITE</a></h2></div>";
}
?>
<!DOCTYPE html>
<html>
<body>

</body>
</html>
