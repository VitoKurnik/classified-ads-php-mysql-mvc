<?php
//http://localhost/novica.php?id=5
	//include_once "baza.php";
	$conn = new mysqli('localhost', 'root', '', 'vaja2');
    $conn->set_charset("UTF8");
	session_start();

	if(isset($_SESSION["USER"])){
		if((time() - $_SESSION['timeout']) > 1800){
			header("location:odjava.php");
		}
		else{
			$_SESSION['timeout'] = time();
		}
		global $conn;
        $id = $_GET["id"];
        $id = mysqli_real_escape_string($conn, $id);
        $query2 = "SELECT * FROM objave WHERE id = '$id'";
        $res2 = $conn->query($query2);
        $objave = array();
        while($objava = $res2->fetch_object()){
            array_push($objave, $objava);
        }
        $novDate = date('Y-m-d H:i:s', strtotime($objave[0]->datum_zapadlosti . ' +30 day'));
        $query = "UPDATE objave SET datum_zapadlosti = '$novDate' WHERE id='$id'";
        $res = $conn->query($query);
		header("location:pregledObjav.php");
	}
	else{
		echo "<div class='naslov'><h1>Oglasi</h1> <h4> <a id='login' href='registracija.php'>Registracija</a><a id='login' href='prijava.php'>Prijavi se!</a></h4></div>";
	}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylexmp4.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>

</body>
</html>
