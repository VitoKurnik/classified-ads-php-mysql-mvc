<?php
//include_once "baza.php";
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
        		$error = "Prišlo je do našpake pri spremembi oglasa.";
        	}
        }
echo "
<head>
<link rel='stylesheet' type='text/css' href='stylexmp.css'>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
</head>";

function get_oglasi(){
    	global $conn;
    	$id = $_GET["id"];
    	$query2 = "SELECT * FROM objave WHERE id = '$id'";
    	$res2 = $conn->query($query2);
    	$oglasi2 = array();
    	while($oglas2 = $res2->fetch_object()){
    		array_push($oglasi2, $oglas2);
    	}
    	return $oglasi2;
    }

function publish($title, $desc, $img, $kategorija){
	global $conn;
	$title = mysqli_real_escape_string($conn, $title);
	$desc = mysqli_real_escape_string($conn, $desc);
	//$user_id = $_SESSION["USER_ID"];

	//$img_file = file_get_contents($img["tmp_name"]);
	//$img_file = mysqli_real_escape_string($conn, $img_file);

	//$kategorija = mysqli_real_escape_string($conn, $kategorija);

    $id2 = $_GET["id"];
    $id2 = mysqli_real_escape_string($conn, $id2);
	$query = "UPDATE objave SET naziv = 'dsadas' WHERE id='$id2'";
	if($conn->query($query)){
		return true;
	}
	else{
		return false;
	}
}

if(isset($_SESSION["USER"])){
	if((time() - $_SESSION['timeout']) > 1800){
		header("location:odjava.php");
	}
	else{
		$_SESSION['timeout'] = time();
	}
	echo "<div class='naslov'><h1>Novice</h1> <h4>Pozdravljen " . $_SESSION["USER"] . "! <a id=login href='odjava.php'>Odjavi</a></h4></div>";

	global $conn;
    $objava = get_oglasi();
    $objava_naslov = $objava[0]->naslov; $objava_desc = $objava[0]->opis; $objava_slika = base64_encode($objava[0]->slika); $objava_kategorija = $objava[0]->kategorija;

	echo "<form action='spremeniObjavo.php' method='POST' enctype='multipart/form-data'>
             		<label>Naslov</label><input type='text' value='$objava_naslov' name='title' /> <br/>
             		<label>Vsebina</label><textarea name='description' rows='10' cols='50'>$objava_desc</textarea> <br/>
             		<label>Slika</label><input type='file' name='image' value='$objava_slika' accept='.png,.jpg' /> <br/>
             		<label>Kategorija</label>
             		            <input type='radio' id='Računalništvo' name='kategorija' value='Računalništvo'>
                                <label for='Računalništvo'>Računalništvo</label>
                                <input type='radio' id='Fotografija' name='kategorija' value='Fotografija'>
                                <label for='Fotografija'>Fotografija</label>
                                <input type='radio' id='Šport' name='kategorija' value='Šport'>
                                <label for='Šport'>Šport</label><br>
             		<input type='submit' name='poslji' value='Spremeni' /> <br/>
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
